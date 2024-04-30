<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
require_once "config.php"; 

    

?>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #fff44f;">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="./img/logo.png" alt="Your Logo" style="width: 70px; height: auto;"></a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./guestindex.php" style="color: #135351; font-weight: bold;">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./guest.php" style="color: #135351; font-weight: bold;">Guest</a>
                </li>
              
                <li class="nav-item">
                    <a class="nav-link" href="./forumUser.php" style="color: #135351; font-weight: bold;">Forum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./eventuser.php" style="color: #135351; font-weight: bold;">Event Schedule</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php" style="color: #135351; font-weight: bold;">Log Out</a>
                </li>
            </ul>
        </div>

        <div class="hamburger-menu" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <ul>
                <li><a href="./indexuser.php" style="color: #135351; font-weight: bold;">Home</a></li>
                <li><a href="<?php echo $learningsLink; ?>" style="color: #135351; font-weight: bold;">Learnings</a></li>
                <li><a href="./forum.php" style="color: #135351; font-weight: bold;">Forum</a></li>
                <li><a href="./eventuser.php" style="color: #135351; font-weight: bold;">Event Schedule</a></li>
                <li><a href="./logout.php" style="color: #135351; font-weight: bold;">Log Out</a></li>
            </ul>
        </div>
    </div>
</nav>
  <body>


  <style>
    /* Add custom styles for the hamburger menu button */
    .hamburger-menu {
      cursor: pointer;
      display: inline-block;
      width: 30px;
      height: 20px;
      position: relative;
    }
    .hamburger-menu div {
      width: 100%;
      height: 3px;
      background-color: #fff; /* Customize the color */
      position: absolute;
      transition: 0.4s;
    }
    .hamburger-menu div:nth-child(1) {
      top: 0;
    }
    .hamburger-menu div:nth-child(2) {
      top: 50%;
      transform: translateY(-50%);
    }
    .hamburger-menu div:nth-child(3) {
      bottom: 0;
    }
    .mobile-menu {
      display: none;
      background-color: #fff44f;
      position: absolute;
      top: 60px;
      right: 0;
      width: 200px; /* Adjust as needed */
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }
    .mobile-menu.active {
      display: block;
    }
    .mobile-menu ul {
      list-style-type: none;
      padding: 0;
    }
    .mobile-menu li {
      padding: 10px;
    }
    .mobile-menu a {
      text-decoration: none;
      color: #135351;
      font-weight: bold;
    }
  </style>
<script>
    // JavaScript function to toggle the mobile menu
    function toggleMenu() {
      var mobileMenu = document.getElementById('mobileMenu');
      mobileMenu.classList.toggle('active');
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-lfM5qO6AQ6W+xT6scl1iC7Qp6p3AJbUhr5dF5R5Z14bW0c5Lb5A5s5e5O5O5O5O5O5O5O5O5O5O5O5O5O5O5O5O5O==" crossorigin="anonymous">
  </script>
</body>