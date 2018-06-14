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
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos`
--

LOCK TABLES `articulos` WRITE;
/*!40000 ALTER TABLE `articulos` DISABLE KEYS */;
INSERT INTO `articulos` VALUES (25,'1',1,5,1),(26,'1',1,6,1),(27,'1',1,7,1),(28,'1',1,8,1),(29,'1',1,9,1),(30,'1',1,10,1),(31,'1',1,11,1),(32,'1',1,12,1),(33,'1',1,13,1),(34,'1',1,14,1),(35,'1',1,15,1),(36,'1',1,16,1),(37,'1',1,17,1),(38,'1',1,18,1),(39,'1',1,19,1),(40,'1',1,20,1),(41,'1',1,21,1),(42,'1',1,22,1),(43,'1',1,23,1),(44,'1',1,24,1),(45,'2',2,5,1),(46,'2',2,6,1),(47,'2',2,7,1),(48,'2',2,8,1),(49,'2',2,9,1),(50,'2',2,10,1),(51,'2',2,11,1),(52,'2',2,12,1),(53,'2',2,13,1),(54,'2',2,14,1),(55,'2',2,15,1),(56,'2',2,16,1),(57,'2',2,17,1),(58,'2',2,18,1),(59,'2',2,19,1),(60,'2',2,20,1),(61,'2',2,21,1),(62,'2',2,22,1),(63,'2',2,23,1),(64,'2',2,24,1),(65,'3',3,22,1),(66,'3',3,23,1),(67,'3',3,24,1),(68,'4',4,22,1),(69,'4',4,23,1),(70,'4',4,24,1),(71,'5',5,5,1),(72,'5',5,6,1),(73,'5',5,7,1),(74,'5',5,8,1),(75,'5',5,9,1),(76,'5',5,10,1),(77,'5',5,11,1),(78,'5',5,12,1),(79,'5',5,13,1),(80,'5',5,14,1),(81,'5',5,15,1),(82,'5',5,16,1),(83,'5',5,17,1),(84,'5',5,18,1),(85,'5',5,19,1),(86,'5',5,20,1),(87,'5',5,21,1),(88,'5',5,22,1),(89,'5',5,23,1),(90,'5',5,24,1),(91,'6',6,5,0),(92,'6',6,6,0),(93,'6',6,7,1),(94,'6',6,8,1),(95,'6',6,9,1),(96,'6',6,10,1),(97,'6',6,11,1),(98,'6',6,12,1),(99,'6',6,13,1),(100,'6',6,14,1),(101,'6',6,15,1),(102,'6',6,16,0),(103,'6',6,17,1),(104,'6',6,18,0),(105,'6',6,19,1),(106,'6',6,20,1),(107,'6',6,21,1),(108,'6',6,22,1),(109,'6',6,23,0),(110,'6',6,24,1),(111,'7',7,22,1),(112,'7',7,23,1),(113,'7',7,24,1),(114,'8',8,22,1),(115,'8',8,23,1),(116,'8',8,24,1),(117,'',4,8,1),(118,'',4,9,1),(119,'',4,10,1),(120,'',4,11,1);
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
  `iva` double DEFAULT '21',
  `tipo_factura` varchar(255) DEFAULT 'B',
  PRIMARY KEY (`id`),
  UNIQUE KEY `CUIT` (`CUIT`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'20-369588796-2','XX-GARY','Cliente 1 - nuevo','CABA','1418','CABA','Argentina','Lanin 111','test',1,21,'B'),(3,'20-30651666-3','1419','Santiago Garibotto','Ciudad AutÃ³noma de Buenos Aires','test','test','Argentina','test','test',1,21,'B'),(4,'20-15698636-1','12133','Hermes Dessio','Chegusan','1233','Cordoba','Argentina','Las rosas 3226','Sin observaciones',1,21,'B');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes_vendedores`
--

LOCK TABLES `clientes_vendedores` WRITE;
/*!40000 ALTER TABLE `clientes_vendedores` DISABLE KEYS */;
INSERT INTO `clientes_vendedores` VALUES (1,1,1,'',0),(2,1,1,'test4',1),(3,1,1,'',0),(4,1,1,'test',0),(5,1,1,'test',0),(6,1,1,'test',0),(7,2,1,NULL,1),(8,4,2,'',1),(9,4,1,'',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactos`
--

LOCK TABLES `contactos` WRITE;
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
INSERT INTO `contactos` VALUES (1,1,'Jorge primo','mail','test primo ',1),(2,4,'Hermes','mail','hermes@dession.com',1);
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
  `numero` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `vendedor` int(11) NOT NULL,
  `fecha_emision` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `iva` double NOT NULL DEFAULT '21',
  `descuento` double NOT NULL DEFAULT '0',
  `embalaje` double NOT NULL DEFAULT '0',
  `observaciones` text,
  `condicion` text,
  `emitido` tinyint(4) DEFAULT '0',
  `direccion_entrega` int(11) DEFAULT NULL,
  `tipo_factura` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero` (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datos_presupuesto`
--

LOCK TABLES `datos_presupuesto` WRITE;
/*!40000 ALTER TABLE `datos_presupuesto` DISABLE KEYS */;
INSERT INTO `datos_presupuesto` VALUES (1,1,1,1,'2018-05-30 12:44:38','2018-05-30 12:44:38',21,0,0,NULL,NULL,1,NULL,NULL),(2,2,1,1,'2018-05-30 12:44:38','2018-05-30 12:44:38',21,0,0,NULL,NULL,1,NULL,NULL),(3,3,1,1,'2018-06-06 22:56:09','2018-06-06 22:56:09',21,0,0,NULL,NULL,1,NULL,NULL),(83,4,1,1,'2018-06-01 02:18:45','2018-06-01 02:18:45',10.5,5,5,'test','SeÃ±a 50% y saldo contraentrega.',1,3,'B'),(85,6,4,2,'2018-06-03 23:17:24','2018-06-03 23:17:24',21,3,8,NULL,NULL,1,13,NULL),(87,5,1,1,'2018-06-06 23:02:02','2018-06-06 23:02:02',21,0,0,NULL,NULL,1,NULL,NULL),(88,7,1,1,'2018-06-06 22:54:19','2018-06-06 22:54:19',21,0,0,NULL,NULL,1,NULL,NULL),(89,8,1,1,'2018-06-06 23:03:20','2018-06-06 23:03:20',21,8,5,'Test de observaciones.',NULL,1,NULL,NULL),(90,9,1,1,'2018-06-06 23:04:44','2018-06-06 23:04:44',21,0,0,NULL,NULL,1,NULL,NULL),(91,10,1,1,'2018-06-10 01:37:07','0000-00-00 00:00:00',21,0,0,NULL,NULL,0,NULL,NULL),(92,11,1,1,'2018-06-10 02:20:33','0000-00-00 00:00:00',21,0,0,NULL,NULL,0,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direcciones_entrega`
--

LOCK TABLES `direcciones_entrega` WRITE;
/*!40000 ALTER TABLE `direcciones_entrega` DISABLE KEYS */;
INSERT INTO `direcciones_entrega` VALUES (1,1,'Carlos Antonio Lopez 3220 2B, CUIT 20306515153','Ciudad AutÃ³noma de Buenos Aires','1419','Buenos Aires','Argentina','test',0,1),(2,1,'Carlos Antonio Lopez 3220 2B','Ciudad AutÃ³noma de Buenos Aires','1419','Buenos Aires','Argentina','test',0,1),(3,1,'Carlos Antonio Lopez 3220 2B18','Ciudad AutÃ³noma de Buenos Aires','1419','Buenos Aires','Argentina','test',0,1),(4,1,'Carlos Antonio Lopez 3220 2B18','Ciudad AutÃ³noma de Buenos Aires','1419','Buenos Aires','Argentina','test',0,0),(5,1,'Carlos Antonio Lopez 3220 2B18','Ciudad AutÃ³noma de Buenos Aires','141915633','Buenos Aires','Argentina','test',0,0),(6,1,'Carlos Antonio Lopez 3220 2B18','Ciudad AutÃ³noma de Buenos Aires','1419','Buenos Aires','Argentina','test',0,0),(7,1,'Carlos Antonio Lopez 3220 2B, CUIT 20306515153','Ciudad AutÃ³noma de Buenos Aires','1418','Buenos Aires','Argentina','test',0,0),(8,1,'Carlos Antonio Lopez 3220 2B, CUIT 20306515153','Ciudad AutÃ³noma de Buenos Aires','1417777','Buenos Aires','Argentina','test',0,0),(9,1,'Carlos Antonio Lopez 3220 2B, CUIT 20306515153','Ciudad AutÃ³noma de Buenos Aires','1417','Buenos Aires','Argentina','test',0,0),(10,1,'Carlos Antonio Lopez 3220 2B, CUIT 20306515153','Ciudad AutÃ³noma de Buenos Aires','1417','Buenos Aires','Argentina','test',0,0),(11,1,'Carlos Antonio Lopez 3220 2B, CUIT 20306515153','Ciudad AutÃ³noma de Buenos Aires','1417','Buenos Aires','Argentina','test',0,0),(12,4,'zapala 6398 Timbre 2','Chegusan','1236','Buenos aires','Argentina','asdfasdf',0,1),(13,4,'zapala 6398 Timbre 2','Chegusan','1236','Buenos aires','Argentina','asdfasdf',0,1),(14,3,'Artigas 4620, 1 6','caba','1419','Ciudad AutÃ³noma de Buenos Aires','Argentina','',0,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mecanismos`
--

LOCK TABLES `mecanismos` WRITE;
/*!40000 ALTER TABLE `mecanismos` DISABLE KEYS */;
INSERT INTO `mecanismos` VALUES (1,'Synchron','regulacion de altura,  mecanismo syncrhon que  permite regular la inclinacion del respaldo,   UP-Down en la rinonera para regular  la misma Asiento multilaminado con goma espuma inyectada termoformado',6468,1),(2,'Basculante','regulacion de altura,  mecanismo basculante que  permite oscilar el mismo,UP-Down en la rinonera para regular  la misma Asiento miltilaminado con gomo espauma inyectada termoformado',0,1),(3,'Cantilever Negro','Estructura cantilever  con brazos terminacion negra, asiento multilaminadocon goma espuma inyectada termoformada',6678,1),(4,'Cantilever Cromado','Estructura cantilever  con brazos terminacion cromada, asiento multilaminadocon goma espuma inyectada termoformada',7203,1),(5,'test','test',1234,0),(6,'Neumatica','Con regulacion de altura atraves de un piston neumatico',0,1),(7,'syncrhon','regulacion de altura,  mecanismo syncrhon que  permite regular la inclinacion del respaldo,   UP-Down en la rińonera para regular  la misma Asiento multilaminado con goma espuma inyectada termoformado',6468,0),(11,'Otro mecanismo','test de meca',0,0),(12,'Otro mecanismo más','segundo test de meca',0,0),(14,'neumatica con contacto ','con regulacion de altura atraves de un piston neumatico, contacto permanente ',0,1),(15,'giratoria','con mecanismo giratorio',0,1),(16,'Fija 4 Patas cromo','fija de 4 patas acabado cromado',0,1),(17,'Fija 4 Patas negro','fija de 4 patas acabado con pintura epoxi negro',0,1),(18,'Fija 4 Patas gris microtexturado ','fija de 4 patas  acabado gris microtexturado',0,1),(19,'Trineo cromada','base trineo cromada',0,1),(20,'Trineo negra','base trineo  pintada con pintura epoxi negro',0,1),(21,'Trineo gris','base trineo gris microtexturado',0,1),(22,'Tandem x 2 cuerpos','Tandem de 2 cuerpos(105x60)',0,1),(23,'Tandem x 3 cuerpos','Tandem de 3 cuerpos (155x60)',0,1),(24,'Tandem x 4 cuerpos','Tandem de 4 cuerpos (205x60)',0,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modelos`
--

LOCK TABLES `modelos` WRITE;
/*!40000 ALTER TABLE `modelos` DISABLE KEYS */;
INSERT INTO `modelos` VALUES (1,'silla','test4','4234',4234,0),(2,'silla','Citiz sin cabezal','Silla Mod. Citiz Sin Cabezal',0,0),(3,'silla','Citiz con cabezal','Silla Mod. Citiz Con Cabezal',766.5,0),(5,'silla','teste4','asdfadf',23123,0),(6,'silla','trst','sfdafd',3123123,0),(8,'silla','gafgsdfg','fsadfaf',546546,0),(9,'silla','tasetat','testtt',596,0),(10,'silla','otro test','otooaosdt',434,0),(11,'silla','getzs','test',6,0),(13,'silla','nuevo test','test nuevo pero ahora con modificaciones',200,0),(16,'silla','testeamos','rtestest',2,0),(17,'silla','otro test test','test',10,0),(18,'silla','Diva','Silla Mod. Diva',0,1),(19,' silla',' 300 Bajo ','Sillon Mod. 300 Bajo',0,1),(20,' silla',' 301 Alto','Sillon Mod. 3001  Alto',0,1),(21,' silla',' 600 Bajo ','Sillon Mod. 300 Bajo',0,1),(22,' silla',' 601 Alto','Sillon Mod. 601  Alto',0,1),(23,' silla',' Alma Est. Blanca','Silla Mod. Alma Estructura blanca',52444,1),(24,' silla',' Alma Est. Gris','Silla Mod. Alma Estructura Gris',5244,1),(25,' silla',' Alma Est. Negra','Silla Mod. Alma Estructura Negra',5244,1),(26,' silla',' Anana','Silla Mod. Anana',0,1),(27,' silla',' Antlia Alto','Sillon Mod. Antlia Alto',0,1),(28,' silla',' Antlia bajo','Sillon Mod. Antlia Bajo',0,1),(29,' silla',' Arcadia','Silla Mod. Arcadia baja',0,1),(30,' silla',' Cala','Silla Mod. Cala',0,1),(31,' silla',' Chino','Silla Mod. Chino',0,1),(32,' silla',' Citiz con cabezal','Silla Mod. Citiz Con Cabezal',7234.5,1),(33,' silla',' Citiz sin cabezal','Silla Mod. Citiz Sin Cabezal',6468,1),(34,' silla',' Cubo 1 cuerpo','Sillon  Mod. Cubo de 1 cuerpo patas cromo',0,1),(35,' silla',' Cubo 2 cuerpos','Sillon  Mod. Cubo de 2 cuerpo patas cromo',0,1),(36,' silla',' Cubo Mesa Cuadrada','Sillon  Mod. Cubo de 60x60 tapa de vidrio de 10mm cuerpo tapizado',0,1),(37,' silla',' Cubo Mesa Rectangular','Sillon  Mod. Cubo de 60x120 tapa de vidrio de 10mm cuerpo tapizado',0,1),(38,' silla',' Cubo Puff de 2 cuerpos','Sillon  Mod. Cubo de 2 cuerpo patas cromo',0,1),(39,' silla',' Delfo Alto','Sillon Mod. Delfo Alto',0,1),(40,' silla',' Delfo Bajo','Sillon Mod. Delfo Bajo',0,1),(41,' silla',' Diva','Silla Mod. Diva',0,1),(42,' silla',' Electra Alto','Sillon Mod. Electra Alto',0,1),(43,' silla',' Electra bajo','Sillon Mod. Electra Bajo',0,1),(44,' silla',' Flora','Silla Mod. Flora',0,1),(45,' silla',' Flora Taburete','Silla Mod. Flora Taburete',0,1),(46,' silla',' Folk','Sillon Mod. Folk',0,1),(47,' silla',' Fresa','Silla Mod. Fresa',0,1),(48,' silla',' Frida ','Silla Mod. Frida',0,1),(49,' silla',' Idra Alto','Sillon Mod. Idra  Alto',0,1),(50,' silla',' Idra Bajo','Sillon Mod. Idra Bajo',0,1),(51,' silla',' India','Silla Mod. India',2950,1),(52,' silla',' Jazz 900 Bajo Red tapizado','Sillon Mod. Jazz 900 Bajo Red Tapizado',0,1),(53,' silla',' Jazz 900 Bajo tapizado','Sillon Mod. Jazz 900 Bajo Tapizado',0,1),(54,' silla',' Jazz 901 Alto  Red tapizado','Sillon Mod. Jazz 901 Alto Red Tapizado',0,1),(55,' silla',' Jazz 901 Alto tapizado','Sillon Mod. Jazz 901 Alto Tapizado',0,1),(56,' silla',' Jim','Silla Mod. Jim',0,1),(57,' silla',' LC2 /1 cuerpo','Sillon Mod. LC de 1 cuerpo  ',0,1),(58,' silla',' LC2 /2 cuerpo','Sillon Mod. LC de 2 cuerpo ',0,1),(59,' silla',' LC2 /3 cuerpo','Sillon Mod. LC de 3 cuerpo ',0,1),(60,' silla',' Malba','Silla Mod. Malba',0,1),(61,' silla',' Mandarin Alto','Sillon Mod. Mandarin  Alto',0,1),(62,' silla',' Mandarin Bajo','Sillon Mod. Mandarin Bajo',0,1),(63,' silla',' Manta','Silla Mod. Manta',0,1),(64,' silla',' Milito ','Taburete Mod. Milito',0,1),(65,' silla',' Milo','Taburete Mod. Milo',0,1),(66,' silla',' Miro','Sillon Mod. Miro  respaldo de Red, sillon con brazos.',0,1),(67,' silla',' Mora','Silla Mod. Mora',0,1),(68,' silla',' Nina','Silla Mod. Nina',0,1),(69,' silla',' One','Silla Mod. One',0,1),(70,' silla',' One Tapizada ','Silla Mod. One Tapizada ',0,1),(71,' silla',' One x 2 cuerpos','',0,1),(72,' silla',' One x 3 cuerpos','',0,1),(73,' silla',' One x 4 cuerpos','',0,1),(74,' silla',' Otro Modelo','Silla Otro Modelo',0,0),(75,' silla',' Ovo','Sillon Mod. Ovo  Cromo',0,1),(76,' silla',' Paulin','Sillon Mod. Paulin base Cromo',0,1),(77,' silla',' Petra Alta','Silla Mod. Petra Alta',0,1),(78,' silla',' Petra Baja','Silla Mod. Petra Baja',0,1),(79,' silla',' Petra x 2 cuerpos','',0,1),(80,' silla',' Petra x 3 cuerpos','',0,1),(81,' silla',' Petra x 4 cuerpos','',0,1),(82,' silla',' Pistacho Alto','Sillon Mod. Pistacho  Alto',0,1),(83,' silla',' Pistacho Bajo','Sillon Mod. Pistacho Bajo',0,1),(84,' silla',' R701','Silla Mod. R701',0,1),(85,' silla',' R701 x 2 cuerpos','',0,1),(86,' silla',' R701 x 3 cuerpos','',0,1),(87,' silla',' R701 x 4 cuerpos','',0,1),(88,' silla',' R850','Silla Mod. R850',0,1),(89,' silla',' R850 X 2 cuerpos','',0,1),(90,' silla',' R850 X 3 cuerpos','',0,1),(91,' silla',' R850 X 4 cuerpos','',0,1),(92,' silla',' R851','Silla Mod. R851',0,1),(93,' silla',' R851 X 2 cuerpos','',0,1),(94,' silla',' R851 X 3 cuerpos','',0,1),(95,' silla',' R851 X 4 cuerpos','',0,1),(96,' silla',' Riota Alta','Silla Mod. Riota Alta',0,1),(97,' silla',' Riota baja','Silla Mod. Riota Baja',0,1),(98,' silla',' Riota x 2 cuerpos','',0,1),(99,' silla',' Riota x 3 cuerpos','',0,1),(100,' silla',' Riota x 4 cuerpos','',0,1),(101,' silla',' Roby Alta','Silla Mod. Roby Alta',0,1),(102,' silla',' Roby Baja','Silla Mod. Roby Baja',0,1),(103,' silla',' Roby x 2 cuerpos','',0,1),(104,' silla',' Roby x 3 cuerpos','',0,1),(105,' silla',' Roby x 4 cuerpos','',0,1),(106,' silla',' Rombo','Silla Mod. Rombo',0,1),(107,' silla',' RP700','Silla Mod. RP700',0,1),(108,' silla',' RP700 x 2 cuerpos','',0,1),(109,' silla',' RP700 x 3 cuerpos','',0,1),(110,' silla',' RP700 x 4 cuerpos','',0,1),(111,' silla',' Smart','Sillon Mod. Sm@rt de 120x72,5 con puerto USB',0,1),(112,' silla',' Spider Alto','Silla Mod. Spider Alto',0,1),(113,' silla',' Spider Bajo','Silla Mod. Spider Bajo',0,1),(114,' silla',' Tyson','Silla Mod. Tyson',0,1),(115,' silla',' Tyson x 2 cuerpos','',0,1),(116,' silla',' Tyson x 3 cuerpos','',0,1),(117,' silla',' Tyson x 4 cuerpos','',0,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modelos_con_mecanismo`
--

LOCK TABLES `modelos_con_mecanismo` WRITE;
/*!40000 ALTER TABLE `modelos_con_mecanismo` DISABLE KEYS */;
INSERT INTO `modelos_con_mecanismo` VALUES (1,2,1,'',0,1),(2,2,2,'',0,1),(3,2,3,'',0,1),(4,2,4,'',0,1),(5,3,1,'',0,0),(6,3,2,'',0,1),(7,3,3,'',0,0),(8,3,4,'',0,0),(63,8,1,'',0,1),(64,8,3,'',0,1),(65,8,4,'',0,0),(66,3,6,'',0,0);
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
  KEY `color_red` (`color_red`),
  KEY `color_casco` (`color_casco`),
  KEY `color_tapizado` (`color_tapizado`),
  CONSTRAINT `color_casco` FOREIGN KEY (`color_casco`) REFERENCES `colores` (`id`),
  CONSTRAINT `color_red` FOREIGN KEY (`color_red`) REFERENCES `colores` (`id`),
  CONSTRAINT `color_tapizado` FOREIGN KEY (`color_tapizado`) REFERENCES `colores` (`id`),
  CONSTRAINT `presupuestos_ibfk_1` FOREIGN KEY (`articulo`) REFERENCES `modelos_con_mecanismo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presupuestos`
--

LOCK TABLES `presupuestos` WRITE;
/*!40000 ALTER TABLE `presupuestos` DISABLE KEYS */;
INSERT INTO `presupuestos` VALUES (12,1,1,NULL,NULL,NULL,1,8382,0,'2018-05-13 02:35:53','2018-05-13 02:35:53',1,'15, 17, 19, 22, 24'),(13,1,3,47,13,NULL,1,6678,0,'2018-05-13 02:35:54','2018-05-13 02:35:54',1,'22, 24'),(14,1,3,42,12,NULL,1,6678,0,'2018-05-13 02:35:54','2018-05-13 02:35:54',1,'22, 24'),(16,1,3,40,14,NULL,1,6678,0,'2018-05-13 02:35:54','2018-05-13 02:35:54',1,'22, 24'),(17,1,1,46,4,NULL,1,7282,0,'2018-05-13 02:35:54','2018-05-13 02:35:54',1,'15, 18, 19, 22, 24'),(18,2,1,40,14,NULL,1,7189.6,5,'2018-05-13 14:52:00','2018-05-13 14:52:00',1,'5, 17, 19, 22, 24'),(19,3,4,40,14,NULL,1,7203,0,'2018-06-06 22:56:09','2018-06-06 22:56:09',1,'22, 24'),(22,4,6,40,14,NULL,1,1754.51,6,'2018-06-01 02:18:45','2018-06-01 02:18:45',1,'6, 17, 20, 22, 24'),(23,4,6,43,14,NULL,1,1754.51,6,'2018-06-01 02:18:45','2018-06-01 02:18:45',1,'6, 17, 20, 22, 24'),(24,4,1,40,11,NULL,1,7568,0,'2018-06-01 02:18:45','2018-06-01 02:18:45',1,'14, 17, 19, 22, 24'),(25,6,6,46,3,NULL,1,1866.5,0,'2018-06-03 23:17:24','2018-06-03 23:17:24',1,'6, 17, 19, 22, 24'),(26,5,6,40,1,NULL,1,728.175,5,'2018-06-06 23:02:01','2018-06-06 23:02:01',1,'5, 18, 19, 22, 24'),(27,8,3,46,1,NULL,1,6678,0,'2018-06-06 23:03:20','2018-06-06 23:03:20',1,'22, 24'),(28,9,7,46,14,NULL,1,7444.5,0,'2018-06-06 23:04:43','2018-06-06 23:04:43',1,'22, 24'),(29,11,66,NULL,NULL,NULL,1,0,0,NULL,'2018-06-10 02:24:52',0,''),(30,11,6,41,14,NULL,1,0,0,NULL,'2018-06-10 04:35:11',0,'7, 17, 19, 22, 24');
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
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `vendedor` (`vendedor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (2,'administrador',NULL,'admin','21232f297a57a5a743894a0e4a801fc3',1,NULL),(3,'vendedor',1,'vendeuno','99d1ee797e678c14be622d903a363042',1,'vendedor 1'),(4,'administrador',NULL,'admini2','5a93108eca184a842047d0e8f33dd3f4',1,'admini2'),(5,'vendedor',2,'vendedos','f5b4a703f7f2b9a91f5b32ae52cbecb9',1,'vendedor 2');
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
INSERT INTO `vendedores` VALUES (1,'vendedor 1','234','test','test','test','test','observaciones',1,'1419'),(2,'vendedor 2','213','test','test','test','test','Observaciones de prueba para el segundo vendedor, escribiendo bastatne para ver como sale.',1,'1111');
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

-- Dump completed on 2018-06-10 18:38:25
