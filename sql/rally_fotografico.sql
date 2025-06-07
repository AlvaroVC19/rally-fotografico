-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2025 a las 23:48:24
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rally_fotografico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `max_fotos_por_participante` int(11) DEFAULT 3,
  `fecha_inicio_subida` datetime DEFAULT NULL,
  `fecha_fin_subida` datetime DEFAULT NULL,
  `fecha_inicio_votacion` datetime DEFAULT NULL,
  `fecha_fin_votacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `max_fotos_por_participante`, `fecha_inicio_subida`, `fecha_fin_subida`, `fecha_inicio_votacion`, `fecha_fin_votacion`) VALUES
(1, 3, '2025-06-07 10:00:00', '2025-06-11 08:34:00', '2025-06-09 08:35:00', '2025-06-14 18:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotografias`
--

CREATE TABLE `fotografias` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `archivo` varchar(255) NOT NULL,
  `estado` enum('pendiente','admitida','rechazada') DEFAULT 'pendiente',
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `fotografias`
--

INSERT INTO `fotografias` (`id`, `id_usuario`, `titulo`, `descripcion`, `archivo`, `estado`, `fecha_subida`) VALUES
(1, 1, 'Amapolas', '', '6835fcdae6295.jpg', 'admitida', '2025-05-27 17:56:42'),
(2, 1, 'Margaritas', '', '68372be11bff4.jpg', 'admitida', '2025-05-28 15:29:37'),
(4, 1, 'Tulipanes', '', '68372c46e7bab.jpg', 'rechazada', '2025-05-28 15:31:18'),
(5, 3, 'Girasol', '', '68448c4e93d55.jpg', 'admitida', '2025-06-07 19:00:30'),
(6, 3, 'Flor de cerezo', '', '68448d128b19e.jpg', 'admitida', '2025-06-07 19:03:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','participante') DEFAULT 'participante',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'Alvaro', 'villadiego@gmail.com', '$2y$10$Kj1vOB7JOBaqcJR0DL.EyOZfx8wj/ezcBLyQA7eNCMDOEZ6LMkKnW', 'participante', '2025-05-26 14:31:16'),
(2, 'admin', 'admin@gmail.com', '$2y$10$.LYq1vfMofq/VbZ0Nsvni.AA5iSHKKn597CGtONnZbZQg.OSgBhsG', 'admin', '2025-05-26 14:49:05'),
(3, 'Maria', 'mariam@gmail.com', '$2y$10$XM/CYLHsrBGeS26MnNYL8.3FVGB3uCgBHx6f.l2LYbyEubRLWGN6e', 'participante', '2025-06-03 17:25:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos`
--

CREATE TABLE `votos` (
  `id` int(11) NOT NULL,
  `id_foto` int(11) NOT NULL,
  `ip_usuario` varchar(45) NOT NULL,
  `fecha_voto` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `votos`
--

INSERT INTO `votos` (`id`, `id_foto`, `ip_usuario`, `fecha_voto`) VALUES
(1, 1, '::1', '2025-05-27 17:59:17'),
(2, 5, '::1', '2025-06-07 19:09:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fotografias`
--
ALTER TABLE `fotografias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_foto` (`id_foto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fotografias`
--
ALTER TABLE `fotografias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `votos`
--
ALTER TABLE `votos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fotografias`
--
ALTER TABLE `fotografias`
  ADD CONSTRAINT `fotografias_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `votos_ibfk_1` FOREIGN KEY (`id_foto`) REFERENCES `fotografias` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
