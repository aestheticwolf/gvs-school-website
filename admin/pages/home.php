<?php
session_start();
include "../../includes/db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: ../login.php");
    exit();
}

/* Fetch Data */
$res = mysqli_query($conn,"SELECT * FROM home_content LIMIT 1");
$data = mysqli_fetch_assoc($res);


/* Reset */
if(isset($_POST['reset'])){

    mysqli_query($conn,"UPDATE home_content SET

    hero_highlight1='',
    hero_highlight2='',
    hero_highlight3='',
    hero_highlight4='',

    thought_of_day='',

    intro_line1='',
    intro_line2='',

    facebook_link='',
    instagram_link=''

    WHERE id=1
    ");

    header("Location: home.php?reset=1");
    exit();
}


/* Upload Hero Images */
function uploadHero($file){
  if($file['name']!=""){
    $name = time()."_".$file['name'];
    move_uploaded_file($file['tmp_name'],
      "../../public/assets/images/".$name);
    return $name;
  }
  return "";
}


/* Update */
if(isset($_POST['save'])){

    $thought = $_POST['thought_of_day'];

    $intro1 = $_POST['intro1'];
    $intro2 = $_POST['intro2'];

    $h1 = $_POST['hero_highlight1'];
    $h2 = $_POST['hero_highlight2'];
    $h3 = $_POST['hero_highlight3'];
    $h4 = $_POST['hero_highlight4'];

    $fb_link = $_POST['facebook_link'];
    $ig_link = $_POST['instagram_link'];

    $img1 = uploadHero($_FILES['hero1']);
    $img2 = uploadHero($_FILES['hero2']);
    $img3 = uploadHero($_FILES['hero3']);


    mysqli_query($conn,"

    UPDATE home_content SET

    hero_img1 = IF('$img1'!='','$img1',hero_img1),
    hero_img2 = IF('$img2'!='','$img2',hero_img2),
    hero_img3 = IF('$img3'!='','$img3',hero_img3),

    thought_of_day='$thought',

    intro_line1='$intro1',
    intro_line2='$intro2',

    hero_highlight1='$h1',
    hero_highlight2='$h2',
    hero_highlight3='$h3',
    hero_highlight4='$h4',

    facebook_link='$fb_link',
    instagram_link='$ig_link'

    WHERE id=1
    ");

    header("Location: home.php?success=1");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Home Page CMS</title>

<script src="https://cdn.tiny.cloud/1/pk37h5rjaeflhgojvtcu8n79yne8sof1yl6hxd0xk4mqc57j/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<style>

body{
  font-family: 'Poppins', Arial, sans-serif;
  margin:0;
  background:#f5f7fb;
}

/* Header */

.header{
  background: linear-gradient(135deg,#143d7a,#4f8fd8);
  color:white;
  padding:18px;
  text-align:center;
  font-size:20px;
  font-weight:600;
  box-shadow:0 4px 15px rgba(0,0,0,0.15);
}

/* Page Container */

.page{
  max-width:1000px;
  margin:30px auto;
  padding:20px;
}

/* Box */

.box{
  background:white;
  padding:30px;
  border-radius:15px;
  box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

/* Section Card */

.section-box{
  background:#f9fbff;
  padding:20px;
  border-radius:12px;
  margin-bottom:25px;
  border:1px solid #e3ecff;
}

/* Headings */

h2{
  margin:0;
}

h4{
  color:#143d7a;
  margin-bottom:10px;
}

/* Inputs */

input,textarea{
  width:100%;
  padding:12px;
  margin:8px 0;
  border:1px solid #ccc;
  border-radius:8px;
  font-size:14px;
  transition:.3s;
}

input:focus,
textarea:focus{
  outline:none;
  border-color:#4f8fd8;
  box-shadow:0 0 5px rgba(79,143,216,0.4);
}

/* Buttons */

.btn-group{
  display:flex;
  gap:15px;
  margin-top:20px;
}

button{
  padding:12px 22px;
  border:none;
  border-radius:8px;
  font-size:14px;
  cursor:pointer;
  transition:.3s;
}

.btn-save{
  background:#143d7a;
  color:white;
}

.btn-save:hover{
  background:#4f8fd8;
}

.btn-reset{
  background:#e74c3c;
  color:white;
}

.btn-reset:hover{
  background:#c0392b;
}

/* Messages */

.success{
  color:#2ecc71;
  font-weight:600;
}

.error{
  color:#e74c3c;
  font-weight:600;
}

/* Back link */

.back{
  display:inline-block;
  margin-bottom:15px;
  text-decoration:none;
  color:#143d7a;
  font-weight:500;
}

.back:hover{
  text-decoration:underline;
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

<!-- Header -->
<div class="header">
  Home Page Management
</div>

<div class="page">

<a href="../dashboard.php" class="btn">← Back to Dashboard</a>


<?php if(isset($_GET['success'])): ?>
<p class="success">✅ Changes saved successfully</p>
<?php endif; ?>

<?php if(isset($_GET['reset'])): ?>
<p class="error">⚠️ All content has been cleared</p>
<?php endif; ?>


<div class="box">

<form method="post" enctype="multipart/form-data">


<!-- Hero Section -->
<div class="section-box">

<h4>🖼️ Hero Images</h4>

<input type="file" name="hero1">
<input type="file" name="hero2">
<input type="file" name="hero3">

</div>


<!-- Thought -->
<div class="section-box">

<h4>💡 Thought of the Day</h4>

<textarea name="thought_of_day" rows="3"
placeholder="Enter motivational thought..."><?= $data['thought_of_day'] ?></textarea>

</div>


<!-- Introduction -->
<div class="section-box">

<h4>📘 Introduction</h4>

<textarea name="intro1"
placeholder="Introduction line 1"><?= $data['intro_line1'] ?></textarea>

<textarea name="intro2"
placeholder="Introduction line 2"><?= $data['intro_line2'] ?></textarea>

</div>


<!-- Social -->
<div class="section-box">

<h4>🌐 Social Links</h4>

<input type="text" name="facebook_link"
value="<?= $data['facebook_link'] ?>"
placeholder="Facebook Page URL">

<input type="text" name="instagram_link"
value="<?= $data['instagram_link'] ?>"
placeholder="Instagram Page URL">

</div>


<!-- Buttons -->
<div class="btn-group">

<button type="submit" name="save" class="btn-save">
💾 Save Changes
</button>

<button type="submit" name="reset" class="btn-reset">
🗑️ Reset All
</button>

</div>


</form>

</div>

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
