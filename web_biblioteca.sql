-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2026 a las 18:18:20
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
-- Base de datos: `web_biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Novela', 'Obras narrativas extensas'),
(2, 'Cuento', 'Obras narrativas breves'),
(3, 'Poesía', 'Obras escritas en verso'),
(4, 'Ensayo', 'Texto de análisis o reflexión'),
(5, 'Ciencia ficción', 'Narrativa basada en ciencia y tecnología'),
(6, 'Fantasía', 'Narrativa con elementos sobrenaturales o imaginarios'),
(7, 'Terror', 'Narrativa orientada a provocar miedo'),
(8, 'Filosofía', 'Obras relacionadas con el pensamiento y la reflexión');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tipo_historial_id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_hora` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id`, `usuario_id`, `tipo_historial_id`, `descripcion`, `fecha_hora`) VALUES
(1, 1, 1, 'Agregó el libro \"1\"', '2026-10-28 10:46:12'),
(2, 1, 4, 'Se modificó el estado del libro \"1\"', '2026-10-28 10:46:18'),
(3, 1, 5, 'Se modificó la puntuación del libro \"1\" a 5', '2026-10-28 10:46:22'),
(4, 1, 2, 'Se modificó la reseña del libro \"1\"', '2026-10-28 10:46:32'),
(5, 1, 3, 'Se borró el libro \"1\"', '2026-10-28 10:46:40'),
(6, 7, 1, 'Agregó el libro \"Biblia\"', '2026-10-28 10:56:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `autor` varchar(150) NOT NULL,
  `genero_id` int(11) NOT NULL,
  `ano_publicacion` int(11) DEFAULT NULL,
  `editorial` varchar(150) DEFAULT NULL,
  `estado_lectura` varchar(20) NOT NULL,
  `puntuacion` int(11) DEFAULT NULL,
  `resena` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `usuario_id`, `titulo`, `autor`, `genero_id`, `ano_publicacion`, `editorial`, `estado_lectura`, `puntuacion`, `resena`, `imagen`) VALUES
(2, 7, 'Biblia', 'Dios', 5, 0, 'el cielo', '', NULL, NULL, 'assets/imagenes/8f89f70ca0bb7738f98e6b4c769a03c4.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_historial`
--

CREATE TABLE `tipo_historial` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_historial`
--

INSERT INTO `tipo_historial` (`id`, `nombre`, `descripcion`) VALUES
(1, 'ALTA_LIBRO', 'Alta de un libro'),
(2, 'MODIFICACION_LIBRO', 'Modificación de un libro'),
(3, 'ELIMINACION_LIBRO', 'Eliminación de un libro'),
(4, 'CAMBIO_ESTADO', 'Cambio del estado de lectura'),
(5, 'PUNTUACION', 'Asignación o modificación de puntuación'),
(6, 'EXPORTACION', 'Exportación de la biblioteca');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `nombre_usuario`, `email`, `password`) VALUES
(1, 'bruno', 'zampaloni', 'bruzzam', 'bruno7oct@gmail.com', '$2y$10$75P8jl0vCE3ycWOFJaHSser/QetGYaPXmdx4.8huLBUSFvs0hNNUC'),
(2, 'alex', 'adaro', 'alexuchu', 'alex@gmail.com', '$2y$10$Od2EEm47sFYWPwFBkP5I9Ovw4ZWr/trwkIY4voSI/bcGdFk.au2ey'),
(3, 'pablo', 'zamaploni', 'pablox', 'pablo@gmail.com', '$2y$10$aHLhKkO3FluLcPZgO1bYU.QRg1qGo4I0KyBeRwFmLOWKMxEyklOS.'),
(4, 'silvia', 'vico', 'silvia37', 'silvia@gmail.com', '$2y$10$fCTtivwCZHoKTrWgStqL/eBFbVE1NrTqxWCuPcuDpwgezdyqZw.46'),
(5, 'a', 'a', 'a', 'a@gmial.com', '$2y$10$cbwpEKsMAyXsESE7ikQ8YeaqFbnfNfQgMWQ78zKaKHH5dAsDIvn9W'),
(7, '1', '1', '1', '1@gmail.com', '$2y$10$dQyFHB1SngvOMgr/q5be/.Uvy76sIY6LSaEykyWX3RsQ19JQB.l6G');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `tipo_historial_id` (`tipo_historial_id`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `genero_id` (`genero_id`);

--
-- Indices de la tabla `tipo_historial`
--
ALTER TABLE `tipo_historial`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_historial`
--
ALTER TABLE `tipo_historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `fk_historial_tipo` FOREIGN KEY (`tipo_historial_id`) REFERENCES `tipo_historial` (`id`),
  ADD CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `libros_ibfk_2` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
