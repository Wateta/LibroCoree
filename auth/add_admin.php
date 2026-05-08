<?php
include '../config/db.php';
include '../auth/auth_check.php';
$msg='';
if(isset($_POST['add_book'])){
  $t=mysqli_real_escape_string($conn,$_POST['title']);
  $a=mysqli_real_escape_string($conn,$_POST['author']);
  $cat=mysqli_real_escape_string($conn,$_POST['category']);
  $q=intval($_POST['quantity']);
  $y=intval($_POST['published_year']);
  $isbn=mysqli_real_escape_string($conn,$_POST['isbn']);
  if(mysqli_query($conn,"INSERT INTO books(title,author,category,quantity,published_year,isbn) VALUES('$t','$a','$cat',$q,$y,'$isbn')"))
    $msg='success';
  else $msg='Error: '.mysqli_error($conn);
}
$pageTitle='Add New Book'; $pageSubtitle='Enter book details below'; $prefix='../';
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Add Book — libroCore</title>
<?php include '../includes/theme.php'; ?>
<link rel="stylesheet" href="../assets/style.css">
</head><body>
<div class="dashboard">
<?php include '../includes/sidebar.php'; ?>
<div class="main-content">
<?php include '../includes/topbar.php'; ?>
<div class="page-body">
  <div style="max-width:600px;">
    <div class="form-card">
      <h2>Book Details</h2>
      <p class="form-subtitle">Fill in the information for the new book</p>
      <?php if($msg==='success'): ?><div class="message">✓ Book added! <a href="view_books.php">View all →</a></div>
      <?php elseif($msg): ?><div class="alert alert-error">⚠ <?=$msg?></div><?php endif; ?>
      <form method="POST">
        <div class="form-grid">
          <div class="input-group span-2"><label>Name</label><input type="text" name="title" placeholder="e.g. The Great Gatsby" required></div>
          <div class="input-group span-2"><label>Email</label><input type="text" name="author" placeholder="e.g. F. Scott Fitzgerald" required></div>
          <div class="input-group"><label>password</label><input type="text" name="category" placeholder="e.g. Fiction"></div>
          <div class="input-group"><label>Quantity</label><input type="number" name="quantity" value="1" min="0"></div>
       
        </div>
        <div class="form-actions">
          <a href="view_books.php" class="btn btn-secondary">Cancel</a>
          <button type="submit" name="add_book" class="btn">Add Admin</button>
        </div>
      </form>
    </div>
  </div>
</div></div></div>
<script src="../assets/theme.js"></script>
</body></html>
