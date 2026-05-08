<?php
include 'auth/auth_check.php';
include 'config/db.php';

$total_books   = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM books"))['c'];
$total_authors = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(DISTINCT author) c FROM books"))['c'];
$total_cats    = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(DISTINCT category) c FROM books WHERE category!=''"))['c'];
$low_stock     = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM books WHERE quantity<=2"))['c'];
$total_qty     = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(quantity) c FROM books"))['c'] ?? 0;
$borrowed      = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM borrows WHERE status='borrowed'"))['c'] ?? 0;

$recent = mysqli_query($conn,"SELECT * FROM books ORDER BY id DESC LIMIT 6");
$recent_borrows = mysqli_query($conn,"SELECT b.*,bk.title FROM borrows b JOIN books bk ON b.book_id=bk.id ORDER BY b.id DESC LIMIT 5") ?: null;
$pageTitle='Dashboard'; $pageSubtitle='Welcome back, '.htmlspecialchars($_SESSION['username']).' 👋';
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard — libroCore</title>
<?php include 'includes/theme.php'; ?>
<link rel="stylesheet" href="assets/style.css">
</head><body>
<div class="dashboard">
<?php include 'includes/sidebar.php'; ?>
<div class="main-content">
<?php include 'includes/topbar.php'; ?>
<div class="page-body">

  <!-- Stats -->
  <div class="stats-grid">
    <div class="stat-card"><div"">Total Books</div><div class="stat-value"><?=$total_books?></div><div class="stat-sub">titles in catalog</div><span class="stat-icon">📚</span></div>
    <div class="stat-card ic"><div class="stat-label">Total Authors</div><div class="stat-value"><?=$total_authors?></div><div class="stat-sub">unique authors</div><span class="stat-icon">✍️</span></div>
    <div class="stat-card sc"><div class="stat-label">Categories</div><div class="stat-value"><?=$total_cats?></div><div class="stat-sub">genres tracked</div><span class="stat-icon">🏷️</span></div>
    <div class="stat-card wc"><div class="stat-label">Total Copies</div><div class="stat-value"><?=$total_qty?></div><div class="stat-sub">physical copies</div><span class="stat-icon">📦</span></div>
    <div class="stat-card dc"><div class="stat-label">Low Stock</div><div class="stat-value"><?=$low_stock?></div><div class="stat-sub">qty ≤ 2 copies</div><span class="stat-icon">⚠️</span></div>
    <div class="stat-card"><div class="stat-label">Borrowed</div><div class="stat-value"><?=$borrowed?></div><div class="stat-sub">currently out</div><span class="stat-icon">📖</span></div>
  </div>

  <!-- Content grid -->
  <div class="content-grid">

    <!-- Recent Books -->
    <div class="card">
      <div class="card-header">
        <h3>Recently Added Books</h3>
        <a href="books/add_book.php" class="btn btn-sm btn-icon">＋ Add Book</a>
      </div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Title</th><th>Author</th><th>Category</th><th>Qty</th><th>Year</th></tr></thead>
          <tbody>
          <?php $c=0; while($row=mysqli_fetch_assoc($recent)): $c++;?>
            <tr>
              <td class="td-title"><?=htmlspecialchars($row['title'])?></td>
              <td class="td-muted"><?=htmlspecialchars($row['author'])?></td>
              <td><span class="badge badge-cat"><?=htmlspecialchars($row['category']?:'—')?></span></td>
              <td><span class="badge <?=$row['quantity']<=2?'badge-low':'badge-qty'?>"><?=$row['quantity']?></span></td>
              <td class="td-muted"><?=$row['published_year']?></td>
            </tr>
          <?php endwhile; if($c===0): ?>
            <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:30px;">No books yet. <a href="books/add_book.php">Add one →</a></td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Right column -->
    <div style="display:flex;flex-direction:column;gap:20px;">

      <!-- Quick Actions -->
      <div class="card">
        <div class="card-header"><h3>Quick Actions</h3></div>
        <div class="card-body">
          <div class="quick-actions">
            <a href="books/add_book.php" class="quick-action"><span class="qa-icon">➕</span><span class="qa-label">Add Book</span></a>
            <a href="search/index.php" class="quick-action"><span class="qa-icon">🔍</span><span class="qa-label">Search</span></a>
            <a href="borrow/index.php" class="quick-action"><span class="qa-icon">📖</span><span class="qa-label">Borrow</span></a>
            <a href="books/view_books.php" class="quick-action"><span class="qa-icon">📋</span><span class="qa-label">All Books</span></a>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="card" style="flex:1;">
        <div class="card-header"><h3>Recent Activity</h3></div>
        <div class="card-body">
          <ul class="activity-list">
            <?php if($recent_borrows && mysqli_num_rows($recent_borrows)>0):
              mysqli_data_seek($recent_borrows,0);
              while($b=mysqli_fetch_assoc($recent_borrows)):
                $dot = $b['status']==='returned'?'green':($b['status']==='overdue'?'red':'blue');
                $icon = $b['status']==='returned'?'returned':'borrowed';
            ?>
            <li class="activity-item">
              <div class="activity-dot <?=$dot?>"></div>
              <div><div class="activity-text"><strong><?=htmlspecialchars($b['borrower_name']??'Someone')?></strong> <?=$b['status']?> <strong>"<?=htmlspecialchars($b['title'])?>"</strong></div>
              <div class="activity-time"><?=date('M d, Y',strtotime($b['borrow_date']??'now'))?></div></div>
            </li>
            <?php endwhile; else: ?>
            <li class="activity-item"><div class="activity-dot blue"></div><div class="activity-text">No borrow activity yet.<br><a href="borrow/index.php">Record a borrow →</a></div></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>

    </div>
  </div>

</div></div></div>
<script src="assets/theme.js"></script>
</body></html>
