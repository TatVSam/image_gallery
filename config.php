<?php
 
define('URL', '/'); // URL текущей страницы
define('UPLOAD_MAX_SIZE', 30000000); // 30mb
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('UPLOAD_DIR', 'uploads');
 
/*$errors = [];
 
if (!empty($_FILES)) {
 
   
 
        $fileName = $_FILES['files']['name'];
 
        if ($_FILES['fileToUpload']['size'] > UPLOAD_MAX_SIZE) {
            $errors[] = 'Недопустимый размер файла ' . $fileName;           
        }
 
        if (!in_array($_FILES['fileToUpload']['type'], ALLOWED_TYPES)) {
            $errors[] = 'Недопустимый формат файла ' . $fileName;           
        }
 
        $filePath = UPLOAD_DIR . '/' . basename($fileName);
 
        if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $filePath)) {
            $errors[] = 'Ошибка загрузки файла ' . $fileName;           
        }
    
}*/
 
?>