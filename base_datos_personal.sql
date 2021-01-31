-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2018 a las 00:46:35
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base_datos_personal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `load_license`
--

CREATE TABLE `load_license` (
  `id` int(200) NOT NULL,
  `cuil` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `comentarios` varchar(1000) COLLATE utf8_spanish2_ci NOT NULL,
  `sday` date NOT NULL,
  `fday` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `address` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `foto` varchar(200) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `load_license`
--

INSERT INTO `load_license` (`id`, `cuil`, `tipo`, `comentarios`, `sday`, `fday`, `address`, `foto`) VALUES
(38, '20366340522', 'Mesa de Examen', '', '2018-12-10', '7', 'CORREA SARRAT 420 DTO4', 'river.jpg'),
(43, '27393775993', 'ART', '', '2018-12-05', '2', 'Candelaria 399', 'e.jpg'),
(119, '20366340522', 'Otros', 'Solicito licencia por cuidado de familiar a cargo (esposa).', '2018-12-07', '7', 'Candelaria 399, Godoy Cruz', 'c_medico.jpg'),
(369, '20366340522', 'Otros', 'Solicito licencia por cuidado de familiar a cargo (esposa).', '2018-12-02', '10', 'Candelaria 399 Godoy Cruz', 'c_medico.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_personal`
--

CREATE TABLE `users_personal` (
  `id` int(11) NOT NULL,
  `cuil` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `cell` varchar(200) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `users_personal`
--

INSERT INTO `users_personal` (`id`, `cuil`, `password`, `name`, `email`, `cell`) VALUES
(72, '20366340522', '$2y$10$NGhyb7XSDXR8MxQ6tLSrjuav74jUdOQRgj3edmTuHt/tatG.xkTPG', 'Aldo Castillo', 'electricidad.castillo.g@gmail.com', '261-6934658'),
(73, '20390211105', '$2y$10$UjMaGCmjOO.ZXW0VIBWZ4uDU3KjAgs4vaSE4Bk93NxR.m/BfTK3pG', 'Gabriel Anzorena', 'gabrielfernandoanzorena@hotmail.com', '261-3404223'),
(74, '27393775993', '$2y$10$LfIQ75z6woSWy.t4BW.MeeY2Ymlt9czb.p8KNF0A94kZlN1wfdR1K', 'Gabriela Ayelén Rojo', 'gaby.ayelen@gmail.com', '261-6935949');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `load_license`
--
ALTER TABLE `load_license`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users_personal`
--
ALTER TABLE `users_personal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `load_license`
--
ALTER TABLE `load_license`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=370;

--
-- AUTO_INCREMENT de la tabla `users_personal`
--
ALTER TABLE `users_personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
