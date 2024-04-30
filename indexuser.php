<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  header("Location: ./login.php");
  exit;
}

$config = parse_ini_file('config.ini', true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="stylesheet" href="./css/index.css"> 
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
  <style>

body {
    background-image: url('./img/b2.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
  }
  </style>
</head>

<body>
  <?php include 'navbaruser.php'; ?>

  </div>
  <div class="container">
  <div class="row">
    <div class="col-lg-8">
      <div class="content" style="float: left; width: 50%;">
        <h2>Organization</h2>
        <p><?php echo $config['organization']['name']; ?></p>
        <p><?php echo $config['organization']['founded']; ?></p>
        <p><?php echo $config['organization']['territory']; ?></p>
        <p><?php echo $config['organization']['statistics']; ?></p>

        <!-- Add your new content here -->
        <div class="content">
          <h3>TELECOMMUNICATIONS</h3>
          <p>Telephone: <?php echo $config['telecommunications']['telephone']; ?></p>
          <p>Email: <?php echo $config['telecommunications']['email']; ?></p>
          <p>Website: <?php echo $config['telecommunications']['website']; ?></p>
          <p>Facebook: <?php echo $config['telecommunications']['facebook']; ?></p>
          <p>Media/Streaming: <?php echo $config['telecommunications']['media_streaming']; ?></p>
        </div>

        <!-- Add the address content -->
        <div class="content">
          <h3>ADDRESS</h3>
          <?php
          if (isset($config['address'])) {
            echo "<p>Street Address: " . $config['address']['street'] . "</p>";
            echo "<p>Mailing Address: " . $config['address']['mailingAddress'] . "</p>";
          } else {
            echo "<p>Address configuration not available.</p>";
          }
          ?>
        </div>

        
        <div class="content">
          <h3>ADMINISTRATOR</h3>
          <?php
          if (isset($config['administration'])) {
            echo "<p>President: " . $config['administration']['president'] . "</p>";
            echo "<p>Executive Secretary: " . $config['administration']['secretary'] . "</p>";
            echo "<p>Treasurer: " . $config['administration']['treasurer'] . "</p>";
          } else {
            echo "<p>Administrator configuration not available.</p>";
          }
          ?>
          <div class="gif-container" style="position: absolute; top: 500px; left: 950px;">
            <img src="./img/sda.gif" alt="Your GIF Image">
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
     
      <div class="slideshow-container">
        <?php
        $imageDirectory = "./img/slideshow/";
        $images = glob($imageDirectory . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

        foreach ($images as $index => $image) {
          echo '<div class="mySlides">';
          echo '<img src="' . $image . '" alt="Slideshow Image">';
          echo '</div>';
        }
        ?>
       
      </div>
    </div>
  </div>
</div>


<script>
  var slideIndex = 0;
  var slideInterval = 3000; 

  showSlides();

  function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");

    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }

    slideIndex++;

    if (slideIndex > slides.length) {
      slideIndex = 1;
    }

    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, slideInterval);
  }
</script>

</body>

</html>
