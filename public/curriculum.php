<?php
include "../includes/db.php";

$data = [];

$result = mysqli_query($conn, "SELECT * FROM curriculum");

while($row = mysqli_fetch_assoc($result)){
    $data[$row['section']] = $row['content'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Curriculum | GVS School</title>

<!-- Main CSS -->
<link rel="stylesheet" href="assets/css/style.css">


<style>
/* Same layout as hosted (Fix footer issue) */

html, body {
  height: 100%;
  margin: 0;
}

body {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.main-wrapper {
  flex: 1 0 auto;
}

.footer {
  flex-shrink: 0;
}
</style>


<!-- AOS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>


<!-- MAIN WRAPPER -->
<div class="main-wrapper">


<!-- SCROLL BAR -->
<div id="progress-bar"></div>


<!-- HEADER -->

<header class="header-main">
  <div class="container header-inner">

    <div class="logo-box">
      <img src="assets/images/logo.png" alt="Logo">

      <div class="logo-text">
        <span class="school-name">GVS School</span>
        <small>Sankhali, Goa</small>
      </div>
    </div>


    <nav class="nav-menu">

      <a href="index.php" class="nav-link">Home</a>
      <a href="about.php" class="nav-link">About</a>
      <a href="curriculum.php" class="nav-link active">Curriculum</a>
      <a href="gallery.php" class="nav-link">Gallery</a>
      <a href="events.php" class="nav-link">Events</a>
      <a href="blog.php" class="nav-link">Blogs</a>

    </nav>

  </div>
</header>



<!-- PAGE HERO -->

<section class="page-hero"
style="
background-image:
linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),
url('assets/images/curriculum-hero.jpg');
background-size: cover;
background-position: center;
background-repeat: no-repeat;
">


  <div class="container" data-aos="fade-up">

    <h1>Our Curriculum</h1>
    <p>Structured learning for every stage</p>

  </div>

</section>



<!-- CURRICULUM -->

<section class="section curriculum-page">

  <div class="container">


    <div class="section-title" data-aos="fade-up">

      <h2>Our Curriculum</h2>
      <p>Learning at every stage</p>

    </div>


    <!-- PRE PRIMARY -->

    <div class="curriculum-card" data-aos="fade-right">

      <img src="assets/images/preprimary.jpg">

      <div class="curriculum-text">

        <h3>Pre-Primary</h3>

        <div>
          <?= $data['Pre-Primary'] ?? 'No content added yet.' ?>
        </div>

      </div>

    </div>


    <!-- PRIMARY -->

    <div class="curriculum-card reverse" data-aos="fade-left">

      <img src="assets/images/primary.jpg">

      <div class="curriculum-text">

        <h3>Primary</h3>

        <div>
          <?= $data['Primary'] ?? 'No content added yet.' ?>
        </div>

      </div>

    </div>


    <!-- HIGH SCHOOL -->

    <div class="curriculum-card" data-aos="fade-right">

      <img src="assets/images/highschool.jpg">

      <div class="curriculum-text">

        <h3>High School</h3>

        <div>
          <?= $data['High School'] ?? 'No content added yet.' ?>
        </div>

      </div>

    </div>


  </div>

</section>


</div> <!-- END main-wrapper -->



<!-- FOOTER -->

<footer class="footer">

  <div class="container footer-grid">


    <div class="footer-col">

      <h3>GVS School</h3>
      <p>Providing quality education since 2006.</p>

    </div>


    <div class="footer-col">

      <h3>Quick Links</h3>

      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>

    </div>


    <div class="footer-col">

      <h3>Contact</h3>

      <p>📍 Sankhali, Goa</p>
      <p>📞 +91 XXXXXXXX</p>
      <p>✉️ info@gvsschool.com</p>

    </div>

  </div>


  <div class="footer-bottom">
    © 2026 GVS School | All Rights Reserved
  </div>

</footer>



<!-- Floating Buttons -->

<a href="https://wa.me/91XXXXXXXXXX"
class="whatsapp-btn"
target="_blank">
<i class="fab fa-whatsapp"></i>
</a>


<button id="scrollTopBtn">
<i class="fas fa-arrow-up"></i>
</button>



<!-- SCRIPTS -->

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="assets/js/main.js"></script>


<script>
AOS.init({
  duration: 1000,
  once: true
});
</script>

</body>
</html>
