<?php
$prefix = (isset($prefix)) ? $prefix : '';
?>
<header class="topbar">
  <div>
    <div class="topbar-title"><?=$pageTitle??'Dashboard'?></div>
    <div class="topbar-sub"><?=$pageSubtitle??''?></div>
  </div>
  <div class="topbar-actions">
    <div class="search-bar" style="display:<?=(isset($hideSearch)&&$hideSearch)?'none':'flex'?>">
      <span class="search-icon">🔍</span>
     <input type="text" placeholder="Search books..." onkeydown="if(event.key==='Enter'){window.location='/y1B_programs/libroCore-v2/search/index.php?q='+encodeURIComponent(this.value);}">
    </div>
    <div class="theme-toggle" onclick="toggleTheme()" title="Toggle theme" id="themeBtn">🌙</div>
    <a href="<?=$prefix?>profile/index.php" class="user-badge">
      <div class="user-avatar"><?=strtoupper(substr($_SESSION['username'],0,1))?></div>
      <?=htmlspecialchars($_SESSION['username'])?>
    </a>
  </div>
</header>
