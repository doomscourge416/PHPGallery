<?php
session_start();

include 'config.php';
include 'db.php';

function loginUser($pdo){

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $username = $_POST['username'];
        $password = $_POST['password'];
        setcookie("username", $username);
    
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
    
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; // Сохранение ID пользователя в сессии
            setcookie("loggedin", true, time() + 60 * 5);
            echo "Добро пожаловать, " . $username . "! Ваш ID: " . $user['id'];
        } else {
            echo "Неверное имя пользователя или пароль!";
        }
    }
}

$pdo = getDbConnection();
$loginUser = loginUser($pdo);

?>

<a href="index.php">На главную</a>