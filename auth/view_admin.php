<?php
include '../config/db.php';
include '../auth/auth_check.php';
$sql = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($conn,$sql);
$pageTitle='Admin List'; $pageSubtitle='All admins in your system'; $prefix='../';
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>All Admins — libroCore</title>
<?php include '../includes/theme.php'; ?>
<link rel="stylesheet" href="../assets/style.css">
</head><body>
<div class="dashboard">
<?php include '../includes/sidebar.php'; ?>
<div class="main-content">
<?php include '../includes/topbar.php'; ?>
<div class="page-body">
  <div class="card">
    <div class="card-header">
      <h3>All Admins</h3>
      <a href="add_admin.php" class="btn btn-sm btn-icon">＋ Add Admin</a>
    </div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $c=0; while($row=mysqli_fetch_assoc($result)): $c++; ?>
          <tr>
            <td class="td-muted"><?=$row['id']?></td>
            <td class="td-title"><?=htmlspecialchars($row['username'])?></td>
            <td class="td-muted"><?=htmlspecialchars($row['email'])?></td>
            <td><div class="action-links">
              <a href="edit_admin.php?id=<?=$row['id']?>" class="btn btn-sm btn-secondary">Edit</a>
              <a href="delete_admin.php?id=<?=$row['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this admin?')">Delete</a>
            </div></td>
          </tr>
        <?php endwhile; if($c===0): ?>
          <tr><td colspan="8"><div class="empty-state"><span class="es-icon">👤</span><h3>No admins yet</h3><p><a href="add_admin.php">Add your first admin →</a></p></div></td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div></div></div>
<script src="../assets/theme.js"></script>
</body></html>
