-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-08-2026 a las 20:08:49
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
-- Base de datos: `diagrama_relacional`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` varchar(4) NOT NULL,
  `id_pedido` varchar(4) NOT NULL,
  `id_producto` varchar(4) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad`, `precio`, `total`) VALUES
('D501', 'O301', 'P401', 2, 15000.00, 30000.00),
('D502', 'O302', 'P402', 1, 45000.00, 45000.00),
('D503', 'O303', 'P403', 3, 7000.00, 21000.00),
('D504', 'O304', 'P409', 1, 48000.00, 48000.00),
('D505', 'O305', 'P405', 1, 15000.00, 15000.00),
('D506', 'O306', 'P409', 1, 48000.00, 48000.00),
('D507', 'O307', 'P404', 2, 13500.00, 27000.00),
('D508', 'O308', 'P401', 1, 15000.00, 15000.00),
('D509', 'O309', 'P408', 3, 12000.00, 36000.00),
('D510', 'O310', 'P410', 1, 19000.00, 19000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` varchar(4) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `nombre`, `cargo`, `celular`) VALUES
('E101', 'Pedro Sanchez', 'Vendedor', '3101112233'),
('E102', 'Ana Morales', 'Cajero', '3102223344'),
('E103', 'Luis Vargas', 'Repartidor', '3103334455'),
('E104', 'Sofia Jimenez', 'Vendedor', '3104445566'),
('E105', 'Miguel Ortiz', 'Repartidor', '3105556677'),
('E106', 'Daniela Ruiz', 'Supervisor', '3106667788'),
('E107', 'Javier Mendez', 'Cajero', '3107778899'),
('E108', 'Paula Guerrero', 'Vendedor', '3108889900'),
('E109', 'Ricardo Nunez', 'Repartidor', '3109990011'),
('E110', 'Carolina Vega', 'Supervisor', '3110001122');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `id_envio` varchar(4) NOT NULL,
  `id_pedido` varchar(4) NOT NULL,
  `id_empleado` varchar(4) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `envio`
--

INSERT INTO `envio` (`id_envio`, `id_pedido`, `id_empleado`, `fecha`, `estado`) VALUES
('S601', 'O301', 'E103', '2026-07-01', 'Entregado'),
('S602', 'O302', 'E103', '2026-07-02', 'Cancelado'),
('S603', 'O303', 'E105', '2026-07-03', 'En camino'),
('S604', 'O304', 'E105', '2026-07-04', 'Entregado'),
('S605', 'O305', 'E103', '2026-07-05', 'Pendiente'),
('S606', 'O306', 'E109', '2026-07-06', 'Entregado'),
('S607', 'O307', 'E109', '2026-07-07', 'Retrasado'),
('S608', 'O308', 'E103', '2026-07-08', 'Entregado'),
('S609', 'O309', 'E105', '2026-07-09', 'Cancelado'),
('S610', 'O310', 'E109', '2026-07-10', 'En camino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` varchar(4) NOT NULL,
  `id_pedido` varchar(4) NOT NULL,
  `metodo_pago` varchar(30) NOT NULL,
  `fecha_pago` date NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id_pago`, `id_pedido`, `metodo_pago`, `fecha_pago`, `monto`, `estado`) VALUES
('2001', 'O301', 'Efectivo', '2026-07-01', 35000.00, 'Confirmado'),
('2002', 'O302', 'Tarjeta', '2026-07-02', 52000.00, 'Reembolsado'),
('2003', 'O303', 'Nequi', '2026-07-03', 21000.00, 'Pendiente'),
('2004', 'O304', 'Tarjeta', '2026-07-04', 48000.00, 'Confirmado'),
('2005', 'O305', 'Efectivo', '2026-07-05', 15000.00, 'Pendiente'),
('2006', 'O306', 'Daviplata', '2026-07-06', 48000.00, 'Confirmado'),
('2007', 'O307', 'Tarjeta', '2026-07-07', 27000.00, 'Rechazado'),
('2008', 'O308', 'Efectivo', '2026-07-08', 33000.00, 'Confirmado'),
('2009', 'O309', 'Nequi', '2026-07-09', 41000.00, 'Reembolsado'),
('2010', 'O310', 'Tarjeta', '2026-07-10', 19000.00, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` varchar(4) NOT NULL,
  `id_usuario` bigint(20) NOT NULL,
  `id_empleado` varchar(4) DEFAULT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `tipo_entrega` varchar(30) DEFAULT NULL,
  `id_pago` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `id_empleado`, `estado`, `total`, `tipo_entrega`, `id_pago`) VALUES
('O301', 1010234567, 'E101', 'Entregado', 35000.00, 'Domicilio', '2001'),
('O302', 1020345678, 'E102', 'Cancelado', 52000.00, 'Recoger en tienda', '2002'),
('O303', 1030456789, 'E103', 'En proceso', 21000.00, 'Domicilio', '2003'),
('O304', 1040567890, 'E101', 'Entregado', 48000.00, 'Domicilio', '2004'),
('O305', 1050678901, 'E104', 'Pendiente', 15000.00, 'Recoger en tienda', '2005'),
('O306', 1060789012, 'E105', 'Entregado', 48000.00, 'Domicilio', '2006'),
('O307', 1070890123, 'E102', 'En proceso', 27000.00, 'Domicilio', '2007'),
('O308', 1080901234, 'E103', 'Entregado', 33000.00, 'Recoger en tienda', '2008'),
('O309', 1091012345, 'E101', 'Cancelado', 41000.00, 'Domicilio', '2009'),
('O310', 1101123456, 'E104', 'En proceso', 19000.00, 'Recoger en tienda', '2010');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` varchar(4) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `descripcion`, `precio`, `estado`) VALUES
('P401', 'Hamburguesa Clasica', 'Carne, queso, lechuga y tomate', 15000.00, 'Activo'),
('P402', 'Pizza Familiar', 'Pizza de 8 porciones sabor mixto', 45000.00, 'Agotado'),
('P403', 'Perro Caliente', 'Salchicha con papas y salsas', 7000.00, 'Activo'),
('P404', 'Ensalada Cesar', 'Lechuga, pollo, crutones y aderezo', 13500.00, 'Inactivo'),
('P405', 'Papas Fritas', 'Porcion grande de papas', 15000.00, 'Activo'),
('P406', 'Gaseosa 500ml', 'Bebida gaseosa sabor cola', 5000.00, 'Agotado'),
('P407', 'Jugo Natural', 'Jugo de fruta natural 400ml', 6000.00, 'Activo'),
('P408', 'Postre Brownie', 'Brownie de chocolate con helado', 12000.00, 'Descontinuado'),
('P409', 'Combo Familiar', 'Incluye 2 hamburguesas y papas', 48000.00, 'Activo'),
('P410', 'Wrap de Pollo', 'Tortilla con pollo y vegetales', 19000.00, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` bigint(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `correo`, `celular`, `direccion`, `contrasena`) VALUES
(1010234567, 'Carlos', 'Ramirez', 'carlos.ramirez@mail.com', '3001112233', 'Calle 100 # 15-23', 'clave123'),
(1020345678, 'Maria', 'Gonzalez', 'maria.gonzalez@mail.com', '3002223344', 'Carrera 7 # 45-10', 'clave456'),
(1030456789, 'Andres', 'Lopez', 'andres.lopez@mail.com', '3003334455', 'Calle 26 # 68-90', 'clave789'),
(1040567890, 'Laura', 'Martinez', 'laura.martinez@mail.com', '3004445566', 'Carrera 15 # 127-45', 'clave321'),
(1050678901, 'Juan', 'Perez', 'juan.perez@mail.com', '3005556677', 'Calle 80 # 70-12', 'clave654'),
(1060789012, 'Camila', 'Torres', 'camila.torres@mail.com', '3006667788', 'Diagonal 45 # 13-05', 'clave987'),
(1070890123, 'Diego', 'Rojas', 'diego.rojas@mail.com', '3007778899', 'Transversal 23 # 53-18', 'clave159'),
(1080901234, 'Valentina', 'Diaz', 'valentina.diaz@mail.com', '3008889900', 'Calle 170 # 8-30', 'clave753'),
(1091012345, 'Santiago', 'Herrera', 'santiago.herrera@mail.com', '3009990011', 'Carrera 30 # 22-04', 'clave852'),
(1101123456, 'Isabella', 'Castro', 'isabella.castro@mail.com', '3010001122', 'Calle 53 # 10-25', 'clave951');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_detalle_pedido` (`id_pedido`),
  ADD KEY `fk_detalle_producto` (`id_producto`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`id_envio`),
  ADD KEY `fk_envio_pedido` (`id_pedido`),
  ADD KEY `fk_envio_empleado` (`id_empleado`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `fk_pago_pedido` (`id_pedido`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedidos_usuario` (`id_usuario`),
  ADD KEY `fk_pedidos_empleado` (`id_empleado`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `fk_detalle_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `envio`
--
ALTER TABLE `envio`
  ADD CONSTRAINT `fk_envio_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `fk_envio_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_pago_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
