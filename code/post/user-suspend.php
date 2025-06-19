<?php 

    $error_message = "";
    $success_message = "";
    if (IS_POST() && isset($_POST['suspendId'])) {
        $suspendId = $_POST['suspendId'];

        $res = db_suspendUser($suspendId);

        if ($res) {
            $success_message = "Successfully!";
        }else{
            $error_message = "Failed!";
        }
    }
?>