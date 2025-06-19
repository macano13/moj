<?php

$dir = "uploads/";
$files1 = scandir($dir);
foreach ($files1 as $key => $value) {
    if ($value != "." && $value != "..") {
        array_map('unlink', glob($dir.$value."/*.*"));
        rmdir($dir.$value);
    }
}
?>
<?php
require_once('config.php');
include_once("code/template/header.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  
  <!-- Converter -->
  <link rel="stylesheet" href="styles/style.css"/>
  <script type="application/javascript" src="scripts/jquery.js"></script>
  <script type="application/javascript" src="scripts/main.js"></script>

  <!-- Custom styles for this template -->
  <link href="../css/scrolling-nav.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


  </head>

<body id="page-top">

  
<!-- Main -->
<main class="main-content">
     <div class="converter-container">
        <div class="tool-content">
            <h3 class="tool-content-title">Upload</h3>
            <div class="page-description text-center" style="width: 90%; margin-left: 5%">Upload  subtitle file</div>
            <div style="width: 100%; text-align: center; margin-top: 20px">
            <div id="converter-uploaded-file"></div>
                <form id="upload-form" enctype="multipart/form-data" action="https://translatesubtitles.co/a/translate.php" method="post">
                    <label for="file-upload-converter" class="red-button" id="upload-btn">
                        <img src="resources/images/upload_cloud.svg" width="18" height="13" alt="upload subtitles"/>
                        <span style="margin-left: 4px;">UPLOAD</span>
                    </label>
                    <input hidden type="file" name="file" id="file-upload-converter" class="file-input" accept=".srt, .vtt, .stl, .sbv, .sub, .ass"/>
                </form>
            </div>
        </div>

        <div class="converter-format-select-container">
            <div class="converter-format-select-title">
                <label for="format-select">
                    Select subtitle format
                </label>
            </div>
            <div class="converter-format-select">
                <select id="format-select">
                    <option value="">Select Format</option>
                    <option value="srt">SubRip (srt)</option>
                    <option value="vtt">WebVTT (vtt)</option>
                    <option value="stl">Spruce Subtitle File (stl)</option>
                    <option value="sbv">Youtube Subtitles (sbv)</option>
                    <option value="sub">SubViewer (sub)</option>
                    <option value="ass">Advanced Sub Station (ass)</option>
                </select>
            </div>
            <span class="converter-arrow"></span>
        </div>

        <div class="tool-content">
            <h3 class="tool-content-title">Download</h3>
            <div class="page-description" style="width: 90%; margin-left: 5%">Download your converted subtitle file</div>
            <div style="width: 100%; text-align: center; margin-top: 20px">

                <button class="red-button" id="download-btn-converter" disabled>
                    <img src="resources/images/download_cloud.svg" width="18" height="13" alt="download subtitle"/>
                    <span style="margin-left: 4px;">DOWNLOAD</span>
                </button>
            </div>
        </div>
    </div>
    
</main>



  <div class="modal fade" id="myModal" role="dialog">
     <div class="modal-dialog modal-lg">
       <div class="modal-content">

         <div class="modal-body">
             <form action="generate.php" method="post">
     <div class="form-group">
  <label>File name :</label>
  <input id="name" name="srt" class="form-control" type="text" readonly>
     </div>
     <div class="form-group">
  <label>Translate to: :</label>
        <select class="form-control" name="lang" id="sel1">
         <?php
         foreach ($result as $lang) {
   ?>       <option value="<?php echo $lang['code'] ?>"><?php echo $lang['name']; ?></option>
  <?php
  }
  ?>
       </select>
     </div>

     <button type="submit" id="complete" class="btn btn-default">Proceed</button>
   </form>
        </div>


     </div>
   </div>



  <a id="dnl" href="" download hidden></a>

  <script type="text/javascript">


     $("#download-btn-converter").click(function(){
         var extention = $("#format-select option:selected").val();

         var myform = document.getElementById("upload-form");
         var formData = new FormData(myform);
         formData.append('extention', extention);

         $.ajax({
             url: "extention_convert.php",
             dataType: 'text',
             data: formData,
             type: 'POST',
             cache: false,
             processData: false,
             contentType: false,
             success: function(e) {

                 document.getElementById("dnl").href = e;
                 document.getElementById('dnl').click();

             },
             error: function() {
                 alert("There are one or more errors!")
             }
         })
     });




     $("#file-upload-converter").change(function(){


     })
  </script>
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom JavaScript for this theme -->
  <script src="../js/scrolling-nav.js"></script>

</body>

</html>
