<?php
session_start();
include "../../includes/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['submit'])){

    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $status = $_POST['status'];

    mysqli_query($conn,
        "INSERT INTO blogs (title, content, author, status)
         VALUES ('$title','$content','$author','$status')"
    );

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Blog</title>

<style>
body{
    font-family:Arial;
}

input,textarea,select{
    width:100%;
    padding:8px;
    margin:8px 0;
}
button{
    padding:10px 20px;
    background:#007bff;
    color:white;
    border:none;
}
</style>
</head>

<body>

<h2>Add New Blog</h2>

<form method="post">

    <input type="text" name="title" placeholder="Title" required>

    <textarea name="content" rows="6" placeholder="Content" required></textarea>

    <input type="text" name="author" placeholder="Author" required>

    <select name="status">
        <option value="Draft">Draft</option>
        <option value="Published">Published</option>
    </select>

    <button type="submit" name="submit">Save</button>

</form>

</body>
</html>
