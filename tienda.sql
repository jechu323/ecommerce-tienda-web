-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 26-07-2026 a las 17:54:47
-- Versión del servidor: 10.4.10-MariaDB
-- Versión de PHP: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre`, `email`, `direccion`) VALUES
(1, 'maria jesus riquelme', 'mjesusriquelmelopez@gmail.com', '5 norte 323 depto 1'),
(2, 'paulina andrea soto', 'paulinasotodelgadillo@gmail.com', '2 poniente 837 depto 402'),
(3, 'manuel jorquera', 'manuel.jorquerasoto@gmail.com', 'edison 4382, quinta normal'),
(4, 'Sebastian', 'sebastian.alvcort@gmail.com', 'Alfredo Barros Errazuriz Providencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

DROP TABLE IF EXISTS `compra`;
CREATE TABLE IF NOT EXISTS `compra` (
  `id_compra` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_compra`),
  KEY `id_producto` (`id_producto`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id_compra`, `cantidad`, `total`, `fecha`, `id_producto`, `id_cliente`) VALUES
(1, 1, 989000, '2026-07-13', 1, 1),
(2, 1, 39990, '2026-07-11', 2, 2),
(3, 1, 299000, '2026-07-13', 3, 3),
(4, 1, 39990, '2026-07-10', 2, 1),
(5, 1, 299000, '2026-07-13', 3, 2),
(6, 1, 989000, '2026-07-11', 1, 3),
(7, 1, 39990, '2026-07-05', 2, 2),
(8, 1, 989000, '2026-07-13', 1, 3),
(9, 1, 989000, '2026-07-13', 1, 1),
(10, 1, 299000, '2026-07-13', 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`) VALUES
(1, 'notebook asus tuf f15', 'notebook gamer', 989000, 20, NULL),
(2, 'mouse logitech g305', 'mouse inalambrico', 39990, 35, NULL),
(3, 'smart tv lg 42 pulgadas', 'smart tv 42 pulgadas 4k', 299000, 15, NULL),
(4, 'Notebook Lenovo T480', 'Windows 10', 450000, 3, NULL),
(5, 'Notebook Lenovo T480', 'Laptop con Windows 11', 500000, 3, 'producto_6a664959a119b.webp');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
