<?php

    require_once('config.php');
    include_once $_SERVER['DOCUMENT_ROOT'].'/vendor/mantas-done/subtitles/src/Subtitles.php';
    use \Done\Subtitles\Subtitles;

    ini_set('display_errors', 'Off');

    $extention = $_POST['extention'];

    function replace_extension($filename, $new_extension) {
        $info = pathinfo($filename);
        return $info['filename'] . '.' . $new_extension;
    }

    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }else {
        $name = rand();
        $dir = mkdir("uploads/".$name, 0755, true);
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$name.'/' . $_FILES['file']['name']);
        // chmod('uploads/'.$name.'/' . $_FILES['file']['name'],0755);
        $fileName = $_FILES['file']['name'];
        $new_name = replace_extension($_FILES['file']['name'], $extention);

        $subtitles = Subtitles::load('uploads/'.$name.'/' .$fileName);
        Subtitles::convert('uploads/'.$name.'/' .$fileName, 'uploads/'.$name.'/' .$new_name);
        // chmod('uploads/'.$name.'/' .$new_name,0755);
        echo 'uploads/'.$name.'/' .$new_name;
    }
?>