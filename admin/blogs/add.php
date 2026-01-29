<?php
session_start();
include "../../includes/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

$author = $_SESSION['admin_user'] ?: "Admin";

if (isset($_POST['submit'])) {

    $title   = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $status  = $_POST['status'];

    /* Image Upload */
    $imageName = "";

    if (!empty($_FILES['image']['name'])) {

        $imageName = time()."_".$_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../../public/uploads/blogs/".$imageName
        );
    }

    /* Insert */
    mysqli_query($conn,"
        INSERT INTO blogs(title,content,image,author,status)
        VALUES('$title','$content','$imageName','$author','$status')
    ");

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>

<title>Add Blog</title>

<script src="https://cdn.tiny.cloud/1/pk37h5rjaeflhgojvtcu8n79yne8sof1yl6hxd0xk4mqc57j/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

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
  box-shadow:0 4px 15px rgba(0,0,0,0.15);
}

/* Page */

.page{
  max-width:900px;
  margin:30px auto;
  padding:20px;
}

/* Box */

.box{
  background:white;
  padding:30px;
  border-radius:15px;
  box-shadow:0 10px 30px rgba(0,0,0,0.08);
  animation:fadeUp .7s ease;
}

/* Animation */

@keyframes fadeUp{
  from{
    opacity:0;
    transform:translateY(20px);
  }
  to{
    opacity:1;
    transform:translateY(0);
  }
}

/* Inputs */

label{
  font-weight:500;
  margin-top:10px;
  display:block;
}

input,textarea,select{
  width:100%;
  padding:12px;
  margin:6px 0 15px;
  border:1px solid #ccc;
  border-radius:8px;
  font-size:14px;
}

input:focus,
textarea:focus,
select:focus{
  outline:none;
  border-color:#4f8fd8;
}

/* Button */

button{
  padding:12px 25px;
  background:#143d7a;
  color:white;
  border:none;
  border-radius:8px;
  cursor:pointer;
  font-size:14px;
  transition:.3s;
}

button:hover{
  background:#4f8fd8;
  transform:scale(1.03);
}

/* Preview */

.preview{
  margin-bottom:15px;
  display:none;
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
  font-weight:500;
}

.back:hover{
  text-decoration:underline;
}

</style>

</head>

<body>

<div class="header">
  Add New Blog
</div>

<div class="page">

<div class="box">

<form method="POST" enctype="multipart/form-data">

<label>Blog Title</label>

<input type="text"
       name="title"
       placeholder="Enter blog title"
       required>


<label>Content</label>

<textarea name="content"
          id="editor"
          required></textarea>


<label>Blog Image</label>

<input type="file"
       name="image"
       accept="image/*"
       onchange="previewImage(event)"
       required>


<div class="preview" id="previewBox">
  <img id="previewImg">
</div>


<label>Status</label>

<select name="status">

  <option value="Draft">Draft</option>

  <option value="Published">Published</option>

</select>


<br>

<button type="submit" name="submit">
Save Blog
</button>

</form>


<a href="index.php" class="btn">
← Back to Blogs
</a>

</div>

</div>


<script>

/* Image Preview */

function previewImage(event){

  const file = event.target.files[0];

  if(!file) return;

  const reader = new FileReader();

  reader.onload = function(){

    document.getElementById('previewImg').src = reader.result;

    document.getElementById('previewBox').style.display = "block";

  };

  reader.readAsDataURL(file);

}

</script>

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
