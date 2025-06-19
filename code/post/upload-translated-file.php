<?php

if (IS_POST() && isset($_POST['filePathUrl'])) {
    $filePath = $_POST['filePathUrl'];
    $converterIdentifier = isset($_POST['converterIdentifier']) ? $_POST['converterIdentifier'] : 0;

    $user = getUserFromSession();
    $userId = $user->id;
    if ($converterIdentifier > 0) {
        $explodedArr = explode('/', $filePath);

        $converteFilePath = $explodedArr[2];
        $copyStatus = copy($_SERVER['DOCUMENT_ROOT'] . '/' . $filePath, $_SERVER['DOCUMENT_ROOT'] . '/content/uploads/' . $userId . '/' . $converteFilePath);
        chmod($_SERVER['DOCUMENT_ROOT'] . '/content/uploads/' . $userId . '/' . $converteFilePath, 0777);
        $explodeVal     = $explodedArr;

        $name           = isset($explodeVal[2]) ? $explodeVal[2] : $filePath;
    } else {
        $explodeVal     = explode('/', $filePath);
        $copyStatus = copy($_SERVER['DOCUMENT_ROOT'] . '/' . $filePath, $_SERVER['DOCUMENT_ROOT'] . '/content/uploads/' . $userId . '/' . $explodeVal[1]);
        chmod($_SERVER['DOCUMENT_ROOT'] . '/content/uploads/' . $userId . '/' . $explodeVal[1], 0777);

        $name           = isset($explodeVal[1]) ? $explodeVal[1] : $filePath;
    }

    if ($copyStatus) {
        // $value_one = "Coverted into " . pathinfo($filePath, PATHINFO_EXTENSION) . " ";
        $value_one = pathinfo($filePath, PATHINFO_FILENAME);
        $description    = isset($explodeVal[1]) ? $value_one . $explodeVal[1] : $value_one;

        $size           = filesize($filePath);
        $ext            = pathinfo($filePath, PATHINFO_EXTENSION);
        // $db_name        = GET_GUID().".".$ext;

        $id = db_insertUploadDetails($name, $description, $size, $userId, $ext, $name);
        if ($id > 0) {
            $dir = "uploads/";
            $files1 = scandir($dir);
            foreach ($files1 as $key => $value) {
                if ($value != "." && $value != "..") {
                    array_map('unlink', glob($dir . $value . "/*.*"));
                    if ($value != '.htaccess') {
                        rmdir($dir . $value);
                    }
                }
            }
            $success_message = "Uploaded successfully.";
            echo "<script>location.href='list.php';</script>";
        } else {
            $error_message = "Something went wrong";
        }
    }
    die;
}
