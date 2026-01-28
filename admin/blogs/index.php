<?php
session_start();
include "../../includes/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['admin_user'];

// Pagination
$limit = 5; // blogs per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page < 1){
    $page = 1;
}

$offset = ($page - 1) * $limit;


// Search & Filter
$search = "";
$status = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

if(isset($_GET['status'])){
    $status = $_GET['status'];
}


// Base Query
$where = "WHERE author='$user'";

if($search != ""){
    $where .= " AND title LIKE '%$search%'";
}

if($status != "" && $status != "all"){
    $where .= " AND status='$status'";
}


// Get Total Rows
$countQuery = "SELECT COUNT(*) as total FROM blogs $where";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);

$totalBlogs = $countRow['total'];

$totalPages = ceil($totalBlogs / $limit);


// Fetch Blogs
$query = "SELECT * FROM blogs 
          $where 
          ORDER BY id DESC 
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $query);
?>




<!DOCTYPE html>
<html>
<head>
    <title>Manage Blogs</title>

   <style>

body{
  font-family:'Poppins',Arial,sans-serif;
  margin:0;
  background:#f5f7fb;
}

/* Header */

.header{
  background:linear-gradient(135deg,#143d7a,#4f8fd8);
  color:white;
  padding:18px;
  text-align:center;
  font-size:20px;
  font-weight:600;
  box-shadow:0 4px 15px rgba(0,0,0,0.15);
}

/* Page */

.page{
  max-width:1200px;
  margin:30px auto;
  padding:20px;
}

/* Top Bar */

.top-bar{
  display:flex;
  justify-content:space-between;
  align-items:center;
  flex-wrap:wrap;
  gap:15px;
  margin-bottom:20px;
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

/* Filter */

.filter-box{
  background:white;
  padding:15px;
  border-radius:10px;
  box-shadow:0 4px 15px rgba(0,0,0,0.06);
  display:flex;
  gap:10px;
  flex-wrap:wrap;
}

.filter-box input,
.filter-box select{
  padding:10px;
  border:1px solid #ccc;
  border-radius:6px;
}

/* Table */

.table-box{
  background:white;
  border-radius:12px;
  overflow:hidden;
  box-shadow:0 8px 25px rgba(0,0,0,0.08);
}

table{
  width:100%;
  border-collapse:collapse;
}

th{
  background:#143d7a;
  color:white;
  padding:12px;
}

td{
  padding:12px;
  border-bottom:1px solid #eee;
  text-align:center;
}

tr:hover{
  background:#f1f6ff;
}

/* Status Badge */

.badge{
  padding:5px 10px;
  border-radius:20px;
  font-size:12px;
  color:white;
}

.published{
  background:#2ecc71;
}

.draft{
  background:#f39c12;
}

/* Pagination */

.pagination{
  margin-top:25px;
  text-align:center;
}

.pagination a,
.pagination span{
  display:inline-block;
  margin:3px;
  padding:8px 12px;
  border-radius:6px;
  background:#143d7a;
  color:white;
  text-decoration:none;
}

.pagination span{
  background:#333;
}

</style>

</head>

<body>

<div class="header">
  Blog Management
</div>

<div class="page">

<div class="top-bar">

  <a href="../dashboard.php" class="btn">← Dashboard</a>

  <a href="add.php" class="btn">+ Add Blog</a>

</div>


<form method="GET" class="filter-box">

  <input type="text"
         name="search"
         placeholder="Search title..."
         value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">

  <select name="status">

    <option value="all">All Status</option>

    <option value="Published"
    <?= (isset($_GET['status']) && $_GET['status']=="Published") ? "selected" : "" ?>>
    Published
    </option>

    <option value="Draft"
    <?= (isset($_GET['status']) && $_GET['status']=="Draft") ? "selected" : "" ?>>
    Draft
    </option>

  </select>

  <button type="submit" class="btn">
    Filter
  </button>

</form>


<div class="table-box">

<table>

<tr>
  <th>ID</th>
  <th>Title</th>
  <th>Author</th>
  <th>Status</th>
  <th>Date</th>
  <th>Actions</th>
</tr>


<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= htmlspecialchars($row['title']); ?></td>

<td><?= $row['author']; ?></td>

<td>
  <span class="badge <?= strtolower($row['status']) ?>">
    <?= $row['status']; ?>
  </span>
</td>

<td><?= $row['created_at']; ?></td>

<td>

<a href="edit.php?id=<?= $row['id']; ?>" class="btn">
Edit
</a>

<a href="delete.php?id=<?= $row['id']; ?>"
   class="btn btn-danger"
   onclick="return confirm('Delete this blog?')">
Delete
</a>

</td>

</tr>

<?php } ?>


<?php if(mysqli_num_rows($result)==0): ?>

<tr>
<td colspan="6">No blogs found</td>
</tr>

<?php endif; ?>

</table>

</div>


<!-- Pagination -->

<div class="pagination">

<?php if($totalPages > 1): ?>

<?php if($page > 1): ?>
<a href="?page=<?= $page-1 ?>&search=<?= $search ?>&status=<?= $status ?>">Prev</a>
<?php endif; ?>


<?php for($i=1;$i<=$totalPages;$i++): ?>

<?php if($i==$page): ?>
<span><?= $i ?></span>
<?php else: ?>
<a href="?page=<?= $i ?>&search=<?= $search ?>&status=<?= $status ?>"><?= $i ?></a>
<?php endif; ?>

<?php endfor; ?>


<?php if($page < $totalPages): ?>
<a href="?page=<?= $page+1 ?>&search=<?= $search ?>&status=<?= $status ?>">Next</a>
<?php endif; ?>

<?php endif; ?>

</div>


</div>

</body>

</html>