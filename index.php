<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // If the user is already logged in, redirect them to the appropriate page
    if ($_SESSION["status"] === "Admin") {
        header("location: indexadmin.php");
    } else {
        header("location: indexuser.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome Seventh-day Adventist Church.</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
</head>
<body>


<div>
<div class="background-image-div">
</div>

   <div class="container mt-4">
    <div class="row">
      <!-- Steps Section Column -->
      <div class="col-lg-8">
        <div class="column-content">
      
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div style="background: #FFFFFF; padding: 40px;">
        <div class="page text-center">
        <h2 style="color: #0071C2;">Seventh-Day Adventist Church</h2>
        <p>The Seventh-day Adventist Church is a Christian denomination distinguished by their doctrinal beliefs that the literal, visible Second Coming of Christ is close at hand, and that the Sabbath of the Old Testament is still relevant today and is God's true biblical Sabbath. Seventh-day Adventist beliefs state they are based solely on scripture, "Scripture is a road map. The Bible is God's voice, speaking His love personally to you today." The denomination grew out of the Millerite movement in the United States during the middle part of the 19th century, and was formally established in 1863. Among its founders was Ellen G. White, whose extensive writings are still held in high regard by the church today.</p>
        <p>While its critics regard it as a sectarian movement, the Seventh-day Adventist church is closely aligned to Protestantism. Its theology is Protestant in character, albeit with a number of unique teachings. These include a belief in the unconscious state of the dead and the doctrine of an investigative judgment. While many of their beliefs are rooted in Hebrew and Christian prophetism, and messianism, Seventh-day Adventists also share many of the basic beliefs held by other Protestant Christians; such as the authority of the Old and New Testaments, human choice, Christ is the only way to gain salvation, communion, and baptism.</p>
        <!-- ... [continue with the rest of the content] ... -->
        <div style="text-align: center; margin-top: 30px;">
          <a href="./login.php" class="btn" style="background-color: #097969; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold;">Start spiritual study</a>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
        </div>
      </div>
    
      
      <!-- New Column for additional content -->
      <div class="col-lg-4">
        <div class="column-content">
        <div class="steps-section" style="background-color: #F2E8C7; color: black; padding: 20px 0; border: 5px solid #2399DA;">
  <div class="container">
    <div class="row text-center">
      <div class="col-md-4">
        <div class="step-number">1</div>
        <div class="step-text">Sign up for free with only your name and email</div>
      </div>
      <div class="col-md-4">
        <div class="step-number">2</div>
        <div class="step-text">Find answers and peace as you begin to understand God’s plan for your life</div>
      </div>
      <div class="col-md-4">
        <div class="step-number">3</div>
        <div class="step-text">View our Bible study for youth and adult</div>
      </div>
    </div>
    <div class="row">
      <div class="col text-center mt-4">
        <a href="./login.php" class="btn btn-light" style="background-color: #097969; color: white;">View our Spiritual learnings</a>
      </div>
    </div>
  </div>
</div>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
  <div class="col-lg-12">
  <div class="container my-5">
  <div class="row align-items-center">
    <!-- Left Column -->
    <div class="col-md-6">
      <div class="p-5 bg-primary text-white">
        <h2>Welcome to the Seventh-day Adventist Church Online Portal, a dynamic web-based platform dedicated to fostering a deeper understanding of our faith and community. This portal is an extension of our church's commitment to spiritual education and community engagement, offering an interactive and accessible space for both members and those interested in our beliefs.</h2>
      </div>
    </div>
    <!-- Right Column -->
    <div class="col-md-6">
      <div class="p-5 bg-light">
        <h3>Our mission is to make spiritual growth and community engagement more accessible than ever. This portal is not just a tool for learning but a virtual extension of our church, where fellowship and faith come together to create a vibrant and supportive online community.</h3>
        <ul>
          <li>Online Bible Study Courses:
Our portal offers structured Bible study courses tailored to different age groups and maturity levels in the faith journey. Adults and youth can embark on separate educational paths, featuring curated scripture studies, reflective exercises, and engaging discussions that resonate with their life stages.</li>
          <li>Experience total peace of mind</li>
          <li>Interactive Learning Experience:
Through multimedia content, interactive quizzes, and reflective exercises, learners can engage with the Word of God in a personal and profound way. Our platform accommodates various learning styles, ensuring that each member's journey through scripture is both enlightening and enjoyable.</li>
          <li>Event and Activity Notifications:
Stay informed about upcoming church events, services, and activities with real-time notifications. Whether it's a local community service project, a church potluck, or a regional worship conference, you'll never miss an opportunity to connect and participate.</li>
          <li>See the world differently—understand why our lives are so full of trouble and at the same time, learn why there is hope.</li>
          <li>Community Engagement:
The portal is a hub for community interaction. Members can share insights, submit prayer requests, and offer support to one another. It's a space to foster fellowship and encourage one another in faith, no matter where you are.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
    </div>
</body>
</html>
<style >
  .steps-section {

  padding: 20px 0;
  color: white; /* Adjust the text color as needed for readability */
}
  .steps-section .step-number {
  font-size: 2em;
  font-weight: bold;
  margin-bottom: 15px;
}

.steps-section .step-text {
  font-size: 1.2em;
  margin-bottom: 15px;
}

.steps-section a.btn {
  padding: 10px 25px;
  font-size: 1.2em;
  border-radius: 5px;
  text-transform: uppercase;
  transition: background-color 0.3s ease;
}

.steps-section a.btn:hover {
  background-color: #055C4E;
  color: #FFF;
}

.background-image-div {
  background-image: url('./components/p2.jpg');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  height: 50vh;
}

.btn {
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: #055C4E; /* Darken the button on hover */
  color: #FFF;
}


</style>