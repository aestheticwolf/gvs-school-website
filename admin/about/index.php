<?php 
session_start();
include "../../includes/db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: ../login.php");
    exit();
}

/* Fetch Data */
$res = mysqli_query($conn,"SELECT * FROM about_content LIMIT 1");
$data = mysqli_fetch_assoc($res);

/* Save */
if(isset($_POST['save'])){

  $vision = mysqli_real_escape_string($conn,$_POST['vision']);
  $mission = mysqli_real_escape_string($conn,$_POST['mission']);

  $president = $_POST['president'];
  $secretary = $_POST['secretary'];
  $treasurer = $_POST['treasurer'];
  $member = $_POST['member'];

  mysqli_query($conn,"
    UPDATE about_content SET
    vision='$vision',
    mission='$mission',
    president='$president',
    secretary='$secretary',
    treasurer='$treasurer',
    member='$member'
  ");

  $msg="✅ About Page Updated Successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit About Page</title>

<script src="https://cdn.tiny.cloud/1/pk37h5rjaeflhgojvtcu8n79yne8sof1yl6hxd0xk4mqc57j/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>


<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

/* Base */

*{
  box-sizing:border-box;
}

body{
  margin:0;
  font-family:'Poppins',sans-serif;
  background:linear-gradient(135deg,#eaf2ff,#f9fbff);
}

/* Header */

.header{
  background:linear-gradient(135deg,#143d7a,#4f8fd8);
  color:white;
  padding:22px;
  text-align:center;
  font-size:22px;
  font-weight:600;
  box-shadow:0 4px 15px rgba(0,0,0,0.15);
}

/* Container */

.container{
  max-width:900px;
  margin:35px auto;
  padding:20px;
}

/* Card */

.card{
  background:white;
  padding:35px;
  border-radius:18px;
  box-shadow:0 12px 35px rgba(0,0,0,0.08);
  animation:fadeUp .7s ease;
}

/* Title */

.card h2{
  margin-top:0;
  color:#143d7a;
  margin-bottom:25px;
}

/* Labels */

label{
  font-weight:500;
  margin-top:15px;
  display:block;
}

/* Inputs */

input, textarea{
  width:100%;
  padding:12px 14px;
  margin:6px 0 15px;

  border:1px solid #ccc;
  border-radius:8px;
  font-size:14px;

  transition:.3s;
}

input:focus,
textarea:focus{
  outline:none;
  border-color:#4f8fd8;
  box-shadow:0 0 0 2px rgba(79,143,216,.15);
}

/* Button */

button{
  margin-top:15px;
  padding:12px 28px;

  background:#143d7a;
  color:white;

  border:none;
  border-radius:8px;
  cursor:pointer;

  font-size:15px;
  font-weight:500;

  transition:.3s;
}

button:hover{
  background:#4f8fd8;
  transform:scale(1.05);
}

/* Message */

.msg{
  background:#eafaf1;
  color:#155724;
  padding:12px;
  border-radius:8px;
  margin-bottom:20px;
  font-weight:500;

  animation:pop .5s ease;
}

/* Back */

.back{
  display:inline-block;
  margin-top:25px;
  color:#143d7a;
  text-decoration:none;
  font-weight:500;
}

.back:hover{
  text-decoration:underline;
}

/* Grid for Names */

.grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
  gap:20px;
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

/* Animations */

@keyframes fadeUp{
  from{
    opacity:0;
    transform:translateY(25px);
  }
  to{
    opacity:1;
    transform:translateY(0);
  }
}

@keyframes pop{
  from{
    transform:scale(.9);
    opacity:0;
  }
  to{
    transform:scale(1);
    opacity:1;
  }
}

</style>
</head>

<body>

<!-- Header -->
<div class="header">
  ✏️ Edit About Page
</div>


<div class="container">

<div class="card">

<h2>About Page Settings</h2>


<?php if(isset($msg)): ?>
  <div class="msg"><?= $msg ?></div>
<?php endif; ?>


<form method="POST">


<!-- Vision -->

<label>Our Vision</label>
<textarea name="vision" id="vision"><?= $data['vision'] ?></textarea>


<!-- Mission -->

<label>Our Mission</label>
<textarea name="mission" id="mission"><?= $data['mission'] ?></textarea>


<!-- Management -->

<h3 style="margin-top:30px;color:#143d7a;">Management Team</h3>

<div class="grid">

  <div>
    <label>President</label>
    <input type="text" name="president"
           value="<?= $data['president'] ?>">
  </div>

  <div>
    <label>Secretary</label>
    <input type="text" name="secretary"
           value="<?= $data['secretary'] ?>">
  </div>

  <div>
    <label>Treasurer</label>
    <input type="text" name="treasurer"
           value="<?= $data['treasurer'] ?>">
  </div>

  <div>
    <label>Member</label>
    <input type="text" name="member"
           value="<?= $data['member'] ?>">
  </div>

</div>


<button name="save">
💾 Save Changes
</button>

</form>

<br>


<a href="../dashboard.php" class="btn">
← Back to Dashboard
</a>

</div>

</div>


<!-- TinyMCE -->

<script>
tinymce.init({

  selector:'#vision,#mission',

  height:260,

  plugins:'lists link image table code fullscreen preview',

  toolbar:
    'undo redo | bold italic underline | ' +
    'bullist numlist | link image | ' +
    'table | fullscreen preview code',

  menubar:false,
  branding:false

});
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
