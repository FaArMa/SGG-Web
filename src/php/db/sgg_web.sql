-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2023 a las 02:05:10
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sgg_web`
--
CREATE DATABASE IF NOT EXISTS `sgg_web` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE `sgg_web`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` tinyint(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `dni` mediumint(8) NOT NULL,
  `rol` tinyint(1) NOT NULL,
  `nombre_usuario` varchar(15) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fecha_emision` date NOT NULL,
  `mesa` varchar(4),
  `importe` decimal(12,2) NOT NULL,
  `id_usuario` tinyint(3),
  CONSTRAINT `factura_usuario_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `id_ingrediente` smallint(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre_ingrediente` varchar(40) NOT NULL,
  `stock` smallint(4),
  `unidad_medida` varchar(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` smallint(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre_producto` varchar(40) NOT NULL,
  `tipo` varchar(6) NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `stock` smallint(4)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente_x_producto`
--

CREATE TABLE `ingrediente_x_producto` (
  `cantidad` int(3) NOT NULL,
  `id_ingrediente` smallint(4),
  `id_producto` smallint(4),
  CONSTRAINT `ingrediente_x_producto_ingrediente_fk` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`),
  CONSTRAINT `ingrediente_x_producto_producto_fk` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` tinyint(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `descripcion` varchar(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_proveedor`
--

CREATE TABLE `pedido_proveedor` (
  `id_pedido` mediumint(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fecha_pedido` date NOT NULL DEFAULT current_timestamp(),
  `id_usuario` tinyint(3),
  `id_proveedor` tinyint(3),
   CONSTRAINT `pedido_proveedor_usuario_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
   CONSTRAINT `pedido_proveedor_proveedor_fk` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente_x_pedido`
--

CREATE TABLE `ingrediente_x_pedido` (
  `cantidad` decimal(6,2) NOT NULL,
  `id_ingrediente` smallint(4),
  `id_pedido` mediumint(6),
  CONSTRAINT `ingrediente_x_pedido_ingrediente_fk` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`),
  CONSTRAINT `ingrediente_x_pedido_pedido_proveedor_fk` FOREIGN KEY (`id_pedido`) REFERENCES `pedido_proveedor` (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item_factura`
--

CREATE TABLE `item_factura` (
  `cantidad` int(3) NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `id_producto` smallint(4),
  `id_factura` int(10),
  CONSTRAINT `item_factura_producto_fk` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `item_factura_factura_fk` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;


COMMIT;

/*
----
---- Índices para tablas volcadas
----

----
---- Indices de la tabla `comanda`
----
--ALTER TABLE `comanda`
--  ADD PRIMARY KEY (`id_comanda`),
--  ADD KEY `id_usuario` (`id_usuario`);

----
---- Indices de la tabla `factura`
----
--ALTER TABLE `factura`
--  ADD PRIMARY KEY (`id_factura`);

----
---- Indices de la tabla `ingrediente`
----
--ALTER TABLE `ingrediente`
--  ADD PRIMARY KEY (`id_ingrediente`),
--  ADD KEY `id_usuario` (`id_usuario`);

----
---- Indices de la tabla `ingrediente_x_pedido`
----
--ALTER TABLE `ingrediente_x_pedido`
--  ADD PRIMARY KEY (`id_ingrediente`,`id_pedido`);

----
---- Indices de la tabla `ingrediente_x_producto`
----
--ALTER TABLE `ingrediente_x_producto`
--  ADD PRIMARY KEY (`id_producto`,`id_ingrediente`);

----
---- Indices de la tabla `pedido`
----
--ALTER TABLE `pedido`
--  ADD PRIMARY KEY (`id_pedido`),
--  ADD KEY `id_usuario` (`id_usuario`);

----
---- Indices de la tabla `producto`
----
--ALTER TABLE `producto`
--  ADD PRIMARY KEY (`id_producto`),
--  ADD KEY `id_usuario` (`id_usuario`);

----
---- Indices de la tabla `producto_x_comanda`
----
--ALTER TABLE `producto_x_comanda`
--  ADD PRIMARY KEY (`id_producto`,`id_comanda`);

----
---- Indices de la tabla `producto_x_pedido`
----
--ALTER TABLE `producto_x_pedido`
--  ADD PRIMARY KEY (`id_producto`,`id_pedido`);

----
---- Indices de la tabla `usuario`
----
--ALTER TABLE `usuario`
--  ADD PRIMARY KEY (`id_usuario`);

----
---- AUTO_INCREMENT de las tablas volcadas
----

----
---- AUTO_INCREMENT de la tabla `comanda`
----
--ALTER TABLE `comanda`
--  MODIFY `id_comanda` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

----
---- AUTO_INCREMENT de la tabla `factura`
----
--ALTER TABLE `factura`
--  MODIFY `id_factura` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

----
---- AUTO_INCREMENT de la tabla `ingrediente`
----
--ALTER TABLE `ingrediente`
--  MODIFY `id_ingrediente` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT;

----
---- AUTO_INCREMENT de la tabla `pedido`
----
--ALTER TABLE `pedido`
--  MODIFY `id_pedido` mediumint(6) UNSIGNED NOT NULL AUTO_INCREMENT;

----
---- AUTO_INCREMENT de la tabla `producto`
----
--ALTER TABLE `producto`
--  MODIFY `id_producto` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT;

----
---- AUTO_INCREMENT de la tabla `usuario`
----
--ALTER TABLE `usuario`
--  MODIFY `id_usuario` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

----
---- Restricciones para tablas volcadas
----

----
---- Filtros para la tabla `comanda`
----
--ALTER TABLE `comanda`
--  ADD CONSTRAINT `comanda_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

----
---- Filtros para la tabla `ingrediente`
----
--ALTER TABLE `ingrediente`
--  ADD CONSTRAINT `ingrediente_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

----
---- Filtros para la tabla `pedido`
----
--ALTER TABLE `pedido`
--  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

----
---- Filtros para la tabla `producto`
----
--ALTER TABLE `producto`
--  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
*/

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
