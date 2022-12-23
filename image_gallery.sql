-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 23 2022 г., 14:46
-- Версия сервера: 8.0.29
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `image_gallery`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `comment_id` int NOT NULL,
  `author_id` int NOT NULL,
  `image_id` int NOT NULL,
  `text` text CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL,
  `date` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`comment_id`, `author_id`, `image_id`, `text`, `date`) VALUES
(1, 1, 2, 'text', '21st feb'),
(2, 2, 1, 'первый коммент', 'December 16, 2022, 1:46 pm'),
(13, 7, 7, 'Когда в дом входит год молодой,\r\nА старый уходит вдаль,\r\nСнежинку хрупкую спрячь в ладонь,\r\nЖелание загадай.\r\nСмотри с надеждой в ночную синь,\r\nНе крепко ладонь сжимай,\r\nИ всё, о чём мечталось, проси,\r\nЗагадывай и желай.\r\n\r\nИ Новый Год, что вот-вот настанет,\r\nИсполнит вмиг мечту твою,\r\nЕсли снежинка не растает,\r\nВ твоей ладони не растает,\r\nПока часы двенадцать бьют,\r\nПока часы двенадцать бьют.', 'December 19, 2022, 8:57 pm'),
(14, 8, 1, 'Отличная схема!', 'December 19, 2022, 10:11 pm'),
(22, 8, 15, 'Как весело!', 'December 20, 2022, 9:26 pm'),
(23, 11, 1, 'Да, мне тоже нравится.', '22 December, 2022, 21:13 pm'),
(24, 11, 1, 'Тест новой даты', '22 декабря 2022 г.,  21:55'),
(26, 2, 21, 'Почему же это изображение без комментариев?', '22 декабря 2022 г.,  22:23'),
(27, 5, 21, 'Надо исправить)', '23 декабря 2022 г.,  13:16'),
(28, 5, 27, 'Очень красиво! Где снято?', '23 декабря 2022 г.,  13:58');

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `image_id` int UNSIGNED NOT NULL,
  `uploader_id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`image_id`, `uploader_id`, `name`) VALUES
(1, 1, 'uploads/R958Q - 2.jpg'),
(7, 2, 'uploads/1618453632_36-phonoteka_org-p-fon-dlya-otkritki-s-novim-godom-52.jpg'),
(11, 6, 'uploads/R958H - 1.jpg'),
(14, 7, 'uploads/Planet9_3840x2160.jpg'),
(15, 5, 'uploads/1.jpg'),
(16, 8, 'uploads/children_jpeg.jpg'),
(17, 8, 'uploads/3.jpg'),
(18, 8, 'uploads/1.png'),
(20, 3, 'uploads/S107T.jpg'),
(21, 3, 'uploads/IMG-20220516-WA0002.jpg'),
(23, 5, 'uploads/Picture23'),
(27, 5, 'uploads/Picture27.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int UNSIGNED NOT NULL,
  `user_login` varchar(30) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
  `user_password` varchar(32) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
  `user_hash` varchar(32) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL DEFAULT '',
  `user_ip` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_password`, `user_hash`, `user_ip`) VALUES
(1, 'Resa', 'c4e14d38d939ebf3f227fa46492dd992', 'cb20834f09a98e0a0a2c8c3f536a296a', 0),
(2, 'Natalia', '485c50b5055548508398db885bae15f7', '3d7af4bc2f611592f2434771ff161c11', 0),
(3, 'Anthony', '65ee77ba45cd8d4e12e6e50313968df5', '51743564de16160c8642c4da4a9a5d1c', 2130706433),
(4, 'Nicholas', 'db00feea3951d3a08e78f3b24b21ded3', 'bd6573e00ef264ca6f5e287222d81cce', 0),
(5, 'Tanya', 'ba6b8128b99108c870ac83d8a4876aac', '14fd3c6a3f39049a32fe32ff32cc37cc', 0),
(6, 'Alex', '796c0079eab8b19f02d8a71ea4311a50', '306f6347adc347d6ed6c9427eea6adbe', 0),
(7, 'Mary', 'f8a69dfbe86f5cbc8aca3efd9806ffd2', '2a8831dd17e6f04b01de9907daeb6ea2', 0),
(8, 'Annie', 'ac2297e7827fefbed6658b000f387e28', 'bc4d11aa1b9b33690d64a07bf0be2d02', 0),
(9, 'Jonathan', '213e7f2bab84b84b899be2b0bf8d17aa', '052b735c24b28998e844426306c466ad', 0),
(10, 'Alexandra', 'f55067b736c347c9b7555b376a6d1053', 'ff5271e276250b73954c555ab8012975', 0),
(11, 'Robin', '595e733954cded61f0e28deb0967a44e', '9b52ab646a89f93cfe6ed762fd19bd3b', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `fk_uploader` (`uploader_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`uploader_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
