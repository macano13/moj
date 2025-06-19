<?php
$error_message = "";
$success_message = "";


if (IS_POST()) {
    if ($_FILES['upload']) {
        $name = $_FILES['upload']['name'];
        $size = $_FILES['upload']['size'];
        
        $type = getFileTypeText($_FILES['upload']['type']);
        $ext = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);

        $user = getUserFromSession();
        $userId = $user->id;

        if (!file_exists(ABSPATH . '/content/uploads/'.$userId.'/'.$name)) {

        $acceptedExt = ['srt', 'ass', 'sub', 'sbv', 'vtt', 'stl'];
        $name = preg_replace('/[^A-Za-z0-9\.\(\) ]/', '', $name); //removes ALL characters
        $name = str_replace(' ', '_', $name);
        // Replaces multiple hyphens with single one.
        $name = preg_replace('/_+/', '_', $name);
        if (in_array($ext, $acceptedExt)) {
            $db_name = GET_GUID() . "." . $ext;
            $file_name_db = ABSPATH . '/content/uploads/' . $userId . '/' . $name;
            $description = isset($_POST["description"]) && $_POST["description"] != '' ? $_POST["description"] : $name;
            if ($size > 0) {
                move_uploaded_file($_FILES['upload']['tmp_name'], $file_name_db);
                chmod($file_name_db, 0666);
                $id = db_insertUploadDetails($name, $description, $size, $userId, $ext, $name);
                if ($id > 0) {
                    $success_message = "Uploaded successfully.";
                    echo "<script>location.href='list.php';</script>";
                }
            } else {
                $error_message = "Not a valid file.";
            }
        } else {
            $error_message = "Please upload only srt, ass, sub, sbv, vtt, stl";
        }
        }else{
            $error_message="File Already Exists";
        }
    }
}
