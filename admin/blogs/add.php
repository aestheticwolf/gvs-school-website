<?php
session_start();
include "../../includes/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

$author = $_SESSION['admin_user'];

if (empty($author)) {
    $author = "Admin";
}

if (isset($_POST['submit'])) {

    $title   = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $status  = $_POST['status'];

    // Image Upload
    $imageName = "";

    if (!empty($_FILES['image']['name'])) {

        $imageName = time() . "_" . $_FILES['image']['name'];

        $tmpName = $_FILES['image']['tmp_name'];

        $uploadPath = "../../public/uploads/blogs/" . $imageName;

        move_uploaded_file($tmpName, $uploadPath);
    }

    // Insert
    $query = "INSERT INTO blogs 
              (title, content, image, author, status)
              VALUES 
              ('$title', '$content', '$imageName', '$author', '$status')";

    mysqli_query($conn, $query);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Blog</title>

<!-- FREE CKEditor -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<style>
body{
    font-family: Arial;
    padding: 20px;
}

input, textarea, select {
    width: 100%;
    padding: 8px;
    margin: 8px 0;
}

textarea{
    min-height: 200px;
}

button {
    padding: 10px 20px;
    background: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}
</style>
</head>

<body>

<h2>Add New Blog</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="title" placeholder="Title" required>

    <!-- Editor -->
    <textarea name="content" id="editor" required></textarea>

    <label>Blog Image</label>
    <input type="file" name="image" required>

    <select name="status">
        <option value="Draft">Draft</option>
        <option value="Published">Published</option>
    </select>

    <br><br>

    <button type="submit" name="submit">Save</button>

</form>

<!-- Start Editor -->
<script>
CKEDITOR.replace('editor');
</script>

</body>
</html>
