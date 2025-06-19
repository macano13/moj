<?php
$error_message = "";
$success_message = "";



if (IS_POST()) {
    if ($_FILES['upload']) {

		$total = count($_FILES['upload']['name']);
		$uploaded = 0;
		for( $i=0 ; $i < $total ; $i++ ) {
	
			$name = $_FILES['upload']['name'][$i];
			$size = $_FILES['upload']['size'][$i];
	
			$type = getFileTypeText($_FILES['upload']['type'][$i]);
			$ext = pathinfo($_FILES['upload']['name'][$i], PATHINFO_EXTENSION);
			
			$user = getUserFromSession();
			$userId = $user->id;
	
			if (!file_exists(ABSPATH . '/content/uploads/'.$userId.'/'.$name)) {
				$acceptedExt = ['srt', 'ass', 'sub', 'sbv', 'vtt', 'stl'];
        $name = preg_replace('/[^A-Za-z0-9\.\(\) ]/', '', $name); //removes ALL characters
        $name = str_replace(' ', '_', $name);
        // Replaces multiple hyphens with single one.
        $name = preg_replace('/_+/', '_', $name);
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
				if (in_array($ext, $acceptedExt)) {
					$db_name = GET_GUID() . "." . $ext;
					$file_name_db = ABSPATH . '/content/uploads/' . $userId . '/' . $name;
					$description = isset($_POST["description"]) && $_POST["description"] != '' ? $_POST["description"] : $name;
					if ($size > 0) {
						move_uploaded_file($_FILES['upload']['tmp_name'][$i], $file_name_db);
						chmod($file_name_db, 0666);
						$id = db_insertUploadDetails($name, $description, $size, $userId, $ext, $name);
//print_r($_FILES);
//echo "<br>";
//echo $file_name_db;
//die("here");


						if ($id > 0) {
							$uploaded = 1;
							$success_message = "Uploaded successfully.";
							/*echo "<script>location.href='list.php';</script>";*/
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
		if($uploaded == 1){
			echo "<script>location.href='list.php';</script>";
		}
    }
}
