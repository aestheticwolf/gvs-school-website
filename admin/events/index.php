<?php
session_start();
include "../../includes/db.php";

if(!isset($_SESSION['admin_id'])){
  header("Location: ../login.php");
  exit();
}

/* Fetch Events */
$result = mysqli_query($conn,
  "SELECT * FROM events ORDER BY event_date DESC"
);
?>

<!DOCTYPE html>
<html>
<head>

<title>Manage Events</title>

<style>

body{
  font-family:Poppins,Arial;
  background:#f4f6f9;
  padding:30px;
}

.header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:25px;
}

.btn{
  padding:8px 15px;
  background:#143d7a;
  color:white;
  text-decoration:none;
  border-radius:6px;
  transition:.3s;
}

.btn:hover{
  background:#4f8fd8;
}

table{
  width:100%;
  background:white;
  border-collapse:collapse;
  border-radius:10px;
  overflow:hidden;
  box-shadow:0 5px 20px rgba(0,0,0,.08);
}

th,td{
  padding:12px;
  border-bottom:1px solid #eee;
  text-align:left;
}

th{
  background:#143d7a;
  color:white;
}

.del{
  background:red;
}

.del:hover{
  background:darkred;
}

.empty{
  text-align:center;
  color:#777;
  padding:20px;
}

</style>

</head>

<body>


<div class="header">

<h2>📅 Manage Events</h2>

<a href="add.php" class="btn">+ Add Event</a>

</div>


<table>

<tr>
  <th>ID</th>
  <th>Title</th>
  <th>Date</th>
 <th>Image</th>
<th>Description</th>
<th>Action</th>

</tr>


<?php if(mysqli_num_rows($result)>0): ?>

<?php while($row=mysqli_fetch_assoc($result)): ?>

<tr>

<td><?= $row['id'] ?></td>

<td><?= htmlspecialchars($row['title']) ?></td>

<td><?= date("d M Y",strtotime($row['event_date'])) ?></td>

<td>
<?php if($row['image']!=""): ?>
<img src="../../public/uploads/events/<?= $row['image'] ?>"
     style="width:70px;height:60px;object-fit:cover;border-radius:6px;">
<?php else: ?>
No Image
<?php endif; ?>
</td>

<td><?= substr(strip_tags($row['description']),0,60) ?>...</td>

<td>
<a href="delete.php?id=<?= $row['id'] ?>"
   class="btn del"
   onclick="return confirm('Delete this event?')">
   Delete
</a>
</td>

</tr>


<?php endwhile; ?>

<?php else: ?>

<tr>
<td colspan="5" class="empty">
No events added yet.
</td>
</tr>

<?php endif; ?>


</table>


<br>

<a href="../dashboard.php" class="btn">← Back</a>


</body>
</html>
