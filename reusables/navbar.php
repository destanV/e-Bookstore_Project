<?php
session_start();
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
          <a href="index.php" class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a>
        </li>

        <li class="nav-item text-uppercase">
          <a href="contact.php"
            class="nav-link <?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact</a>
        </li>
        <?php
        if (isset($_SESSION['username'])) {
          echo <<<HTML
    <li class="nav-item text-uppercase">
        <a href="profile.php" class="nav-link" id="navbarProfile">Profile</a>
    </li>
    <li class="nav-item text-uppercase">
        <a href="scripts/logout.php" class="nav-link" id="navbarLogout">Log Out</a>
    </li>
    HTML;
        } else {
          echo <<<HTML
    <li class="nav-item text-uppercase">
        <a href="login.php" class="nav-link" id="navbarLogin">Log In</a>
    </li>
    HTML;
        }
        ?>



      </ul>
    </div>
  </div>
</nav>