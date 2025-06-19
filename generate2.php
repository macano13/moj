<?php
require_once('config.php');

$lines = $_POST['text'];
$file_name = $_POST['file_name'];
$folder = $_POST['folder'];

if (!file_exists('uploads/'.$folder.'/'.$folder)) {
    mkdir('uploads/'.$folder.'/'.$folder, 0700);
}
//mkdir('/uploads/'.$folder.'/'.$folder, 0777, true);

$myfile = fopen('uploads/'.$folder.'/'.$folder.'/'.$file_name, "w") or die("Unable to open file!");
$txt = $lines;
fwrite($myfile, $txt);
fclose($myfile);


include  '../vendor/mantas-done/subtitles/src/Subtitles.php';
use \Done\Subtitles\Subtitles;
    $subtitles = new Subtitles();

// $data = $_POST['text'];
// $file_name = $_POST['file_name'];

// foreach($data as $obj){
// 	$subtitles->add($obj['start'], $obj['end'],$obj['text']);
// 	$subtitles->save($file_name);
// }
// echo $file_name;






// include  'vendor\mantas-done\subtitles\src\Subtitles.php';
// use \Done\Subtitles\Subtitles;
// ini_set('MAX_EXECUTION_TIME', -1);
// define('SRT_STATE_SUBNUMBER', 0);
// define('SRT_STATE_TIME', 1);
// define('SRT_STATE_TEXT', 2);
// define('SRT_STATE_BLANK', 3);



// $lines = file($file_name);

// $subs = array();
// $state = SRT_STATE_SUBNUMBER;
// $subNum = 0;
// $subText = '';
// $subTime = '';

// foreach ($lines as $line) {
//     switch ($state) {
//         case SRT_STATE_SUBNUMBER:
//             $subNum = trim($line);
//             $state = SRT_STATE_TIME;
//             break;

//         case SRT_STATE_TIME:
//             $subTime = trim($line);
//             $state = SRT_STATE_TEXT;
//             break;

//         case SRT_STATE_TEXT:
//             if (trim($line) == '') {
//                 $sub = new stdClass;
//                 $sub->number = $subNum;
//                 list($sub->startTime, $sub->stopTime) = (strstr($line, '=') ? explode('=', $line) : array($line, ''));
//                 $sub->text = $subText;
//                 $subText = '';
//                 $state = SRT_STATE_SUBNUMBER;

//                 $subs[] = $sub;
//             } else {
//                 $subText .= $line;
//             }
//             break;
//     }
// }

// if ($state == SRT_STATE_TEXT) {
//     // if file was missing the trailing newlines, we'll be in this
//     // state here.  Append the last read text and add the last sub.
//     $sub->text = $subText;
//     $subs[] = $sub;
// }

// print_r($subs);

 ?>
