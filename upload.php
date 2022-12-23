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
            switch ($_FILES['fileToUpload']['type']) {
                case 'image/jpeg': 
                    $extension = '.jpg';
                    break;
                case 'image/png': 
                    $extension = '.png';
                    break;
                case 'image/gif': 
                    $extension = '.gif';
                    break;
            }
            
            $link=mysqli_connect(HOST_NAME, "root", "root", DB_NAME);
            $max_image_id = mysqli_query($link,"SELECT MAX(image_id) FROM images");
            $max_image = mysqli_fetch_assoc($max_image_id);
            $name_id = (int) $max_image["MAX(image_id)"] + 1;
            $saveName = "Picture" . $name_id;
            $savePath = UPLOAD_DIR . '/' . $saveName . $extension;
           
            if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $savePath)) {
            $errors[] = 'Ошибка загрузки файла ' . $fileName;         
        }
        }
}



if (empty($_FILES['fileToUpload']["name"])) {
    $_SESSION["upload_info"] = "<br>" . "Вы не выбрали файл!";
    header("Location: index.php");

} elseif (count($errors) <>0) {
    $str = "<br>" . "При загрузке изображений произошли следующие ошибки:" . "<br>";
    foreach ($errors as $error) {
        $str .= $error . "<br>";
    }
    $_SESSION["upload_info"] = $str;
    header("Location: index.php");
} elseif (isset($_FILES['fileToUpload']) && (count($errors) == 0)) {
    $uploader_id = $_SESSION['user_id'];
    mysqli_query($link, "INSERT INTO images SET uploader_id='$uploader_id', name='".$savePath."'");
    $_SESSION["upload_info_success"] = "<br>" . "Файл успешно загружен!";
    header("Location: index.php");
}





