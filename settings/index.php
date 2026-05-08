<?php
include '../auth/auth_check.php';
include '../config/db.php';
$msg = '';
if(isset($_POST['save_settings'])){
  $msg = 'Settings saved!';
}
$pageTitle='Settings'; $pageSubtitle='Customize your libroCore experience'; $prefix='../';
?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Settings — libroCore</title>
<?php include '../includes/theme.php'; ?>
<link rel="stylesheet" href="../assets/style.css">
</head><body>
<div class="dashboard">
<?php include '../includes/sidebar.php'; ?>
<div class="main-content">
<?php include '../includes/topbar.php'; ?>
<div class="page-body">

<?php if($msg): ?><div class="alert alert-success">✓ <?=$msg?></div><?php endif; ?>

<!-- Appearance -->
<div class="settings-section">
  <div class="settings-title">🎨 Appearance</div>
  <div class="settings-row">
    <div class="sri"><h4>Dark Mode</h4><p>Switch between dark and light theme</p></div>
    <label class="toggle">
      <input type="checkbox" id="themeToggleCheck" onchange="toggleTheme()">
      <span class="toggle-slider"></span>
    </label>
  </div>
  <div class="settings-row">
    <div class="sri"><h4>Compact Sidebar</h4><p>Reduce sidebar padding for more space</p></div>
    <label class="toggle"><input type="checkbox"><span class="toggle-slider"></span></label>
  </div>
</div>

<!-- Notifications -->
<div class="settings-section">
  <div class="settings-title">🔔 Alerts</div>
  <div class="settings-row">
    <div class="sri"><h4>Low Stock Alerts</h4><p>Warn when a book has ≤ 2 copies</p></div>
    <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
  </div>
  <div class="settings-row">
    <div class="sri"><h4>Overdue Borrow Alerts</h4><p>Highlight books past their due date</p></div>
    <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
  </div>
</div>

<!-- Library Info -->
<div class="settings-section">
  <div class="settings-title">🏛️ Library Information</div>
  <div class="card-body" style="padding:24px;">
    <form method="POST">
      <div class="form-grid">
        <div class="input-group span-2">
          <label>Library Name</label>
          <input type="text" name="lib_name" placeholder="e.g. City Public Library" value="libroCore Library">
        </div>
        <div class="input-group">
          <label>Default Borrow Period (days)</label>
          <input type="number" name="borrow_days" value="14">
        </div>
        <div class="input-group">
          <label>Low Stock Threshold</label>
          <input type="number" name="low_stock" value="2">
        </div>
      </div>
      <button type="submit" name="save_settings" class="btn btn-icon" style="width:auto;">💾 Save Settings</button>
    </form>
  </div>
</div>

<!-- Danger Zone -->
<div class="settings-section">
  <div class="settings-title" style="color:var(--danger);">⚠️ Danger Zone</div>
  <div class="settings-row">
    <div class="sri"><h4>Export All Books</h4><p>Download your catalog as CSV</p></div>
    <a href="../books/export.php" class="btn btn-sm btn-secondary btn-icon">📥 Export CSV</a>
  </div>
  <div class="settings-row">
    <div class="sri"><h4>Sign Out Everywhere</h4><p>End all active sessions</p></div>
    <a href="../auth/logout.php" class="btn btn-sm btn-danger btn-icon">⎋ Sign Out</a>
  </div>
</div>

</div></div></div>
<script src="../assets/theme.js"></script>
<script>
document.addEventListener('DOMContentLoaded',function(){
  var t = localStorage.getItem('lcTheme')||'dark';
  var chk = document.getElementById('themeToggleCheck');
  if(chk) chk.checked = (t==='light');
});
</script>
</body></html>
