<?php 


require_once('../../config.php');

	
if (isset($_REQUEST['ids'])) {
        $user = getUserFromSession();
        $userId = $user->id;
        $ids = $_REQUEST['ids'];
		$delids = explode(",", $ids);
		foreach($delids as $deletedId){
echo $deletedId;
			if($deletedId != ""){
				$fileName = db_getFileNameById($deletedId);
				if (isset($fileName[0])) {
					if (file_exists(ABSPATH . '/content/uploads/'.$userId.'/'.$fileName[0]['db_file_name'])) {
						unlink(ABSPATH . '/content/uploads/'.$userId.'/'.$fileName[0]['db_file_name']);
					}
				}
				$res = db_deleteSubtitleRecord($deletedId);
			}
		}
        

        
    }
	
	
?>