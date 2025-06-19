<?php
    require_once('config.php');
    include_once $_SERVER['DOCUMENT_ROOT'].'/vendor/mantas-done/subtitles/src/Subtitles.php';
    use \Done\Subtitles\Subtitles;

    function replace_extension($filename, $new_extension) {
        $info = pathinfo($filename);
        return $info['filename'] . '.' . $new_extension;
    }
    function generateDownloadFile()
    {
        $fileName       = $_POST['fileName'];
        $convertedExt   = $_POST['extention'];


        $info = pathinfo($fileName);
        $exactFileName =  $info['filename'];
        $oldExt =  $info['extension'];

        $user = getUserFromSession();
        $userId = $user->id;

        $newFileName = db_getConvertedFileName($userId,$fileName);

        if ($newFileName) {
            $exactFileName = $newFileName->description;

        }
        $new_name = replace_extension($exactFileName, $convertedExt);

        $name = rand();
        $dir = mkdir("uploads/".$name, 0777, true);
        $copyStatus = copy('content/uploads/'.$userId.'/'.$fileName, $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$name.'/'.$fileName);
        chmod($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$name.'/'.$fileName,0777);

        
        if ($copyStatus) {
            $subtitles = Subtitles::load('uploads/'.$name.'/' .$fileName);
            Subtitles::convert('uploads/'.$name.'/' .$fileName, 'uploads/'.$name.'/' .$new_name);
            return json_encode('uploads/'.$name.'/' .$new_name);
        }else{
            return json_encode('error');
        }
    }

    echo generateDownloadFile();
   

?>