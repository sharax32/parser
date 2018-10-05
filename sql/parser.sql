-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 05 2018 г., 07:21
-- Версия сервера: 5.6.38
-- Версия PHP: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `parser`
--

-- --------------------------------------------------------

--
-- Структура таблицы `zodiac`
--

CREATE TABLE `zodiac` (
  `id` int(11) DEFAULT '0',
  `name` varchar(50) DEFAULT '0',
  `link` varchar(50) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `zodiac_day`
--

CREATE TABLE `zodiac_day` (
  `zodiac_id` int(11) DEFAULT NULL,
  `day` int(11) DEFAULT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `zodiac_month`
--

CREATE TABLE `zodiac_month` (
  `zodiac_id` int(11) DEFAULT NULL,
  `month` text,
  `work` text,
  `love` text,
  `money` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `zodiac_year`
--

CREATE TABLE `zodiac_year` (
  `zodiac_id` int(11) DEFAULT NULL,
  `year` text,
  `work` text,
  `love` text,
  `money` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
