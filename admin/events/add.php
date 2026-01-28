<?php
session_start();
include "../../includes/db.php";

if(!isset($_SESSION['admin_id'])){
  header("Location: ../login.php");
  exit();
}

if(isset($_POST['save'])){

 $title = mysqli_real_escape_string($conn,$_POST['title']);
$date  = $_POST['event_date'];
$desc  = mysqli_real_escape_string($conn,$_POST['description']);

/* Upload Image */
$imageName = "";

if(!empty($_FILES['image']['name'])){

    $imageName = time()."_".$_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../../public/uploads/events/".$imageName
    );
}

/* Insert with image */
mysqli_query($conn,
  "INSERT INTO events(title,event_date,description,image)
   VALUES('$title','$date','$desc','$imageName')"
);

header("Location: index.php");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Event</title>

<style>

body{
  font-family:Poppins,Arial;
  background:#f4f6f9;
  padding:30px;
}

.box{
  max-width:500px;
  margin:auto;
  background:white;
  padding:25px;
  border-radius:12px;
  box-shadow:0 5px 20px rgba(0,0,0,.1);
}

h2{
  text-align:center;
  margin-bottom:20px;
}

input,textarea,button{
  width:100%;
  padding:10px;
  margin:10px 0;
  border-radius:6px;
  border:1px solid #ccc;
}

textarea{
  min-height:120px;
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

</style>

</head>

<body>


<div class="box">

<h2>➕ Add Event</h2>


<form method="POST" enctype="multipart/form-data">


<input type="text"
       name="title"
       placeholder="Event Title"
       required>


<input type="date"
       name="event_date"
       required>


<textarea name="description"
          placeholder="Event Description"
          required></textarea>

          <label>Event Poster / Image</label>
<input type="file" name="image" accept="image/*">



<button name="save">Save Event</button>

</form>


<a href="index.php">← Back</a>

</div>


</body>
</html>
