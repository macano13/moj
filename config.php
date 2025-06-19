<?php

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'c1zvizdoDB');

/** MySQL database username */
define('DB_USER', 'c1uploading1');

/** MySQL database password */
define('DB_PASSWORD', '#Stomornjak111');

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

define('APP_NAME', '');
    
session_start();

// if (isset($_SESSION['USER_INFO'])) {
//     $user = $_SESSION["USER_INFO"];

//     $extendExpiredDate = date("Y-m-d", strtotime($user->expire_date . " +10 days"));
//     $todayDate = Date('Y-m-d');
//     if (($user->expire_date != $todayDate) || ($user->user_role == 2)) {
//         if ($extendExpiredDate < $todayDate) {
//             session_destroy();
//         }
//     }
// }

require_once(ABSPATH . '/code/system/db_helper/shared/ez_sql_core.php');
require_once(ABSPATH . '/code/system/db_helper/mysqli/ez_sql_mysqli.php');
require_once(ABSPATH . '/code/system/web-helper.php');

require_once(ABSPATH . '/filter.php');

// $currentDate = date('Y-m-d');
// if (isset($_SESSION['expire'])) {
//     if ($currentDate > $_SESSION['expire']) {
//         session_destroy();
//     }
// }

// if (isset($_SESSION['USER_INFO'])) {
//     $user = $_SESSION["USER_INFO"];

//     $db_user = db_getUserByEmailAndPwd($user->email,$user->password);

//     if (!is_null($db_user)) {
//         $extendExpiredDate = date("Y-m-d", strtotime($db_user->expire_date . " +10 days"));
//         $todayDate = Date('Y-m-d');
//         if (($db_user->expire_date != $todayDate) || ($db_user->user_role == 2)) {
//             if ($extendExpiredDate < $todayDate) {
//                 session_destroy();
//                 echo '<script type="text/javascript">window.location = "/login.php"</script>';
//             }
//         }
//     }else{
//         session_destroy();
//         echo '<script type="text/javascript">window.location = "/login.php"</script>';
//     }
// }

if (isset($_SESSION['USER_INFO'])) {
    $user = $_SESSION["USER_INFO"];
    $db_user = db_getUserByEmailAndPwd($user->email,$user->password);
    setUserToSession($db_user);
}
?>