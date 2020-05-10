-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-05-2020 a las 19:10:00
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `yovoy_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(20) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(9) NOT NULL,
  `date` date NOT NULL,
  `comment` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`comment_id`, `event_id`, `user_id`, `date`, `comment`) VALUES
(1, 2, 2, '2020-05-07', 'HOOHOHO'),
(2, 2, 9, '2020-05-07', 'HOLAAAAAAAA COMO ESTAN! ESTO ES UN COMENTARIO LARGOoooooooooooooooooooooo y LARGOoooooooooooooooooooooo y LARGOoooooooooooooooooooooooooooooooo y LARGOooooooooooooooooooooooLARGOooooooooooooooooooooooLARGOoooooooooooooooooooooo'),
(3, 2, 9, '2020-05-07', 'EjemplooooooooLARGOoooooooooooooooooooooo'),
(5, 2, 9, '2020-05-07', 'Otra que soy pesado!'),
(6, 2, 9, '2020-05-07', 'Otra que soy pesado!');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `creator` int(9) NOT NULL,
  `img_name` varchar(50) DEFAULT NULL,
  `creation_date` date NOT NULL DEFAULT current_timestamp(),
  `event_date` date NOT NULL,
  `capacity` int(11) NOT NULL,
  `current_attendees` int(11) NOT NULL,
  `location` varchar(30) DEFAULT NULL,
  `tags` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `event`
--

INSERT INTO `event` (`event_id`, `name`, `creator`, `img_name`, `creation_date`, `event_date`, `capacity`, `current_attendees`, `location`, `tags`, `description`) VALUES
(2, 'Barra Libre', 2, 'default-event.png', '2020-03-30', '2020-03-30', 20, 1, 'Madrid SOL', 'cerveza, alcohol', '¡Vamos a beber cerveza gratis!'),
(3, 'RokEnRol', 2, 'rokenrol.jpg', '2020-03-30', '2020-04-01', 100, 1, 'WiZink', NULL, '¡Una noche de Rock and Rol!'),
(8, 'Unli Rice', 2, 'unli.jpg', '2020-04-24', '2020-04-30', 99, 0, 'Gran Via, Madrid', 'arroz', 'Si te gusta mucho el arroz, ven a hincharte!'),
(10, 'Hamburgesa gratis primer 100 personas!', 2, 'hamburgesa.jpg', '2020-04-24', '2020-04-22', 100, 0, 'Burger King, Calle Princesa, M', 'bk, hamburges, burgerking', 'Primer 100 personas, 1 menu whopper gratis!'),
(11, 'Bingo!', 4, 'bingo.jpg', '2020-04-24', '2020-06-05', 20, 0, 'Calle Manuela Malasaña, Madrid', 'bingo, premio', 'Aqui es divertido! Podrás ganar premios que no puedes imaginar!'),
(15, 'GameAndWin', 9, 'game.jpg', '2020-05-07', '2020-05-28', 99, 0, 'Centro Comercial La Vaguada', 'games, win, prizes', 'Varios juegos para divertir con amigos y ganar premios. Esto es una descripcion larga para mostrar m'),
(16, 'asdasdasdasd', 2, 'default-event.png', '2020-05-10', '2020-01-01', 1, 0, 'asdasd', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event_tags`
--

CREATE TABLE `event_tags` (
  `event_id` int(11) NOT NULL,
  `tag` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `event_tags`
--

INSERT INTO `event_tags` (`event_id`, `tag`) VALUES
(8, 'arroz'),
(10, 'bk'),
(10, ' hamburgesa'),
(10, ' burgerking'),
(11, 'bingo'),
(11, ' premio'),
(2, 'cerveza'),
(2, ' alcohol'),
(15, 'games'),
(15, ' win'),
(15, ' prizes'),
(16, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `join_event`
--

CREATE TABLE `join_event` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `join_date` date DEFAULT current_timestamp(),
  `accepted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `join_event`
--

INSERT INTO `join_event` (`event_id`, `user_id`, `join_date`, `accepted`) VALUES
(2, 3, '2020-05-07', 1),
(2, 4, '2020-05-07', 1),
(2, 5, '2020-05-07', 1),
(2, 6, '2020-05-07', 1),
(2, 9, '2020-05-07', 1),
(3, 3, '2020-05-07', 1),
(11, 2, '2020-05-07', 1),
(15, 2, '2020-05-09', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relationship`
--

CREATE TABLE `relationship` (
  `user_one_id` int(9) NOT NULL,
  `user_two_id` int(9) NOT NULL,
  `status` int(1) NOT NULL,
  `action_user_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `relationship`
--

INSERT INTO `relationship` (`user_one_id`, `user_two_id`, `status`, `action_user_id`) VALUES
(2, 3, 1, 2),
(2, 4, 1, 2),
(4, 9, 1, 9),
(5, 9, 2, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
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
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `username`, `name`, `img_name`, `creation_date`, `type`) VALUES
(1, 'admin@yovoy.com', '$2y$10$hedED5zbm5TpTNTCizsURujEKUiA873d7Qj0HD8F/xtGesKM4g52m', 'eladmin', 'admin', 'admin.png', '2020-04-24', 0),
(2, 'maria@yovoy.com', '$2y$10$C9h7umkfFpTVvvPQsHyFNubDrAv/rCbESjDemDOapg1Dbfx6RAo5.', 'megustaeventos', 'Maria Mercedes', 'maria.jpg', '2020-04-24', 1),
(3, 'pablo@yovoy.com', '$2y$10$AgyNHL35/Iwl/EhgTD0kc.4i/0zJMpMf.NXlGkqOm/TKU9JHvbLFC', 'meaburro', 'Pablo Gonzales', 'pablo.jpg', '2020-04-24', 1),
(4, 'manuel123@yovoy.com', '$2y$10$IdGxa/yeRXlYiLjH1V5iZOT.1P8X5lv7lpr84fiIDW2rAFY3jrSvi', 'elcapitan', 'Manuel Alvar', 'manuel.jpg', '2020-04-24', 1),
(5, 'isabel789@yovoy.com', '$2y$10$j1e5Oq8EUldBF0tWcRa9aeqlh8xp0blZLYxTen5Z3WZlFADBPqbAa', 'isadora', 'Isabel Gapaz', 'isabel.jpg', '2020-04-24', 1),
(6, 'ana12345@yovoy.com', '$2y$10$zQNBXXcyMdcVVDaqL6howOl4QeDj1fpXJBUaiAZ5SUdbKPd41Tyx6', 'anaanaana', 'Ana Velasquez', 'ana.png', '2020-04-25', 1),
(8, 'mario@yovoy.com', '$2y$10$yL4moLeRIhBLFM.iHTXZa.Ovt22S9E1O9CHfUfW.2q1DdnsxGNOvu', 'gamerfreak', 'Mario Mauricio Maurer', 'mario.jpg', '2020-04-26', 1),
(9, 'mariel@yovoy.com', '$2y$10$0sns19IcZFicXGa2ghV.W.lg2a4xOMUV.Lh4tusCUm8AnP8VgEpIy', 'vamosporalli', 'Mariel Sanchez', 'mariel.jpg', '2020-05-07', 1),
(11, 'hhh@gmail.com', '$2y$10$T7429/pfwghwLyfNFCwpB.mvt1ocOvTvxvgD/y9QPD2eIiXR7ia5e', 'juanita', 'Juanita', 'default.jpg', '2020-05-10', 1),
(12, 'hhhh@gmail.com', '$2y$10$wWJuMaayl2gt2VSpStJyuOo4QlceNYAn0xOEoX/fpT.vkpspU24OG', 'jajajajajajaajaj', 'VERY ANGERY', 'indexPic.jpg', '2020-05-10', 1),
(13, 'premium@yovoy.com', '$2y$10$IgeqreB6jnXhCB8tk2RIuO1UDdg.xPEhzS3NPwQnaRQ/RBDNm1qbi', 'elonmusk', 'Elon Musk', 'boton_UNIRSE_2.png', '2020-05-10', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `createEvent` (`creator`);

--
-- Indices de la tabla `event_tags`
--
ALTER TABLE `event_tags`
  ADD KEY `event_id` (`event_id`);

--
-- Indices de la tabla `join_event`
--
ALTER TABLE `join_event`
  ADD PRIMARY KEY (`event_id`,`user_id`),
  ADD KEY `user` (`user_id`);

--
-- Indices de la tabla `relationship`
--
ALTER TABLE `relationship`
  ADD PRIMARY KEY (`user_one_id`,`user_two_id`),
  ADD UNIQUE KEY `user_one_id` (`user_one_id`,`user_two_id`),
  ADD KEY `user_id2` (`user_two_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `createEvent` FOREIGN KEY (`creator`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `event_tags`
--
ALTER TABLE `event_tags`
  ADD CONSTRAINT `event_id` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `join_event`
--
ALTER TABLE `join_event`
  ADD CONSTRAINT `event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `relationship`
--
ALTER TABLE `relationship`
  ADD CONSTRAINT `user_id1` FOREIGN KEY (`user_one_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id2` FOREIGN KEY (`user_two_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
