-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 25 2022 г., 18:48
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
(31, 14, 31, 'Это мы с дочками на юге отдыхали :)', '25 декабря 2022 г.,  17:40'),
(32, 15, 30, 'Это Блю марбл?', '25 декабря 2022 г.,  17:54'),
(33, 15, 31, 'Как здорово! Тоже хочу в отпуск :(', '25 декабря 2022 г.,  17:55'),
(34, 14, 33, 'Такие фотографии всегда нагоняют на меня тоску. Это не Россия?', '25 декабря 2022 г.,  17:58'),
(35, 14, 34, 'Это знает всякий. Это не слова. Преданней собаки нету существа!', '25 декабря 2022 г.,  18:00'),
(36, 15, 34, 'Преданней собаки, ласковей собаки...', '25 декабря 2022 г.,  18:02'),
(37, 15, 33, 'Нет, это США. Обожаю заброшки.', '25 декабря 2022 г.,  18:03'),
(38, 13, 30, 'Нет, это фото 2006 года.', '25 декабря 2022 г.,  18:06'),
(39, 13, 34, 'Веселей собаки - нету существа!', '25 декабря 2022 г.,  18:06'),
(40, 15, 35, 'Галактика Боде. Идеальная спираль. И ни человека на световые годы вокруг...', '25 декабря 2022 г.,  18:15'),
(41, 14, 36, 'Какая красота!', '25 декабря 2022 г.,  18:17'),
(42, 14, 37, 'Счастливые дети прекрасны вдвойне!', '25 декабря 2022 г.,  18:21'),
(43, 15, 38, 'У меня в детстве тоже был ретривер...', '25 декабря 2022 г.,  18:23'),
(44, 15, 40, 'Кинмел Холл... Как же я хочу тут побывать.', '25 декабря 2022 г.,  18:28'),
(45, 13, 41, 'Интересное фото! Это Индия?', '25 декабря 2022 г.,  18:31'),
(46, 15, 43, 'The universe is infinite and chaotic and cold. And there has never been a plan...', '25 декабря 2022 г.,  18:34'),
(47, 15, 41, 'Да, это в городе Шекгавати (штат Раджастан).', '25 декабря 2022 г.,  18:36'),
(48, 13, 44, 'Австралийская овчарка! Эта порода отлично дрессируется.', '25 декабря 2022 г.,  18:44');

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
(30, 13, 'uploads/Picture1.jpg'),
(31, 14, 'uploads/Picture31.jpg'),
(33, 15, 'uploads/Picture32.jpg'),
(34, 14, 'uploads/Picture34.jpg'),
(35, 13, 'uploads/Picture35.jpg'),
(36, 13, 'uploads/Picture36.jpg'),
(37, 14, 'uploads/Picture37.jpg'),
(38, 14, 'uploads/Picture38.jpg'),
(39, 15, 'uploads/Picture39.jpg'),
(40, 15, 'uploads/Picture40.jpg'),
(41, 15, 'uploads/Picture41.jpg'),
(42, 13, 'uploads/Picture42.jpg'),
(43, 13, 'uploads/Picture43.png'),
(44, 14, 'uploads/Picture44.jpg'),
(45, 15, 'uploads/Picture45.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int UNSIGNED NOT NULL,
  `user_login` varchar(30) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
  `user_password` varchar(32) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
  `user_hash` varchar(32) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_password`, `user_hash`) VALUES
(13, 'Joseph', 'a0f88708159e790880dd246fa608ae37', 'b48f79957b05963bc8cdd06da0cf8cf0'),
(14, 'Nataly', '5a14752682b50f929ac52bfcc69a49c5', 'd91d9ee4ec6aa3b4f2945b3820fea3be'),
(15, 'Bella', '3ff50cadf7969ff8017d9ddca227e2a2', '079188a5ede7628baa611cc2fc2a929b');

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
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
