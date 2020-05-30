-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2020 at 08:43 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yovoy_db`
--
CREATE DATABASE IF NOT EXISTS `yovoy_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `yovoy_db`;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activity_id`, `user_id`, `object_type`, `obj_user_id`, `obj_event_id`, `activity_date`, `activity_type`) VALUES
(4, 2, 1, NULL, 42, '2020-05-26 21:10:37', 1),
(5, 2, 0, 9, NULL, '2020-05-26 21:18:44', 0),
(6, 9, 0, 2, NULL, '2020-05-26 21:18:45', 0),
(13, 2, 1, NULL, 11, '2020-05-26 23:03:18', 2),
(14, 2, 1, NULL, 11, '2020-05-26 23:08:58', 3),
(36, 16, 0, 13, NULL, '2020-05-30 16:57:48', 0),
(37, 13, 0, 16, NULL, '2020-05-30 16:57:49', 0),
(38, 17, 0, 16, NULL, '2020-05-30 16:59:54', 0),
(39, 16, 0, 17, NULL, '2020-05-30 16:59:55', 0),
(40, 17, 0, 13, NULL, '2020-05-30 16:59:59', 0),
(41, 13, 0, 17, NULL, '2020-05-30 16:59:59', 0),
(42, 18, 0, 13, NULL, '2020-05-30 17:07:54', 0),
(43, 13, 0, 18, NULL, '2020-05-30 17:07:54', 0),
(44, 18, 0, 16, NULL, '2020-05-30 17:07:59', 0),
(45, 16, 0, 18, NULL, '2020-05-30 17:07:59', 0),
(46, 18, 0, 17, NULL, '2020-05-30 17:08:04', 0),
(47, 17, 0, 18, NULL, '2020-05-30 17:08:04', 0),
(48, 19, 0, 13, NULL, '2020-05-30 17:11:18', 0),
(49, 13, 0, 19, NULL, '2020-05-30 17:11:18', 0),
(50, 19, 0, 16, NULL, '2020-05-30 17:11:22', 0),
(51, 16, 0, 19, NULL, '2020-05-30 17:11:22', 0),
(52, 19, 0, 17, NULL, '2020-05-30 17:11:25', 0),
(53, 17, 0, 19, NULL, '2020-05-30 17:11:25', 0),
(54, 19, 0, 18, NULL, '2020-05-30 17:11:29', 0),
(55, 18, 0, 19, NULL, '2020-05-30 17:11:29', 0),
(56, 20, 0, 13, NULL, '2020-05-30 17:12:42', 0),
(57, 13, 0, 20, NULL, '2020-05-30 17:12:42', 0),
(58, 20, 0, 16, NULL, '2020-05-30 17:12:48', 0),
(59, 16, 0, 20, NULL, '2020-05-30 17:12:48', 0),
(60, 20, 0, 17, NULL, '2020-05-30 17:12:53', 0),
(61, 17, 0, 20, NULL, '2020-05-30 17:12:53', 0),
(62, 20, 0, 18, NULL, '2020-05-30 17:12:56', 0),
(63, 18, 0, 20, NULL, '2020-05-30 17:12:56', 0),
(64, 20, 0, 19, NULL, '2020-05-30 17:12:59', 0),
(65, 19, 0, 20, NULL, '2020-05-30 17:12:59', 0),
(66, 21, 0, 13, NULL, '2020-05-30 17:13:46', 0),
(67, 13, 0, 21, NULL, '2020-05-30 17:13:46', 0),
(68, 21, 0, 16, NULL, '2020-05-30 17:13:50', 0),
(69, 16, 0, 21, NULL, '2020-05-30 17:13:50', 0),
(70, 21, 0, 17, NULL, '2020-05-30 17:13:54', 0),
(71, 17, 0, 21, NULL, '2020-05-30 17:13:54', 0),
(72, 21, 0, 18, NULL, '2020-05-30 17:13:58', 0),
(73, 18, 0, 21, NULL, '2020-05-30 17:13:58', 0),
(74, 21, 0, 19, NULL, '2020-05-30 17:14:03', 0),
(75, 19, 0, 21, NULL, '2020-05-30 17:14:03', 0),
(76, 21, 0, 20, NULL, '2020-05-30 17:14:08', 0),
(77, 20, 0, 21, NULL, '2020-05-30 17:14:08', 0),
(78, 22, 0, 13, NULL, '2020-05-30 17:14:45', 0),
(79, 13, 0, 22, NULL, '2020-05-30 17:14:45', 0),
(80, 22, 0, 16, NULL, '2020-05-30 17:14:49', 0),
(81, 16, 0, 22, NULL, '2020-05-30 17:14:49', 0),
(82, 22, 0, 17, NULL, '2020-05-30 17:14:53', 0),
(83, 17, 0, 22, NULL, '2020-05-30 17:14:53', 0),
(84, 22, 0, 18, NULL, '2020-05-30 17:14:57', 0),
(85, 18, 0, 22, NULL, '2020-05-30 17:14:57', 0),
(86, 22, 0, 19, NULL, '2020-05-30 17:15:01', 0),
(87, 19, 0, 22, NULL, '2020-05-30 17:15:01', 0),
(88, 22, 0, 20, NULL, '2020-05-30 17:15:05', 0),
(89, 20, 0, 22, NULL, '2020-05-30 17:15:05', 0),
(90, 22, 0, 21, NULL, '2020-05-30 17:15:09', 0),
(91, 21, 0, 22, NULL, '2020-05-30 17:15:09', 0),
(92, 14, 0, 13, NULL, '2020-05-30 17:16:28', 0),
(93, 13, 0, 14, NULL, '2020-05-30 17:16:28', 0),
(94, 14, 0, 16, NULL, '2020-05-30 17:16:33', 0),
(95, 16, 0, 14, NULL, '2020-05-30 17:16:33', 0),
(96, 14, 0, 17, NULL, '2020-05-30 17:16:36', 0),
(97, 17, 0, 14, NULL, '2020-05-30 17:16:36', 0),
(98, 14, 0, 18, NULL, '2020-05-30 17:16:41', 0),
(99, 18, 0, 14, NULL, '2020-05-30 17:16:41', 0),
(100, 14, 0, 19, NULL, '2020-05-30 17:16:45', 0),
(101, 19, 0, 14, NULL, '2020-05-30 17:16:45', 0),
(102, 14, 0, 20, NULL, '2020-05-30 17:16:50', 0),
(103, 20, 0, 14, NULL, '2020-05-30 17:16:50', 0),
(104, 14, 0, 21, NULL, '2020-05-30 17:16:54', 0),
(105, 21, 0, 14, NULL, '2020-05-30 17:16:55', 0),
(106, 14, 0, 22, NULL, '2020-05-30 17:16:58', 0),
(107, 22, 0, 14, NULL, '2020-05-30 17:16:58', 0),
(108, 23, 0, 17, NULL, '2020-05-30 17:17:28', 0),
(109, 17, 0, 23, NULL, '2020-05-30 17:17:28', 0),
(110, 23, 0, 13, NULL, '2020-05-30 17:17:32', 0),
(111, 13, 0, 23, NULL, '2020-05-30 17:17:32', 0),
(112, 23, 0, 16, NULL, '2020-05-30 17:17:35', 0),
(113, 16, 0, 23, NULL, '2020-05-30 17:17:35', 0),
(114, 23, 0, 18, NULL, '2020-05-30 17:17:39', 0),
(115, 18, 0, 23, NULL, '2020-05-30 17:17:39', 0),
(116, 23, 0, 19, NULL, '2020-05-30 17:17:42', 0),
(117, 19, 0, 23, NULL, '2020-05-30 17:17:43', 0),
(118, 23, 0, 20, NULL, '2020-05-30 17:17:46', 0),
(119, 20, 0, 23, NULL, '2020-05-30 17:17:46', 0),
(120, 23, 0, 21, NULL, '2020-05-30 17:17:50', 0),
(121, 21, 0, 23, NULL, '2020-05-30 17:17:50', 0),
(122, 23, 0, 22, NULL, '2020-05-30 17:17:54', 0),
(123, 22, 0, 23, NULL, '2020-05-30 17:17:54', 0),
(124, 23, 0, 14, NULL, '2020-05-30 17:17:58', 0),
(125, 14, 0, 23, NULL, '2020-05-30 17:17:58', 0),
(126, 9, 1, NULL, 47, '2020-05-30 13:23:05', 1),
(127, 2, 1, NULL, 43, '2020-05-30 16:16:50', 3),
(129, 2, 1, NULL, 49, '2020-05-30 16:21:01', 1),
(130, 6, 1, NULL, 49, '2020-05-30 16:21:16', 2),
(132, 4, 0, 2, NULL, '2020-05-30 16:50:16', 0),
(133, 2, 0, 4, NULL, '2020-05-30 16:50:16', 0),
(134, 20, 1, NULL, 43, '2020-05-31 02:23:32', 2),
(135, 20, 1, NULL, 51, '2020-05-31 02:28:04', 1);

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `event_id`, `user_id`, `date`, `comment`) VALUES
(81, 2, 9, '2020-05-24 21:58:15', 'awaw'),
(82, 2, 3, '2020-05-24 23:32:15', 'aasdasdsad'),
(85, 8, 9, '2020-05-30 16:14:41', 'Este evento parece muy intersente...'),
(87, 43, 20, '2020-05-30 20:25:27', '¡Espero que haya mucha gente aquí!');

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `name`, `creator`, `img_name`, `aux_autoinc`, `creation_date`, `event_date`, `capacity`, `current_attendees`, `location`, `tags`, `description`) VALUES
(2, 'Barra Libre', 2, '2.png', 3, '2020-03-01', '2020-05-01 15:00:00', 20, 1, 'Madrid SOL', 'cerveza, alcohol', '¡Vamos a beber cerveza gratis!'),
(3, 'RokEnRol', 2, '3.png', 1, '2020-03-30', '2020-05-30 00:00:00', 100, 1, 'WiZink', NULL, '¡Una noche de Rock and Rol!'),
(8, 'Unli Rice', 2, '8.png', 1, '2020-04-24', '2020-05-30 00:00:00', 99, 0, 'Gran Via, Madrid', 'arroz', 'Si te gusta mucho el arroz, ven a hincharte!'),
(10, 'Hamburgesa gratis primer 100 personas!', 2, '10.png', 1, '2020-04-24', '2020-05-30 00:00:00', 100, 0, 'Burger King, Calle Princesa, M', 'bk, hamburges, burgerking', 'Primer 100 personas, 1 menu whopper gratis!'),
(11, 'Bingo!', 4, '11.png', 1, '2020-04-24', '2020-05-30 00:00:00', 20, 0, 'Calle Manuela Malasaña, Madrid', 'bingo, premio', 'Aqui es divertido! Podrás ganar premios que no puedes imaginar!'),
(15, 'GameAndWin', 9, '15.png', 1, '2020-05-07', '2020-05-30 00:00:00', 99, 0, 'Centro Comercial La Vaguada', 'games, win, prizes', 'Varios juegos para divertir con amigos y ganar premios. Esto es una descripcion larga para mostrar m'),
(42, 'Café del mes: Pumpkin Latte', 2, 'default-event.png', 1, '2020-05-26', '2020-05-30 12:00:00', 0, 0, '30', 'Primer 30 personas que compra un latté, con este codigo pueden validar un upgrade a pumpkin latte.', 'Centro Comercial Principe Pio'),
(43, 'Evento premium', 13, '43.png', 3, '2020-05-21', '2020-08-12 12:00:00', 80, 0, 'Alcobendas', 'comida', 'Aqui hay fiesta'),
(47, 'Sesión de fotos', 9, 'default-event.png', 1, '2020-05-30', '2020-08-07 15:00:00', 15, 0, 'Casa de Campo Madrid', 'fotos,flores,arroz', 'Se hará una sesión de fotos. Los usuarios premium podrán optar a vestuario.'),
(49, 'EVENTO FIESTERO', 2, '49.png', 2, '2020-05-30', '2020-10-23 23:00:00', 10, 0, 'Barcelona', 'fiesta,alegria', 'Fiesta a tope'),
(51, 'Concierto', 20, '51.png', 3, '2020-05-30', '2020-07-27 16:00:00', 20, 0, 'Gran Via, Madrid', 'musica, concierto', 'Una sesión de música para todos');

--
-- Dumping data for table `event_aux_imgs`
--

INSERT INTO `event_aux_imgs` (`event_id`, `img_id`) VALUES
(2, 1),
(43, 1),
(43, 2),
(49, 1),
(51, 1),
(51, 2);

--
-- Dumping data for table `event_tags`
--

INSERT INTO `event_tags` (`event_id`, `tag`) VALUES
(8, 'arroz'),
(10, 'bk'),
(10, ' hamburgesa'),
(10, ' burgerking'),
(11, 'bingo'),
(11, ' premio'),
(15, 'games'),
(15, ' win'),
(15, ' prizes'),
(2, 'cerveza'),
(2, ' alcohol'),
(42, 'c'),
(8, 'arroz'),
(10, 'bk'),
(10, ' hamburgesa'),
(10, ' burgerking'),
(11, 'bingo'),
(11, ' premio'),
(15, 'games'),
(15, ' win'),
(15, ' prizes'),
(2, 'cerveza'),
(2, ' alcohol'),
(42, 'c'),
(8, 'arroz'),
(10, 'bk'),
(10, ' hamburgesa'),
(10, ' burgerking'),
(11, 'bingo'),
(11, ' premio'),
(15, 'games'),
(15, ' win'),
(15, ' prizes'),
(2, 'cerveza'),
(2, ' alcohol'),
(42, 'c'),
(47, 'fotos'),
(47, 'flores'),
(47, 'arroz'),
(43, 'comida'),
(49, 'fiesta'),
(49, 'alegria'),
(51, 'musica'),
(51, ' concierto');

--
-- Dumping data for table `join_event`
--

INSERT INTO `join_event` (`event_id`, `user_id`, `join_date`, `accepted`) VALUES
(2, 3, '2020-05-23 13:50:23', 0),
(2, 4, '2020-05-23 13:50:23', 0),
(2, 5, '2020-05-25 17:51:54', 1),
(2, 6, '2020-05-23 13:48:39', 0),
(3, 3, '2020-05-16 00:00:00', 0),
(10, 6, '2020-05-30 16:18:38', 0),
(11, 2, '2020-05-26 23:08:58', 1),
(43, 2, '2020-05-30 16:16:50', 1),
(49, 6, '2020-05-30 16:21:14', 0),
(49, 14, '2020-05-30 16:21:41', 0);

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `this_user_id`, `that_user_id`, `event_id`, `type`, `date`, `isRead`) VALUES
(190, 2, 9, 2, 5, '2020-05-27', 0),
(192, 5, NULL, 2, 3, '2020-05-25', 0),
(208, 9, 2, NULL, 1, '2020-05-26', 0),
(209, 9, 2, NULL, 1, '2020-05-26', 0),
(210, 9, 2, NULL, 1, '2020-05-26', 0),
(211, 9, 2, NULL, 1, '2020-05-26', 0),
(212, 9, 2, NULL, 1, '2020-05-26', 0),
(219, 2, NULL, 11, 3, '2020-05-26', 0),
(225, 2, 9, 2, 5, '2020-05-27', 0),
(243, 16, 13, NULL, 0, '2020-05-30', 0),
(244, 17, 13, NULL, 0, '2020-05-30', 0),
(245, 18, 13, NULL, 0, '2020-05-30', 0),
(246, 19, 13, NULL, 0, '2020-05-30', 0),
(247, 21, 13, NULL, 0, '2020-05-30', 0),
(248, 20, 13, NULL, 0, '2020-05-30', 0),
(249, 14, 13, NULL, 0, '2020-05-30', 0),
(250, 22, 13, NULL, 0, '2020-05-30', 0),
(251, 13, 16, NULL, 1, '2020-05-30', 0),
(252, 17, 16, NULL, 0, '2020-05-30', 0),
(253, 18, 16, NULL, 0, '2020-05-30', 0),
(254, 19, 16, NULL, 0, '2020-05-30', 0),
(255, 20, 16, NULL, 0, '2020-05-30', 0),
(256, 21, 16, NULL, 0, '2020-05-30', 0),
(257, 14, 16, NULL, 0, '2020-05-30', 0),
(258, 22, 16, NULL, 0, '2020-05-30', 0),
(259, 16, 17, NULL, 1, '2020-05-30', 0),
(260, 13, 17, NULL, 1, '2020-05-30', 0),
(261, 18, 17, NULL, 0, '2020-05-30', 0),
(262, 19, 17, NULL, 0, '2020-05-30', 0),
(263, 20, 17, NULL, 0, '2020-05-30', 0),
(264, 21, 17, NULL, 0, '2020-05-30', 0),
(265, 14, 17, NULL, 0, '2020-05-30', 0),
(266, 22, 17, NULL, 0, '2020-05-30', 0),
(267, 23, 17, NULL, 0, '2020-05-30', 0),
(268, 23, 13, NULL, 0, '2020-05-30', 0),
(269, 23, 16, NULL, 0, '2020-05-30', 0),
(270, 13, 18, NULL, 1, '2020-05-30', 0),
(271, 16, 18, NULL, 1, '2020-05-30', 0),
(272, 17, 18, NULL, 1, '2020-05-30', 0),
(273, 19, 18, NULL, 0, '2020-05-30', 0),
(274, 20, 18, NULL, 0, '2020-05-30', 0),
(275, 21, 18, NULL, 0, '2020-05-30', 0),
(276, 14, 18, NULL, 0, '2020-05-30', 0),
(277, 22, 18, NULL, 0, '2020-05-30', 0),
(278, 23, 18, NULL, 0, '2020-05-30', 0),
(279, 13, 19, NULL, 1, '2020-05-30', 0),
(280, 16, 19, NULL, 1, '2020-05-30', 0),
(281, 17, 19, NULL, 1, '2020-05-30', 0),
(282, 18, 19, NULL, 1, '2020-05-30', 0),
(283, 20, 19, NULL, 0, '2020-05-30', 0),
(284, 21, 19, NULL, 0, '2020-05-30', 0),
(285, 22, 19, NULL, 0, '2020-05-30', 0),
(286, 14, 19, NULL, 0, '2020-05-30', 0),
(287, 23, 19, NULL, 0, '2020-05-30', 0),
(288, 13, 20, NULL, 1, '2020-05-30', 0),
(289, 16, 20, NULL, 1, '2020-05-30', 0),
(290, 17, 20, NULL, 1, '2020-05-30', 0),
(291, 18, 20, NULL, 1, '2020-05-30', 0),
(292, 19, 20, NULL, 1, '2020-05-30', 0),
(293, 21, 20, NULL, 0, '2020-05-30', 0),
(294, 14, 20, NULL, 0, '2020-05-30', 0),
(295, 22, 20, NULL, 0, '2020-05-30', 0),
(296, 23, 20, NULL, 0, '2020-05-30', 0),
(297, 13, 21, NULL, 1, '2020-05-30', 0),
(298, 16, 21, NULL, 1, '2020-05-30', 0),
(299, 17, 21, NULL, 1, '2020-05-30', 0),
(300, 18, 21, NULL, 1, '2020-05-30', 0),
(301, 19, 21, NULL, 1, '2020-05-30', 0),
(302, 20, 21, NULL, 1, '2020-05-30', 0),
(303, 14, 21, NULL, 0, '2020-05-30', 0),
(304, 22, 21, NULL, 0, '2020-05-30', 0),
(305, 23, 21, NULL, 0, '2020-05-30', 0),
(306, 13, 22, NULL, 1, '2020-05-30', 0),
(307, 16, 22, NULL, 1, '2020-05-30', 0),
(308, 17, 22, NULL, 1, '2020-05-30', 0),
(309, 18, 22, NULL, 1, '2020-05-30', 0),
(310, 19, 22, NULL, 1, '2020-05-30', 0),
(311, 20, 22, NULL, 1, '2020-05-30', 0),
(312, 21, 22, NULL, 1, '2020-05-30', 0),
(313, 14, 22, NULL, 0, '2020-05-30', 0),
(314, 23, 22, NULL, 0, '2020-05-30', 0),
(315, 13, 14, NULL, 1, '2020-05-30', 0),
(316, 16, 14, NULL, 1, '2020-05-30', 0),
(317, 17, 14, NULL, 1, '2020-05-30', 0),
(318, 18, 14, NULL, 1, '2020-05-30', 0),
(319, 19, 14, NULL, 1, '2020-05-30', 0),
(320, 20, 14, NULL, 1, '2020-05-30', 0),
(321, 21, 14, NULL, 1, '2020-05-30', 0),
(322, 22, 14, NULL, 1, '2020-05-30', 0),
(323, 23, 14, NULL, 0, '2020-05-30', 0),
(324, 17, 23, NULL, 1, '2020-05-30', 0),
(325, 13, 23, NULL, 1, '2020-05-30', 0),
(326, 16, 23, NULL, 1, '2020-05-30', 0),
(327, 18, 23, NULL, 1, '2020-05-30', 0),
(328, 19, 23, NULL, 1, '2020-05-30', 0),
(329, 20, 23, NULL, 1, '2020-05-30', 0),
(330, 21, 23, NULL, 1, '2020-05-30', 0),
(331, 22, 23, NULL, 1, '2020-05-30', 0),
(332, 14, 23, NULL, 1, '2020-05-30', 0),
(333, 9, 2, 47, 5, '2020-05-30', 0),
(334, 2, 9, 8, 5, '2020-05-30', 0),
(336, 2, NULL, 43, 3, '2020-05-30', 0),
(337, 2, 13, NULL, 0, '2020-05-30', 0),
(339, 2, 6, 49, 2, '2020-05-30', 0),
(340, 2, 14, 49, 2, '2020-05-30', 0),
(341, 2, NULL, 43, 4, '2020-05-30', 1),
(342, 2, 4, NULL, 1, '2020-05-30', 0),
(343, 2, NULL, 43, 4, '2020-05-30', 0),
(344, 13, 20, 43, 5, '2020-05-30', 0),
(345, 13, 20, 43, 5, '2020-05-30', 0);

--
-- Dumping data for table `promote_event`
--

INSERT INTO `promote_event` (`user_id`, `event_id`) VALUES
(2, 11),
(2, 15),
(6, 49),
(9, 2),
(20, 43);

--
-- Dumping data for table `relationship`
--

INSERT INTO `relationship` (`user_one_id`, `user_two_id`, `status`, `action_user_id`) VALUES
(2, 3, 1, 3),
(2, 4, 1, 4),
(2, 9, 1, 9),
(2, 13, 0, 13),
(13, 14, 1, 14),
(13, 16, 1, 16),
(13, 17, 1, 17),
(13, 18, 1, 18),
(13, 19, 1, 19),
(13, 20, 1, 20),
(13, 21, 1, 21),
(13, 22, 1, 22),
(13, 23, 1, 23),
(14, 16, 1, 14),
(14, 17, 1, 14),
(14, 18, 1, 14),
(14, 19, 1, 14),
(14, 20, 1, 14),
(14, 21, 1, 14),
(14, 22, 1, 14),
(14, 23, 1, 23),
(16, 17, 1, 17),
(16, 18, 1, 18),
(16, 19, 1, 19),
(16, 20, 1, 20),
(16, 21, 1, 21),
(16, 22, 1, 22),
(16, 23, 1, 23),
(17, 18, 1, 18),
(17, 19, 1, 19),
(17, 20, 1, 20),
(17, 21, 1, 21),
(17, 22, 1, 22),
(17, 23, 1, 23),
(18, 19, 1, 19),
(18, 20, 1, 20),
(18, 21, 1, 21),
(18, 22, 1, 22),
(18, 23, 1, 23),
(19, 20, 1, 20),
(19, 21, 1, 21),
(19, 22, 1, 22),
(19, 23, 1, 23),
(20, 21, 1, 21),
(20, 22, 1, 22),
(20, 23, 1, 23),
(21, 22, 1, 22),
(21, 23, 1, 23),
(22, 23, 1, 23);

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`report_id`, `object_type`, `obj_user_id`, `obj_event_id`, `report_date`, `user_id`, `resolved`, `report_text`) VALUES
(2, 0, 5, NULL, '2020-05-28 08:53:38', 8, 1, 'ES QUE'),
(21, 0, 2, NULL, '2020-05-28 00:04:11', 9, 1, 'aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa'),
(22, 0, 3, NULL, '2020-05-30 16:41:55', 2, 0, 'No ha hecho nada bueno');

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `username`, `name`, `img_name`, `creation_date`, `type`) VALUES
(1, 'admin@yovoy.com', '$2y$10$hedED5zbm5TpTNTCizsURujEKUiA873d7Qj0HD8F/xtGesKM4g52m', 'eladmin', 'admin', '1.png', '2020-04-24', 0),
(2, 'maria@yovoy.com', '$2y$10$C9h7umkfFpTVvvPQsHyFNubDrAv/rCbESjDemDOapg1Dbfx6RAo5.', 'megustaeventos', 'Maria Mercedes', '2.png', '2020-04-24', 1),
(3, 'pablo@yovoy.com', '$2y$10$AgyNHL35/Iwl/EhgTD0kc.4i/0zJMpMf.NXlGkqOm/TKU9JHvbLFC', 'meaburro', 'Pablo Gonzales', '3.png', '2020-04-24', 1),
(4, 'manuel123@yovoy.com', '$2y$10$IdGxa/yeRXlYiLjH1V5iZOT.1P8X5lv7lpr84fiIDW2rAFY3jrSvi', 'elcapitan', 'Manuel Alvar', '4.png', '2020-04-24', 1),
(5, 'isabel789@yovoy.com', '$2y$10$j1e5Oq8EUldBF0tWcRa9aeqlh8xp0blZLYxTen5Z3WZlFADBPqbAa', 'isadora', 'Isabel Gapaz', '5.png', '2020-04-24', 1),
(6, 'ana12345@yovoy.com', '$2y$10$zQNBXXcyMdcVVDaqL6howOl4QeDj1fpXJBUaiAZ5SUdbKPd41Tyx6', 'anaanaana', 'Ana Velasquez', '6.png', '2020-04-25', 1),
(8, 'mario@yovoy.com', '$2y$10$yL4moLeRIhBLFM.iHTXZa.Ovt22S9E1O9CHfUfW.2q1DdnsxGNOvu', 'gamerfreak', 'Mario Mauricio Maurer', '8.png', '2020-04-26', 1),
(9, 'mariel@yovoy.com', '$2y$10$0sns19IcZFicXGa2ghV.W.lg2a4xOMUV.Lh4tusCUm8AnP8VgEpIy', 'vamosporalli', 'Mariel Sanchez', '9.png', '2020-05-07', 1),
(11, 'hhh@gmail.com', '$2y$10$T7429/pfwghwLyfNFCwpB.mvt1ocOvTvxvgD/y9QPD2eIiXR7ia5e', 'juanita', 'Juanita', 'default.jpg', '2020-05-10', 1),
(12, 'hhhh@gmail.com', '$2y$10$wWJuMaayl2gt2VSpStJyuOo4QlceNYAn0xOEoX/fpT.vkpspU24OG', 'jajajajajajaajaj', 'VERY ANGERY', '12.png', '2020-05-10', 1),
(13, 'premium@yovoy.com', '$2y$10$IgeqreB6jnXhCB8tk2RIuO1UDdg.xPEhzS3NPwQnaRQ/RBDNm1qbi', 'elonmusk', 'Elon Musk', '13.png', '2020-05-10', 2),
(14, 'richard@yovoy.com', '$2y$10$HnqoM6pFuc0Uk0DKwh9RKu7hBtubeacHfznKKCgEAjtzSITwNSQVe', 'richard2306', 'Richard Correa', 'default.jpg', '2020-05-15', 2),
(16, 'premium.2@yovoy.com', '$2y$10$gnVI7wdW7Tpsswi5vgxgJez/NqI0IEoilzuSxRw8rb0xhX4z6GtrO', 'premium2', 'Usuario Premium B', 'default.jpg', '2020-05-30', 2),
(17, 'premium.3@yovoy.com', '$2y$10$6Fo1PfYcxBlEMrdCZl9KUuT8NjAK9IkDjUH51GYIbPQySu0EULzxS', 'premium3', 'Usuario Premium C', 'default.jpg', '2020-05-30', 2),
(18, 'premium.4@yovoy.com', '$2y$10$ooOhzBX9zM7/toPbn2f5yeVcGNTsg5gJizmUzf7vP777i7gjp5jwe', 'premium4', 'Usuario Premium D', 'default.jpg', '2020-05-30', 2),
(19, 'premium.5@yovoy.com', '$2y$10$FOI8mzVyDxe8ePge7Ly8PuEHzAkewm5d7FTcG.USEQksKwXV.FVoi', 'premium5', 'Usuario Premium E', 'default.jpg', '2020-05-30', 2),
(20, 'harold@yovoy.com', '$2y$10$u6N7Mu5y.AQpGmyNKqyQJOSRWcP4eIGRwXKJ73CpSekVvqqKk3nUe', 'haroldabc', 'Harold Pascua', 'default.jpg', '2020-05-30', 2),
(21, 'dale@yovoy.com', '$2y$10$v/5uGSglsnFG8LLZtXIJRuGYab05ymkHl03GdYuMNAbfC01yUc.om', 'dalevale', 'Dale Valencia', 'default.jpg', '2020-05-30', 2),
(22, 'fer@yovoy.com', '$2y$10$Hg7FnS0mfdOvntUDYap.7.Qss8.VTOPG4Fa1KtnmOVDtE3POkT4uC', 'ter123', 'Fer Muñoz', 'default.jpg', '2020-05-30', 2),
(23, 'luis@gmail.com', '$2y$10$dmbOxh3ed3vQH506mt8VH.m6mtyXXmE6.XdSIU3pnfM/MAQpSK4OG', 'quieroir', 'Luis Cruz', 'default.jpg', '2020-05-30', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
