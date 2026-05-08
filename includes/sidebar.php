<?php
$current = basename($_SERVER['PHP_SELF']);
$dir = basename(dirname($_SERVER['PHP_SELF']));
function isActive($pages){ global $current,$dir;
  foreach($pages as $p){ if(strpos($current,$p)!==false) return 'active'; } return ''; }
?>

<?php $base = "/y1B_programs/libroCore-v2/"; ?>

<aside class="sidebar">
  <div class="sidebar-header">
    <span class="sidebar-logo">libro<span>Core</span></span>
    <span class="sidebar-tagline">Library Management</span>
  </div>

  <ul class="sidebar-nav">
    <span class="nav-label">Navigation</span>

    <li>
      <a href="<?= $base ?>dashboard.php" class="<?=isActive(['dashboard'])?>">
        <span class="ni">⊞</span> Dashboard
      </a>
    </li>

    <span class="nav-label">Catalog</span>

    <li>
      <a href="<?= $base ?>books/view_books.php" class="<?=isActive(['view_books'])?>">
        All Books
      </a>
    </li>

    <li>
      <a href="<?= $base ?>books/add_book.php" class="<?=isActive(['add_book'])?>">
        ＋ Add Book
      </a>
    </li>

    <li>
      <a href="<?= $base ?>search/index.php" class="<?=isActive(['search'])?>">
        Search Books
      </a>
    </li>

    <span class="nav-label">Circulation</span>

    <li>
      <a href="<?= $base ?>borrow/index.php" class="<?=isActive(['borrow'])?>">
        Borrow & Return
      </a>
    </li>

    <span class="nav-label">Account</span>

    <li>
      <a href="<?= $base ?>auth/add_admin.php">
        👤 Add Admin
      </a>
    </li>

    <li>
      <a href="<?= $base ?>auth/view_admins.php">
        👥 View Admins
      </a>
    </li>

    <li>
      <a href="<?= $base ?>profile/index.php" class="<?=isActive(['profile'])?>">
        👤 My Profile
      </a>
    </li>

    <li>
      <a href="<?= $base ?>settings/index.php" class="<?=isActive(['settings'])?>">
        ⚙ Settings
      </a>
    </li>

  </ul>

  <div class="sidebar-footer">
    <a href="<?= $base ?>auth/logout.php">
      ⎋ Sign Out
    </a>
  </div>
</aside>