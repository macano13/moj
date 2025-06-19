<?php 
    $error_message = "";
    $success_message = "";
    if (IS_POST() && isset($_POST['deleteid'])) {
        
        function removeDir($path) {
            $files = glob("$path/*");
            foreach ($files as $file) {
                if (is_dir($file)) {
                    removeDir($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($path);
        }

        $deletedID = $_POST['deleteid'];
        $res = db_deleteUser($deletedID);

        if ($res) {
            removeDir(ABSPATH .'/content/uploads/'.$deletedID.'/');
            $success_message = "Data deleted Successfully!";
        }else{
            $error_message = "Data deleted Failed!";
        }
    }
?>