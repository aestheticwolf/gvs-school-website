<?php
session_start();
include "../../includes/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

/* Get image */
$res = mysqli_query($conn,"SELECT image FROM blogs WHERE id=$id");
$row = mysqli_fetch_assoc($res);

if($row){

  if(!empty($row['image'])){
    unlink("../../public/uploads/blogs/".$row['image']);
  }

  mysqli_query($conn,"DELETE FROM blogs WHERE id=$id");
}

header("Location: index.php");
exit();
