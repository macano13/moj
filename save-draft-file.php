<?php

require_once('config.php');


if ( isset($_POST['filePathUrl'])) {
    $filePath = $_POST['filePathUrl'];
    $fileName = $_POST['fileName'];

    $user = getUserFromSession();
   
    $userId = $user->id;

    $explodeVal     = explode('/', $filePath);
  
    $copyStatus = copy($_SERVER['DOCUMENT_ROOT'] . '/' . $filePath, $_SERVER['DOCUMENT_ROOT'] . '/content/uploads/' . $userId . '/' . $fileName);
    chmod($_SERVER['DOCUMENT_ROOT'] . '/content/uploads/' . $userId . '/' . $fileName, 0777);

    $name           = isset($fileName) ? $fileName : $filePath;

    if ($copyStatus) {
        $value_one = "Coverted into " . pathinfo($filePath, PATHINFO_FILENAME) . " ";
        $description    = isset($fileName) ? $value_one . $fileName : $value_one;

        $size           = filesize($filePath);
        $ext            = pathinfo($filePath, PATHINFO_EXTENSION);
        // $db_name        = GET_GUID().".".$ext;

        // $id = db_insertUploadDetails($name, $description, $size, $userId, $ext, $name);
        // if ($id > 0) {
        //     $dir = "uploads/";
        //     $files1 = scandir($dir);
        //     foreach ($files1 as $key => $value) {
        //         if ($value != "." && $value != "..") {
        //             array_map('unlink', glob($dir . $value . "/*.*"));
        //             if ($value != '.htaccess') {
        //                 rmdir($dir . $value);
        //             }
        //         }
        //     }
        //     $success_message = "Uploaded successfully.";
        //     echo "<script>location.href='list.php';</script>";
        // } else {
        //     $error_message = "Something went wrong";
        // }
    }
    die;
}
