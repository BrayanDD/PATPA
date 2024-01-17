-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-01-2024 a las 19:53:50
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `patpa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `seccion_id` int(11) DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `imagen` varchar(150) DEFAULT NULL,
  `precio` int(7) DEFAULT NULL,
  `calificacion` int(100) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`id`, `nombre`, `categoria_id`, `seccion_id`, `descripcion`, `imagen`, `precio`, `calificacion`, `usuario_id`) VALUES
(21, 'prueba1', 1, 1, 'prueba', 'images/21.png', 363, NULL, 32),
(22, 'prueba2', 2, 2, 'prueba', 'images/22.png', 10000, NULL, 32),
(23, 'prueba3', 1, 3, 'prueba3', 'images/23.png', 10, NULL, 32),
(24, 'prueba4polloeditar', 1, 6, 'prueba4editado', 'images/24.png', 100000, NULL, 33),
(25, 'pruebahanmu', 1, 5, 'pruebahambur', 'images/25.png', 10000, NULL, 33),
(26, 'pruebahambur2', 1, 5, 'pruebahambur2', 'images/26.png', 5000, NULL, 33),
(29, 'pruba_si_sirve_img', 1, 5, 'pruba_si_sirve_img', 'images/29.png', 777, NULL, 33),
(31, 'prueba_editar_imagen', 1, 6, 'prueba_edudu', 'images/31.png', 12222, NULL, 33),
(32, 'prueba_immm', 1, 5, 'perrr', 'images/32.png', 777777, NULL, 33),
(33, 'final', 2, 6, 'elllll', 'images/33.png', 88888, NULL, 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion_empresa`
--

CREATE TABLE `calificacion_empresa` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificacion_empresa`
--

INSERT INTO `calificacion_empresa` (`id`, `id_usuario`, `calificacion`, `id_empresa`) VALUES
(1, 33, 4, 33),
(2, 33, 4, 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `articulo_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `categorias` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `categorias`) VALUES
(1, 'Comidas Rapidas'),
(2, 'Cenas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `comentario` varchar(250) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`id`, `id_usuario`, `comentario`, `id_empresa`) VALUES
(1, 33, 'rueba recacargar comentario', 33),
(9, 33, 'comentario otra empresa prueba', 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `estado` varchar(150) DEFAULT NULL,
  `total` int(20) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `estado`, `total`, `id_usuario`) VALUES
(2, 'pendiente', 200000, 33),
(8, 'pendiente', 300000, 33),
(9, 'pendiente', 39444, 33),
(11, 'pendiente', 30, 34),
(12, 'pendiente', 1452, 34),
(18, 'pendiente', 5000, 33),
(19, 'pendiente', 777, 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_pedido`
--

CREATE TABLE `productos_pedido` (
  `id` int(11) NOT NULL,
  `id_articulo` int(11) DEFAULT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_pedido`
--

INSERT INTO `productos_pedido` (`id`, `id_articulo`, `id_pedido`, `cantidad`) VALUES
(7, 24, 2, 2),
(12, 24, 8, 3),
(13, 31, 9, 2),
(14, 26, 9, 3),
(16, 21, 12, 4),
(22, 26, 18, 1),
(23, 29, 19, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol`) VALUES
(1, 'usuario'),
(2, 'repartidor'),
(3, 'empresa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `empresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`id`, `nombre`, `empresa_id`) VALUES
(1, 'prueba', 32),
(2, 'prueba2', 32),
(3, 'prueba3', 32),
(5, 'pruebahambur', 33),
(6, 'para eliminar', 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(300) NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `categorias` int(11) DEFAULT NULL,
  `id_rol` int(11) NOT NULL,
  `foto` varchar(250) DEFAULT NULL,
  `fondo` varchar(250) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `calificacion` varchar(5) DEFAULT NULL,
  `latitud` varchar(25) DEFAULT NULL,
  `longitud` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `correo`, `usuario`, `contraseña`, `edad`, `categorias`, `id_rol`, `foto`, `fondo`, `direccion`, `calificacion`, `latitud`, `longitud`) VALUES
(31, 'danifo', 'danirep@gmail', 'danicrak', 'ed02873f559ad72a05ab5c0338fcccc6e16d11e24f82867bd275ac59feeff9f09c0371a374f9752ed906906d1e34d929b0dd7cc63092cf32923a5422eaea748a', NULL, 1, 1, 'images/foto_pre.png', 'images/fondo_pre.png', 'calle 25', NULL, '', ''),
(32, 'adminbra', 'ad@ad', 'add', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', NULL, 2, 3, 'images/foto_pre.png', 'images/fondo_pre.png', 'calle 25', '4', '', ''),
(33, 'admin', 'admin@admin', 'administrador', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', NULL, 1, 3, 'images/foto33.png', 'images/fondo33.jpg', 'calle 25', '4', '0.5002935', '-76.4983897'),
(34, 'brayanddd', 'Qkkk@kk', 'braybobedit', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', NULL, NULL, 1, 'images/foto_pre.png', 'images/fondo_pre.png', 'calle16', NULL, '', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cagorias_id` (`categoria_id`),
  ADD KEY `seccion_id` (`seccion_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `calificacion_empresa`
--
ALTER TABLE `calificacion_empresa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foren_id_usuario` (`id_usuario`),
  ADD KEY `foren_id_empresa` (`id_empresa`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_articulo` (`articulo_id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foren_usuario` (`id_usuario`),
  ADD KEY `for_empresa` (`id_empresa`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos_pedido`
--
ALTER TABLE `productos_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `articulo_idd` (`id_articulo`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresa_id` (`empresa_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forenkey_id_rol` (`id_rol`),
  ADD KEY `forenkey_id_categorias` (`categorias`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `calificacion_empresa`
--
ALTER TABLE `calificacion_empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `productos_pedido`
--
ALTER TABLE `productos_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `cagorias_id` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `seccion_id` FOREIGN KEY (`seccion_id`) REFERENCES `seccion` (`id`),
  ADD CONSTRAINT `usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `calificacion_empresa`
--
ALTER TABLE `calificacion_empresa`
  ADD CONSTRAINT `foren_id_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `foren_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `id_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulo` (`id`);

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `for_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `foren_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `productos_pedido`
--
ALTER TABLE `productos_pedido`
  ADD CONSTRAINT `articulo_idd` FOREIGN KEY (`id_articulo`) REFERENCES `articulo` (`id`),
  ADD CONSTRAINT `id_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id`);

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD CONSTRAINT `empresa_id` FOREIGN KEY (`empresa_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `forenkey_id_categorias` FOREIGN KEY (`categorias`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `forenkey_id_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
