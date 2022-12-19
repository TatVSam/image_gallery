<?php


//var_dump($_FILES['fileToUpload']);

//var_dump($_FILES["error"]);
session_start();
include 'config.php';


$errors = [];
 
if (!empty($_FILES)) {
 
   
 
        $fileName = $_FILES['fileToUpload']['name'];
 
        if ($_FILES['fileToUpload']['size'] > UPLOAD_MAX_SIZE) {
            $errors[] = 'Недопустимый размер файла ' . $fileName;           
        }
 
        if (!in_array($_FILES['fileToUpload']['type'], ALLOWED_TYPES)) {
            $errors[] = 'Недопустимый формат файла ' . $fileName;           
        }
 
         
        if (count($errors) == 0) {
        $savePath = UPLOAD_DIR . '/' . $fileName;
        echo $savePath;
        if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $savePath)) {
            $errors[] = 'Ошибка загрузки файла ' . $fileName;           
        }
        }
}

print_r($errors);

if (isset($_FILES['fileToUpload']) && (count($errors) == 0)) {
    $link=mysqli_connect("localhost", "root", "root", "image_gallery"); 
    $uploader_id = $_SESSION['user_id'];
    mysqli_query($link, "INSERT INTO images SET uploader_id='$uploader_id', name='".$savePath."'");
}

/*
if (isset($_FILES['fileToUpload']) && UPLOAD_ERR_OK === $_FILES['fileToUpload']['error']) {
    echo 'Файл ' . $_FILES['fileToUpload']['name'] . ' успешно загружен на сервер!';
}

$tmpName = $_FILES['fileToUpload']['tmp_name'];


$savePath = UPLOAD_DIR . '/' . $_FILES['fileToUpload']['name'];
// копируем файл
copy($tmpName, $savePath);
$link=mysqli_connect("localhost", "root", "root", "image_gallery"); 
$uploader_id = $_SESSION['user_id'];
mysqli_query($link, "INSERT INTO images SET uploader_id='$uploader_id', name='".$savePath."'");*/




