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
            font-family: Arial;
            background:#f4f6f9;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
        }

        th,td{
            padding:10px;
            border:1px solid #ddd;
        }

        th{
            background:#343a40;
            color:white;
        }

        a{
            text-decoration:none;
            color:blue;
        }

        .btn{
            padding:6px 10px;
            background:#28a745;
            color:white;
            border-radius:4px;
        }

        .del{
            background:red;
        }
    </style>
</head>

<body>

<h2>Manage Blogs</h2>

<a href="add.php" class="btn">+ Add New Blog</a>

<br><br>

<form method="GET" style="margin-bottom:15px;">

    <input type="text"
           name="search"
           placeholder="Search by title..."
           value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">

    <select name="status">

        <option value="all">All</option>

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
        Search
    </button>

</form>


<table>

<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Author</th>
    <th>Status</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['title']; ?></td>
    <td><?= $row['author']; ?></td>
    <td><?= $row['status']; ?></td>
    <td><?= $row['created_at']; ?></td>

    <td>
        <a href="edit.php?id=<?= $row['id']; ?>" class="btn">Edit</a>
        &nbsp;
        <a href="delete.php?id=<?= $row['id']; ?>" 
           class="btn del"
           onclick="return confirm('Delete this blog?')">
           Delete
        </a>
    </td>
</tr>

<?php } ?>

<?php if(mysqli_num_rows($result) == 0): ?>
<tr>
    <td colspan="6" style="text-align:center;">
        No blogs found
    </td>
</tr>
<?php endif; ?>

</table>


<!-- Pagination -->

<div style="margin-top:20px; text-align:center;">

<?php if($totalPages > 1): ?>

    <?php if($page > 1): ?>
        <a class="btn" 
           href="?page=<?= $page-1 ?>&search=<?= $search ?>&status=<?= $status ?>">
           Prev
        </a>
    <?php endif; ?>


    <?php for($i=1; $i <= $totalPages; $i++): ?>

        <?php if($i == $page): ?>
            <span class="btn" style="background:#343a40;">
                <?= $i ?>
            </span>
        <?php else: ?>
            <a class="btn"
               href="?page=<?= $i ?>&search=<?= $search ?>&status=<?= $status ?>">
               <?= $i ?>
            </a>
        <?php endif; ?>

    <?php endfor; ?>


    <?php if($page < $totalPages): ?>
        <a class="btn" 
           href="?page=<?= $page+1 ?>&search=<?= $search ?>&status=<?= $status ?>">
           Next
        </a>
    <?php endif; ?>


<?php endif; ?>

</div>


</body>
</html>