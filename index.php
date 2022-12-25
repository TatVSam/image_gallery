<?php 
include 'config.php';
include 'functions.php';
session_start();

//Если заходит ранее авторизованный пользователь
if (!empty($_COOKIE['id'])) {
    $query = mysqli_query($link,"SELECT user_id, user_hash, user_login FROM users WHERE user_id='".mysqli_real_escape_string($link,$_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
    

    if (($userdata['user_hash'] == $_COOKIE['hash']) and ($userdata['user_id'] == $_COOKIE['id'])) {
        $_SESSION['auth'] = true;
        $_SESSION['user_id'] = $_COOKIE['id'];
        $_SESSION['user_login'] = $userdata['user_login']; 
    }

}


//Удаление изображения тем, кто его загрузил

if (!empty($_POST["deleted_id"])) {
    //удаляем файл с диска
    $delete_image = mysqli_query($link,"SELECT name FROM images WHERE image_id ='".mysqli_real_escape_string($link, $_POST["deleted_id"])."'");
    $deleted_image_path = mysqli_fetch_assoc($delete_image);
    unlink($deleted_image_path['name']);
    //Удаляем из БД запись о изображении и комментарии к изображению
    mysqli_query($link,"DELETE FROM images WHERE image_id ='".mysqli_real_escape_string($link, $_POST["deleted_id"])."'");
    mysqli_query($link,"DELETE FROM comments WHERE image_id ='".mysqli_real_escape_string($link, $_POST["deleted_id"])."'");
    unset($_POST["deleted_id"]);
    header ("Refresh: 2");
}

//Добавление комментария

if (!empty($_POST["comment_image_id"])) {
    $comment_date = date("j F Y, G:i");
    $comment_date_rus = getRussianDate($comment_date);
    mysqli_query($link,"INSERT INTO comments SET author_id='".mysqli_real_escape_string($link, $_SESSION["user_id"])."', 
    image_id='".mysqli_real_escape_string($link, $_POST["comment_image_id"])."', 
    text='".mysqli_real_escape_string($link, $_POST["comment"])."', 
    date='$comment_date_rus'"); 
    unset($_POST["comment_image_id"]);
 
    header ("Refresh: 2");
}

//Удаление комментария автором
if (!empty($_POST["comment_deleted_id"])) {
    
    mysqli_query($link,"DELETE FROM comments WHERE comment_id ='".mysqli_real_escape_string($link, $_POST["comment_deleted_id"])."'");
    unset($_POST["comment_deleted_id"]);
    header ("Refresh: 2");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"> 
    
</head>
<body>

<?php
//Интерфейс авторизованного пользователя
if (!empty($_SESSION['auth'])) {
?>
  <div class="nav"> 
        <!--При авторизации отображаем приветствие и кнопку для выхода-->
        <p class="welcome">Здравствуйте, <?=$_SESSION['user_login']?></p>
        <a href="logout.php"><button class="open-button btn btn-secondary" type="button">Выйти</button></a>         
  </div>




  <div class="container form-container rounded p-4 m-12 mt-2">



  <h4>Добро пожаловать, <?= $_SESSION['user_login'] ?>! Вы можете загрузить новое изображение в нашу галерею!</h1>
 
 
    <form action="upload.php" method="post" enctype="multipart/form-data">
      <p>Выберите изображение для загрузки:<p>

      <input type="hidden" name="MAX_FILE_SIZE" value="UPLOAD_MAX_SIZE">
      <input type="file" class="file-input" name="fileToUpload" id="chooseFile">
      <small class="form-text text-muted">
          Максимальный размер файла: <?php echo UPLOAD_MAX_SIZE / 1000000; ?> Мб.
          Допустимые форматы: <?php echo implode(', ', ALLOWED_TYPES) ?>.
      </small>
   
    <hr>
  
      <button type="submit" class="btn btn-primary">Загрузить</button>
      <a href="index.php" class="btn btn-secondary ml-3">Сброс</a>
    </form>

   

  <?php
 // }
  //Информация об ошибках загрузки
  if (!empty ($_SESSION["upload_info"])) { ?>
    <div class="alert alert-danger"><?= $_SESSION["upload_info"]; ?></div>
    
   <?php unset ($_SESSION["upload_info"]);
  
  }
  // Информация об успешной загрузке изображения
  if (!empty ($_SESSION["upload_info_success"])) { ?>
    <div class="alert alert-success"><?= $_SESSION["upload_info_success"]; ?></div>
    
   <?php unset ($_SESSION["upload_info_success"]);
  
  }
}
?>
</div>

<?php
//Интерфейс неавторизованного пользователя
        if (empty($_SESSION['auth'])) {
    ?>
      

        <div class="nav">  
            <!--Отображаем вверху кнопки авторизации и регистрации-->
            <button class="open-button btn btn-secondary" type="button" data-toggle="modal" data-target="#loginModal">Войдите</button>        
            <button class="registration-button btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#registerModal">Зарегистрируйтесь</button>
              
        </div>
 
    <?php
        }
    ?>


<!-- Модальное окно регистрации -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
    <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Зарегистрируйтесь</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action="register.php" method="POST">
          <div class="form-group">
            <input name="login" class="form-control" type="text" placeholder="Логин" required>
          </div>
          <div class="form-group">
            <input name="password" class="form-control" type="password" placeholder="Пароль" required>
          </div>
          <div class="form-group">     
            <input name="password_repeat" class="form-control" type="password" placeholder="Повторите пароль" required>
          </div>      
      </div>
      
      <div class="modal-footer">
        <input name="submit" class ="btn btn-primary" type="submit" value="Зарегистрироваться">
        <button type="button" class="btn cancel btn-secondary" data-dismiss="modal">Закрыть</button>
      </form>       
      </div>

    </div>
  </div>
</div>



<!-- Модальное окно авторизации -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
    <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Авторизуйтесь</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
        <form action="login.php" method="POST">
          <div class="form-group">
            <label for="login"><b>Логин</b></label>
            <input name="login" class="form-control" type="text" placeholder="Введите логин" required>
          </div>

          <div class="form-group">
            <label for="password"><b>Пароль</b></label>
            <input name="password" class="form-control" type="password" placeholder="Введите пароль" required>
          </div>

      </div>

      <div class="modal-footer">
        <input name="submit" type="submit" class="btn btn-primary" value="Войти">
        <button type="button" class="btn cancel btn-secondary" data-dismiss="modal">Закрыть</button>
      </form>
      </div>

    </div>
  </div>
</div>

<?php

//Вывод галереи
$result = mysqli_query($link,"SELECT image_id, uploader_id, name FROM images");
for ($images = []; $row = mysqli_fetch_assoc($result); $images[] = $row);

foreach ($images as $image) {
?>
<div class="container">
    <div class="row">
    <!--Колонка изображений -->
    <div class="col-sm mt-4">
    <img src="<?= $image["name"] ?>" >
 
    <?php
    //Если авторизован пользователь, загрузивший изображение
    if (!empty($_SESSION["user_id"]) and ($_SESSION["user_id"] == $image["uploader_id"])) {
    ?>
    <div class="text-info mt-1">Загрузили Вы</div>

    <form action="" method="post" class="mb-2">
      <input type="hidden" name="deleted_id" value="<?= $image['image_id'] ?>">
      <button class="btn btn-link" type="submit">Удалить изображение</button>
  
    </form>   
    
  <?php
    } else {
      $result = mysqli_query($link,"SELECT user_login FROM users WHERE user_id ='".mysqli_real_escape_string($link, $image['uploader_id'])."'");
    
      $image_uploader = mysqli_fetch_assoc($result);

    ?>
     <div class="text-info mt-1 mb-2">Загрузил(а) <?= $image_uploader['user_login'] ?></div>
  <?php
    }
  ?>

    </div>
    <!--Колонка комментариев -->
    <div class="col-sm mt-4">
    <p class="text-center text-uppercase font-weight-bold text-secondary">Комментарии</p>
    <?php
    $result = mysqli_query($link,"SELECT comment_id, author_id, text, date FROM comments WHERE image_id='".mysqli_real_escape_string($link, $image['image_id'])."'");
    for ($comments = []; $row = mysqli_fetch_assoc($result); $comments[] = $row);
   
    foreach ($comments as $comment) {
        $author_name_query = mysqli_query($link,"SELECT user_login FROM users WHERE user_id='".mysqli_real_escape_string($link, $comment['author_id'])."' LIMIT 1");
        $author_name = mysqli_fetch_assoc($author_name_query);
    ?>
        <div class="container comment_container mt-2 mb-1">
        <p class="text-right text-info"><?= $author_name['user_login'] ?></p>
        <p><?= $comment['text'] ?></p>
        <p class="text-right text-muted"><?= $comment['date'] ?></p>
    <?php
    //Авторизованный пользователь может удалить свой комментарий
        if (!empty($_SESSION["user_id"]) and ($_SESSION["user_id"] == $comment["author_id"])) {
            ?>
            
               <form action="" method="post">
                  <input type="hidden" name="comment_deleted_id" value="<?= $comment['comment_id'] ?>">
                  <button class="btn btn-link" type="submit">Удалить комментарий</button>
               </form>
              <?php
                }
        echo " </div>";
    }
    //Авторизованный пользователь может оставить комментарий
    if (!empty($_SESSION['auth'])) {
  ?>
 
    <form action="" method="post">
      <input type="hidden" name="comment_image_id" value="<?= $image['image_id'] ?>">
    
      <div class="form-group purple-border">
  
        <textarea class="form-control mt-3 mb-2" placeholder="Что думаете об этом изображении?" name="comment" id="comment" rows="3"></textarea>
      </div>
   
      <button type="submit" class="btn btn-outline-secondary">Опубликовать комментарий</button>
 
    </form>
    <hr>
    <?php
      }
    ?>
</div> <!-- col -->
</div> <!-- row -->
</div> <!-- container -->
<?php
} //конец вывода галереи

?>

    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

   

</body>
</html>

