<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  header("Location: ./login.php");
  exit;
}

$config = parse_ini_file('config.ini', true);

function updateConfigFile($configData)
{
  $newConfig = "; Configuration file\n\n";
  foreach ($configData as $sectionName => $section) {
    $newConfig .= "[$sectionName]\n";
    foreach ($section as $key => $value) {
      $newConfig .= "$key = \"$value\"\n";
    }
    $newConfig .= "\n";
  }

  if (file_put_contents('config.ini', $newConfig) !== FALSE) {
    return true;
  } else {
    return false;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateOrganization"])) {
  $organizationName = $_POST["organizationName"];
  $organizationFounded = $_POST["organizationFounded"];
  $organizationTerritory = $_POST["organizationTerritory"];
  $organizationStatistics = $_POST["organizationStatistics"];

  // Update the organization configuration data
  $config['organization']['name'] = $organizationName;
  $config['organization']['founded'] = $organizationFounded;
  $config['organization']['territory'] = $organizationTerritory;
  $config['organization']['statistics'] = $organizationStatistics;

  // Attempt to update the config.ini file
  if (updateConfigFile($config)) {
    $configResponse = "Organization configuration updated successfully.";
  } else {
    $configResponse = "Error updating organization configuration.";
  }
}

// Check if the telecom config form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["saveTelecomConfig"])) {
  // Get the form data
  $telephone = $_POST["telephone"];
  $email = $_POST["email"];
  $website = $_POST["website"];
  $facebook = $_POST["facebook"];
  $media_streaming = $_POST["media_streaming"];

  // Update the telecom configuration data
  $config['telecommunications']['telephone'] = $telephone;
  $config['telecommunications']['email'] = $email;
  $config['telecommunications']['website'] = $website;
  $config['telecommunications']['facebook'] = $facebook;
  $config['telecommunications']['media_streaming'] = $media_streaming;

  // Attempt to update the config.ini file
  if (updateConfigFile($config)) {
    $telecomConfigResponse = "Telecom configuration updated successfully.";
  } else {
    $telecomConfigResponse = "Error updating telecom configuration.";
  }
}
// Check if the address form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["saveAddressConfig"])) {
  // Get the form data
  $street = $_POST["street"];
  $mailingAddress = $_POST["mailingAddress"];

  // Update the address configuration data
  $config['address']['street'] = $street;
  $config['address']['mailingAddress'] = $mailingAddress;

  // Attempt to update the config.ini file
  if (updateConfigFile($config)) {
    $addressConfigResponse = "Address configuration updated successfully.";
  } else {
    $addressConfigResponse = "Error updating address configuration.";
  }

}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["saveAdminConfig"])) {
  // Get the form data
  $president = $_POST["president"];
  $secretary = $_POST["secretary"];
  $treasurer = $_POST["treasurer"];

  // Update the administrator configuration data
  $config['administration']['president'] = $president;
  $config['administration']['secretary'] = $secretary;
  $config['administration']['treasurer'] = $treasurer;

  // Attempt to update the config.ini file
  if (updateConfigFile($config)) {
    $adminConfigResponse = "Admin configuration updated successfully.";
  } else {
    $adminConfigResponse = "Error updating admin configuration.";
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User login system</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="stylesheet" href="./css/indexA.css"> 
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
  <?php include 'navbar.php'; ?>
<div class="chang">
  <!-- Button to open the upload modal -->
  <button id="openUploadModal">Upload Image</button>

  <!-- Button to open the config edit modal -->
  <button id="openConfigModal">Edit Configuration</button>
</div>
  <!-- The upload image modal -->
  <div id="uploadModal" class="modal">
    <div class="modal-content">
      <span class="close" id="closeUploadModal">&times;</span>
      <form id="uploadForm" enctype="multipart/form-data" class="upload-container">
        <input type="file" name="image" accept="image/*" id="fileInput">
        <input type="button" value="Upload Image" id="uploadButton">
      </form>
      <div id="uploadResponse"></div>
    </div>
  </div>

  <!-- The config edit modal -->
  <div id="configModal" class="modal">
    <div class="modal-content config-center">
      <span class="close" id="closeConfigModal">&times;</span>
      <form id="configForm" class="config-container" method="POST"
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Organization configuration fields here -->
        <label for="organizationName">Organization Name:</label>
        <input type="text" name="organizationName" value="<?php echo $config['organization']['name']; ?>"><br>

        <label for="organizationFounded">Founded:</label>
        <input type="text" name="organizationFounded" value="<?php echo $config['organization']['founded']; ?>"><br>

        <label for="organizationTerritory">Territory:</label>
        <input type="text" name="organizationTerritory" value="<?php echo $config['organization']['territory']; ?>"><br>

        <label for="organizationStatistics">Statistics:</label>
        <input type="text" name="organizationStatistics"
          value="<?php echo $config['organization']['statistics']; ?>"><br>

        <input type="submit" name="updateOrganization" value="Save Configuration">
      </form>
      <div id="configResponse">
        <?php echo isset($configResponse) ? $configResponse : ''; ?>
      </div>

      <!-- Button to open the telecom config section -->
      <button id="openTelecomConfig">Edit Telecom Configuration</button>


      <!-- Telecom configuration section -->
      <div id="telecomConfigSection" style="display: none;">
        <h3>Telecommunications Configuration</h3>
        <form id="telecomConfigForm" class="config-container" method="POST"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <!-- Telecom configuration fields here -->
          <label for="telephone">Telephone:</label>
          <input type="text" name="telephone" value="<?php echo $config['telecommunications']['telephone']; ?>"><br>

          <label for="email">Email:</label>
          <input type="text" name="email" value="<?php echo $config['telecommunications']['email']; ?>"><br>

          <label for="website">Website:</label>
          <input type="text" name="website" value="<?php echo $config['telecommunications']['website']; ?>"><br>

          <label for="facebook">Facebook:</label>
          <input type="text" name="facebook" value="<?php echo $config['telecommunications']['facebook']; ?>"><br>

          <label for="media_streaming">Media/Streaming:</label>
          <input type="text" name="media_streaming"
            value="<?php echo $config['telecommunications']['media_streaming']; ?>"><br>

          <input type="submit" name="saveTelecomConfig" value="Save Telecom Configuration">
        </form>
        <div id="telecomConfigResponse">
          <?php echo isset($telecomConfigResponse) ? $telecomConfigResponse : ''; ?>
        </div>

        <button id="openAddConfig">Edit Address Configuration</button>
        <!-- Address configuration section -->
        <div id="addressConfigSection" style="display: none;">
          <h3>Address Configuration</h3>
          <form id="addressConfigForm" class="config-container" method="POST"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Address configuration fields here -->
            <label for="street">Street Address:</label>
            <input type="text" name="street" value="<?php echo $config['address']['street']; ?>"><br>

            <label for="mailingAddress">Mailing Address:</label>
            <input type="text" name="mailingAddress" value="<?php echo $config['address']['mailingAddress']; ?>"><br>

            <input type="submit" name="saveAddressConfig" value="Save Address Configuration">
          </form>
          <div id="addressConfigResponse">
            <?php echo isset($addressConfigResponse) ? $addressConfigResponse : ''; ?>
          </div>
        </div>


        <button id="openAdminConfig">Edit Administrator Configuration</button>
        <div id="adminConfigSection" style="display: none;">
          <h3>Administrator Configuration</h3>
          <form id="adminConfigForm" class="config-container" method="POST"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Administrator configuration fields here -->
            <label for="president">President:</label>
            <input type="text" name="president" value="<?php echo $config['administration']['president']; ?>"><br>

            <label for="secretary">Executive Secretary:</label>
            <input type="text" name="secretary" value="<?php echo $config['administration']['secretary']; ?>"><br>

            <label for="treasurer">Treasurer:</label>
            <input type="text" name="treasurer" value="<?php echo $config['administration']['treasurer']; ?>"><br>

            <input type="submit" name="saveAdminConfig" value="Save Administrator Configuration">
          </form>
          <div id="adminConfigResponse">
            <?php echo isset($adminConfigResponse) ? $adminConfigResponse : ''; ?>
          </div>
        </div>



      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="content-container">
          <h2>Organization</h2>
          <p>
            <?php echo $config['organization']['name']; ?>
          </p>
          <p>
            <?php echo $config['organization']['founded']; ?>
          </p>
          <p>
            <?php echo $config['organization']['territory']; ?>
          </p>
          <p>
            <?php echo $config['organization']['statistics']; ?>
          </p>

          <!-- Add the telecommunications content -->
          <div class="content">
            <h3>TELECOMMUNICATIONS</h3>
            <p>Telephone:
              <?php echo $config['telecommunications']['telephone']; ?>
            </p>
            <p>Email:
              <?php echo $config['telecommunications']['email']; ?>
            </p>
            <p>Website:
              <?php echo $config['telecommunications']['website']; ?>
            </p>
            <p>Facebook:
              <?php echo $config['telecommunications']['facebook']; ?>
            </p>
            <p>Media/Streaming:
              <?php echo $config['telecommunications']['media_streaming']; ?>
            </p>
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

          <!-- Add the administrator content -->
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
          </div>
        </div>
      </div>

      <!-- Slideshow container on the right -->
      <div class="col-lg-4">
        <div class="slideshow-container">
          <?php
          $imageDirectory = "./img/slideshow/"; 
          $images = glob($imageDirectory . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

          $slideIndex = 0; 
          
          foreach ($images as $index => $image) {
            echo '<div class="mySlides">';
            echo '<img src="' . $image . '" alt="Slideshow Image">';
            echo '<div class="remove-container">';
              $disableRemoveButton = $index === 0 ? 'disabled' : '';
  
  echo '<input type="checkbox" name="removeImage[]" value="' . $index . '" ' . $disableRemoveButton . '>';
  echo '<button class="remove-button" onclick="removeImage(' . $index . ')" ' . $disableRemoveButton . '>Remove</button>';
            echo '</div>';
            echo '</div>';
          }
          ?>
          <!-- Add navigation dots here -->
          <div class="dot-container">
            <?php
            foreach ($images as $image) {
              echo '<span class="dot"></span>';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <div class="gif-container">
              <img src="./img/sda.gif" alt="Your GIF Image">
            </div>


  </div>






  <script>
  function removeImage(index) {
    var confirmation = confirm("Are you sure you want to remove this image?");
    if (confirmation) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "remove_image.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            // Handle success, e.g., update the slideshow
            location.reload();
          } else {
            alert("Error removing image.");
          }
        }
      };

      xhr.send("index=" + index);
    }
  }


    var slideIndex = 0;

    function showSlides() {
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");

      for (var i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }

      slideIndex++;
      if (slideIndex > slides.length) {
        slideIndex = 1;
      }

      for (var i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }

      slides[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].className += " active";

      setTimeout(showSlides, 3000); 
    }

   
    showSlides();

    var uploadModal = document.getElementById("uploadModal");
    var openUploadModal = document.getElementById("openUploadModal");
    var closeUploadModal = document.getElementById("closeUploadModal");

    openUploadModal.onclick = function () {
      uploadModal.style.display = "block";
    }

    closeUploadModal.onclick = function () {
      uploadModal.style.display = "none";
      document.getElementById("uploadResponse").innerHTML = ""; 
    }

    window.onclick = function (event) {
      if (event.target == uploadModal) {
        uploadModal.style.display = "none";
        document.getElementById("uploadResponse").innerHTML = ""; 
      }
    }

  
    document.getElementById("uploadButton").addEventListener("click", function () {
      var fileInput = document.getElementById("fileInput");
      var formData = new FormData();
      formData.append("image", fileInput.files[0]);

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "upload.php", true);

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
          
            document.getElementById("uploadResponse").innerHTML = xhr.responseText;

           
            fileInput.value = "";

            setTimeout(function () {
              location.reload();
            }, 1000); 
          } else {
            document.getElementById("uploadResponse").innerHTML = "Error uploading file.";
          }
        }
      };

      xhr.send(formData);
    });

    var configModal = document.getElementById("configModal");
    var openConfigModal = document.getElementById("openConfigModal");
    var closeConfigModal = document.getElementById("closeConfigModal");

    var telecomConfigSection = document.getElementById("telecomConfigSection");
    var openTelecomConfig = document.getElementById("openTelecomConfig");

    var addressConfigSection = document.getElementById("addressConfigSection");
    var openAddConfig = document.getElementById("openAddConfig");

    var adminConfigSection = document.getElementById("adminConfigSection");
    var openAdminConfig = document.getElementById("openAdminConfig");



    openConfigModal.onclick = function () {
      configModal.style.display = "block";
    }

    closeConfigModal.onclick = function () {
      configModal.style.display = "none";
      document.getElementById("configResponse").innerHTML = ""; 
    }

    openTelecomConfig.onclick = function () {
      telecomConfigSection.style.display = "block";
    }
    openAddConfig.onclick = function () {
      addressConfigSection.style.display = "block";
    }
    openAdminConfig.onclick = function () {
      adminConfigSection.style.display = "block";
    }


    function closeTelecomConfig() {
      telecomConfigSection.style.display = "none";
      document.getElementById("telecomConfigResponse").innerHTML = "";
    }
    function closeTelecomConfig() {
      addressConfigSection.style.display = "none";
      document.getElementById("addressConfigResponse                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ").innerHTML = ""; // Clear the response
    }
    function closeTelecomConfig() {
      adminConfigSection.style.display = "none";
      document.getElementById("adminConfigResponse                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ").innerHTML = ""; // Clear the response
    }
    document.getElementById("closeTelecomConfig").onclick = closeTelecomConfig;

    window.onclick = function (event) {
      if (event.target == configModal) {
        configModal.style.display = "none";
        closeTelecomConfig(); 
      }
    }



 document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.querySelectorAll('input[name="removeImage[]"]');
    
    checkboxes.forEach(function (checkbox) {
      checkbox.addEventListener('change', function () {
        var removeButton = this.parentNode.querySelector('.remove-button');
        removeButton.disabled = checkboxes[0].checked; // Disable if the checkbox for the first image is checked
      });
    });
  });
  </script>
</body>

</html>
<style>
  .chang{
margin-top: 10px;
margin-left: 10px;
  }
  .gif-container{
    margin-left: 800px;
    margin-top: -200px;
  }

</style>