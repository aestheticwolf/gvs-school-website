<?php
session_start();
include "../../includes/db.php";

/* Check Login */
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

/* Check ID */
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

/* Fetch Blog */
$sql = "SELECT * FROM blogs WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Blog not found";
    exit();
}

$blog = mysqli_fetch_assoc($result);

/* Author */
$author = $_SESSION['admin_user'] ?? "Admin";


/* Update Blog */
if (isset($_POST['update'])) {

    $title   = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $status  = $_POST['status'];

    /* Image */
    $imageName = $blog['image'];

    if (!empty($_FILES['image']['name'])) {

        $imageName = time() . "_" . $_FILES['image']['name'];

        $tmpName = $_FILES['image']['tmp_name'];

        $uploadPath = "../../public/uploads/blogs/" . $imageName;

        move_uploaded_file($tmpName, $uploadPath);
    }

    /* Update Query */
    $query = "UPDATE blogs SET
              title='$title',
              content='$content',
              image='$imageName',
              author='$author',
              status='$status'
              WHERE id=$id";

    mysqli_query($conn, $query);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Blog</title>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>


<style>

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
}

/* Container */

.page{
  max-width:900px;
  margin:30px auto;
  padding:20px;
}

/* Form Box */

.box{
  background:white;
  padding:30px;
  border-radius:15px;
  box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

/* Inputs */

input,textarea,select{
  width:100%;
  padding:12px;
  margin:8px 0;
  border:1px solid #ccc;
  border-radius:8px;
}

input:focus,
textarea:focus,
select:focus{
  outline:none;
  border-color:#4f8fd8;
}

/* Button */

button{
  padding:12px 22px;
  background:#143d7a;
  color:white;
  border:none;
  border-radius:8px;
  cursor:pointer;
}

button:hover{
  background:#4f8fd8;
}

/* Image */

.preview{
  margin:15px 0;
}

.preview img{
  max-width:220px;
  border-radius:10px;
  box-shadow:0 4px 15px rgba(0,0,0,0.2);
}

/* Back */

.back{
  display:inline-block;
  margin-top:15px;
  color:#143d7a;
  text-decoration:none;
}

</style>

</head>

<body>

<div class="header">
  Edit Blog
</div>

<div class="page">

<div class="box">

<form method="POST" enctype="multipart/form-data">

<label>Title</label>

<input type="text" name="title"
       value="<?= htmlspecialchars($blog['title']); ?>"
       required>


<label>Content</label>

<textarea name="content" id="editor" required>
<?= htmlspecialchars($blog['content']); ?>
</textarea>


<div class="preview">

<p>Current Image:</p>

<?php if(!empty($blog['image'])): ?>

<img src="../../public/uploads/blogs/<?= $blog['image']; ?>">

<?php else: ?>

<p>No image uploaded</p>

<?php endif; ?>

</div>


<label>Change Image</label>

<input type="file" name="image">


<label>Status</label>

<select name="status">

<option value="Draft"
<?php if($blog['status']=="Draft") echo "selected"; ?>>
Draft
</option>

<option value="Published"
<?php if($blog['status']=="Published") echo "selected"; ?>>
Published
</option>

</select>


<br><br>

<button type="submit" name="update">
Update Blog
</button>

</form>


<a href="index.php" class="back">← Back to Blogs</a>

</div>

</div>

<script>
CKEDITOR.replace('editor');
</script>

</body>

</html>
