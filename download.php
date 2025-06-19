<?php
if (!isset($_REQUEST["external_download"])) {
    require_once('config.php');
    $fileNameResult = db_getFileName($_REQUEST["createdId"], $_REQUEST["id"]);
    $file = ABSPATH . '/content/uploads/'.$_REQUEST["createdId"].'/'.$fileNameResult->file_name;
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $fileName = $fileNameResult->description.'.'.$ext;
}else{        
    // ** MySQL settings - You can get this info from your web host ** //
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
    $fileNameResult = db_getFileName($_REQUEST["createdId"], $_REQUEST["id"]);

    $file = ABSPATH . '/content/uploads/'.$_REQUEST["createdId"].'/'.$fileNameResult->file_name;
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $fileName = $fileNameResult->description.'.'.$ext;
}


if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$fileName.'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
?>