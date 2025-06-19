<?php

$folder = $_POST["folder"];
$data =  $_POST['data'];

$data =json_decode($data, true);
$files = array();

foreach($data as $obj){
	$files[] = $obj;
}

$names = array('vip.translatesubtitles.co.zip', 'vip.translatesubtitles.co.zip','vip.translatesubtitles.co.zip','vip.translatesubtitles.co.zip');
$i = rand(0,3);

$zipname = $names[$i];


$zip = new ZipArchive;
$zip->open($zipname, ZipArchive::CREATE);
foreach ($files as $file) {
  $zip->addFile($file);
}
$zip->close();

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . filesize($zipname));
readfile($zipname);

$folder = 'uploads/'.$folder;

flush();

system("rm -rf ".escapeshellarg($folder));


if (file_exists($zipname)) {
    unlink( $zipname );
}
