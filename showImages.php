<?php
function showImages($pdo) { 
    $images = []; // Инициализируем пустой массив $images

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
        
        // Проверка на допустимый размер файла
        if ($_FILES['image']['size'] > MAX_FILE_SIZE) {
            die('Ошибка загрузки файла! Превышен допустимый размер!');
        }

        // Проверка на допустимый тип файла
        if (!in_array($_FILES['image']['type'], ALLOWED_TYPES)) {
            die('Ошибка загрузки файла! Недопустимый тип файла');
        }

        // Обработка загрузки изображения
        $file = $_FILES['image'];
        $filePath = UPLOAD_DIR . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $filePath);
        
        // Сохранение информации в БД
        $stmt = $pdo->prepare("INSERT INTO images (path) VALUES (?)");
        $stmt->execute([$filePath]);
    }

    // Извлекаем изображения из БД
    $images = $pdo->query("SELECT * FROM images")->fetchAll();

    return $images; // Возвращаем массив изображений
}

?>