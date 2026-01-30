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


/* Upload Hero Images */
function uploadHero($file){
    if($file['name']!=""){
        $name = time()."_".$file['name'];
        move_uploaded_file(
            $file['tmp_name'],
            "../../public/assets/images/".$name
        );
        return $name;
    }
    return "";
}


/* Reset */
if(isset($_POST['reset'])){

    mysqli_query($conn,"UPDATE home_content SET

    hero_managed='',
    hero_title='',
    hero_subtitle='',
    hero_tagline='',

    hero_img1='',
    hero_img2='',
    hero_img3='',

    thought_of_day='',

    intro_line1='',
    intro_line2='',

    facebook_link='',
    instagram_link=''

    WHERE id=1");

    header("Location: home.php?reset=1");
    exit();
}


/* Save */
if(isset($_POST['save'])){

    $hero_managed  = $_POST['hero_managed'];
    $hero_title    = $_POST['hero_title'];
    $hero_subtitle = $_POST['hero_subtitle'];
    $hero_tagline  = $_POST['hero_tagline'];

    $thought = $_POST['thought_of_day'];

    $intro1 = $_POST['intro1'];
    $intro2 = $_POST['intro2'];

    $fb_link = $_POST['facebook_link'];
    $ig_link = $_POST['instagram_link'];

    $img1 = uploadHero($_FILES['hero1']);
    $img2 = uploadHero($_FILES['hero2']);
    $img3 = uploadHero($_FILES['hero3']);


    mysqli_query($conn,"UPDATE home_content SET

    hero_managed='$hero_managed',
    hero_title='$hero_title',
    hero_subtitle='$hero_subtitle',
    hero_tagline='$hero_tagline',

    hero_img1 = IF('$img1'!='','$img1',hero_img1),
    hero_img2 = IF('$img2'!='','$img2',hero_img2),
    hero_img3 = IF('$img3'!='','$img3',hero_img3),

    thought_of_day='$thought',

    intro_line1='$intro1',
    intro_line2='$intro2',

    facebook_link='$fb_link',
    instagram_link='$ig_link'

    WHERE id=1");

    header("Location: home.php?success=1");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Home Page CMS</title>

<script src="https://cdn.tiny.cloud/1/pk37h5rjaeflhgojvtcu8n79yne8sof1yl6hxd0xk4mqc57j/tinymce/8/tinymce.min.js"></script>

<style>

body{
  font-family:Poppins,Arial;
  margin:0;
  background:#f5f7fb;
}

.header{
  background:linear-gradient(135deg,#143d7a,#4f8fd8);
  color:white;
  padding:18px;
  text-align:center;
  font-size:20px;
}

.page{
  max-width:1000px;
  margin:30px auto;
  padding:20px;
}

.box{
  background:white;
  padding:30px;
  border-radius:12px;
  box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.section-box{
  background:#f9fbff;
  padding:20px;
  border-radius:10px;
  margin-bottom:25px;
}

input,textarea{
  width:100%;
  padding:12px;
  margin:6px 0;
  border:1px solid #ccc;
  border-radius:6px;
}

.btn{
  background:#143d7a;
  color:white;
  padding:10px 16px;
  border:none;
  border-radius:6px;
  text-decoration:none;
}

.btn:hover{background:#4f8fd8;}

.btn-danger{
  background:#e74c3c;
}

.success{color:green;font-weight:600;}
.error{color:red;font-weight:600;}

</style>
</head>

<body>

<div class="header">
Home Page Management
</div>

<div class="page">

<a href="../dashboard.php" class="btn">← Back</a>

<?php if(isset($_GET['success'])): ?>
<p class="success">Saved Successfully</p>
<?php endif; ?>

<?php if(isset($_GET['reset'])): ?>
<p class="error">All Cleared</p>
<?php endif; ?>


<div class="box">

<form method="post" enctype="multipart/form-data">


<!-- HERO TEXT -->
<div class="section-box">

<h3>🎯 Hero Text</h3>

<input type="text" name="hero_managed"
value="<?= $data['hero_managed'] ?>"
placeholder="Managed by...">

<input type="text" name="hero_title"
value="<?= $data['hero_title'] ?>"
placeholder="Main Title">

<input type="text" name="hero_subtitle"
value="<?= $data['hero_subtitle'] ?>"
placeholder="Subtitle">

<input type="text" name="hero_tagline"
value="<?= $data['hero_tagline'] ?>"
placeholder="Tagline">

</div>


<!-- HERO IMAGES -->
<div class="section-box">

<h3>🖼️ Hero Images</h3>

<input type="file" name="hero1">
<input type="file" name="hero2">
<input type="file" name="hero3">

</div>


<!-- THOUGHT -->
<div class="section-box">

<h3>💡 Thought of Day</h3>

<textarea name="thought_of_day"><?= $data['thought_of_day'] ?></textarea>

</div>


<!-- INTRO -->
<div class="section-box">

<h3>📘 Introduction</h3>

<textarea name="intro1"><?= $data['intro_line1'] ?></textarea>

<textarea name="intro2"><?= $data['intro_line2'] ?></textarea>

</div>


<!-- SOCIAL -->
<div class="section-box">

<h3>🌐 Social Links</h3>

<input type="text" name="facebook_link"
value="<?= $data['facebook_link'] ?>">

<input type="text" name="instagram_link"
value="<?= $data['instagram_link'] ?>">

</div>


<!-- BUTTONS -->
<div style="margin-top:20px">

<button name="save" class="btn">💾 Save</button>

<button name="reset" class="btn btn-danger">🗑 Reset</button>

</div>

</form>

</div>
</div>


<script>
tinymce.init({
  selector:'textarea',
  height:180
});
</script>

</body>
</html>
