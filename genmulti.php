<?php



include_once  'vendor/mantas-done/subtitles/src/Subtitles.php';
use \Done\Subtitles\Subtitles;
    $subtitles = new Subtitles();

/** The name of the database for WordPress */
define('DB_NAME', 'c1zvizdoDB');

/** MySQL database username */
define('DB_USER', 'c1uploading1');

/** MySQL database password */
define('DB_PASSWORD', '#Test111');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');


define('APP_DEBUG', FALSE);

//define('APP_DEBUG', TRUE);

if (!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__));


require_once(ABSPATH . '/code/system/db_helper/shared/ez_sql_core.php');
require_once(ABSPATH . '/code/system/db_helper/mysqli/ez_sql_mysqli.php');
require_once(ABSPATH . '/code/app-biz.php');


$data =  $_POST['data'];
$file_name_act =  $_POST['file'];
$folder =  'uploads/'.$_POST['folder'];

$ext = pathinfo($file_name, PATHINFO_EXTENSION);


$explodedFileName = explode('/', $file_name);


//$fileNameResult = db_getFileName(null, $explodedFileName[1]);

if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

//if (isset($fileNameResult)) {
 //   $file_name = $folder.'/'.$fileNameResult->description.'.'.$ext;
//}


$file_name = $folder.'/'.$file_name_act;


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
echo $file_name; ?>
