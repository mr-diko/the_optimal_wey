-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 20 2015 г., 16:53
-- Версия сервера: 5.5.44-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `optimal_rout`
--

-- --------------------------------------------------------

--
-- Структура таблицы `the_wey`
--

CREATE TABLE IF NOT EXISTS `the_wey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first node` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `second node` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `distance` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `the_wey`
--

INSERT INTO `the_wey` (`id`, `first node`, `second node`, `distance`, `time`) VALUES
(1, 'A', 'B', 80, 40),
(2, 'A', 'C', 110, 55),
(3, 'A', 'E', 330, 240),
(4, 'B', 'A', 80, 40),
(5, 'B', 'F', 340, 230),
(6, 'C', 'A', 110, 55),
(7, 'C', 'D', 60, 20),
(8, 'C', 'E', 205, 80),
(9, 'D', 'C', 60, 20),
(10, 'D', 'F', 192, 110),
(11, 'F', 'D', 192, 110),
(12, 'F', 'B', 340, 230),
(13, 'F', 'E', 80, 40),
(14, 'E', 'A', 330, 240),
(15, 'E', 'C', 205, 80),
(16, 'E', 'F', 80, 40);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
