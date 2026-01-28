<?php
include "../includes/db.php";

/* Fetch Staff */
$res = mysqli_query($conn,"SELECT * FROM staff ORDER BY section");

$groups = [];

while($row = mysqli_fetch_assoc($res)){
    $groups[$row['section']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>About Us | GVS School</title>

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

<img src="assets/images/logo.png">

<div class="logo-text">

<span class="school-name">GVS School</span>
<small>Sankhali, Goa</small>

</div>
</div>


<nav class="nav-menu">

<a href="index.php" class="nav-link">Home</a>
<a href="about.php" class="nav-link active">About</a>
<a href="curriculum.php" class="nav-link">Curriculum</a>
<a href="gallery.php" class="nav-link">Gallery</a>
<a href="events.php" class="nav-link">Events</a>
<a href="blog.php" class="nav-link">Blogs</a>

</nav>

</div>

</header>



<!-- HERO -->

<section class="page-hero">

<div class="container" data-aos="fade-up">

<h1>About Our Institution</h1>
<p>Our Journey • Vision • Leadership • Faculty</p>

</div>

</section>



<!-- HISTORY -->

<section class="section">

<div class="container">

<div class="section-title" data-aos="fade-up">

<h2>Our History</h2>
<p>Journey Since 2006</p>

</div>


<div class="message-box" data-aos="fade-up">

<img src="assets/images/school.jpg">

<div>

<p>
Gopalkrishna Vidhyaprasarak Saunstha was established in 2006
with the aim of providing quality education.
</p>

<p>
The institution expanded gradually to secondary level.
</p>

<p>
Today GVS School focuses on holistic development.
</p>

</div>

</div>

</div>

</section>



<!-- VISION -->

<section class="section events">

<div class="container">

<div class="section-title" data-aos="fade-up">

<h2>Vision & Mission</h2>

</div>


<div class="card-grid">

<div class="card" data-aos="fade-right">

<h3>Our Vision</h3>

<p>
To nurture responsible citizens.
</p>

</div>


<div class="card" data-aos="fade-left">

<h3>Our Mission</h3>

<p>
Quality education with NEP 2020 standards.
</p>

</div>

</div>

</div>

</section>



<!-- MANAGEMENT -->

<section class="section">

<div class="container">

<div class="section-title" data-aos="fade-up">

<h2>Management</h2>
<p>Guiding the Institution</p>

</div>


<div class="card-grid">

<div class="card" data-aos="zoom-in">

<h3>President</h3>
<p>Dr. S. S. Hinde</p>

</div>

<div class="card" data-aos="zoom-in" data-aos-delay="100">

<h3>Secretary</h3>
<p>Name Here</p>

</div>

<div class="card" data-aos="zoom-in" data-aos-delay="200">

<h3>Treasurer</h3>
<p>Name Here</p>

</div>

<div class="card" data-aos="zoom-in" data-aos-delay="300">

<h3>Member</h3>
<p>Name Here</p>

</div>

</div>

</div>

</section>



<!-- ================= FACULTY ================= -->

<section class="section faculty-section">

<div class="container">

<div class="section-title" data-aos="fade-up">

<h2>Our Faculty</h2>
<p>Meet Our Dedicated Teaching Staff</p>

</div>



<?php if(count($groups)>0): ?>

<?php foreach($groups as $section=>$staffList): ?>

<h3 class="faculty-group-title" data-aos="fade-up">

<?= htmlspecialchars($section) ?>

</h3>


<div class="faculty-grid">


<?php foreach($staffList as $s): ?>

<div class="faculty-card" data-aos="zoom-in">


<img src="uploads/staff/<?= $s['image'] ?>" alt="">


<h3><?= htmlspecialchars($s['name']) ?></h3>

<p><?= htmlspecialchars($s['role']) ?></p>

<span><?= htmlspecialchars($s['qualification']) ?></span>


</div>

<?php endforeach; ?>


</div>


<?php endforeach; ?>

<?php else: ?>

<p style="text-align:center;color:#777">
No staff data available.
</p>

<?php endif; ?>


</div>

</section>



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



<!-- WHATSAPP -->

<a href="https://wa.me/91XXXXXXXXXX"
class="whatsapp-btn"
target="_blank">

<i class="fab fa-whatsapp"></i>

</a>


<!-- TOP -->

<button id="scrollTopBtn">↑</button>



<!-- SCRIPTS -->

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script src="assets/js/main.js"></script>


<script>

AOS.init({
  duration:1000,
  once:true
});

</script>


</body>
</html>
