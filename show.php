<?php 
session_start();
$link=mysqli_connect("localhost", "root", "root", "image_gallery"); 
if (!empty($_COOKIE['id'])) {
    $query = mysqli_query($link,"SELECT user_id, user_hash, user_login FROM users WHERE user_id='".mysqli_real_escape_string($link,$_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
    

    if (($userdata['user_hash'] == $_COOKIE['hash']) and ($userdata['user_id'] == $_COOKIE['id'])) {
        $_SESSION['auth'] = true;
        $_SESSION['user_id'] = $_COOKIE['id'];
        $_SESSION['user_login'] = $userdata['user_login']; 
    }

}
if (!empty($_SESSION['auth'])) {
echo "Привет, " . $userdata['user_login'] . "<br>";
}


if (!empty($_POST["deleted_id"])) {
    mysqli_query($link,"DELETE FROM images WHERE image_id ='".mysqli_real_escape_string($link, $_POST["deleted_id"])."'");
    unset($_POST["deleted_id"]);
    header ("Refresh: 2");
}

echo $_POST["comment_image_id"];
if (!empty($_POST["comment_image_id"])) {
    $comment_date = date("F j, Y, g:i a");
    mysqli_query($link,"INSERT INTO comments SET author_id='".mysqli_real_escape_string($link, $_SESSION["user_id"])."', 
    image_id='".mysqli_real_escape_string($link, $_POST["comment_image_id"])."', 
    text='".mysqli_real_escape_string($link, $_POST["comment"])."', 
    date='$comment_date'"); 
    unset($_POST["comment_image_id"]);
    //echo $_POST["comment_image_id"];
    header ("Refresh: 2");
}
echo $_POST["comment_deleted_id"];
if (!empty($_POST["comment_deleted_id"])) {
    echo $_POST["comment_deleted_id"];
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

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Запустить модальное окно
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="register.php" method="POST">
Логин <input name="login" type="text" placeholder="Логин" required><br>
Пароль <input name="password" type="password" placeholder="Пароль" required><br>
Пароль <input name="password_repeat" type="password" placeholder="Повторите пароль" required><br>
<input name="submit" type="submit" value="Зарегистрироваться">
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php
//$link=mysqli_connect("localhost", "root", "root", "image_gallery"); 
$result = mysqli_query($link,"SELECT image_id, uploader_id, name FROM images");
for ($images = []; $row = mysqli_fetch_assoc($result); $images[] = $row);
//echo "<pre>"; var_dump($images); echo "</pre>";
//mysqli_query($link,"DELETE FROM images WHERE image_id = 5");
//$result = mysqli_query($link,"SELECT user_login FROM users WHERE user_id = 2 LIMIT 1");
//$res = mysqli_fetch_assoc($result);
//echo $res['user_login'];


foreach ($images as $image) {
?>
    <img src="<?= $image["name"] ?>" >
   
    <?php 
    
    $result = mysqli_query($link,"SELECT user_login FROM users WHERE user_id ='".mysqli_real_escape_string($link, $image['uploader_id'])."'");
    
    $res = mysqli_fetch_assoc($result);
    echo $res['user_login'] . " ";

    if (!empty($_SESSION["user_id"]) and ($_SESSION["user_id"] == $image["uploader_id"])) {
?>

   <form action="" method="post">
   <input type="hidden" name="deleted_id" value="<?= $image['image_id'] ?>">
   <p><input type="submit" value="Удалить"></p>
  </form>
  <?php
    }
    echo "<p>Комменты</p>";
    $result = mysqli_query($link,"SELECT comment_id, author_id, text, date FROM comments WHERE image_id='".mysqli_real_escape_string($link, $image['image_id'])."'");
    for ($comments = []; $row = mysqli_fetch_assoc($result); $comments[] = $row);
    //echo "<pre>"; var_dump($comments); echo "</pre>";
    foreach ($comments as $comment) {
        $author_name_query = mysqli_query($link,"SELECT user_login FROM users WHERE user_id='".mysqli_real_escape_string($link, $comment['author_id'])."' LIMIT 1");
        $author_name = mysqli_fetch_assoc($author_name_query);
        echo $author_name['user_login'] . nl2br("\n");
        echo $comment['text'];
        echo "<p>". $comment['date'] . "</p>";

        if (!empty($_SESSION["user_id"]) and ($_SESSION["user_id"] == $comment["author_id"])) {
            ?>
            
               <form action="" method="post">
               <input type="hidden" name="comment_deleted_id" value="<?= $comment['comment_id'] ?>">
               <p><input type="submit" value="Удалить"></p>
              </form>
              <?php
                }
    }
    /*
    for ($author_name = []; $row = mysqli_fetch_assoc($result); $author_name[] = $row);
    
    echo "<pre>"; var_dump($author_name); echo "</pre>";*/
 ?>

    <form action="" method="post">
    <input type="hidden" name="comment_image_id" value="<?= $image['image_id'] ?>">
    <textarea placeholder="Что думаете?" name="comment" id="comment"></textarea>

    <button type="submit">Опубликовать</button>
</form>
<?php
}

?>


    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

   

</body>
</html>

