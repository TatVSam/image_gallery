<?php
session_start();
include 'config.php';
print "Привет, ".$_SESSION['user_login'].". Всё работает!";
?>
<form action="upload.php" method="post" enctype="multipart/form-data">
  Выберите изображение для загрузки:
  <input type="hidden" name="MAX_FILE_SIZE" value="UPLOAD_MAX_SIZE">
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Загрузить изображение" name="submit">
</form>