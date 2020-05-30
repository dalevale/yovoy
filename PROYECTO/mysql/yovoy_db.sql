-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2020 at 09:21 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(9) NOT NULL,
  `object_type` int(1) NOT NULL,
  `obj_user_id` int(9) DEFAULT NULL,
  `obj_event_id` int(11) DEFAULT NULL,
  `activity_date` datetime NOT NULL,
  `activity_type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activity_id`, `user_id`, `object_type`, `obj_user_id`, `obj_event_id`, `activity_date`, `activity_type`) VALUES
(4, 2, 1, NULL, 42, '2020-05-26 21:10:37', 1),
(5, 2, 0, 9, NULL, '2020-05-26 21:18:44', 0),
(6, 9, 0, 2, NULL, '2020-05-26 21:18:45', 0),
(13, 2, 1, NULL, 11, '2020-05-26 23:03:18', 2),
(14, 2, 1, NULL, 11, '2020-05-26 23:08:58', 3);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(20) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(9) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `comment` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `event_id`, `user_id`, `date`, `comment`) VALUES
(81, 2, 9, '2020-05-24 21:58:15', 'awaw'),
(82, 2, 3, '2020-05-24 23:32:15', 'aasdasdsad');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `creator` int(9) NOT NULL,
  `img_name` varchar(50) DEFAULT NULL,
  `aux_autoinc` int(3) NOT NULL DEFAULT 1,
  `creation_date` date NOT NULL DEFAULT current_timestamp(),
  `event_date` datetime NOT NULL,
  `capacity` int(11) NOT NULL,
  `current_attendees` int(11) NOT NULL,
  `location` varchar(30) DEFAULT NULL,
  `tags` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(42, 'Café del mes: Pumpkin Latte', 2, 'default-event.png', 1, '2020-05-26', '2020-05-30 12:00:00', 0, 0, '30', 'Primer 30 personas que compra un latté, con este codigo pueden validar un upgrade a pumpkin latte.', 'Centro Comercial Principe Pio');

-- --------------------------------------------------------

--
-- Table structure for table `event_aux_imgs`
--

CREATE TABLE `event_aux_imgs` (
  `event_id` int(11) NOT NULL,
  `img_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_aux_imgs`
--

INSERT INTO `event_aux_imgs` (`event_id`, `img_id`) VALUES
(2, 1);

--
-- Triggers `event_aux_imgs`
--
DELIMITER $$
CREATE TRIGGER `aux_autoinc_update` AFTER INSERT ON `event_aux_imgs` FOR EACH ROW UPDATE event SET event.aux_autoinc=event.aux_autoinc+1 WHERE event.event_id=NEW.event_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `event_tags`
--

CREATE TABLE `event_tags` (
  `event_id` int(11) NOT NULL,
  `tag` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(42, 'c');

-- --------------------------------------------------------

--
-- Table structure for table `join_event`
--

CREATE TABLE `join_event` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `join_date` datetime DEFAULT current_timestamp(),
  `accepted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `join_event`
--

INSERT INTO `join_event` (`event_id`, `user_id`, `join_date`, `accepted`) VALUES
(2, 3, '2020-05-23 13:50:23', 0),
(2, 4, '2020-05-23 13:50:23', 0),
(2, 5, '2020-05-25 17:51:54', 1),
(2, 6, '2020-05-23 13:48:39', 0),
(3, 3, '2020-05-16 00:00:00', 0),
(11, 2, '2020-05-26 23:08:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) NOT NULL,
  `this_user_id` int(9) NOT NULL,
  `that_user_id` int(9) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `type` int(1) NOT NULL,
  `date` date NOT NULL,
  `isRead` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(213, 9, 2, NULL, 1, '2020-05-26', 0),
(214, 9, 2, NULL, 1, '2020-05-26', 0),
(219, 2, NULL, 11, 3, '2020-05-26', 0),
(225, 2, 9, 2, 5, '2020-05-27', 0),
(242, 2, 9, NULL, 0, '2020-05-27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `promote_event`
--

CREATE TABLE `promote_event` (
  `user_id` int(9) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promote_event`
--

INSERT INTO `promote_event` (`user_id`, `event_id`) VALUES
(2, 11),
(2, 15),
(9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

CREATE TABLE `relationship` (
  `user_one_id` int(9) NOT NULL,
  `user_two_id` int(9) NOT NULL,
  `status` int(1) NOT NULL,
  `action_user_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `relationship`
--

INSERT INTO `relationship` (`user_one_id`, `user_two_id`, `status`, `action_user_id`) VALUES
(2, 3, 1, 3),
(2, 4, 0, 2),
(2, 9, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `report_id` int(9) NOT NULL,
  `object_type` int(1) NOT NULL,
  `obj_user_id` int(11) DEFAULT NULL,
  `obj_event_id` int(11) DEFAULT NULL,
  `report_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `resolved` int(1) NOT NULL,
  `report_text` varchar(150) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`report_id`, `object_type`, `obj_user_id`, `obj_event_id`, `report_date`, `user_id`, `resolved`, `report_text`) VALUES
(2, 0, 5, NULL, '2020-05-28 08:53:38', 8, 1, 'ES QUE'),
(21, 0, 2, NULL, '2020-05-28 00:04:11', 9, 1, 'aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa aaaaaaaaaa');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(9) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `username` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `img_name` varchar(50) DEFAULT NULL,
  `creation_date` date NOT NULL DEFAULT current_timestamp(),
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(19, 'premium.5@yovoy.com', '$2y$10$FOI8mzVyDxe8ePge7Ly8PuEHzAkewm5d7FTcG.USEQksKwXV.FVoi', 'premium5', 'Usuario Premium E', 'default.jpg', '2020-05-30', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `obj_user_id` (`obj_user_id`),
  ADD KEY `obj_event_id` (`obj_event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `createEvent` (`creator`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `event_aux_imgs`
--
ALTER TABLE `event_aux_imgs`
  ADD PRIMARY KEY (`event_id`,`img_id`) USING BTREE;

--
-- Indexes for table `event_tags`
--
ALTER TABLE `event_tags`
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `join_event`
--
ALTER TABLE `join_event`
  ADD PRIMARY KEY (`event_id`,`user_id`),
  ADD KEY `user` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `this_user_id` (`this_user_id`),
  ADD KEY `that_user_id` (`that_user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `promote_event`
--
ALTER TABLE `promote_event`
  ADD PRIMARY KEY (`user_id`,`event_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `relationship`
--
ALTER TABLE `relationship`
  ADD PRIMARY KEY (`user_one_id`,`user_two_id`),
  ADD UNIQUE KEY `user_one_id` (`user_one_id`,`user_two_id`),
  ADD KEY `user_id2` (`user_two_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `obj_event_id` (`obj_event_id`),
  ADD KEY `obj_user_id` (`obj_user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_ibfk_2` FOREIGN KEY (`obj_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_ibfk_3` FOREIGN KEY (`obj_event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `createEvent` FOREIGN KEY (`creator`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_aux_imgs`
--
ALTER TABLE `event_aux_imgs`
  ADD CONSTRAINT `FOREIGN` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_tags`
--
ALTER TABLE `event_tags`
  ADD CONSTRAINT `event_id` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `join_event`
--
ALTER TABLE `join_event`
  ADD CONSTRAINT `event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`that_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`this_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promote_event`
--
ALTER TABLE `promote_event`
  ADD CONSTRAINT `promote_event_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `promote_event_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `relationship`
--
ALTER TABLE `relationship`
  ADD CONSTRAINT `user_id1` FOREIGN KEY (`user_one_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id2` FOREIGN KEY (`user_two_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`obj_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`obj_event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
