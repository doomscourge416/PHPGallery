<?php
// Подключение к базе данных
include 'config.php';
include 'db.php';


$pdo = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка, была ли загружена картинка
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        
        // Путь для сохранения изображения
        $uploadFileDir = './uploads/';
        $dest_path = $uploadFileDir . $fileName;

        // Перемещение загруженного файла
        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            // Сохранение информации о изображении в базе данных
            $stmt = $pdo->prepare("INSERT INTO images (path) VALUES (:path)");
            $stmt->execute([':path' => $dest_path]);

            echo "Файл успешно загружен и сохранен в базе данных.";
        } else {
            echo "Ошибка при перемещении загруженного файла.";
        }
    } else {
        echo "Ошибка загрузки файла.";
    }
}
?>

<a href="./">На главную</a>