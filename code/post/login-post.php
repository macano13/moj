<?php
$error_message = "";
if (IS_POST()) {

$db_user = db_getUserByEmailAndPwd($_POST["email"], $_POST["password"]);

if ($db_user) {
    setUserToSession($db_user);
    $user = $_SESSION["USER_INFO"];
    // $extendExpiredDate = date("Y-m-d", strtotime($user->expire_date . " +10 days"));
    // $todayDate = Date('Y-m-d');
    // if (($user->expire_date != $todayDate) || ($user->user_role == 2)) {
    //     if ($extendExpiredDate < $todayDate) {
    //         $error_message = "Acount Suspend";
    //         session_destroy();
    //     }
    // }
    REDIRECT(ABS_URL().'/upload-file.php');
} else {
    $error_message = "Invalid credentails.";
}
}