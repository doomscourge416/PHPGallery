<?php
session_start();
include 'config.php';
include 'db.php';
include 'showImages.php';

$pdo = getDbConnection();
$images = showImages($pdo);

?>

<!DOCTYPE html>
<html lang="ru">
<head>

    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="style.css">
    <title>Галерея изображений</title>

</head>
<body>

<header>
    
    <!-- Форма регистрации и логика её отсутствия (если уже залогированы)-->
    <?php if(!isset($_COOKIE['loggedin'])) : ?>

    <h4>Регистрация</h4>
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
    <?php endif; ?>


    <!-- Форма авторизации и логика её отсутствия (если уже залогированы) -->   
    <?php if(!isset($_COOKIE['loggedin'])) : ?>
    <h4>Авторизация</h4>    
    <form method="POST" action="login.php">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
    <?php endif; ?>
</header>


<div class="container">

    <h1>Галерея изображений</h1>

    <form action="upload.php" method="POST" enctype="multipart/form-data">

        <input type="file" name="image" accept="image/jpeg,image/png,image/gif" required>
        <button type="submit" class="btn btn-primary">Загрузить</button>

    </form>

    <div class="gallery">

        <?php foreach ($images as $image): ?>
            <div class="card">

                <img src="<?= $image['path'] ?>" alt="image" class="card-img-top" style="width:100px; height:100px;">   <!-- FIXME: решение на скорую руку для норм отображения картинок! поменять! -->

                <div class="card-body">

                    <form action="delete.php" method="POST">

                        <input type="hidden" name="id" value="<?= $image['id'] ?>">
                        <button type="submit" class="btn btn-danger">Удалить</button>

                    </form>

                    <h5>Комментарии:</h5>
                    <?php
                    // Получаем комментарии к изображению
                    $stmt = $pdo->prepare("SELECT * FROM comments WHERE image_id = ?");
                    $stmt->execute([$image['id']]);
                    $comments = $stmt->fetchAll();
                    ?>

                
                    <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                    <p><strong><?php
                        
                    // Подготовка SQL-запроса для получения имени пользователя
                    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :author_id");
                    $stmt->execute(['author_id' => $comment['author']]);
                    $user = $stmt->fetch();

                    // Проверка, найден ли пользователь, и вывод имени
                    if ($user) {
                        echo htmlspecialchars($user['username']);
                    } else {
                        echo "Неизвестный пользователь";
                    }
                    ?>:
                    </strong> <?= htmlspecialchars($comment['text']) ?></p>
                    <small><?= $comment['created_at'] ?></small>

                    <!-- Форма для удаления комментария -->
                    <form action="deleteComment.php" method="POST" style="display:inline;">
                        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                        <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить этот комментарий?');">Удалить</button>
                    </form>
                    </div>
                    <?php endforeach; ?>

                </div>

                <!-- Форма для комментариев -->

                <?php if (isset($_COOKIE['loggedin'])): // Проверка авторизации ?>            
                <form action="comment.php" method="POST">
                    
                    <input type="hidden" name="image_id" value="<?= $image['id'] ?>">
                    <textarea name="text" required></textarea>
                    <input type="hidden" name="author" value="<?= $comment['author'] ?>">
                    <button type="submit" class="btn btn-primary">Оставить комментарий</button>
                    
                </form>

                <?php else: ?>
                <p>Чтобы оставить комментарий, нужно <a href="login.php">войти</a>.</p>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
