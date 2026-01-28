<?php
include '../includes/db.php';

if (!isset($_GET['id'])) {
  header("Location: blog.php");
  exit();
}

$id = intval($_GET['id']);

$query = "SELECT * FROM blogs WHERE id = $id AND status = 'Published'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
  echo "Blog not found.";
  exit();
}

$blog = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo $blog['title']; ?> | GVS School</title>

<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

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
      <a href="blog.php" class="nav-link active">Blogs</a>
    </nav>

  </div>
</header>


<section class="section">

  <div class="container blog-single">

    <h1><?php echo $blog['title']; ?></h1>

    <div class="blog-single-meta">
      <span>
        <i class="fa fa-user"></i>
        <?php echo $blog['author']; ?>
      </span>

      <span>
        <i class="fa fa-calendar"></i>
        <?php echo date("M d, Y", strtotime($blog['created_at'])); ?>
      </span>
    </div>

    <?php if(!empty($blog['image'])): ?>
      <img 
       src="uploads/blogs/<?php echo $blog['image']; ?>"
      class="blog-single-img"
        alt="<?php echo $blog['title']; ?>"
      >
    <?php endif; ?>

    <p>
      <?php echo nl2br($blog['content']); ?>
    </p>

    <a href="blog.php" class="btn">← Back to Blogs</a>

  </div>

</section>


<footer class="footer">

  <div class="footer-bottom">
    © 2026 GVS School
  </div>

</footer>

</body>
</html>
