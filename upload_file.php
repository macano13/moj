<?php
    session_start();
    //$name = md5(uniqid());
    $name = uniqid();
    if (!file_exists('uploads')){
        mkdir('uploads');
    }


    $dir = mkdir("uploads/".$name, 0777, true);

    for($i=0; $i<count($_FILES['files']['name']); $i++){

        $target_path = "uploads/".$name;
        $ext = explode('.', basename($_FILES['files']['name'][$i]));
        $target_path = $target_path . $i . "." . $ext[count($ext)-1]; 
        $file = basename($_FILES['files']['name'][$i]);

        if(move_uploaded_file($_FILES['files']['tmp_name'][$i], "uploads/$name/$file")) {
            $ext = pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION);
            
            
        } else{
            echo json_encode(['status' => 'failed']);
        }
    }
    echo json_encode(['status' => 'success', 'id' => $name]);


// if (isset($_FILES['files']['name'])) {
   
//     if (file_exists('uploads/' . $_FILES['files']['name'])) {
//         print_r("expression");
//         //echo 'File already exists : uploads/' . $_FILES['files']['name'];
//     } else {
//         move_uploaded_file($_FILES['files']['tmp_name'], 'uploads/' . $_FILES['files']['name']);
//         //echo  $_FILES['files']['name'];
//         print_r($_FILES['files']['name']);
//     }
    
// }   
/* 
 * End of script
 */
?>