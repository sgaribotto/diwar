-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 02, 2018 at 12:13 AM
-- Server version: 10.2.13-MariaDB
-- PHP Version: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id5714927_diwar`
--
CREATE DATABASE IF NOT EXISTS `id5714927_diwar` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `id5714927_diwar`;

-- --------------------------------------------------------

--
-- Table structure for table `articulos`
--

CREATE TABLE `articulos` (
  `id` int(11) NOT NULL,
  `codigo_articulo` varchar(255) DEFAULT NULL,
  `modelo_con_mecanismo` int(11) NOT NULL,
  `variaciones` int(11) NOT NULL,
  `en_uso` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `articulos`
--

INSERT INTO `articulos` (`id`, `codigo_articulo`, `modelo_con_mecanismo`, `variaciones`, `en_uso`) VALUES
(25, '1', 1, 5, 1),
(26, '1', 1, 6, 1),
(27, '1', 1, 7, 1),
(28, '1', 1, 8, 1),
(29, '1', 1, 9, 1),
(30, '1', 1, 10, 1),
(31, '1', 1, 11, 1),
(32, '1', 1, 12, 1),
(33, '1', 1, 13, 1),
(34, '1', 1, 14, 1),
(35, '1', 1, 15, 1),
(36, '1', 1, 16, 1),
(37, '1', 1, 17, 1),
(38, '1', 1, 18, 1),
(39, '1', 1, 19, 1),
(40, '1', 1, 20, 1),
(41, '1', 1, 21, 1),
(42, '1', 1, 22, 1),
(43, '1', 1, 23, 1),
(44, '1', 1, 24, 1),
(45, '2', 2, 5, 1),
(46, '2', 2, 6, 1),
(47, '2', 2, 7, 1),
(48, '2', 2, 8, 1),
(49, '2', 2, 9, 1),
(50, '2', 2, 10, 1),
(51, '2', 2, 11, 1),
(52, '2', 2, 12, 1),
(53, '2', 2, 13, 1),
(54, '2', 2, 14, 1),
(55, '2', 2, 15, 1),
(56, '2', 2, 16, 1),
(57, '2', 2, 17, 1),
(58, '2', 2, 18, 1),
(59, '2', 2, 19, 1),
(60, '2', 2, 20, 1),
(61, '2', 2, 21, 1),
(62, '2', 2, 22, 1),
(63, '2', 2, 23, 1),
(64, '2', 2, 24, 1),
(65, '3', 3, 22, 1),
(66, '3', 3, 23, 1),
(67, '3', 3, 24, 1),
(68, '4', 4, 22, 1),
(69, '4', 4, 23, 1),
(70, '4', 4, 24, 1),
(71, '5', 5, 5, 1),
(72, '5', 5, 6, 1),
(73, '5', 5, 7, 1),
(74, '5', 5, 8, 1),
(75, '5', 5, 9, 1),
(76, '5', 5, 10, 1),
(77, '5', 5, 11, 1),
(78, '5', 5, 12, 1),
(79, '5', 5, 13, 1),
(80, '5', 5, 14, 1),
(81, '5', 5, 15, 1),
(82, '5', 5, 16, 1),
(83, '5', 5, 17, 1),
(84, '5', 5, 18, 1),
(85, '5', 5, 19, 1),
(86, '5', 5, 20, 1),
(87, '5', 5, 21, 1),
(88, '5', 5, 22, 1),
(89, '5', 5, 23, 1),
(90, '5', 5, 24, 1),
(91, '6', 6, 5, 0),
(92, '6', 6, 6, 0),
(93, '6', 6, 7, 1),
(94, '6', 6, 8, 1),
(95, '6', 6, 9, 1),
(96, '6', 6, 10, 1),
(97, '6', 6, 11, 1),
(98, '6', 6, 12, 1),
(99, '6', 6, 13, 1),
(100, '6', 6, 14, 1),
(101, '6', 6, 15, 1),
(102, '6', 6, 16, 0),
(103, '6', 6, 17, 1),
(104, '6', 6, 18, 0),
(105, '6', 6, 19, 1),
(106, '6', 6, 20, 1),
(107, '6', 6, 21, 1),
(108, '6', 6, 22, 1),
(109, '6', 6, 23, 0),
(110, '6', 6, 24, 1),
(111, '7', 7, 22, 1),
(112, '7', 7, 23, 1),
(113, '7', 7, 24, 1),
(114, '8', 8, 22, 1),
(115, '8', 8, 23, 1),
(116, '8', 8, 24, 1),
(117, '', 4, 8, 1),
(118, '', 4, 9, 1),
(119, '', 4, 10, 1),
(120, '', 4, 11, 1),
(121, NULL, 68, 13, 1),
(122, NULL, 68, 8, 1),
(123, NULL, 68, 9, 1),
(124, NULL, 68, 10, 1),
(125, NULL, 84, 8, 1),
(126, NULL, 84, 9, 1),
(127, NULL, 84, 10, 1),
(128, NULL, 84, 11, 1),
(129, NULL, 84, 12, 1),
(130, NULL, 84, 13, 1),
(131, NULL, 84, 14, 1),
(132, NULL, 84, 15, 1),
(133, NULL, 84, 16, 1),
(134, NULL, 84, 5, 1),
(135, NULL, 84, 6, 1),
(136, NULL, 84, 7, 1),
(137, NULL, 84, 27, 0),
(138, NULL, 84, 26, 1),
(139, NULL, 84, 17, 1),
(140, NULL, 84, 24, 0),
(141, NULL, 84, 23, 1),
(142, NULL, 84, 22, 1),
(143, NULL, 85, 23, 1),
(144, NULL, 85, 22, 1),
(145, NULL, 87, 23, 1),
(146, NULL, 87, 22, 1),
(147, NULL, 86, 8, 1),
(148, NULL, 86, 9, 1),
(149, NULL, 86, 10, 1),
(150, NULL, 86, 11, 1),
(151, NULL, 86, 12, 1),
(152, NULL, 86, 13, 1),
(153, NULL, 86, 14, 1),
(154, NULL, 86, 15, 1),
(155, NULL, 86, 16, 1),
(156, NULL, 86, 5, 1),
(157, NULL, 86, 6, 1),
(158, NULL, 86, 7, 1),
(159, NULL, 86, 23, 1),
(160, NULL, 86, 22, 1),
(161, NULL, 88, 8, 1),
(162, NULL, 88, 9, 1),
(163, NULL, 88, 10, 1),
(164, NULL, 88, 11, 1),
(165, NULL, 88, 12, 1),
(166, NULL, 88, 13, 1),
(167, NULL, 88, 14, 1),
(168, NULL, 88, 15, 1),
(169, NULL, 88, 16, 1),
(170, NULL, 88, 5, 1),
(171, NULL, 88, 6, 1),
(172, NULL, 88, 23, 1),
(173, NULL, 88, 22, 1),
(174, NULL, 88, 7, 1),
(175, NULL, 92, 8, 1),
(176, NULL, 92, 9, 1),
(177, NULL, 92, 10, 1),
(178, NULL, 92, 11, 1),
(179, NULL, 92, 12, 1),
(180, NULL, 92, 13, 1),
(181, NULL, 92, 14, 1),
(182, NULL, 92, 15, 1),
(183, NULL, 92, 16, 1),
(184, NULL, 92, 5, 1),
(185, NULL, 92, 6, 1),
(186, NULL, 92, 7, 1),
(187, NULL, 92, 23, 1),
(188, NULL, 92, 22, 1),
(189, NULL, 67, 12, 1),
(190, NULL, 98, 8, 1),
(191, NULL, 67, 29, 0),
(192, NULL, 89, 8, 1),
(193, NULL, 89, 9, 1),
(194, NULL, 89, 10, 1),
(195, NULL, 89, 11, 1),
(196, NULL, 89, 12, 1),
(197, NULL, 89, 13, 1),
(198, NULL, 89, 14, 1),
(199, NULL, 89, 15, 1),
(200, NULL, 89, 16, 1),
(201, NULL, 89, 5, 1),
(202, NULL, 89, 6, 1),
(203, NULL, 89, 7, 1),
(204, NULL, 89, 26, 1),
(205, NULL, 89, 17, 1),
(206, NULL, 89, 23, 1),
(207, NULL, 89, 22, 1),
(208, NULL, 84, 53, 1),
(209, NULL, 84, 52, 1),
(210, NULL, 114, 35, 1),
(211, NULL, 114, 42, 1),
(212, NULL, 115, 27, 1),
(213, NULL, 115, 17, 1),
(214, NULL, 115, 35, 1),
(215, NULL, 115, 20, 1),
(216, NULL, 115, 19, 1),
(217, NULL, 115, 23, 1),
(218, NULL, 125, 30, 1),
(219, NULL, 125, 39, 1),
(220, NULL, 127, 39, 0),
(221, NULL, 127, 30, 0),
(222, NULL, 127, 54, 1),
(223, NULL, 127, 27, 1),
(224, NULL, 131, 54, 1),
(225, NULL, 131, 30, 1),
(226, NULL, 131, 21, 1),
(227, NULL, 131, 19, 1),
(228, NULL, 131, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `CUIT` varchar(255) NOT NULL,
  `codigo_cliente` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `localidad` varchar(255) NOT NULL,
  `codigo_postal` varchar(255) NOT NULL,
  `provincia` varchar(255) NOT NULL,
  `pais` varchar(255) DEFAULT 'Argentina',
  `direccion` varchar(255) NOT NULL,
  `observaciones` text NOT NULL,
  `en_uso` tinyint(4) NOT NULL DEFAULT 1,
  `iva` double DEFAULT 21,
  `tipo_factura` varchar(255) DEFAULT 'B'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `CUIT`, `codigo_cliente`, `nombre`, `localidad`, `codigo_postal`, `provincia`, `pais`, `direccion`, `observaciones`, `en_uso`, `iva`, `tipo_factura`) VALUES
(1, '20-369588796-2', 'XX-GARY', 'Cliente 1 - nuevo', 'CABA', '1418', 'CABA', 'Argentina', 'Lanin 111', 'test', 1, 21, 'B'),
(3, '20-30651666-3', '1419', 'Santiago Garibotto', 'Ciudad AutÃ³noma de Buenos Aires', 'test', 'test', 'Argentina', 'test', 'test', 1, 21, 'B'),
(4, '20-15698636-1', '12133', 'Hermes Dessio', 'Chegusan', '1233', 'Cordoba', 'Argentina', 'Las rosas 3226', 'Sin observaciones', 1, 21, 'B'),
(5, '30-54568150-8', 'C01921', 'Municipalidad de General San Martin ', 'San Martin ', '1650', 'Bs. As.', 'Argentina', 'Belgrano ', '', 1, 21, 'B'),
(6, '99-99999999-9', '9999988', 'Cliente de prueba', 'TEST', '1212', 'CABA', 'Argentina', 'test', '', 1, 10.5, 'B');

-- --------------------------------------------------------

--
-- Table structure for table `clientes_vendedores`
--

CREATE TABLE `clientes_vendedores` (
  `id` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `vendedor` int(11) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `en_uso` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clientes_vendedores`
--

INSERT INTO `clientes_vendedores` (`id`, `cliente`, `vendedor`, `observaciones`, `en_uso`) VALUES
(1, 1, 1, '', 0),
(2, 1, 1, 'test4', 1),
(3, 1, 1, '', 0),
(4, 1, 1, 'test', 0),
(5, 1, 1, 'test', 0),
(6, 1, 1, 'test', 0),
(7, 2, 1, NULL, 1),
(8, 4, 2, '', 1),
(9, 4, 1, '', 1),
(10, 5, 1, '', 1),
(11, 3, 1, NULL, 1),
(12, 6, 1, NULL, 1),
(13, 3, 3, '', 1),
(14, 3, 5, NULL, 1),
(15, 6, 5, NULL, 1),
(16, 6, 5, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `codigos_de_articulo`
--

CREATE TABLE `codigos_de_articulo` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `modelo_con_mecanismo` int(11) DEFAULT NULL,
  `variaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_uso` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `codigos_de_articulo`
--

INSERT INTO `codigos_de_articulo` (`id`, `codigo`, `modelo_con_mecanismo`, `variaciones`, `en_uso`) VALUES
(1, 'S.300 N./BASC 342C', 67, '12', 1),
(5, 'SANA-N-AQUA', 104, '', 1),
(10, 'SDELFO-A-C/B', 114, '', 1),
(13, 'SANA-F-N', 102, '', 1),
(14, 'SANA-F-C-', 100, '', 1),
(17, 'SANA-FR-C', 112, '', 1),
(18, 'SANA-FR-C', 110, '', 1),
(19, 'SANA-FR-GRISC', 111, '', 1),
(20, 'SANA-T-N-', 109, '', 1),
(21, 'SANA-T-G-', 108, '', 1),
(22, 'SANA-T-C-', 107, '', 1),
(23, 'STAN-ANANA-2', 105, '', 1),
(24, 'STAN-ANANA-3', 106, '', 1),
(25, 'STAN-ANANA-4', 120, '', 1),
(26, 'SANA-B-', 119, '', 1),
(27, 'SANA-B-G-', 118, '', 1),
(28, 'SANA-B-C-', 117, '', 1),
(30, 'SANA-S-N-', 122, '', 1),
(31, 'SANA-S-GP-', 121, '', 1),
(32, 'SFLORA-F-', 123, '', 1),
(33, 'SFRI-F-C', 125, '', 1),
(34, 'SFRI-F-A-', 126, '', 1),
(36, 'SFRI-N-', 127, '27', 1),
(37, 'SFRI-N-C', 127, '54', 1),
(39, 'SJIM-N-', 131, '19,30', 1),
(40, 'SJIM-N-C-', 131, '19,54', 1),
(41, 'SJIM-FG-', 129, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `colores`
--

CREATE TABLE `colores` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `precio` double NOT NULL DEFAULT 0,
  `en_uso` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `colores`
--

INSERT INTO `colores` (`id`, `tipo`, `nombre`, `descripcion`, `precio`, `en_uso`) VALUES
(1, 'marathon', 'violeta', '', 0, 1),
(2, 'marathon', 'rojo señal', '', 0, 1),
(3, 'marathon', 'rojo', '', 0, 1),
(4, 'marathon', 'petroleo', '', 0, 1),
(5, 'marathon', 'negro', '', 0, 1),
(6, 'marathon', 'naranja', '', 0, 1),
(7, 'marathon', 'maiz', '', 0, 1),
(8, 'marathon', 'gris titanio', '', 0, 1),
(9, 'marathon', 'gris perla', '', 0, 1),
(10, 'marathon', 'gris oscuro', '', 0, 1),
(11, 'marathon', 'bordo', '', 0, 1),
(12, 'marathon', 'azul marino', '', 0, 1),
(13, 'marathon', 'azul', '', 0, 1),
(14, 'marathon', 'aero', '', 0, 1),
(15, 'marathon', 'beige', '', 0, 1),
(16, 'marathon', 'verde', '', 0, 1),
(17, 'eco cuero', 'amarillo', '', 0, 1),
(18, 'eco cuero', 'aqua', '', 0, 1),
(19, 'eco cuero', 'arena', '', 0, 1),
(20, 'eco cuero', 'azul', '', 0, 1),
(21, 'eco cuero', 'azul fosco', '', 0, 1),
(22, 'eco cuero', 'azulino', '', 0, 1),
(23, 'eco cuero', 'beige lotus', '', 0, 1),
(24, 'eco cuero', 'blanco', '', 0, 1),
(25, 'eco cuero', 'camel', '', 0, 1),
(26, 'eco cuero', 'chocolate', '', 0, 1),
(27, 'eco cuero', 'fucsia', '', 0, 1),
(28, 'eco cuero', 'gris', '', 0, 1),
(29, 'eco cuero', 'maiz', '', 0, 1),
(30, 'eco cuero', 'marron', '', 0, 1),
(31, 'eco cuero', 'naranja', '', 0, 1),
(32, 'eco cuero', 'negro', '', 0, 1),
(33, 'eco cuero', 'rojo fuego', '', 0, 1),
(34, 'eco cuero', 'rojo tomate', '', 0, 1),
(35, 'eco cuero', 'turquesa', '', 0, 1),
(36, 'eco cuero', 'verde inglés', '', 0, 1),
(37, 'eco cuero', 'verde manzana', '', 0, 1),
(38, 'eco cuero', 'verde selva', '', 0, 1),
(39, 'eco cuero', 'violeta', '', 0, 1),
(40, 'red', 'azul', '', 0, 1),
(41, 'red', 'bizon', '', 0, 1),
(42, 'red', 'gris perla', '', 0, 1),
(43, 'red', 'naranja', '', 0, 1),
(44, 'red', 'negro', '', 0, 1),
(45, 'red', 'petroleo', '', 0, 1),
(46, 'red', 'rojo', '', 0, 1),
(47, 'red', 'rojo fuego', '', 0, 1),
(48, 'red', 'verde', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `valor` varchar(255) DEFAULT NULL,
  `en_uso` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contactos`
--

INSERT INTO `contactos` (`id`, `cliente`, `nombre`, `tipo`, `valor`, `en_uso`) VALUES
(1, 1, 'Jorge primo', 'mail', 'test primo ', 1),
(2, 4, 'Hermes', 'mail', 'hermes@dession.com', 1),
(3, 5, 'Direccion de Educacion ', 'nada ', 'nada ', 1),
(4, 6, 'test', 'test', 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `datos_presupuesto`
--

CREATE TABLE `datos_presupuesto` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `vendedor` int(11) NOT NULL,
  `fecha_emision` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `iva` double NOT NULL DEFAULT 21,
  `descuento` double NOT NULL DEFAULT 0,
  `embalaje` double NOT NULL DEFAULT 0,
  `observaciones` text DEFAULT NULL,
  `condicion` text DEFAULT NULL,
  `emitido` tinyint(4) DEFAULT 0,
  `direccion_entrega` int(11) DEFAULT NULL,
  `tipo_factura` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `datos_presupuesto`
--

INSERT INTO `datos_presupuesto` (`id`, `numero`, `cliente`, `vendedor`, `fecha_emision`, `fecha_actualizacion`, `iva`, `descuento`, `embalaje`, `observaciones`, `condicion`, `emitido`, `direccion_entrega`, `tipo_factura`) VALUES
(1, 1, 1, 1, '2018-05-30 12:44:38', '2018-05-30 12:44:38', 21, 0, 0, NULL, NULL, 1, NULL, NULL),
(2, 2, 1, 1, '2018-05-30 12:44:38', '2018-05-30 12:44:38', 21, 0, 0, NULL, NULL, 1, NULL, NULL),
(3, 3, 1, 1, '2018-06-06 22:56:09', '2018-06-06 22:56:09', 21, 0, 0, NULL, NULL, 1, NULL, NULL),
(83, 4, 1, 1, '2018-06-01 02:18:45', '2018-06-01 02:18:45', 10.5, 5, 5, 'test', 'SeÃ±a 50% y saldo contraentrega.', 1, 3, 'B'),
(85, 6, 4, 2, '2018-06-03 23:17:24', '2018-06-03 23:17:24', 21, 3, 8, NULL, NULL, 1, 13, NULL),
(87, 5, 1, 1, '2018-06-06 23:02:02', '2018-06-06 23:02:02', 21, 0, 0, NULL, NULL, 1, NULL, NULL),
(88, 7, 1, 1, '2018-06-06 22:54:19', '2018-06-06 22:54:19', 21, 0, 0, NULL, NULL, 1, NULL, NULL),
(89, 8, 1, 1, '2018-06-06 23:03:20', '2018-06-06 23:03:20', 21, 8, 5, 'Test de observaciones.', NULL, 1, NULL, NULL),
(90, 9, 1, 1, '2018-06-06 23:04:44', '2018-06-06 23:04:44', 21, 0, 0, NULL, NULL, 1, NULL, NULL),
(91, 10, 1, 1, '2018-06-10 01:37:07', '0000-00-00 00:00:00', 21, 0, 0, NULL, NULL, 0, NULL, NULL),
(92, 11, 1, 1, '2018-06-27 21:50:29', '2018-06-27 21:50:29', 21, 0, 0, NULL, NULL, 1, NULL, NULL),
(93, 12, 4, 1, '2018-06-12 14:08:55', '0000-00-00 00:00:00', 21, 0, 0, NULL, NULL, 0, NULL, NULL),
(95, 14, 5, 1, '2018-06-13 11:59:25', '0000-00-00 00:00:00', 21, 0, 0, NULL, NULL, 0, NULL, NULL),
(96, 13, 1, 1, '2018-06-27 22:07:47', '0000-00-00 00:00:00', 21, 0, 0, NULL, NULL, 0, NULL, NULL),
(97, 15, 6, 1, '2018-06-27 22:09:07', '0000-00-00 00:00:00', 21, 0, 0, NULL, NULL, 0, NULL, NULL),
(98, 16, 6, 1, '2018-06-27 22:09:57', '2018-06-27 22:09:57', 21, 5, 5, NULL, NULL, 0, NULL, NULL),
(99, 17, 6, 1, '2018-06-27 22:11:21', '2018-06-27 22:11:21', 21, 3, 8, NULL, 'Seña 30% y saldo contraentrega.', 1, NULL, 'A'),
(100, 18, 6, 1, '2018-06-27 23:23:16', '2018-06-27 23:23:16', 10.5, 2, 5, NULL, 'Seña 30% y saldo contraentrega.', 1, NULL, 'A'),
(101, 19, 5, 1, '2018-06-29 12:08:52', '2018-06-29 12:08:52', 21, 0, 0, NULL, 'contado', 1, 15, 'B'),
(102, 20, 5, 1, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 21, 1, 0, NULL, 'Otro. (Aclarar en observaciones)', 1, 15, 'B');

-- --------------------------------------------------------

--
-- Table structure for table `direcciones_entrega`
--

CREATE TABLE `direcciones_entrega` (
  `id` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `localidad` varchar(255) NOT NULL,
  `codigo_postal` varchar(255) NOT NULL,
  `provincia` varchar(255) NOT NULL,
  `pais` varchar(255) DEFAULT 'Argentina',
  `observaciones` text DEFAULT NULL,
  `es_default` tinyint(4) DEFAULT 0,
  `en_uso` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `direcciones_entrega`
--

INSERT INTO `direcciones_entrega` (`id`, `cliente`, `direccion`, `localidad`, `codigo_postal`, `provincia`, `pais`, `observaciones`, `es_default`, `en_uso`) VALUES
(1, 1, 'Carlos Antonio Lopez 3220 2B, CUIT 20306515153', 'Ciudad AutÃ³noma de Buenos Aires', '1419', 'Buenos Aires', 'Argentina', 'test', 0, 1),
(2, 1, 'Carlos Antonio Lopez 3220 2B', 'Ciudad AutÃ³noma de Buenos Aires', '1419', 'Buenos Aires', 'Argentina', 'test', 0, 1),
(3, 1, 'Carlos Antonio Lopez 3220 2B18', 'Ciudad AutÃ³noma de Buenos Aires', '1419', 'Buenos Aires', 'Argentina', 'test', 0, 1),
(4, 1, 'Carlos Antonio Lopez 3220 2B18', 'Ciudad AutÃ³noma de Buenos Aires', '1419', 'Buenos Aires', 'Argentina', 'test', 0, 0),
(5, 1, 'Carlos Antonio Lopez 3220 2B18', 'Ciudad AutÃ³noma de Buenos Aires', '141915633', 'Buenos Aires', 'Argentina', 'test', 0, 0),
(6, 1, 'Carlos Antonio Lopez 3220 2B18', 'Ciudad AutÃ³noma de Buenos Aires', '1419', 'Buenos Aires', 'Argentina', 'test', 0, 0),
(7, 1, 'Carlos Antonio Lopez 3220 2B, CUIT 20306515153', 'Ciudad AutÃ³noma de Buenos Aires', '1418', 'Buenos Aires', 'Argentina', 'test', 0, 0),
(8, 1, 'Carlos Antonio Lopez 3220 2B, CUIT 20306515153', 'Ciudad AutÃ³noma de Buenos Aires', '1417777', 'Buenos Aires', 'Argentina', 'test', 0, 0),
(9, 1, 'Carlos Antonio Lopez 3220 2B, CUIT 20306515153', 'Ciudad AutÃ³noma de Buenos Aires', '1417', 'Buenos Aires', 'Argentina', 'test', 0, 0),
(10, 1, 'Carlos Antonio Lopez 3220 2B, CUIT 20306515153', 'Ciudad AutÃ³noma de Buenos Aires', '1417', 'Buenos Aires', 'Argentina', 'test', 0, 0),
(11, 1, 'Carlos Antonio Lopez 3220 2B, CUIT 20306515153', 'Ciudad AutÃ³noma de Buenos Aires', '1417', 'Buenos Aires', 'Argentina', 'test', 0, 0),
(12, 4, 'zapala 6398 Timbre 2', 'Chegusan', '1236', 'Buenos aires', 'Argentina', 'asdfasdf', 0, 1),
(13, 4, 'zapala 6398 Timbre 2', 'Chegusan', '1236', 'Buenos aires', 'Argentina', 'asdfasdf', 0, 1),
(14, 3, 'Artigas 4620, 1 6', 'caba', '1419', 'Ciudad AutÃ³noma de Buenos Aires', 'Argentina', '', 0, 1),
(15, 5, 'Belgrano 3747', 'San Martin ', '1650', 'Bs. As.', 'Argentina', '', 0, 1),
(16, 6, 'Dirección de prueba 225', 'TEST', '1212', 'TEST', 'Argentina', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mecanismos`
--

CREATE TABLE `mecanismos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `precio` double NOT NULL DEFAULT 0,
  `en_uso` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mecanismos`
--

INSERT INTO `mecanismos` (`id`, `nombre`, `descripcion`, `precio`, `en_uso`) VALUES
(1, 'Synchron', 'regulacion de altura,  <b>mecanismo syncrhon</b> que  permite regular la inclinacion del respaldo,   UP-Down permite la regulacion de altura en el respaldo,', 6468, 1),
(2, 'Basculante', 'regulación de altura,  <b>mecanismo basculante</b> que  permite oscilar el mismo,', 0, 1),
(3, 'Cantilever Negro', 'Estructura cantilever  con brazos terminacion negra, asiento multilaminadocon goma espuma inyectada termoformada', 6678, 1),
(4, 'Cantilever Cromado', 'Estructura cantilever  con brazos terminacion cromada, asiento multilaminadocon goma espuma inyectada termoformada test', 7203, 1),
(5, 'test', 'test', 1234, 0),
(6, 'Neumatica', 'con regulacion de altura atraves de un piston neumatico,', 0, 1),
(7, 'syncrhon', 'regulacion de altura,  mecanismo syncrhon que  permite regular la inclinacion del respaldo,   UP-Down en la rińonera para regular  la misma Asiento multilaminado con goma espuma inyectada termoformado', 6468, 0),
(11, 'Otro mecanismo', 'test de meca', 0, 0),
(12, 'Otro mecanismo más', 'segundo test de meca', 0, 0),
(14, 'neumatica con contacto ', 'con regulacion de altura atraves de un piston neumatico, contacto permanente ', 0, 1),
(15, 'giratoria', 'con mecanismo giratorio', 0, 1),
(16, 'Fija 4 Patas cromo', 'fija de 4 patas acabado cromado', 0, 1),
(17, 'Fija 4 Patas negro', 'fija de 4 patas acabado con pintura epoxi negro', 0, 1),
(18, 'Fija 4 Patas gris microtexturado ', 'fija de 4 patas  acabado gris microtexturado', 0, 1),
(19, 'Trineo cromada', 'base trineo cromada', 0, 1),
(20, 'Trineo negra', 'base trineo  pintada con pintura epoxi negro', 0, 1),
(21, 'Trineo gris', 'base trineo gris microtexturado', 0, 1),
(22, 'Tandem x 2 cuerpos', 'Tandem de 2 cuerpos(105x60)', 0, 1),
(23, 'Tandem x 3 cuerpos', 'Tandem de 3 cuerpos (155x60)', 0, 1),
(24, 'Tandem x 4 cuerpos', 'Tandem de 4 cuerpos (205x60)', 0, 1),
(25, 'Fija 4 patas con ruedas negra', 'Fija de 4 patas pintada en epoxi negro, con ruedas,', 0, 1),
(27, 'Fija 4 patas con ruedas gris mictro', 'Fija de 4 patas pintada gris microtexturado, con ruedas,', 0, 1),
(28, 'Fija 4 patas con ruedas negro', 'Fija de 4 patas pintado con pintura negra, con ruedas,', 0, 1),
(31, 'Fija 4 patas con ruedas cromada', 'Fija de 4 patas cromada, con ruedas', 0, 1),
(32, 'Taburete negro', 'Taburete fijo de 4 patas pintadas en pintura epoxi negro', 0, 1),
(33, 'Taburete gris ', 'Taburete fijo de 4 patas pintado en gris microtexturado', 0, 1),
(34, 'Taburete cromo', 'Taburete fijo de 4 patas cromadas', 0, 1),
(35, 'Studio base negro ', 'Base <b>Studio</B> negra, tablita pupitre revatilble', 0, 1),
(36, 'Studio base gris', 'Base <b>Studio</B> gris , tablita pupitre revatilble', 0, 1),
(37, 'Fija 4 patas', 'Fija de 4 patas', 0, 1),
(39, 'Wood', 'Base Wood, fija de 4 patas de madera.', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `modelos`
--

CREATE TABLE `modelos` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL DEFAULT 'silla',
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `precio` double NOT NULL DEFAULT 0,
  `en_uso` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modelos`
--

INSERT INTO `modelos` (`id`, `tipo`, `nombre`, `descripcion`, `precio`, `en_uso`) VALUES
(1, 'silla', 'test4', '4234', 4234, 0),
(2, 'silla', 'Citiz sin cabezal', 'Silla Mod. Citiz Sin Cabezal', 0, 0),
(3, 'silla', 'Citiz con cabezal', 'Silla Mod. Citiz Con Cabezal', 766.5, 0),
(5, 'silla', 'teste4', 'asdfadf', 23123, 0),
(6, 'silla', 'trst', 'sfdafd', 3123123, 0),
(8, 'silla', 'gafgsdfg', 'fsadfaf', 546546, 0),
(9, 'silla', 'tasetat', 'testtt', 596, 0),
(10, 'silla', 'otro test', 'otooaosdt', 434, 0),
(11, 'silla', 'getzs', 'test', 6, 0),
(13, 'silla', 'nuevo test', 'test nuevo pero ahora con modificaciones', 200, 0),
(16, 'silla', 'testeamos', 'rtestest', 2, 0),
(17, 'silla', 'otro test test', 'test', 10, 0),
(18, 'silla', 'Diva', 'Silla Mod. Diva', 0, 1),
(19, 'silla', ' 300 Bajo ', 'Sillon <b>Mod. 300 Bajo</b>.', 0, 1),
(20, 'silla', ' 301 Alto', 'Sillon Mod. 301  Alto', 0, 1),
(21, 'silla', ' 600 Bajo ', 'Sillon Mod. 600 Bajo', 0, 1),
(22, 'silla', ' 601 Alto', 'Sillon Mod. 601  Alto', 0, 1),
(23, 'silla', ' Alma Est. Blanca', 'Silla Mod. Alma Estructura blanca', 52444, 1),
(24, 'silla', ' Alma Est. Gris', 'Silla Mod. Alma Estructura Gris', 5244, 1),
(25, 'silla', ' Alma Est. Negra', 'Silla Mod. Alma Estructura Negra', 5244, 1),
(26, 'silla', ' Anana', 'Silla <b>Mod. Anana,</b>', 0, 1),
(27, 'silla', ' Antlia Alto', 'Sillon Mod. Antlia Alto', 0, 1),
(28, 'silla', ' Antlia bajo', 'Sillon Mod. Antlia Bajo', 0, 1),
(29, 'silla', ' Arcadia', 'Silla Mod. Arcadia baja', 0, 1),
(30, 'silla', ' Cala', 'Silla Mod. Cala', 0, 1),
(31, 'silla', ' Chino', 'Silla Mod. Chino', 0, 1),
(32, 'silla', ' Citiz con cabezal', 'Silla Mod. Citiz Con Cabezal', 7234.5, 1),
(33, 'silla', ' Citiz sin cabezal', 'Silla Mod. Citiz Sin Cabezal', 6468, 1),
(34, 'silla', ' Cubo 1 cuerpo', 'Sillon  Mod. Cubo de 1 cuerpo patas cromo', 0, 1),
(35, 'silla', ' Cubo 2 cuerpos', 'Sillon  Mod. Cubo de 2 cuerpo patas cromo', 0, 1),
(36, 'silla', ' Cubo Mesa Cuadrada', 'Sillon  Mod. Cubo de 60x60 tapa de vidrio de 10mm cuerpo tapizado', 0, 1),
(37, 'silla', ' Cubo Mesa Rectangular', 'Sillon  Mod. Cubo de 60x120 tapa de vidrio de 10mm cuerpo tapizado', 0, 1),
(38, 'silla', ' Cubo Puff de 2 cuerpos', 'Sillon  Mod. Cubo de 2 cuerpo patas cromo', 0, 1),
(39, 'silla', ' Delfo Alto', 'Sillon <b>Mod. Delfo</b> Alto', 0, 1),
(40, 'silla', ' Delfo Bajo', 'Sillon <b>Mod. Delfo</b> Bajo', 0, 1),
(41, 'silla', ' Diva', 'Silla Mod. Diva', 0, 1),
(42, 'silla', ' Electra Alto', 'Sillon Mod. Electra Alto', 0, 1),
(43, 'silla', ' Electra bajo', 'Sillon Mod. Electra Bajo', 0, 1),
(44, 'silla', ' Flora', 'Silla <b>Mod. Flora</b>,', 0, 1),
(45, 'silla', ' Flora Taburete', 'Silla <b>Mod. Flora Taburete</b>,', 0, 1),
(46, 'silla', ' Folk', 'Sillon Mod. Folk', 0, 1),
(47, 'silla', ' Fresa', 'Silla Mod. Fresa', 0, 1),
(48, 'silla', ' Frida ', 'Silla <b>Mod. Frida,</b>', 0, 1),
(49, 'silla', ' Idra Alto', 'Sillon Mod. Idra  Alto', 0, 1),
(50, 'silla', ' Idra Bajo', 'Sillon Mod. Idra Bajo', 0, 1),
(51, 'silla', ' India', 'Silla Mod. India', 2950, 1),
(52, 'silla', ' Jazz 900 Bajo Red tapizado', 'Sillon Mod. Jazz 900 Bajo Red Tapizado', 0, 1),
(53, 'silla', ' Jazz 900 Bajo tapizado', 'Sillon Mod. Jazz 900 Bajo Tapizado', 0, 1),
(54, 'silla', ' Jazz 901 Alto  Red tapizado', 'Sillon Mod. Jazz 901 Alto Red Tapizado', 0, 1),
(55, 'silla', ' Jazz 901 Alto tapizado', 'Sillon Mod. Jazz 901 Alto Tapizado', 0, 1),
(56, 'silla', ' Jim', 'Silla <b> Mod. Jim</b>', 0, 1),
(57, 'silla', ' LC2 /1 cuerpo', 'Sillon Mod. LC de 1 cuerpo  ', 0, 1),
(58, 'silla', ' LC2 /2 cuerpo', 'Sillon Mod. LC de 2 cuerpo ', 0, 1),
(59, 'silla', ' LC2 /3 cuerpo', 'Sillon Mod. LC de 3 cuerpo ', 0, 1),
(60, 'silla', ' Malba', 'Silla Mod. Malba', 0, 1),
(61, 'silla', ' Mandarin Alto', 'Sillon Mod. Mandarin  Alto', 0, 1),
(62, 'silla', ' Mandarin Bajo', 'Sillon Mod. Mandarin Bajo', 0, 1),
(63, 'silla', ' Manta', 'Silla Mod. <b>Manta </b>con', 0, 1),
(64, 'silla', ' Milito ', 'Taburete Mod. Milito', 0, 1),
(65, 'silla', ' Milo', 'Taburete Mod. Milo', 0, 1),
(66, 'silla', ' Miro', 'Sillon Mod. Miro  respaldo de Red, sillon con brazos.', 0, 1),
(67, 'silla', ' Mora', 'Silla Mod. Mora', 0, 1),
(68, 'silla', ' Nina', 'Silla Mod. Nina', 0, 1),
(69, 'silla', ' One', 'Silla Mod. One', 0, 1),
(70, 'silla', ' One Tapizada ', 'Silla Mod. One Tapizada ', 0, 1),
(71, 'silla', ' One x 2 cuerpos', '', 0, 1),
(72, 'silla', ' One x 3 cuerpos', '', 0, 1),
(73, 'silla', ' One x 4 cuerpos', '', 0, 1),
(74, 'silla', ' Otro Modelo', 'Silla Otro Modelo', 0, 0),
(75, 'silla', ' Ovo', 'Sillon Mod. Ovo  Cromo', 0, 1),
(76, 'silla', ' Paulin', 'Sillon Mod. Paulin base Cromo', 0, 1),
(77, 'silla', ' Petra Alta', 'Silla Mod. Petra Alta', 0, 1),
(78, 'silla', ' Petra Baja', 'Silla Mod. Petra Baja', 0, 1),
(79, 'silla', ' Petra x 2 cuerpos', '', 0, 1),
(80, 'silla', ' Petra x 3 cuerpos', '', 0, 1),
(81, 'silla', ' Petra x 4 cuerpos', '', 0, 1),
(82, 'silla', ' Pistacho Alto', 'Sillon Mod. Pistacho  Alto', 0, 1),
(83, 'silla', ' Pistacho Bajo', 'Sillon Mod. Pistacho Bajo', 0, 1),
(84, 'silla', ' R701', 'Silla Mod. R701', 0, 1),
(85, 'silla', ' R701 x 2 cuerpos', '', 0, 1),
(86, 'silla', ' R701 x 3 cuerpos', '', 0, 1),
(87, 'silla', ' R701 x 4 cuerpos', '', 0, 1),
(88, 'silla', ' R850', 'Silla Mod. R850', 0, 1),
(89, 'silla', ' R850 X 2 cuerpos', '', 0, 1),
(90, 'silla', ' R850 X 3 cuerpos', '', 0, 1),
(91, 'silla', ' R850 X 4 cuerpos', '', 0, 1),
(92, 'silla', ' R851', 'Silla Mod. R851', 0, 1),
(93, 'silla', ' R851 X 2 cuerpos', '', 0, 1),
(94, 'silla', ' R851 X 3 cuerpos', '', 0, 1),
(95, 'silla', ' R851 X 4 cuerpos', '', 0, 1),
(96, 'silla', ' Riota Alta', 'Silla Mod. Riota Alta', 0, 1),
(97, 'silla', ' Riota baja', 'Silla Mod. Riota Baja', 0, 1),
(98, 'silla', ' Riota x 2 cuerpos', '', 0, 1),
(99, 'silla', ' Riota x 3 cuerpos', '', 0, 1),
(100, 'silla', ' Riota x 4 cuerpos', '', 0, 1),
(101, 'silla', ' Roby Alta', 'Silla Mod. Roby Alta', 0, 1),
(102, 'silla', ' Roby Baja', 'Silla Mod. Roby Baja', 0, 1),
(103, 'silla', ' Roby x 2 cuerpos', '', 0, 1),
(104, 'silla', ' Roby x 3 cuerpos', '', 0, 1),
(105, 'silla', ' Roby x 4 cuerpos', '', 0, 1),
(106, 'silla', ' Rombo', 'Silla Mod. Rombo', 0, 1),
(107, 'silla', ' RP700', 'Silla Mod. RP700', 0, 1),
(108, 'silla', ' RP700 x 2 cuerpos', '', 0, 1),
(109, 'silla', ' RP700 x 3 cuerpos', '', 0, 1),
(110, 'silla', ' RP700 x 4 cuerpos', '', 0, 1),
(111, 'silla', ' Smart', 'Sillon Mod. Sm@rt de 120x72,5 con puerto USB', 0, 1),
(112, 'silla', ' Spider Alto', 'Silla Mod. Spider Alto', 0, 1),
(113, 'silla', ' Spider Bajo', 'Silla Mod. Spider Bajo', 0, 1),
(114, 'silla', ' Tyson', 'Silla Mod. Tyson', 0, 1),
(115, 'silla', ' Tyson x 2 cuerpos', '', 0, 1),
(116, 'silla', ' Tyson x 3 cuerpos', '', 0, 1),
(117, 'silla', ' Tyson x 4 cuerpos', '', 0, 1),
(118, 'silla', 'manta', 'Silla Mod.Manta', 0, 1),
(119, 'silla', 'anana', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `modelos_con_mecanismo`
--

CREATE TABLE `modelos_con_mecanismo` (
  `id` int(11) NOT NULL,
  `modelo` int(11) NOT NULL,
  `mecanismo` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `precio` double NOT NULL DEFAULT 0,
  `en_uso` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modelos_con_mecanismo`
--

INSERT INTO `modelos_con_mecanismo` (`id`, `modelo`, `mecanismo`, `descripcion`, `precio`, `en_uso`) VALUES
(1, 2, 1, '', 0, 1),
(2, 2, 2, '', 0, 1),
(3, 2, 3, '', 0, 1),
(4, 2, 4, '', 0, 1),
(5, 3, 1, '', 0, 0),
(6, 3, 2, '', 0, 1),
(7, 3, 3, '', 0, 0),
(8, 3, 4, '', 0, 0),
(63, 8, 1, '', 0, 1),
(64, 8, 3, '', 0, 1),
(65, 8, 4, '', 0, 0),
(66, 3, 6, '', 0, 0),
(67, 19, 2, 'http://www.diwar.com.ar/site/assets/files/4844/producto-300-460x580-1.jpg', 5020, 1),
(68, 19, 4, '', 0, 1),
(69, 68, 22, '', 0, 1),
(70, 68, 24, '', 0, 1),
(71, 68, 23, '', 0, 1),
(72, 52, 2, '', 0, 1),
(73, 19, 15, '', 0, 0),
(74, 19, 16, '', 0, 1),
(75, 26, 2, '', 0, 0),
(76, 26, 4, '', 0, 0),
(77, 20, 2, '', 0, 1),
(78, 21, 2, '', 0, 1),
(79, 21, 4, '', 0, 1),
(80, 21, 3, '', 0, 1),
(81, 23, 2, '', 0, 1),
(82, 24, 2, '', 0, 1),
(83, 63, 6, '', 0, 1),
(84, 63, 2, 'http://diwar.com.ar/site/assets/files/1046/manta-01.jpg', 3889.44, 1),
(85, 63, 4, '', 0, 1),
(86, 63, 16, '', 0, 1),
(87, 63, 3, '', 0, 1),
(88, 63, 17, '', 0, 1),
(89, 63, 1, 'http://diwar.com.ar/site/assets/files/1046/manta_460x580.jpg', 4592.44, 1),
(90, 63, 20, '', 0, 1),
(91, 63, 19, '', 0, 1),
(92, 63, 22, '', 0, 1),
(93, 63, 23, '', 0, 1),
(94, 63, 24, '', 0, 1),
(95, 32, 2, '', 0, 1),
(96, 32, 3, '', 0, 1),
(97, 32, 4, '', 0, 1),
(98, 19, 3, 'http://www.diwar.com.ar/site/assets/files/4844/300-a.jpg', 0, 1),
(99, 19, 18, '', 0, 0),
(100, 26, 16, '', 1321.71, 1),
(101, 26, 18, '', 0, 1),
(102, 26, 17, '', 981.75, 1),
(103, 26, 15, '', 0, 0),
(104, 26, 6, '', 1784.2, 1),
(105, 26, 22, '', 2670.94, 1),
(106, 26, 23, '', 4006.42, 1),
(107, 26, 19, '', 1780.75, 1),
(108, 26, 21, '', 1355.75, 1),
(109, 26, 20, '', 1355.75, 1),
(110, 26, 31, '', 2242.64, 1),
(111, 26, 27, '', 1817.64, 1),
(112, 26, 25, '', 1817.64, 1),
(113, 26, 28, '', 0, 1),
(114, 39, 2, 'http://www.diwar.com.ar/site/assets/files/1057/delfo1_460x580.jpg', 5570.32, 1),
(115, 40, 2, '', 0, 1),
(116, 40, 6, '', 0, 1),
(117, 26, 34, '', 2514, 1),
(118, 26, 33, '', 1914, 1),
(119, 26, 32, '', 1914, 1),
(120, 26, 24, '', 5341.88, 1),
(121, 26, 36, '', 2830, 1),
(122, 26, 35, '', 2830, 1),
(123, 44, 37, '', 2116.8, 1),
(124, 45, 37, 'http://diwar.com.ar/productos/sillas/taburete/flora/#', 2116.8, 1),
(125, 48, 16, '', 1536.8, 1),
(126, 48, 18, '', 1281.8, 1),
(127, 48, 6, '', 1836, 1),
(128, 48, 39, '', 2386.8, 1),
(129, 56, 18, '', 1626.9, 1),
(130, 56, 16, '', 1839.4, 1),
(131, 56, 6, '', 2322.2, 1),
(132, 56, 39, '', 2689.4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id` int(11) NOT NULL,
  `numero` bigint(20) NOT NULL,
  `articulo` int(11) NOT NULL,
  `color_red` int(11) DEFAULT NULL,
  `color_tapizado` int(11) DEFAULT NULL,
  `color_casco` int(11) DEFAULT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL,
  `precio_a_la_emision` double DEFAULT 0,
  `descuento_articulo` double DEFAULT 0,
  `fecha_emision` timestamp NULL DEFAULT NULL,
  `fecha_actualizacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `emitido` tinyint(4) NOT NULL DEFAULT 0,
  `variaciones` varchar(255) DEFAULT NULL,
  `colores` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `presupuestos`
--

INSERT INTO `presupuestos` (`id`, `numero`, `articulo`, `color_red`, `color_tapizado`, `color_casco`, `cantidad`, `precio_a_la_emision`, `descuento_articulo`, `fecha_emision`, `fecha_actualizacion`, `emitido`, `variaciones`, `colores`) VALUES
(12, 1, 1, NULL, NULL, NULL, 1, 8382, 0, '2018-05-13 02:35:53', '2018-05-13 02:35:53', 1, '15, 17, 19, 22, 24', NULL),
(13, 1, 3, 47, 13, NULL, 1, 6678, 0, '2018-05-13 02:35:54', '2018-05-13 02:35:54', 1, '22, 24', NULL),
(14, 1, 3, 42, 12, NULL, 1, 6678, 0, '2018-05-13 02:35:54', '2018-05-13 02:35:54', 1, '22, 24', NULL),
(16, 1, 3, 40, 14, NULL, 1, 6678, 0, '2018-05-13 02:35:54', '2018-05-13 02:35:54', 1, '22, 24', NULL),
(17, 1, 1, 46, 4, NULL, 1, 7282, 0, '2018-05-13 02:35:54', '2018-05-13 02:35:54', 1, '15, 18, 19, 22, 24', NULL),
(18, 2, 1, 40, 14, NULL, 1, 7189.6, 5, '2018-05-13 14:52:00', '2018-05-13 14:52:00', 1, '5, 17, 19, 22, 24', NULL),
(19, 3, 4, 40, 14, NULL, 1, 7203, 0, '2018-06-06 22:56:09', '2018-06-06 22:56:09', 1, '22, 24', NULL),
(22, 4, 6, 40, 14, NULL, 1, 1754.51, 6, '2018-06-01 02:18:45', '2018-06-01 02:18:45', 1, '6, 17, 20, 22, 24', NULL),
(23, 4, 6, 43, 14, NULL, 1, 1754.51, 6, '2018-06-01 02:18:45', '2018-06-01 02:18:45', 1, '6, 17, 20, 22, 24', NULL),
(24, 4, 1, 40, 11, NULL, 1, 7568, 0, '2018-06-01 02:18:45', '2018-06-01 02:18:45', 1, '14, 17, 19, 22, 24', NULL),
(25, 6, 6, 46, 3, NULL, 1, 1866.5, 0, '2018-06-03 23:17:24', '2018-06-03 23:17:24', 1, '6, 17, 19, 22, 24', NULL),
(26, 5, 6, 40, 1, NULL, 1, 728.175, 5, '2018-06-06 23:02:01', '2018-06-06 23:02:01', 1, '5, 18, 19, 22, 24', NULL),
(27, 8, 3, 46, 1, NULL, 1, 6678, 0, '2018-06-06 23:03:20', '2018-06-06 23:03:20', 1, '22, 24', NULL),
(28, 9, 7, 46, 14, NULL, 1, 7444.5, 0, '2018-06-06 23:04:43', '2018-06-06 23:04:43', 1, '22, 24', NULL),
(29, 11, 66, NULL, NULL, NULL, 1, 766.5, 0, '2018-06-27 21:50:29', '2018-06-27 21:50:29', 1, '', NULL),
(30, 11, 6, 41, 14, NULL, 1, 2141.5, 0, '2018-06-27 21:50:29', '2018-06-27 21:50:29', 1, '7, 17, 19, 22, 24', NULL),
(31, 14, 92, NULL, 12, NULL, 1, 0, 0, NULL, '2018-06-13 13:19:08', 0, '5, 22', NULL),
(33, 11, 67, NULL, NULL, NULL, 1, 5940, 0, '2018-06-27 21:50:29', '2018-06-27 21:50:29', 1, '12', ''),
(34, 11, 77, NULL, NULL, NULL, 1, 0, 0, '2018-06-27 21:50:29', '2018-06-27 21:50:29', 1, '', ''),
(35, 17, 67, NULL, NULL, NULL, 1, 5940, 0, '2018-06-27 22:11:21', '2018-06-27 22:11:21', 1, '12', ''),
(36, 17, 68, NULL, NULL, NULL, 1, 1200, 0, '2018-06-27 22:11:21', '2018-06-27 22:11:21', 1, '10', ''),
(37, 18, 67, NULL, NULL, NULL, 1, 5940, 0, '2018-06-27 23:23:16', '2018-06-27 23:23:16', 1, '12', ''),
(38, 19, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:08:52', '2018-06-29 12:08:52', 1, '5, 17, 22', '14'),
(39, 19, 89, NULL, NULL, NULL, 1, 6247.44, 0, '2018-06-29 12:08:52', '2018-06-29 12:08:52', 1, '7, 17, 23', '26'),
(40, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:19', '2018-06-29 12:31:19', 1, '5, 17, 22', '3'),
(41, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '5, 17, 22', '3'),
(42, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '5, 17, 22', '3'),
(43, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '5, 17, 22', '3'),
(44, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '5, 17, 22', '3'),
(45, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '5, 17, 22', '3'),
(46, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '5, 17, 22', '3'),
(47, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '5, 17, 22', '3'),
(48, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '5, 17, 22', '3'),
(49, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '5, 17, 22', '3'),
(50, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '5, 17, 22', '3'),
(51, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '5, 17, 22', '3'),
(52, 20, 84, NULL, NULL, NULL, 1, 5544.44, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '5, 17, 22', '3'),
(53, 20, 67, NULL, NULL, NULL, 1, 5940, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '12', ''),
(54, 20, 67, NULL, NULL, NULL, 1, 5940, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '12', ''),
(55, 20, 67, NULL, NULL, NULL, 1, 5940, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '12', ''),
(56, 20, 67, NULL, NULL, NULL, 1, 5940, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '12', ''),
(57, 20, 67, NULL, NULL, NULL, 1, 5940, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '12', ''),
(58, 20, 67, NULL, NULL, NULL, 1, 5940, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '12', ''),
(59, 20, 67, NULL, NULL, NULL, 1, 5940, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '12', ''),
(60, 20, 67, NULL, NULL, NULL, 1, 5940, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '12', ''),
(61, 20, 67, NULL, NULL, NULL, 1, 5940, 0, '2018-06-29 12:31:20', '2018-06-29 12:31:20', 1, '12', '');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL DEFAULT 'vendedor',
  `vendedor` int(11) DEFAULT NULL,
  `usuario` varchar(255) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `en_uso` tinyint(4) DEFAULT 1,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `vendedor`, `usuario`, `clave`, `en_uso`, `nombre`) VALUES
(2, 'administrador', NULL, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, NULL),
(3, 'vendedor', 1, 'vendeuno', '99d1ee797e678c14be622d903a363042', 1, 'vendedor 1'),
(4, 'administrador', NULL, 'admini2', '5a93108eca184a842047d0e8f33dd3f4', 1, 'admini2'),
(5, 'vendedor', 2, 'vendedos', 'f5b4a703f7f2b9a91f5b32ae52cbecb9', 1, 'vendedor 2'),
(6, 'vendedor', 5, 'rmartin', '968c68f07633a2dc9be1ab6725746c6b', 1, 'Rodrigo Martin ');

-- --------------------------------------------------------

--
-- Table structure for table `variaciones`
--

CREATE TABLE `variaciones` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `precio` double NOT NULL DEFAULT 0,
  `en_uso` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `variaciones`
--

INSERT INTO `variaciones` (`id`, `tipo`, `nombre`, `descripcion`, `precio`, `en_uso`) VALUES
(5, 'brazo', '550', 'con brazo 550,', 275, 1),
(6, 'brazo', '670', 'con brazo 670,', 275, 1),
(7, 'brazo', '680', 'con brazo 680,', 275, 1),
(8, 'brazo', '338C', 'con brazo 338 cromado, ', 1000, 1),
(9, 'brazo', '338N', 'con brazo 338 negro, ', 720, 1),
(10, 'brazo', '340C', 'con brazo 340 cromado,', 1200, 1),
(11, 'brazo', '340N', 'con brazo 340 negro,', 900, 1),
(12, 'brazo', '342C', 'con brazo 342 cromado,', 920, 1),
(13, 'brazo', '342N', 'con brazo 342 negro,', 720, 1),
(14, 'brazo', '350PP', 'con brazo 350pp,', 308, 1),
(15, 'brazo', '405PP', 'Brazo regulable en altura Mod. 405 PP', 814, 1),
(16, 'brazo', '405PU', 'Brazo regulable en altura Mod. 405 PU', 894, 1),
(17, 'estrella', 'BTRC660', 'Estrella cromada de 5 ramas ', 1380, 1),
(18, 'estrella', 'Citiz', '', 0, 1),
(19, 'rueda', 'RT900', 'con rueadas de doble rodamiento.', 0, 1),
(20, 'rueda', 'RT900 Parquet', '', 0, 1),
(21, 'rueda', 'Patines', '', 0, 1),
(22, 'tapizado', 'Marathon', 'Tapizado en marathon', 0, 1),
(23, 'tapizado', 'Eco cuero', 'Tapizado en eco cuero', 0, 1),
(24, 'red', 'red', 'Red color', 0, 1),
(25, 'casco', 'test', 'test', 56, 0),
(26, 'estrella', 'BAR197', 'estrella de 5 rayos con ruedas de doble rodamiento.', 0, 1),
(27, 'estrella', 'BAR198', 'estralla de 5 rayos.', 0, 1),
(28, 'Cascos', '600', 'Casco melaminico ', 0, 1),
(29, 'brazo', '201', 'brazo 201,', 500, 1),
(30, 'estrella', 'Mint', 'estrella de 5 rayos,', 0, 1),
(31, 'estrella', 'Tyson', 'estrella de 5 rayos,', 0, 1),
(33, 'estrella', 'BAP 120', 'estrella de 5 rayos con alma de hierro,', 0, 1),
(35, 'estrella', 'BAP120', 'estrella de 5 rayos con alma de hierro,', 0, 1),
(39, 'estrella', 'BTRC600', 'estralla de 5 rayos cromada,', 1260, 1),
(40, 'estrella', 'BTEC600', 'estrella de 5 rayos cromada,', 0, 1),
(42, 'estrella', 'BTEC660', 'estrella de 5 rayos cromada,', 1260, 1),
(44, 'red', 'azul', 'respaldo de red Azul,', 0, 1),
(45, 'red', 'Vison', 'respaldo de red Vison,', 0, 1),
(46, 'red', 'Gris Perla', 'respaldo de red Gris Perla,', 0, 1),
(47, 'red', 'Naranaja', 'respaldo de red Naranja,', 0, 1),
(48, 'red', 'Negra', 'respaldo de red Negra,', 0, 1),
(49, 'red', 'Petroleo', 'respaldo de red Petroleo,', 0, 1),
(50, 'red', 'Roja', 'respaldo de red Roja,', 0, 1),
(51, 'red', 'Verde', 'respaldo de red Verde,', 0, 1),
(52, 'brazo', '339n', 'con brazo 339 negro,', 1020, 1),
(53, 'brazo', '339C', 'con brazo 339 cromado,', 1320, 1),
(54, 'estrella', 'Cromo para diseño', 'Estrella cromada de 5 rayos, ', 850, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendedores`
--

CREATE TABLE `vendedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `localidad` varchar(255) NOT NULL,
  `provincia` varchar(255) NOT NULL,
  `observaciones` text NOT NULL,
  `en_uso` tinyint(4) NOT NULL DEFAULT 1,
  `codigo_postal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vendedores`
--

INSERT INTO `vendedores` (`id`, `nombre`, `telefono`, `mail`, `direccion`, `localidad`, `provincia`, `observaciones`, `en_uso`, `codigo_postal`) VALUES
(1, 'vendedor 1', '234', 'test', 'test', 'test', 'test', 'observaciones', 1, '1419'),
(2, 'vendedor 2', '213', 'test', 'test', 'test', 'test', 'Observaciones de prueba para el segundo vendedor, escribiendo bastatne para ver como sale.', 1, '1111'),
(3, 'Vendedor 3', 'teléfono de prueba', 'mail de prueba', 'dire de prueba', 'localidad de prueba', 'provincia', '', 1, '1222'),
(4, 'Vendedor 3', 'teléfono de prueba', 'mail de prueba', 'dire de prueba', 'localidad de prueba', 'provincia', '', 1, '1222'),
(5, 'Rodrigo Martin ', '54 1133221615', 'rodrigo@diwar.com.ar', 'Lacroze 4735', 'Villa Ballester ', 'Bs. As.', '', 1, '1653');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modelo_con_mecanismo` (`modelo_con_mecanismo`,`variaciones`),
  ADD KEY `modelos_con_mecanismo` (`modelo_con_mecanismo`),
  ADD KEY `variaciones` (`variaciones`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CUIT` (`CUIT`);

--
-- Indexes for table `clientes_vendedores`
--
ALTER TABLE `clientes_vendedores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `codigos_de_articulo`
--
ALTER TABLE `codigos_de_articulo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modelo_con_mecanismo` (`modelo_con_mecanismo`,`variaciones`);

--
-- Indexes for table `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_colores` (`tipo`,`nombre`);

--
-- Indexes for table `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `datos_presupuesto`
--
ALTER TABLE `datos_presupuesto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero` (`numero`);

--
-- Indexes for table `direcciones_entrega`
--
ALTER TABLE `direcciones_entrega`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mecanismos`
--
ALTER TABLE `mecanismos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_modelos` (`nombre`);

--
-- Indexes for table `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_modelos` (`tipo`,`nombre`);

--
-- Indexes for table `modelos_con_mecanismo`
--
ALTER TABLE `modelos_con_mecanismo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_modelo_mecanismo` (`modelo`,`mecanismo`),
  ADD KEY `mecanismos` (`mecanismo`);

--
-- Indexes for table `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `numero` (`numero`),
  ADD KEY `articulo` (`articulo`),
  ADD KEY `color_red` (`color_red`),
  ADD KEY `color_casco` (`color_casco`),
  ADD KEY `color_tapizado` (`color_tapizado`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `vendedor` (`vendedor`);

--
-- Indexes for table `variaciones`
--
ALTER TABLE `variaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_modelos` (`tipo`,`nombre`);

--
-- Indexes for table `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `clientes_vendedores`
--
ALTER TABLE `clientes_vendedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `codigos_de_articulo`
--
ALTER TABLE `codigos_de_articulo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `colores`
--
ALTER TABLE `colores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `datos_presupuesto`
--
ALTER TABLE `datos_presupuesto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `direcciones_entrega`
--
ALTER TABLE `direcciones_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `mecanismos`
--
ALTER TABLE `mecanismos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `modelos_con_mecanismo`
--
ALTER TABLE `modelos_con_mecanismo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `variaciones`
--
ALTER TABLE `variaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`modelo_con_mecanismo`) REFERENCES `modelos_con_mecanismo` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `variaciones` FOREIGN KEY (`variaciones`) REFERENCES `variaciones` (`id`);

--
-- Constraints for table `modelos_con_mecanismo`
--
ALTER TABLE `modelos_con_mecanismo`
  ADD CONSTRAINT `modelos_con_mecanismo_ibfk_1` FOREIGN KEY (`modelo`) REFERENCES `modelos` (`id`),
  ADD CONSTRAINT `modelos_con_mecanismo_ibfk_2` FOREIGN KEY (`mecanismo`) REFERENCES `mecanismos` (`id`);

--
-- Constraints for table `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD CONSTRAINT `color_casco` FOREIGN KEY (`color_casco`) REFERENCES `colores` (`id`),
  ADD CONSTRAINT `color_red` FOREIGN KEY (`color_red`) REFERENCES `colores` (`id`),
  ADD CONSTRAINT `color_tapizado` FOREIGN KEY (`color_tapizado`) REFERENCES `colores` (`id`),
  ADD CONSTRAINT `presupuestos_ibfk_1` FOREIGN KEY (`articulo`) REFERENCES `modelos_con_mecanismo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
