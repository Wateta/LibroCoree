<?php
$current = basename($_SERVER['PHP_SELF']);
$dir = basename(dirname($_SERVER['PHP_SELF']));
function isActive($pages){ global $current,$dir;
  foreach($pages as $p){ if(strpos($current,$p)!==false) return 'active'; } return ''; }
?>
<aside class="sidebar">
  <div class="sidebar-header">
    <span class="sidebar-logo">libro<span>Core</span></span>
    <span class="sidebar-tagline">Library Management</span>
  </div>
  <ul class="sidebar-nav">
    <span class="nav-label">Navigation</span>
    <li><a href="<?=($dir=='books'||$dir=='profile'||$dir=='settings'||$dir=='search'||$dir=='borrow')?'../':''?>dashboard.php" class="<?=isActive(['dashboard'])?>"><span class="ni">⊞</span> Dashboard</a></li>
    <span class="nav-label">Catalog</span>
    <li><a href="<?=($dir=='books')?'':'books/'?>view_books.php" class="<?=isActive(['view_books'])?>"><span class="ni"></span> All Books</a></li>
    <li><a href="<?=($dir=='books')?'':'books/'?>add_book.php" class="<?=isActive(['add_book'])?>"><span class="ni">＋</span> Add Book</a></li>
    <li><a href="<?=($dir=='search')?'':'search/'?>index.php" class="<?=isActive(['search'])?>"><span class="ni"></span> Search Books</a></li>
    <span class="nav-label">Circulation</span>
    <li><a href="<?=($dir=='borrow')?'':'borrow/'?>index.php" class="<?=isActive(['borrow'])?>"><span class="ni"></span> Borrow & Return</a></li>
    <span class="nav-label">Account</span>
    <li><a href="/y1B_programs/libroCore-v2/auth/add_admin.php">👤 Add Admin</a></li>
    <li><a href="<?=($dir=='profile')?'':'profile/'?>index.php" class="<?=isActive(['profile'])?>"><span class="ni">👤</span> My Profile</a></li>
    <li><a href="<?=($dir=='settings')?'':'settings/'?>index.php" class="<?=isActive(['settings'])?>"><span class="ni">⚙</span> Settings</a></li>
  </ul>
  <div class="sidebar-footer">
    <a href="<?=($dir=='books'||$dir=='profile'||$dir=='settings'||$dir=='search'||$dir=='borrow')?'../':''?>auth/logout.php">⎋ &nbsp;Sign Out</a>
  </div>
</aside>
