-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2023 at 10:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
(1, '2023-06-01', 'D3', 5820.00, 13),
(2, '2023-06-18', 'S1', 7420.00, 10),
(3, '2023-06-16', 'S3', 5200.00, 11),
(4, '2023-06-16', 'S3', 14513.00, 10),
(5, '2023-06-22', 'D4', 3800.00, 2),
(6, '2023-06-23', 'S2', 4500.00, 3),
(7, '2023-06-23', 'D2', 2800.00, 4),
(8, '2023-06-23', 'S4', 5200.00, 1),
(9, '2023-06-24', 'D1', 6200.00, 3),
(10, '2023-06-24', 'S1', 4200.00, 2),
(11, '2023-06-24', 'S3', 3100.00, 4),
(12, '2023-06-24', 'D3', 4800.00, 1);
*/
-- --------------------------------------------------------

--
-- Table structure for table `ingrediente`
--

CREATE TABLE `ingrediente` (
  `id_ingrediente` int(4) NOT NULL,
  `nombre_ingrediente` varchar(40) NOT NULL,
  `stock` int(4) DEFAULT NULL CHECK (`stock` >= 0),
  `unidad_medida` varchar(3) DEFAULT NULL,
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `ingrediente`
--
/*
INSERT INTO `ingrediente` (`id_ingrediente`, `nombre_ingrediente`, `stock`, `unidad_medida`, `baja`) VALUES
(1, 'carne', 6000, 'gr', 0),
(2, 'lechuga', 14000, 'gr', 0),
(3, 'pan', 5000, 'gr', 0),
(4, 'masa', 30000, 'gr', 0),
(5, 'cebolla', 27500, 'gr', 0),
(6, 'fernet', 1600, 'lt', 0),
(7, 'coca', 10000, 'lt', 0),
(8, 'jugo de naranja', 1500, 'lt', 0),
(9, 'campari', 1800, 'lt', 0),
(10, 'pan brioche', 2000, 'u', 0),
(11, 'manteca', 2000, 'gr', 0),
(12, 'hielo entero', 2000, 'gr', 0),
(13, 'aperol', 2000, 'lt', 0),
(14, 'vino espumante', 2000, 'lt', 0),
(15, 'tomate', 8000, 'gr', 0),
(16, 'queso cheddar', 5000, 'gr', 0),
(17, 'hamburguesa de pollo', 3000, 'u', 0),
(18, 'cebolla morada', 5000, 'gr', 0),
(19, 'mayonesa', 2000, 'gr', 0),
(20, 'azúcar', 1200, 'gr', 0),
(21, 'limón', 3000, 'u', 0),
(22, 'agua con gas', 1200, 'ml', 0),
(23, 'albahaca', 1000, 'gr', 0),
(24, 'queso mozzarella', 1900, 'gr', 0),
(25, 'salsa de tomate', 1000, 'gr', 0),
(26, 'jamon', 1500, 'gr', 0),
(27, 'queso', 1500, 'gr', 0),
(28, 'pan de miga', 3000, 'gr', 0),
(29, 'vino tinto', 1000, 'u', 0),
(30, 'jugo de lima', 1300, 'ml', 0),
(31, 'ron cubano', 1600, 'ml', 0),
(32, 'ginebra', 1500, 'ml', 0),
(33, 'cerveza', 4500, 'ml', 0),
(34, 'cafe', 1200, 'ml', 0);
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
(200.00, 1, 1),
(360.00, 4, 2),
(40.00, 2, 1),
(240.00, 3, 1),
(300.00, 5, 2),
(0.06, 6, 3),
(0.24, 7, 3),
(0.24, 8, 4),
(0.06, 9, 4),
(0.35, 7, 5),
(1.50, 7, 6),
(100.00, 5, 7),
(400.00, 1, 7),
(1.00, 10, 7),
(30.00, 11, 7),
(0.02, 8, 8),
(50.00, 12, 8),
(0.06, 13, 8),
(0.22, 14, 8),
(150.00, 15, 1),
(80.00, 16, 1),
(1.00, 17, 1),
(40.00, 18, 1),
(30.00, 19, 1),
(500.00, 20, 3),
(2.00, 21, 3),
(500.00, 20, 4),
(2.00, 21, 4),
(500.00, 20, 5),
(2.00, 21, 5),
(500.00, 20, 6),
(2.00, 21, 6),
(200.00, 19, 7),
(400.00, 18, 7),
(100.00, 15, 7),
(200.00, 15, 8),
(100.00, 16, 8),
(10.00, 23, 9),
(3000.00, 4, 9),
(90.00, 24, 9),
(100.00, 25, 9),
(150.00, 26, 10),
(150.00, 27, 10),
(300.00, 28, 10),
(1.00, 29, 11),
(30.00, 30, 12),
(60.00, 31, 12),
(200.00, 12, 12),
(20.00, 20, 12),
(120.00, 22, 12),
(50.00, 32, 13),
(120.00, 22, 13),
(300.00, 21, 13),
(200.00, 12, 13),
(200.00, 34, 14),
(450.00, 33, 15);
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
(1, 1020.00, 6, 1),
(2, 4800.00, 7, 1),
(1, 1020.00, 6, 2),
(2, 6400.00, 1, 2),
(4, 5200.00, 3, 3),
(3, 7971.00, 2, 4),
(6, 3942.00, 5, 4),
(2, 2600.00, 3, 4),
(2, 1600.00, 1, 5),
(1, 890.00, 2, 5),
(3, 3300.00, 3, 5),
(4, 1100.00, 4, 6),
(2, 850.00, 5, 6),
(1, 1600.00, 6, 6),
(3, 740.00, 7, 7),
(1, 1290.00, 8, 7),
(2, 1700.00, 1, 8),
(1, 940.00, 2, 8),
(2, 1400.00, 3, 9),
(1, 1150.00, 4, 9),
(4, 380.00, 5, 9),
(3, 2400.00, 6, 10),
(1, 800.00, 7, 10),
(2, 1350.00, 8, 10);
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
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `pedido_proveedor`
--
/*
INSERT INTO `pedido_proveedor` (`id_pedido`, `fecha_pedido`, `id_usuario`, `id_proveedor`, `baja`) VALUES
(1, '2023-06-01', 3, 1, 1),
(2, '2023-06-06', 6, 2, 1),
(3, '2023-06-10', 4, 3, 0),
(4, '2023-06-12', 5, 4, 0),
(5, '2023-06-14', 3, 5, 0),
(6, '2023-06-17', 4, 6, 1),
(7, '2023-06-19', 5, 7, 0),
(8, '2023-06-21', 6, 8, 0),
(9, '2023-06-23', 6, 1, 0),
(10, '2023-06-24', 7, 2, 0),
(11, '2023-06-24', 5, 3, 0),
(12, '2023-06-24', 3, 4, 0),
(13, '2023-06-24', 4, 5, 0),
(14, '2023-06-24', 6, 6, 0),
(15, '2023-06-24', 7, 7, 0),
(16, '2023-06-24', 5, 8, 0);
*/
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
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `producto`
--
/*
INSERT INTO `producto` (`id_producto`, `nombre_producto`, `tipo`, `precio`, `stock`, `baja`) VALUES
(1, 'Hamburguesa de Lechuga', 'comida', 3200.00, NULL, 0),
(2, 'Fugazzetta', 'comida', 2657.00, NULL, 0),
(3, 'Fernet con Coca', 'bebida', 1300.00, NULL, 0),
(4, 'Garibaldi', 'bebida', 1100.00, NULL, 0),
(5, 'Coca de Lata', 'bebida', 657.00, NULL, 0),
(6, 'Coca 1.5 Lt', 'bebida', 1020.00, NULL, 0),
(7, 'Oklahoma Burger', 'comida', 2400.00, NULL, 0),
(8, 'Aperol Spritz', 'bebida', 1400.00, NULL, 0),
(9, 'Pizza Margarita', 'comida', 3200.00, NULL, 0),
(10, 'Sándwich de Jamón y Queso', 'comida', 1120.00, NULL, 0),
(11, 'Vino Tinto Reserva', 'bebida', 1900.00, NULL, 0),
(12, 'Mojito', 'bebida', 960.00, NULL, 0),
(13, 'Gin Tonic', 'bebida', 1100.00, NULL, 0),
(14, 'Café Expresso', 'bebida', 1400.00, NULL, 0),
(15, 'Cerveza Artesanal', 'bebida', 1750.00, NULL, 0);
*/
-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(3) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `descripcion` varchar(60) DEFAULT NULL,
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `proveedor`
--
/*
INSERT INTO `proveedor` (`id_proveedor`, `nombre`, `mail`, `descripcion`, `baja`) VALUES
(1, 'Distribuidora La Vega', 'info@lavega.com', 'Proveedor de frutas y verduras frescas.', 0),
(2, 'Carnicería San José', 'ventas@carniceriasanjose.com', 'Especialistas en carnes de alta calidad.', 0),
(3, 'Distribuciones Marítimas', 'info@distribucionesmaritimas.com', 'Proveedor de pescados y mariscos frescos.', 0),
(4, 'Quesos Artesanos', 'ventas@quesosartesanos.com', 'Amplia variedad de quesos artesanales.', 0),
(5, 'Panadería La Delicia', 'contacto@panaderialadelicia.com', 'Elaboración propia de panes y productos de reposte', 0),
(6, 'Bebidas del Mundo', 'info@bebidasdelmundo.com', 'Proveedor de bebidas alcohólicas y no alcohólicas.', 0),
(7, 'Distribuidora de Vinos Finos', 'ventas@vinosfinos.com', 'Amplia selección de vinos nacionales e importados.', 0),
(8, 'Dulces y Golosinas S.A.', 'info@dulcesygolosinas.com', 'Proveedor de dulces y golosinas de todo tipo.', 0),
(9, 'Distribuidora de Frutos Secos', 'info@frutossecos.com', 'Proveedores de una amplia variedad de frutos secos.', 0),
(10, 'Distribuciones Lácteas', 'ventas@distribucioneslacteas.com', 'Proveedor de productos lácteos frescos.', 0),
(11, 'Distribuidora de Bebidas Gaseosas', 'info@distribuidorabebidasgaseosas.com', 'Proveedor de bebidas gaseosas de distintas marcas.', 0),
(12, 'Distribuidora de Helados', 'ventas@distribuidorahelados.com', 'Proveedor de helados artesanales y de marca.', 0),
(13, 'Distribuidora de Frutas Exóticas', 'info@frutasexoticas.com', 'Proveedores de frutas exóticas de alta calidad.', 0),
(14, 'Cafetería y Té', 'ventas@cafeteriayte.com', 'Proveedor de café y té de diversas variedades.', 0),
(15, 'Distribuidora de Condimentos', 'info@condimentos.com', 'Proveedor de condimentos y especias para cocina.', 0),
(16, 'Distribuidora de Bebidas Energéticas', 'ventas@bebidasenergeticas.com', 'Proveedor de bebidas energéticas de distintas marcas.', 0);
*/
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
  `nombre_usuario` varchar(31) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `usuario`
--
/*
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `dni`, `rol`, `nombre_usuario`, `contrasena`, `baja`) VALUES
(1, 'María', 'López', 28345967, 0, 'mlopez', '$argon2id$v=19$m=65536,t=4,p=1$bElXUzhpRDFXeC50VWZJRg$DBUwc+v/9YwTDbiZ5cgURevTpIyLcMy2xGC9QvQT73Q', 0),
(2, 'Juan', 'Martínez', 76592341, 0, 'jmartinez', '$argon2id$v=19$m=65536,t=4,p=1$TFphUWtUd2QwVTZGd2s4dg$QKFMyI9VhCW8Ef0DJhBDfAAfxe2or2N17mTK6/vooGw', 0),
(3, 'Ana', 'García', 43871235, 1, 'agarcia', '$argon2id$v=19$m=65536,t=4,p=1$SkEwQS8yak11VUtFZDVXTw$m/CS46hdcFnX8spH835vv4DVHmx5Mm7TDm0UPbxCrxs', 0),
(4, 'Luis', 'Rodríguez', 62987453, 1, 'lrodriguez', '$argon2id$v=19$m=65536,t=4,p=1$SUFzRWN3bXdTckQ4ZlFLSQ$hTqsLlMx/x/pOJi2BILYx6PHIP2Hno4tdaD4lQGdYIw', 1),
(5, 'Laura', 'Fernández', 18453627, 1, 'lfernandez', '$argon2id$v=19$m=65536,t=4,p=1$T0VzZW0zUVJJYlc5clV5dw$gmr5D92FlYYJiFoHWkPLcbHdMtN0kLRA+dUIkY4gOy8', 0),
(6, 'Andrés', 'Sánchez', 37198245, 1, 'asanchez', '$argon2id$v=19$m=65536,t=4,p=1$SG9Yd1VlZmgyN0Rjc3F4aA$qXGGBcBG7VzTXLc6XFPlOhhB1v8NJDSuycvUgCgfog0', 0),
(7, 'Carolina', 'González', 89674532, 2, 'cgonzalez', '$argon2id$v=19$m=65536,t=4,p=1$SkZlR3prQURWeDVzckFyQg$A4sVXnGKdiCKgvbmwYtTK+9evzlAukftfpS1KunZQyM', 0),
(8, 'Pedro', 'Ramírez', 51973468, 2, 'pramirez', '$argon2id$v=19$m=65536,t=4,p=1$TnQudjNSZTk1M2pzcC5rbg$3VVhKo8r4KwKATs1ie7lSQF0DYL2bFhE9a8o6qe6Pzw', 0),
(9, 'Sofía', 'Torres', 28764513, 2, 'storres', '$argon2id$v=19$m=65536,t=4,p=1$L2p0S2Rvb2lsdWlzRDFWWQ$EFzu+vYFmi5+/rdcbKxK0sLbIOIL5xiUK42b8ZxFqWI', 0),
(10, 'Gabriel', 'Herrera', 65347821, 2, 'gherrera', '$argon2id$v=19$m=65536,t=4,p=1$a3lpcEZCNGFVTzNkU2M0Mg$ck0lv2TMvyxuR065/I9YSmJpVzQEPmIaSnh2PxPY1tM', 0),
(11, 'Valentina', 'Castro', 14256983, 2, 'vcastro', '$argon2id$v=19$m=65536,t=4,p=1$RjNFWUNaekE2bk5JcTZFeA$+imhJRdG7m9eziiavtTQEYNhvmk52qOzXBAyesfLQes', 0),
(12, 'Alejandro', 'Jiménez', 72519384, 2, 'ajimenez', '$argon2id$v=19$m=65536,t=4,p=1$NmxyOXdRYVRsMlFYNlZ1dg$1B+eGz6Z8sEOmodK8fTYpvfaDIlrn3E4GNhAmLQodO0', 0),
(13, 'Camila', 'Ríos', 38465792, 2, 'crios', '$argon2id$v=19$m=65536,t=4,p=1$WmpITVVqa2tzUGt5UXdVRQ$lhM+BIekcxRuuvDGjqxDYSibEqPVftmZIG2hFdpXaOE', 1),
(14, 'Martín', 'Silva', 91625478, 2, 'msilva', '$argon2id$v=19$m=65536,t=4,p=1$RFY4cVlwM0VkVEN4Vk9TVQ$NLVJnmDdzBQKYqqJ0HID715PHFIP1KRMX4mwxTshziY', 1),
(15, 'Victoria', 'Ortiz', 58234697, 3, 'vortiz', '$argon2id$v=19$m=65536,t=4,p=1$VkNoMGFsdWF3RGVaVnZNQw$zJSE/ipMznJ7XQ5EysNmQlDnUvR09jojB9SoExBpu98', 1),
(16, 'Manuel', 'Paredes', 49762183, 3, 'mparedes', '$argon2id$v=19$m=65536,t=4,p=1$aC9OWWljaUZnV25IN25JUg$r+ihqxvzzggSH5OpwDl+897Hs0Gkm36yVyrJ4pI0hv4', 0);
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
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `nombre_producto` (`nombre_producto`);

--
-- Indexes for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `id_ingrediente` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedido_proveedor`
--
ALTER TABLE `pedido_proveedor`
  MODIFY `id_pedido` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(3) NOT NULL AUTO_INCREMENT;

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
