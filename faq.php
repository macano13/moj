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


	.accordion {
  background-color: #F5F5F5;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
  margin: 3px;
}

.active, .accordion:hover {
  background-color: lightgreen;
}

.accordion:after {
  content: '\002B';
  color: #777;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

.active:after {
  content: "\2212";
}

.panel {
  padding: 0 18px;
  background-color: white;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
	
</style>

<!-- Main content -->
<section class="content">
	<!-- general form elements -->
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Frequently asked questions</h3>
			
		</div>

<button class="accordion">Can I upload more then one subtitle file?</button>
<div class="panel">
  <p>Yes, you can upload up to 20 subtitle files at once, please see in the Knowledge base section a video on how to do it.</p>
</div>

<button class="accordion">Can I translate a subtitle file into more than one language at once?</button>
<div class="panel">
  <p>Not yet, but we are working on the implementation of a Multi language translator where you will be able to translate one subtitle into more than one language at once.</p>
</div>

<button class="accordion">Can I subscribe annually for payment?</button>
<div class="panel">
  <p>Not for now, but we will make that option in the near future, where you will be able to subscribe to the annual payment..</p>
</div>
  



	</div>
	<!-- /.box -->
</section>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>
</html>
<!-- /.content -->
<?php
include_once("code/template/footer.php");
?>