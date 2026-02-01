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


/* Save */
if(isset($_POST['save'])){

    /* TEXT */
    $hero_managed  = trim($_POST['hero_managed'] ?? '');
    $hero_title    = trim($_POST['hero_title'] ?? '');
    $hero_subtitle = trim($_POST['hero_subtitle'] ?? '');
    $hero_tagline  = trim($_POST['hero_tagline'] ?? '');

    $thought = trim($_POST['thought_of_day'] ?? '');
    $intro1  = trim($_POST['intro1'] ?? '');
    $intro2  = trim($_POST['intro2'] ?? '');

    $fb_link = trim($_POST['facebook_link'] ?? '');
    $ig_link = trim($_POST['instagram_link'] ?? '');


    /* Keep old if empty */
    if($hero_managed=="")  $hero_managed  = $data['hero_managed'];
    if($hero_title=="")    $hero_title    = $data['hero_title'];
    if($hero_subtitle=="") $hero_subtitle = $data['hero_subtitle'];
    if($hero_tagline=="")  $hero_tagline  = $data['hero_tagline'];

    if($thought=="") $thought = $data['thought_of_day'];
    if($intro1=="")  $intro1  = $data['intro_line1'];
    if($intro2=="")  $intro2  = $data['intro_line2'];

    if($fb_link=="") $fb_link = $data['facebook_link'];
    if($ig_link=="") $ig_link = $data['instagram_link'];


    /* Escape */
    $hero_managed  = mysqli_real_escape_string($conn,$hero_managed);
    $hero_title    = mysqli_real_escape_string($conn,$hero_title);
    $hero_subtitle = mysqli_real_escape_string($conn,$hero_subtitle);
    $hero_tagline  = mysqli_real_escape_string($conn,$hero_tagline);

    $thought = mysqli_real_escape_string($conn,$thought);
    $intro1  = mysqli_real_escape_string($conn,$intro1);
    $intro2  = mysqli_real_escape_string($conn,$intro2);

    $fb_link = mysqli_real_escape_string($conn,$fb_link);
    $ig_link = mysqli_real_escape_string($conn,$ig_link);


    /* HERO IMAGES */
    $oldImgs = json_decode($data['hero_images'], true);
    if(!is_array($oldImgs)) $oldImgs = [];

    $newImgs = [];

    if(!empty($_FILES['hero_images']['name'][0])){

      foreach($_FILES['hero_images']['tmp_name'] as $k=>$tmp){

        if(count($oldImgs) + count($newImgs) >= 6){
          break;
        }

        if($_FILES['hero_images']['error'][$k] != 0) continue;

        $ext = pathinfo($_FILES['hero_images']['name'][$k], PATHINFO_EXTENSION);

        $name = uniqid("hero_",true).".".$ext;

        $dest = "../../public/assets/images/".$name;

        if(move_uploaded_file($tmp,$dest)){
          $newImgs[] = $name;
        }
      }
    }

    $allImgs = array_slice(array_merge($oldImgs,$newImgs),0,6);

    $jsonImgs = mysqli_real_escape_string($conn,json_encode($allImgs));


    /* UPDATE */
    mysqli_query($conn,"UPDATE home_content SET

    hero_images='$jsonImgs',

    hero_managed='$hero_managed',
    hero_title='$hero_title',
    hero_subtitle='$hero_subtitle',
    hero_tagline='$hero_tagline',

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

.preview-box{
  background:#ffffff;
  border:1px dashed #4f8fd8;
  padding:15px;
  margin-top:12px;
  border-radius:8px;
  font-size:14px;
  color:#333;
}

.preview-title{
  font-weight:600;
  color:#143d7a;
  margin-bottom:6px;
  font-size:13px;
}


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


<div class="box">

<form method="post" enctype="multipart/form-data">


<!-- HERO TEXT -->
<div class="section-box">

<h3>🎯 Hero Text</h3>

<input type="text" id="hero_managed" name="hero_managed" placeholder="Managed by...">

<input type="text" id="hero_title" name="hero_title" placeholder="Main Title">

<input type="text" id="hero_subtitle" name="hero_subtitle" placeholder="Subtitle">

<input type="text" id="hero_tagline" name="hero_tagline" placeholder="Tagline">



<!-- Preview -->
<div class="preview-box">

<div class="preview-title">Current Hero Text</div>

<p><b>Managed:</b> <?= $data['hero_managed'] ?></p>
<p><b>Title:</b> <?= $data['hero_title'] ?></p>
<p><b>Subtitle:</b> <?= $data['hero_subtitle'] ?></p>
<p><b>Tagline:</b> <?= $data['hero_tagline'] ?></p>

<br>

<button type="button" class="btn" onclick="editHero()">Edit</button>

<button type="button" class="btn btn-danger" onclick="clearHero()">
Delete
</button>


</div>

</div>



<!-- HERO IMAGES -->
<div class="section-box">

<h3>🖼️ Hero Images</h3>

<input type="file" name="hero_images[]" multiple accept="image/*">
<p style="font-size:13px;color:#666">Maximum 6 images</p>


</div>


<?php
$imgs = json_decode($data['hero_images'], true);
if(!is_array($imgs)) $imgs = [];
?>

<div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:10px">

<?php foreach($imgs as $img){ ?>

<img src="../../public/assets/images/<?= $img ?>"
     style="width:120px;height:80px;object-fit:cover;border:1px solid #ccc;border-radius:6px">

<?php } ?>

</div>



<!-- THOUGHT -->
<div class="section-box">

<h3>💡 Thought of Day</h3>

<textarea id="thoughtBox" name="thought_of_day"></textarea>

<!-- Preview -->
<div class="preview-box">

<div class="preview-title">Current Thought</div>

<?= nl2br($data['thought_of_day']) ?>

<br><br>

<button type="button" class="btn" onclick="editThought()">Edit</button>

<button type="button" class="btn btn-danger" onclick="clearThought()">
Delete
</button>

</div>

</div>




<!-- INTRODUCTION -->
<div class="section-box">

<h3>📘 Introduction</h3>

<textarea id="intro1" name="intro1"></textarea>

<textarea id="intro2" name="intro2"></textarea>


<!-- Preview -->
<div class="preview-box">

<div class="preview-title">Current Introduction</div>

<p><?= nl2br($data['intro_line1']) ?></p>
<p><?= nl2br($data['intro_line2']) ?></p>

<br>

<button type="button" class="btn" onclick="editIntro()">Edit</button>

<button type="button" class="btn btn-danger" onclick="clearIntro()">
Delete
</button>

</div>

</div>




<!-- SOCIAL -->
<div class="section-box">

<h3>🌐 Social Links</h3>

<input type="text" id="fbBox" name="facebook_link">

<input type="text" id="igBox" name="instagram_link">



<!-- Preview -->
<div class="preview-box">

<div class="preview-title">Current Social Links</div>

<p><b>Facebook:</b> <?= $data['facebook_link'] ?></p>
<p><b>Instagram:</b> <?= $data['instagram_link'] ?></p>

<br>

<button type="button" class="btn" onclick="editSocial()">Edit</button>

<button type="button" class="btn btn-danger" onclick="clearSocial()">
Delete
</button>

</div>




<!-- BUTTONS -->
<div style="margin-top:20px">

<button name="save" class="btn">💾 Save</button>

<button type="button"
        class="btn btn-danger"
        onclick="resetForm()">
🗑 Reset
</button>


</div>

</form>

</div>
</div>


<script>

/* HERO */
function editHero(){

  document.getElementById("hero_managed").value =
  `<?= addslashes($data['hero_managed']) ?>`;

  document.getElementById("hero_title").value =
  `<?= addslashes($data['hero_title']) ?>`;

  document.getElementById("hero_subtitle").value =
  `<?= addslashes($data['hero_subtitle']) ?>`;

  document.getElementById("hero_tagline").value =
  `<?= addslashes($data['hero_tagline']) ?>`;
}

function clearHero(){

  document.getElementById("hero_managed").value="";
  document.getElementById("hero_title").value="";
  document.getElementById("hero_subtitle").value="";
  document.getElementById("hero_tagline").value="";
}


/* THOUGHT */
function editThought(){

  document.getElementById("thoughtBox").value =
  `<?= addslashes($data['thought_of_day']) ?>`;
}

function clearThought(){
  document.getElementById("thoughtBox").value="";
}


/* INTRO (Already working) */
function editIntro(){

  document.getElementById("intro1").value =
  `<?= addslashes($data['intro_line1']) ?>`;

  document.getElementById("intro2").value =
  `<?= addslashes($data['intro_line2']) ?>`;
}

function clearIntro(){

  document.getElementById("intro1").value="";
  document.getElementById("intro2").value="";
}


/* SOCIAL */
function editSocial(){

  document.getElementById("fbBox").value =
  `<?= addslashes($data['facebook_link']) ?>`;

  document.getElementById("igBox").value =
  `<?= addslashes($data['instagram_link']) ?>`;
}

function clearSocial(){

  document.getElementById("fbBox").value="";
  document.getElementById("igBox").value="";
}


/* RESET */
function resetForm(){

  if(confirm("Clear all typed fields?")){

    document.querySelector("form").reset();

    if(window.tinymce){
      tinymce.editors.forEach(editor=>{
        editor.setContent('');
      });
    }
  }
}

</script>


</body>
</html>
