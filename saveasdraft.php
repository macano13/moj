<?php 

require_once('config.php');

    include_once  'vendor/mantas-done/subtitles/src/Subtitles.php';
    use \Done\Subtitles\Subtitles;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $subtitles = new Subtitles();

        $data =  $_POST['data'];
        $file_name =  $_POST['file'];
    
        $data =json_decode($data, true);
        foreach($data as $obj){
            $start = explode(':', $obj['start']);
            $startSeconds = explode(",", $start[2]);
            $start = ($start[0]*3600)+($start[1]*60)+$startSeconds[0]+($startSeconds[1]/1000);
            $end = explode(':', $obj['end']);
            $endSeconds = explode(",", $end[2]);
            $end = ($end[0]*3600)+($end[1]*60)+$endSeconds[0]+($endSeconds[1]/1000);
            $subtitles->add($start, $end, $obj['text']);
        }
        $subtitles->save($file_name);
        $response = [
            'status' => "success",
            'message' => $file_name,
        ];

        
        $extension_array = array('.srt', '.ass', '.vtt', '.stl', '.sub', '.sbv');
        foreach($extension_array as $ext){
          foreach (glob("*$ext") as $file) {
            unlink($file);
          }
        }
        foreach($extension_array as $ext){
          foreach (glob("uploads/*$ext") as $file) {
            unlink($file);
          }
        }
        echo json_encode($response);

        $explodeFileame = explode('/', $file_name);
        // echo "<pre>";
        // print_r($explodeFileame);
        // die;
        $userid   = $explodeFileame[2];
        $draftFileName = $explodeFileame[4];
        db_updateSubtitleUpdateTime($userid,$draftFileName);
    }else{
        $response = [
            'status' => "failed",
            'message' => "request method not supported",
        ];
        echo json_encode($response);
    }
?>