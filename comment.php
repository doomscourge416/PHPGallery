<?php
session_start();

include 'config.php';
include 'db.php';

function addComment($pdo){

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['image_id'], $_POST['text'], $_POST['author'])) {

        $imageId = $_POST['image_id'];
        $text = $_POST['text'];
        $author = $_POST['author'];
        $created_at = date("Y-m-d H:i:s");
            
        // Сохранение комментария в БД  
        $stmt = $pdo->prepare("INSERT INTO comments (image_id, text, author, created_at) VALUES (?, ?, ?, ?)");
        $stmt->execute([$imageId, $text, $author, $created_at]);
        
        header("Location: index.php");
        exit;
    }

}

$pdo = getDbConnection();
$addComment = addComment($pdo);