<?php

session_start();

include 'config.php';
include 'db.php';

function registrateUser($pdo){

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хешируем пароль

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);

        echo "Регистрация успешна, " . $username . "!";
    }

}
$pdo = getDbConnection();
$registrate = registrateUser($pdo);
?>


<a href="index.php">На главную</a>