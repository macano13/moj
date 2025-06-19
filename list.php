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

$folder = uniqid();

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

<script rel="preload" src="js/bootbox.min.js" as="script"></script>

<html lang="en">
<style type="text/css">
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
		.loading{
			font-size:16px;
			padding-right:10px;
			display:none;
		}
		.loading-bg{
			background-image:url("loading.gif");
			background-repeat: no-repeat;
			background-position: center;
			
		}
		.done{
			background-image:url("done.png");
			background-repeat: no-repeat;
			background-position: center;
			background-size: auto 300px;
		}
		.select-img{
			background-image:url("select.png");
			background-repeat: no-repeat;
			background-position: center;
			background-size: auto 300px;
		}
		
		#msgbox{
			font-size: 14px;
			font-weight: bold;
			text-align: center;
			margin-bottom: 10px;
		}
		.transmullateModal{
			width:100% !important;
		}
		#tr_content{
			display:none1;
			max-height:700px;
			overflow:auto;
			opacity:0;
			font-size:1px;
		}
		#tr_content .table2{
			
			width:25% !important;
			max-width:25% !important;
			float:left !important;
			
		}
		#tr_content .notranslate{
			display:none;
		}
		#google_translate_element{
			display:none;
		}
		#downloadall{
			display:none;
		}
		.processing-span{
			float:left;
			display:none;
			font-size:18px;
			font-weight:bold;
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
    
    <style type="text/css">
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
    <style type="text/css">
        #loaderModal {
            text-align: center;
            position: fixed;
            left: 50%;
            top: 65%;
            transform: translate(-50%, -50%);
        }
    </style>
    <style>
        #popup {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 99;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .5);
            display: none;
        }

        #error-popup {
            width: 400px;
            height: 200px;
            position: fixed;
            z-index: 100;
            top: 50vh;
            left: 50%;
            background: #fff;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #error-popup>span {
            position: absolute;
            right: 8px;
            top: 5px;
            color: #ba0d0d;
            font-weight: 700;
            font-size: 20px;
        }

        #error-popup>span:hover {
            cursor: pointer;
        }

        #error-popup p {
            /*position: absolute;*/
            /*padding-left: 10px;*/
            /*padding-right: 10px;*/
            /*text-align: center;*/
            /*top: 50%;*/
            font-size: 20px;
            /*transform: translateY(-50%);*/
        }

        #error-popup p span {
            color: #ba0d0d;
            font-size: 30px;
            font-weight: 600;
        }

        .translated-sub {
            display: none;
        }

        #text-to-translate {
            visibility: hidden;
            position: absolute;
            top: 150px;
            height: calc(600px);
            overflow: scroll;
        }

        /*loader*/
        #loader {
            margin: auto;
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: rgba(241, 242, 243, 0.6);
        }

        #loader h4 {
            font-size: 16px;
            letter-spacing: 10px;
            font-weight: 900;
        }

    .success-msg {
    max-width: 100%;
    border-radius: 5px;
    font-size: 15px;
    height: 40px;
    text-align: center;
    padding: 10px;
    background: green;
    color: white;
    font-weight: 600;
    display: none;
	
	animation:success-msg 0.5s 1;
    -webkit-animation:success-msg 0.5s 1;
    animation-fill-mode: forwards;
    
    animation-delay:7s;
    -webkit-animation-delay:6s; /* Safari and Chrome */
    -webkit-animation-fill-mode: forwards;
    
} 

@keyframes success-msg{
    from {opacity :1;}
    to {opacity :0;}
}

@-webkit-keyframes success-msg{
    from {opacity :1;}
    to {opacity :0;}
}
        }
    </style>
    <style type="text/css">
        iframe.goog-te-banner-frame {
            display: none !important;
        }
    </style>
    <style type="text/css">
        body {
            position: static !important;
            top: 0px !important;
        }

.goog-te-gadget .goog-te-combo {

     border-radius: 8px!important;
}
    </style>
    <style type="text/css">
        #loaderModal {
            text-align: center;
            position: fixed;
            left: 50%;
            top: 65%;
            transform: translate(-50%, -50%);
        }
    </style>
<style>
.h3, h3 {
    font-size: 24px!important;
    text-shadow: 5px 4px 8px grey;
	width:100%;
}
.translate_multi{
	float:right;
	margin-right:5px;
}
.delete_multi{
	float:right;
	margin-right:5px;
}
</style>
 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<section class="content notranslate">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">Subtitle Tools
                     <div>
                
                <button type="button" class="btn translate_multi">Multi Translate</button>
                <button type="button" class="btn delete_multi">Delete</button>
                
                
                <a style="display:none;" data-toggle="modal" data-target="#transmullateModal" class="showmodal" style="cursor:pointer">
														ewtranslate
													</a>
                
                
                <br>
            </div>	
                        
                    
                    </h3>
					<!-- <form class="form-inline" action="list.php" method="POST" name="searchForm" class="listSearchForm">
						<div class="form-group">
							<input type="text" class="form-control" name="search_term" placeholder="Search Subtitle">
						</div>
						<div class="form-group">
							<select name="subtitles_amount" class="form-control">
                                                                 <option value="15">15</option>
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
                <div class="ajax-msgs"></div>
				<!-- /.box-header -->
				<?php if ($data) { ?>
					<div class="box-body table-responsive" style="min-height:80vh">
						<table id="filelist" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
                                	<th style="padding: 8px 10px;"><input type="checkbox" class="checkall" /></th>
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
								<tr class="row_<?php echo $item->id ?>">
                               	
<td>
                                    	<input type="checkbox" cid="<?php echo $item->id ?>" value="<?php HREF('/api.php?subtitle=' . $item->db_file_name . '&createdBy=' . $item->created_by); ?>" class="cb-element" />
                                    </td>

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
										<a href="javascript:void(0);" target="_top" onClick="window.location.href='<?php HREF('/download.php?id=' . $item->description . '&createdId=' . $item->created_by); ?>';" data-file-id="<?php echo $item->db_file_name; ?>" class="btn btn-social btn-dropbox">
											<i class="fa fa-download"></i>Download
										</a>
									</td>
									<td>
                                    
                                    	<button type="button" class="delete_single" cid="<?php echo $item->id ?>"><i class="fa fa-trash"></i></button>
                                        
                                        
										<form action="list.php" method="post" name="deleteForm">
											<input type="hidden" name="deleteid" class="deleteid" value="<?php echo $item->id ?>">
											
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
<div class="modal fade notranslate" id="transmullateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div id="loader-wrapper2" style="display:none">
		<div id="loader2"></div>
	</div>
	<div class="modal-dialog transmullateModal" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Translate and Download multiple files
                	<!--<button type="button" id="start_translation" style="float:right;">Start Translation</button>-->
                </h3>
			</div>
			<div class="modal-body translate-body select-img">
					<div id="google_translate_element"></div>
                    <div id="msgbox"></div>
                    
                    <div class="translate" id="tr_content"></div>
                    
			
			</div>
			<div class="modal-footer">
            	<span class="processing-span"></span>
            	<span class="loading">Please wait...</span>
            	<button type="button" class="btn btn-default" id="downloadall">Download</button>
				<button type="button" class="btn btn-default close-modal-btn" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>




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

<form id="downlform" method="post" action="downloadall.php" target="_blank">
	<input type="hidden" name="folder" value="<?=$folder; ?>" />
    <input type="hidden" name="data" id="dataval" value="" />
</form>
<script type="text/javascript">
	// const sendMailLink = document.getElementsByClassName('sendMail')
	// document.getElementById('sendMail').addEventListener('click',function (e) {
	// 	document.getElementById('mailBody').value = this.dataset.sendmailurl
	// })
	
	function googleTranslateElementInit() {
		
        new google.translate.TranslateElement({}, 'google_translate_element');
    }

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

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" rel="noreferrer"></script>

</html>
<!-- /.content -->
<?php
include_once("code/template/footer.php");

?>
<script>

	var totfiles = 0;
	var folder = "<?=$folder; ?>";
	
	//var pagelength = 15;
	
	
	$(document).ready(function() {
		
		
		
		$(document).on("click", ".checkall", function(){
			
			var ischk = $(".checkall").prop('checked');
			
			if(ischk == true){
				
				//var checked = 0;
				
				$('.cb-element').prop('checked',true);
				
				//$('.cb-element').each(function(i, obj) {
				//	checked = checked + 1;
					
					//if(checked < 16){
						$(this).prop('checked',true);
					//}
					
				//});
				
				
				
				
				
			}
			else{
				$('.cb-element').prop('checked',false);
			}
		});
		
		var inprocess = 0;
		var called = 0;
		var downfiles = [];
		
	$(document).on("click", "#downloadall", function(){
		
		
		
		
		
			
			inprocess = 0;
			called = 0;
			downfiles = [];
			$("#downloadall").hide();
			$(".loading").show();
			
			//alert(totfiles);

		//$("#tr_content").show();
			
		for(var i=0; i<totfiles; i++){
			
				var cid = "trasrt_" + i;
				
				var did = "#trasrt_" + i;
				var php_var = $(did).attr("cid");
				
				var table = document.getElementById(cid);
				var jsonArr = [];
				for (var e = 1, row; row = table.rows[e]; e++) {
					var col = row.cells;
					var jsonObj = {
						id: col[0].innerText,
						start: col[1].innerText,
						end: col[2].innerText,
						text: col[4].innerText
	
					}
	
					jsonArr.push(jsonObj);
	
				}
				var trasrt = JSON.stringify(jsonArr);
				//alert("done");
				getgenratfile(trasrt,php_var, folder );
				inprocess = inprocess + 1;
				
			}
	});
		
		function getgenratfile(trasrt,php_var, folder ){
			
			$.ajax({
					type: "POST",
					url: "genmulti.php",
					data: {
						data: trasrt,
						file: php_var,
						folder:folder
					},
					cache: false,
	
					success: function(data) {
						//console.log(data);
						
						downfiles.push(data);
						
						var downfilesdata = JSON.stringify(downfiles);
						$("#dataval").val(downfilesdata);
						
						inprocess = inprocess - 1;
						
						setTimeout(function() {
							if(inprocess == 0 && called == 0){
								downloadfun();
							}
						  }, 1000);
						
					}
				});
			
		}
		
		function downloadfun(){
			called = 1;
			$(".close-modal-btn").trigger("click");
			$("#downlform").submit();
			//$("#tr_content").hide();
		}
		
		
		
		$(document).on("click", ".translate_multi", function(){
			
			var achk = 0;
			totfiles = 0;
			
			$("#transmullateModal select").prepend("<option value=''>Select Language</option>").val('');
			$("#transmullateModal select").trigger("change");
			
			$("#downloadall").show();
			$(".loading").hide();
			$("#msgbox").show();
			$("#google_translate_element").hide();
			$("#downloadall").hide();
			$(".processing-span").hide();
			$(".processing-span").text("");
			
			$(".translate-body").removeClass("loading-bg");
			$(".translate-body").removeClass("done");
			$(".translate-body").addClass("select-img");
			
			if(typeof timer_gear !== "undefined"){
			  clearTimeout(timer_gear);
			}
			
			$('.cb-element').each(function(i, obj) {
				var inchk = $(this).prop("checked");
				if(inchk == true){
					achk = 1;
					totfiles = totfiles + 1;
				}
			});
			
			if(totfiles > 15){
				alert("Maximum 15 Subtitles can be translated at once.");
				return false;
			}
			
			if(achk == 0){
				alert("Please select at least one file");
				return false;
			}else{
				//show dialog box
				$("#tr_content").html('');
				$(".showmodal").trigger("click");
				
				$("#transmullateModal select").hide();
				
				$("#msgbox").html("1/" + totfiles + " file is processing" );
				var confile = 1;
				var cnt = -1;
				
				//tr_content
				$('.cb-element').each(function(i, obj) {
					var inchk = $(this).prop("checked");
					if(inchk == true){
						var callurlval = $(this).val();
						
						cnt = cnt + 1;
						
						
						$.ajax({
							url: callurlval + "&cnt="+ cnt,
							type: 'GET',
							//dataType: 'json',
							success: function(data) {
								$("#tr_content").append(data);
								console.log(confile + " and " + totfiles);
								if(confile < totfiles){
									confile = confile + 1;
								}
								
								$("#msgbox").html(confile + "/" + totfiles + " file is processing" );
								
								if(confile > totfiles){
									$("#msgbox").hide();
									$("#google_translate_element").show();
									$("#transmullateModal select").show();
								}
								
								/*
								if (data == 'success') {
									alert("Name Updated successfully!");
								} else if (data == 'failed') {
									alert("Name Updated Failed!");
								}
								*/
							},
							error: function(error) {
								console.log("Somewthing Went wrong");
							}
						});
						
						$("#msgbox").hide();
						$("#google_translate_element").show();
						
						
					}
				});
				
				
				
			}
			
		});
		
		
		
		
		
		$(document).on("click", ".cb-element", function(){
			
			//var chkd = 0;
			//$('.cb-element').each(function(i, obj) {
			//		var inchk = $(this).prop("checked");
			//		if(inchk == true){
			//			chkd = chkd + 1;
			//		}
			//	});
				
			var cschk = $(this).prop('checked');
			
			
			//if(cschk == true && chkd > 15){
			//	$(this).prop('checked', false);
			//	alert("Maximual 15 can be translated at once.");
			//	return false;
				
			//}
			
			
			
			if(cschk == false){
				$('.checkall').prop('checked',false);
			}else{
				
				//checkall if all
				var nochk = 1;
				$('.cb-element').each(function(i, obj) {
					var inchk = $(this).prop("checked");
					if(inchk == false){
						nochk = 0;
					}
				});
				
				if(nochk == 1){
					$('.checkall').prop('checked',true);
				}
				
			}
		});
		
		//var istranslating = 0;
		
		//$(document).on("click", "#start_translation", function(){
			//$(".translate-body").removeClass("done");
			//$(".translate-body").removeClass("select-img");
			//$(".translate-body").addClass("loading-bg");
			
			//$('#tr_content').scrollTop(0);
			//scrollTop: $('#tr_content').scrollTop( 0 );
			//istranslating = 1;
			
			//$("#start_translation").hide();
			
			//googleTranslateElementInit();
			
			
			//setTimeout(function() { 
				
					$("#transmullateModal select").trigger("change");
			//}, 1000);
		//});
		
		
		$(document).on("change", "#transmullateModal select", function(){
			
			$("#start_translation").hide();
			
			scrollTop: $('#tr_content').scrollTop( 0 );
			$("#transmullateModal select").hide();
			
			$("#downloadall").hide();
			movdedonw();
			$(".translate-body").removeClass("done");
			$(".translate-body").removeClass("select-img");
			$(".translate-body").addClass("loading-bg");
		});
		
		function movdedonw(){
			
			var scrollpos = $('#tr_content').scrollTop();
			var elmnt = document.getElementById("tr_content");
			var ht = elmnt.scrollHeight;
			
			//if(istranslating == 1){
			
				var chkpos = scrollpos + 700;
				
				if(chkpos  < ht){
					var newpos = scrollpos + 690;
					//alert(newpos);
					$('#tr_content').scrollTop(scrollpos + 690);
					
					var percentage = (scrollpos / ht ) * 100;
					percentage = percentage.toFixed(2);
					$(".processing-span").show();
					$(".processing-span").text("Processing " + percentage + "%");
					
					var timer_gear = setTimeout(function() { 
						movdedonw();
					}, 900);
				
				}else{
					$('#tr_content').scrollTop(scrollpos + 690);
					
					$(".processing-span").show();
					$(".processing-span").text("Completed. Please wait a sec");
					
					
					setTimeout(function() { 
						showdownloads();
					}, 3000);
				}
			
			//}else{
			//	istranslating = 0;
			//}
			
		}
		
		function showdownloads(){
			
			//$("#transmullateModal select").prepend("<option value=''>Select Language</option>").val('');
			
			$(".translate-body").removeClass("loading-bg");
			$(".translate-body").addClass("done");
			$(".processing-span").hide();
			$(".processing-span").text("");
			$("#downloadall").show();
			$("#transmullateModal select").show();
			//$("#start_translation").show();
		}
		
		
		
		
		$('#filelist').DataTable({
			"pageLength": 15,
			"iDisplayLength":1,
			"aaSorting": [],
			"aoColumns":[
			{"bSortable": false},
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
		
		
		
		
		var myTable = $('#filelist').DataTable();
		
		
		$(document).on("click", ".delete_single", function(){
			var ids = "";
			var cid = $(this).attr("cid");
			ids = cid;
			var curow = ".row_" + cid;
			
			$('#filelist').DataTable().row(curow).remove(1000).draw();
			
					$(".ajax-msgs").show();
					$(".ajax-msgs").addClass("callout");
					$(".ajax-msgs").addClass("callout-success");
					$(".ajax-msgs").text("Data deleted Successfully!");
					
					$.ajax({
						url: '/code/post/delete-multi-files-post.php',
						type: 'POST',
						data: {
							'ids': ids
						},
						success: function(response) {
							
						setTimeout(function() {
							
							$('.ajax-msgs').delay(1000).fadeOut('slow');
							
							$(".ajax-msgs").text("");
							$(".ajax-msgs").removeClass("callout");
							$(".ajax-msgs").removeClass("callout-success");
							
							
						  }, 10000);
							
						}
					})
			
		})
		
		$(document).on("click", ".delete_multi", function(){
			
			var selctdfiles = 0;
			
			$('.cb-element').each(function(i, obj) {
				var inchk = $(this).prop("checked");
				if(inchk == true){
					achk = 1;
					selctdfiles = selctdfiles + 1;
				}
			});
			
			if(selctdfiles == 0){
				alert("Please select at least one file");
				return false;
			}else{
				//row_
				
				var ids = "";
				
				$('.cb-element').each(function(i, obj) {
					var inchk = $(this).prop("checked");
					if(inchk == true){
						var cid = $(this).attr("cid");
						var curow = ".row_" + cid;
						ids = ids + "," + cid;

						//$('#filelist').DataTable().row(curow).fadeOut(200,function(){
						 //  $('#filelist').DataTable().row(curow).remove();
						//});
						
						$('#filelist').DataTable().row(curow).remove(1000).draw();

					}
				});
				
				if(ids != ""){
					$(".ajax-msgs").show();
					$(".ajax-msgs").addClass("callout");
					$(".ajax-msgs").addClass("callout-success");
					$(".ajax-msgs").text("Data deleted Successfully!");
					
					$.ajax({
						url: '/code/post/delete-multi-files-post.php',
						type: 'POST',
						data: {
							'ids': ids
						},
						success: function(response) {
							
						setTimeout(function() {
							
							$('.ajax-msgs').delay(1000).fadeOut('slow');
							
							$(".ajax-msgs").text("");
							$(".ajax-msgs").removeClass("callout");
							$(".ajax-msgs").removeClass("callout-success");
							
							
						  }, 10000);
							
						}
					})
					
				}
				
			}
			
			
		});
		
		
		
		
	});
</script>

