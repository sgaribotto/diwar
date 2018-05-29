-- MySQL dump 10.15  Distrib 10.0.24-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: diwar
-- ------------------------------------------------------
-- Server version	10.0.24-MariaDB-1~trusty

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articulos`
--

DROP TABLE IF EXISTS `articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_articulo` varchar(255) NOT NULL,
  `modelo_con_mecanismo` int(11) NOT NULL,
  `variaciones` int(11) NOT NULL,
  `en_uso` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `modelo_con_mecanismo` (`modelo_con_mecanismo`,`variaciones`),
  KEY `modelos_con_mecanismo` (`modelo_con_mecanismo`),
  KEY `variaciones` (`variaciones`),
  CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`modelo_con_mecanismo`) REFERENCES `modelos_con_mecanismo` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `variaciones` FOREIGN KEY (`variaciones`) REFERENCES `variaciones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos`
--

LOCK TABLES `articulos` WRITE;
/*!40000 ALTER TABLE `articulos` DISABLE KEYS */;
INSERT INTO `articulos` VALUES (25,'1',1,5,1),(26,'1',1,6,1),(27,'1',1,7,1),(28,'1',1,8,1),(29,'1',1,9,1),(30,'1',1,10,1),(31,'1',1,11,1),(32,'1',1,12,1),(33,'1',1,13,1),(34,'1',1,14,1),(35,'1',1,15,1),(36,'1',1,16,1),(37,'1',1,17,1),(38,'1',1,18,1),(39,'1',1,19,1),(40,'1',1,20,1),(41,'1',1,21,1),(42,'1',1,22,1),(43,'1',1,23,1),(44,'1',1,24,1),(45,'2',2,5,1),(46,'2',2,6,1),(47,'2',2,7,1),(48,'2',2,8,1),(49,'2',2,9,1),(50,'2',2,10,1),(51,'2',2,11,1),(52,'2',2,12,1),(53,'2',2,13,1),(54,'2',2,14,1),(55,'2',2,15,1),(56,'2',2,16,1),(57,'2',2,17,1),(58,'2',2,18,1),(59,'2',2,19,1),(60,'2',2,20,1),(61,'2',2,21,1),(62,'2',2,22,1),(63,'2',2,23,1),(64,'2',2,24,1),(65,'3',3,22,1),(66,'3',3,23,1),(67,'3',3,24,1),(68,'4',4,22,1),(69,'4',4,23,1),(70,'4',4,24,1),(71,'5',5,5,1),(72,'5',5,6,1),(73,'5',5,7,1),(74,'5',5,8,1),(75,'5',5,9,1),(76,'5',5,10,1),(77,'5',5,11,1),(78,'5',5,12,1),(79,'5',5,13,1),(80,'5',5,14,1),(81,'5',5,15,1),(82,'5',5,16,1),(83,'5',5,17,1),(84,'5',5,18,1),(85,'5',5,19,1),(86,'5',5,20,1),(87,'5',5,21,1),(88,'5',5,22,1),(89,'5',5,23,1),(90,'5',5,24,1),(91,'6',6,5,0),(92,'6',6,6,0),(93,'6',6,7,1),(94,'6',6,8,1),(95,'6',6,9,1),(96,'6',6,10,1),(97,'6',6,11,1),(98,'6',6,12,1),(99,'6',6,13,1),(100,'6',6,14,1),(101,'6',6,15,1),(102,'6',6,16,0),(103,'6',6,17,1),(104,'6',6,18,0),(105,'6',6,19,1),(106,'6',6,20,1),(107,'6',6,21,1),(108,'6',6,22,1),(109,'6',6,23,1),(110,'6',6,24,1),(111,'7',7,22,1),(112,'7',7,23,1),(113,'7',7,24,1),(114,'8',8,22,1),(115,'8',8,23,1),(116,'8',8,24,1);
/*!40000 ALTER TABLE `articulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CUIT` varchar(255) NOT NULL,
  `codigo_cliente` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `localidad` varchar(255) NOT NULL,
  `codigo_postal` varchar(255) NOT NULL,
  `provincia` varchar(255) NOT NULL,
  `pais` varchar(255) DEFAULT 'Argentina',
  `direccion` varchar(255) NOT NULL,
  `observaciones` text NOT NULL,
  `en_uso` tinyint(4) NOT NULL DEFAULT '1',
  `iva` varchar(255) DEFAULT 'RI',
  `tipo_factura` varchar(255) DEFAULT 'B',
  PRIMARY KEY (`id`),
  UNIQUE KEY `CUIT` (`CUIT`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'20-369588796-2','XX-GAR','Cliente 1','CABA','1418','CABA','Argentina','Lanin 111','test',1,'RI','B'),(2,'20-30651666-3','test','test','ttset','1516','CABA','Argentina','test','test',1,'RI','B');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes_vendedores`
--

DROP TABLE IF EXISTS `clientes_vendedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes_vendedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) NOT NULL,
  `vendedor` int(11) NOT NULL,
  `observaciones` text,
  `en_uso` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes_vendedores`
--

LOCK TABLES `clientes_vendedores` WRITE;
/*!40000 ALTER TABLE `clientes_vendedores` DISABLE KEYS */;
INSERT INTO `clientes_vendedores` VALUES (1,1,1,'',0),(2,1,1,'test4',1),(3,1,1,'',0),(4,1,1,'test',0),(5,1,1,'test',0),(6,1,1,'test',0);
/*!40000 ALTER TABLE `clientes_vendedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colores`
--

DROP TABLE IF EXISTS `colores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `precio` double NOT NULL DEFAULT '0',
  `en_uso` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_colores` (`tipo`,`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colores`
--

LOCK TABLES `colores` WRITE;
/*!40000 ALTER TABLE `colores` DISABLE KEYS */;
INSERT INTO `colores` VALUES (1,'marathon','violeta','',0,1),(2,'marathon','rojo señal','',0,1),(3,'marathon','rojo','',0,1),(4,'marathon','petroleo','',0,1),(5,'marathon','negro','',0,1),(6,'marathon','naranja','',0,1),(7,'marathon','maiz','',0,1),(8,'marathon','gris titanio','',0,1),(9,'marathon','gris perla','',0,1),(10,'marathon','gris oscuro','',0,1),(11,'marathon','bordo','',0,1),(12,'marathon','azul marino','',0,1),(13,'marathon','azul','',0,1),(14,'marathon','aero','',0,1),(15,'marathon','beige','',0,1),(16,'marathon','verde','',0,1),(17,'eco cuero','amarillo','',0,1),(18,'eco cuero','aqua','',0,1),(19,'eco cuero','arena','',0,1),(20,'eco cuero','azul','',0,1),(21,'eco cuero','azul fosco','',0,1),(22,'eco cuero','azulino','',0,1),(23,'eco cuero','beige lotus','',0,1),(24,'eco cuero','blanco','',0,1),(25,'eco cuero','camel','',0,1),(26,'eco cuero','chocolate','',0,1),(27,'eco cuero','fucsia','',0,1),(28,'eco cuero','gris','',0,1),(29,'eco cuero','maiz','',0,1),(30,'eco cuero','marron','',0,1),(31,'eco cuero','naranja','',0,1),(32,'eco cuero','negro','',0,1),(33,'eco cuero','rojo fuego','',0,1),(34,'eco cuero','rojo tomate','',0,1),(35,'eco cuero','turquesa','',0,1),(36,'eco cuero','verde inglés','',0,1),(37,'eco cuero','verde manzana','',0,1),(38,'eco cuero','verde selva','',0,1),(39,'eco cuero','violeta','',0,1),(40,'red','azul','',0,1),(41,'red','bizon','',0,1),(42,'red','gris perla','',0,1),(43,'red','naranja','',0,1),(44,'red','negro','',0,1),(45,'red','petroleo','',0,1),(46,'red','rojo','',0,1),(47,'red','rojo fuego','',0,1),(48,'red','verde','',0,1);
/*!40000 ALTER TABLE `colores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactos`
--

DROP TABLE IF EXISTS `contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `valor` varchar(255) DEFAULT NULL,
  `en_uso` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactos`
--

LOCK TABLES `contactos` WRITE;
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
INSERT INTO `contactos` VALUES (1,1,'Jorge primo','mail','test primo ',1);
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datos_presupuesto`
--

DROP TABLE IF EXISTS `datos_presupuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datos_presupuesto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `presupuesto` int(11) NOT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `valor` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipo_por_presupuesto` (`presupuesto`,`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datos_presupuesto`
--

LOCK TABLES `datos_presupuesto` WRITE;
/*!40000 ALTER TABLE `datos_presupuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `datos_presupuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direcciones_entrega`
--

DROP TABLE IF EXISTS `direcciones_entrega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `direcciones_entrega` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `localidad` varchar(255) NOT NULL,
  `codigo_postal` varchar(255) NOT NULL,
  `provincia` varchar(255) NOT NULL,
  `pais` varchar(255) DEFAULT 'Argentina',
  `observaciones` text,
  `es_default` tinyint(4) DEFAULT '0',
  `en_uso` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direcciones_entrega`
--

LOCK TABLES `direcciones_entrega` WRITE;
/*!40000 ALTER TABLE `direcciones_entrega` DISABLE KEYS */;
INSERT INTO `direcciones_entrega` VALUES (1,1,'Carlos Antonio Lopez 3220 2B, CUIT 20306515153','Ciudad AutÃ³noma de Buenos Aires','1419','Buenos Aires','Argentina','test',0,1),(2,1,'Carlos Antonio Lopez 3220 2B','Ciudad AutÃ³noma de Buenos Aires','1419','Buenos Aires','Argentina','test',0,1),(3,1,'Carlos Antonio Lopez 3220 2B18','Ciudad AutÃ³noma de Buenos Aires','1419','Buenos Aires','Argentina','test',0,1),(4,1,'Carlos Antonio Lopez 3220 2B18','Ciudad AutÃ³noma de Buenos Aires','1419','Buenos Aires','Argentina','test',0,0),(5,1,'Carlos Antonio Lopez 3220 2B18','Ciudad AutÃ³noma de Buenos Aires','141915633','Buenos Aires','Argentina','test',0,0),(6,1,'Carlos Antonio Lopez 3220 2B18','Ciudad AutÃ³noma de Buenos Aires','1419','Buenos Aires','Argentina','test',0,0),(7,1,'Carlos Antonio Lopez 3220 2B, CUIT 20306515153','Ciudad AutÃ³noma de Buenos Aires','1418','Buenos Aires','Argentina','test',0,0),(8,1,'Carlos Antonio Lopez 3220 2B, CUIT 20306515153','Ciudad AutÃ³noma de Buenos Aires','1417777','Buenos Aires','Argentina','test',0,0),(9,1,'Carlos Antonio Lopez 3220 2B, CUIT 20306515153','Ciudad AutÃ³noma de Buenos Aires','1417','Buenos Aires','Argentina','test',0,0),(10,1,'Carlos Antonio Lopez 3220 2B, CUIT 20306515153','Ciudad AutÃ³noma de Buenos Aires','1417','Buenos Aires','Argentina','test',0,0),(11,1,'Carlos Antonio Lopez 3220 2B, CUIT 20306515153','Ciudad AutÃ³noma de Buenos Aires','1417','Buenos Aires','Argentina','test',0,0);
/*!40000 ALTER TABLE `direcciones_entrega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mecanismos`
--

DROP TABLE IF EXISTS `mecanismos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mecanismos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `precio` double NOT NULL DEFAULT '0',
  `en_uso` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_modelos` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mecanismos`
--

LOCK TABLES `mecanismos` WRITE;
/*!40000 ALTER TABLE `mecanismos` DISABLE KEYS */;
INSERT INTO `mecanismos` VALUES (1,'Synchron','regulacion de altura,  mecanismo syncrhon que  permite regular la inclinacion del respaldo,   UP-Down en la riñonera para regular  la misma Asiento multilaminado con goma espuma inyectada termoformado',6468,1),(2,'Basculante','regulacion de altura,  mecanismo basculante que  permite oscilar el mismo,UP-Down en la riñonera para regular  la misma Asiento miltilaminado con gomo espauma inyectada termoformado',0,1),(3,'Cantilever Negro','Estructura cantilever  con brazos terminacion negra, asiento multilaminadocon goma espuma inyectada termoformada',6678,1),(4,'Cantilever Cromado','Estructura cantilever  con brazos terminacion cromada, asiento multilaminadocon goma espuma inyectada termoformada',7203,1),(5,'test','test',1234,0);
/*!40000 ALTER TABLE `mecanismos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modelos`
--

DROP TABLE IF EXISTS `modelos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modelos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL DEFAULT 'silla',
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `precio` double NOT NULL DEFAULT '0',
  `en_uso` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_modelos` (`tipo`,`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modelos`
--

LOCK TABLES `modelos` WRITE;
/*!40000 ALTER TABLE `modelos` DISABLE KEYS */;
INSERT INTO `modelos` VALUES (1,'silla','test4','4234',4234,0),(2,'silla','Citiz sin cabezal','Silla Mod. Citiz Sin Cabezal',0,1),(3,'silla','Citiz con cabezal','Silla Mod. Citiz Con Cabezal',766.5,1),(5,'silla','teste4','asdfadf',23123,0),(6,'silla','trst','sfdafd',3123123,0),(8,'silla','gafgsdfg','fsadfaf',546546,1),(9,'silla','tasetat','testtt',596,0),(10,'silla','otro test','otooaosdt',434,0),(11,'silla','getzs','test',6,0),(13,'silla','nuevo test','test nuevo pero ahora con modificaciones',200,0),(16,'silla','testeamos','rtestest',2,0),(17,'silla','otro test test','test',10,1);
/*!40000 ALTER TABLE `modelos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modelos_con_mecanismo`
--

DROP TABLE IF EXISTS `modelos_con_mecanismo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modelos_con_mecanismo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelo` int(11) NOT NULL,
  `mecanismo` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `precio` double NOT NULL DEFAULT '0',
  `en_uso` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_modelo_mecanismo` (`modelo`,`mecanismo`),
  KEY `mecanismos` (`mecanismo`),
  CONSTRAINT `modelos_con_mecanismo_ibfk_1` FOREIGN KEY (`modelo`) REFERENCES `modelos` (`id`),
  CONSTRAINT `modelos_con_mecanismo_ibfk_2` FOREIGN KEY (`mecanismo`) REFERENCES `mecanismos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modelos_con_mecanismo`
--

LOCK TABLES `modelos_con_mecanismo` WRITE;
/*!40000 ALTER TABLE `modelos_con_mecanismo` DISABLE KEYS */;
INSERT INTO `modelos_con_mecanismo` VALUES (1,2,1,'',0,1),(2,2,2,'',0,1),(3,2,3,'',0,1),(4,2,4,'',0,1),(5,3,1,'',0,0),(6,3,2,'',0,1),(7,3,3,'',0,1),(8,3,4,'',0,1),(63,8,1,'',0,1),(64,8,3,'',0,1),(65,8,4,'',0,0);
/*!40000 ALTER TABLE `modelos_con_mecanismo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presupuestos`
--

DROP TABLE IF EXISTS `presupuestos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `presupuestos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` bigint(20) NOT NULL,
  `cliente` int(11) NOT NULL,
  `vendedor` int(11) NOT NULL,
  `articulo` int(11) NOT NULL,
  `color_red` int(11) DEFAULT NULL,
  `color_tapizado` int(11) DEFAULT NULL,
  `color_casco` int(11) DEFAULT NULL,
  `cantidad` int(10) unsigned NOT NULL,
  `precio_a_la_emision` double DEFAULT '0',
  `descuento_articulo` double DEFAULT '0',
  `fecha_emision` timestamp NULL DEFAULT NULL,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `emitido` tinyint(4) NOT NULL DEFAULT '0',
  `variaciones` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `numero` (`numero`),
  KEY `articulo` (`articulo`),
  KEY `cliente` (`cliente`),
  KEY `vendedor` (`vendedor`),
  KEY `color_red` (`color_red`),
  KEY `color_casco` (`color_casco`),
  KEY `color_tapizado` (`color_tapizado`),
  CONSTRAINT `cliente` FOREIGN KEY (`cliente`) REFERENCES `clientes` (`id`),
  CONSTRAINT `color_casco` FOREIGN KEY (`color_casco`) REFERENCES `colores` (`id`),
  CONSTRAINT `color_red` FOREIGN KEY (`color_red`) REFERENCES `colores` (`id`),
  CONSTRAINT `color_tapizado` FOREIGN KEY (`color_tapizado`) REFERENCES `colores` (`id`),
  CONSTRAINT `presupuestos_ibfk_1` FOREIGN KEY (`articulo`) REFERENCES `modelos_con_mecanismo` (`id`),
  CONSTRAINT `vendedor` FOREIGN KEY (`vendedor`) REFERENCES `vendedores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presupuestos`
--

LOCK TABLES `presupuestos` WRITE;
/*!40000 ALTER TABLE `presupuestos` DISABLE KEYS */;
INSERT INTO `presupuestos` VALUES (12,1,1,1,1,NULL,NULL,NULL,1,8382,0,'2018-05-13 02:35:53','2018-05-13 02:35:53',1,'15, 17, 19, 22, 24'),(13,1,1,1,3,47,13,NULL,1,6678,0,'2018-05-13 02:35:54','2018-05-13 02:35:54',1,'22, 24'),(14,1,1,1,3,42,12,NULL,1,6678,0,'2018-05-13 02:35:54','2018-05-13 02:35:54',1,'22, 24'),(16,1,1,1,3,40,14,NULL,1,6678,0,'2018-05-13 02:35:54','2018-05-13 02:35:54',1,'22, 24'),(17,1,1,1,1,46,4,NULL,1,7282,0,'2018-05-13 02:35:54','2018-05-13 02:35:54',1,'15, 18, 19, 22, 24'),(18,2,1,1,1,40,14,NULL,1,7189.6,5,'2018-05-13 14:52:00','2018-05-13 14:52:00',1,'5, 17, 19, 22, 24'),(19,3,1,1,4,40,14,NULL,1,0,0,NULL,'2018-05-13 15:19:41',0,'22, 24');
/*!40000 ALTER TABLE `presupuestos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL DEFAULT 'vendedor',
  `vendedor` int(11) DEFAULT NULL,
  `usuario` varchar(255) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `en_uso` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'vendedor',1,'gari','1dff9ef3751f8930e1222a440958f295',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variaciones`
--

DROP TABLE IF EXISTS `variaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `precio` double NOT NULL DEFAULT '0',
  `en_uso` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_modelos` (`tipo`,`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variaciones`
--

LOCK TABLES `variaciones` WRITE;
/*!40000 ALTER TABLE `variaciones` DISABLE KEYS */;
INSERT INTO `variaciones` VALUES (5,'brazo','550','',0,1),(6,'brazo','670','',0,1),(7,'brazo','680','',0,1),(8,'brazo','338C','',0,1),(9,'brazo','338N','',0,1),(10,'brazo','340C','',0,1),(11,'brazo','340N','',0,1),(12,'brazo','342C','',0,1),(13,'brazo','342N','',0,1),(14,'brazo','350PP','DescripciÃ³n 350 PP',0,1),(15,'brazo','405PP','Brazo regulable en altura Mod. 405 PP',814,1),(16,'brazo','405PU','Brazo regulable en altura Mod. 405 PU',894,1),(17,'estrella','BTRC660','Estrella cromada de 5 ramas ',1100,1),(18,'estrella','Citiz','',0,1),(19,'rueda','RT900','',0,1),(20,'rueda','RT900 Parquet','',0,1),(21,'rueda','Patines','',0,1),(22,'tapizado','Marathon','Tapizado en marathon',0,1),(23,'tapizado','Eco cuero','Tapizado en eco cuero',0,1),(24,'red','red','Red color',0,1),(25,'casco','test','test',56,0);
/*!40000 ALTER TABLE `variaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendedores`
--

DROP TABLE IF EXISTS `vendedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `localidad` varchar(255) NOT NULL,
  `provincia` varchar(255) NOT NULL,
  `observaciones` text NOT NULL,
  `en_uso` tinyint(4) NOT NULL DEFAULT '1',
  `codigo_postal` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendedores`
--

LOCK TABLES `vendedores` WRITE;
/*!40000 ALTER TABLE `vendedores` DISABLE KEYS */;
INSERT INTO `vendedores` VALUES (1,'vendedor 1','234','test','test','test','test','observaciones',1,'1419'),(2,'vendedor 2','213','test','test','test','test','',1,NULL);
/*!40000 ALTER TABLE `vendedores` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-28 12:18:10
