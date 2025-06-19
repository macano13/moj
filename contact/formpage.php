<?php
    require_once('../config.php');
	
	include_once("../code/template/header.php");
	
	?>
<!DOCTYPE html>
<style>
.h3, h3 {
    font-size: 24px!important;
    text-shadow: 5px 4px 8px grey;
}

.description {
	height: 250px!important;
	
}
.form-control {
    
    margin-bottom: 10px!important;
}

</style>
<html lang="en">
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header">
				<?php
            if (isset($_SESSION['report_error'])) {
                echo '<div class="alert alert-danger text-center" id="danger-alert" role="alert">Invalid Email Address</div>';
                unset($_SESSION['report_error']);
            }
            ?>

            <?php
            if (isset($_SESSION['mail_success'])) {
                echo '<div class="alert alert-success text-center" id="success-alert" role="alert">The message was sent successfully! We will get back to you soon via Email.</div>';
                unset($_SESSION['mail_success']);
            }
            ?>
					<h3 class="box-title">Support</h3>
    <head>
<link rel="icon" href="../favicon.png" type="image/ico" sizes="32x32">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contact Us</title>
        <div class="demo" style="text-align: center;">
                <button class="btn btn-danger"  style="margin-top: 20px;" data-toggle="modal" data-target="#myModal">Contact Support
                </button>
				</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="form.css" >
        <script src="form.js"></script>
		 <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.min.css">
  <link rel="stylesheet" href="/content/lib/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/content/lib/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/content/lib/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/content/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/content/lib/plugins/iCheck/square/green.css">
    </head>
    <body >
<div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Contact Us</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <form action="report-mail.php" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Your Email and Description</label>
                                    <input type="email" name="email" placeholder="Email" class="form-control">
                                    <input type="description" name="description" placeholder="Description" class="form-control description">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="submit">Send Message</button>
                                
                            </div>
                        </form>
                    </div>

                </div>
            </div>
		</div>
		</div>
		</div>
		</div>
		</section>
		<!-- jQuery 3 -->
<script src="/content/lib/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/content/lib/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/content/lib/plugins/iCheck/icheck.min.js"></script>
<!-- magnific-popup -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
		<script>
$("#success-alert").fadeTo(7000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
});

$("#danger-alert").fadeTo(5000, 500).slideUp(500, function(){
    $("#danger-alert").slideUp(500);
});



</script>
    </body>
</html>
<?php
include_once("../code/template/footer.php");
?>
