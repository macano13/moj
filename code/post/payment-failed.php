<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
    
    if (isset($_GET['token'])) {
        $token = $_GET['token'];

        $_SESSION['paymentMessage'] = 'Failed! Unable to comeplete the payment '.$token;
        echo "<script>window.location.href ='/index.php?message=payment';</script>";
    }else {
        $result = array("status" => 400, "Message" => "Data missing");
        echo json_encode($result);
    }
    
?>