<?php 

if ( 0 < $_FILES['file']['error'] ) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
}
else {
	$name = rand();
	$dir = mkdir("uploads/".$name, 0777, true);
    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$name.'/' . $_FILES['file']['name']);
    chmod('uploads/'.$name.'/' . $_FILES['file']['name'],0777);
    echo $name;
}