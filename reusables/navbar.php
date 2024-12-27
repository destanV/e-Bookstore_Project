<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav>
  <div class="container">
    <div id="logo-box">
      <a href="index.php" class="logo text-uppercase">E-Bookstore</a>
    </div>
    <div id="nav-links">
      <ul>
        <li class="nav-item text-uppercase">
          <a href="portfolio.php" class="nav-link <?php echo $current_page == 'portfolio.php' ? 'active' : ''; ?>">Portfolio</a>
        </li>
        <li class="nav-item text-uppercase">
          <a href="about.php" class="nav-link <?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About</a>
        </li>
        <li class="nav-item text-uppercase">
          <a href="contact.php" class="nav-link <?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>