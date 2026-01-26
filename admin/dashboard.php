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
            font-family: Arial;
            margin:0;
            background:#f4f6f9;
        }

        .header{
            background:#343a40;
            color:white;
            padding:15px;
            text-align:center;
        }

        .container{
            display:flex;
        }

        .sidebar{
            width:220px;
            background:#222;
            min-height:100vh;
            padding-top:20px;
        }

        .sidebar a{
            display:block;
            color:white;
            padding:12px;
            text-decoration:none;
        }

        .sidebar a:hover{
            background:#007bff;
        }

        .content{
            padding:25px;
            width:100%;
        }
    </style>
</head>

<body>

<div class="header">
    <h2>Admin Panel</h2>
</div>

<div class="container">

    <div class="sidebar">

        <a href="dashboard.php">Dashboard</a>
        <a href="blogs/index.php">Manage Blogs</a>
        <a href="../pages/">Pages</a>
        <a href="../gallery/">Gallery</a>
        <a href="../staff/">Staff</a>
        <a href="../events/">Events</a>
        <a href="../curriculum/">Curriculum</a>

        <hr style="border:1px solid #444;">

        <a href="logout.php">Logout</a>

    </div>

    <div class="content">

        <h3>Welcome, <?php echo $_SESSION['admin_user']; ?></h3>

        <p>Select an option from the menu.</p>

        <p>Your admin panel is ready.</p>

    </div>

</div>

</body>
</html>
