<?php
require_once('config.php');
require_once(ABSPATH . '/code/post/login-post.php');
//echo phpinfo();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VIP Translate Subtitles | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
  @media only screen and (max-width: 1086px) {
.flexing {
    justify-content: center;
    display: flex;
    flex-wrap: wrap;

}
}

ol, ul {
list-style: none!important;
text-align: left!important;
}

p {
	font-size: 16px;
    font-weight: 600;
    text-shadow: 8px 5px 15px grey;
}
}
img.slika {
  
 width: 180px!important;
}

img.vip-slika {
width: 80px
}

.flexing {
	padding-top: 2%;
	padding-left: 3%;
	padding-rigt: 3%;
	
}

.fa {
color: #2ebb2e!important;
}

.crta {
   
    width: 100%;
    
    color: lawngreen;
    background: transparent;
    animation: crtica 2s linear;
    animation-direction:alternate;
  

}

@keyframes crtica {
    0% {

        width: 20%;
        color: rgb(18, 236, 127);
        background: rgb(18, 236, 127);
        height: 1px;
    }
    25% {
        width: 50%;
        color: rgb(18, 236, 127);
        background: rgb(18, 236, 127);
        height: 1px;
    }
    50% {
        width: 70%;
        color: rgb(18, 236, 127);
        background: rgb(18, 236, 127);
        height: 1px;
    }
    75% {
        width: 85%;
        color: rgb(18, 236, 127);
        background: rgb(18, 236, 127);
        height: 1px;
    }
    100% {
        width: 100%;
        color: rgb(18, 236, 127);
        background: rgb(18, 236, 127);
        height: 1px;
    }
}
hr {
margin-top: 2px!important;
}
</style>
</head>
<div class="demo" style="text-align: center;">
                <button class="btn btn-danger"  style="margin-top: 20px;" data-toggle="modal" data-target="#myModal">Request Demo
                </button>
				</div>

            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Request Demo Account</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <form action="report-mail.php" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Your Email</label>
                                    <input type="email" name="email" class="form-control">
                                    <input type="hidden" name="report_url" class="form-control"
                                           value="<?php $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']
                                               === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                                           echo $link;  ?>">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="submit">Request Demo</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

<div class="flexing">
              <?php
            if (isset($_SESSION['report_error'])) {
                echo '<div class="alert alert-danger text-center" id="danger-alert" role="alert">Invalid Email Address</div>';
                unset($_SESSION['report_error']);
            }
            ?>

            <?php
            if (isset($_SESSION['mail_success'])) {
                echo '<div class="alert alert-success text-center" id="success-alert" role="alert">Request is successfully submitted we will send you the Demo information via Email address.</div>';
                unset($_SESSION['mail_success']);
            }
            ?>
<div class="price-single type-black shadow" style="padding-top: 0px;">
<img src="vip.png" class="vip-slika" alt="">
<h3>VIP<span> Account</span></h3>
<p class="price">
€2.99<span>/month</span>
</p>
<ul>
<hr/ class="crta">
<li><i class="fa fa-check-square-o" aria-hidden="true"></i> Supported Subtitle Formats: SRT,SBV,SUB,ASS,VTT,STL</li>
<hr/ class="crta">
<li><i class="fa fa-check-square-o" aria-hidden="true"></i> Unlimited Subtitle Translations</li>
<hr/ class="crta">
<li><i class="fa fa-check-square-o" aria-hidden="true"></i> Unlimited Subtitle Uploads</li>
<hr/ class="crta">
<li><i class="fa fa-check-square-o" aria-hidden="true"></i> Unlimited Subtitle Converting</li>
<hr/ class="crta">
<li><i class="fa fa-check-square-o" aria-hidden="true"></i> External Subtitle Database Access</li>
<hr/ class="crta">
<li><i class="fa fa-check-square-o" aria-hidden="true"></i> Unlimited Subtitle Downloads</li>
<hr/ class="crta">
<li><i class="fa fa-check-square-o" aria-hidden="true"></i> Save Subtitle as a Draft (continue editing later)</li>
<hr/ class="crta">
<li><i class="fa fa-check-square-o" aria-hidden="true"></i> Share Subtitles</li>
<hr/ class="crta">
<li><i class="fa fa-check-square-o" aria-hidden="true"></i> Regular Updates</li>
<hr/ class="crta">
<li><i class="fa fa-check-square-o" aria-hidden="true"></i> Knowledge Base</li>
<hr/ class="crta">
<li><i class="fa fa-check-square-o" aria-hidden="true"></i> VIP Support</li>
<hr/ class="crta">
</ul>
</div>
<div class="images">
<p>Video demostration</p>
<img src="video-translate.gif" class="slika" alt="translating">

</div>

<body class="hold-transition login-page">

<div class="login-box">
<div class="login-logo">
    <a href="login.php"><b>VIP </b>Translate Subtitles</a>
<br>
<h3>You can get VIP via Patreon donate</h3>
<p><a target="_blank" rel="noopener noreferrer" href="https://www.patreon.com/join/TranslateSubtitles/checkout?rid=9945220">
            <img src="patreon-logo.webp" align="middle" height="80" width="170">
          </a></p>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php
    if($error_message != ""){ ?>
    <div class="callout callout-danger">
    <?php echo $error_message; ?>
              </div>
   <?php } ?>
    
    <form action="login.php" method="post">
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
			 <div class="dugmadi">
	     <button onclick="location.href='pass/index.php'" class="btn btn-primary"  type="button">
         I forgot my password</button><br/><br/>
	<button onclick="location.href='register.php'" class="btn btn-primary" type="button">
         Register a new membership</button>
		 </div>
     </div>
</form>



  <!-- /.login-box-body -->

</div>
</div>
</div>
<!-- /.login-box -->

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
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green',
      increaseArea: '20%' // optional
    });
  });
</script>
<script>

$('.slika').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=FQiPvsNTsPI'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});
</script>
<script>
$("#success-alert").fadeTo(5000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
});

$("#danger-alert").fadeTo(5000, 500).slideUp(500, function(){
    $("#danger-alert").slideUp(500);
});



</script>
<!-- GetButton.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+38765217359", // WhatsApp number
            email: "support@translatesubtitles.com", // Email
            call_to_action: "Message us", // Call to action
            button_color: "#000000", // Color of button
            position: "right", // Position may be 'right' or 'left'
            order: "whatsapp,email", // Order of buttons
            pre_filled_message: "Need Support?", // WhatsApp pre-filled message
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget -->
</body>
</html>
