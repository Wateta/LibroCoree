<?php
include '../config/db.php';
include '../auth/auth_check.php';
$sql = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($conn,$sql);
$pageTitle='Book Catalog'; $pageSubtitle='All books in your library'; $prefix='../';
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>All Books — libroCore</title>
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
      <h3>All Books</h3>
      <a href="add_book.php" class="btn btn-sm btn-icon">＋ Add Book</a>
    </div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>#</th><th>Title</th><th>Author</th><th>Category</th><th>Qty</th><th>Year</th><th>ISBN</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $c=0; while($row=mysqli_fetch_assoc($result)): $c++; ?>
          <tr>
            <td class="td-muted"><?=$row['id']?></td>
            <td class="td-title"><?=htmlspecialchars($row['title'])?></td>
            <td class="td-muted"><?=htmlspecialchars($row['author'])?></td>
            <td><span class="badge badge-cat"><?=htmlspecialchars($row['category']?:'—')?></span></td>
            <td><span class="badge <?=$row['quantity']<=2?'badge-low':'badge-qty'?>"><?=$row['quantity']?></span></td>
            <td class="td-muted"><?=$row['published_year']?></td>
            <td class="td-muted" style="font-size:12px;font-family:monospace;"><?=htmlspecialchars($row['isbn'])?></td>
            <td><div class="action-links">
              <a href="edit_book.php?id=<?=$row['id']?>" class="btn btn-sm btn-secondary">Edit</a>
              <a href="delete_book.php?id=<?=$row['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this book?')">Delete</a>
            </div></td>
          </tr>
        <?php endwhile; if($c===0): ?>
          <tr><td colspan="8"><div class="empty-state"><span class="es-icon">📚</span><h3>No books yet</h3><p><a href="add_book.php">Add your first book →</a></p></div></td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div></div></div>
<script src="../assets/theme.js"></script>
</body></html>
