-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 09 2023 г., 15:20
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `taxi`
--

-- --------------------------------------------------------

--
-- Структура таблицы `acceptord`
--

CREATE TABLE `acceptord` (
  `id` int(11) NOT NULL,
  `idord` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `rating` int(11) NOT NULL,
  `dissatisfaction` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `acceptord`
--

INSERT INTO `acceptord` (`id`, `idord`, `comment`, `rating`, `dissatisfaction`) VALUES
(8, 3, 'отзыв', 5, '');

-- --------------------------------------------------------

--
-- Структура таблицы `carphoto`
--

CREATE TABLE `carphoto` (
  `id` int(11) NOT NULL,
  `iddriver` int(11) NOT NULL,
  `carpath` varchar(500) NOT NULL,
  `postdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cartaxi`
--

CREATE TABLE `cartaxi` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `marka` varchar(100) NOT NULL,
  `licplate` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `cartaxi`
--

INSERT INTO `cartaxi` (`id`, `iduser`, `marka`, `licplate`) VALUES
(2, 8, 'Nissan ', 'А777АА 086');

-- --------------------------------------------------------

--
-- Структура таблицы `dissatisfaction`
--

CREATE TABLE `dissatisfaction` (
  `id` int(11) NOT NULL,
  `diss` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `dissatisfaction`
--

INSERT INTO `dissatisfaction` (`id`, `diss`) VALUES
(1, 'Отсутствие заказчика'),
(5, 'Авария'),
(6, 'Неудовлетворенность клиента приехавшей машиной');

-- --------------------------------------------------------

--
-- Структура таблицы `driverwd`
--

CREATE TABLE `driverwd` (
  `id` int(11) NOT NULL,
  `iddriver` int(11) NOT NULL,
  `date` date NOT NULL,
  `free` int(11) NOT NULL,
  `end` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `driverwd`
--

INSERT INTO `driverwd` (`id`, `iddriver`, `date`, `free`, `end`) VALUES
(8, 8, '2023-04-08', 1, 1),
(9, 8, '2023-04-09', 0, 1),
(10, 8, '2023-04-09', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `operatorwd`
--

CREATE TABLE `operatorwd` (
  `id` int(11) NOT NULL,
  `idoper` int(11) NOT NULL,
  `date` date NOT NULL,
  `end` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `operatorwd`
--

INSERT INTO `operatorwd` (`id`, `idoper`, `date`, `end`) VALUES
(18, 7, '2023-04-08', 1),
(19, 9, '2023-04-08', 1),
(20, 7, '2023-04-09', 1),
(21, 9, '2023-04-09', 1),
(22, 7, '2023-04-09', 0),
(23, 9, '2023-04-09', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `ord`
--

CREATE TABLE `ord` (
  `id` int(11) NOT NULL,
  `phone` text NOT NULL,
  `nameuser` varchar(100) NOT NULL,
  `timeout` int(11) NOT NULL,
  `dateorder` date DEFAULT NULL,
  `time` text NOT NULL,
  `start` varchar(500) NOT NULL,
  `finish` varchar(500) NOT NULL,
  `price` int(11) NOT NULL,
  `driver` int(11) NOT NULL,
  `accept` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `ord`
--

INSERT INTO `ord` (`id`, `phone`, `nameuser`, `timeout`, `dateorder`, `time`, `start`, `finish`, `price`, `driver`, `accept`) VALUES
(3, '185151651', 'asd', 50, '2023-04-09', '10-30', 'wqe', 'rty', 185, 8, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `salary`
--

CREATE TABLE `salary` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `date` date NOT NULL,
  `salary` int(11) NOT NULL,
  `tax_salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `salary`
--

INSERT INTO `salary` (`id`, `iduser`, `date`, `salary`, `tax_salary`) VALUES
(5, 8, '2023-04-09', 93, 0),
(6, 7, '2023-04-09', 93, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `idgroup` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `fio` varchar(100) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` text NOT NULL,
  `fired` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `idgroup`, `login`, `password`, `fio`, `phone`, `email`, `fired`) VALUES
(1, 1, 'admin', '$2y$10$gLXM3E1g1zkGYUK6gIK9.uUGXQ1QIy1cbmkC9uLXCdo.yOFXCu5x6', 'admin', 123456, 'admin@admin', 0),
(7, 2, 'operator', '$2y$10$6Hm6KGeGAdTpYk09ZNCSS.L9/a.W0fdWldl6mHsjycs7lcA4BJTWO', 'Васильков Федор Иванович', 12356889, 'operator@operator', 0),
(8, 3, 'driver1', '$2y$10$zl9ROPu5j6V9DvpIk41Dau0y18Af5qmwUoiEhTHXIbBO3Mxil.W2K', 'Филонович Рамзан Александрович', 1249816, 'driver1@driver1', 0),
(9, 2, 'operator2', '$2y$10$JF.46RNgkiOvTPyRj8CpMOiBMXA.aDC74PmTYzwKvwKFBLbpWfKIG', 'Киселев Андрей Иванович', 12135513, 'operator2@operator2', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `usercart`
--

CREATE TABLE `usercart` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `avatar` varchar(500) NOT NULL,
  `contract` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `usercart`
--

INSERT INTO `usercart` (`id`, `iduser`, `avatar`, `contract`) VALUES
(5, 7, 'upload/userinfo/operator/1680790309ferma-slider.png', 'upload/userinfo/operator/1680790309slider-back.png'),
(6, 8, 'upload/userinfo/driver1/1680790501ferma-slider.png', 'upload/userinfo/driver1/1680790501slider-back.png'),
(7, 9, 'upload/userinfo/operator2/1680790624ferma-slider.png', 'upload/userinfo/operator2/1680790624slider-back.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `acceptord`
--
ALTER TABLE `acceptord`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `carphoto`
--
ALTER TABLE `carphoto`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cartaxi`
--
ALTER TABLE `cartaxi`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dissatisfaction`
--
ALTER TABLE `dissatisfaction`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `driverwd`
--
ALTER TABLE `driverwd`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `operatorwd`
--
ALTER TABLE `operatorwd`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ord`
--
ALTER TABLE `ord`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `usercart`
--
ALTER TABLE `usercart`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `acceptord`
--
ALTER TABLE `acceptord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `carphoto`
--
ALTER TABLE `carphoto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `cartaxi`
--
ALTER TABLE `cartaxi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `dissatisfaction`
--
ALTER TABLE `dissatisfaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `driverwd`
--
ALTER TABLE `driverwd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `operatorwd`
--
ALTER TABLE `operatorwd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `ord`
--
ALTER TABLE `ord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `salary`
--
ALTER TABLE `salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `usercart`
--
ALTER TABLE `usercart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
