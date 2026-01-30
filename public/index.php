<?php
include __DIR__ . "/../includes/db.php";


/* Home Content */
$res = mysqli_query($conn,"SELECT * FROM home_content LIMIT 1");
$home = mysqli_fetch_assoc($res);

/* Latest Events */
$events = mysqli_query($conn,
"SELECT * FROM events ORDER BY event_date DESC LIMIT 3"
);
?>




<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>GVS School | Home</title>

<link rel="stylesheet" href="assets/css/style.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet"
 href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

 <style>
@media (max-width:768px){
  .hero-new{
    height:45vh !important;
    min-height:280px !important;
  }
}
</style>


</head>

<body>

<!-- SCROLL BAR -->
<div id="progress-bar"></div>


<!-- HEADER -->

<header class="header-main">

  <div class="container header-inner">


    <!-- Logo -->

    <div class="logo-box">

      <img src="assets/images/logo.png" alt="GVS Logo">

      <div class="logo-text">

        <span class="school-name">GVS School</span>

        <small>Sankhali, Goa</small>

      </div>

    </div>


    <!-- Menu -->

    <nav class="nav-menu">

      <a href="index.php" class="nav-link active">Home</a>
      <a href="about.php" class="nav-link">About</a>
      <a href="curriculum.php" class="nav-link">Curriculum</a>
      <a href="gallery.php" class="nav-link">Gallery</a>
      <a href="events.php" class="nav-link">Events</a>
      <a href="blog.php" class="nav-link">Blogs</a>

    </nav>


  </div>

</header>



<!-- HERO -->

<section class="hero-new"
style="
height:60vh;
min-height:420px;
max-height:650px;
background-size:cover;
background-position:center;
background-repeat:no-repeat;
margin-top:80px;
">


  <div class="hero-overlay"></div>

  <div class="container">

    <div class="hero-box" data-aos="fade-up">
    <span class="hero-managed">
<?= $home['hero_managed'] ?>
</span>


      <!-- <span class="hero-managed">
        Managed by Gopalkrishna Vidhyaprasarak Saunstha
      </span> -->

      

   <h1 class="hero-main">
<?= $home['hero_title'] ?>
</h1>



      <!-- <h1 class="hero-main">
        Gopalkrishna Vidhyaprasarak Saunstha
      </h1> -->

      <h2 class="hero-sub">
<?= $home['hero_subtitle'] ?>
</h2>



      <!-- <h2 class="hero-sub">
        GVS School, Sankhali – Goa
      </h2> -->


      <p class="hero-tagline">
<?= $home['hero_tagline'] ?>
</p>







      </div>

    </div>

  </div>

</section>




<!-- MESSAGE -->

<section class="section events">

  <div class="container">

    <div class="section-title" data-aos="fade-up">
      <h2>Thought of the Day</h2>
    </div>

    <div class="thought-box" data-aos="fade-up">

  <i class="fas fa-quote-left"></i>

  <p class="thought-text">
    <?= nl2br($home['thought_of_day']) ?>
  </p>

  <span class="thought-author">
    – GVS School
  </span>

</div>



  </div>
</section>




<!-- HISTORY -->

<section class="section history">

  <div class="container">

    <div class="section-title" data-aos="fade-up">
      <h2>Saunstha Introduction</h2>
      <p>Our Journey & Growth</p>
    </div>


    <div class="intro-text" data-aos="fade-up">



    <p><?= $home['intro_line1'] ?></p>
<p><?= $home['intro_line2'] ?></p>


      <!-- <p>
        GVS School is committed to quality education and moral values.
      </p>

      <p>
        We promote academics, sports, culture and social responsibility.
      </p> -->

    </div>


    <div class="timeline">


      <div class="timeline-item" data-aos="fade-right">
        <h3>2006 – Foundation</h3>
        <p>Started with nursery and pre-primary.</p>
      </div>

      <div class="timeline-item" data-aos="fade-left">
        <h3>Early Growth</h3>
        <p>LKG and UKG introduced.</p>
      </div>

      <div class="timeline-item" data-aos="fade-right">
        <h3>2011 – Registration</h3>
        <p>Primary section started.</p>
      </div>

      <div class="timeline-item" data-aos="fade-left">
        <h3>2012–2014 – Expansion</h3>
        <p>Expanded till STD IV.</p>
      </div>

      <div class="timeline-item" data-aos="fade-right">
        <h3>Achievements</h3>
        <p>Multiple awards won.</p>
      </div>

      <div class="timeline-item" data-aos="fade-left">
        <h3>2020–21 – Secondary</h3>
        <p>Secondary English medium started.</p>
      </div>

      <div class="timeline-item" data-aos="fade-up">
        <h3>Present & Future</h3>
        <p>Growing towards STD X.</p>
      </div>


    </div>

  </div>

</section>


<!-- HOME EVENTS -->

<section class="section events home-events">

<div class="container">

<div class="section-title" data-aos="fade-up">

<h2>Latest Events</h2>

<p>Our Recent Activities</p>

</div>


<div class="event-grid">


<?php if(mysqli_num_rows($events)>0): ?>


<?php while($row=mysqli_fetch_assoc($events)): ?>


<div class="event-card" data-aos="zoom-in">

<?php if(!empty($row['image'])): ?>
  <img src="uploads/events/<?= $row['image'] ?>" class="event-img">
<?php else: ?>
  <img src="assets/images/default-event.jpg" class="event-img">
<?php endif; ?>

<div class="event-content">

  <span class="event-date">
    <?= date("d M Y",strtotime($row['event_date'])) ?>
  </span>

  <h3><?= htmlspecialchars($row['title']) ?></h3>

  <p>
    <?= substr(strip_tags($row['description']),0,120) ?>...
  </p>

</div>

</div>



<?php endwhile; ?>


<?php else: ?>


<p style="text-align:center;width:100%;color:#777;">
No upcoming events.
</p>


<?php endif; ?>


</div>


<div style="text-align:center;margin-top:30px;">

<a href="events.php" class="btn-main">

View All Events

</a>

</div>


</div>

</section>



<!-- FACEBOOK LIVE -->

<section class="section live-campus">

  <div class="container">

    <div class="section-title" data-aos="fade-up">
      <!-- <h2>Live From Campus</h2>
      <p>Watch our latest activities and events</p> -->

      <h2><?= $home['fb_title'] ?></h2>
<p><?= $home['fb_subtitle'] ?></p>

    </div>

    <div class="fb-wrapper" data-aos="zoom-in">

      <iframe
        src="https://www.facebook.com/plugins/page.php?href=https://www.facebook.com/gopalkrishnaschool/&tabs=timeline&width=900&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=false"
        scrolling="no"
        frameborder="0"
        allowfullscreen="true"
        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
      </iframe>

    </div>

  </div>

</section>





<!-- SOCIAL -->

<section class="section events">

  <div class="container">

    <div class="section-title" data-aos="fade-up">
      <h2>Connect With Us</h2>
    </div>

    <div class="social-box" data-aos="fade-up">

    <a href="<?= $home['facebook_link'] ?>" target="_blank" class="social-btn fb">
  Facebook
</a>

<a href="<?= $home['instagram_link'] ?>" target="_blank" class="social-btn ig">
  Instagram
</a>


    </div>

  </div>

</section>





<!-- FOOTER -->

<footer class="footer">

  <div class="container footer-grid">


    <div class="footer-col">

      <h3>GVS School</h3>

      <p>
        Providing quality education since 2006.
      </p>

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

<script>
document.addEventListener("DOMContentLoaded", function () {

const hero = document.querySelector('.hero-new');

const images = [

<?php if($home['hero_img1']){ ?>
"assets/images/<?= $home['hero_img1'] ?>",
<?php } ?>

<?php if($home['hero_img2']){ ?>
"assets/images/<?= $home['hero_img2'] ?>",
<?php } ?>

<?php if($home['hero_img3']){ ?>
"assets/images/<?= $home['hero_img3'] ?>",
<?php } ?>

];

let i = 0;

if(images.length > 0){

hero.style.backgroundImage = "url(" + images[0] + ")";

setInterval(()=>{

i++;

if(i >= images.length){
i = 0;
}

hero.style.backgroundImage = "url(" + images[i] + ")";

},4000);

}

});
</script>


</body>


</html>
