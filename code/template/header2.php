
<!DOCTYPE html>
<html>
<head>
  <!-- <meta charset="UTF-8"> -->
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title class="notranslate">Translate Subtitles VIP</title>
  <!-- Tell the browser to be responsive to screen width -->
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" href="favicon.png" type="image/ico" sizes="32x32">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.min.css">
  <link rel="stylesheet" href="/content/lib/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
  <link rel="stylesheet" href="/content/lib/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/content/lib/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/content/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/content/css/skins/_all-skins.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
   
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="/content/css/custom.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="notranslate logo-mini"><b>VI</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="notranslate logo-lg"><b>VIP</b>Client Area</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="javascript:void(0);">
              <img src="/content/img/user2-160x160.png" class="user-image" alt="User Image">
              <?php $user = getUserFromSession(); ?>
              <span class="notranslate hidden-xs"><?php echo $user->name; ?></span>
            </a>
            
          </li>
          <li class="dropdown user user-menu">
            <a href="logout.php">
              <span class="notranslate hidden-xs">Log Out</span>
              <i  class="fa fa-sign-out"></i>
            </a>
            
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->
  
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
     
      <ul class="notranslate sidebar-menu" data-widget="tree">
        <?php if ($user->user_role == 1) { ?>
          <li><a href="<?php HREF('/user_list.php'); ?>"><i class="fa fa-circle-o text-green"></i> <span>User List</span></a></li>
          <li><a href="<?php HREF('/currency.php'); ?>"><i class="fa fa-circle-o text-green"></i> <span>Currency</span></a></li>
        <?php } ?>
        <li><a href="<?php HREF('/payment.php'); ?>"><i class="fa fa-circle-o text-green"></i> <span>Payment</span></a></li>
        
        <?php if ($user->expire_date != null) { ?>
          <?php 
            $todayDate = Date('Y-m-d');
            $extendExpiredDate = date("Y-m-d", strtotime($user->expire_date ." +10 days"));
            if ($todayDate < $extendExpiredDate && $user->is_active != 2) { 
          ?>
            <li><a href="<?php HREF('/upload-file.php'); ?>"><i class="fa fa-circle-o text-red"></i> <span>Upload Subtitle</span></a></li>
            <li><a href="<?php HREF('/list.php'); ?>"><i class="fa fa-circle-o text-yellow"></i> <span>Subtitle Tools</span></a></li>
            <div class="flask-frontend-container">
    <iframe src="https://vip.translatesubtitles.co/search/" width="100%" height="800px" style="border:none;"></iframe>
</div>

            <li><a href="<?php HREF('/knowledge.php'); ?>"><i class="fa fa-circle-o text-purple"></i> <span>Knowledge Base</span></a></li>
            <li><a href="<?php HREF('/contact/formpage.php'); ?>"><i class="fa fa-circle-o text-rose"></i> <span>Support</span></a></li>
            <li><a href="<?php HREF('/blog.php'); ?>"><i class="fa fa-circle-o text-white"></i> <span>Blog News</span></a></li>
            <li><a href="<?php HREF('/faq.php'); ?>"><i class="fa fa-circle-o text-white"></i> <span>FAQ</span></a></li>
          <?php } ?>
        <?php } ?>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <div class="content-wrapper">
 