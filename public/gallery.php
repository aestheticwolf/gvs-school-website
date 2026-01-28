<?php
include "../includes/db.php";

$result = mysqli_query($conn,
    "SELECT * FROM gallery ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Gallery | GVS School</title>

<link rel="stylesheet" href="assets/css/style.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

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
      <a href="curriculum.php" class="nav-link">Curriculum</a>
      <a href="gallery.php" class="nav-link active">Gallery</a>
      <a href="events.php" class="nav-link">Events</a>
      <a href="blog.php" class="nav-link">Blogs</a>

    </nav>

  </div>
</header>



<!-- PAGE HERO -->

<section class="page-hero">

  <div class="container" data-aos="fade-up">

    <h1>School Gallery</h1>
    <p>Moments • Memories • Achievements</p>

  </div>

</section>



<!-- GALLERY GRID -->

<section class="section gallery-page">

  <div class="container">

    <div class="gallery-grid">


<?php if(mysqli_num_rows($result) > 0): ?>

<?php while($row = mysqli_fetch_assoc($result)): ?>

<div class="gallery-card" data-aos="zoom-in">

  <img src="uploads/gallery/<?= $row['image'] ?>" alt="Gallery">

  <div class="gallery-overlay">
    <h3><?= $row['event_name'] ?></h3>
  </div>

</div>

<?php endwhile; ?>

<?php else: ?>

<p style="text-align:center; width:100%;">
  No images uploaded yet.
</p>

<?php endif; ?>


    </div>

  </div>

</section>



<!-- FOOTER -->

<footer class="footer">

  <div class="container footer-grid">

    <div class="footer-col">
      <h3>GVS School</h3>
      <p>Providing quality education with values and discipline since 2006.</p>
    </div>

    <div class="footer-col">
      <h3>Quick Links</h3>

      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="curriculum.php">Curriculum</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="blog.php">Blogs</a></li>
      </ul>

    </div>

    <div class="footer-col">
      <h3>Contact</h3>
      <p>Sankhali, Goa</p>
      <p>+91 XXXXXXXX</p>
      <p>info@gvsschool.com</p>
    </div>

  </div>

  <div class="footer-bottom">
    © 2026 GVS School | All Rights Reserved
  </div>

</footer>



<!-- FLOATING BUTTONS -->

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
