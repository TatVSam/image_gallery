<?php
 
define('URL', '/'); // URL текущей страницы
define('UPLOAD_MAX_SIZE', 20000000); // 20mb
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('UPLOAD_DIR', 'uploads');
define('HOST_NAME', 'localhost');
define('DB_NAME', 'image_gallery');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');


$link=mysqli_connect(HOST_NAME, DB_USER, DB_PASSWORD, DB_NAME);