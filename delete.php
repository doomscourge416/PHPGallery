<?php
session_start();
include 'config.php';
include 'db.php';

function deleteImage($pdo){

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        
        // Получение пути к изображению из БД
        $stmt = $pdo->prepare("SELECT path FROM images WHERE id = ?");
        $stmt->execute([$id]);
        $image = $stmt->fetch();
        
        // Удаление комментариев
        $stmt = $pdo->prepare("DELETE FROM comments WHERE image_id = ?");
        $stmt->execute([$id]);
        
        // Удаление файла
        unlink($image['path']);
        
        // Удаление записи из БД
        $stmt = $pdo->prepare("DELETE FROM images WHERE id = ?");
        $stmt->execute([$id]);
    
        header("Location: index.php");
        exit;
    }

}

$pdo = getDbConnection();
$deleteImage = deleteImage($pdo);

?>