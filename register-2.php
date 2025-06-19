<?php
require_once('config.php');
require_once(ABSPATH . '/code/post/register-post.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VIP Translate Subtitles | Register</title>
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

.checkbox, .radio {

    padding-left: 20px!important;
}
.col-xs-4 {
    width: 43.33333333%!important;
    padding-left: 0!important;
}

.button-class {
	
    padding-top: 12%;
    padding-right: 65%;
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
  </style>
  </head>
  <div class="flexing">
<div class="price-single type-black shadow">
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
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
  <a href="login.php"><b>VIP </b>Translate Subtitles</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>
    <div class="box-body">
    <?php
    if($success_message  != ""){ ?>
    <div class="callout callout-success">
    <?php echo $success_message; ?>
              </div>
   <?php } ?>
    <?php
    if($error_message != ""){ ?>
    <div class="callout callout-danger">
    <?php echo $error_message; ?>
              </div>
   <?php } ?>
    <form action="register.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full name"/>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Retype password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> I agree to the <a href="terms.php">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div><br/><br/>
        <!-- /.col -->
		<div class="button-class">
		    <button onclick="location.href='login.php'" class="btn btn-primary login" style="display: flex;"type="button">
         LOGIN</button>
		 </div>
      </div>
    </form>

  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

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
</body>
</html>
