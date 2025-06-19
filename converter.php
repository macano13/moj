<?php
    require_once('config.php');
    require_once(ABSPATH . '/code/post/upload-translated-file.php');
    // $dir = "uploads/";
	// $files1 = scandir($dir);
    // foreach ($files1 as $key => $value) {
    //     if ($value != "." && $value != "..") {
	// 		array_map('unlink', glob($dir.$value."/*.*"));
	// 		if ($value != '.htaccess') {
	// 			rmdir($dir.$value);	
	// 		}
    //     }
    // }
	include_once("code/template/header.php");
	$user = getUserFromSession();

	if ($user->expire_date == null) {
		echo "<script>window.location.href ='/payment.php';</script>";
	}else{
		$extendExpiredDate = date("Y-m-d", strtotime($user->expire_date ." +10 days") );
		$todayDate = Date('Y-m-d');
		if ($todayDate > $extendExpiredDate) {
			echo "<script>window.location.href ='/payment.php';</script>";
		}
	}

	$file = '';
	if (isset($_GET['filename'])) {
		$fileName = $_GET['filename'];
		$file = $fileName;

		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		
		$res = db_getConvertedFileName($user->id,$fileName);

		$showfileName = $res->description.'.'.$ext;
	}
	if ($user->is_active == 2 || $user->is_active == 0) {
		echo "<script>window.location.href ='/payment.php';</script>";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Converter -->
	<link rel="stylesheet" href="styles/style.css"/>
	<script type="application/javascript" src="scripts/jquery.js"></script>
	<script type="application/javascript" src="scripts/main.js"></script>
</head>
	<!-- Main -->
<section class="content">
	<div class="box box-primary">
        <div class="box-header">
			<div class="converter-container">
				<div class="tool-content">
					
					<div class="page-description text-center" style="width: 90%; margin-left: 5%">Uploaded subtitle file</div>
					<div style="width: 100%; text-align: center; margin-top: 20px">
						<div id="converter-uploaded-file"></div>
						<div id="<?php echo $file != '' ? 'converter-uploaded-file-link':''?>">
							<?php echo isset($showfileName) && $showfileName != '' ? $showfileName : $file?>
						</div>
							<form id="upload-form" enctype="multipart/form-data" action="https://translatesubtitles.co/a/translate.php" method="post">

								<input hidden type="file" name="file" 
									id="file-upload-converter" class="file-input" 
									accept=".srt, .vtt, .stl, .sbv, .sub, .ass" style="display:none"/>
								<input type="hidden" name="input_fileName" id="input_fileName" value="<?php echo $file?>">
							</form>
						</div>
					</div>

					<div class="converter-format-select-container">
						<div class="converter-format-select-title">
							<label for="format-select">Select subtitle format</label>
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
						
					</div>
					<div class="tool-content">
						
						<div class="page-description" style="width: 90%; margin-left: 5%">Download or Save your converted subtitle file</div>
						<div style="width: 100%; text-align: center; margin-top: 20px">
							<?php if (!empty($file)) { ?>
								<button class="save-button" id="download-btn-converter-linkFile" disabled>
									
									<span style="margin-left: 4px;">DOWNLOAD</span>
								</button>
							<?php }else {?>
								<button class="save-button" id="download-btn-converter" disabled>
									
									<span style="margin-left: 4px;">DOWNLOAD</span>
								</button>
							<?php } ?>
							<form action="converter.php" method="post" style="display:inline-block">
								<input type="hidden" name="filePathUrl" id="filePathUrl" value="filePathUrl">
								<input type="hidden" name="converterIdentifier" id="converterIdentifier" value="1">
								<button type="submit" class="btn save-button" disabled id="btnSaveSubtitle" style="margin-top: -10px">
									Save Subtitle
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-body">
						<form action="generate2.php" method="post">
							<div class="form-group">
								<label>File name :</label>
								<input id="name" name="srt" class="form-control" type="text" readonly>
							</div>
							<div class="form-group">
								<label>Translate to: :</label>
								<select class="form-control" name="lang" id="sel1">
									<?php foreach ($result as $lang) {?>
									<option value="<?php echo $lang['code'] ?>"><?php echo $lang['name']; ?></option>
									<?php } ?>
								</select>
							</div>
							<button type="submit" id="complete" class="btn btn-default">Proceed</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


	<a id="dnl" href="" download hidden></a>
</section>

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
					document.getElementById("filePathUrl").value = e;
                    document.getElementById("btnSaveSubtitle").disabled  = false;
					document.getElementById('dnl').click();
				},
				error: function(e) {
					alert("There are one or more errors!")
				}
			})
		});

		$("#download-btn-converter-linkFile").click(function(){
			var extention = $("#format-select option:selected").val();
			let input_fileName = document.getElementById('input_fileName').value;

			$.ajax({
				url: 'extention_convert_download.php',
				type: 'POST',
				dataType : 'json',
				data: {
					'fileName': input_fileName,
					'extention': extention
				},
				success: function (data) {
					document.getElementById("dnl").href = data;
					document.getElementById("filePathUrl").value = data;
                    document.getElementById("btnSaveSubtitle").disabled  = false;
					document.getElementById('dnl').click();
				},
				error: function(error) {
					alert("Somewthing Went wrong");
				}
			});

		});

		$("#format-select").change(function(){
			let input_fileName = document.getElementById('input_fileName').value;
			var extention = $("#format-select option:selected").val();

			if(input_fileName != "") {
				$.ajax({
					url: 'extention_convert_download.php',
					type: 'POST',
					dataType : 'json',
					data: {
						'fileName': input_fileName,
						'extention': extention
					},
					success: function (data) {
						document.getElementById("dnl").href = data;
						document.getElementById("filePathUrl").value = data;
						document.getElementById("btnSaveSubtitle").disabled  = false;
						$("#download-btn-converter-linkFile").prop("disabled",false);
					},
					error: function(error) {
						alert("Somewthing Went wrong 1");
					}
				});
			}else{
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
						document.getElementById("filePathUrl").value = e;
						document.getElementById("btnSaveSubtitle").disabled  = false;
					},
					error: function(e) {
						alert("There are one or more errors!")
					}
				})
			}

		})
	</script>
</html>
<?php
include_once("code/template/footer.php");
?>