<?php
session_start();
include "../../includes/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

$sections = ['Pre-Primary', 'Primary', 'High School'];

/* Save Content */
if(isset($_POST['save'])){

    $section = $_POST['section'];
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    // Check if exists
    $check = mysqli_query($conn,
        "SELECT id FROM curriculum WHERE section='$section'"
    );

    if(mysqli_num_rows($check) > 0){

        // Update
        mysqli_query($conn,
            "UPDATE curriculum 
             SET content='$content'
             WHERE section='$section'"
        );

    } else {

        // Insert
        mysqli_query($conn,
            "INSERT INTO curriculum(section,content)
             VALUES('$section','$content')"
        );
    }

    $msg = "✅ Curriculum saved successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Curriculum Manager</title>

<script src="https://cdn.tiny.cloud/1/pk37h5rjaeflhgojvtcu8n79yne8sof1yl6hxd0xk4mqc57j/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>


<style>

/* Base */

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
  font-weight:600;
  box-shadow:0 4px 15px rgba(0,0,0,0.15);
}

/* Page */

.page{
  max-width:1100px;
  margin:25px auto;
  padding:20px;
}

/* Back */

.back{
  display:inline-block;
  margin-bottom:15px;
  color:#143d7a;
  text-decoration:none;
  font-weight:500;
}

.back:hover{
  text-decoration:underline;
}

/* Card */

.card{
  background:white;
  padding:30px;
  border-radius:18px;
  box-shadow:0 10px 30px rgba(0,0,0,0.08);

  animation:fadeUp .7s ease;
}

/* Labels */

label{
  font-weight:500;
  margin-top:12px;
  display:block;
}

/* Inputs */

select, textarea{
  width:100%;
  padding:12px;
  margin:6px 0 15px;

  border:1px solid #ccc;
  border-radius:8px;

  font-size:14px;
}

select:focus,
textarea:focus{
  outline:none;
  border-color:#4f8fd8;
}

/* Button */

button{
  padding:12px 28px;
  background:#143d7a;
  color:white;
  border:none;
  border-radius:8px;
  cursor:pointer;

  font-size:15px;
  transition:.3s;
}

button:hover{
  background:#4f8fd8;
  transform:scale(1.05);
}

/* Message */

.msg{
  padding:12px;
  background:#eafaf1;
  color:#155724;
  border-radius:8px;
  margin-bottom:15px;
  font-weight:500;
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

/* Animation */

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

</style>

</head>

<body>


<div class="header">
  Curriculum Manager
</div>


<div class="page">

<a href="../dashboard.php" class="btn">
← Back to Dashboard
</a>


<div class="card">


<?php if(isset($msg)): ?>
<div class="msg"><?= $msg ?></div>
<?php endif; ?>


<form method="POST">


<label>Select Section</label>

<select name="section" required>

<?php foreach($sections as $s): ?>

<option value="<?= $s ?>">
<?= $s ?>
</option>

<?php endforeach; ?>

</select>


<label>Curriculum Content</label>

<textarea name="content"
          id="editor"
          placeholder="Enter curriculum details here..."
          required></textarea>


<button type="submit" name="save">
Save Curriculum
</button>


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
