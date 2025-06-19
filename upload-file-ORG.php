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
</style>
<!-- Main content -->
<section class="content">
	<!-- general form elements -->
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Upload Subtitle</h3>
		</div>
		<!-- /.box-header -->
		<!-- form start -->
		<form role="form" action="upload-file.php" method="post" enctype="multipart/form-data">
			<div class="box-body">
				<?php if ($success_message  != "") { ?>
					<div class="callout callout-success"><?php echo $success_message; ?></div>
				<?php } ?>
				<?php if ($error_message != "") { ?>
					<div class="callout callout-danger"><?php echo $error_message; ?></div>
				<?php } ?>
				<div class="form-group">
					<label for="description">Subtitle Name (optional)</label>
					<input type="text" id="description" name="description" placeholder="Enter Subtitle Name (optional)" class="form-control">
					<!-- <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea> -->
				</div>
				<div class="form-group">
					<label for="upload">File input</label>
					<input type="file" id="upload" name="upload" />
				</div>
			</div>
			<!-- /.box-body -->

			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
	<!-- /.box -->
</section>

</html>
<!-- /.content -->
<?php
include_once("code/template/footer.php");
?>