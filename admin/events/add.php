<?php
session_start();
include "../../includes/db.php";

if(!isset($_SESSION['admin_id'])){
  header("Location: ../login.php");
  exit();
}

if(isset($_POST['save'])){

 $title = mysqli_real_escape_string($conn,$_POST['title']);
$date  = $_POST['event_date'];
$desc  = mysqli_real_escape_string($conn,$_POST['description']);

/* Upload Image */
$imageName = "";

if(!empty($_FILES['image']['name'])){

    $imageName = time()."_".$_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../../public/uploads/events/".$imageName
    );
}

/* Insert with image */
mysqli_query($conn,
  "INSERT INTO events(title,event_date,description,image)
   VALUES('$title','$date','$desc','$imageName')"
);

header("Location: index.php");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Event</title>

<script src="https://cdn.tiny.cloud/1/pk37h5rjaeflhgojvtcu8n79yne8sof1yl6hxd0xk4mqc57j/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<style>

body{
  font-family:Poppins,Arial;
  background:#f4f6f9;
  padding:30px;
}

.box{
  max-width:500px;
  margin:auto;
  background:white;
  padding:25px;
  border-radius:12px;
  box-shadow:0 5px 20px rgba(0,0,0,.1);
}

h2{
  text-align:center;
  margin-bottom:20px;
}

input,textarea,button{
  width:100%;
  padding:10px;
  margin:10px 0;
  border-radius:6px;
  border:1px solid #ccc;
}

textarea{
  min-height:120px;
}

button{
  background:#143d7a;
  color:white;
  border:none;
  cursor:pointer;
}

button:hover{
  background:#4f8fd8;
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


</style>

</head>

<body>


<div class="box">

<h2>➕ Add Event</h2>


<form method="POST" enctype="multipart/form-data">


<input type="text"
       name="title"
       placeholder="Event Title"
       required>


<input type="date"
       name="event_date"
       required>


<textarea name="description"
          placeholder="Event Description"
          required></textarea>

          <label>Event Poster / Image</label>
<input type="file" name="image" accept="image/*">



<button name="save">Save Event</button>

</form>

<br>

<a href="index.php" class="btn">← Back</a>

</div>

<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until Feb 11, 2026:
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    uploadcare_public_key: '1c79622a59fd687714fc',
  });
</script> 

</body>
</html>
