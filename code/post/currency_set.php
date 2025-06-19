<?php 
    $error_message = "";
    $success_message = "";
    if (IS_POST() && isset($_POST['currencyId'])) {
        $defaultID = $_POST['currencyId'];
        $amount = $_POST['currencyAmount'];

        $res = db_updateCureencyDefault($defaultID,$amount);

        if ($res) {

            $success_message = "Data deleted Successfully!";
        }else{
            $error_message = "Data deleted Failed!";
        }

    }
?>