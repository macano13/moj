<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subtitleId     = $_POST['id'];
    // $value = 
    $subtitleName   = rtrim(trim($_POST['name']), '<br />');

    $id = db_updateSubtitleName($subtitleName, $subtitleId);
    if ($id > 0) {
        echo json_encode("success");
    } else {
        // echo json_encode("failed");
    }
}
