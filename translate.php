<?php
require_once('config.php');
header('Content-Type: text/html; charset=utf-8');

require_once(ABSPATH . '/code/post/upload-file-post.php');
include_once("code/template/header.php");
$user = getUserFromSession();
if ($user->expire_date == null) {
  echo "<script>window.location.href ='/payment.php';</script>";
} else {
  $extendExpiredDate = date("Y-m-d", strtotime($user->expire_date . " +10 days"));
  $todayDate = Date('Y-m-d');
  if ($todayDate > $extendExpiredDate) {
    echo "<script>window.location.href ='/payment.php';</script>";
  }
}
?>
<?php

$extension_array = array('.srt', '.ass', '.vtt', '.stl', '.sub', '.sbv');
foreach ($extension_array as $ext) {
  foreach (glob("*$ext") as $file) {
    unlink($file);
  }
}
foreach ($extension_array as $ext) {
  foreach (glob("uploads/*$ext") as $file) {
    unlink($file);
  }
}

if ($user->is_active == 2 || $user->is_active == 0) {
	echo "<script>window.location.href ='/payment.php';</script>";
}

?>
<html>

<head>
  <!-- Custom styles for this template -->

  <link href="dropzone.css" type="text/css" rel="stylesheet" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <script src="dropzone.js"></script>

  <style type="text/css">
    .dropzone {
      border: 2px dashed #dedede;
      border-radius: 5px;
      background: #f5f5f5;
      height: 100px;

    }

    .dropzone i {
      font-size: 2rem;
    }

    .dropzone .dz-message {
      color: rgba(0, 0, 0, .54);
      font-weight: 500;
      font-size: initial;
      text-transform: uppercase;
    }

    .loader {
      margin-left: 35% !important;
      margin-top: 10%;
      margin-bottom: 10%;

      align-content: center;
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #3498db;
      width: 200px;
      height: 200px;
      -webkit-animation: spin 2s linear infinite;
      /* Safari */
      animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
      0% {
        -webkit-transform: rotate(0deg);
      }

      100% {
        -webkit-transform: rotate(360deg);
      }
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>
  <style>
    .pc_block {
      margin: auto !important;
    }
  </style>
  <style>
    ins {
      margin: 0 auto !important;
    }
  </style>

</head>


<!-- Main content -->
<section class="content">
  <div class="box box-primary">
    <div class="box-header">
      <div class="container text-center">

        <form id="upload-widget" method="post" action="upload.php" class="dropzone">
          <div class="dz-message d-flex flex-column">
            <i class="material-icons text-muted">cloud_upload</i>
            Drag &amp; Drop here SRT,ASS,SUB,SBV,VTT,STL Subtitle file or click
          </div>

        </form>
      </div>
    </div>
  </div>
</section>


<script type="text/javascript">
  Dropzone.options.uploadWidget = {
    accept: function(file, done) {
      done();
    },
    paramName: 'file',
    acceptedFiles: '.srt,.ass,.vtt,.stl,.sub,.sbv',
    maxFiles: 1,
    init: function() {
      this.on('success', function(file, resp) {
        window.location.href = 'subtitle.php?srt=' + file.name;
      });
    }
  };
</script>
<script>
  $('#complete').click(function() {
    $('#myModal').modal('hide');
    $('#myModal1').modal('show');

  });
</script>

</html>
<?php include_once("code/template/footer.php"); ?>