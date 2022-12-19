<?
// Скрипт проверки 
// Соединяемся с БД
session_start();

$link=mysqli_connect("localhost", "root", "root", "image_gallery");
 
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);
 
    
    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
 or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0.0.0.0")))
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
        print "Хм, что-то не получилось";
    }
    else
    {
        $_SESSION['user_login'] = $userdata['user_login']; 
        $_SESSION['auth'] = true;
        $_SESSION['user_id'] = $userdata['user_id'];
        header('Location: index.php');
        
    }
}
else
{
    print "Включите куки";
}
?>