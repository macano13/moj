<?php 
    require_once('config.php');
    require_once(ABSPATH . '/code/post/delete-file-post.php');


    if (isset($_GET['deleteid'])) {
        if (is_int($_GET['deleteid'])) {
            deleteProcess($_GET['deleteid']);
        }
    }
?>