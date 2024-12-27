SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `comments` (
  `id` int NOT NULL,
  `author` int NOT NULL,
  `image_id` int NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `comments` (`id`, `author`, `image_id`, `text`, `created_at`) VALUES
(17, 1, 28, 'Мне лично нравится этот Логотип!', '2024-12-27 07:45:45'),
(18, 2, 29, 'А мне вот этот!', '2024-12-27 07:46:30'),
(19, 2, 28, 'Неплохо, но второй лучше!', '2024-12-27 07:46:41'),
(25, 2, 32, 'Вот! Это то - что нам надо!', '2024-12-27 08:23:58');

CREATE TABLE `images` (
  `id` int NOT NULL,
  `path` varchar(512) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `images` (`id`, `path`, `created_at`) VALUES
(28, './uploads/OIP.jpg', '2024-12-27 07:43:42'),
(29, './uploads/golfclublogo.png', '2024-12-27 07:46:22'),
(32, './uploads/500.png', '2024-12-27 08:23:49');

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'user1', '$2y$10$TRx78WfDC/9JyM7gSMd3Ze0l0kkKZYkWduwdJe.4j5JS.b53YvJZa'),
(2, 'user2', '$2y$10$xFCY2SCDsqLZh7NiXZ9N2eMTM//vOUubicdUmMWKapI73frFD5mXK'),
(3, 'root', '$2y$10$m9GCIj4ZJb.CIz2j0tmTYuNUzPiWY8X2I/QuI3tNciTfJ8kReNUoq');


ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`author`),
  ADD KEY `image_id` (`image_id`);

ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

ALTER TABLE `images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
