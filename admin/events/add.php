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

      $uploadDir = "../../public/uploads/events/";

      if(!is_dir($uploadDir)){
          mkdir($uploadDir,0755,true);
      }

      $imageName = time()."_".$_FILES['image']['name'];

      move_uploaded_file(
          $_FILES['image']['tmp_name'],
          $uploadDir.$imageName
      );
  }

  /* Insert */
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

<script src="https://cdn.tiny.cloud/1/pk37h5rjaeflhgojvtcu8n79yne8sof1yl6hxd0xk4mqc57j/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

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

/* Buttons */

.btn{
  padding:10px 16px;
  border:none;
  border-radius:8px;
  background:#143d7a;
  color:white;
  text-decoration:none;
  font-size:14px;
}

.btn:hover{
  background:#4f8fd8;
}

</style>

</head>

<body>


<div class="box">

<h2>➕ Add Event</h2>


<form method="POST" enctype="multipart/form-data" id="eventForm">


<input type="text"
       name="title"
       placeholder="Event Title"
       required>


<input type="date"
       name="event_date"
       required>


<textarea name="description"
          id="editor"
          placeholder="Event Description"></textarea>


<label>Event Poster / Image</label>
<input type="file" name="image" accept="image/*">


<button name="save">Save Event</button>

</form>

<br>

<a href="index.php" class="btn">← Back</a>

</div>


<!-- TinyMCE -->
<script>
tinymce.init({
  selector: '#editor',
  height: 200
});
</script>


<!-- Validation -->
<script>
document.getElementById("eventForm").addEventListener("submit", function(e){

  if(tinymce.get("editor").getContent().trim() === ""){
    alert("Please enter event description");
    e.preventDefault();
  }

});
</script>

</body>
</html>
