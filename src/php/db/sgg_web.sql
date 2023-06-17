-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2023 at 08:06 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgg_web`
--
CREATE DATABASE IF NOT EXISTS `sgg_web` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sgg_web`;

-- --------------------------------------------------------

--
-- Table structure for table `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(10) NOT NULL,
  `fecha_emision` date NOT NULL,
  `mesa` varchar(4) DEFAULT NULL,
  `importe` decimal(12,2) NOT NULL,
  `id_usuario` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `factura`
--
/*
INSERT INTO `factura` (`id_factura`, `fecha_emision`, `mesa`, `importe`, `id_usuario`) VALUES
(6, '2022-11-26', 'D3', '5820.00', 19),
(10, '2023-06-18', 'S1', '7420.00', 12),
(11, '2023-06-16', 'S3', '5200.00', 13),
(12, '2023-06-16', 'S3', '14513.00', 12);
*/
-- --------------------------------------------------------

--
-- Table structure for table `ingrediente`
--

CREATE TABLE `ingrediente` (
  `id_ingrediente` int(4) NOT NULL,
  `nombre_ingrediente` varchar(40) NOT NULL,
  `stock` int(4) DEFAULT NULL,
  `unidad_medida` varchar(3) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `ingrediente`
--
/*
INSERT INTO `ingrediente` (`id_ingrediente`, `nombre_ingrediente`, `stock`, `unidad_medida`, `baja`) VALUES
(1, 'carne', 600, 'gr', 0),
(2, 'lechuga', 1400, 'gr', 0),
(3, 'pan', 500, 'gr', 0),
(4, 'masa', 3000, 'gr', 0),
(5, 'cebolla', 2750, 'gr', 0),
(6, 'fernet', 6, 'lt', 0),
(7, 'coca', 10, 'lt', 0),
(8, 'jugo de naranja', 5, 'lt', 0),
(9, 'campari', 8, 'lt', 0),
(15, 'pan brioche', 200, 'u', 0),
(16, 'manteca', 200, 'gr', 0),
(17, 'hielo entero', 200, 'gr', 0),
(18, 'aperol', 200, 'lt', 0),
(19, 'vino espumante', 200, 'lt', 0);
*/
-- --------------------------------------------------------

--
-- Table structure for table `ingrediente_x_pedido`
--

CREATE TABLE `ingrediente_x_pedido` (
  `cantidad` int(3) NOT NULL,
  `id_ingrediente` int(4) DEFAULT NULL,
  `id_pedido` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingrediente_x_producto`
--

CREATE TABLE `ingrediente_x_producto` (
  `cantidad` decimal(6,2) NOT NULL,
  `id_ingrediente` int(4) DEFAULT NULL,
  `id_producto` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `ingrediente_x_producto`
--
/*
INSERT INTO `ingrediente_x_producto` (`cantidad`, `id_ingrediente`, `id_producto`) VALUES
('200.00', 1, 1),
('360.00', 4, 2),
('40.00', 2, 1),
('240.00', 3, 1),
('300.00', 5, 2),
('0.06', 6, 3),
('0.24', 7, 3),
('0.24', 8, 4),
('0.06', 9, 4),
('0.35', 7, 5),
('1.50', 7, 12),
('100.00', 5, 16),
('400.00', 1, 16),
('1.00', 15, 16),
('30.00', 16, 16),
('0.02', 8, 17),
('50.00', 17, 17),
('0.06', 18, 17),
('0.22', 19, 17);
*/
-- --------------------------------------------------------

--
-- Table structure for table `item_factura`
--

CREATE TABLE `item_factura` (
  `cantidad` int(3) NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `id_producto` int(4) DEFAULT NULL,
  `id_factura` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `item_factura`
--
/*
INSERT INTO `item_factura` (`cantidad`, `precio`, `id_producto`, `id_factura`) VALUES
(1, '1020.00', 12, 6),
(2, '4800.00', 16, 6),
(1, '1020.00', 12, 10),
(2, '6400.00', 1, 10),
(4, '5200.00', 3, 11),
(3, '7971.00', 2, 12),
(6, '3942.00', 5, 12),
(2, '2600.00', 3, 12);
*/
-- --------------------------------------------------------

--
-- Table structure for table `pedido_proveedor`
--

CREATE TABLE `pedido_proveedor` (
  `id_pedido` int(6) NOT NULL,
  `fecha_pedido` date NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(3) DEFAULT NULL,
  `id_proveedor` int(3) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(4) NOT NULL,
  `nombre_producto` varchar(40) NOT NULL,
  `tipo` varchar(6) NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `stock` int(4) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `producto`
--
/*
INSERT INTO `producto` (`id_producto`, `nombre_producto`, `tipo`, `precio`, `stock`, `baja`) VALUES
(1, 'Ambruhgesau Con Chugale', 'comida', '3200.00', NULL, 0),
(2, 'Fugazzex', 'comida', '2657.00', NULL, 0),
(3, 'Fernardinho', 'bebida', '1300.00', NULL, 0),
(4, 'Garibaldi', 'bebida', '1100.00', NULL, 0),
(5, 'Tala De Caco', 'bebida', '657.00', NULL, 0),
(12, 'Coca 1.5 Lt', 'bebida', '1020.00', 0, 0),
(16, 'Oklahoma Burger', 'comida', '2400.00', NULL, 0),
(17, 'Aperol Spritz', 'bebida', '1400.00', NULL, 0);
*/
-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(3) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(3) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `dni` int(8) NOT NULL,
  `rol` tinyint(1) NOT NULL,
  `nombre_usuario` varchar(15) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `baja` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `usuario`
--
/*
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `dni`, `rol`, `nombre_usuario`, `contrasena`, `baja`) VALUES
(1, 'Franco', 'Armani', 37865891, 1, 'FArmaniX', 'riverpasion', 1),
(2, 'Rogelio', 'Funes Mori', 38912551, 2, 'RFunesMori', 'riverelmasgrande', 1),
(3, 'Lucas', 'Beltran', 40105829, 3, 'LBeltran', 'cologallina', 1),
(4, 'Marcelo', 'Gallardo', 10100100, 1, 'mgallardo', 'quepedazodemuñeco', 0),
(5, 'Enzo', 'Perez', 12345678, 0, 'eperez', '674f3c2c1a8a6f90461e8a66fb5550ba', 0),
(6, 'Pablo', 'Almodovar', 14096861, 2, 'palmodovar', 'a957aa96221d0b7cb99ab072eaed7bf9', 1),
(8, 'jose martin', 'campanella', 25978432, 3, 'jcampanella', '117ffc1acd844e431a4b73f0867adae5', 1),
(10, 'martin', 'demichelis', 13246587, 0, 'mdemichelis', '2e2c4bf7ceaa4712a72dd5ee136dc9a8', 0),
(11, 'milton', 'casco', 34086581, 1, 'mcasco', '7aee5d5dfa97b2516e5f639672c7e199', 0),
(12, 'marcelo', 'barovero', 32194532, 2, 'mbarovero', '1d38dd921e15520709f86320185c5e1d', 0),
(13, 'lucas', 'alario', 42654910, 2, 'lalario', '43975bc2dfc84641a2a8c4d3fe653176', 0),
(14, 'jonatan', 'maidana', 12345679, 2, 'jmaidana', '166cee72e93a992007a89b39eb29628b', 0),
(15, 'Ezequiel', 'Palacios', 13456789, 1, 'epalacios', '46d045ff5190f6ea93739da6c0aa19bc', 0),
(16, 'tabare', 'viudez', 31465876, 1, 'tviudez', 'fdc0eb412a84fa549afe68373d9087e9', 0),
(17, 'manuel', 'lanzini', 12346666, 3, 'mlanzini', 'e9510081ac30ffa83f10b68cde1cac07', 0),
(18, 'lucas', 'pratto', 45000111, 2, 'lpratto', '7d7c45b9a935cf9d845fc75679a41559', 0),
(19, 'Sebastián', 'Driussi', 11222333, 2, 'sdriussi', 'f7e0b956540676a129760a3eae309294', 0),
(20, 'javier', 'pinola', 11222333, 0, 'jpinola', 'f7e0b956540676a129760a3eae309294', 0),
(21, 'pepe', 'argento', 11122233, 0, 'pargento', 'e0f7a4d0ef9b84b83b693bbf3feb8e6e', 1),
(22, 'esequiel', 'barco', 22111333, 0, 'ebarco', 'ff49cc40a8890e6a60f40ff3026d2730', 0),
(23, 'ramon', 'diaz', 99888222, 3, 'rdiaz', '532923f11ac97d3e7cb0130315b067dc', 0),
(24, 'pedo', 'feo', 11222999, 2, 'pfeo', 'a36e841c5230a79c2102036d2e259848', 1);
*/
--
-- Indexes for dumped tables
--

--
-- Indexes for table `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `factura_usuario_fk` (`id_usuario`);

--
-- Indexes for table `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`id_ingrediente`);

--
-- Indexes for table `ingrediente_x_pedido`
--
ALTER TABLE `ingrediente_x_pedido`
  ADD KEY `ingrediente_x_pedido_ingrediente_fk` (`id_ingrediente`),
  ADD KEY `ingrediente_x_pedido_pedido_proveedor_fk` (`id_pedido`);

--
-- Indexes for table `ingrediente_x_producto`
--
ALTER TABLE `ingrediente_x_producto`
  ADD KEY `ingrediente_x_producto_ingrediente_fk` (`id_ingrediente`),
  ADD KEY `ingrediente_x_producto_producto_fk` (`id_producto`);

--
-- Indexes for table `item_factura`
--
ALTER TABLE `item_factura`
  ADD KEY `item_factura_producto_fk` (`id_producto`),
  ADD KEY `item_factura_factura_fk` (`id_factura`);

--
-- Indexes for table `pedido_proveedor`
--
ALTER TABLE `pedido_proveedor`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `pedido_proveedor_usuario_fk` (`id_usuario`),
  ADD KEY `pedido_proveedor_proveedor_fk` (`id_proveedor`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indexes for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `id_ingrediente` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pedido_proveedor`
--
ALTER TABLE `pedido_proveedor`
  MODIFY `id_pedido` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_usuario_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `ingrediente_x_pedido`
--
ALTER TABLE `ingrediente_x_pedido`
  ADD CONSTRAINT `ingrediente_x_pedido_ingrediente_fk` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`),
  ADD CONSTRAINT `ingrediente_x_pedido_pedido_proveedor_fk` FOREIGN KEY (`id_pedido`) REFERENCES `pedido_proveedor` (`id_pedido`);

--
-- Constraints for table `ingrediente_x_producto`
--
ALTER TABLE `ingrediente_x_producto`
  ADD CONSTRAINT `ingrediente_x_producto_ingrediente_fk` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`),
  ADD CONSTRAINT `ingrediente_x_producto_producto_fk` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Constraints for table `item_factura`
--
ALTER TABLE `item_factura`
  ADD CONSTRAINT `item_factura_factura_fk` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`),
  ADD CONSTRAINT `item_factura_producto_fk` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Constraints for table `pedido_proveedor`
--
ALTER TABLE `pedido_proveedor`
  ADD CONSTRAINT `pedido_proveedor_proveedor_fk` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`),
  ADD CONSTRAINT `pedido_proveedor_usuario_fk` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
