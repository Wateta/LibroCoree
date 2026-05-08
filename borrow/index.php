<?php
include '../auth/auth_check.php';
include '../config/db.php';

$msg = ''; $msgtype = '';
if(isset($_POST['borrow_book'])){
  $book_id = intval($_POST['book_id']);
  $name = mysqli_real_escape_string($conn,$_POST['borrower_name']);
  $date = $_POST['borrow_date'];
  $due  = $_POST['due_date'];
  $chk = mysqli_fetch_assoc(mysqli_query($conn,"SELECT quantity FROM books WHERE id=$book_id"));
  if($chk && $chk['quantity']>0){
    mysqli_query($conn,"INSERT INTO borrows(book_id,borrower_name,borrow_date,due_date,status) VALUES($book_id,'$name','$date','$due','borrowed')");
    mysqli_query($conn,"UPDATE books SET quantity=quantity-1 WHERE id=$book_id");
    $msg='Book borrowed successfully!'; $msgtype='success';
  } else { $msg='Book is out of stock!'; $msgtype='error'; }
}
if(isset($_POST['return_book'])){
  $id = intval($_POST['borrow_id']);
  $b = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM borrows WHERE id=$id"));
  if($b){ mysqli_query($conn,"UPDATE borrows SET status='returned',return_date=NOW() WHERE id=$id");
    mysqli_query($conn,"UPDATE books SET quantity=quantity+1 WHERE id={$b['book_id']}");
    $msg='Book returned successfully!'; $msgtype='success'; }
}

$books = mysqli_query($conn,"SELECT id,title,author,quantity FROM books WHERE quantity>0 ORDER BY title");
$borrows = mysqli_query($conn,"SELECT br.*,bk.title as book_title FROM borrows br JOIN books bk ON br.book_id=bk.id ORDER BY br.id DESC");
$pageTitle='Borrow & Return'; $pageSubtitle='Manage book circulation'; $prefix='../';
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Borrow & Return — libroCore</title>
<?php include '../includes/theme.php'; ?>
<link rel="stylesheet" href="../assets/style.css">
</head><body>
<div class="dashboard">
<?php include '../includes/sidebar.php'; ?>
<div class="main-content">
<?php include '../includes/topbar.php'; ?>
<div class="page-body">

<?php if($msg): ?>
  <div class="alert alert-<?=$msgtype==='success'?'success':'error'?>"><?=$msgtype==='success'?'✓':'⚠'?> <?=$msg?></div>
<?php endif; ?>

<div class="content-grid">

  <!-- Borrow Form -->
  <div>
    <div class="card" style="margin-bottom:20px;">
      <div class="card-header"><h3> Record a Borrow</h3></div>
      <div class="card-body">
        <form method="POST">
          <div class="form-grid">
            <div class="input-group span-2">
              <label>Select Book</label>
              <select name="book_id" required>
                <option value="">— Choose a book —</option>
                <?php while($b=mysqli_fetch_assoc($books)): ?>
                <option value="<?=$b['id']?>"><?=htmlspecialchars($b['title'])?> — <?=htmlspecialchars($b['author'])?> (<?=$b['quantity']?> left)</option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="input-group span-2">
              <label>Borrower Name</label>
              <input type="text" name="borrower_name" placeholder="Full name" required>
            </div>
            <div class="input-group">
              <label>Borrow Date</label>
              <input type="date" name="borrow_date" value="<?=date('Y-m-d')?>" required>
            </div>
            <div class="input-group">
              <label>Due Date</label>
              <input type="date" name="due_date" value="<?=date('Y-m-d',strtotime('+14 days'))?>" required>
            </div>
          </div>
          <button type="submit" name="borrow_book" class="btn"> Record Borrow</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Stats sidebar -->
  <div style="display:flex;flex-direction:column;gap:16px;">
    <?php
      $total_b = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM borrows WHERE status='borrowed'"))['c']??0;
      $total_r = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM borrows WHERE status='returned'"))['c']??0;
      $overdue = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM borrows WHERE status='borrowed' AND due_date < NOW()"))['c']??0;
    ?>
    <div class="stat-card"><div class="stat-label">Currently Borrowed</div><div class="stat-value" style="font-size:30px;"><?=$total_b?></div><span class="stat-icon">📖</span></div>
    <div class="stat-card sc"><div class="stat-label">Total Returned</div><div class="stat-value" style="font-size:30px;"><?=$total_r?></div><span class="stat-icon">✅</span></div>
    <div class="stat-card dc"><div class="stat-label">Overdue</div><div class="stat-value" style="font-size:30px;"><?=$overdue?></div><span class="stat-icon">⏰</span></div>
  </div>

</div>

<!-- Borrow Records -->
<div class="card">
  <div class="card-header"><h3>Borrow Records</h3></div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>#</th><th>Book</th><th>Borrower</th><th>Borrowed</th><th>Due</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
      <?php $c=0; while($row=mysqli_fetch_assoc($borrows)): $c++;
        $overdue_row = $row['status']==='borrowed' && strtotime($row['due_date'])<time();
        $status = $overdue_row?'overdue':$row['status'];
      ?>
        <tr>
          <td class="td-muted"><?=$row['id']?></td>
          <td class="td-title"><?=htmlspecialchars($row['book_title'])?></td>
          <td class="td-muted"><?=htmlspecialchars($row['borrower_name'])?></td>
          <td class="td-muted"><?=date('M d, Y',strtotime($row['borrow_date']))?></td>
          <td class="td-muted" style="<?=$overdue_row?'color:var(--danger)':''?>"><?=date('M d, Y',strtotime($row['due_date']))?></td>
          <td><span class="badge badge-<?=$status?>"><?=ucfirst($status)?></span></td>
          <td>
            <?php if($row['status']==='borrowed'): ?>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="borrow_id" value="<?=$row['id']?>">
              <button type="submit" name="return_book" class="btn btn-sm btn-success">↩ Return</button>
            </form>
            <?php else: ?>
            <span style="color:var(--text-muted);font-size:12px;"><?=date('M d',strtotime($row['return_date']??'now'))?></span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; if($c===0): ?>
        <tr><td colspan="7"><div class="empty-state"><span class="es-icon">📖</span><h3>No borrows yet</h3><p>Use the form above to record a borrow</p></div></td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</div></div></div>
<script src="../assets/theme.js"></script>
</body></html>
