<?php
require_once('config.php');

include_once("code/template/header.php");
?>

<?php

session_start();

$folder = $_SESSION['folder'];


// Enter the name of directory
$pathdir = "uploads/$folder/";

// delete existing translate_file.zip
if(file_exists("uploads/$folder/subtitle_$folder.zip")){
	unlink("uploads/$folder/subtitle_$folder.zip");
}

$zipcreated = "uploads/$folder/subtitle_$folder.zip";
// Create new zip class
$zip = new ZipArchive;

if($zip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {

    $dir = opendir($pathdir);

    while($file = readdir($dir)) {
        if(is_file($pathdir.$file)) {
            $zip -> addFile($pathdir.$file, $file);
        }
    }
    $zip ->close();
}

//echo "uploads/$folder/subtitle_$folder.zip";
$path="uploads/$folder/subtitle_$folder.zip";

$file="subtitle_$folder.zip";
header("Content-type: application/zip");
header("Content-Disposition: attachment; filename=$file");
header("Pragma: no-cache");
header("Expires: 0");
readfile($path);

//remove file after download
deleteFolder($folder, 'uploads');
deleteFolder($folder, 'toSrt');
header('location: index.php');

function deleteFolder($folder, $parent){
    $files = scandir("$parent/$folder");
    foreach ($files as $file){
        if ($file !== '.' || $file !== '..'){
            unlink("$parent/$folder/$file");
        }
    }
    rmdir("$parent/$folder");
}

	
//print_r($arr);
header('Location: index.php');