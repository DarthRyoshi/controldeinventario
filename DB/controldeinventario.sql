-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2025 a las 15:05:25
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
-- Base de datos: `controldeinventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `prestamo_id` int(11) DEFAULT NULL,
  `accion` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `prestamo_id`, `accion`, `descripcion`, `fecha`, `usuario_id`, `producto_id`) VALUES
(0, 42, 'CREAR PRÉSTAMO', 'Jadir Hussein le prestó los siguientes insumos a Pepito rojas: Epson l3250 (Serial: LIAOH-BKSGF), Lenovo ThinkCentre M720s (Serial: LTM720S-BX9K8Z)', '2025-10-06 15:36:09', 17, NULL),
(0, 42, 'DEVOLUCIÓN PRÉSTAMO', 'Registro de devolución del préstamo de Pepito rojas: Epson l3250 (Serial: LIAOH-BKSGF), Lenovo ThinkCentre M720s (Serial: LTM720S-BX9K8Z)', '2025-10-06 15:36:16', 17, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-06 15:55:01', 17, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-13 11:42:05', 17, NULL),
(0, 43, 'CREAR PRÉSTAMO', 'Jadir Hussein le prestó los siguientes insumos a Jeremiah Ajmeh: Epson l3250 (Serial: LIAOH-BKSGF), Lenovo IdeaPad 3 15ITL6 (Serial: LIP315-8D3V2S), AOC 22B1HS (Serial: AOC22B-2L7G9H)', '2025-10-13 12:13:51', 17, NULL),
(0, 44, 'CREAR PRÉSTAMO', 'Jadir Hussein le prestó los siguientes insumos a Pepito rojas: Microsoft Basic Optical Mouse (Serial: MSBOM-5K4T9P), HP X1000 Wired Mouse (Serial: HPX1000-D7L2V3)', '2025-10-13 12:14:02', 17, NULL),
(0, 43, 'DEVOLUCIÓN PRÉSTAMO', 'Registro de devolución del préstamo de Jeremiah Ajmeh: Epson l3250 (Serial: LIAOH-BKSGF), Lenovo IdeaPad 3 15ITL6 (Serial: LIP315-8D3V2S), AOC 22B1HS (Serial: AOC22B-2L7G9H)', '2025-10-13 12:14:18', 17, NULL),
(0, 44, 'DEVOLUCIÓN PRÉSTAMO', 'Registro de devolución del préstamo de Pepito rojas: Microsoft Basic Optical Mouse (Serial: MSBOM-5K4T9P), HP X1000 Wired Mouse (Serial: HPX1000-D7L2V3)', '2025-10-13 12:14:23', 17, NULL),
(0, 45, 'CREAR PRÉSTAMO', 'Jadir Hussein le prestó los siguientes insumos a Pepito rojas: Epson l3250 (Serial: LIAOH-BKSGF), Dell OptiPlex 7070 Micro (Serial: D7070M-Q4R2F1)', '2025-10-13 13:21:18', 17, NULL),
(0, 45, 'DEVOLUCIÓN PRÉSTAMO', 'Registro de devolución del préstamo de Pepito rojas: Epson l3250 (Serial: LIAOH-BKSGF), Dell OptiPlex 7070 Micro (Serial: D7070M-Q4R2F1)', '2025-10-13 13:21:28', 17, NULL),
(0, 46, 'CREAR PRÉSTAMO', 'Jadir Hussein le prestó los siguientes insumos a Jeremiah Ajmeh: Epson l3250 (Serial: LIAOH-BKSGF), Asus Vivo AiO V222FAK (Serial: AIV222-7G8X2J), LG 22MK430H-B (Serial: LG2242-9M7D1Q), HP X1000 Wired Mouse (Serial: HPX1000-D7L2V3)', '2025-10-13 13:23:55', 17, NULL),
(0, 46, 'DEVOLUCIÓN PRÉSTAMO', 'Registro de devolución del préstamo de Jeremiah Ajmeh: Epson l3250 (Serial: LIAOH-BKSGF), Asus Vivo AiO V222FAK (Serial: AIV222-7G8X2J), LG 22MK430H-B (Serial: LG2242-9M7D1Q), HP X1000 Wired Mouse (Serial: HPX1000-D7L2V3)', '2025-10-13 13:24:14', 17, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-13 13:26:13', 17, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-13 16:23:46', 17, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-13 16:42:04', 17, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-13 18:13:00', 17, NULL),
(0, NULL, 'CREAR PRODUCTO', 'Se creó el producto Epson L3250 con serial X9F4K-72LMQ-0D8VN-A5ZCX-1RPTB', '2025-10-13 18:27:34', 17, 1),
(0, NULL, 'EDITAR PRODUCTO', 'Se editó el producto Epson l3250  (ID 37)', '2025-10-13 18:32:27', 17, 37),
(0, 47, 'CREAR PRÉSTAMO', 'Jadir Hussein le prestó los siguientes insumos a Jeremiah Ajmeh: Epson l3250  (Serial: X9F4K-72LMQ-0D8VN-A5ZCX-1RPTB)', '2025-10-13 18:52:37', 17, NULL),
(0, 48, 'CREAR PRÉSTAMO', 'Jadir Hussein le prestó los siguientes insumos a Jeremiah Ajmeh: Epson l3250 (Serial: LIAOH-BKSGF)', '2025-10-13 18:52:51', 17, NULL),
(0, 48, 'DEVOLUCIÓN PRÉSTAMO', 'Registro de devolución del préstamo de Jeremiah Ajmeh: ', '2025-10-13 18:52:56', 17, NULL),
(0, 48, 'DEVOLUCIÓN PRÉSTAMO', 'Registro de devolución del préstamo de Jeremiah Ajmeh: Epson l3250 (Serial: LIAOH-BKSGF)', '2025-10-13 18:52:59', 17, NULL),
(0, 47, 'DEVOLUCIÓN PRÉSTAMO', 'Registro de devolución del préstamo de Jeremiah Ajmeh: Epson l3250  (Serial: X9F4K-72LMQ-0D8VN-A5ZCX-1RPTB)', '2025-10-13 18:53:01', 17, NULL),
(0, 49, 'CREAR PRÉSTAMO', 'Jadir Hussein le prestó los siguientes insumos a Pepito rojas: Epson l3250 (Serial: LIAOH-BKSGF)', '2025-10-13 19:14:41', 17, NULL),
(0, 49, 'DEVOLUCIÓN PRÉSTAMO', 'Registro de devolución del préstamo de Pepito rojas: Epson l3250 (Serial: LIAOH-BKSGF)', '2025-10-13 19:17:35', 17, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-14 19:36:28', 17, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-14 19:54:38', 17, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-14 20:09:07', 17, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-14 20:20:00', 17, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-14 20:32:22', 17, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-15 11:43:35', 17, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-15 12:09:19', 17, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-15 12:23:56', 17, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-15 12:26:25', 17, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-15 12:26:31', 28, NULL),
(0, 50, 'CREAR PRÉSTAMO', 'Pepito rojas le prestó los siguientes insumos a Jadir Hussein: Acer Aspire 5 A515-56 (Serial: AAA515-7F4B8M), Asus ZenBook 14 UX425EA (Serial: AZB14-3H9C5L), Lenovo IdeaPad 3 15ITL6 (Serial: LIP315-8D3V2S), Dell OptiPlex 7070 Micro (Serial: D7070M-Q4R2F1)', '2025-10-15 12:26:58', 28, NULL),
(0, 50, 'DEVOLUCIÓN PRÉSTAMO', 'Registro de devolución del préstamo de Jadir Hussein: Acer Aspire 5 A515-56 (Serial: AAA515-7F4B8M), Asus ZenBook 14 UX425EA (Serial: AZB14-3H9C5L), Lenovo IdeaPad 3 15ITL6 (Serial: LIP315-8D3V2S), Dell OptiPlex 7070 Micro (Serial: D7070M-Q4R2F1)', '2025-10-15 12:27:05', 28, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-15 12:53:07', 28, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-15 13:00:40', 17, NULL),
(0, 51, 'CREAR PRÉSTAMO', 'Jadir Hussein le prestó los siguientes insumos a Jeremiah Ajmeh: Epson l3250  (Serial: X9F4K-72LMQ-0D8VN-A5ZCX-1RPTB)', '2025-10-15 14:08:32', 17, NULL),
(0, 51, 'DEVOLUCIÓN PRÉSTAMO', 'Registro de devolución del préstamo de Jeremiah Ajmeh: Epson l3250  (Serial: X9F4K-72LMQ-0D8VN-A5ZCX-1RPTB)', '2025-10-15 14:09:45', 17, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-15 15:29:10', 17, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-15 18:55:01', 17, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-15 19:52:54', 17, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-15 19:59:57', 17, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-15 20:15:08', 17, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-17 04:02:01', 17, NULL),
(0, NULL, 'LOGOUT', 'Cierre de sesión', '2025-10-17 04:02:17', 17, NULL),
(0, NULL, 'LOGIN', 'Ingreso al sistema', '2025-10-17 13:03:51', 17, NULL),
(0, NULL, 'CREAR USUARIO', 'Se creó el usuario administradpr con RUT 1111111-1', '2025-10-17 13:04:30', 17, NULL),
(0, NULL, 'EDITAR USUARIO', 'Se editó el usuario administradpr (ID 31)', '2025-10-17 13:04:39', 17, NULL),
(0, NULL, 'EDITAR USUARIO', 'Se editó el usuario administrador (ID 31)', '2025-10-17 13:04:49', 17, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_prestamos`
--

CREATE TABLE `detalle_prestamos` (
  `id` int(11) NOT NULL,
  `prestamo_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad_prestada` int(11) NOT NULL,
  `cantidad_devuelta` int(11) NOT NULL DEFAULT 0,
  `fecha_devolucion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_prestamos`
--

INSERT INTO `detalle_prestamos` (`id`, `prestamo_id`, `producto_id`, `cantidad_prestada`, `cantidad_devuelta`, `fecha_devolucion`) VALUES
(1, 42, 10, 1, 1, '2025-10-06 12:36:16'),
(2, 42, 15, 1, 1, '2025-10-06 12:36:16'),
(3, 43, 10, 1, 1, '2025-10-13 09:14:18'),
(4, 43, 21, 1, 1, '2025-10-13 09:14:18'),
(5, 43, 27, 1, 1, '2025-10-13 09:14:18'),
(6, 44, 31, 1, 1, '2025-10-13 09:14:23'),
(7, 44, 33, 1, 1, '2025-10-13 09:14:23'),
(8, 45, 10, 1, 1, '2025-10-13 10:21:28'),
(9, 45, 16, 1, 1, '2025-10-13 10:21:28'),
(10, 46, 10, 1, 1, '2025-10-13 10:24:14'),
(11, 46, 17, 1, 1, '2025-10-13 10:24:14'),
(12, 46, 25, 1, 1, '2025-10-13 10:24:14'),
(13, 46, 33, 1, 1, '2025-10-13 10:24:14'),
(14, 47, 37, 1, 1, '2025-10-13 15:53:01'),
(15, 48, 10, 1, 1, '2025-10-13 15:52:59'),
(16, 49, 10, 1, 1, '2025-10-13 16:17:35'),
(17, 50, 22, 1, 1, '2025-10-15 09:27:05'),
(18, 50, 23, 1, 1, '2025-10-15 09:27:05'),
(19, 50, 21, 1, 1, '2025-10-15 09:27:05'),
(20, 50, 16, 1, 1, '2025-10-15 09:27:05'),
(21, 51, 37, 1, 1, '2025-10-15 11:09:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_prestamo` datetime NOT NULL,
  `estado` enum('vigente','completo') NOT NULL DEFAULT 'vigente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `usuario_id`, `fecha_prestamo`, `estado`) VALUES
(42, 28, '2025-10-06 12:36:09', 'completo'),
(43, 29, '2025-10-13 09:13:51', 'completo'),
(44, 28, '2025-10-13 09:14:02', 'completo'),
(45, 28, '2025-10-13 10:21:18', 'completo'),
(46, 29, '2025-10-13 10:23:55', 'completo'),
(47, 29, '2025-10-13 15:52:37', 'completo'),
(48, 29, '2025-10-13 15:52:51', 'completo'),
(49, 28, '2025-10-13 16:14:40', 'completo'),
(50, 17, '2025-10-15 09:26:58', 'completo'),
(51, 29, '2025-10-15 11:08:32', 'completo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `imagen` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `serial` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `categoria`, `stock`, `imagen`, `descripcion`, `estado`, `fecha_creacion`, `serial`) VALUES
(10, 'Epson l3250', 'Impresora', 1, '1758827794_EcoTank-L3250-690x460-1.jpg', 'La Epson EcoTank L3250 es una impresora multifuncional 3 en 1 (impresión, escaneo y copiado) diseñada para ofrecer un bajo costo por página y una experiencia de usuario sencilla, ideal para hogares, estudiantes y pequeñas oficinas.', 'activo', '2025-09-25 19:16:34', 'LIAOH-BKSGF'),
(15, 'Lenovo ThinkCentre M720s', 'Computador De Escritorio', 1, '1758897240_Lenovo_ThinkCentre_M720s.avif', 'Intel Core i5, 8GB RAM, 256GB SSD', 'activo', '2025-09-26 14:34:00', 'LTM720S-BX9K8Z'),
(16, 'Dell OptiPlex 7070 Micro', 'Computador De Escritorio', 1, '1758897291_Dell_OptiPlex_7070_Micro.jpg', 'Intel Core i5, 8GB RAM, 512GB SSD', 'activo', '2025-09-26 14:34:51', 'D7070M-Q4R2F1'),
(17, 'Asus Vivo AiO V222FAK', 'Computador De Escritorio', 1, '1758897323_Asus_Vivo_AiO_V222FAK.jpg', 'Pentium Gold, 4GB RAM, 256GB SSD', 'activo', '2025-09-26 14:35:23', 'AIV222-7G8X2J'),
(18, 'Lenovo IdeaCentre AIO 3 24IAP7', 'Computador De Escritorio', 1, '1758897355_Lenovo_IdeaCentre_AIO_3_24IAP7.jpg', 'Intel Pentium, 8GB RAM, 256GB SSD', 'activo', '2025-09-26 14:35:55', 'HPAIO24-2J7V6C'),
(19, 'Dell Inspiron 15 3511', 'Laptops', 1, '1758897757_Dell_Inspiron_15_3511.webp', 'Intel Core i5, 16GB RAM, 512GB SSD', 'activo', '2025-09-26 14:42:37', 'DLI15-6K2X9R'),
(20, 'HP Pavilion 14', 'Laptops', 1, '1758897833_HP_Pavilion_14.avif', 'AMD Ryzen 5, 8GB RAM, 256GB SSD', 'activo', '2025-09-26 14:43:53', 'HLP14-4B7G1F'),
(21, 'Lenovo IdeaPad 3 15ITL6', 'Laptops', 1, '1758897890_Lenovo_IdeaPad_3_15ITL6.jpg', 'Intel Core i5, 8GB RAM, 512GB SSD', 'activo', '2025-09-26 14:44:50', 'LIP315-8D3V2S'),
(22, 'Acer Aspire 5 A515-56', 'Laptops', 1, '1758897940_Acer_Aspire_5_A515-56.png', 'Intel Core i5, 8GB RAM, 512GB SSD', 'activo', '2025-09-26 14:45:40', 'AAA515-7F4B8M'),
(23, 'Asus ZenBook 14 UX425EA', 'Laptops', 1, '1758898032_Asus_ZenBook_14_UX425EA.jpg', 'Intel Core i7, 16GB RAM, 512GB SSD', 'activo', '2025-09-26 14:47:12', 'AZB14-3H9C5L'),
(25, 'LG 22MK430H-B', 'Monitor', 1, '1758902254_LG_22MK430H-B.avif', '21.5\", IPS, Full HD', 'activo', '2025-09-26 15:57:34', 'LG2242-9M7D1Q'),
(27, 'AOC 22B1HS', 'Monitores', 1, '1758903852_AOC_22B1HS.jpg', '21.5\", IPS, Full HD', 'activo', '2025-09-26 16:24:12', 'AOC22B-2L7G9H'),
(28, 'Genius KB-110X', 'Teclados', 1, '1758903999_Genius_KB-110XGenius_KB-110X.jpg', 'USB, económico', 'activo', '2025-09-26 16:26:39', 'GNKB110X-L6T3V4'),
(29, 'Microsoft Wired Keyboard 600', 'Teclados', 1, '1758904078_Microsoft_Wired_Keyboard_600.jpg', 'USB-Sencillo', 'activo', '2025-09-26 16:27:58', 'MWK600-H3L2P7'),
(30, 'HP K1500', 'Teclados', 1, '1758904175_HP_K1500.jpg', 'USB, resistente', 'activo', '2025-09-26 16:29:35', 'HPK1500-F9R5D1'),
(31, 'Microsoft Basic Optical Mouse', 'Mouse', 1, '1758904738_Microsoft_Basic_Optical_Mouse.jpg', 'USB', 'activo', '2025-09-26 16:38:58', 'MSBOM-5K4T9P'),
(32, 'Genius DX-120', 'Mouse', 1, '1758904782_Genius_DX-120.webp', 'USB', 'activo', '2025-09-26 16:39:42', 'GNDX120-B3H9L1'),
(33, 'HP X1000 Wired Mouse', 'Mouse', 1, '1758904808_HP_X1000_Wired_Mouse.jpg', 'USB', 'activo', '2025-09-26 16:40:08', 'HPX1000-D7L2V3'),
(37, 'Epson l3250 ', 'Impresora', 1, '1760380054_1758827794_EcoTank-L3250-690x460-1.jpg', 'La Epson EcoTank L3250 es una impresora multifuncional 3 en 1 (impresión, escaneo y copiado) diseñada para ofrecer un bajo costo por página y una experiencia de usuario sencilla, ideal para hogares, estudiantes y pequeñas oficinas.\r\n', 'activo', '2025-10-13 18:27:34', 'X9F4K-72LMQ-0D8VN-A5ZCX-1RPTB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id` int(11) NOT NULL,
  `nombre_reporte` varchar(255) NOT NULL,
  `tipo_reporte` enum('PDF','EXCEL') NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_generacion` datetime DEFAULT current_timestamp(),
  `parametros` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reportes`
--

INSERT INTO `reportes` (`id`, `nombre_reporte`, `tipo_reporte`, `ruta_archivo`, `usuario_id`, `fecha_generacion`, `parametros`) VALUES
(23, 'Reporte de Bitácora', 'PDF', 'reporte_bitacora_2025-10-15_15-35-48.pdf', 17, '2025-10-15 10:35:48', '{}'),
(24, 'Reporte de Bitácora', 'PDF', 'reporte_bitacora_2025-10-15_16-10-19.pdf', 17, '2025-10-15 11:10:19', '{}'),
(25, 'Reporte de Bitácora', 'PDF', 'reporte_bitacora_2025-10-15_21-42-08.pdf', 17, '2025-10-15 16:42:08', '{}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('admin','registro','consulta') NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `rut`, `email`, `contrasena`, `rol`, `fecha_creacion`) VALUES
(17, 'Jadir Hussein', '12.059.892-0', 'JHussein@gmail.com', '$2y$10$rb6IHgy8Z0i.P5VL7lG/Z.HQX9CcrmrqrmHqkbF.HaEmKDaS71A2u', 'admin', '2025-09-22 15:52:25'),
(28, 'Pepito rojas', '21.543.789-0', 'pp@gmail.com', '$2y$10$MJ6t.HfNdS2Y08Bv3L3Z8OwatVnsY4ONd64DV/DqxT1cBpBN296Gi', 'admin', '2025-09-30 15:48:42'),
(29, 'Jeremiah Ajmeh', '12.345.678-1', 'ja@gmail.com', '$2y$10$83nhgQCHvhrhg3Vsijs32.rDcCGtMCSJl4NMYxxcS0bJBMeuVn1Tm', 'registro', '2025-09-30 15:49:17'),
(30, 'Diego Diaz', '21.294.443-2', 'dd@gmail.com', '$2y$10$jGU2ihObZ79Rey/K2GvrSu2MHQJdOWSj.3goDiqDyv0HV7AoR/Vuy', 'registro', '2025-09-30 15:49:36'),
(31, 'administrador', '1.111.111-1', 'admin@gmail.com', '$2y$10$D8Hmrb2OF1LST86Y95O37.Wz2X9Nm3IA4XKOpPP0ArFy1G7kU7baa', 'admin', '2025-10-17 13:04:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_prestamos`
--
ALTER TABLE `detalle_prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prestamo_id` (`prestamo_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial` (`serial`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_prestamos`
--
ALTER TABLE `detalle_prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_prestamos`
--
ALTER TABLE `detalle_prestamos`
  ADD CONSTRAINT `detalle_prestamos_ibfk_1` FOREIGN KEY (`prestamo_id`) REFERENCES `prestamos` (`id`),
  ADD CONSTRAINT `detalle_prestamos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `reportes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
