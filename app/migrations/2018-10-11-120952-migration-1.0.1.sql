-- New column added to usuarios table
/*
ALTER TABLE pruebas
ADD COLUMN nombre VARCHAR(255) NULL,
ADD COLUMN email VARCHAR(255) NULL,
ADD COLUMN direccion VARCHAR(255) NULL,
ADD COLUMN telefono VARCHAR(255) NULL,
ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- 1.0.1 migration
ALTER TABLE usuarios
ADD COLUMN firma VARCHAR(255) NULL AFTER perfil;

ALTER TABLE servicios
ADD COLUMN id_contrato BIGINT(20) NULL AFTER tipo_servicio;

-- DROP TABLE IF EXISTS `jserp_contratos`;
CREATE TABLE `jserp_contratos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `folio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_cliente` bigint(20) DEFAULT NULL,
  `rep_legal` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `detalles` text COLLATE utf8_unicode_ci,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_termino` datetime DEFAULT NULL,
  `preventivos` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mensualidades` int(5) DEFAULT NULL,
  `monto` float(20,2) DEFAULT NULL,
  `valor_total` float(20,2) DEFAULT NULL,
  `rep_legal` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE jserp_contratos
ADD COLUMN adjunto VARCHAR(255) NULL AFTER valor_total;
*/

ALTER TABLE envios
ADD COLUMN tracking_id VARCHAR(255) NULL AFTER id,
ADD COLUMN entrega_estimada DATETIME NULL AFTER solicitado,
ADD COLUMN firmado_por VARCHAR(255) NULL AFTER entregado;

UPDATE envios SET status='Pending' WHERE status='pendiente';
UPDATE envios SET status='InfoReceived' WHERE status='en-preparacion';
UPDATE envios SET status='InTransit' WHERE status='recolectado';
UPDATE envios SET status='OutForDelivery' WHERE status='en-camino';
UPDATE envios SET status='FailedAttempt' WHERE status='no-entregado';
UPDATE envios SET status='Delivered' WHERE status='entregado';

-- MIGRACIÓN 1.0.1
ALTER TABLE envios ADD COLUMN peso_real FLOAT(10,2) DEFAULT NULL AFTER peso_neto;
-- ADD COLUMN sobrepeso FLOAT(10,2) DEFAULT NULL AFTER peso_real;

-- MIGRACIÓN 1.0.1.1
ALTER TABLE envios ADD COLUMN sobrepeso_pago_status VARCHAR(255) NULL AFTER status;

-- MIGRACIÓN 1.0.1.2
-- NUEVA TABLA PARA MULTIPLES SESIONES ACTIVAS
DROP TABLE IF EXISTS `sesion_tokens`;
CREATE TABLE `sesion_tokens` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(10) NOT NULL,
  `token` text COLLATE utf8_unicode_ci,
  `navegador` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sistema_operativo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lifetime` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valid` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- MIGRACIÓN 1.0.4
-- ----------------------------
-- Table structure for va_couriers
-- ----------------------------
DROP TABLE IF EXISTS `va_couriers`;
CREATE TABLE `va_couriers` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `slug` varchar(30) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `other_name` varchar(255) DEFAULT NULL,
  `web_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of va_couriers
-- ----------------------------
INSERT INTO `va_couriers` VALUES ('1', 'fedex', 'FedEx', '1 800 463 3339 / 03456 070809 / 1800 419 4343', 'Federal Express', 'https://www.fedex.com/', '2018-12-21 20:03:43', '2018-12-21 20:04:17');
INSERT INTO `va_couriers` VALUES ('2', 'dhl', 'DHL Express', '+1 800 225 5345', 'DHL International', 'https://www.dhl.com/', '2018-12-21 20:04:18', '2018-12-21 20:04:19');
INSERT INTO `va_couriers` VALUES ('3', 'estafeta', 'Estafeta', '+52 1-800-378-2338', 'Estafeta Mexicana', 'https://www.estafeta.com/', '2018-12-21 20:04:59', '2018-12-21 20:05:00');
INSERT INTO `va_couriers` VALUES ('4', 'ups', 'UPS', '+1 800 742 5877', 'United Parcel Service', 'https://www.ups.com', '2018-12-21 20:05:24', '2018-12-21 20:05:25');
INSERT INTO `va_couriers` VALUES ('5', 'mexico-redpack', 'Mexico Repack', '+52 1800-013-3333', 'TNT Mexico', 'https://www.redpack.com.mx', '2018-12-21 20:06:05', '2018-12-21 20:06:06');
INSERT INTO `va_couriers` VALUES ('6', 'paquetexpress', 'Paquetexpress', '+01 800 8210 208', null, 'https://www.paquetexpress.com.mx', '2018-12-21 20:07:18', '2018-12-21 20:07:19');

ALTER TABLE productos ADD COLUMN id_courier BIGINT(10) NULL AFTER titulo;
UPDATE productos p SET p.id_courier = (SELECT c.id FROM va_couriers c WHERE c.slug LIKE CONCAT('%', p.titulo ,'%'));

-- Tabla de direcciones actualizada
-- Nuevos scripts
-- Etc
-- ----------------------------
-- Table structure for direcciones
-- ----------------------------
DROP TABLE IF EXISTS `direcciones`;
CREATE TABLE `direcciones` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` varchar(255) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `calle` varchar(255) DEFAULT NULL,
  `num_ext` varchar(20) DEFAULT NULL,
  `num_int` varchar(20) DEFAULT NULL,
  `colonia` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `referencias` varchar(255) DEFAULT NULL,
  `coordenadas` text,
  `creado` datetime DEFAULT NULL,
  `actualizado` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


-- MIGRACIÓN 1.0.5
-- Resumén de cambios hasta el momento
ALTER TABLE usuarios
ADD COLUMN sub_start BIGINT(10) NULL AFTER api_key,
ADD COLUMN sub_end BIGINT(10) NULL AFTER sub_start;

ALTER TABLE usuarios
ADD COLUMN id_sub_type BIGINT(10) NULL AFTER api_key;