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
    font-family: Arial;
    padding: 20px;
}

input, textarea, select{
    width: 100%;
    padding: 8px;
    margin: 8px 0;
}

button{
    padding: 10px 20px;
    background: green;
    color: white;
    border: none;
    cursor: pointer;
}

img{
    max-width:200px;
    display:block;
    margin-bottom:10px;
}
</style>
</head>

<body>

<h2>Edit Blog</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="title"
           value="<?php echo $blog['title']; ?>" required>

    <textarea name="content" id="editor" required>
<?php echo htmlspecialchars($blog['content']); ?>
</textarea>


    <p>Current Image:</p>

    <?php if(!empty($blog['image'])): ?>
        <img src="../../public/uploads/blogs/<?php echo $blog['image']; ?>">
    <?php endif; ?>


    <label>Change Image (optional)</label>
    <input type="file" name="image">


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


    <button type="submit" name="update">
        Update Blog
    </button>

</form>

<br>

<a href="index.php">← Back</a>

<script>
CKEDITOR.replace('editor');
</script>


</body>
</html>
