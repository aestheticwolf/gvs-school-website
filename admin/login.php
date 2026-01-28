<?php
session_start();
require_once "../includes/db.php";

$error = "";

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == "" || $password == "") {
        $error = "All fields are required";
    } else {

        $sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $admin = $result->fetch_assoc();

            if (password_verify($password, $admin['password'])) {

                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_user'] = $admin['username'];

                header("Location: dashboard.php");
                exit();

            } else {
                $error = "Invalid password";
            }

        } else {
            $error = "User not found";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Login | GVS School</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* RESET */
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family: "Poppins", Arial, sans-serif;
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

/* BACKGROUND ANIMATION */

@keyframes bgMove{
  0%{background-position:0% 50%;}
  50%{background-position:100% 50%;}
  100%{background-position:0% 50%;}
}

/* LOGIN CARD */

.login-box{
  width:360px;
  background:rgba(255,255,255,0.95);
  padding:35px 30px;
  border-radius:16px;
  box-shadow:0 15px 40px rgba(0,0,0,.25);
  text-align:center;
  animation:fadeIn .8s ease;
}

/* FADE ANIMATION */

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

/* TITLE */

.login-box h2{
  margin-bottom:25px;
  color:#143d7a;
  font-weight:600;
}

/* INPUT BOX */

.input-box{
  position:relative;
  margin:20px 0;
}

.input-box input{
  width:100%;
  padding:12px 40px 12px 12px;
  border:1px solid #ccc;
  border-radius:8px;
  font-size:15px;
  outline:none;
  transition:.3s;
}

.input-box input:focus{
  border-color:#143d7a;
  box-shadow:0 0 0 2px rgba(20,61,122,.1);
}

/* ICON */

.input-box i{
  position:absolute;
  right:12px;
  top:50%;
  transform:translateY(-50%);
  color:#777;
}

/* BUTTON */

button{
  width:100%;
  padding:12px;
  background:#143d7a;
  color:white;
  border:none;
  border-radius:8px;
  font-size:15px;
  font-weight:500;
  cursor:pointer;
  transition:.3s;
  margin-top:10px;
}

button:hover{
  background:#4f8fd8;
  transform:translateY(-2px);
  box-shadow:0 6px 15px rgba(0,0,0,.2);
}

/* ERROR */

.error{
  background:#ffe6e6;
  color:#c00;
  padding:8px;
  border-radius:6px;
  margin-bottom:15px;
  font-size:14px;
}

/* FOOTER TEXT */

.login-footer{
  margin-top:18px;
  font-size:13px;
  color:#666;
}

</style>
</head>

<body>

<div class="login-box">

  <h2>
    <i class="fa-solid fa-user-shield"></i>
    Admin Login
  </h2>

  <?php if($error!=""){ ?>
    <div class="error"><?= $error ?></div>
  <?php } ?>

  <form method="POST">

    <div class="input-box">
      <input type="text"
             name="username"
             placeholder="Username"
             required>
      <i class="fa-solid fa-user"></i>
    </div>

    <div class="input-box">
      <input type="password"
             name="password"
             placeholder="Password"
             required>
      <i class="fa-solid fa-lock"></i>
    </div>

    <button type="submit" name="login">
      Login
    </button>

  </form>

  <div class="login-footer">
    © <?= date("Y") ?> GVS School Admin Panel
  </div>

</div>

</body>
</html>
