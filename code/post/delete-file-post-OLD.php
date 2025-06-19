<?php 
    $error_message = "";
    $success_message = "";
    if (IS_POST() && isset($_POST['deleteid'])) {
        $user = getUserFromSession();
        $userId = $user->id;
        $deletedId = $_POST['deleteid'];
        $fileName = db_getFileNameById($deletedId);
        if (isset($fileName[0])) {
            if (file_exists(ABSPATH . '/content/uploads/'.$userId.'/'.$fileName[0]['db_file_name'])) {
                unlink(ABSPATH . '/content/uploads/'.$userId.'/'.$fileName[0]['db_file_name']);
            }
        }
        $res = db_deleteSubtitleRecord($deletedId);

        if ($res) {
            $success_message = "Data deleted Successfully!";
        }else{
            $error_message = "Data deleted Failed!";
        }
    }
?>