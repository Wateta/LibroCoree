<?php
include '../config/db.php';
include '../auth/auth_check.php';
$id=intval($_GET['id']);
$book=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM books WHERE id=$id"));
$msg='';
if(isset($_POST['update_book'])){
  $t=mysqli_real_escape_string($conn,$_POST['title']);
  $a=mysqli_real_escape_string($conn,$_POST['author']);
  $cat=mysqli_real_escape_string($conn,$_POST['category']);
  $q=intval($_POST['quantity']);
  $y=intval($_POST['published_year']);
  $isbn=mysqli_real_escape_string($conn,$_POST['isbn']);
  if(mysqli_query($conn,"UPDATE books SET title='$t',author='$a',category='$cat',quantity=$q,published_year=$y,isbn='$isbn' WHERE id=$id")){
    header("Location: view_books.php"); exit();
  } else $msg='Error updating book.';
}
$pageTitle='Edit Book'; $pageSubtitle='Update book information'; $prefix='../';
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Edit Book — libroCore</title>
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
      <h2>Edit Book</h2>
      <p class="form-subtitle">Updating: <strong style="color:var(--gold);"><?=htmlspecialchars($book['title'])?></strong></p>
      <?php if($msg): ?><div class="alert alert-error">⚠ <?=$msg?></div><?php endif; ?>
      <form method="POST">
        <div class="form-grid">
          <div class="input-group span-2"><label>Book Title</label><input type="text" name="title" value="<?=htmlspecialchars($book['title'])?>" required></div>
          <div class="input-group span-2"><label>Author</label><input type="text" name="author" value="<?=htmlspecialchars($book['author'])?>" required></div>
          <div class="input-group"><label>Category</label><input type="text" name="category" value="<?=htmlspecialchars($book['category'])?>"></div>
          <div class="input-group"><label>Quantity</label><input type="number" name="quantity" value="<?=$book['quantity']?>" min="0"></div>
          <div class="input-group"><label>Published Year</label><input type="number" name="published_year" value="<?=$book['published_year']?>"></div>
          <div class="input-group"><label>ISBN</label><input type="text" name="isbn" value="<?=htmlspecialchars($book['isbn'])?>"></div>
        </div>
        <div class="form-actions">
          <a href="view_books.php" class="btn btn-secondary">Cancel</a>
          <button type="submit" name="update_book" class="btn">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div></div></div>
<script src="../assets/theme.js"></script>
</body></html>
