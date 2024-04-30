// Toggle password visibility
const userPasswordEl = document.querySelector("#password");
const togglePasswordEl = document.querySelector("#togglePassword");

togglePasswordEl.addEventListener("click", function () {
  if (this.checked === true) {
    userPasswordEl.setAttribute("type", "text");
  } else {
    userPasswordEl.setAttribute("type", "password");
  }
});
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

  setTimeout(showSlides, 3000); // Change image every 3 seconds (adjust as needed)
}

// Call the function to start the slideshow
showSlides();

// JavaScript for handling the upload modal
var uploadModal = document.getElementById("uploadModal");
var openUploadModal = document.getElementById("openUploadModal");
var closeUploadModal = document.getElementById("closeUploadModal");

openUploadModal.onclick = function() {
  uploadModal.style.display = "block";
}

closeUploadModal.onclick = function() {
  uploadModal.style.display = "none";
  document.getElementById("uploadResponse").innerHTML = ""; // Clear the response
}

window.onclick = function(event) {
  if (event.target == uploadModal) {
    uploadModal.style.display = "none";
    document.getElementById("uploadResponse").innerHTML = ""; // Clear the response
  }
}

// JavaScript for handling file upload with AJAX
document.getElementById("uploadButton").addEventListener("click", function() {
  var fileInput = document.getElementById("fileInput");
  var formData = new FormData();
  formData.append("image", fileInput.files[0]);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "upload.php", true);

  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Display the response message in the modal
        document.getElementById("uploadResponse").innerHTML = xhr.responseText;

        // Clear the file input
        fileInput.value = "";

        // Reload the page after a successful upload (you can adjust the delay as needed)
        setTimeout(function() {
          location.reload();
        }, 1000); // Refresh the page after 2 seconds
      } else {
        document.getElementById("uploadResponse").innerHTML = "Error uploading file.";
      }
    }
  };

  xhr.send(formData);
});

// JavaScript for handling the config modal and telecom config section
var configModal = document.getElementById("configModal");
var openConfigModal = document.getElementById("openConfigModal");
var closeConfigModal = document.getElementById("closeConfigModal");

var telecomConfigSection = document.getElementById("telecomConfigSection");
var openTelecomConfig = document.getElementById("openTelecomConfig");

var addressConfigSection = document.getElementById("addressConfigSection");
var openAddConfig = document.getElementById("openAddConfig");


openConfigModal.onclick = function() {
  configModal.style.display = "block";
}

closeConfigModal.onclick = function() {
  configModal.style.display = "none";
  document.getElementById("configResponse").innerHTML = ""; // Clear the response
}

openTelecomConfig.onclick = function() {
  telecomConfigSection.style.display = "block";
}
openAddConfig.onclick = function() {
  addressConfigSection.style.display = "block";
}

// Function to hide the telecom config section
function closeTelecomConfig() {
  telecomConfigSection.style.display = "none";
  document.getElementById("telecomConfigResponse").innerHTML = ""; // Clear the response
}
function closeTelecomConfig() {
  addressConfigSection.style.display = "none";
  document.getElementById("addressConfigResponse                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ").innerHTML = ""; // Clear the response
}
// Close the telecom config section when the close button is clicked
document.getElementById("closeTelecomConfig").onclick = closeTelecomConfig;

// Close the telecom config section if the user clicks outside of it
window.onclick = function(event) {
  if (event.target == configModal) {
    configModal.style.display = "none";
    closeTelecomConfig(); // Close the telecom config section
  }
}
