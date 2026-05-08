<?php
include '../auth/auth_check.php';
include '../config/db.php';

$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id=$user_id"));
$total_books = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM books"))['c'];
$my_borrows  = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM borrows WHERE status='borrowed'"))['c']??0;
$total_added = $total_books;

$msg = '';
if(isset($_POST['update_profile'])){
  $uname = mysqli_real_escape_string($conn,$_POST['username']);
  $email = mysqli_real_escape_string($conn,$_POST['email']);
  mysqli_query($conn,"UPDATE users SET username='$uname',email='$email' WHERE id=$user_id");
  $_SESSION['username'] = $uname;
  $msg = 'Profile updated!';
  $user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id=$user_id"));
}
if(isset($_POST['change_password'])){
  $old = $_POST['old_password'];
  $new = $_POST['new_password'];
  if(password_verify($old,$user['password'])){
    $hash = password_hash($new,PASSWORD_DEFAULT);
    mysqli_query($conn,"UPDATE users SET password='$hash' WHERE id=$user_id");
    $msg = 'Password changed!';
  } else { $msg = 'error:Incorrect current password'; }
}
$pageTitle='My Profile'; $pageSubtitle='Manage your account'; $prefix='../';
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Profile — libroCore</title>
<?php include '../includes/theme.php'; ?>
<link rel="stylesheet" href="../assets/style.css">
</head><body>
<div class="dashboard">
<?php include '../includes/sidebar.php'; ?>
<div class="main-content">
<?php include '../includes/topbar.php'; ?>
<div class="page-body">

<?php if($msg && !str_starts_with($msg,'error:')): ?>
  <div class="alert alert-success">✓ <?=$msg?></div>
<?php elseif(str_starts_with($msg??'','error:')): ?>
  <div class="alert alert-error">⚠ <?=substr($msg,6)?></div>
<?php endif; ?>

<!-- Profile Hero -->
<div class="profile-hero">
  <div class="user-avatar-lg"><?=strtoupper(substr($user['username'],0,1))?></div>
  <div class="profile-info">
    <h2><?=htmlspecialchars($user['username'])?></h2>
    <p><?=htmlspecialchars($user['email'])?></p>
    <div class="profile-stats-row">
      <div class="ps-item"><div class="ps-val"><?=$total_books?></div><div class="ps-lbl">Books</div></div>
      <div class="ps-item"><div class="ps-val"><?=$my_borrows?></div><div class="ps-lbl">Borrowed</div></div>
      <div class="ps-item"><div class="ps-val"><?=date('Y',strtotime($user['created_at']??'now'))?></div><div class="ps-lbl">Member since</div></div>
    </div>
  </div>
</div>

<div class="content-grid">

  <!-- Edit Profile -->
  <div class="card">
    <div class="card-header"><h3>Edit Profile</h3></div>
    <div class="card-body">
      <form method="POST">
        <div class="input-group">
          <label>Username</label>
          <input type="text" name="username" value="<?=htmlspecialchars($user['username'])?>" required>
        </div>
        <div class="input-group">
          <label>Email Address</label>
          <input type="email" name="email" value="<?=htmlspecialchars($user['email'])?>" required>
        </div>
        <button type="submit" name="update_profile" class="btn">Save Changes</button>
      </form>
    </div>
  </div>

  <!-- Change Password -->
  <div class="card">
    <div class="card-header"><h3>Change Password</h3></div>
    <div class="card-body">
      <form method="POST">
        <div class="input-group">
          <label>Current Password</label>
          <input type="password" name="old_password" placeholder="••••••••" required>
        </div>
        <div class="input-group">
          <label>New Password</label>
          <input type="password" name="new_password" placeholder="••••••••" required>
        </div>
        <button type="submit" name="change_password" class="btn btn-secondary">Update Password</button>
      </form>
    </div>
  </div>

</div>
</div></div></div>
<script src="../assets/theme.js"></script>
</body></html>
