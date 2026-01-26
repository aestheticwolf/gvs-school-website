<?php
include '../includes/db.php';

$query = "SELECT * FROM blogs WHERE status='Published' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Blogs | GVS School</title>

  <!-- Main CSS -->
  <link rel="stylesheet" href="assets/css/style.css">

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Font Awesome -->
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
      <a href="index.html" class="nav-link">Home</a>
      <a href="about.html" class="nav-link">About</a>
      <a href="curriculum.html" class="nav-link">Curriculum</a>
      <a href="gallery.html" class="nav-link">Gallery</a>
      <a href="blog.php" class="nav-link active">Blogs</a>
    </nav>

  </div>
</header>


<!-- PAGE HERO -->

<section class="page-hero">
  <div class="container" data-aos="fade-up">
    <h1>Our Blogs</h1>
    <p>Insights • Activities • Achievements • Education</p>
  </div>
</section>


<!-- BLOG SECTION -->

<section class="section blog-section">

  <div class="container">

    <div class="section-title" data-aos="fade-up">
      <h2>Latest Articles</h2>
      <p>Stay updated with school activities</p>
    </div>


  <div class="blog-grid">

<?php if(mysqli_num_rows($result) > 0): ?>

  <?php while($row = mysqli_fetch_assoc($result)): ?>

    <a href="blog-single.php?id=<?php echo $row['id']; ?>" class="blog-link">

      <div class="blog-card" data-aos="fade-up">

        <div class="blog-img">

<?php if(!empty($row['image'])): ?>
    <img src="uploads/blogs/<?php echo $row['image']; ?>" 
         alt="<?php echo $row['title']; ?>">
<?php else: ?>
    <img src="assets/images/default-blog.jpg" 
         alt="Default Image">
<?php endif; ?>

</div>     

        <div class="blog-content">

          <div class="blog-meta">
            <span>
              <i class="fa-solid fa-user"></i>
              <?php echo $row['author']; ?>
            </span>

            <span>
              <i class="fa-solid fa-calendar"></i>
              <?php echo date("M d, Y", strtotime($row['created_at'])); ?>
            </span>
          </div>

          <h3><?php echo $row['title']; ?></h3>

          <p>
            <?php echo substr($row['content'], 0, 120); ?>...
          </p>

          <span class="blog-btn">
            Read More <i class="fa-solid fa-arrow-right"></i>
          </span>

        </div>

      </div>

    </a>

  <?php endwhile; ?>

<?php else: ?>

  <p>No blogs found.</p>

<?php endif; ?>

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
        <li><a href="index.html">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="curriculum.html">Curriculum</a></li>
        <li><a href="gallery.html">Gallery</a></li>
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



<!-- Floating Buttons -->

<a href="https://wa.me/91XXXXXXXXXX"
   class="whatsapp-btn"
   target="_blank">
  <i class="fab fa-whatsapp"></i>
</a>

<button id="scrollTopBtn">
  <i class="fas fa-arrow-up"></i>
</button>



<!-- Scripts -->

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="assets/js/main.js"></script>

<script>
AOS.init({
  duration: 800,
  once: true,
  mirror: false,
  offset: 120,
  easing: 'ease-in-out'
});
</script>

</body>
</html>
