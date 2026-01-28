<?php
session_start();
include "../../includes/db.php";

if(!isset($_SESSION['admin_id'])){
  header("Location: ../login.php");
  exit();
}

if(isset($_GET['id'])){

  $id = intval($_GET['id']);

  mysqli_query($conn,
    "DELETE FROM events WHERE id=$id"
  );
}

header("Location: index.php");
exit();
