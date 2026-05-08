<?php
include '../auth/auth_check.php';
include '../config/db.php';
$q = trim($_GET['q'] ?? '');
$results = null; $count = 0;
if($q !== ''){
  $safe = mysqli_real_escape_string($conn, $q);
  $sql = "SELECT * FROM books WHERE title LIKE '%$safe%' OR author LIKE '%$safe%' OR category LIKE '%$safe%' OR isbn LIKE '%$safe%' ORDER BY title ASC";
  $results = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($results);
}
$pageTitle='Search Books'; $pageSubtitle='Find any book in your catalog'; $hideSearch=true; $prefix='../';
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Search — libroCore</title>
<?php include '../includes/theme.php'; ?>
<link rel="stylesheet" href="../assets/style.css">
</head><body>
<div class="dashboard">
<?php include '../includes/sidebar.php'; ?>
<div class="main-content">
<?php include '../includes/topbar.php'; ?>
<div class="page-body">

  <!-- Search Form -->
  <div class="card" style="margin-bottom:24px;">
    <div class="card-body">
      <form method="GET" style="display:flex;gap:12px;align-items:flex-end;">
        <div class="input-group" style="flex:1;margin-bottom:0;">
          <label>Search books, authors, categories, ISBN</label>
          <input type="text" name="q" value="<?=htmlspecialchars($q)?>" placeholder="e.g. Harry Potter, Fiction, 978..." autofocus>
        </div>
        <button type="submit" class="btn btn-icon" style="width:auto;padding:12px 28px;">🔍 Search</button>
      </form>
    </div>
  </div>

  <?php if($q !== ''): ?>
  <!-- Results -->
  <div class="card">
    <div class="card-header">
      <h3>Results for "<?=htmlspecialchars($q)?>"</h3>
      <span style="font-size:13px;color:var(--text-muted);"><?=$count?> book<?=$count!=1?'s':''?> found</span>
    </div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>#</th><th>Title</th><th>Author</th><th>Category</th><th>Qty</th><th>Year</th><th>ISBN</th><th>Actions</th></tr></thead>
        <tbody>
        <?php if($count>0): while($row=mysqli_fetch_assoc($results)): ?>
          <tr>
            <td class="td-muted"><?=$row['id']?></td>
            <td class="td-title"><?=htmlspecialchars($row['title'])?></td>
            <td class="td-muted"><?=htmlspecialchars($row['author'])?></td>
            <td><span class="badge badge-cat"><?=htmlspecialchars($row['category']?:'—')?></span></td>
            <td><span class="badge <?=$row['quantity']<=2?'badge-low':'badge-qty'?>"><?=$row['quantity']?></span></td>
            <td class="td-muted"><?=$row['published_year']?></td>
            <td class="td-muted" style="font-size:12px;font-family:monospace;"><?=htmlspecialchars($row['isbn'])?></td>
            <td><div class="action-links">
              <a href="../books/edit_book.php?id=<?=$row['id']?>" class="btn btn-sm btn-secondary">Edit</a>
              <a href="../books/delete_book.php?id=<?=$row['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this book?')">Delete</a>
            </div></td>
          </tr>
        <?php endwhile; else: ?>
          <tr><td colspan="8"><div class="empty-state"><span class="es-icon">🔍</span><h3>No results found</h3><p>Try different keywords or <a href="../books/add_book.php">add this book</a></p></div></td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php else: ?>
  <div class="empty-state"><span class="es-icon">📚</span><h3>Start searching</h3><p>Type a book title, author name, category or ISBN above</p></div>
  <?php endif; ?>

</div></div></div>
<script src="../assets/theme.js"></script>
</body></html>
