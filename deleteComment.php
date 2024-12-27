<?php
session_start();

include 'config.php';
include 'db.php';

function deleteComment($pdo) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'])) {
        $comment_id = $_POST['comment_id'];
        $user_id = $_SESSION['user_id'];

        // Получаем автора комментария по его ID
        $stmt = $pdo->prepare("SELECT author FROM comments WHERE id = :comment_id");
        $stmt->execute(['comment_id' => $comment_id]);
        $comment = $stmt->fetch();

        // Проверка, является ли текущий пользователь автором комментария
        if ($comment && $comment['author'] == $user_id) {
            
            // Подготовка SQL-запроса для удаления комментария
            $stmt = $pdo->prepare("DELETE FROM comments WHERE id = :comment_id");
            $stmt->execute(['comment_id' => $comment_id]);

            // Перенаправление обратно на страницу с комментариями
            header("Location: index.php");
            exit();
        } else {
            die('Вы не имеете прав для удаления этого комментария.');
        }
    }
}

$pdo = getDbConnection();
deleteComment($pdo);
?>