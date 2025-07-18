/*
Navicat MySQL Data Transfer

Source Server         : XAMPP
Source Server Version : 100414
Source Host           : localhost:3306
Source Database       : db_shippr

Target Server Type    : MYSQL
Target Server Version : 100414
File Encoding         : 65001

Date: 2022-03-15 09:45:39
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `coordenadas` text DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `actualizado` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of direcciones
-- ----------------------------
INSERT INTO `direcciones` VALUES ('1', '28', 'remitente', 'Lucas Ortiaga', '', '5523456789', 'CompanyCool', '57896', 'Calle de los lagos', '123', '', 'Coloniacool', 'CDMX', 'México', 'México', 'Pared gris, saguan verde claro', null, '2019-12-06 12:15:33', '2022-03-15 09:43:11');
INSERT INTO `direcciones` VALUES ('2', '28', null, 'O\' Donell', '', '5511223344', 'Mercado Libre', '68522', 'Avenida en CDMX', '123', 'G-584', 'Iztapalapa', 'Alguna', 'CDMX', 'México', 'Almacén mercado libre', null, '2019-12-06 12:16:44', '2022-03-15 09:43:25');
INSERT INTO `direcciones` VALUES ('3', '1', null, 'Oficina', 'jslocal2@localhost.com', '5512345678', 'Empresa', '57896', 'Una calle en méxico', '22', '', 'Tamaulipas Sección Virgencitas', 'Ciudad Nezahualcoyotl', 'Méxito', 'México', 'Pared blanca', null, '2020-02-18 10:59:45', '2020-02-18 10:59:45');
INSERT INTO `direcciones` VALUES ('4', '1', 'remitente', 'JHON DOE VILLA', 'ventas@empresa.com', '5512345678', 'Empresa', '57896', 'Una calle en México', '22', '', 'Tamaulipas Sección Virgencitas', 'Nezahualcóyotl', 'México', 'México', 'Pared blanca', null, '2020-02-18 13:06:18', '2020-02-18 13:06:18');

-- ----------------------------
-- Table structure for envios
-- ----------------------------
DROP TABLE IF EXISTS `envios`;
CREATE TABLE `envios` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(10) DEFAULT 0,
  `id_venta` bigint(10) DEFAULT 0,
  `id_producto` bigint(10) DEFAULT 0,
  `id_courier` int(3) DEFAULT 0,
  `tracking_id` varchar(255) DEFAULT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `capacidad` int(3) DEFAULT 0,
  `precio` float(10,2) DEFAULT 0.00,
  `cantidad` int(10) DEFAULT 0,
  `remitente` text DEFAULT NULL,
  `destinatario` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `paq_alto` float(10,2) DEFAULT 0.00,
  `paq_ancho` float(10,2) DEFAULT 0.00,
  `paq_largo` float(10,2) DEFAULT 0.00,
  `peso_neto` float(10,2) DEFAULT 0.00,
  `peso_real` float(10,2) DEFAULT 0.00,
  `peso_vol` float(10,2) DEFAULT 0.00,
  `num_guia` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `adjunto` varchar(255) DEFAULT NULL,
  `imagenes` text DEFAULT NULL,
  `solicitado` int(3) DEFAULT 0,
  `descargado` int(3) DEFAULT 0,
  `con_sobrepeso` int(3) DEFAULT 0,
  `entrega_estimada` datetime DEFAULT NULL,
  `entregado` datetime DEFAULT NULL,
  `firmado_por` varchar(255) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `actualizado` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of envios
-- ----------------------------
INSERT INTO `envios` VALUES ('1', '1', '1', '4', '2', '', '', 'DHL regular 5kg (3 a 5 días)', '5', '165.00', '1', '{\"nombre\":\"Jhon Doe\",\"email\":\"jslocal@localhost.com\",\"telefono\":\"5512345678\",\"empresa\":\"CompanyCool\",\"cp\":\"57896\",\"calle\":\"Una calle en méxico\",\"num_ext\":\"22\",\"num_int\":\"\",\"colonia\":\"Virgencitas\",\"ciudad\":\"Nezahualcoyotl\",\"estado\":\"M\\u00e9xico\",\"referencias\":\"Pared gris, saguan verde claro\"}', '{\"nombre\":\"O\' Donell\",\"email\":\"\",\"telefono\":\"551122334455\",\"empresa\":\"Mercado Libre\",\"cp\":\"68522\",\"calle\":\"Avenida en CDMX\",\"num_ext\":\"123\",\"num_int\":\"G-584\",\"colonia\":\"Iztapalapa\",\"ciudad\":\"Alguna\",\"estado\":\"CDMX\",\"referencias\":\"Almac\\u00e9n mercado libre\"}', 'Playeras nuevas', '20.25', '20.35', '1.52', '2.55', '8.00', '0.13', '776593520250', 'InfoReceived', 'ShipprLabel-uynxqobehvp5-vlqaxpuzfcyh-l8opyrsblyui.pdf', null, '1', '1', '1', null, null, null, '2019-12-06 12:27:39', '2019-12-06 15:56:58');
INSERT INTO `envios` VALUES ('2', '1', '2', '5', '2', null, '', 'DHL regular 10kg (3 a 5 días)', '10', '245.00', '1', '{\"nombre\":\"Jhon Doe\",\"email\":\"jslocal@localhost.com\",\"telefono\":\"5512345678\",\"empresa\":\"CompanyCool\",\"cp\":\"57896\",\"calle\":\"Una calle en méxico\",\"num_ext\":\"22\",\"num_int\":\"\",\"colonia\":\"Virgencitas\",\"ciudad\":\"Nezahualcoyotl\",\"estado\":\"M\\u00e9xico\",\"referencias\":\"Pared gris, saguan verde claro\"}', '{\"nombre\":\"O\' Donell\",\"email\":\"\",\"telefono\":\"551122334455\",\"empresa\":\"Mercado Libre\",\"cp\":\"68522\",\"calle\":\"Avenida en CDMX\",\"num_ext\":\"123\",\"num_int\":\"G-584\",\"colonia\":\"Iztapalapa\",\"ciudad\":\"Alguna\",\"estado\":\"CDMX\",\"referencias\":\"Almac\\u00e9n mercado libre\"}', 'Más playeras Empresa', '20.00', '30.00', '25.00', '3.55', '12.55', '3.00', '776596245852', 'Delivered', 'ShipprLabel-tmuahg0n1clh-oll4podgtgfg-9g1hgu8bwphm.pdf', null, '0', '0', '1', null, null, null, '2019-12-06 18:12:01', '2019-12-10 11:51:11');
INSERT INTO `envios` VALUES ('3', '1', '3', '4', '2', null, 'REF-123', 'DHL regular 5kg (3 a 5 días)', '5', '165.00', '1', '{\"nombre\":\"Jhon Doe\",\"email\":\"jslocal@localhost.com\",\"telefono\":\"5512345678\",\"empresa\":\"CompanyCool\",\"cp\":\"57896\",\"calle\":\"Una calle en méxico\",\"num_ext\":\"22\",\"num_int\":\"\",\"colonia\":\"Virgencitas\",\"ciudad\":\"Nezahualcoyotl\",\"estado\":\"M\\u00e9xico\",\"referencias\":\"Pared gris, saguan verde claro\"}', '{\"nombre\":\"O\' Donell\",\"email\":\"\",\"telefono\":\"551122334455\",\"empresa\":\"Mercado Libre\",\"cp\":\"68522\",\"calle\":\"Avenida en CDMX\",\"num_ext\":\"123\",\"num_int\":\"G-584\",\"colonia\":\"Iztapalapa\",\"ciudad\":\"Alguna\",\"estado\":\"CDMX\",\"referencias\":\"Almac\\u00e9n mercado libre\"}', 'Equipo médico', '35.00', '20.00', '20.00', '4.55', '5.36', '2.80', '776593798524', 'OutForDelivery', null, null, '0', '0', '1', null, null, null, '2019-12-09 13:01:36', '2020-06-29 10:49:57');
INSERT INTO `envios` VALUES ('4', '1', '4', '5', '2', null, '', 'DHL regular 10kg (3 a 5 días)', '10', '245.00', '1', '{\"nombre\":\"Jhon Doe\",\"email\":\"jslocal@localhost.com\",\"telefono\":\"5512345678\",\"empresa\":\"CompanyCool\",\"cp\":\"57896\",\"calle\":\"Una calle en méxico\",\"num_ext\":\"22\",\"num_int\":\"\",\"colonia\":\"Virgencitas\",\"ciudad\":\"Nezahualcoyotl\",\"estado\":\"M\\u00e9xico\",\"referencias\":\"Pared gris, saguan verde claro\"}', '{\"nombre\":\"O\' Donell\",\"email\":\"\",\"telefono\":\"551122334455\",\"empresa\":\"Mercado Libre\",\"cp\":\"68522\",\"calle\":\"Avenida en CDMX\",\"num_ext\":\"123\",\"num_int\":\"G-584\",\"colonia\":\"Iztapalapa\",\"ciudad\":\"Alguna\",\"estado\":\"CDMX\",\"referencias\":\"Almac\\u00e9n mercado libre\"}', 'Paquete', '10.00', '25.00', '32.00', '25.00', '12.55', '1.60', '776593785412', 'InTransit', null, null, '0', '0', '1', null, null, null, '2019-12-09 14:45:32', '2019-12-10 11:51:11');
INSERT INTO `envios` VALUES ('5', '28', '5', '4', '2', null, '', 'DHL regular 5kg (3 a 5 días)', '5', '165.00', '1', '{\"nombre\":\"Jhon Doe\",\"email\":\"jslocal2@localhost.com\",\"telefono\":\"5512345678\",\"empresa\":\"CompanyCool\",\"cp\":\"57896\",\"calle\":\"Una calle en méxico\",\"num_ext\":\"22\",\"num_int\":\"\",\"colonia\":\"Virgencitas\",\"ciudad\":\"Nezahualcoyotl\",\"estado\":\"M\\u00e9xico\",\"referencias\":\"Pared gris, saguan verde claro\"}', '{\"nombre\":\"O\' Donell\",\"email\":\"\",\"telefono\":\"551122334455\",\"empresa\":\"Mercado Libre\",\"cp\":\"68522\",\"calle\":\"Avenida en CDMX\",\"num_ext\":\"123\",\"num_int\":\"G-584\",\"colonia\":\"Iztapalapa\",\"ciudad\":\"Alguna\",\"estado\":\"CDMX\",\"referencias\":\"Almac\\u00e9n mercado libre\"}', 'Envío bien cools', '10.00', '12.55', '25.00', '3.65', '6.75', '0.63', '776589621253', 'InTransit', null, null, '0', '0', '1', null, null, null, '2019-12-09 15:05:47', '2019-12-10 11:51:11');
INSERT INTO `envios` VALUES ('6', '28', '6', '2', '1', null, '', 'FedEx regular 3kg (3 a 5 días)', '3', '140.00', '1', '{\"nombre\":\"Jhon Doe\",\"email\":\"jslocal2@localhost.com\",\"telefono\":\"5512345678\",\"empresa\":\"CompanyCool\",\"cp\":\"57896\",\"calle\":\"Una calle en méxico\",\"num_ext\":\"22\",\"num_int\":\"\",\"colonia\":\"Virgencitas\",\"ciudad\":\"Nezahualcoyotl\",\"estado\":\"M\\u00e9xico\",\"referencias\":\"Pared gris, saguan verde claro\"}', '{\"nombre\":\"O\' Donell\",\"email\":\"\",\"telefono\":\"551122334455\",\"empresa\":\"Mercado Libre\",\"cp\":\"68522\",\"calle\":\"Avenida en CDMX\",\"num_ext\":\"123\",\"num_int\":\"G-584\",\"colonia\":\"Iztapalapa\",\"ciudad\":\"Alguna\",\"estado\":\"CDMX\",\"referencias\":\"Almac\\u00e9n mercado libre\"}', 'playeritas', '10.00', '10.00', '15.23', '2.45', '3.98', '0.30', '778228963549', 'Delivered', null, null, '0', '0', '1', null, null, null, '2019-12-09 15:36:50', '2019-12-10 11:51:11');
INSERT INTO `envios` VALUES ('7', '28', '7', '5', '2', null, '', 'DHL regular 10kg (3 a 5 días)', '10', '245.00', '1', '{\"nombre\":\"Jhon Doe\",\"email\":\"jslocal2@localhost.com\",\"telefono\":\"5512345678\",\"empresa\":\"CompanyCool\",\"cp\":\"57896\",\"calle\":\"Una calle en méxico\",\"num_ext\":\"22\",\"num_int\":\"\",\"colonia\":\"Virgencitas\",\"ciudad\":\"Nezahualcoyotl\",\"estado\":\"M\\u00e9xico\",\"referencias\":\"Pared gris, saguan verde claro\"}', '{\"nombre\":\"O\' Donell\",\"email\":\"\",\"telefono\":\"551122334455\",\"empresa\":\"Mercado Libre\",\"cp\":\"68522\",\"calle\":\"Avenida en CDMX\",\"num_ext\":\"123\",\"num_int\":\"G-584\",\"colonia\":\"Iztapalapa\",\"ciudad\":\"Alguna\",\"estado\":\"CDMX\",\"referencias\":\"Almac\\u00e9n mercado libre\"}', 'paquetito puntos 3', '25.00', '25.32', '30.00', '3.55', '12.55', '3.80', '782168428466', 'OutForDelivery', null, null, '0', '0', '1', null, null, null, '2019-12-09 15:51:19', '2019-12-10 11:51:11');
INSERT INTO `envios` VALUES ('8', '1', '8', '2', '1', null, '', 'FedEx regular 3kg (3 a 5 días)', '3', '140.00', '1', '{\"cp\":\"09810\",\"colonia\":\"Granjas Esmeralda\",\"ciudad\":\"Iztapalapa\",\"estado\":\"Ciudad de M\\u00e9xico\",\"calle\":\"Una calle en México\",\"num_ext\":\"22\",\"num_int\":\"\",\"referencias\":\"Algo por aqu\\u00ed\",\"nombre\":\"Root user\",\"email\":\"jslocal@localhost.com\",\"telefono\":\"5512345678\",\"empresa\":\"Joystick SA de CV\"}', '{\"cp\":\"57896\",\"colonia\":\"Tamaulipas Secci\\u00f3n Virgencitas\",\"ciudad\":\"Ciudad Nezahualcoyotl\",\"estado\":\"M\\u00e9xito\",\"calle\":\"Una calle en méxico\",\"num_ext\":\"22\",\"num_int\":\"\",\"referencias\":\"Pared blanca\",\"nombre\":\"Oficina\",\"email\":\"jslocal2@localhost.com\",\"telefono\":\"5512345678\",\"empresa\":\"Empresa\"}', 'asdfafd', '10.00', '10.00', '10.00', '2.25', '0.00', '0.20', null, 'Pending', null, null, '0', '0', '0', null, null, null, '2020-02-18 11:35:02', '2020-02-18 11:35:02');
INSERT INTO `envios` VALUES ('9', '1', '9', '3', '5', null, '', 'Mexico Repack regular 3kg (3 a 5 días)', '3', '200.00', '1', '{\"cp\":\"57896\",\"colonia\":\"Tamaulipas Secci\\u00f3n Virgencitas\",\"ciudad\":\"Nezahualc\\u00f3yotl\",\"estado\":\"M\\u00e9xico\",\"calle\":\"Una calle en México\",\"num_ext\":\"22\",\"num_int\":\"\",\"referencias\":\"Pared blanca\",\"nombre\":\"JHON DOE VILLA\",\"email\":\"ventas@empresa.com\",\"telefono\":\"5512345678\",\"empresa\":\"Empresa\"}', '{\"cp\":\"54719\",\"colonia\":\"Claustros de San Miguel\",\"ciudad\":\"Cuautitl\\u00e1n Izcalli\",\"estado\":\"M\\u00e9xico\",\"calle\":\"O Donell Street\",\"num_ext\":\"123\",\"num_int\":\"\",\"referencias\":\"Mercado libre\",\"nombre\":\"Mercado libre\",\"email\":\"\",\"telefono\":\"123456\",\"empresa\":\"\"}', 'algo asdfasd ', '10.00', '10.00', '15.00', '2.55', '0.00', '0.30', null, 'Pending', null, null, '0', '0', '0', null, null, null, '2020-02-18 14:55:33', '2020-02-18 14:55:33');
INSERT INTO `envios` VALUES ('10', '1', '10', '6', '1', null, '', 'FedEx express 3kg (día siguiente)', '3', '160.00', '1', '{\"cp\":\"57896\",\"colonia\":\"Tamaulipas Secci\\u00f3n Virgencitas\",\"ciudad\":\"Nezahualc\\u00f3yotl\",\"estado\":\"M\\u00e9xico\",\"calle\":\"Una calle en México\",\"num_ext\":\"22\",\"num_int\":\"\",\"referencias\":\"Pared blanca\",\"nombre\":\"JHON DOE VILLA\",\"email\":\"ventas@empresa.com\",\"telefono\":\"5512345678\",\"empresa\":\"Empresa\"}', '{\"cp\":\"44910\",\"colonia\":\"8 de Julio\",\"ciudad\":\"Guadalajara\",\"estado\":\"Jalisco\",\"calle\":\"Una calle en México\",\"num_ext\":\"22\",\"num_int\":\"\",\"referencias\":\"Pared blanca\",\"nombre\":\"JHON DOE VILLA\",\"email\":\"ventas@empresa.com\",\"telefono\":\"5512345678\",\"empresa\":\"Empresa\"}', 'Playeras', '10.00', '20.00', '30.00', '2.99', '0.00', '1.20', null, 'Pending', null, null, '0', '0', '0', null, null, null, '2020-06-29 11:09:38', '2020-06-29 11:09:38');
INSERT INTO `envios` VALUES ('11', '1', '10', '5', '2', null, '', 'DHL regular 10kg (3 a 5 días)', '10', '256.23', '1', '{\"cp\":\"57896\",\"colonia\":\"Tamaulipas Secci\\u00f3n Virgencitas\",\"ciudad\":\"Nezahualc\\u00f3yotl\",\"estado\":\"M\\u00e9xico\",\"calle\":\"Una calle en México\",\"num_ext\":\"22\",\"num_int\":\"\",\"referencias\":\"Pared blanca\",\"nombre\":\"JHON DOE VILLA\",\"email\":\"ventas@empresa.com\",\"telefono\":\"5512345678\",\"empresa\":\"Empresa\"}', '{\"cp\":\"54719\",\"colonia\":\"Claustros de San Miguel\",\"ciudad\":\"Cuautitl\\u00e1n Izcalli\",\"estado\":\"M\\u00e9xico\",\"calle\":\"Una calle en méxico\",\"num_ext\":\"22\",\"num_int\":\"\",\"referencias\":\"Pared blanca\",\"nombre\":\"Oficina\",\"email\":\"jslocal2@localhost.com\",\"telefono\":\"5512345678\",\"empresa\":\"Empresa\"}', 'Playeras', '10.00', '40.00', '30.00', '3.55', '0.00', '2.40', null, 'Pending', null, null, '0', '0', '0', null, null, null, '2020-06-29 11:09:38', '2020-06-29 11:09:38');
INSERT INTO `envios` VALUES ('12', '1', '11', '4', '2', null, '', 'DHL regular 5kg (3 a 5 días)', '5', '176.23', '1', '{\"cp\":\"57896\",\"colonia\":\"Tamaulipas Secci\\u00f3n Virgencitas\",\"ciudad\":\"Nezahualc\\u00f3yotl\",\"estado\":\"M\\u00e9xico\",\"calle\":\"Una calle en México\",\"num_ext\":\"22\",\"num_int\":\"\",\"referencias\":\"Pared blanca\",\"nombre\":\"JHON DOE VILLA\",\"email\":\"ventas@empresa.com\",\"telefono\":\"5512345678\",\"empresa\":\"Empresa\"}', '{\"cp\":\"54715\",\"colonia\":\"Ex-Hacienda San Miguel\",\"ciudad\":\"Cuautitl\\u00e1n Izcalli\",\"estado\":\"M\\u00e9xico\",\"calle\":\"Una calle en méxico\",\"num_ext\":\"22\",\"num_int\":\"\",\"referencias\":\"Pared blanca\",\"nombre\":\"Oficina\",\"email\":\"jslocal2@localhost.com\",\"telefono\":\"5512345678\",\"empresa\":\"Empresa\"}', 'Playeras', '30.00', '30.00', '10.00', '2.55', '0.00', '1.80', null, 'Pending', null, null, '0', '0', '0', null, null, null, '2020-06-29 11:20:26', '2020-06-29 11:20:26');

-- ----------------------------
-- Table structure for opciones
-- ----------------------------
DROP TABLE IF EXISTS `opciones`;
CREATE TABLE `opciones` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `opcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valor` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of opciones
-- ----------------------------
INSERT INTO `opciones` VALUES ('1', 'sitename', 'Shippr', '2018-09-25 19:53:04', '2019-08-20 11:48:06');
INSERT INTO `opciones` VALUES ('2', 'siteslogan', 'Sistema de administración de envíos.', '2018-09-25 19:53:04', '2019-08-16 15:05:18');
INSERT INTO `opciones` VALUES ('3', 'sitedesc', 'Shippr el mejor ERP de administración de empresas de envíos y logística, desarrollado por Joystick, empresa 100% mexicana.', '2018-09-25 19:53:04', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('4', 'siteurl', 'http://127.0.0.1:7884/guias/v1/', '2018-09-25 19:53:04', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('5', 'siteph', '5512346789', '2018-09-25 19:53:04', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('6', 'siterfc', 'XXJOHNDOEXX00', '2018-09-25 19:53:04', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('7', 'siterazonSocial', 'Shippr SA de CV', '2018-09-25 19:53:04', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('8', 'siteaddress', '{\"cp\":\"78956\",\"calle\":\"Un domicilio\",\"num_ext\":\"3569\",\"num_int\":\"H-255\",\"colonia\":\"Roma\",\"ciudad\":\"Cua\\u00fahtemoc\",\"estado\":\"CDMX\",\"pais\":\"M\\u00e9xico\"}', '2018-09-25 19:53:05', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('9', 'bank_name', 'Shippr Banco Oficial', '2018-09-25 19:53:05', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('10', 'bank_number', 'SUC-123', '2018-09-25 19:53:05', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('11', 'bank_account_name', 'JOHN DOE TITULAR DE CUENTA', '2018-09-25 19:53:05', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('12', 'bank_account_number', '1234567890', '2018-09-25 19:53:05', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('13', 'bank_clabe', '1234567890', '2018-09-25 19:53:05', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('14', 'time_zone', 'America/Mexico_City', '2018-09-25 19:53:05', '2018-09-25 19:53:05');
INSERT INTO `opciones` VALUES ('15', 'maintenance_mode', '0', '0000-00-00 00:00:00', '2018-11-05 13:49:43');
INSERT INTO `opciones` VALUES ('16', 'siteversion', '2.0.0', '2018-09-25 20:20:03', '2019-10-05 15:26:17');
INSERT INTO `opciones` VALUES ('17', 'site_smtp_host', '', '2018-09-26 09:53:42', '2022-03-15 09:45:24');
INSERT INTO `opciones` VALUES ('18', 'site_smtp_port', '', '2018-09-26 09:53:43', '2022-03-15 09:45:23');
INSERT INTO `opciones` VALUES ('19', 'site_smtp_email', '', '2018-09-26 09:53:43', '2022-03-15 09:45:21');
INSERT INTO `opciones` VALUES ('20', 'site_smtp_password', '', '2018-09-26 09:53:43', '2022-03-15 09:45:20');
INSERT INTO `opciones` VALUES ('21', 'email_address_for_reportes', '', '2018-09-26 09:53:43', '2022-03-15 09:45:01');
INSERT INTO `opciones` VALUES ('22', 'email_address_for_anticipos', '', '2018-09-26 09:53:43', '2022-03-15 09:45:01');
INSERT INTO `opciones` VALUES ('23', 'email_address_for_contabilidad', '', '2018-09-26 09:53:43', '2022-03-15 09:45:01');
INSERT INTO `opciones` VALUES ('24', 'email_address_for_contacto', '', '2018-09-26 09:53:43', '2022-03-15 09:45:01');
INSERT INTO `opciones` VALUES ('25', 'cron_repeat_time', 'week', '2018-09-26 10:17:13', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('26', 'sitegmaps', '', '2018-09-27 17:34:51', '2022-03-15 09:45:17');
INSERT INTO `opciones` VALUES ('27', 'sitelogo', 'serp-1000.png', '2018-09-28 10:52:24', '2019-11-25 13:00:16');
INSERT INTO `opciones` VALUES ('29', 'sitekey', '', '2018-09-28 19:12:11', '2018-09-28 19:12:13');
INSERT INTO `opciones` VALUES ('30', 'domain', 'www.joystick.com.mx', '2018-09-28 23:54:34', '2022-03-15 09:45:14');
INSERT INTO `opciones` VALUES ('31', 'maintenance_time', '0', '2018-10-01 00:04:50', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('32', 'sitetheme', 'orange', '2018-10-01 14:03:58', '2019-10-08 13:58:43');
INSERT INTO `opciones` VALUES ('33', 'email_alignment', 'right', '2018-10-01 22:50:27', '2019-08-16 15:04:34');
INSERT INTO `opciones` VALUES ('34', 'pdf_alignment', 'right', '2018-10-01 22:50:27', '2019-08-20 12:53:28');
INSERT INTO `opciones` VALUES ('35', 'updating_system', '0', '2018-10-03 11:26:23', '2018-11-05 13:49:43');
INSERT INTO `opciones` VALUES ('36', 'db_version', '1.0.0', null, '2018-10-12 12:57:05');
INSERT INTO `opciones` VALUES ('37', 'sitefavicon', '', null, '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('38', 'site_login_bg', '', '2018-10-15 13:31:10', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('39', 'mp_client_id', '', '2018-11-09 20:50:48', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('40', 'mp_client_secret', '', '2018-11-09 20:51:01', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('41', 'mp_sandbox', '1', '2018-11-23 13:02:57', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('42', 'va_mp_comission_rate', '0.08', '2018-12-12 10:45:53', '2018-12-12 10:46:33');
INSERT INTO `opciones` VALUES ('43', 'va_mp_overweight_price', '45.00', '2018-12-12 10:45:53', '2018-12-12 10:45:53');
INSERT INTO `opciones` VALUES ('44', 'va_mp_public_key', '', '2019-01-21 18:26:29', '2022-03-15 09:45:02');
INSERT INTO `opciones` VALUES ('45', 'va_mp_access_token', '', '2019-01-21 18:26:30', '2022-03-15 09:45:01');
INSERT INTO `opciones` VALUES ('46', 'site_regimen', '612', '2019-08-20 11:47:44', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('47', 'site_google_analytics', '', '2019-08-20 11:49:49', '2019-08-20 11:49:49');
INSERT INTO `opciones` VALUES ('48', 'site_hotjar', '', '2019-08-20 11:49:49', '2019-08-20 11:49:49');
INSERT INTO `opciones` VALUES ('49', 'sitekeywords', '[\"envíos\",\"guías prepagadas\",\"dhl\",\"fedex\",\"ups\",\"rastreo de envíos\",\"rastrea tu envío\",\"envía barato y rápido\",\"guías baratas\",\"redpack\",\"Fedex\",\"logística de envíos\",\"erp de envíos\",\"plataforma para vender envíos\",\"plataforma para vender guías\"]', '2019-08-20 11:49:49', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('50', 'site_public', '1', '2019-08-20 11:49:49', '2019-08-20 11:49:49');
INSERT INTO `opciones` VALUES ('51', 'sidebar_alignment', 'left', '2019-08-20 12:07:33', '2019-08-20 12:07:47');
INSERT INTO `opciones` VALUES ('52', 'sidebar_opacity', '1', '2019-08-20 12:07:33', '2019-10-08 13:57:36');
INSERT INTO `opciones` VALUES ('53', 'siteplan', 'basic', null, '2019-08-24 13:10:51');
INSERT INTO `opciones` VALUES ('54', 'site_status', '1', null, '2021-12-02 20:04:21');
INSERT INTO `opciones` VALUES ('55', 'faq', '', '2019-10-03 15:43:26', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('56', 'faq_updated', '', '2019-10-03 15:43:26', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('57', 'aftership_api_key', '', '2019-10-08 13:00:35', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('58', 'sidebar_bg', '', '2019-11-25 12:55:19', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('59', 'email_sitename', '[Shippr] -', '2019-11-25 12:55:19', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('60', 'email_template', 'jserp_template_02.php', '2019-11-25 12:55:19', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('61', 'show_signs', '0', '2019-11-25 12:55:19', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('62', 'site_suspended', '0', '2019-11-25 12:55:19', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('63', 'siteemail', '', '2019-11-25 12:55:19', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('64', 'sitepublic', '1', '2019-11-25 12:55:19', '2019-11-25 12:55:19');
INSERT INTO `opciones` VALUES ('65', 'site_lv_opening', '9', '2019-11-25 13:00:16', '2019-11-25 13:00:50');
INSERT INTO `opciones` VALUES ('66', 'site_lv_closing', '22', '2019-11-25 13:00:16', '2021-12-02 20:03:57');
INSERT INTO `opciones` VALUES ('67', 'site_sat_opening', '10', '2019-11-25 13:00:16', '2019-11-25 13:00:50');
INSERT INTO `opciones` VALUES ('68', 'site_sat_closing', '14', '2019-11-25 13:00:16', '2019-11-25 13:00:50');
INSERT INTO `opciones` VALUES ('69', 'site_sun_opening', '0', '2019-11-25 13:00:16', '2019-11-25 13:00:16');
INSERT INTO `opciones` VALUES ('70', 'site_sun_closing', '0', '2019-11-25 13:00:16', '2019-11-25 13:00:16');
INSERT INTO `opciones` VALUES ('71', 'site_sun_opening', '0', '2019-11-25 13:03:57', '2019-12-06 11:55:18');
INSERT INTO `opciones` VALUES ('72', 'bank_card_number', '', '2019-12-06 11:36:23', '2019-12-06 11:36:23');
INSERT INTO `opciones` VALUES ('73', 'site_custom_zones', '1', '2019-12-06 11:55:17', '2021-12-02 19:51:21');

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_padre` bigint(20) DEFAULT NULL,
  `id_usuario` bigint(20) DEFAULT NULL,
  `id_ref` bigint(20) DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permalink` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contenido` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mime_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adjuntos` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `limite` datetime DEFAULT NULL,
  `completado` datetime DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `actualizado` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of posts
-- ----------------------------

-- ----------------------------
-- Table structure for productos
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sku` varchar(255) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `id_courier` bigint(10) DEFAULT NULL,
  `capacidad` int(10) DEFAULT NULL,
  `tipo_servicio` varchar(255) DEFAULT NULL,
  `tiempo_entrega` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` float(10,2) DEFAULT NULL,
  `precio_descuento` float(10,2) DEFAULT NULL,
  `publicado` int(3) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `actualizado` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of productos
-- ----------------------------
INSERT INTO `productos` VALUES ('1', '065967729939', 'Guía de envío', '2', '3', 'regular', '3 a 5 días', 'Guía electrónica de envío', '120.00', '120.00', '1', '2019-12-06 12:13:59', '2019-12-06 12:13:59');
INSERT INTO `productos` VALUES ('2', '799553566161', 'Guía de envío', '1', '3', 'regular', '3 a 5 días', 'Guía electrónica de envío', '140.00', '140.00', '1', '2019-12-06 12:14:09', '2019-12-06 12:14:09');
INSERT INTO `productos` VALUES ('3', '626752812655', 'Guía de envío', '5', '3', 'regular', '3 a 5 días', 'Guía electrónica de envío', '125.00', '125.00', '1', '2019-12-06 12:14:18', '2019-12-06 12:14:18');
INSERT INTO `productos` VALUES ('4', '103142592683', 'Guía de envío', '2', '5', 'regular', '3 a 5 días', 'Guía electrónica de envío', '165.00', '165.00', '1', '2019-12-06 12:14:26', '2019-12-06 12:14:26');
INSERT INTO `productos` VALUES ('5', '134723635934', 'Guía de envío', '2', '10', 'regular', '3 a 5 días', 'Guía electrónica de envío', '245.00', '245.00', '1', '2019-12-06 12:14:33', '2019-12-06 12:14:33');
INSERT INTO `productos` VALUES ('6', '427175314758', 'Guía de envío', '1', '3', 'express', 'día siguiente', 'Guía electrónica de envío', '160.00', '160.00', '1', '2020-02-18 14:09:42', '2020-02-18 14:09:42');
INSERT INTO `productos` VALUES ('7', '285308092677', 'Guía de envío', '1', '10', 'express', 'día siguiente', 'Guía electrónica de envío', '250.00', '250.00', '1', '2020-06-29 12:27:55', '2020-06-29 12:27:55');

-- ----------------------------
-- Table structure for pruebas
-- ----------------------------
DROP TABLE IF EXISTS `pruebas`;
CREATE TABLE `pruebas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `pruebas2` int(3) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pruebas
-- ----------------------------
INSERT INTO `pruebas` VALUES ('1', 'Roberto', 'jslocal@localhost.com', '2019-10-05', '0');
INSERT INTO `pruebas` VALUES ('2', 'Luzerito', 'jslocal2@localhost.com', '2019-10-05', '0');
INSERT INTO `pruebas` VALUES ('3', 'Roberto', 'jslocal@localhost.com', '2019-10-05', '0');
INSERT INTO `pruebas` VALUES ('4', 'Luzerito', 'jslocal2@localhost.com', '2019-10-05', '0');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'root', 'Developer', null, '2018-11-06 12:46:14', '2018-11-06 12:59:48');
INSERT INTO `roles` VALUES ('2', 'admin', 'Administrador', null, '2018-11-06 12:46:12', '2018-11-06 12:59:49');
INSERT INTO `roles` VALUES ('3', 'regular', 'Regular', 'Usuario regular de Empresa Envíos, puede hacer uso de la plataforma y enviar tantos envíos como requiera al costo regular.', '2018-11-06 12:46:23', '2019-01-20 23:46:35');
INSERT INTO `roles` VALUES ('4', 'socio', 'Socio', 'Usuario preferente con precios especiales y únicos de Empresa Envíos.', '2019-01-20 23:44:10', '2019-01-20 23:46:47');
INSERT INTO `roles` VALUES ('5', 'premium', 'Premium', 'Usuario con la taza más baja de comisiones de pago con tarjetas y acceso a costos de socio en Empresa Envíos.', '2019-01-20 23:46:27', '2019-01-20 23:46:32');
INSERT INTO `roles` VALUES ('6', 'worker', 'Trabajador', 'Usuario trabajador de la empresa con acceso a administración.', null, '2019-08-20 12:52:19');

-- ----------------------------
-- Table structure for sesion_tokens
-- ----------------------------
DROP TABLE IF EXISTS `sesion_tokens`;
CREATE TABLE `sesion_tokens` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(10) NOT NULL,
  `token` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `navegador` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sistema_operativo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lifetime` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valid` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sesion_tokens
-- ----------------------------
INSERT INTO `sesion_tokens` VALUES ('5', '28', '8646ac220dc2892b20205a6cfed56eb6dc0a5101b4e5d83fbbaf4352a0c52757', 'Firefox', 'Windows 64', '127.0.0.1', '1670188248', '1', '2021-12-04 15:10:48', '2021-12-04 15:10:48');
INSERT INTO `sesion_tokens` VALUES ('9', '1', 'da8df3bf58669347237e688aecf0f550867b2d65dbd9ffc0f0f3557f7797fe80', 'Firefox', 'Windows 64', '127.0.0.1', '1678895033', '1', '2022-03-15 09:43:53', '2022-03-15 09:43:53');

-- ----------------------------
-- Table structure for shippr_transacciones
-- ----------------------------
DROP TABLE IF EXISTS `shippr_transacciones`;
CREATE TABLE `shippr_transacciones` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) DEFAULT '',
  `tipo` varchar(50) DEFAULT '',
  `detalle` varchar(255) DEFAULT NULL,
  `referencia` varchar(50) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT 0,
  `tipo_ref` varchar(255) DEFAULT NULL,
  `id_ref` int(11) DEFAULT 0,
  `status` varchar(255) DEFAULT NULL,
  `status_detalle` varchar(255) DEFAULT NULL,
  `metodo_pago` varchar(255) DEFAULT NULL,
  `mensualidades` int(5) DEFAULT 1,
  `descripcion` varchar(255) DEFAULT '',
  `subtotal` float(10,2) DEFAULT 0.00,
  `impuestos` float(10,2) DEFAULT 0.00,
  `total` float(10,2) DEFAULT 0.00,
  `debido` float(10,2) DEFAULT 0.00,
  `hash` varchar(255) DEFAULT '',
  `creado` datetime DEFAULT NULL,
  `actualizado` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shippr_transacciones
-- ----------------------------
INSERT INTO `shippr_transacciones` VALUES ('1', '0769211315', 'recarga_saldo', 'Root user solicitó recarga de saldo por $300.00 pesos', '1574708659', '1', null, '0', 'abonado', 'Crédito abonado', 'efectivo', '1', 'Nueva transacción', '258.62', '41.38', '300.00', '0.00', '4a17cb6916db1ffc9df4cb4e1f2fafea9cd91939c07c31a5e8637172fb368e33', '2019-11-25 13:04:19', '2019-11-25 13:05:04');
INSERT INTO `shippr_transacciones` VALUES ('2', '7585841695', 'abono_saldo', 'Abono por $300.00 MXN', '0769211315', '1', 'abono_saldo', '0', 'pagado', 'Pago aprobado', 'efectivo', '1', 'Nueva transacción', '258.62', '41.38', '300.00', '0.00', '855c67fd0b80952f94eccf57cbea2d59f375cf87acc65116f254ab7ad14304fa', '2019-11-25 13:05:04', '2019-12-09 14:13:02');
INSERT INTO `shippr_transacciones` VALUES ('3', '7601428870', 'recarga_saldo', 'Root user solicitó recarga de saldo por $500.00 pesos', '1575653788', '1', null, '0', 'abonado', 'Crédito abonado', 'efectivo', '1', 'Nueva transacción', '431.03', '68.97', '500.00', '0.00', '75250ed808fced8a2d6039236a47170b7fd2db9a2c51eb7966b27b52324527cd', '2019-12-06 11:36:28', '2019-12-06 11:36:51');
INSERT INTO `shippr_transacciones` VALUES ('4', '6087090799', 'abono_saldo', 'Abono por $500.00 MXN', '7601428870', '1', 'abono_saldo', '0', 'pagado', 'Pago aprobado', 'efectivo', '1', 'Nueva transacción', '431.03', '68.97', '500.00', '0.00', '4199336081e07cb1741050f57f2de422d94b133f8240546cbe912a18356895df', '2019-12-06 11:36:51', '2019-12-09 14:13:01');
INSERT INTO `shippr_transacciones` VALUES ('5', '3251692005', 'retiro_saldo', 'Retiro por $165.00 MXN en compra realizada 5454110925', '1575656859', '1', null, '1', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva transacción', '142.24', '22.76', '165.00', '0.00', 'b3010bba296e7b0bfe9456409aca7101ecbc53ec9a07095cce0f8e0c2c5e2449', '2019-12-06 12:27:39', '2019-12-06 12:27:39');
INSERT INTO `shippr_transacciones` VALUES ('6', '9879489849', 'cargo_sobrepeso_saldo', 'Cargo por sobrepeso del envío #1', null, '1', 'envio', '1', 'pagado', 'Pago pendiente', 'user_wallet', '1', 'Nueva transacción', '10.00', '6.00', '16.00', '16.00', '12312312adfasdfasdf', '2019-12-06 14:32:28', '2019-12-06 18:07:10');
INSERT INTO `shippr_transacciones` VALUES ('7', '9801397954', 'retiro_saldo', 'Retiro por $245.00 MXN en compra realizada 4856838984', '1575677521', '1', 'compra', '2', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva transacción', '211.21', '33.79', '245.00', '0.00', 'd8f9649cf9b424b109b56ba852e9da53b1d15a475096d391e606462e06a90d93', '2019-12-06 18:12:01', '2019-12-06 18:12:01');
INSERT INTO `shippr_transacciones` VALUES ('8', '3763867889', 'cargo_sobrepeso_saldo', 'Cargo por sobrepeso para el envío 2 de un monto $75.00', 'Envío #2', '1', 'envio', '2', 'pagado', 'Pago pendiente', 'user_wallet', '1', 'Nueva transacción', '64.66', '10.34', '75.00', '0.00', '766c34bf06758f3568b2e4bda26e85a84bbcc501cadc67aa82b159ce6cff4ec5', '2019-12-09 12:52:50', '2019-12-09 12:56:03');
INSERT INTO `shippr_transacciones` VALUES ('9', '7921448577', 'retiro_saldo', 'Retiro por $165.00 MXN en compra realizada 9731021127', '1575918096', '1', 'compra', '3', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva transacción', '142.24', '22.76', '165.00', '0.00', '87b1ff9f74914431b4953df4c7464380814baa5a3cdd74bea8211f5fa0452b82', '2019-12-09 13:01:36', '2019-12-09 13:01:36');
INSERT INTO `shippr_transacciones` VALUES ('10', '8480830238', 'cargo_sobrepeso_saldo', 'Cargo por sobrepeso para el envío 3 de un monto $150.00', 'Envío #3', '1', 'envio', '3', 'pagado', 'Pago pendiente', 'user_wallet', '1', 'Nueva transacción', '129.31', '20.69', '150.00', '0.00', '168660368fd2696ae118c1bb9928ddc0cad0f4beb91d23aa4e8bcf7235eb508a', '2019-12-09 13:02:27', '2019-12-09 13:03:51');
INSERT INTO `shippr_transacciones` VALUES ('11', '8482461423', 'recarga_saldo', 'Root user solicitó recarga de saldo por $300.00 pesos', '1575918636', '1', 'recarga_saldo', '0', 'abonado', 'Crédito abonado', 'efectivo', '1', 'Nueva transacción', '258.62', '41.38', '300.00', '0.00', '5f5b1498a730e36a23d2fbcb5607c0438df750d0c8f3581e6c27d6b1ef2982f3', '2019-12-09 13:10:36', '2019-12-09 13:10:47');
INSERT INTO `shippr_transacciones` VALUES ('12', '3739376942', 'abono_saldo', 'Abono por $300.00 MXN', '8482461423', '1', 'abono_saldo', '0', 'pagado', 'Pago aprobado', 'efectivo', '1', 'Nueva transacción', '258.62', '41.38', '300.00', '0.00', '25b52897ba7f7356e51b507537cd595a4a5fe2009d40a7a458f5d101227d1152', '2019-12-09 13:10:47', '2019-12-09 13:10:47');
INSERT INTO `shippr_transacciones` VALUES ('13', '2083328594', 'recarga_saldo', 'Root user solicitó recarga de saldo por $300.00 pesos', '1575922452', '1', 'recarga_saldo', '0', 'abonado', 'Recarga solicitada', 'efectivo', '1', 'Nueva transacción', '258.62', '41.38', '300.00', '0.00', '65641e117862f615c9d499959ae6db0c942dfcfbbc09158180e7cb5e2f480074', '2019-12-09 14:14:12', '2019-12-09 14:17:19');
INSERT INTO `shippr_transacciones` VALUES ('14', '4366767411', 'abono_saldo', 'Abono por $300.00 MXN', '2083328594', '1', 'abono_saldo', '0', 'pagado', 'Pago aprobado', 'efectivo', '1', 'Nueva transacción', '258.62', '41.38', '300.00', '0.00', '6c138c1518eb1d113cad97cefdaed8bf6c2b0d83f870d4f1f5c6d177ba6eae47', '2019-12-09 14:17:19', '2019-12-09 14:17:19');
INSERT INTO `shippr_transacciones` VALUES ('15', '0000615860', 'recarga_saldo', 'Root user solicitó recarga de saldo por $300.00 pesos', '1575922884', '1', 'recarga_saldo', '0', 'abonado', 'Saldo abonado', 'efectivo', '1', 'Nueva transacción', '258.62', '41.38', '300.00', '0.00', 'a2bc6d77e897aa5b641fcce27e4e27ebf6d9c08a0879b7336e45b7b1f7fb514f', '2019-12-09 14:21:24', '2019-12-09 14:21:39');
INSERT INTO `shippr_transacciones` VALUES ('16', '8339318998', 'abono_saldo', 'Abono por $300.00 MXN', '0000615860', '1', 'abono_saldo', '0', 'pagado', 'Pago aprobado', 'efectivo', '1', 'Nueva transacción', '258.62', '41.38', '300.00', '0.00', 'b212443928809760bd90ca97756dcd1cdb16ab1efe4361d628eb89bd8f1c3a8b', '2019-12-09 14:21:39', '2019-12-09 14:21:39');
INSERT INTO `shippr_transacciones` VALUES ('17', '9227949105', 'retiro_saldo', 'Retiro por $245.00 MXN en compra realizada 9743769341', '1575924332', '1', 'compra', '4', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva transacción', '211.21', '33.79', '245.00', '0.00', '85253e0583b7f86deb0dcd86f060acbcae1e06b55bb28aa161342b4386d5f958', '2019-12-09 14:45:32', '2019-12-09 14:45:32');
INSERT INTO `shippr_transacciones` VALUES ('18', '6397210208', 'cargo_sobrepeso_saldo', 'Cargo por sobrepeso para el envío 4 de un monto $125.00', 'Envío #4', '1', 'envio', '4', 'pagado', 'Pago pendiente', 'user_wallet', '1', 'Nueva transacción', '107.76', '17.24', '125.00', '0.00', '99c11b3c262cc9db0ca891cb063dae95d66cba808162bcab8366ff01746259ed', '2019-12-09 14:46:25', '2019-12-09 15:00:51');
INSERT INTO `shippr_transacciones` VALUES ('19', '3054555327', 'recarga_saldo', 'Walter White solicitó recarga de saldo por $1,000.00 pesos', '1575925428', '28', 'recarga_saldo', '0', 'rechazado', 'Pago rechazado', 'efectivo', '1', 'Nueva transacción', '862.07', '137.93', '1000.00', '0.00', '9dd96197d170db3787d13f5c84733c91f21e1a9f4f4b680c92146ae6527cce0d', '2019-12-09 15:03:48', '2019-12-09 15:04:28');
INSERT INTO `shippr_transacciones` VALUES ('20', '1069007907', 'recarga_saldo', 'Walter White solicitó recarga de saldo por $1,000.00 pesos', '1575925497', '28', 'recarga_saldo', '0', 'abonado', 'Saldo abonado', 'efectivo', '1', 'Nueva transacción', '862.07', '137.93', '1000.00', '0.00', '41cc50e271ee9356ba8415f22bab8d7dafb1ea0ea14abd61c1e28922f22fa051', '2019-12-09 15:04:57', '2019-12-09 15:05:17');
INSERT INTO `shippr_transacciones` VALUES ('21', '9389744356', 'abono_saldo', 'Abono por $1,000.00 MXN', '1069007907', '28', 'abono_saldo', '0', 'pagado', 'Pago aprobado', 'efectivo', '1', 'Nueva transacción', '862.07', '137.93', '1000.00', '0.00', '3a4fdea97475f67b03d179011021d3869103c3ba969234ce4bd3f29b325fb8ff', '2019-12-09 15:05:17', '2019-12-09 15:05:17');
INSERT INTO `shippr_transacciones` VALUES ('22', '2175155577', 'retiro_saldo', 'Retiro por $165.00 MXN en compra realizada 4829075050', '1575925547', '28', 'compra', '5', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva transacción', '142.24', '22.76', '165.00', '0.00', 'c77278d166192c72ff5c3be37b668c96e65c81c2c620ea172cc45e49aa3bba77', '2019-12-09 15:05:47', '2019-12-09 15:05:47');
INSERT INTO `shippr_transacciones` VALUES ('23', '5047133804', 'cargo_sobrepeso_saldo', 'Cargo por sobrepeso para el envío 5 de un monto $127.55', 'Envío #5', '28', 'envio', '5', 'pagado', 'Pago pendiente', 'user_wallet', '1', 'Nueva transacción', '109.96', '17.59', '127.55', '0.00', '03341f57260b46a82692c9b9aabaf26f1a0d43828d75844987b03ac4496db817', '2019-12-09 15:11:57', '2019-12-09 15:12:27');
INSERT INTO `shippr_transacciones` VALUES ('24', '0614544811', 'retiro_saldo', 'Retiro por $140.00 MXN en compra realizada 4875696398', '1575927410', '28', 'compra', '6', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva transacción', '120.69', '19.31', '140.00', '0.00', 'effd7cff87e2172d6a778b91eef568271b310e0c8b9deff112456d093b6f975e', '2019-12-09 15:36:50', '2019-12-09 15:36:50');
INSERT INTO `shippr_transacciones` VALUES ('25', '3529475745', 'cargo_sobrepeso_saldo', 'Cargo por sobrepeso para el envío 6 de un monto $85.00', 'Envío #6', '28', 'envio', '6', 'pagado', 'Pago pendiente', 'user_wallet', '1', 'Nueva transacción', '73.28', '11.72', '85.00', '0.00', '739f1e57236a796752294f7698eb56a99e4c28f1b485418709dafabc0dbe53be', '2019-12-09 15:37:30', '2019-12-09 15:38:22');
INSERT INTO `shippr_transacciones` VALUES ('26', '3428222723', 'retiro_saldo', 'Retiro por $245.00 MXN en compra realizada 1460991153', '1575928279', '28', 'compra', '7', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva transacción', '211.21', '33.79', '245.00', '0.00', '7012d0c2498d9f4964f80edc6a189fbe6d4b9f779c27d593df1594581962e7bc', '2019-12-09 15:51:19', '2019-12-09 15:51:19');
INSERT INTO `shippr_transacciones` VALUES ('27', '9465770089', 'cargo_sobrepeso_saldo', 'Cargo por sobrepeso para el envío 7 de un monto $75.00', 'Envío #7', '28', 'envio', '7', 'pagado', 'Pago pendiente', 'user_wallet', '1', 'Nueva transacción', '64.66', '10.34', '75.00', '0.00', '7fb16754221f350551cf6291f2061adefe77d7bbb2b76cad98caa4d2bf311dda', '2019-12-09 15:51:55', '2019-12-09 15:52:25');
INSERT INTO `shippr_transacciones` VALUES ('28', '2433706375', 'retiro_saldo', 'Retiro por $140.00 MXN en compra realizada 0615952737', '1582047302', '1', 'compra', '8', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva transacción', '120.69', '19.31', '140.00', '0.00', 'b536a896375d358cc91454ad8a6321df8a8cd97898bb5b04c285cd2854f3c1a9', '2020-02-18 11:35:02', '2020-02-18 11:35:02');
INSERT INTO `shippr_transacciones` VALUES ('29', '7835582776', 'retiro_saldo', 'Retiro por $200.00 MXN en compra realizada 0282467808', '1582059333', '1', 'compra', '9', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva transacción', '172.41', '27.59', '200.00', '0.00', '94a1aee94b601ac1cae5ffc2be73291f73bdbb025a91911405309534f0cc1ad2', '2020-02-18 14:55:33', '2020-02-18 14:55:33');
INSERT INTO `shippr_transacciones` VALUES ('30', '978492649', 'devolucion_saldo', 'Reembolso por $200.00 shalala', '1582059333', '1', 'compra', '9', 'pagado', 'Pago aprobado', 'user_wallet', '1', '', '200.00', '0.00', '200.00', '0.00', '123', '2020-03-26 13:52:45', '2020-03-26 13:54:32');
INSERT INTO `shippr_transacciones` VALUES ('31', '9896299218', 'devolucion_saldo', 'Devolución por $0.00 MXN en compra realizada', '', '0', 'compra', '0', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva devolución', '0.00', '0.00', '0.00', '0.00', '95fb5e466444a502004cf47bbffa5e844c7292345e22c4dbc2b055f81e6960a1', '2020-03-26 14:27:36', '2020-03-26 14:27:36');
INSERT INTO `shippr_transacciones` VALUES ('32', '9668997189', 'devolucion_saldo', 'Devolución por $140.00 MXN en compra realizada 0615952737', '0615952737', '1', 'compra', '8', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva devolución', '120.69', '19.31', '140.00', '0.00', 'e7bd7aa678e45d3cef02bdd304bb962ac8f1fc145c65d26f3cf24e3b6e22249f', '2020-03-26 14:34:55', '2020-03-26 14:34:55');
INSERT INTO `shippr_transacciones` VALUES ('33', '1378043172', 'devolucion_saldo', 'Devolución por $245.00 MXN en compra realizada 9743769341', '9743769341', '1', 'compra', '4', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva devolución', '211.21', '33.79', '245.00', '0.00', '9043d59195eb031247cf57dcf693e55d57fb161448c7c278bf8ab391052c3067', '2020-03-26 14:36:43', '2020-03-26 14:36:43');
INSERT INTO `shippr_transacciones` VALUES ('34', '5074771649', 'devolucion_saldo', 'Devolución por $245.00 MXN en compra realizada 4856838984', '4856838984', '1', 'compra', '2', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva devolución', '211.21', '33.79', '245.00', '0.00', '2529cee2c87c3b247d1713e23d2c8a5229fa90c385165712f834a45109245bfd', '2020-03-26 14:38:34', '2020-03-26 14:38:34');
INSERT INTO `shippr_transacciones` VALUES ('35', '1264121888', 'retiro_saldo', 'Retiro por $416.23 MXN en compra realizada 0867993319', '1593446979', '1', 'compra', '10', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva transacción', '358.82', '57.41', '416.23', '0.00', 'ff7e4b1a810d0ef78fceda3cefae6536269e8aff24108d2df5682f40a174fc68', '2020-06-29 11:09:39', '2020-06-29 11:09:39');
INSERT INTO `shippr_transacciones` VALUES ('36', '8413308934', 'retiro_saldo', 'Retiro por $416.23 MXN en compra realizada 0867993319', '1593447210', '1', 'compra', '10', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva transacción', '358.82', '57.41', '416.23', '0.00', '2548f6e2a2b53954d8497646cbb6b5eb4548038a6e1e7d1d23624ba17e6cd9cf', '2020-06-29 11:13:30', '2020-06-29 11:13:30');
INSERT INTO `shippr_transacciones` VALUES ('37', '3196377320', 'recarga_saldo', 'Root user solicitó recarga de saldo por $1,500.00 pesos', '1593447485', '1', 'recarga_saldo', '0', 'abonado', 'Saldo abonado', 'efectivo', '1', 'Nueva transacción', '1293.10', '206.90', '1500.00', '0.00', '1ca7a00b3a5d8dada2a76690791b5d8b28663c2e923560e825f440027a2fec32', '2020-06-29 11:18:05', '2020-06-29 11:18:20');
INSERT INTO `shippr_transacciones` VALUES ('38', '7392735449', 'abono_saldo', 'Abono por $1,500.00 MXN', '3196377320', '1', 'abono_saldo', '0', 'pagado', 'Pago aprobado', 'efectivo', '1', 'Nueva transacción', '1293.10', '206.90', '1500.00', '0.00', '680c11c75fad13084240065347d33917286ba5286d52c47cac4987aff2709615', '2020-06-29 11:18:20', '2020-06-29 11:18:20');
INSERT INTO `shippr_transacciones` VALUES ('39', '6689597395', 'retiro_saldo', 'Retiro por $176.23 MXN en compra realizada 2798959425', '1593447626', '1', 'compra', '11', 'pagado', 'Pago aprobado', 'user_wallet', '1', 'Nueva transacción', '151.92', '24.31', '176.23', '0.00', 'de09798facf407a20874a6126bd44a6be20d6a3c1e6accd7dc19496a95c142a8', '2020-06-29 11:20:26', '2020-06-29 11:20:26');
INSERT INTO `shippr_transacciones` VALUES ('40', '9270984443', 'recarga_saldo', 'Root user solicitó recarga de saldo por $1,000.00 pesos', '1638497287', '1', 'recarga_saldo', '0', 'rechazado', 'Pago rechazado', 'efectivo', '1', 'Nueva transacción', '862.07', '137.93', '1000.00', '0.00', '188ff974dcb29485eb08d8d1446fccb4d04fa43840d3f7d40446782009abba61', '2021-12-02 20:08:07', '2021-12-04 15:10:07');
INSERT INTO `shippr_transacciones` VALUES ('41', '1187213492', 'recarga_saldo', 'Walter White solicitó recarga de saldo por $5,000.00 pesos', '1638652040', '28', 'recarga_saldo', '0', 'abonado', 'Saldo abonado', 'efectivo', '1', 'Nueva transacción', '4310.34', '689.66', '5000.00', '0.00', '2eaba8d22967e51e8369b0f02fcec60c932f16135eb30125704a306290e50758', '2021-12-04 15:07:20', '2021-12-04 15:10:29');
INSERT INTO `shippr_transacciones` VALUES ('42', '8121831221', 'abono_saldo', 'Abono por $5,000.00 MXN', '1187213492', '28', 'abono_saldo', '0', 'pagado', 'Pago aprobado', 'efectivo', '1', 'Nueva transacción', '4310.34', '689.66', '5000.00', '0.00', 'fc65df747e7a63aa007b67a0892d878d02f3d5e8ec86d22a7a32a3c8bacaf7ec', '2021-12-04 15:10:29', '2021-12-04 15:10:29');

-- ----------------------------
-- Table structure for shippr_zonas
-- ----------------------------
DROP TABLE IF EXISTS `shippr_zonas`;
CREATE TABLE `shippr_zonas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_courier` int(11) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `tipo_servicio` varchar(255) DEFAULT NULL,
  `zona_extendida` int(3) DEFAULT 0,
  `recoleccion` int(3) DEFAULT 1,
  `cargo` float(10,2) DEFAULT 0.00,
  `creado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=235 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shippr_zonas
-- ----------------------------
INSERT INTO `shippr_zonas` VALUES ('5', '2', '54719', 'exp', '1', '1', '11.23', '2020-02-18 14:33:17');
INSERT INTO `shippr_zonas` VALUES ('6', '5', '54719', 'eco', '1', '1', '12.35', '2020-02-18 14:50:36');
INSERT INTO `shippr_zonas` VALUES ('7', '4', '54719', 'eco', '0', '1', '0.00', '2020-02-20 11:39:45');
INSERT INTO `shippr_zonas` VALUES ('8', '3', '54719', 'eco', '1', '1', '19.95', '2020-02-20 11:40:00');
INSERT INTO `shippr_zonas` VALUES ('9', '1', '57896', 'exp', '0', '1', '0.00', '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('10', '1', '54719', 'eco', '0', '1', '0.00', '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('11', '1', '54715', 'exp', '0', '1', '0.00', '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('12', '1', '79815', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('13', '1', '79819', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('14', '1', '79820', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('15', '1', '79821', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('16', '1', '79822', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('17', '1', '79823', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('18', '1', '79825', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('19', '1', '79826', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('20', '1', '79830', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('21', '1', '79833', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('22', '1', '79834', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('23', '1', '79835', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('24', '1', '79836', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('25', '1', '79837', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('26', '1', '79840', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('27', '1', '79841', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('28', '1', '79842', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('29', '1', '79849', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('30', '1', '79850', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('31', '1', '79851', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('32', '1', '79852', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('33', '1', '79853', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('34', '1', '79854', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('35', '1', '79856', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('36', '1', '79859', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('37', '1', '79860', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('38', '1', '79861', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('39', '1', '79863', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('40', '1', '79864', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('41', '1', '79865', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('42', '1', '79866', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('43', '1', '79867', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('44', '1', '79870', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('45', '1', '79871', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('46', '1', '79874', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('47', '1', '79876', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('48', '1', '79878', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('49', '1', '79879', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('50', '1', '79880', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('51', '1', '79884', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('52', '1', '79887', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('53', '1', '79888', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('54', '1', '79889', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('55', '1', '79890', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('56', '1', '79891', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('57', '1', '79893', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('58', '1', '79895', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('59', '1', '79903', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('60', '1', '79910', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('61', '1', '79923', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('62', '1', '79930', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('63', '1', '79933', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('64', '1', '79935', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('65', '1', '79936', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('66', '1', '79937', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('67', '1', '79938', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('68', '1', '79940', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('69', '1', '79941', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('70', '1', '79942', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('71', '1', '79943', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('72', '1', '79944', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('73', '1', '79945', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('74', '1', '79946', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('75', '1', '79948', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('76', '1', '79950', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('77', '1', '79952', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('78', '1', '79953', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('79', '1', '79954', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('80', '1', '79955', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('81', '1', '79956', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('82', '1', '79957', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('83', '1', '79958', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('84', '1', '79963', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('85', '1', '79964', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('86', '1', '79967', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('87', '1', '79970', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('88', '1', '79973', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('89', '1', '79974', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('90', '1', '79975', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('91', '1', '79976', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('92', '1', '79977', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('93', '1', '79978', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('94', '1', '79980', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('95', '1', '79982', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('96', '1', '79985', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('97', '1', '79986', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('98', '1', '79987', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('99', '1', '79990', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('100', '1', '79995', 'eco', '1', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('101', '1', '80000', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('102', '1', '80010', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('103', '1', '80013', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('104', '1', '80014', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('105', '1', '80015', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('106', '1', '80016', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('107', '1', '80017', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('108', '1', '80018', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('109', '1', '80019', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('110', '1', '80020', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('111', '1', '80024', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('112', '1', '80025', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('113', '1', '80026', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('114', '1', '80027', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('115', '1', '80028', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('116', '1', '80029', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('117', '1', '80030', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('118', '1', '80034', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('119', '1', '80040', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('120', '1', '80050', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('121', '1', '80054', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('122', '1', '80055', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('123', '1', '80058', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('124', '1', '80059', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('125', '1', '80060', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('126', '1', '80063', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('127', '1', '80064', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('128', '1', '80065', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('129', '1', '80070', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('130', '1', '80080', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('131', '1', '80088', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('132', '1', '80090', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('133', '1', '80093', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('134', '1', '80100', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('135', '1', '80101', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('136', '1', '80103', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('137', '1', '80104', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('138', '1', '80105', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('139', '1', '80106', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('140', '1', '80107', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('141', '1', '80109', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('142', '1', '80110', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('143', '1', '80120', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('144', '1', '80128', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('145', '1', '80129', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('146', '1', '80130', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('147', '1', '80135', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('148', '1', '80139', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('149', '1', '80140', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('150', '1', '80143', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('151', '1', '80144', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('152', '1', '80145', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('153', '1', '80150', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('154', '1', '80155', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('155', '1', '80159', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('156', '1', '80160', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('157', '1', '80170', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('158', '1', '80176', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('159', '1', '80177', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('160', '1', '80178', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('161', '1', '80179', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('162', '1', '80180', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('163', '1', '80184', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('164', '1', '80189', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('165', '1', '80190', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('166', '1', '80194', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('167', '1', '80197', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('168', '1', '80199', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('169', '1', '80200', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('170', '1', '80210', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('171', '1', '80220', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('172', '1', '80225', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('173', '1', '80227', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('174', '1', '80228', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('175', '1', '80230', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('176', '1', '80240', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('177', '1', '80246', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('178', '1', '80247', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('179', '1', '80248', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('180', '1', '80249', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('181', '1', '80250', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('182', '1', '80260', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('183', '1', '80270', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('184', '1', '80279', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('185', '1', '80280', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('186', '1', '80290', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('187', '1', '80294', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('188', '1', '80295', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('189', '1', '80296', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('190', '1', '80297', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('191', '1', '80298', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('192', '1', '80299', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('193', '1', '80300', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('194', '1', '80301', 'exp', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('195', '1', '80302', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('196', '1', '80303', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('197', '1', '80304', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('198', '1', '80305', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('199', '1', '80308', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('200', '1', '80309', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('201', '1', '80310', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('202', '1', '80311', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('203', '1', '80313', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('204', '1', '80314', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('205', '1', '80315', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('206', '1', '80316', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('207', '1', '80317', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('208', '1', '80318', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('209', '1', '80319', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('210', '1', '80380', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('211', '1', '80383', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('212', '1', '80384', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('213', '1', '80385', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('214', '1', '80386', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('215', '1', '80387', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('216', '1', '80390', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('217', '1', '80391', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('218', '1', '80393', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('219', '1', '80394', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('220', '1', '80396', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('221', '1', '80397', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('222', '1', '80398', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('223', '1', '80399', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('224', '1', '80400', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('225', '1', '80402', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('226', '1', '80403', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('227', '1', '80405', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('228', '1', '80408', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('229', '1', '80409', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('230', '1', '80410', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('231', '1', '80411', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('232', '1', '80415', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('233', '1', '80416', 'eco', '0', null, null, '2020-02-20 12:05:25');
INSERT INTO `shippr_zonas` VALUES ('234', '1', '80417', 'eco', '0', null, null, '2020-02-20 12:05:25');

-- ----------------------------
-- Table structure for tokens
-- ----------------------------
DROP TABLE IF EXISTS `tokens`;
CREATE TABLE `tokens` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_ref` bigint(20) DEFAULT NULL,
  `token` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `lifetime` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valid` int(10) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tokens
-- ----------------------------
INSERT INTO `tokens` VALUES ('1', '26', 'be8d9fe3407a304aa492d3894246b778df4463f8fd56988a24024933a053acf9', '1574878600', '1', '2019-11-26 12:16:40', '2019-11-26 12:16:40');
INSERT INTO `tokens` VALUES ('2', '1', '96c55aa1624c4a51e625ff7b2bf045cf506975f30eb8331caef5ea6748e1b73d', '1575681293', '1', '2019-12-06 13:14:53', '2019-12-06 13:14:53');
INSERT INTO `tokens` VALUES ('3', '25', '5eb92cfb8dce534510278b3900eb9c830deffad8f752ce7f66266a97b5ee2051', '1576085573', '1', '2019-12-10 11:32:53', '2019-12-10 11:32:53');
INSERT INTO `tokens` VALUES ('4', '23', 'afad95a5b38e56908857b3f16caa92c67a86f799b246054805e588d0243b7312', '1576085634', '1', '2019-12-10 11:33:54', '2019-12-10 11:33:54');
INSERT INTO `tokens` VALUES ('5', '22', '75623e4224d447f39c32f2a958f227f88afa1ea34419d43da457769c75e0634f', '1647445010', '0', '2022-03-15 09:36:50', '2022-03-15 09:40:37');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int(5) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verificado` int(5) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_role` int(10) DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `perfil` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firma` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `background` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `redesSociales` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(5) DEFAULT NULL,
  `token` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empresa` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razon_social` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rfc` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cp` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `calle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num_ext` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num_int` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `colonia` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ciudad` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coordenadas` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credito` float(20,2) DEFAULT NULL,
  `api_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT 0,
  `time_active` bigint(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('1', 'root', 'jslocal@localhost.com', '1', '$2y$10$JsEFyxqIYbbHZh4Dd925zu0G3VSXzuztElr.LEQcjSlOS2KJ2.EQ.', 'Root user', '1', 'Root user biografía', 'wea7ffulyqtm-s4rrywnkh9xw-rjvrunmtzp9v-320.png', null, 'pwrebzupwxox-ghdogosywexj-zquuiqjvmvmr-852.jpg', '{\"facebook\":\"https:\\/\\/www.facebook.com\\/joystickdesign\",\"twitter\":\"https:\\/\\/www.twitter.com\\/JoystickDG\",\"instagram\":\"\",\"whatsapp\":\"5512345678\",\"email\":\"jslocal@localhost.com\",\"google\":\"\"}', '127.0.0.1', '0', '0fe67983c8139ae00e47c8fe3a2bceebc2eba721f04763915c1ef63c796c6c8a', 'Joystick SA de CV', 'JHON DOE VILLA', 'OOAR931128479', '5512345678', '57896', 'Una calle en México', '22', '', 'VIRGENCITAS', 'NEZAHUÁLCOYOTL', 'MÉXICO', null, null, '969e4319edf425cce370c79bc8a1a733c4776701a579f57b0ff3fdae436a84b3', '0', '1647359096', '2018-06-13 09:06:04', '2022-03-15 09:44:56');
INSERT INTO `usuarios` VALUES ('22', 'admin', 'jslocal@localhost.com', '1', '$2y$10$JsEFyxqIYbbHZh4Dd925zu0G3VSXzuztElr.LEQcjSlOS2KJ2.EQ.', 'Walter White', '2', null, null, null, null, null, null, '0', '1f22854af1b30fc9b97a26764da355e77424dc8dffa6fc17416ebf871cd945a7', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '1647358854', '2019-11-25 15:21:10', '2022-03-15 09:40:54');
INSERT INTO `usuarios` VALUES ('23', 'yoshio', 'jslocal@localhost.com', '1', '$2y$10$JsEFyxqIYbbHZh4Dd925zu0G3VSXzuztElr.LEQcjSlOS2KJ2.EQ.', 'Yoshio Gaynuroz', '2', null, null, null, null, null, null, '0', '0d5f32d22c50661cda614c6e36ac5508d512c0ab553f4c87da0033f3bd7a4870', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null, '2019-11-25 15:23:12', '2022-03-15 09:41:00');
INSERT INTO `usuarios` VALUES ('24', 'walterwhite2', 'jslocal@localhost.com', '1', '$2y$10$JsEFyxqIYbbHZh4Dd925zu0G3VSXzuztElr.LEQcjSlOS2KJ2.EQ.', 'Walter White', '2', null, null, null, null, null, null, '0', '15299c1a3db32d5c6d6b08dc1618c8c40b200afc07282a92005b3eea454d125e', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '1574720054', '2019-11-25 15:28:59', '2022-03-15 09:41:00');
INSERT INTO `usuarios` VALUES ('25', 'walterwhite3', 'jslocal@localhost.com', '1', '$2y$10$JsEFyxqIYbbHZh4Dd925zu0G3VSXzuztElr.LEQcjSlOS2KJ2.EQ.', 'Walter White', '2', null, null, null, null, null, null, '0', '76933cf38f5edbe3f3413165fd55ab74f63d5847224602cf8a2f02c7ee3398a7', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null, '2019-11-25 15:29:55', '2022-03-15 09:41:00');
INSERT INTO `usuarios` VALUES ('27', 'roborozco', 'roborozco@joystick.com.mx', '1', '$2y$10$JsEFyxqIYbbHZh4Dd925zu0G3VSXzuztElr.LEQcjSlOS2KJ2.EQ.', 'Roberto Orozco', '6', null, null, null, null, null, '127.0.0.1', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', null, '2019-11-26 11:40:10', '2022-03-15 09:41:00');
INSERT INTO `usuarios` VALUES ('28', 'regular', 'jslocal2@localhost.com', '1', '$2y$10$JsEFyxqIYbbHZh4Dd925zu0G3VSXzuztElr.LEQcjSlOS2KJ2.EQ.', 'Walter White', '3', null, null, null, null, null, '127.0.0.1', '0', 'f7ab0e97c9f8c44605b90920df7880cc1751867de34054a504a8ab5bebbded92', null, null, null, null, null, null, null, null, null, null, null, null, null, 'f921302d9233a1ba33b12c01120be41464f047d3d64c6f951f6eb62821b5e085', '0', '1647359027', '2019-12-09 15:03:12', '2022-03-15 09:43:47');

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
  `thumb` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of va_couriers
-- ----------------------------
INSERT INTO `va_couriers` VALUES ('1', 'fedex', 'FedEx', '1 800 463 3339 / 03456 070809 / 1800 419 4343', 'Federal Express', 'https://www.fedex.com/', 'fedex.jpg', '2018-12-21 20:03:43', '2019-10-07 13:04:06');
INSERT INTO `va_couriers` VALUES ('2', 'dhl', 'DHL', '+1 800 225 5345', 'DHL International', 'https://www.dhl.com/', 'dhl.jpg', '2018-12-21 20:04:18', '2019-10-08 17:54:16');
INSERT INTO `va_couriers` VALUES ('3', 'estafeta', 'Estafeta', '+52 1-800-378-2338', 'Estafeta Mexicana', 'https://www.estafeta.com/', 'estafeta.jpg', '2018-12-21 20:04:59', '2019-10-07 13:04:29');
INSERT INTO `va_couriers` VALUES ('4', 'ups', 'UPS', '+1 800 742 5877', 'United Parcel Service', 'https://www.ups.com', 'ups.jpg', '2018-12-21 20:05:24', '2019-10-07 13:04:34');
INSERT INTO `va_couriers` VALUES ('5', 'mexico-redpack', 'Mexico Repack', '+52 1800-013-3333', 'TNT Mexico', 'https://www.redpack.com.mx', 'redpack.jpg', '2018-12-21 20:06:05', '2019-10-07 13:04:28');
INSERT INTO `va_couriers` VALUES ('6', 'paquetexpress', 'Paquetexpress', '+01 800 8210 208', 'Paquetexpress', 'https://www.paquetexpress.com.mx', 'paquetexpress.png', '2018-12-21 20:07:18', '2019-10-09 13:13:29');

-- ----------------------------
-- Table structure for va_subscriptions
-- ----------------------------
DROP TABLE IF EXISTS `va_subscriptions`;
CREATE TABLE `va_subscriptions` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) DEFAULT NULL,
  `id_usuario` bigint(10) DEFAULT NULL,
  `id_sub_type` int(3) DEFAULT NULL,
  `start` bigint(10) DEFAULT NULL,
  `end` bigint(10) DEFAULT NULL,
  `cancelled` bigint(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of va_subscriptions
-- ----------------------------

-- ----------------------------
-- Table structure for va_sub_transactions
-- ----------------------------
DROP TABLE IF EXISTS `va_sub_transactions`;
CREATE TABLE `va_sub_transactions` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `id_sub` bigint(10) DEFAULT NULL,
  `id_transaction` bigint(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of va_sub_transactions
-- ----------------------------

-- ----------------------------
-- Table structure for va_sub_types
-- ----------------------------
DROP TABLE IF EXISTS `va_sub_types`;
CREATE TABLE `va_sub_types` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `regular_price` float(10,2) DEFAULT NULL,
  `sale_price` float(10,2) DEFAULT NULL,
  `comission_rate` float(10,4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of va_sub_types
-- ----------------------------

-- ----------------------------
-- Table structure for va_transacciones
-- ----------------------------
DROP TABLE IF EXISTS `va_transacciones`;
CREATE TABLE `va_transacciones` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `id_ref` bigint(20) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_detalle` varchar(255) DEFAULT NULL,
  `pago_numero` bigint(30) DEFAULT NULL,
  `metodo_pago` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `mensualidades` int(10) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `subtotal` float(10,2) DEFAULT NULL,
  `impuestos` float(10,2) DEFAULT NULL,
  `debido` float(10,2) DEFAULT NULL,
  `total` float(10,2) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `actualizado` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of va_transacciones
-- ----------------------------

-- ----------------------------
-- Table structure for ventas
-- ----------------------------
DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `folio` varchar(255) DEFAULT NULL,
  `id_usuario` bigint(10) DEFAULT NULL,
  `nonce` varchar(255) DEFAULT NULL,
  `metodo_pago` varchar(255) DEFAULT NULL,
  `pago_status` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `collection_id` varchar(255) DEFAULT NULL,
  `preference_id` varchar(255) DEFAULT NULL,
  `merchant_order_id` varchar(255) DEFAULT NULL,
  `subtotal` float(20,2) DEFAULT NULL,
  `comision` float(20,2) DEFAULT NULL,
  `total` float(20,2) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `actualizado` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ventas
-- ----------------------------
INSERT INTO `ventas` VALUES ('1', '5454110925', '1', '3effefa38cb0a2439f17881a9ddaf8dc75ff0781490ac128ec4daf8b8377cf99', 'user_wallet', 'pagado', 'completada', '', null, null, '165.00', '0.00', '165.00', '2019-12-06 12:27:39', '2019-12-06 14:21:00');
INSERT INTO `ventas` VALUES ('2', '4856838984', '1', '1746346b54e718d27d318589c0d05877afe1c687807fcdf89d9b3f82593cf49c', 'user_wallet', 'devuelto', 'cancelada', null, null, null, '245.00', '0.00', '245.00', '2019-12-06 18:12:01', '2020-03-26 14:38:34');
INSERT INTO `ventas` VALUES ('3', '9731021127', '1', '5d3297ed43631eba4cfb5f718e0536cd53b63130fcb1d8917046e0aa42ad010c', 'user_wallet', 'pagado', 'en-proceso', null, null, null, '165.00', '0.00', '165.00', '2019-12-09 13:01:36', '2019-12-09 13:01:37');
INSERT INTO `ventas` VALUES ('4', '9743769341', '1', 'e7df80ece5b23f9d3cb3d3a7a7f2e8774a044901fe0fa328035a55a4f9d4b955', 'user_wallet', 'devuelto', 'cancelada', null, null, null, '245.00', '0.00', '245.00', '2019-12-09 14:45:32', '2020-03-26 14:36:43');
INSERT INTO `ventas` VALUES ('5', '4829075050', '28', '0768a2f97fabb9cc2396adfaaf5a40b61b2cdca77a04f4555141335949a77ed2', 'user_wallet', 'pagado', 'en-proceso', null, null, null, '165.00', '0.00', '165.00', '2019-12-09 15:05:47', '2019-12-09 15:05:48');
INSERT INTO `ventas` VALUES ('6', '4875696398', '28', 'a95544216a1521c5c27faa7549110a108960b2a28e669817e7d95f7b2ea6d54c', 'user_wallet', 'pagado', 'en-proceso', null, null, null, '140.00', '0.00', '140.00', '2019-12-09 15:36:50', '2019-12-09 15:36:50');
INSERT INTO `ventas` VALUES ('7', '1460991153', '28', '38fc0be0ef0dd2798e56ed297fa34d9f648ab96b01b51b0f676078eecf515094', 'user_wallet', 'pagado', 'completada', '', null, null, '245.00', '0.00', '245.00', '2019-12-09 15:51:19', '2019-12-10 11:52:14');
INSERT INTO `ventas` VALUES ('8', '0615952737', '1', '77c22ae4b2759090bfb03613bf6807fe5bf98b1f821f948642cae560fdd5cb9e', 'user_wallet', 'devuelto', 'cancelada', null, null, null, '140.00', '0.00', '140.00', '2020-02-18 11:35:01', '2020-03-26 14:34:55');
INSERT INTO `ventas` VALUES ('9', '0282467808', '1', 'ef190be8d854c04c0a8d72166e9203bf5e24aa35c71159cebba649fefeb18d2a', 'user_wallet', 'devuelto', 'cancelada', null, null, null, '200.00', '0.00', '200.00', '2020-02-18 14:55:33', '2020-03-26 13:39:23');
INSERT INTO `ventas` VALUES ('10', '0867993319', '1', '6dfd82548f14bf036c0fbcfba603daef6ee8dee1f275176f148415a5797a5b72', 'user_wallet', 'pagado', 'en-proceso', null, null, null, '416.23', '0.00', '416.23', '2020-06-29 11:09:38', '2020-06-29 11:13:30');
INSERT INTO `ventas` VALUES ('11', '2798959425', '1', '36e149dcdf2a7fecb8e428e15497a859394e01bf9fcd3d6197df442c1b9bbbc6', 'user_wallet', 'pagado', 'completada', '6689597395', null, null, '176.23', '0.00', '176.23', '2020-06-29 11:20:26', '2020-06-29 12:27:04');
