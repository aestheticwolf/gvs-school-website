<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Admin Dashboard</title>

  <style>

body{
  font-family: 'Poppins', sans-serif;
  margin:0;
  background:#f5f7fb;
}

/* Header */

.header{
  background: linear-gradient(135deg,#143d7a,#4f8fd8);
  color:white;
  padding:18px;
  text-align:center;
  font-size:20px;
  font-weight:600;
}

/* Layout */

.container{
  display:flex;
}

/* Sidebar */

.sidebar{
  width:230px;
  background:#0f2f5f;
  min-height:100vh;
  padding-top:20px;
}

.sidebar a{
  display:flex;
  align-items:center;
  gap:10px;

  color:#fff;
  padding:14px 18px;
  text-decoration:none;
  font-size:14px;

  transition:0.3s;
}

.sidebar a:hover{
  background:#4f8fd8;
  padding-left:25px;
}

/* Content */

.content{
  padding:35px;
  width:100%;
}

/* Dashboard Cards */

.dashboard-cards{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:25px;
  margin-top:30px;
}

.card{
  background:#fff;
  padding:25px;
  border-radius:15px;

  box-shadow:0 8px 25px rgba(0,0,0,0.08);

  transition:0.3s;
}

.card:hover{
  transform:translateY(-6px);
}

.card h3{
  color:#143d7a;
  margin-bottom:8px;
}

.card p{
  color:#666;
  font-size:14px;
}

/* Make cards clickable */
.card{
  text-decoration:none;
  color:inherit;
  position:relative;
  overflow:hidden;
  cursor:pointer;
}

/* Fade in animation */
@keyframes fadeUp {
  from{
    opacity:0;
    transform:translateY(20px);
  }
  to{
    opacity:1;
    transform:translateY(0);
  }
}

.card{
  animation: fadeUp 0.6s ease forwards;
}

/* Delay animation for each card */
.card:nth-child(1){animation-delay:.1s;}
.card:nth-child(2){animation-delay:.2s;}
.card:nth-child(3){animation-delay:.3s;}
.card:nth-child(4){animation-delay:.4s;}
.card:nth-child(5){animation-delay:.5s;}
.card:nth-child(6){animation-delay:.6s;}
.card:nth-child(7){animation-delay:.7s;}
.card:nth-child(8){animation-delay:.8s;}

/* Hover glow effect */
.card::before{
  content:'';
  position:absolute;
  top:0;
  left:-100%;
  width:100%;
  height:100%;
  background:linear-gradient(
    120deg,
    transparent,
    rgba(79,143,216,0.2),
    transparent
  );
  transition:.6s;
}

.card:hover::before{
  left:100%;
}

/* Icon animation */
.card h3{
  transition:.3s;
}

.card:hover h3{
  transform:scale(1.05);
  color:#4f8fd8;
}

/* Main layout border */
.content{
  background:white;
  border-radius:12px;
  box-shadow:0 10px 30px rgba(0,0,0,0.08);
  margin:20px;
}

/* Sidebar border */
.sidebar{
  border-right:2px solid rgba(255,255,255,0.1);
}

/* Header shadow */
.header{
  box-shadow:0 4px 15px rgba(0,0,0,0.15);
}

/* Logout hover */
.sidebar a:last-child:hover{
  background:#c0392b;
  color:white;
}


</style>

</head>

<body>

<!-- Header -->
<div class="header">
  <h2>Admin Panel</h2>
</div>

<div class="container">

  <!-- Sidebar -->
  <div class="sidebar">

    <h3 style="color:white;text-align:center;margin-bottom:20px;">
      👨‍💼 Admin
    </h3>

    <a href="dashboard.php">📊 Dashboard</a>
    <a href="pages/">🏠 Home Page</a>
    <a href="blogs/index.php">📰 Blogs</a>
    <a href="gallery/">🖼️ Gallery</a>
    <a href="curriculum/">📚 Curriculum</a>
    <a href="staff/">👩‍🏫 Staff</a>
    <a href="events/">📅 Events</a>
    <a href="pages/">📄 Pages</a>
    <a href="about/">ℹ️ About Page</a>


    <hr style="border:1px solid rgba(255,255,255,0.2);margin:15px;">

    <!-- Logout -->
    <a href="logout.php" style="color:#ffb3b3;">🚪 Logout</a>

  </div>


  <!-- Main Content -->
  <div class="content">

    <h2>Welcome, <?php echo $_SESSION['admin_user']; ?> 👋</h2>
    <p>Manage your website from here.</p>


    <!-- Cards -->
    <div class="dashboard-cards">

      <a href="pages/" class="card">
        <h3>🏠 Home Page</h3>
        <p>Edit home content</p>
      </a>

      <a href="blogs/index.php" class="card">
        <h3>📰 Blogs</h3>
        <p>Manage articles</p>
      </a>

      <a href="gallery/" class="card">
        <h3>🖼️ Gallery</h3>
        <p>Upload photos</p>
      </a>

      <a href="curriculum/" class="card">
        <h3>📚 Curriculum</h3>
        <p>Manage courses</p>
      </a>

         <a href="staff/" class="card">
        <h3>👩‍🏫 Staff</h3>
        <p>Manage teachers</p>
      </a>

      <a href="events/" class="card">
        <h3>📅 Events</h3>
        <p>Manage events</p>
      </a>
        
     
      <a href="about/" class="card">
      <h3>ℹ️ About Pages</h3>
        <p>Edit about page</p>
      </a>

      <a href="#" class="card">
        <h3>⚙️ Settings</h3>
        <p>Website settings</p>
      </a>

    </div>

  </div>

</div>

</body>


</html>