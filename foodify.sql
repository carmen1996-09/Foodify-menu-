-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2026 a las 17:49:02
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
-- Base de datos: `foodify`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierres_caja`
--

CREATE TABLE `cierres_caja` (
  `id_cierre` int(11) NOT NULL,
  `fecha_cierre` datetime NOT NULL DEFAULT current_timestamp(),
  `total_cierre` decimal(10,2) NOT NULL,
  `cantidad_pedidos` int(11) NOT NULL,
  `auditor` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cierres_caja`
--

INSERT INTO `cierres_caja` (`id_cierre`, `fecha_cierre`, `total_cierre`, `cantidad_pedidos`, `auditor`) VALUES
(1, '2026-09-16 13:35:59', 26500.00, 1, 'Gerente Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(1, 1, 2, 1, 26500.00, 26500.00),
(2, 2, 2, 1, 26500.00, 26500.00),
(3, 3, 1, 1, 24900.00, 24900.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `cargo` enum('admin','cocina','caja') NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `id_usuario`, `cargo`, `estado`) VALUES
(1, 2, 'admin', 'activo'),
(2, 3, 'cocina', 'activo'),
(3, 4, 'caja', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `id_envio` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `estado_envio` enum('Pendiente','En camino','Entregado','Cancelado') NOT NULL DEFAULT 'Pendiente',
  `fecha_entrega` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `envio`
--

INSERT INTO `envio` (`id_envio`, `id_pedido`, `direccion`, `estado_envio`, `fecha_entrega`) VALUES
(1, 3, 'Calle 100 #20-30', 'En camino', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `metodo_pago` enum('PSE','Tarjeta de Cr?dito','Pagar en Efectivo','Pagar en Caja') NOT NULL,
  `estado_pago` enum('Pendiente','Pagado','Rechazado') NOT NULL DEFAULT 'Pendiente',
  `banco` varchar(100) DEFAULT NULL,
  `nombre_titular` varchar(150) DEFAULT NULL,
  `documento` varchar(50) DEFAULT NULL,
  `fecha_pago` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id_pago`, `id_pedido`, `metodo_pago`, `estado_pago`, `banco`, `nombre_titular`, `documento`, `fecha_pago`) VALUES
(1, 1, 'Pagar en Efectivo', 'Pagado', NULL, NULL, NULL, '2026-09-16 18:35:52'),
(2, 2, 'Pagar en Efectivo', 'Pendiente', NULL, NULL, NULL, '2026-09-16 18:45:31'),
(3, 3, 'Pagar en Efectivo', 'Pagado', NULL, NULL, NULL, '2026-09-16 18:49:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `tipo_servicio` enum('Domicilio','Comer en el Establecimiento','Para Llevar') NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `estado_pedido` enum('En Cola','En Preparacion','Despachado','Cancelado') NOT NULL DEFAULT 'En Cola',
  `id_cierre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `fecha_pedido`, `total`, `tipo_servicio`, `direccion`, `estado_pedido`, `id_cierre`) VALUES
(1, 1, '2026-09-16 18:34:06', 26500.00, 'Para Llevar', NULL, 'Despachado', 1),
(2, 1, '2026-09-16 18:45:31', 26500.00, 'Para Llevar', NULL, 'Despachado', NULL),
(3, 1, '2026-09-16 18:47:36', 24900.00, 'Domicilio', 'Calle 100 #20-30', 'Despachado', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `ingredientes` text DEFAULT NULL,
  `imagen` varchar(500) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `categoria`, `precio`, `descripcion`, `stock`, `ingredientes`, `imagen`, `visible`, `fecha_creacion`) VALUES
(1, 'Hamburguesa Monster Cheese', 'hamburguesas', 24900.00, 'Doble carne angus, queso cheddar fundido y salsa secreta.', 9, 'Carne Angus, Cheddar', 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500', 1, '2026-09-14 16:28:44'),
(2, 'Hamburguesa BBQ Bacon', 'hamburguesas', 26500.00, 'Tocino ahumado, aros de cebolla crocantes y salsa BBQ.', 13, 'Carne Res, Tocino', 'https://images.unsplash.com/photo-1553979459-d2229ba7433b?w=500', 1, '2026-09-14 16:28:44'),
(3, 'Pizza Pepperoni Supreme', 'pizzas', 32000.00, 'Masa italiana artesanal con abundante pepperoni madurado.', 9, 'Pepperoni, Mozzarella', 'https://images.unsplash.com/photo-1628840042765-356cda07504e?w=500', 1, '2026-09-14 16:28:44'),
(4, 'Alitas BBQ Crujientes', 'alitas', 20000.00, 'Ba?adas en salsa de barbacoa dulce ahumada.', 55, 'Alitas x8, BBQ', 'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?w=500', 1, '2026-09-14 16:28:44'),
(5, 'Papas Nativas Especiales', 'acompañamientos', 12500.00, 'Papas r?sticas con tocineta picada y queso cheddar.', 30, 'Papas, Cheddar', 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=500', 1, '2026-09-14 16:28:44'),
(6, 'Perro Americano Gigante', 'perros calientes', 15900.00, 'Salchicha suiza de 22cm con papa ripiada.', 14, 'Salchicha Suiza, Ripio', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJH54C02cZmm_OKCIT4jX1kg9dULUNHPcexehf73DZeg&s=10', 1, '2026-09-14 16:28:44'),
(7, 'Limonada de Coco Fresh', 'bebidas', 8500.00, 'Zumo de lim?n natural batido con crema de coco espesa.', 20, 'Limón, Coco', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=500', 1, '2026-09-14 16:28:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('cliente','admin','cocina','caja') NOT NULL DEFAULT 'cliente',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `correo`, `contrasena`, `rol`, `fecha_registro`) VALUES
(1, 'si', 'si1@gmail.com', '$2y$10$vrnoA810UtCuvu8gHLFncuL5vWMT9AILTfhit9eX8BT4hXtxbK1mC', 'cliente', '2026-09-16 18:33:52'),
(2, 'Gerente Admin', 'admin@foodify.com', 'admin123', 'admin', '2026-09-16 18:38:23'),
(3, 'Jefe de Cocina', 'cocina@foodify.com', 'cocina123', 'cocina', '2026-09-16 18:38:23'),
(4, 'Cajero Central', 'caja@foodify.com', 'caja123', 'caja', '2026-09-16 18:38:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cierres_caja`
--
ALTER TABLE `cierres_caja`
  ADD PRIMARY KEY (`id_cierre`);

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
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `fk_empleado_usuario` (`id_usuario`);

--
-- Indices de la tabla `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`id_envio`),
  ADD KEY `fk_envio_pedido` (`id_pedido`);

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
  ADD KEY `fk_pedido_usuario` (`id_usuario`),
  ADD KEY `fk_pedido_cierre` (`id_cierre`);

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cierres_caja`
--
ALTER TABLE `cierres_caja`
  MODIFY `id_cierre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `envio`
--
ALTER TABLE `envio`
  MODIFY `id_envio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `fk_detalle_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_empleado_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `envio`
--
ALTER TABLE `envio`
  ADD CONSTRAINT `fk_envio_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_pago_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedido_cierre` FOREIGN KEY (`id_cierre`) REFERENCES `cierres_caja` (`id_cierre`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
