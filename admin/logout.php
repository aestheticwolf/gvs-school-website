<?php
session_start();

/* If not logged in */
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

/* Logout action */
if(isset($_POST['logout'])){

    session_unset();
    session_destroy();

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Logout | GVS School</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* RESET */

*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:Poppins,Arial,sans-serif;
}

/* BODY BACKGROUND */

body{
  height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  background: linear-gradient(270deg,#143d7a,#4f8fd8,#143d7a);
  background-size:600% 600%;
  animation:bgMove 12s ease infinite;
}

/* BG ANIMATION */

@keyframes bgMove{
  0%{background-position:0% 50%;}
  50%{background-position:100% 50%;}
  100%{background-position:0% 50%;}
}

/* CARD */

.logout-box{
  width:380px;
  background:rgba(255,255,255,.95);
  padding:35px 30px;
  border-radius:16px;
  box-shadow:0 15px 40px rgba(0,0,0,.25);
  text-align:center;
  animation:fadeIn .7s ease;
}

/* FADE */

@keyframes fadeIn{
  from{
    opacity:0;
    transform:translateY(30px);
  }
  to{
    opacity:1;
    transform:translateY(0);
  }
}

/* ICON */

.logout-icon{
  font-size:55px;
  color:#143d7a;
  margin-bottom:15px;
  animation:pulse 2s infinite;
}

@keyframes pulse{
  0%{transform:scale(1);}
  50%{transform:scale(1.08);}
  100%{transform:scale(1);}
}

/* TITLE */

.logout-box h2{
  color:#143d7a;
  margin-bottom:10px;
}

/* TEXT */

.logout-box p{
  color:#555;
  font-size:15px;
  margin-bottom:25px;
}

/* BUTTONS */

.btn-group{
  display:flex;
  gap:15px;
}

.btn{
  flex:1;
  padding:11px;
  border:none;
  border-radius:8px;
  font-size:14px;
  cursor:pointer;
  transition:.3s;
}

/* LOGOUT BTN */

.btn-logout{
  background:#d63031;
  color:white;
}

.btn-logout:hover{
  background:#ff5252;
  transform:translateY(-2px);
  box-shadow:0 6px 15px rgba(0,0,0,.2);
}

/* CANCEL */

.btn-cancel{
  background:#143d7a;
  color:white;
}

.btn-cancel:hover{
  background:#4f8fd8;
  transform:translateY(-2px);
  box-shadow:0 6px 15px rgba(0,0,0,.2);
}

/* FOOTER */

.logout-footer{
  margin-top:20px;
  font-size:13px;
  color:#777;
}

</style>

</head>

<body>


<div class="logout-box">

  <div class="logout-icon">
    <i class="fa-solid fa-right-from-bracket"></i>
  </div>

  <h2>Logout</h2>

  <p>
    Are you sure you want to logout from Admin Panel?
  </p>

  <form method="POST">

    <div class="btn-group">

      <button type="submit"
              name="logout"
              class="btn btn-logout">
        Logout
      </button>

      <a href="dashboard.php"
         class="btn btn-cancel"
         style="text-decoration:none;line-height:40px;">
        Cancel
      </a>

    </div>

  </form>

  <div class="logout-footer">
    © <?= date("Y") ?> GVS School Admin
  </div>

</div>


</body>
</html>
