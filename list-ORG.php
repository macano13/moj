<?php
require_once('config.php');
require_once(ABSPATH . '/code/post/delete-file-post.php');
$user = getUserFromSession();

$searchTerm = '';
$subtitles_amount = 5000;
$data = '';

if (IS_POST() && isset($_POST['search_term']) || isset($_POST['subtitles_amount'])) {
	$searchTerm = $_POST['search_term'];
	$subtitles_amount = $_POST['subtitles_amount'];

	db_getUploadsByUserId($user->id, $searchTerm, $subtitles_amount);
}
$data = db_getUploadsByUserId($user->id, $searchTerm, $subtitles_amount);
include_once("code/template/header.php");
?>

<?php
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">Subtitle Tools</h3>
					<!-- <form class="form-inline" action="list.php" method="POST" name="searchForm" class="listSearchForm">
						<div class="form-group">
							<input type="text" class="form-control" name="search_term" placeholder="Search Subtitle">
						</div>
						<div class="form-group">
							<select name="subtitles_amount" class="form-control">
								<option value="20">20</option>
								<option value="30" selected>30</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</div>
						<button type="submit" class="btn btn-default">Search</button>
					</form> -->
				</div>
				<?php if ($success_message  != "") { ?>
					<div class="callout callout-success"><?php echo $success_message; ?></div>
				<?php } ?>
				<?php if ($error_message != "") { ?>
					<div class="callout callout-danger"><?php echo $error_message; ?></div>
				<?php } ?>
				<!-- /.box-header -->
				<?php if ($data) { ?>
					<div class="box-body table-responsive" style="min-height:80vh">
						<table id="filelist" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Type</th>
									<!-- <th>Size</th> -->
									<th>Modified</th>
									<th>Uploaded</th>
									<th>Edit/Translate</th>
									<th>Convert</th>
									<th>Share</th>
									<th>Action</th>
									<th>Delete</th>
								</tr>
							</thead>
							<!-- substr($file, 0, strrpos($file, '.')) -->
							<tbody>
							<?php foreach ($data as $key => $item) { ?>
								<tr>
									<td><?php echo ++$key; ?></td>
									<?php $name = pathinfo($item->file_name, PATHINFO_FILENAME); ?>
									<td contenteditable="" class="txtName">
										<?php //echo isset($name) && $name != '' ? $name: $item->description; ?>
										<?php echo $item->description; ?>
									</td>
									<td>
										<?php echo getFileTypeIcon($item->file_type); ?>
										<p style="display:none"><?php echo $item->file_type?></p>
									</td>
									<!-- <td><?php //echo $item->size; ?> bytes</td> -->
									<td><?php echo $item->modified_date; ?></td>
									<td><?php echo $item->creation_date; ?></td>
									<td>
										<a href="<?php HREF('/subtitle.php?subtitle=' . $item->db_file_name . '&createdBy=' . $item->created_by); ?>">
											<i class="fa fa-pencil"></i> <i class="fa fa-language" aria-hidden="true"></i>
										</a>
									</td>
									<td>
										<a href="<?php HREF('/converter.php?filename=' . $item->db_file_name); ?>">
											<i class="fa fa-exchange"></i>
										</a>
									</td>
									<td>
										<div class="dropdown">
											<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
												<i class="fa fa-share-alt"></i><span class="caret"></span>
											</button>
											<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
												<li>
													<a href="http://www.facebook.com/sharer.php?u=<?php echo 'https://vip.translatesubtitles.co/download.php?id=' . $item->description . '%26createdId=' . $item->created_by; ?>">FaceBook</a>
												</li>
												<li>
													
													<a  data-toggle="modal" data-target="#myModal" class="sendMail" style="cursor:pointer"
														data-sendmailurl="<?php HREF('/download.php?id='.$item->description. '&createdId='.$item->created_by. '&external_download=1');?>">
														Email
													</a>
												</li>
											</ul>
										</div>
									</td>
									<td>
										<a href="javascript:void(0);" target="_top" onclick="window.location.href='<?php HREF('/download.php?id=' . $item->description . '&createdId=' . $item->created_by); ?>';" data-file-id="<?php echo $item->db_file_name; ?>" class="btn btn-social btn-dropbox">
											<i class="fa fa-download"></i>Download
										</a>
									</td>
									<td>
										<form action="list.php" method="post" name="deleteForm">
											<input type="hidden" name="deleteid" class="deleteid" value="<?php echo $item->id ?>">
											<button type="submit"><i class="fa fa-trash"></i></button>
										</form>
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>				
					</div>
				<?php } ?>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>
<style>

	#filelist th, #filelist td {
		border: none;
	}
	table.dataTable.no-footer {
		border: none
	}
	.container {
		position: relative;
	}
	#loader-wrapper {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 1000;
		background-color: rgba(0, 0, 0, 0.3);
	}
	#loader {
		display: block;
		position: relative;
		left: 50%;
		top: 50%;
		width: 100px;
		height: 100px;
		margin: -50px 0 0 -50px;
		border-radius: 50%;
		border: 3px solid transparent;
		border-top-color: #3498db;
		-webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
		animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
	}
	
	#loader:before {
		content: "";
		position: absolute;
		top: 5px;
		left: 5px;
		right: 5px;
		bottom: 5px;
		border-radius: 50%;
		border: 3px solid transparent;
		border-top-color: #e74c3c;
		-webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
		animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
	}
	
	#loader:after {
		content: "";
		position: absolute;
		top: 15px;
		left: 15px;
		right: 15px;
		bottom: 15px;
		border-radius: 50%;
		border: 3px solid transparent;
		border-top-color: #f9c922;
		-webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
		animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
	}
	
	@-webkit-keyframes spin {
		0%   {
			-webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
			-ms-transform: rotate(0deg);  /* IE 9 */
			transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
		}
		100% {
			-webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
			-ms-transform: rotate(360deg);  /* IE 9 */
			transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
		}
	}
	@keyframes spin {
		0%   {
			-webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
			-ms-transform: rotate(0deg);  /* IE 9 */
			transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
		}
		100% {
			-webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
			-ms-transform: rotate(360deg);  /* IE 9 */
			transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
		}
	}
	
</style>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div id="loader-wrapper" style="display:none">
		<div id="loader"></div>
	</div>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Send File Link Via Email</h3>
				<div class="alert" id="mailSendAlert" style="display:none"></div>
			</div>
			<div class="modal-body">
			<div class="form-group">
				<div>
				    <label>Email Body</label>
				</div>
				<input type="email" id="sendMailemail" class="form-control" placeholder="Email">
			</div>
			<div class="form-group">
				<div>
				    <label>Email Body</label>
				</div>
				<textarea  class="form-control" cols="54" id="mailBody"></textarea>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block btn-flat" id="mailSend">Send</button>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	// const sendMailLink = document.getElementsByClassName('sendMail')
	// document.getElementById('sendMail').addEventListener('click',function (e) {
	// 	document.getElementById('mailBody').value = this.dataset.sendmailurl
	// })

	const sendMailLink = document.getElementsByClassName('sendMail')
	if (sendMailLink != null) {
		for (var i = 0; i < sendMailLink.length; i++) {
			sendMailLink[i].addEventListener('click', function (e) {
				document.getElementById('mailBody').value = this.dataset.sendmailurl;
			}, false);
		}
	}

	// document.getElementById('sendMail').addEventListener('click',function (e) {
	// 	document.getElementById('mailBody').value = this.dataset.sendmailurl
	// })

	document.getElementById('mailSend').addEventListener('click', function (e) {
		let sendMailemail = document.getElementById('sendMailemail').value
		let mailLink = document.getElementById('mailBody').value
		let mailSendAlert = document.getElementById('mailSendAlert')
		let myModal = document.getElementById('myModal')
		let loaderWrapper = document.getElementById('loader-wrapper')
		
		loaderWrapper.style.display = 'block'
		$.ajax({
			url: '/code/post/sendDownloadfileLink.php',
			type: 'POST',
			data: {
				'email': sendMailemail,
				'mailBody': mailLink
			},
			success: function(response) {
			loaderWrapper.style.display = 'none'
				// console.log(data.message);
				// console.log(response);
				// console.log(response.status);
				// if (data.message == 1) {
				// 	console.log('test');
					mailSendAlert.classList.add('alert-success')
					mailSendAlert.style.display = 'block'
					mailSendAlert.innerHTML = "Success!"
					
				// } else{
				// 	mailSendAlert.classList.add('alert-danger')
				// 	mailSendAlert.style.display = 'block'
				// 	mailSendAlert.innerHTML = "Failed!"
				// }
				myModal.style.display = 'none'
				// modal-backdrop fade in
				document.getElementsByClassName('modal-backdrop fade in')[0].style.display='none'
				sendMailemail = ''
				mailLink = ''
			},
			error: function(error) {
				loaderWrapper.style.display = 'none'
				mailSendAlert.classList.add('alert-danger')
				mailSendAlert.style.display = 'block'
				mailSendAlert.innerHTML = "Failed!"
				sendMailemail = ''
				mailLink = ''
			}
		});
	})
	const txtName = document.getElementsByClassName('txtName');
	for (let i = 0; i < txtName.length; i++) {
		txtName[i].addEventListener('focusout', function(e) {
			let txtId = document.getElementsByClassName('deleteid')[i].value;
			let updatedName = e.target.innerHTML;
			$.ajax({
				url: '/code/post/update-name.php',
				type: 'POST',
				dataType: 'json',
				data: {
					'id': txtId,
					'name': updatedName
				},
				success: function(data) {
					if (data == 'success') {
						alert("Name Updated successfully!");
					} else if (data == 'failed') {
						alert("Name Updated Failed!");
					}
				},
				error: function(error) {
					console.log("Somewthing Went wrong");
				}
			});
		})

	}
</script>

</html>
<!-- /.content -->
<?php
include_once("code/template/footer.php");
?>
<script>
	$(document).ready(function() {
		$('#filelist').DataTable({
			"pageLength": 10,
			"iDisplayLength": -1,
			"aoColumns":[
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false}
		]
		});
	});
</script>