<?php
require_once('config.php');
require_once(ABSPATH . '/code/post/upload-file-post.php');
include_once("code/template/header.php");

if ($user->expire_date == null) {
	echo "<script>window.location.href ='/payment.php';</script>";
} else {
	$extendExpiredDate = date("Y-m-d", strtotime($user->expire_date . " +10 days"));
	$todayDate = Date('Y-m-d');
	if ($todayDate > $extendExpiredDate) {
		echo "<script>window.location.href ='/payment.php';</script>";
	}
}

if ($user->is_active == 2 || $user->is_active == 0) {
	echo "<script>window.location.href ='/payment.php';</script>";
}
?>
<html lang="en">
<style>
.h3, h3 {
    font-size: 24px!important;
    text-shadow: 5px 4px 8px grey;
}

.dugme {
	height: 50%;
}

.card {
    text-align: left!important;
    max-width: 100%!important;
    height: auto!important;
	margin: 10px!important;
}
.red {
	border: 3px solid red!important;
}

.check {
    font-size: 30px;
    color: lightgreen;
}
	
</style>

<!-- Main content -->
<section class="content">
	<!-- general form elements -->
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Blog News</h3>
			<p class="h5">In this section you can see which updates have been done and which updates will be done next.</p>
			<p class="h5">The box marked in green means that the update is complete. The box marked in red means that the update will be soon.</p>
		</div>
		
	  <div class="card w-75 red">
  <div class="card-body " style="border: border: 3px solid red;">
    <h4 class="card-title">Multi Language Translator</h4>
    <p class="card-text">We are trying to create a Multi language translator in the future where you will be able to select one subtitle file and translate it into several different languages.</p>
    
  </div>
</div>	

  <div class="card w-75 red">
  <div class="card-body " style="border: border: 3px solid red;">
    <h4 class="card-title">Upgrade mini pop up window User settings</h4>
    <p class="card-text">We will create a pop up window on the click of your username where you will be able to change your username and password.</p>
    
  </div>
</div>

  <div class="card w-75">
  <div class="card-body " style="border: border: 3px solid lightgreen;">
    <h4 class="card-title">Multi subtitle translator implemented</h4>
    <p class="card-text">The Multi subtitle translator has been successfully integrated where you can translate up to 15 subtitle files at once. Please check out the Knlowledge Base video section to get acquainted with how it works.</p>
    <span class="check">&#10003;</span>
  </div>
</div>

  <div class="card w-75">
  <div class="card-body " style="border: border: 3px solid lightgreen;">
    <h4 class="card-title">Delete all subtitle files on the page</h4>
    <p class="card-text">The function has been successfully integrated, where you will be able to delete all the files you mark on the page with one click.</p>
    <span class="check">&#10003;</span>
  </div>
</div>

<div class="card w-75">
  <div class="card-body" style="border: border: 3px solid lightgreen;">
    <h4 class="card-title">Subtitle upload issue fixed</h4>
    <p class="card-text">We just fixed the issue with upload subtitle files, some subtitles could not be uploaded because they had foreign characters or spaces in them, now we have fixed it and automatically after uploading the subtitle file it will get its proper name.</p>
    
<span class="check">&#10003;</span>
  </div>
</div>

	</div>
	<!-- /.box -->
</section>

</html>
<!-- /.content -->
<?php
include_once("code/template/footer.php");
?>