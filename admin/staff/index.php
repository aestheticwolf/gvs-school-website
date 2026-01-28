<?php
session_start();
include "../../includes/db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: ../login.php");
    exit();
}

/* Add Staff */
if(isset($_POST['add'])){

    $name = $_POST['name'];
    $role = $_POST['role'];
    $qual = $_POST['qualification'];
    $section = $_POST['section'];

    $img = "";

    if(!empty($_FILES['image']['name'])){

        $img = time()."_".$_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../../public/uploads/staff/".$img
        );
    }

    mysqli_query($conn,"
      INSERT INTO staff(name,role,qualification,image,section)
      VALUES('$name','$role','$qual','$img','$section')
    ");

    header("Location: index.php");
    exit();
}


/* Delete */
if(isset($_GET['del'])){

    $id = intval($_GET['del']);

    $res = mysqli_query($conn,
      "SELECT image FROM staff WHERE id=$id"
    );

    if($r=mysqli_fetch_assoc($res)){
        if($r['image']){
            unlink("../../public/uploads/staff/".$r['image']);
        }
    }

    mysqli_query($conn,"DELETE FROM staff WHERE id=$id");

    header("Location: index.php");
    exit();
}


/* Fetch */
$result = mysqli_query($conn,
  "SELECT * FROM staff ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>

<title>Staff Manager</title>

<style>

body{
  font-family:Poppins,Arial;
  background:#f5f7fb;
  padding:25px;
}

h2{color:#143d7a}

/* Card */

.card{
  background:white;
  padding:25px;
  border-radius:15px;
  box-shadow:0 8px 25px rgba(0,0,0,.08);
  margin-bottom:25px;

  animation:fade .6s;
}

@keyframes fade{
  from{opacity:0;transform:translateY(20px)}
  to{opacity:1}
}

/* Inputs */

input,select,button{
  width:100%;
  padding:10px;
  margin:6px 0;
  border-radius:6px;
  border:1px solid #ccc;
}

button{
  background:#143d7a;
  color:white;
  border:none;
  cursor:pointer;
}

button:hover{
  background:#4f8fd8;
}

/* Grid */

.grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:20px;
}

/* Staff Card */

.staff-card{
  background:white;
  border-radius:15px;
  overflow:hidden;
  box-shadow:0 5px 15px rgba(0,0,0,.1);
  text-align:center;

  transition:.3s;
}

.staff-card:hover{
  transform:translateY(-5px);
}

.staff-card img{
  width:100%;
  height:200px;
  object-fit:cover;
}

.staff-card h4{
  margin:10px 0 3px;
}

.staff-card span{
  color:#666;
  font-size:13px;
}

.del{
  display:block;
  padding:8px;
  background:red;
  color:white;
  text-decoration:none;
  margin-top:8px;
}

</style>
</head>

<body>

<h2>Staff Management</h2>

<a href="../dashboard.php">← Back</a>


<!-- ADD -->

<div class="card">

<h3>Add New Staff</h3>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="name" placeholder="Name" required>

<input type="text" name="role" placeholder="Role" required>

<input type="text" name="qualification" placeholder="Qualification" required>

<select name="section" required>

<option>Pre-Primary</option>
<option>Primary</option>
<option>High School</option>
<option>Attendant (Primary)</option>
<option>Attendant (Pre-Primary)</option>

</select>

<input type="file" name="image">

<button name="add">Add Staff</button>

</form>

</div>


<!-- LIST -->

<div class="grid">

<?php while($s=mysqli_fetch_assoc($result)): ?>

<div class="staff-card">

<img src="../../public/uploads/staff/<?= $s['image'] ?>">

<h4><?= $s['name'] ?></h4>

<p><?= $s['role'] ?></p>

<span><?= $s['qualification'] ?></span><br>

<small><?= $s['section'] ?></small>

<a class="del"
   href="?del=<?= $s['id'] ?>"
   onclick="return confirm('Delete staff?')">
Delete
</a>

</div>

<?php endwhile; ?>

</div>

</body>
</html>
