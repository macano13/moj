<?php
require_once('config.php');

include_once("code/template/header.php");
?>
<html lang="en">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-primary">
        <?php if (isset($_GET['message']) && $_GET['message'] === 'payment') { ?>
            <div class="alert alert-success">
                <?php 
                  echo isset($_SESSION['paymentMessage']) ? $_SESSION['paymentMessage'] : '';
                  unset($_SESSION['paymentMessage']) ;
                ?>
            </div>
        <?php } ?>
      </div>
      <!-- /.box -->
      <?php 
        
        $extendExpiredDate = date("Y-m-d", strtotime($user->expire_date ." +10 days") );
        $todayDate = Date('Y-m-d');
        if ($todayDate > $extendExpiredDate) {
      ?>
        <h2 class='text-center'>Your payment time has been expired. Please pay to get your full access</h2>
      <?php  } ?>
      <?php if ($user->is_active == 2) { ?>
        <h2 class='text-center'>Your accound suspended. Please contact with authority</h2>
      <?php } ?>
    </section>
</html>
    <!-- /.content -->
    <?php
include_once("code/template/footer.php");
?>
 