<?php
session_start();
include "../../includes/db.php";

/* Check Login */
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

/* Upload Image */
if (isset($_POST['upload'])) {

    $event = mysqli_real_escape_string($conn, $_POST['event_name']);

    $file = $_FILES['image'];

    $name = $file['name'];
    $tmp  = $file['tmp_name'];
    $size = $file['size'];

    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    $allowed = ['jpg','jpeg','png','webp'];

    if (!in_array($ext, $allowed)) {
        $msg = "❌ Only JPG, PNG, WEBP allowed!";
    }
    elseif ($size > 10 * 1024 * 1024) {
        $msg = "❌ Image must be below 10MB!";
    }
    else {

        $newName = time() . "_" . $name;

        $path = "../../public/uploads/gallery/" . $newName;

        if (move_uploaded_file($tmp, $path)) {

            mysqli_query($conn,
                "INSERT INTO gallery(event_name,image)
                 VALUES('$event','$newName')"
            );

            $msg = "✅ Image uploaded successfully!";
        }
    }
}

/* Delete Image */
if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $res = mysqli_query($conn,
        "SELECT image FROM gallery WHERE id=$id"
    );

    if ($row = mysqli_fetch_assoc($res)) {

        if(file_exists("../../public/uploads/gallery/".$row['image'])){
            unlink("../../public/uploads/gallery/".$row['image']);
        }

        mysqli_query($conn,
            "DELETE FROM gallery WHERE id=$id"
        );
    }

    header("Location: index.php");
    exit();
}

/* Fetch Images */
$result = mysqli_query($conn,
    "SELECT * FROM gallery ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>

<title>Gallery Manager</title>

<style>

/* Base */

body{
  font-family:'Poppins',Arial,sans-serif;
  background:#f5f7fb;
  margin:0;
}

/* Header */

.header{
  background:linear-gradient(135deg,#143d7a,#4f8fd8);
  color:white;
  padding:18px;
  text-align:center;
  font-size:20px;
  box-shadow:0 4px 15px rgba(0,0,0,0.15);
}

/* Page */

.page{
  max-width:1200px;
  margin:25px auto;
  padding:20px;
}

/* Upload Box */

.upload-box{
  background:white;
  padding:25px;
  border-radius:15px;
  box-shadow:0 8px 25px rgba(0,0,0,0.08);
  margin-bottom:25px;

  animation:fadeUp .7s ease;
}

/* Inputs */

label{
  font-weight:500;
  display:block;
  margin-top:10px;
}

input{
  width:100%;
  padding:12px;
  margin:6px 0 12px;
  border:1px solid #ccc;
  border-radius:8px;
}

input:focus{
  outline:none;
  border-color:#4f8fd8;
}

/* Button */

button{
  padding:12px 25px;
  background:#143d7a;
  color:white;
  border:none;
  border-radius:8px;
  cursor:pointer;
  transition:.3s;
}

button:hover{
  background:#4f8fd8;
  transform:scale(1.05);
}

/* Preview */

.preview{
  display:none;
  margin-bottom:12px;
}

.preview img{
  max-width:220px;
  border-radius:10px;
  box-shadow:0 4px 15px rgba(0,0,0,0.2);
}

/* Grid */

.grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
  gap:25px;
}

/* Card */

.card{
  background:white;
  border-radius:15px;
  overflow:hidden;
  box-shadow:0 6px 20px rgba(0,0,0,0.08);
  transition:.3s;
  position:relative;

  animation:fadeUp .7s ease;
}

.card:hover{
  transform:translateY(-8px);
  box-shadow:0 15px 35px rgba(0,0,0,0.15);
}

/* Image */

.card img{
  width:100%;
  height:180px;
  object-fit:cover;
}

/* Info */

.card-body{
  padding:15px;
  text-align:center;
}

.card-body h4{
  margin:0 0 8px;
  color:#143d7a;
  font-size:15px;
}

/* Delete */

.delete-btn{
  display:inline-block;
  margin-top:5px;
  color:#dc3545;
  font-size:13px;
  text-decoration:none;
  font-weight:500;
}

.delete-btn:hover{
  text-decoration:underline;
}

/* Message */

.msg{
  padding:10px;
  border-radius:8px;
  margin-bottom:15px;
  background:#eafaf1;
  color:#155724;
  font-weight:500;
}

/* Back */

.back{
  display:inline-block;
  margin-bottom:15px;
  color:#143d7a;
  text-decoration:none;
  font-weight:500;
}

.back:hover{
  text-decoration:underline;
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
  transition:.3s;
  cursor:pointer;
}

.btn:hover{
  background:#4f8fd8;
}

.btn-danger{
  background:#e74c3c;
}

.btn-danger:hover{
  background:#c0392b;
}

/* Animation */

@keyframes fadeUp{
  from{
    opacity:0;
    transform:translateY(20px);
  }
  to{
    opacity:1;
    transform:translateY(0);
  }
}

</style>

</head>

<body>

<div class="header">
  Gallery Manager
</div>


<div class="page">

<a href="../dashboard.php" class="btn">
← Back to Dashboard
</a>


<!-- Upload Box -->

<div class="upload-box">

<?php if(isset($msg)): ?>
<div class="msg"><?= $msg ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<label>Event / Album Name</label>

<input type="text"
       name="event_name"
       placeholder="Eg: Annual Day 2026"
       required>


<label>Select Image</label>

<input type="file"
       name="image"
       accept="image/*"
       onchange="previewImage(event)"
       required>


<div class="preview" id="previewBox">
  <img id="previewImg">
</div>


<button type="submit" name="upload">
Upload Image
</button>

</form>

</div>


<!-- Gallery Grid -->

<div class="grid">

<?php while($row = mysqli_fetch_assoc($result)): ?>

<div class="card">

<img src="../../public/uploads/gallery/<?= $row['image'] ?>">

<div class="card-body">

<h4><?= htmlspecialchars($row['event_name']) ?></h4>

<a href="?delete=<?= $row['id'] ?>"
   class="delete-btn"
   onclick="return confirm('Delete this image?')">
Delete
</a>

</div>

</div>

<?php endwhile; ?>

<?php if(mysqli_num_rows($result)==0): ?>

<p>No images uploaded yet.</p>

<?php endif; ?>

</div>


</div>


<script>

/* Preview */

function previewImage(e){

  const file = e.target.files[0];

  if(!file) return;

  const reader = new FileReader();

  reader.onload = function(){

    document.getElementById('previewImg').src = reader.result;

    document.getElementById('previewBox').style.display="block";

  };

  reader.readAsDataURL(file);

}

</script>

</body>
</html>
