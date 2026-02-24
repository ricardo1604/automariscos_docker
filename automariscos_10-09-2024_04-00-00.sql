-- MySQL dump 10.13  Distrib 5.7.39, for Win32 (AMD64)
--
-- Host: localhost    Database: automariscos
-- ------------------------------------------------------
-- Server version	5.7.39-log

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
-- Current Database: `automariscos`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `automariscos` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `automariscos`;

--
-- Table structure for table `borrar_mesas_estado`
--

DROP TABLE IF EXISTS `borrar_mesas_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `borrar_mesas_estado` (
  `mesa` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `tiempo_corriendo` int(11) DEFAULT '0',
  `mesero` varchar(50) DEFAULT NULL,
  `modificado` datetime DEFAULT NULL,
  `orden_actual` varchar(50) DEFAULT '0',
  `num_personas` int(11) DEFAULT '0',
  `mesa_principal` int(11) DEFAULT '0',
  `orden_busqueda` varchar(50) DEFAULT '0',
  UNIQUE KEY `mesa` (`mesa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrar_mesas_estado`
--

LOCK TABLES `borrar_mesas_estado` WRITE;
/*!40000 ALTER TABLE `borrar_mesas_estado` DISABLE KEYS */;
INSERT INTO `borrar_mesas_estado` VALUES (8,'ocupada','red',174,'DANIEL','2023-06-03 10:38:09','0',2,0,'8'),(16,'ocupada','red',174,'DANIEL','2023-06-03 10:38:12','0',3,0,'12'),(17,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',3,0,'5'),(18,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',1,0,'4'),(20,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',1,0,'6'),(21,'libre','green',1365230,NULL,'2023-05-21 20:04:56','0',0,0,'0'),(22,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',5,0,'9'),(23,'libre','green',1332403,NULL,'2023-05-23 17:00:56','0',0,0,'0'),(25,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',1,0,'11'),(26,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',2,0,'1'),(28,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',3,0,'13'),(30,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',2,0,'7'),(33,'libre','green',1284223,NULL,'2023-05-26 06:08:56','0',0,0,'0'),(37,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',1,0,'3'),(39,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',2,0,'2'),(59,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',2,0,'14'),(63,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',1,0,'15'),(64,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',1,0,'10'),(68,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',2,0,'16'),(74,'ocupada','red',682,'DANIEL','2023-06-03 07:33:41','0',2,0,'20'),(75,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','0',1,0,'17'),(80,'ocupada','red',897,'DANIEL','2023-06-03 06:04:44','06022023000018',1,0,'18'),(96,'ocupada','red',711,'DANIEL','2023-06-03 07:16:17','06032023000019',5,0,'19'),(97,'libre','green',1349807,NULL,'2023-05-22 12:58:56','0',0,0,'0');
/*!40000 ALTER TABLE `borrar_mesas_estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `cliente_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(40) DEFAULT NULL,
  `apellidos` varchar(40) DEFAULT NULL,
  `empresa` varchar(40) DEFAULT NULL,
  `dui` varchar(9) DEFAULT NULL,
  `correo` varchar(40) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `fecha_cumpleanos` date DEFAULT NULL,
  `fecha_conmemorativa` date DEFAULT NULL,
  `notas` varchar(150) DEFAULT NULL,
  `fecha_creado` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cliente_id`),
  UNIQUE KEY `dui` (`dui`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (4,'DANIEL','ESPINOZA','','016920519','dgespinozav@gmail.com','Activo',123456789,'2022-12-09','2022-12-06','NINGUNA NOTA','2023-04-09 15:14:22'),(5,'CARLOS','MEDINA','','123333222','correo@aqui.com','Activo',NULL,NULL,NULL,NULL,'2023-04-09 15:14:22'),(6,'TEST','CLIENTE','','016920518','cliente@cliente.com','Activo',NULL,NULL,NULL,NULL,'2023-04-09 15:14:22'),(7,'MARIO','AQUINO','NINGUNA EE','665656565','ddd2@gmail.com','Activo',NULL,NULL,NULL,'','2023-04-09 15:14:22'),(8,'MARIO','CARLOS','','065655665','ddd@dd.com','Activo',NULL,NULL,NULL,NULL,'2023-04-09 15:14:22'),(9,'CC','DD','','111111111','ddd@ggg.com','Activo',NULL,NULL,NULL,NULL,'2023-04-09 15:14:22'),(12,'MARIO1','QUIJANO1','','143312121','dad@ddd.com','Activo',45645664,'2022-12-10','2022-12-10','ninguna nota aqui','2023-04-09 15:14:22'),(13,'CARLOS','UMANA','NINGUNA','778788978','dasa@ddd.com','Activo',45654645,NULL,NULL,'','2023-04-09 15:14:22'),(15,'MARIO','PRIETO','','109281387','sddd@ddd.com','Activo',9109020,'2022-11-30',NULL,'1111','2023-04-09 15:14:22'),(16,'JONATHAN','URROZ','','123018030','dada@ddd.com','Activo',54644664,NULL,'2022-12-17','','2023-04-09 15:14:22'),(17,'JULIO','PEREZ','','109321837','ddd@ddd.com','Activo',78788788,'2022-12-01','2022-12-14','111','2023-04-09 15:14:22'),(18,'GUILLERMO','TORO','','456456456','dada@ccc.com','Activo',54544558,'2022-12-14','2022-12-08','','2023-04-09 15:14:22'),(19,'MARIO','CASTRO2','NO TIENE','129102901','mcastro@gmail.com','Activo',12345648,NULL,NULL,'nada especial','2023-04-09 15:14:22'),(20,'VICTOR','CRUZ','NO TIENE','465464696','ddd@gmail.com','Activo',16556656,'2023-04-09','2023-04-11',NULL,'2023-04-09 15:15:00'),(21,'D','E','121221','116920519','ddd@com.com','Activo',1692051,NULL,NULL,'','2023-05-21 07:53:33');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `globales`
--

DROP TABLE IF EXISTS `globales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `globales` (
  `zonas` int(11) DEFAULT NULL,
  `mesas` int(11) DEFAULT NULL,
  `propina` decimal(10,4) DEFAULT NULL,
  `iva` decimal(10,4) DEFAULT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `codempresa` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `conit` varchar(100) DEFAULT NULL,
  `coiva` varchar(100) DEFAULT NULL,
  `giro` varchar(100) DEFAULT NULL,
  `caja` varchar(10) DEFAULT NULL,
  `mensajes` varchar(100) DEFAULT NULL,
  `nombre_comercial` varchar(100) DEFAULT NULL,
  `fila` int(11) DEFAULT NULL,
  `mantenimiento` decimal(10,4) DEFAULT NULL,
  `ganancia` decimal(10,4) DEFAULT NULL,
  `inactividad` int(11) DEFAULT NULL,
  `correonoti` varchar(50) DEFAULT NULL,
  `correonoticc` varchar(125) DEFAULT NULL,
  `bloqueo_comanda` int(11) DEFAULT NULL,
  `refrescar_comanda` int(11) DEFAULT NULL,
  `refrescar_bar` int(11) DEFAULT NULL,
  `refrescar_cocina` int(11) DEFAULT NULL,
  `max_orden_bar` int(11) DEFAULT NULL,
  `max_orden_cocina` int(11) DEFAULT NULL,
  `cover` decimal(10,2) DEFAULT NULL,
  `consumo` decimal(10,2) DEFAULT NULL,
  `estadocover` varchar(20) DEFAULT NULL,
  `estadoconsumo` varchar(20) DEFAULT NULL,
  `clunes` varchar(20) DEFAULT NULL,
  `cmartes` varchar(20) DEFAULT NULL,
  `cmiercoles` varchar(20) DEFAULT NULL,
  `cjueves` varchar(20) DEFAULT NULL,
  `cviernes` varchar(20) DEFAULT NULL,
  `csabado` varchar(20) DEFAULT NULL,
  `cdomingo` varchar(20) DEFAULT NULL,
  `choraini` time DEFAULT NULL,
  `chorafin` time DEFAULT NULL,
  `cmlunes` varchar(20) DEFAULT NULL,
  `cmmartes` varchar(20) DEFAULT NULL,
  `cmmiercoles` varchar(20) DEFAULT NULL,
  `cmjueves` varchar(20) DEFAULT NULL,
  `cmviernes` varchar(20) DEFAULT NULL,
  `cmsabado` varchar(20) DEFAULT NULL,
  `cmdomingo` varchar(20) DEFAULT NULL,
  `cmhoraini` time DEFAULT NULL,
  `cmhorafin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `globales`
--

LOCK TABLES `globales` WRITE;
/*!40000 ALTER TABLE `globales` DISABLE KEYS */;
INSERT INTO `globales` VALUES (5,100,10.0000,13.0000,'VIDAL CHICAS DIAZ','AUTOMARISCOS1','           5A AV NORTE Y BLVD TUTUNICHAPA, FTE A REDONDEL DON RUA','1404-110277-101-0','167474-7','RESTAURANTE','01',' VUELVA PRONTO POR QUE SERVIRLE ES NUESTRO MAYOR GUSTO','RESTAURANTE AUTOMARISCOS',1,50.0000,20.0000,10,'automariscos@gmail.com',' dgespinozav@gmail.com,soporte@gmail.com,itsoporte@gmail.com',6,1,1,1,1000,900,10.00,15.00,'true','true','true','true','true','true','true','true','true','05:00:00','23:00:00','true','true','true','true','true','true','true','05:00:00','03:00:00');
/*!40000 ALTER TABLE `globales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos_accesos`
--

DROP TABLE IF EXISTS `grupos_accesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupos_accesos` (
  `grupo_id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`grupo_id`),
  UNIQUE KEY `grupo_nombre` (`grupo_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos_accesos`
--

LOCK TABLES `grupos_accesos` WRITE;
/*!40000 ALTER TABLE `grupos_accesos` DISABLE KEYS */;
INSERT INTO `grupos_accesos` VALUES (1,'ADMINISTRADOR'),(9,'BARTENDER'),(6,'CAJERO'),(10,'COCINERO'),(2,'MESERO'),(8,'MISC');
/*!40000 ALTER TABLE `grupos_accesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos_privilegios`
--

DROP TABLE IF EXISTS `grupos_privilegios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupos_privilegios` (
  `grupo_id` int(11) DEFAULT NULL,
  `priv_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos_privilegios`
--

LOCK TABLES `grupos_privilegios` WRITE;
/*!40000 ALTER TABLE `grupos_privilegios` DISABLE KEYS */;
INSERT INTO `grupos_privilegios` VALUES (7,1),(7,2);
/*!40000 ALTER TABLE `grupos_privilegios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_impresion`
--

DROP TABLE IF EXISTS `historial_impresion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historial_impresion` (
  `id_impresion` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(40) DEFAULT NULL,
  `usuario` varchar(40) DEFAULT NULL,
  `notas_impresion` varchar(100) DEFAULT NULL,
  `mesa` varchar(10) DEFAULT NULL,
  `orden` varchar(50) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('encola','impreso') DEFAULT NULL,
  `archivo` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_impresion`),
  UNIQUE KEY `archivo` (`archivo`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_impresion`
--

LOCK TABLES `historial_impresion` WRITE;
/*!40000 ALTER TABLE `historial_impresion` DISABLE KEYS */;
INSERT INTO `historial_impresion` VALUES (139,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:01:10','encola','impresiones/precuenta_1691874070329_DANIEL.docx'),(140,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:02:47','encola','impresiones/precuenta_1691874167186_DANIEL.docx'),(141,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:03:31','encola','impresiones/precuenta_1691874211286_DANIEL.docx'),(142,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:04:13','encola','impresiones/precuenta_1691874253752_DANIEL.docx'),(143,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:16:10','encola','impresiones/precuenta_1691874970464_DANIEL.docx'),(144,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:17:18','encola','impresiones/precuenta_1691875038631_DANIEL.docx'),(145,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:20:29','encola','impresiones/precuenta_1691875229593_DANIEL.docx'),(146,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:21:30','encola','impresiones/precuenta_1691875290869_DANIEL.docx'),(147,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:25:00','encola','impresiones/precuenta_1691875500212_DANIEL.docx'),(148,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:25:49','encola','impresiones/precuenta_1691875549458_DANIEL.docx'),(149,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:26:15','encola','impresiones/precuenta_1691875575630_DANIEL.docx'),(150,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:26:51','encola','impresiones/precuenta_1691875611450_DANIEL.docx'),(151,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 15:31:18','encola','impresiones/precuenta_1691875878224_DANIEL.docx'),(152,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 18:56:24','encola','impresiones/precuenta_1691888184733_DANIEL.docx'),(153,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 18:57:48','encola','impresiones/precuenta_1691888268125_DANIEL.docx'),(154,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 18:59:59','encola','impresiones/precuenta_1691888399388_DANIEL.docx'),(155,'Precuenta','DANIEL','','26','07232023000001','2023-08-12 19:00:47','encola','impresiones/precuenta_1691888447564_DANIEL.docx'),(156,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 10:36:30','encola','impresiones/precuenta_1691944590885_DANIEL.docx'),(157,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 10:48:09','encola','impresiones/precuenta_1691945289885_DANIEL.docx'),(158,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 10:48:13','encola','impresiones/precuenta_1691945293789_DANIEL.docx'),(159,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 10:53:07','encola','impresiones/precuenta_1691945587136_DANIEL.docx'),(160,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 10:53:11','encola','impresiones/precuenta_1691945591052_DANIEL.docx'),(161,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 10:54:28','encola','impresiones/precuenta_1691945668974_DANIEL.docx'),(162,'Precuenta','DANIEL','','37','08132023000002','2023-08-13 10:54:58','encola','impresiones/precuenta_1691945698071_DANIEL.docx'),(163,'Precuenta','DANIEL','','37','08132023000002','2023-08-13 11:10:06','encola','impresiones/precuenta_1691946606500_DANIEL.docx'),(164,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 11:12:36','encola','impresiones/precuenta_1691946756276_DANIEL_07232023000001.docx'),(165,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 11:19:16','encola','impresiones/precuenta_1691947156622_DANIEL_07232023000001.docx'),(166,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 11:22:50','encola','impresiones/precuenta_1691947370265_DANIEL_07232023000001.docx'),(167,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 11:26:41','encola','impresiones/precuenta_1691947601692_DANIEL_07232023000001.docx'),(168,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 11:28:12','encola','impresiones/precuenta_1691947692921_DANIEL_07232023000001.docx'),(169,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 11:33:09','encola','impresiones/precuenta_1691947989323_DANIEL_07232023000001.docx'),(170,'Precuenta','DANIEL','','26','07232023000001','2023-08-13 11:39:04','encola','impresiones/precuenta_1691948344810_DANIEL_07232023000001.docx'),(171,'Precuenta','DANIEL','','37','08132023000002','2023-08-13 14:17:12','encola','impresiones/precuenta_1691957832955_DANIEL_08132023000002.docx'),(172,'ordenbar','DANIEL','','26','07232023000001','2023-08-13 17:38:26','encola','impresiones/precuenta_1691969905997_DANIEL_07232023000001.docx'),(173,'ordenbar','DANIEL','','26','07232023000001','2023-08-13 17:40:15','encola','impresiones/ordenbar_1691970015040_DANIEL_07232023000001.docx'),(174,'ordenbar','DANIEL','','26','07232023000001','2023-08-13 17:48:09','encola','impresiones/ordenbar_1691970489644_DANIEL_07232023000001.docx'),(175,'ordenbar','DANIEL','','26','07232023000001','2023-08-13 17:49:18','encola','impresiones/ordenbar_1691970558354_DANIEL_07232023000001.docx'),(176,'ordenbar','DANIEL','','26','07232023000001','2023-08-13 17:51:59','encola','impresiones/ordenbar_1691970719343_DANIEL_07232023000001.docx'),(177,'ordenbar','DANIEL','','26','07232023000001','2023-08-13 17:52:37','encola','impresiones/ordenbar_1691970757216_DANIEL_07232023000001.docx'),(178,'ordenbar','DANIEL','','26','07232023000001','2023-08-13 18:17:01','encola','impresiones/ordenbar_1691972220993_DANIEL_07232023000001.docx'),(179,'ordenbar','DANIEL','','26','07232023000001','2023-08-13 18:17:41','encola','impresiones/ordenbar_1691972261364_DANIEL_07232023000001.docx'),(180,'ordenbar','DANIEL','','26','07232023000001','2023-08-13 18:18:49','encola','impresiones/ordenbar_1691972329228_DANIEL_07232023000001.docx'),(181,'ordenbar','DANIEL','','26','07232023000001','2023-08-13 18:42:28','encola','impresiones/ordenbar_1691973748795_DANIEL_07232023000001.docx'),(182,'ordenbar','DANIEL','','26','07232023000001','2023-08-13 18:44:35','encola','impresiones/ordenbar_1691973875128_DANIEL_07232023000001.docx'),(183,'Precuenta','DANIEL','','39','09112023000003','2023-09-11 19:19:37','encola','impresiones/precuenta_1694481577135_DANIEL_09112023000003.docx'),(184,'Precuenta','DANIEL','','37','12122023000004','2024-01-19 06:25:21','encola','impresiones/precuenta_1705667121031_DANIEL_12122023000004.docx');
/*!40000 ALTER TABLE `historial_impresion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredientes`
--

DROP TABLE IF EXISTS `ingredientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredientes` (
  `ingrediente_id` int(100) NOT NULL AUTO_INCREMENT,
  `ingrediente` varchar(150) DEFAULT NULL,
  `unidad` varchar(60) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `costo` decimal(10,4) DEFAULT NULL,
  PRIMARY KEY (`ingrediente_id`),
  UNIQUE KEY `ingrediente` (`ingrediente`)
) ENGINE=InnoDB AUTO_INCREMENT=350 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredientes`
--

LOCK TABLES `ingredientes` WRITE;
/*!40000 ALTER TABLE `ingredientes` DISABLE KEYS */;
INSERT INTO `ingredientes` VALUES (1,'AZUCAR EN BOLSITAS','UNIDAD','Activo',0.0100),(2,'CUBITOS MAGY','UNIDAD','Activo',0.0300),(3,'VASO DESECHABLE','UNIDAD','Activo',0.0300),(4,'CUCHARA FORRADA','UNIDAD','Activo',0.0400),(5,'CEREZAS','UNIDAD','Activo',0.0500),(6,'MASECA 50 LBS TORTIMASA','UNIDAD','Activo',0.0600),(7,'TORTILLA DE TACOS','UNIDAD','Activo',0.0600),(8,'CAJA DE COSCAFE','UNIDAD','Activo',0.0700),(9,'PAN DE CAJA','UNIDAD','Activo',0.0900),(10,'HUEVOS DE CODORNIZ','UNIDAD','Activo',0.0900),(11,'ALMEJAS ','UNIDAD','Activo',0.1000),(12,'SAL EN BOLSITAS','UNIDAD','Activo',0.1000),(13,'PANCITO PARA COCTEL','UNIDAD','Activo',0.1100),(14,'JAMON FAMILIAR','UNIDAD','Activo',0.1300),(15,'PAN PARA CHORIPAN ','UNIDAD','Activo',0.1300),(16,'RAPIDITAS','UNIDAD','Activo',0.1300),(17,'LIMONES','UNIDAD','Activo',0.1300),(18,'LATA DE PIÑA TROCITOS','UNIDAD','Activo',0.1500),(19,'NARANJAS','UNIDAD','Activo',0.1500),(20,'ALITAS DE POLLO','UNIDAD','Activo',0.1600),(21,'QUESO CRAF','UNIDAD','Activo',0.1600),(22,'HUEVOS DE GALLINA','UNIDAD','Activo',0.1800),(23,'PEPINOS','UNIDAD','Activo',0.2000),(24,'TORTILLA DE BURRO','UNIDAD','Activo',0.2400),(25,'CONCHAS','unidad','Activo',0.2000),(26,'ELOTES','UNIDAD','Activo',0.2500),(27,'LONGANIZA PRECOCIDA PARA BOCA','UNIDAD','Activo',0.2600),(28,'CRISTAL ','UNIDAD','Activo',0.3300),(29,'CHORIZO PLATO// GUACHO','UNIDAD','Activo',0.4000),(30,'SORBETE (BOLITA)','UNIDAD','Activo',0.4000),(31,'PLATANO','UNIDAD','Activo',0.4000),(32,'JAIBA','UNIDAD','Activo',0.4400),(33,'PAN PARA TORTA MEXICANA','UNIDAD','Activo',0.4500),(34,'PAN CHAPATA','UNIDAD','Activo',0.4800),(35,'COSTILLON','UNIDAD','Activo',0.5000),(36,'PESCADO BOCA','UNIDAD','Activo',0.5000),(37,'MANZANAS','UNIDAD','Activo',0.5000),(38,'FRESA','UNIDAD','Activo',0.5500),(39,'UVA','UNIDAD','Activo',0.5500),(40,'FANTA','UNIDAD','Activo',0.5500),(41,'FRESCA','UNIDAD','Activo',0.5500),(42,'COCA COLA','UNIDAD','Activo',0.5500),(43,'SPRITE','UNIDAD','Activo',0.5500),(44,'KINLEY','UNIDAD','Activo',0.5500),(45,'TE DE LIMON ','UNIDAD','Activo',0.5800),(46,'TE DE DURAZNO','UNIDAD','Activo',0.5800),(47,'COSTILLA PARA PIZZA ','UNIDAD','Activo',0.6100),(48,'ESPAGUETTI ROMA','UNIDAD','Activo',0.6500),(49,'PLATILLO DE PESCADO','UNIDAD','Activo',0.6600),(50,'COCO PARA FROZEN','UNIDAD','Activo',0.7500),(51,'SUPREMA VERDE','UNIDAD','Activo',0.8500),(52,'GOLDEN VERDE','UNIDAD','Activo',0.8600),(53,'GOLDEN EXTRA','UNIDAD','Activo',0.8600),(54,'PILSENER ','UNIDAD','Activo',0.8600),(55,'CORONITA','UNIDAD','Activo',0.9900),(56,'MARAÑON CONGELADO (32 ONZ)','UNIDAD','Activo',1.0000),(57,'DULCE DE ATADO','UNIDAD','Activo',1.1000),(58,'CAMARON CON CABEZA GRANDE','UNIDAD','Activo',1.1500),(59,'MICHELOB ULTRA','UNIDAD','Activo',1.3200),(60,'CORONA','UNIDAD','Activo',1.4500),(61,'MODELO','UNIDAD','Activo',1.5300),(62,'STELLA ARTOIS','UNIDAD','Activo',1.5300),(63,'REGIA','UNIDAD','Activo',1.6300),(64,'SALCHICHA','UNIDAD','Activo',1.7500),(65,'CHAOMIN ','UNIDAD','Activo',1.8100),(66,'MANGO CONGELADO  (BOLSA 22 ONZ)','UNIDAD','Activo',2.5000),(67,'PASTA PARA LASAÑA','UNIDAD','Activo',3.2000),(68,'PESCADO CURVINA MEDIANA','UNIDAD','Activo',4.5000),(69,'MARACUYA CONGELADO (32 ONZ.)','UNIDAD','Activo',5.0000),(70,'MAMEY CONGELADO (22 ONZ.)','UNIDAD','Activo',5.0000),(71,'PIÑA','UNIDAD','Activo',5.0000),(72,'PESCADO BOCA COLORADA MEDIANO','UNIDAD','Activo',5.2500),(73,'MARISCADA/ BLANDOS','UNIDAD','Activo',6.0000),(74,'MARISCADA/DUROS','UNIDAD','Activo',1.0300),(75,'BASE PARA MARISCADA','UNIDAD','Activo',0.6500),(76,'FRESCO DE ENSALADA','UNIDAD','Activo',0.0000),(77,'POLLO PARA EL PERSONAL','PORCION','Activo',1.2500),(78,'PUYASO','ONZA','Activo',0.3300),(79,'FILETE DE DORADO','ONZA','Activo',0.3500),(80,'CREMA DE COCO','ONZA','Activo',0.3500),(81,'POLLO ENTERO PARA PLATO','PORCION','Activo',1.6500),(82,'CAMARON PELADO PARA COCTEL','ONZA','Activo',0.4000),(83,'CUAJADA','ORDEN','Activo',0.2500),(84,'PIMIENTA EN GRANO','ONZA','Activo',0.4500),(85,'CHILI CON CARNE','ONZA','Activo',0.1500),(86,'COMINO EN GRANO','ONZA','Activo',0.5000),(87,'POSTA DE NUCA','ONZA','Activo',0.1800),(88,'LOMO ROLLIZO','ONZA','Activo',0.5000),(89,'CALAMAR PARA COCTEL','ONZA','Activo',0.2200),(90,'CARACOL','ONZA','Activo',0.5000),(91,'CARNE DE TACOS DE RES','ONZA','Activo',0.2600),(92,'PALILLO PARA BARBACOA','ONZA','Activo',0.0200),(93,'MANTEQUILLA','ONZA','Activo',0.5000),(94,'HARINA FUERTE PARA PIZZA','ONZA','Activo',0.0400),(95,'GALON DE SALSA NEGRITO ESPESA','ONZA','Activo',0.0400),(96,'TAJIN','ONZA','Activo',0.5600),(97,'JUGO DE PIÑA JUMEX','ONZA','Activo',0.0500),(98,'BOTELLA DE STOLICHNAYA','BOTELLA','Activo',17.9500),(99,'JUGO DE TOMATE JUMEX','ONZA','Activo',0.0500),(100,'ARROBA DE SAL DE COCINA','ONZA','Activo',0.0100),(101,'COSTILLA AHUMADA PARA BOCA  2.5 ONZ','ONZA','Activo',0.6100),(102,'CANELA EN RAJA ','ONZA','Activo',0.6300),(103,'PAPAS FRANCESAS ','ONZA','Activo',0.0730),(104,'TRAGO DE ABSOLUT','ONZA','Activo',0.8000),(105,'VINAGRE CLARO','ONZA','Activo',0.0200),(106,'VINAGRE AMARILLO ','ONZA','Activo',0.0200),(107,'AZUCAR A GRANEL','ONZA','Activo',0.0300),(108,'HARINA DE ARROZ NELY','ONZA','Activo',0.0500),(109,'BIDON DE ACEITE','ONZA','Activo',0.0500),(110,'GALON DE SALSA INGLESA','ONZA','Activo',0.0300),(111,'MARGARINA PIZZA','ONZA','Activo',0.0500),(112,'GALON DE SALSA PICANTE','ONZA','Activo',0.0500),(113,'MOSTAZA PREPARADA','ONZA','Activo',0.0600),(114,'HARINA DE TRIGO','ONZA','Activo',0.0800),(115,'MANI EN GRANO','ONZA','Activo',0.0800),(116,'ARROZ COCIDO','ONZA','Activo',0.1000),(117,'AJONJOLI','ONZA','Activo',0.1000),(118,'MORRO','ONZA','Activo',0.1000),(119,'ESENCIA DE VAINILLA BLANCA','ONZA','Activo',0.1200),(120,'LECHE EVAPORADA NESTLE','ONZA','Activo',0.1200),(121,'CORAZON DE RES','ONZA','Activo',0.1300),(122,'COSTILLA RIBLET','ONZA','Activo',0.1400),(123,'CEVADA CON LECHE','ONZA','Activo',0.1500),(124,'FRIJOL ROJO DE SEDA','ONZA','Activo',0.1500),(125,'LOMO DE CERDO','ONZA','Activo',0.1700),(126,'CHICHARON PARA PUPUSAS','ONZA','Activo',0.1700),(127,'CALAMAR COCIDO PARA ARROZ ','ONZA','Activo',0.3000),(128,'FROZEN DE FRESA','ONZA','Activo',0.1700),(129,'FROZEN DE TAMARINDO','ONZA','Activo',0.1700),(130,'FROZEN DE MARACUYA','ONZA','Activo',0.1700),(131,'FROZEN DE ARRAYAN','ONZA','Activo',0.1700),(132,'PASTA DE TOMATE NATURAS','ONZA','Activo',0.1700),(133,'SALSA BARBACOA','ONZA','Activo',0.0700),(134,'CARNE MOLIDA','ONZA','Activo',0.1900),(135,'GALON DE SALSA KETCHUP','ONZA','Activo',0.0700),(136,'ACEITUNA NEGRA EN RODAJA','ONZA','Activo',0.1900),(137,'BATER','ONZA','Activo',0.0800),(138,'SOPA MAGUIE','ONZA','Activo',0.2000),(139,'SALSA PARRILLERA','ONZA','Activo',0.0800),(140,'VERSATIER','ONZA','Activo',0.2000),(141,'CONSOME DE CARNE','ONZA','Activo',0.0900),(142,'LEVADURA PARA PAN','ONZA','Activo',0.2100),(143,'EMPANIZADOR','ONZA','Activo',0.0900),(144,'PECHUGA DESHUEZADA','ONZA','Activo',0.2400),(145,'ACEITE VEGETAL','ONZA','Activo',0.0900),(146,'CONEJO','ONZA','Activo',0.2500),(147,'CONSOME DE POLLO','ONZA','Activo',0.1000),(148,'PESCADETAS','ONZA','Activo',0.2500),(149,'QUESO CHEDAR','ONZA','Activo',0.2500),(150,'MAISENA SIMPLE','ONZA','Activo',0.2500),(151,'MANITA DE CINTA','ONZA','Activo',0.2600),(152,'BOTELLA DE CREMA ','ONZA','Activo',0.1100),(153,'MAYONESA    COCTEL','ONZA','Activo',0.1100),(154,'CONSOME DE CAMARON O PARA SOPAS','ONZA','Activo',0.1200),(155,'BOTE DE PEPINILLO','ONZA','Activo',0.1200),(156,'MARGARINA MIRASOL','ONZA','Activo',0.1300),(157,'LIBRA QUESILLO SUPER','ONZA','Activo',0.1700),(158,'NACHOS (3 ONZ.)','ONZA','Activo',0.1800),(159,'MOZARELLA','ONZA','Activo',0.1800),(160,'SALSA DE OSTRAS ','ONZA','Activo',0.1800),(161,'MONTREAL STEAK','ONZA','Activo',0.1900),(162,'LECHE EN POLVO','ONZA','Activo',0.1900),(163,'PEPPERONI','ONZA','Activo',0.2000),(164,'VINO PRESIDENTE','ONZA','Activo',0.2000),(165,'JUGO DE GRANADINA','ONZA','Activo',0.2100),(166,'ADOBO PASTOR','ONZA','Activo',0.2300),(167,'SAZON COMPLETO','ONZA','Activo',0.2600),(168,'PAPRIKA','ONZA','Activo',0.2900),(169,'MANTECA MAZOLA ','ONZA','Activo',0.3200),(170,'ACEITE DE OLIVA EXTRA VIRGEN','ONZA','Activo',0.3300),(171,'CONCENTRADO DE CAMARON O MARISCOS SECOS','ONZA','Activo',0.3500),(172,'BOTELLA BACARDI ORO','BOTELLA','Activo',8.5540),(173,'ZASON DE SOYA PARA MARISCOS','ONZA','Activo',0.3900),(174,'BOTELLA BACARDI CARTA BLANCA','BOTELLA','Activo',8.5540),(175,'CRUTONES','ONZA','Activo',0.4100),(176,'CHACALIN/ PUD PELADO','ONZA','Activo',0.2700),(177,'SALSA PARA PIZZA','ONZA','Activo',0.5100),(178,'QUESO PARMESANO','ONZA','Activo',0.5100),(179,'LECHE DE COCO','ONZA','Activo',0.2700),(180,'TRAGO JARANA REPOSADO','ONZA','Activo',0.6100),(181,'CREMA DE MARISCO MAGGUIE','ONZA','Activo',0.2700),(182,'CAMARON CON CABEZA PEQUEÑA','ONZA','Activo',0.2800),(183,'LATA DE HONGOS','ONZA','Activo',0.2800),(184,'PIMIENTA NEGRA CRAQUEADA','ONZA','Activo',0.7100),(185,'BRANDY SOLERA ','ONZA','Activo',0.7200),(186,'FINDLANDIA ','ONZA','Activo',0.7500),(187,'BALLANTINE´S $26.00','ONZA','Activo',1.0400),(188,'JIMADOR BLANCO $27.00','ONZA','Activo',1.0800),(189,'JIMADOR REPOSADO $28.00','ONZA','Activo',1.1200),(190,'GIN PARA LONG ISLAND ','ONZA','Activo',1.2000),(191,'SOMETHING ESPECIAL $30.95','ONZA','Activo',1.2400),(192,'BOTELLA JACK DANIEL´S','BOTELLA','Activo',41.8000),(193,'CHIVAS REGAL $51.95','ONZA','Activo',2.0000),(194,'CONDIMENTO CAJUN','ONZA','Activo',0.0000),(195,'GLUTAMATO MONOSODICO','ONZA','Activo',0.0000),(196,'SALSA BUFALO','ONZA','Activo',0.1000),(197,'SALSA CHIPOTLE','ONZA','Activo',0.1040),(198,'CHIVAS REGAL $27.50','ONZA','Activo',0.0000),(199,'SOMETHING ESPECIAL $15.95','ONZA','Activo',0.0000),(200,'TRAGO DE JACK DANIEL´S ','ONZA','Activo',1.6710),(201,'TRAGO JARANA BLANCO $19.29','ONZA','Activo',0.5840),(202,'MEDIA DE SMIRNOF ROJO','MEDIA','Activo',6.2500),(203,'MEDIA DE BOTRAN BLACK','MEDIA','Activo',3.5830),(204,'MEDIA DE BOTRAN RED','MEDIA','Activo',3.1200),(205,'MEDIA DE VENADO LIGTH ','MEDIA','Activo',3.7470),(206,'RON FLOR DE CAÑA 4 AÑOS ','MEDIA','Activo',4.2500),(207,'MEDIA DE JOSE CUERVO ORO ','MEDIA','Activo',9.8300),(208,'MEDIA CINTA NEGRA ','MEDIA','Activo',24.7800),(209,'MEDIA DE CINTA ROJA ','MEDIA','Activo',15.5800),(210,'MEDIA DE BUCHANNAS ','MEDIA','Activo',25.4150),(211,'BOTELLA DE J&B ','BOTELLA','Activo',16.0000),(212,'HERRADURA REPOSADO','MEDIA','Activo',0.0000),(213,'HERRADURA BLANCO','MEDIA','Activo',0.0000),(214,'GIN BEEFTEAR','MEDIA','Activo',0.0000),(216,'BOTELLA BOTRAN 12 AÑOS ','BOTELLA','Activo',15.4100),(217,'BOTELLA DE TANQUERAY STERLING','BOTELLA','Activo',19.5000),(218,'CIGARROS','MEDIA','Activo',0.0000),(219,'HIERBA BUENA','ONZA','Activo',0.2500),(220,'LIBRA DE QUESO DURA BLANDO','ONZA','Activo',0.2500),(221,'YUCAS','LIBRA','Activo',0.3500),(222,'LECHUGA REPOLLADA','ONZA','Activo',0.0300),(223,'REMOLACHA','LIBRA','Activo',0.5000),(224,'ZANAHORIA','ONZA','Activo',0.0400),(225,'RABANO','ONZA','Activo',0.0400),(226,'EJOTES','LIBRA','Activo',1.0000),(227,'CEBOLLA MORADA','LIBRA','Activo',1.0000),(228,'CEBOLLA BLANCA','ONZA','Activo',0.0600),(229,'JALAPEÑO','ONZA','Activo',0.0620),(230,'REPOLLOS','LIBRA','Activo',1.0000),(231,'WISQUIL','ONZA','Activo',0.0620),(232,'PIPIANES','LIBRA','Activo',1.0000),(233,'PAPA','ONZA','Activo',0.0718),(234,'MORTADELA','LIBRA','Activo',1.4900),(235,'CABEZA DE PESCADO','LIBRA','Activo',1.5000),(236,'CHILE VERDE','ONZA','Activo',0.0930),(237,'FRIJOLES BLANCOS','LIBRA','Activo',1.5000),(238,'DIENTES DE AJO','ONZA','Activo',0.1000),(239,'CHILES DE COLOR','ONZA','Activo',0.1100),(240,'GALLINAS','PORCION','Activo',2.0000),(241,'HUESO CORRIENTE DE RES','LIBRA','Activo',2.0000),(242,'CILANTRO','ONZA','Activo',0.1800),(243,'FRIJOLES FRESCOS PARA PERSONAL','libra','Activo',2.0000),(244,'AGUACATE','ONZA','Activo',0.1500),(245,'COSTILLA TIPICA AHUMADA PARA PLATO','LIBRA','Activo',3.9500),(246,'CARNE PARA GUISAR','LIBRA','Activo',3.9500),(248,'ALETA','LIBRA','Activo',5.3000),(249,'APIO','ONZA','Activo',0.0600),(250,'COSTILLA FRESCA','ONZA','Activo',0.1900),(251,'BOLSA TRANSPARENTE DE 15LB','LIBRA','Activo',0.0000),(252,'TOMATE','ONZA','Activo',0.0400),(253,'CERVEZA MILLER DRAF','UNIDAD','Activo',1.4540),(254,'CERVEZA HEINEKEN','UNIDAD','Activo',1.4120),(255,'CERVEZA SMIRNOF ICE ROJA','UNIDAD','Activo',1.4200),(256,'CERVEZA SMIRNOF ICE MANZANA','UNIDAD','Activo',1.4200),(257,'CERVEZA SMIRNOF ICE CEREZA','UNIDAD','Activo',1.4200),(258,'CERVEZA SMIRNOF ICE GUARANA','UNIDAD','Activo',1.4200),(259,'BOTELLA DE BOTRAN RED ','BOTELLA','Activo',5.6200),(260,'BOTELLA RON FLOR DE CAÑA 4 AÑOS','BOTELLA','Activo',6.9500),(261,'BOTELLA DE BOTRAN BLACK ','BOTELLA','Activo',6.8700),(262,'BOTELLA DE VENADO LIGTH ','BOTELLA','Activo',6.8700),(263,'BOTELLA SMIRNOF ROJO','BOTELLA','Activo',11.4700),(264,'TRAGO JOSE CUERVO ORO ','ONZA','Activo',0.7080),(265,'BOTELLA 1800 REPOSADO','BOTELLA','Activo',29.1700),(266,'BOTELLA CINTA ROJA ','BOTELLA','Activo',29.2400),(267,'BOTELLA DE CINTA NEGRA','BOTELLA','Activo',45.7100),(268,'BOTELLA BUCHANNAS ','BOTELLA','Activo',47.0830),(269,'TEQUILA 1800 AÑEJO ','BOTELLA','Activo',37.7100),(270,'BOTELLA JOSE CUERVO PLATA','BOTELLA','Activo',17.8700),(271,'BOTELLA DON JULIO REPOSADO ','BOTELLA','Activo',65.8300),(272,'TRAGO DE AMARETO $26.57','ONZA','Activo',1.0630),(273,'LICOR DE CAFÉ SONATA $19.95','ORDEN','Activo',0.7980),(275,'TRAGO TRIPLE SEC $9.29','ONZA','Activo',0.3710),(276,'BOTELLA DE VINO TINTO','BOTELLA','Activo',5.6020),(277,'SKYY','BOTELLA','Activo',0.0000),(279,'CHIRIMOL','ONZA','Activo',0.2000),(280,'SALSA ROSADA ','ONZA','Activo',0.1400),(281,'TORTILLA ','UNIDAD','Activo',0.1200),(283,'FRIJOL MOLIDO','ONZA','Activo',0.2500),(284,'CURTIDO','ONZA','Activo',0.1000),(285,'SALSA DE TOMATE PARA PUPUSA','ONZA','Activo',0.1500),(286,'CEBOLLA CURTIDA AMARIILA','ONZA','Activo',0.1250),(287,'CEBOLLA CURTIDA MORADA','ONZA','Activo',0.1000),(289,'CHORIZO DE TUZA','UNIDAD','Activo',0.1500),(290,'FONFO DE MARISCOS','UNIDAD','Activo',0.6500),(291,'FONDO DE GALLINA','UNIDAD','Activo',0.3500),(292,'FONDO DE SOPA DE TORTILLA','UNIDAD','Activo',0.2000),(293,'SOPA DE GALLINA KNOR','ONZA','Activo',0.2000),(294,'ENSALADA NATURAL PARA PLATO','UNIDAD','Activo',0.4000),(295,'CEVICHE DE PESCADO','UNIDAD','Activo',0.6550),(296,'PANKO','ONZA','Activo',0.6190),(297,'PASTA DE AJO CON ACEITE','ONZA','Activo',0.1000),(298,'CASAMIEMTO','ONZA','Activo',0.1200),(299,'SALSA TARTARA','ONZA','Activo',0.2000),(300,'CRAWFISH','ONZA','Activo',0.2500),(301,'ELOTE AMARILLO','UNIDAD','Activo',0.3700),(302,'CAMARON CON CASCARA PARA COCTEL','ONZA','Activo',0.3530),(303,'JALAPEÑO ENCURTIDO','ONZA','Activo',0.1000),(304,'CEBOLLA CARAMELIZADA','ORDEN','Activo',0.3000),(305,'SALSA VERDE TAQUERA','ONZA','Activo',0.2000),(306,'SALSA DE AJO','ORDEN','Activo',0.3000),(307,'SALSA SABOR ORIENTAL','UNIDAD','Activo',0.2100),(308,'CHICLOSA PARA AZAFATON','UNIDAD','Activo',0.3700),(309,'AJO PICADO PRICEMARK','ONZA','Activo',0.2200),(310,'CLAVO DE OLOR','ONZA','Activo',3.0000),(311,'CHICHARRONES CON COSTILLA','ONZA','Activo',0.3760),(312,'PIMENTON O PAPRIKA','ONZA','Activo',0.2800),(313,'RELLENENO DE CAMARON PARA PESCADO (4 ONZ)','ORDEN','Activo',1.7500),(314,'PESCADO CURVINA GRANDE','UNIDAD','Activo',5.5000),(315,'PESCADO BOCA COLORADA GRANDE','UNIDAD','Activo',6.7500),(316,'HERSHEY CHOCOLATE','ONZA','Activo',0.5870),(317,'HIELO','ONZA','Activo',0.0100),(318,'MIXER','UNIDAD','Activo',0.5500),(319,'BOTELLA DE JOSE CUERVO ORO','BOTELLA','Activo',17.7100),(320,'TRAGO DE BAILEYS $23.87','ONZA','Activo',0.9540),(321,'TRAGO DE VINO TINTO ','ONZA','Activo',0.2540),(322,'TRAGO DE DON JULIO REPOSADO','ONZA','Activo',2.6330),(323,'TRAGO DE BOTRAN RED','ONZA','Activo',0.2240),(324,'TRAGO DE RON FLOR DE CAÑA 4 AÑOS','ONZA','Activo',0.2780),(325,'TRAGO SMIRNOF ROJO','ONZA','Activo',0.4580),(326,'TRAGO DE 1800 REPOSADO','ONZA','Activo',1.1660),(327,'TRAGO DE BUCHANA','ONZA','Activo',1.8830),(328,'TRAGO DE JOSE CUERVO PLATA','ONZA','Activo',0.7140),(329,'TRAGO DE TANQUERAY STERLING ','ONZA','Activo',0.7800),(330,'TRAGO DE BACARDI CARTA BLANCA','ONZA','Activo',0.3880),(331,'TRAGO DE BACARDI ORO','ONZA','Activo',0.3880),(332,'MEDIA DE BACARDI CARTA BLANCA','MEDIA','Activo',5.4570),(333,'MEDIA BACARDI ORO','MEDIA','Activo',5.4570),(334,'MEDIA DE FINDLANDIA','MEDIA','Activo',9.6720),(335,'BOTELLA DE ABSOLUT','BOTELLA','Activo',19.9900),(336,'TRAGO DE BOTRAN BLACK','ONZA','Activo',0.2740),(337,'TRAGO DE VENADO LIGTH','ONZA','Activo',0.2740),(338,'TRAGO DE 1800 AÑEJO','ONZA','Activo',1.5080),(339,'TRAGO DE CINTA NEGRA','ONZA','Activo',1.8280),(340,'TRAGO DE CINTA ROJA','ONZA','Activo',1.1690),(341,'MEDIA DE ABSOLUT ','MEDIA','Activo',13.9900),(342,'MEDIA DE STOLICHNAYA','MEDIA','Activo',9.9500),(343,'TRAGO DE STOLICHNAYA','ONZA','Activo',0.7180),(344,'TRAGO DE BOTRAN 12 AÑOS ','ONZA','Activo',0.6160),(345,'MEDIA DE JACK DANIELS','MEDIA','Activo',22.3200),(346,'HORCHATA','PORCION','Activo',0.2110),(348,'SODAS','UNIDAD','Activo',0.5500),(349,'FRUTA PARA FRESCO DE ENSALADA','UNIDAD','Activo',0.5010);
/*!40000 ALTER TABLE `ingredientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredientes_asignados`
--

DROP TABLE IF EXISTS `ingredientes_asignados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredientes_asignados` (
  `producto_id` int(11) DEFAULT NULL,
  `ingrediente_id` int(11) DEFAULT NULL,
  `cantidad` decimal(10,4) DEFAULT NULL,
  `costot` decimal(10,4) DEFAULT NULL,
  UNIQUE KEY `producto_id` (`producto_id`,`ingrediente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredientes_asignados`
--

LOCK TABLES `ingredientes_asignados` WRITE;
/*!40000 ALTER TABLE `ingredientes_asignados` DISABLE KEYS */;
INSERT INTO `ingredientes_asignados` VALUES (4,85,6.0000,0.9000),(4,158,3.0000,0.5400),(4,149,0.5000,0.1250),(4,220,0.1000,0.0250),(2,25,12.0000,2.4000),(2,17,1.0000,0.1300),(2,279,2.0000,0.4000),(5,22,1.0000,0.1800),(5,83,1.0000,0.2500),(5,152,0.0500,0.0060),(5,244,2.5000,0.3750),(5,281,2.0000,0.5000),(7,285,1.0000,0.1500),(7,284,1.0000,0.1000),(7,157,1.0000,0.1700),(7,283,1.0000,0.2500),(7,6,1.0000,0.0600),(6,6,1.0000,0.0600),(6,283,0.6500,0.1625),(6,157,0.6500,0.1105),(6,126,0.6500,0.1105),(6,285,1.0000,0.1500),(6,284,1.0000,0.1000),(8,157,2.0000,0.3400),(8,6,1.0000,0.0600),(8,284,1.0000,0.1000),(8,285,1.0000,0.1500),(9,6,1.0000,0.0600),(9,176,1.0000,0.2700),(9,285,1.0000,0.1500),(9,284,1.0000,0.1000),(9,157,0.7500,0.1275),(9,279,0.6250,0.1250),(10,29,2.0000,0.8000),(10,279,2.0000,0.4000),(10,22,1.0000,0.1800),(10,175,1.0000,0.4100),(10,178,0.2500,0.1275),(3,10,12.0000,1.0800),(3,280,1.0000,0.1400),(13,14,2.0000,0.2600),(14,163,2.0000,0.4000),(15,29,1.0000,0.4000),(11,22,1.0000,0.1800),(11,58,2.0000,2.3000),(11,176,4.0000,1.0800),(11,281,1.0000,0.1200),(11,154,0.2500,0.0300),(12,58,2.0000,2.3000),(12,140,2.0000,0.4000),(12,154,0.2500,0.0300),(12,176,4.0000,1.0800),(12,181,0.5000,0.1350),(12,281,1.0000,0.1200),(12,162,0.6000,0.1140),(20,17,0.5000,0.0650),(20,73,1.0000,6.0000),(20,74,1.0000,1.0300),(20,75,1.0000,0.6500),(20,140,2.0000,0.4000),(20,162,0.6000,0.1140),(20,179,2.0000,0.5400),(20,181,0.5000,0.1350),(20,281,1.0000,0.1200),(20,154,0.2500,0.0300),(21,17,0.5000,0.0650),(21,116,0.5000,0.0500),(21,224,2.0000,0.0800),(21,231,1.0000,0.0620),(21,233,3.0000,0.2150),(21,240,0.5000,1.0000),(21,279,2.0000,0.4000),(21,281,1.0000,0.1200),(21,291,1.0000,0.3500),(21,293,0.5000,0.1000),(22,291,0.5000,0.1750),(22,240,1.0000,2.0000),(22,293,0.2500,0.0500),(22,281,1.0000,0.1200),(22,279,1.0000,0.2000),(22,233,1.5000,0.1080),(22,231,1.0000,0.0620),(22,224,1.0000,0.0400),(22,17,0.5000,0.0650),(22,116,3.2500,0.3250),(22,294,1.0000,0.4000),(24,25,12.0000,2.4000),(24,239,1.0000,0.1100),(24,228,1.0000,0.0600),(24,238,0.4000,0.0400),(24,157,2.0000,0.3400),(24,160,0.0500,0.0090),(25,148,10.0000,2.5000),(25,279,1.0000,0.2000),(25,287,1.0000,0.1000),(25,281,2.0000,0.2400),(25,17,1.0000,0.1300),(26,49,3.0000,1.9800),(26,281,2.0000,0.2400),(26,17,1.0000,0.1300),(26,294,1.0000,0.4000),(27,289,6.0000,0.9000),(27,244,1.5000,0.2250),(27,83,1.0000,0.2500),(27,281,2.0000,0.2400),(27,279,1.0000,0.2000),(27,287,1.0000,0.1000),(23,7,3.0000,0.1800),(23,17,0.2500,0.0330),(23,152,0.5000,0.0550),(23,157,2.0000,0.3400),(23,244,1.5000,0.2250),(23,292,1.0000,0.2000),(28,17,0.5000,0.0650),(28,27,2.0000,0.5200),(28,35,3.0000,1.5000),(28,101,6.0000,3.6600),(28,103,4.0000,0.2920),(28,121,4.0000,0.5200),(28,133,1.0000,0.0700),(28,135,1.0000,0.0700),(28,151,4.0000,1.0400),(28,196,1.0000,0.1000),(28,279,1.0000,0.2000),(28,281,2.0000,0.2400),(28,287,1.0000,0.1000),(29,10,3.0000,0.2700),(29,17,0.5000,0.0650),(29,20,3.0000,0.4800),(29,101,4.0000,2.4400),(29,103,4.0000,0.2920),(29,133,1.0000,0.0700),(29,135,1.0000,0.0700),(29,146,4.0000,1.0000),(29,151,4.0000,1.0400),(29,279,1.0000,0.2000),(29,280,1.0000,0.1400),(29,281,2.0000,0.2400),(29,287,1.0000,0.1000),(29,295,2.0000,1.3100),(30,17,0.5000,0.0650),(30,25,6.0000,1.2000),(30,36,2.0000,1.0000),(30,79,4.0000,1.4000),(30,103,4.0000,0.2920),(30,135,1.0000,0.0700),(30,182,4.0000,1.1200),(30,279,1.0000,0.2000),(30,280,1.0000,0.1400),(30,281,2.0000,0.2400),(30,287,1.0000,0.1000),(30,295,2.0000,1.3100),(33,17,1.0000,0.1300),(33,35,4.0000,2.0000),(33,83,1.0000,0.2500),(33,152,0.2500,0.0280),(33,279,1.0000,0.2000),(33,281,1.0000,0.1200),(33,298,3.0000,0.3600),(34,79,8.0000,2.8000),(34,299,1.0000,0.2000),(34,281,2.0000,0.2400),(34,143,2.0000,0.1800),(34,137,0.5000,0.0400),(34,108,1.0000,0.0500),(34,296,0.5000,0.3095),(34,17,0.5000,0.0650),(36,222,2.5000,0.0750),(36,23,1.0000,0.2000),(36,252,8.0000,0.3200),(36,225,8.0000,0.3200),(36,17,0.5000,0.0650),(36,286,1.0000,0.1250),(37,222,2.0000,0.0600),(37,252,4.0000,0.1600),(37,175,3.0000,1.2300),(37,178,0.5000,0.2550),(37,144,8.0000,1.9200),(37,299,1.0000,0.2000),(37,17,0.2500,0.0325),(35,17,1.5000,0.1950),(35,140,2.0000,0.4000),(35,156,1.0000,0.1300),(35,228,2.5000,0.1500),(35,239,3.0000,0.3300),(35,242,0.2500,0.0300),(35,249,0.5000,0.0300),(35,300,0.7500,0.1880),(35,301,1.0000,0.3700),(35,302,16.0000,5.6480),(38,9,3.0000,0.2700),(38,22,1.0000,0.1800),(38,81,1.0000,1.6500),(38,228,0.5000,0.0300),(38,236,0.5000,0.0465),(38,220,0.2500,0.0625),(38,147,0.2500,0.0250),(38,252,1.5000,0.0600),(38,23,0.5000,0.1000),(38,222,0.2500,0.0075),(38,103,5.0000,0.3650),(38,135,1.0000,0.0700),(39,14,2.0000,0.2600),(39,9,3.0000,0.2700),(39,21,2.0000,0.3200),(39,220,0.2500,0.0625),(39,222,0.2500,0.0075),(39,252,0.5000,0.0200),(39,22,1.0000,0.1800),(39,23,0.5000,0.1000),(39,153,0.2500,0.0275),(39,103,5.0000,0.3650),(39,135,1.0000,0.0700),(40,34,1.0000,0.4800),(40,88,4.0000,2.0000),(40,103,5.0000,0.3650),(40,135,1.0000,0.0700),(40,153,0.5000,0.0550),(40,244,0.7500,0.1130),(40,283,1.0000,0.2500),(40,304,1.0000,0.3000),(40,222,0.5000,0.0150),(40,157,1.5000,0.2550),(41,144,4.0000,0.9600),(41,34,1.0000,0.4800),(41,103,5.0000,0.3650),(41,135,1.0000,0.0700),(41,153,0.5000,0.0550),(41,244,0.7500,0.1125),(41,157,1.5000,0.2550),(41,283,1.0000,0.2500),(41,304,1.0000,0.3000),(41,222,0.2500,0.0075),(42,125,6.0000,1.0200),(42,244,1.5000,0.2250),(42,166,1.0000,0.2300),(42,279,3.0000,0.6000),(42,7,4.0000,0.2400),(42,220,0.5000,0.1250),(42,157,2.0000,0.3400),(42,17,0.5000,0.0650),(42,305,1.0000,0.2000),(43,151,6.0000,1.5600),(43,7,4.0000,0.2400),(43,244,1.5000,0.2250),(43,17,0.5000,0.0650),(43,157,2.0000,0.3400),(43,220,0.2500,0.0625),(43,279,3.0000,0.6000),(43,305,1.0000,0.2000),(44,33,1.0000,0.4500),(44,283,1.0000,0.2500),(44,244,1.5000,0.2250),(44,151,6.0000,1.5600),(44,157,2.0000,0.3400),(44,228,3.0000,0.1800),(44,95,3.0000,0.1200),(44,153,0.2500,0.0275),(44,305,1.0000,0.2000),(44,279,1.0000,0.2000),(44,17,0.5000,0.0650),(45,228,3.0000,0.1800),(45,229,2.0000,0.1240),(45,236,2.0000,0.1860),(45,239,2.0000,0.2200),(45,281,2.0000,0.2400),(45,151,6.0000,1.5600),(45,93,0.6000,0.3000),(46,82,2.0000,0.8000),(46,151,4.0000,1.0400),(46,228,3.0000,0.1800),(46,93,0.6000,0.3000),(46,229,2.0000,0.1240),(46,236,2.0000,0.1860),(46,239,2.0000,0.2200),(46,281,2.0000,0.2400),(47,24,1.0000,0.2400),(47,244,1.5000,0.2250),(47,152,1.0000,0.1100),(47,151,6.0000,1.5600),(47,298,2.0000,0.2400),(47,157,2.0000,0.3400),(47,305,1.0000,0.2000),(47,17,0.5000,0.0650),(47,279,3.0000,0.6000),(50,116,6.0000,0.6000),(50,21,1.0000,0.1600),(50,228,1.0000,0.0600),(50,239,1.0000,0.1100),(50,249,1.0000,0.0600),(50,160,1.0000,0.1800),(50,170,0.2500,0.0825),(50,171,0.2500,0.0875),(50,173,0.5000,0.1950),(50,242,0.2500,0.0300),(50,281,2.0000,0.2400),(50,25,10.0000,2.0000),(48,21,1.0000,0.1600),(48,82,4.0000,1.6000),(48,116,6.0000,0.6000),(48,160,1.0000,0.1800),(48,170,0.2500,0.0830),(48,171,0.2500,0.0880),(48,173,0.5000,0.1950),(48,228,1.0000,0.0600),(48,236,1.0000,0.0930),(48,239,1.0000,0.1100),(48,242,0.2500,0.0300),(48,249,1.0000,0.0600),(48,281,2.0000,0.2400),(49,21,1.0000,0.1600),(49,116,6.0000,0.6000),(49,127,4.0000,1.2000),(49,136,1.5000,0.2850),(49,160,1.0000,0.1800),(49,170,0.2500,0.0830),(49,171,0.2500,0.0880),(49,173,0.5000,0.1950),(49,228,1.0000,0.0600),(49,239,1.0000,0.1100),(49,242,0.2500,0.0300),(49,249,1.0000,0.0600),(49,281,2.0000,0.2400),(51,252,3.0000,0.1200),(51,228,2.0000,0.1200),(51,298,3.0000,0.3600),(51,83,1.0000,0.2500),(51,17,0.2500,0.0325),(51,220,0.1000,0.0250),(51,281,2.0000,0.2400),(51,236,1.0000,0.0930),(51,88,6.0000,3.0000),(53,125,6.0000,1.0200),(53,298,3.0000,0.3600),(53,166,2.0000,0.4600),(53,236,1.0000,0.0930),(53,252,3.0000,0.1200),(53,228,2.0000,0.1200),(53,83,1.0000,0.2500),(53,17,0.2500,0.0325),(53,220,0.1000,0.0250),(53,281,2.0000,0.2400),(52,17,0.2500,0.0330),(52,83,1.0000,0.2500),(52,144,8.0000,1.9200),(52,220,0.1000,0.0250),(52,228,2.0000,0.1200),(52,236,1.0000,0.0930),(52,252,3.0000,0.1200),(52,281,2.0000,0.2400),(52,298,3.0000,0.3600),(54,17,0.5000,0.0650),(54,122,16.0000,2.2400),(54,133,1.0000,0.0700),(54,281,2.0000,0.2400),(54,286,1.0000,0.1250),(56,81,1.0000,1.6500),(56,116,3.0000,0.3000),(56,220,0.1000,0.0250),(56,281,1.0000,0.1200),(56,294,1.0000,0.4000),(56,228,3.0000,0.1800),(56,95,2.0000,0.0800),(58,125,6.0000,1.0200),(58,233,5.0000,0.3600),(58,294,1.0000,0.4000),(58,281,1.0000,0.1200),(58,166,2.0000,0.4600),(58,17,0.2500,0.0325),(57,29,1.0000,0.4000),(57,78,6.0000,1.9800),(57,83,1.0000,0.2500),(57,220,0.1000,0.0250),(57,279,1.0000,0.2000),(57,281,1.0000,0.1200),(57,294,1.0000,0.4000),(57,298,3.0000,0.3600),(57,17,0.2500,0.0325),(55,144,8.0000,1.9200),(55,233,5.0000,0.3590),(55,279,1.0000,0.2000),(55,281,1.0000,0.1200),(55,294,1.0000,0.4000),(55,17,0.2500,0.0325),(59,83,1.0000,0.2500),(59,133,1.0000,0.0700),(59,196,1.0000,0.1000),(59,244,1.5000,0.2250),(59,245,1.0000,3.9500),(59,283,2.0000,0.5000),(59,281,1.0000,0.1200),(59,306,1.0000,0.3000),(60,88,8.0000,4.0000),(60,298,3.0000,0.3600),(60,244,1.5000,0.2250),(60,22,1.0000,0.1800),(60,83,1.0000,0.2500),(60,281,1.0000,0.1200),(60,17,0.2500,0.0325),(60,294,1.0000,0.4000),(60,279,1.0000,0.2000),(62,79,8.0000,2.8000),(62,103,5.0000,0.3650),(62,294,1.0000,0.4000),(62,135,1.0000,0.0700),(62,299,1.0000,0.2000),(62,281,2.0000,0.2400),(62,143,1.5000,0.1350),(62,108,0.2500,0.0125),(62,137,0.2500,0.0200),(62,17,0.2500,0.0325),(31,17,0.5000,0.0650),(31,108,1.0000,0.0500),(31,137,0.5000,0.0400),(31,143,2.0000,0.1800),(31,182,8.0000,2.2400),(31,281,2.0000,0.2400),(31,296,0.5000,0.3100),(32,17,0.5000,0.0650),(32,171,0.2500,0.0880),(32,181,0.5000,0.1350),(32,182,8.0000,2.2400),(32,242,0.5000,0.0600),(32,244,1.5000,0.2250),(32,281,2.0000,0.2400),(32,297,2.5000,0.2500),(63,294,1.0000,0.4000),(63,103,5.0000,0.3650),(63,299,1.0000,0.2000),(63,281,2.0000,0.2400),(63,17,0.2500,0.0325),(63,58,4.0000,4.6000),(63,137,0.2500,0.0200),(63,108,0.2500,0.0125),(63,220,0.2500,0.0625),(63,143,2.0000,0.1800),(61,17,0.2500,0.0330),(61,79,8.0000,2.8000),(61,233,5.0000,0.3590),(61,281,2.0000,0.2400),(61,294,1.0000,0.4000),(61,306,1.0000,0.3000),(64,58,4.0000,4.6000),(64,135,1.0000,0.0700),(64,306,1.0000,0.3000),(64,281,2.0000,0.2400),(64,233,5.0000,0.3600),(64,294,1.0000,0.4000),(64,17,1.0000,0.1300),(65,88,8.0000,4.0000),(65,29,1.0000,0.4000),(65,279,1.0000,0.2000),(65,83,1.0000,0.2500),(65,58,2.0000,2.3000),(65,233,5.0000,0.3600),(65,294,1.0000,0.4000),(65,281,1.0000,0.1200),(65,17,0.2500,0.0325),(66,88,8.0000,4.0000),(66,144,8.0000,1.9200),(66,58,2.0000,2.3000),(66,233,5.0000,0.3600),(66,281,1.0000,0.1200),(66,294,1.0000,0.4000),(66,17,0.2500,0.0325),(66,279,1.0000,0.2000),(67,58,4.0000,4.6000),(67,144,8.0000,1.9200),(67,88,8.0000,4.0000),(67,29,2.0000,0.8000),(67,79,8.0000,2.8000),(67,233,5.0000,0.3600),(67,279,1.0000,0.2000),(67,294,1.0000,0.4000),(67,17,1.0000,0.1300),(67,281,2.0000,0.2400),(68,250,1.0000,3.0500),(68,116,3.0000,0.3000),(68,294,1.0000,0.4000),(68,17,0.2500,0.0325),(68,281,1.0000,0.1200),(68,307,1.0000,0.2100),(69,58,4.0000,4.6000),(69,89,8.0000,1.7600),(69,79,8.0000,2.8000),(69,103,10.0000,0.7300),(69,135,1.0000,0.0700),(69,308,2.0000,0.7400),(69,287,1.0000,0.1000),(69,143,12.0000,1.0800),(69,137,4.0000,0.3200),(69,108,3.0000,0.1500),(69,242,0.2500,0.0300),(69,299,2.0000,0.4000),(71,294,1.0000,0.4000),(71,17,0.5000,0.0650),(71,281,2.0000,0.2400),(71,313,1.0000,1.7500),(71,68,1.0000,4.5000),(72,314,1.0000,5.5000),(72,294,1.0000,0.4000),(72,281,2.0000,0.2400),(72,17,0.5000,0.0650),(72,313,1.0000,1.7500),(73,72,1.0000,5.2500),(73,313,1.0000,1.7500),(73,294,1.0000,0.4000),(73,281,2.0000,0.2400),(73,17,0.5000,0.0650),(74,17,0.5000,0.0650),(74,281,2.0000,0.2400),(74,294,1.0000,0.4000),(74,313,1.0000,1.7500),(74,315,1.0000,6.7500),(75,20,5.0000,0.8000),(75,249,2.0000,0.1200),(75,224,2.0000,0.0800),(75,299,1.0000,0.2000),(75,143,2.0000,0.1800),(75,137,1.0000,0.0800),(75,108,2.0000,0.1000),(75,296,1.0000,0.6190),(75,196,3.0000,0.3000),(70,17,0.5000,0.0650),(70,281,2.0000,0.2400),(70,286,1.0000,0.1250),(70,287,1.0000,0.1000),(70,311,16.0000,6.0160),(76,30,3.0000,1.2000),(76,316,0.5000,0.2935),(76,5,1.0000,0.0500),(77,44,1.0000,0.5500),(77,17,2.0000,0.2600),(78,219,0.2500,0.0630),(78,17,2.0000,0.2600),(79,17,2.0000,0.2600),(80,19,6.0000,0.9000),(84,46,1.0000,0.5800),(84,317,5.5000,0.0550),(83,45,1.0000,0.5800),(83,317,5.5000,0.0550),(82,28,1.0000,0.3300),(82,317,5.5000,0.0550),(81,123,2.0000,0.3000),(81,162,0.5000,0.0950),(81,317,2.0000,0.0200),(85,42,1.0000,0.5500),(85,317,5.5000,0.0550),(86,40,1.0000,0.5500),(86,317,5.5000,0.0550),(87,39,1.0000,0.5500),(87,317,5.5000,0.0550),(88,38,1.0000,0.5500),(88,317,5.5000,0.0550),(89,44,1.0000,0.5500),(89,317,5.5000,0.0550),(90,41,1.0000,0.5500),(90,317,5.5000,0.0550),(91,43,1.0000,0.5500),(91,317,5.5000,0.0550),(93,50,1.0000,0.7500),(93,317,10.0000,0.1000),(94,346,1.0000,0.2110),(94,162,2.0000,0.3800),(94,317,5.0000,0.0500),(92,17,1.5000,0.1950),(92,317,5.0000,0.0500),(92,335,1.0000,19.9900),(92,348,2.0000,1.1000),(95,8,1.0000,0.0700),(95,1,2.0000,0.0200),(96,162,1.0000,0.1900),(96,1,2.0000,0.0200),(97,349,1.0000,0.5010);
/*!40000 ALTER TABLE `ingredientes_asignados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredientes_sub`
--

DROP TABLE IF EXISTS `ingredientes_sub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredientes_sub` (
  `id_ingrediente` int(11) DEFAULT NULL,
  `id_sub` int(11) DEFAULT NULL,
  UNIQUE KEY `id_ingrediente` (`id_ingrediente`,`id_sub`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredientes_sub`
--

LOCK TABLES `ingredientes_sub` WRITE;
/*!40000 ALTER TABLE `ingredientes_sub` DISABLE KEYS */;
INSERT INTO `ingredientes_sub` VALUES (335,28),(335,38),(335,39),(335,40),(335,41),(335,42),(347,1),(347,2),(347,4),(347,5),(347,7),(347,8),(348,38),(348,39),(348,40),(348,41),(348,42),(348,43);
/*!40000 ALTER TABLE `ingredientes_sub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `licencia`
--

DROP TABLE IF EXISTS `licencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `licencia` (
  `clave` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 MIN_ROWS=1 MAX_ROWS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licencia`
--

LOCK TABLES `licencia` WRITE;
/*!40000 ALTER TABLE `licencia` DISABLE KEYS */;
INSERT INTO `licencia` VALUES ('216a693a9452fb0278c305153c72393317cd4e30');
/*!40000 ALTER TABLE `licencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `localizacion`
--

DROP TABLE IF EXISTS `localizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `localizacion` (
  `departamento` varchar(60) DEFAULT NULL,
  `municipio` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `localizacion`
--

LOCK TABLES `localizacion` WRITE;
/*!40000 ALTER TABLE `localizacion` DISABLE KEYS */;
INSERT INTO `localizacion` VALUES ('Ahuachapan','Ahuachapan'),('Ahuachapan','Apaneca'),('Ahuachapan','Atiquizaya'),('Ahuachapan','Concepcion de Ataco'),('Ahuachapan','El Refugio'),('Ahuachapan','Guaymango'),('Ahuachapan','Jujutla'),('Ahuachapan','San Francisco Menendez'),('Ahuachapan','San Lorenzo'),('Ahuachapan','San Pedro Puxtla'),('Ahuachapan','Tacuba'),('Ahuachapan','Turin'),('Cabanas','Cinquera'),('Cabanas','Dolores'),('Cabanas','Guacotecti'),('Cabanas','Ilobasco'),('Cabanas','Jutiapa'),('Cabanas','San Isidro'),('Cabanas','Sensuntepeque'),('Cabanas','Tejutepeque'),('Cabanas','Victoria'),('Chalatenango','Agua Caliente'),('Chalatenango','Arcatao'),('Chalatenango','Azacualpa'),('Chalatenango','Chalatenango'),('Chalatenango','Citala'),('Chalatenango','Comalapa'),('Chalatenango','Concepcion Quezaltepeque'),('Chalatenango','Dulce Nombre de Maria'),('Chalatenango','El Carrizal'),('Chalatenango','El Paraiso'),('Chalatenango','La Laguna'),('Chalatenango','La Palma'),('Chalatenango','La Reina'),('Chalatenango','Las Vueltas'),('Chalatenango','Nombre de Jesus'),('Chalatenango','Nueva Concepcion'),('Chalatenango','Nueva Trinidad'),('Chalatenango','Ojos de Agua'),('Chalatenango','Potonico'),('Chalatenango','San Antonio de la Cruz (San Antonio La Cruz)'),('Chalatenango','San Antonio Los Ranchos (San Antonio Ranchos)'),('Chalatenango','San Fernando'),('Chalatenango','San Francisco Lempa'),('Chalatenango','San Francisco Morazan'),('Chalatenango','San Ignacio'),('Chalatenango','San Isidro Labrador'),('Chalatenango','San Jose Cancasque'),('Chalatenango','San Jose Las Flores'),('Chalatenango','San Luis del Carmen'),('Chalatenango','San Miguel de Mercedes'),('Chalatenango','San Rafael'),('Chalatenango','Santa Rita'),('Chalatenango','Tejutla'),('Cuscatlan','Candelaria'),('Cuscatlan','Cojutepeque'),('Cuscatlan','El Carmen'),('Cuscatlan','El Rosario'),('Cuscatlan','Monte San Juan'),('Cuscatlan','Oratorio de Concepcion'),('Cuscatlan','San Bartolome Perulapia'),('Cuscatlan','San Cristobal'),('Cuscatlan','San Jose Guayabal'),('Cuscatlan','San Pedro Perulapan'),('Cuscatlan','San Rafael Cedros'),('Cuscatlan','San Ramon'),('Cuscatlan','Santa Cruz Analquito'),('Cuscatlan','Santa Cruz Michapa'),('Cuscatlan','Suchitoto'),('Cuscatlan','Tenancingo'),('Cuscatlan','Zacatecas'),('La Libertad','Antiguo Cuscatlan'),('La Libertad','Chiltiupan'),('La Libertad','Ciudad Arce'),('La Libertad','Colon'),('La Libertad','Comasagua'),('La Libertad','Huizucar'),('La Libertad','Jayaque'),('La Libertad','Jicalapa'),('La Libertad','La Libertad'),('La Libertad','Nuevo Cuscatlan'),('La Libertad','Opico'),('La Libertad','Quezaltepeque'),('La Libertad','Sacacoyo'),('La Libertad','San Jose Villanueva'),('La Libertad','San Matias'),('La Libertad','San Pablo Tacachico'),('La Libertad','Santa Tecla'),('La Libertad','Talnique'),('La Libertad','Tamanique'),('La Libertad','Teotepeque'),('La Libertad','Tepecoyo'),('La Libertad','Zaragoza'),('La Paz','Cuyultitan'),('La Paz','El Rosario'),('La Paz','Jerusalen'),('La Paz','Mercedes La Ceiba'),('La Paz','Olocuilta'),('La Paz','Paraiso de Osorio'),('La Paz','San Antonio Masahuat'),('La Paz','San Emigdio'),('La Paz','San Francisco Chinameca'),('La Paz','San Juan Nonualco'),('La Paz','San Juan Talpa'),('La Paz','San Juan Tepezontes'),('La Paz','San Luis La Herradura'),('La Paz','San Luis Talpa'),('La Paz','San Miguel Tepezontes'),('La Paz','San Pedro Masahuat'),('La Paz','San Pedro Nonualco'),('La Paz','San Rafael Obrajuelo'),('La Paz','Santa Maria Ostuma'),('La Paz','Santiago Nonualco'),('La Paz','Tapalhuaca'),('La Paz','Zacatecoluca'),('La Union','Anamoros'),('La Union','Bolivar'),('La Union','Concepcion de Oriente'),('La Union','Conchagua'),('La Union','El Carmen'),('La Union','El Sauce'),('La Union','Intipuca'),('La Union','La Union'),('La Union','Lislique'),('La Union','Meanguera del Golfo'),('La Union','Nueva Esparta'),('La Union','Pasaquina'),('La Union','Poloros'),('La Union','San Alejo'),('La Union','San Jose'),('La Union','Santa Rosa de Lima'),('La Union','Yayantique'),('La Union','Yucuaiquin'),('Morazan','Arambala'),('Morazan','Cacaopera'),('Morazan','Chilanga'),('Morazan','Corinto'),('Morazan','Delicias de Concepcion'),('Morazan','El Divisadero'),('Morazan','El Rosario'),('Morazan','Gualococti'),('Morazan','Guatajiagua'),('Morazan','Joateca'),('Morazan','Jocoaitique'),('Morazan','Jocoro'),('Morazan','Lolotiquillo'),('Morazan','Meanguera'),('Morazan','Osicala'),('Morazan','Perquin'),('Morazan','San Carlos'),('Morazan','San Fernando'),('Morazan','San Francisco Gotera'),('Morazan','San Isidro'),('Morazan','San Simon'),('Morazan','Sensembra'),('Morazan','Sociedad'),('Morazan','Torola'),('Morazan','Yamabal'),('Morazan','Yoloaiquin'),('San Miguel','Carolina'),('San Miguel','Chapeltique'),('San Miguel','Chinameca'),('San Miguel','Chirilagua'),('San Miguel','Ciudad Barrios'),('San Miguel','Comacaran'),('San Miguel','El Transito'),('San Miguel','Lolotique'),('San Miguel','Moncagua'),('San Miguel','Nueva Guadalupe'),('San Miguel','Nuevo Eden de San Juan'),('San Miguel','Quelepa'),('San Miguel','San Antonio'),('San Miguel','San Gerardo'),('San Miguel','San Jorge'),('San Miguel','San Luis de la Reina'),('San Miguel','San Miguel'),('San Miguel','San Rafael (San Rafael Oriente)'),('San Miguel','Sesori'),('San Miguel','Uluazapa'),('San Salvador','Aguilares'),('San Salvador','Apopa'),('San Salvador','Ayutuxtepeque'),('San Salvador','Cuscatancingo'),('San Salvador','Delgado'),('San Salvador','El Paisnal'),('San Salvador','Guazapa'),('San Salvador','Ilopango'),('San Salvador','Mejicanos'),('San Salvador','Nejapa'),('San Salvador','Panchimalco'),('San Salvador','Rosario de Mora'),('San Salvador','San Marcos'),('San Salvador','San Martin'),('San Salvador','San Salvador'),('San Salvador','Santiago Texacuangos'),('San Salvador','Santo Tomas'),('San Salvador','Soyapango'),('San Salvador','Tonacatepeque'),('San Vicente','Apastepeque'),('San Vicente','Guadalupe'),('San Vicente','San Cayetano Istepeque'),('San Vicente','San Esteban Catarina'),('San Vicente','San Ildefonso'),('San Vicente','San Lorenzo'),('San Vicente','San Sebastian'),('San Vicente','San Vicente'),('San Vicente','Santa Clara'),('San Vicente','Santo Domingo'),('San Vicente','Tecoluca'),('San Vicente','Tepetitan'),('San Vicente','Verapaz'),('Santa Ana','Candelaria de la Frontera'),('Santa Ana','Chalchuapa'),('Santa Ana','Coatepeque'),('Santa Ana','El Congo'),('Santa Ana','El Porvenir'),('Santa Ana','Masahuat'),('Santa Ana','Metapan'),('Santa Ana','San Antonio Pajonal'),('Santa Ana','San Sebastian Salitrillo'),('Santa Ana','Santa Ana'),('Santa Ana','Santa Rosa Guachipilin'),('Santa Ana','Santiago de la Frontera'),('Santa Ana','Texistepeque'),('Sonsonate','Acajutla'),('Sonsonate','Armenia'),('Sonsonate','Caluco'),('Sonsonate','Cuisnahuat'),('Sonsonate','Izalco'),('Sonsonate','Juayua'),('Sonsonate','Nahuizalco'),('Sonsonate','Nahulingo'),('Sonsonate','Salcoatitan'),('Sonsonate','San Antonio del Monte'),('Sonsonate','San Julian'),('Sonsonate','Santa Catarina Masahuat'),('Sonsonate','Santa Isabel Ishuatan'),('Sonsonate','Santo Domingo'),('Sonsonate','Sonsonate'),('Sonsonate','Sonzacate'),('Usulutan','Alegria'),('Usulutan','Berlin'),('Usulutan','California'),('Usulutan','Concepcion Batres'),('Usulutan','El Triunfo'),('Usulutan','Ereguayquin'),('Usulutan','Estanzuelas'),('Usulutan','Jiquilisco'),('Usulutan','Jucuapa'),('Usulutan','Jucuaran'),('Usulutan','Mercedes Umana'),('Usulutan','Nueva Granada'),('Usulutan','Ozatlan'),('Usulutan','Puerto El Triunfo'),('Usulutan','San Agustin'),('Usulutan','San Buenaventura'),('Usulutan','San Dionisio'),('Usulutan','San Francisco Javier'),('Usulutan','Santa Elena'),('Usulutan','Santa Maria'),('Usulutan','Santiago de Maria'),('Usulutan','Tecapan'),('Usulutan','Usulutan');
/*!40000 ALTER TABLE `localizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mapa_area_zonas`
--

DROP TABLE IF EXISTS `mapa_area_zonas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mapa_area_zonas` (
  `area` int(11) DEFAULT NULL,
  `zona` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mapa_area_zonas`
--

LOCK TABLES `mapa_area_zonas` WRITE;
/*!40000 ALTER TABLE `mapa_area_zonas` DISABLE KEYS */;
INSERT INTO `mapa_area_zonas` VALUES (3,4),(2,3),(1,1),(4,5),(1,2);
/*!40000 ALTER TABLE `mapa_area_zonas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mesas`
--

DROP TABLE IF EXISTS `mesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mesas` (
  `zona` int(11) DEFAULT NULL,
  `mesa` int(11) DEFAULT NULL,
  UNIQUE KEY `mesa` (`mesa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesas`
--

LOCK TABLES `mesas` WRITE;
/*!40000 ALTER TABLE `mesas` DISABLE KEYS */;
INSERT INTO `mesas` VALUES (2,8),(1,14),(1,11),(1,6),(1,7),(1,9),(1,15),(2,13),(2,22),(2,17),(2,24),(4,35),(4,43),(4,46),(4,47),(2,1),(2,2),(3,5),(3,20),(3,23),(3,10),(2,28),(1,3),(1,12),(3,25),(3,21),(3,27),(3,32),(3,42),(3,44),(3,45),(3,29),(3,33),(3,40),(3,48),(2,16),(2,18),(2,30),(2,19),(1,31),(1,34),(1,36),(1,52),(4,49),(4,70),(4,71),(4,72),(4,50),(4,73),(5,4),(5,51),(5,54),(5,53),(5,55),(5,99),(5,98),(5,97),(5,96),(5,56),(5,57),(5,58),(5,59),(5,60),(5,61),(5,62),(5,63),(5,64),(5,76),(5,65),(5,66),(5,67),(5,69),(5,74),(5,68),(5,75),(5,80),(5,88);
/*!40000 ALTER TABLE `mesas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mesas_estado`
--

DROP TABLE IF EXISTS `mesas_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mesas_estado` (
  `mesa` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `tiempo_corriendo` int(11) DEFAULT '0',
  `mesero` varchar(50) DEFAULT NULL,
  `modificado` datetime DEFAULT NULL,
  `orden_actual` varchar(50) DEFAULT '0',
  `num_personas` int(11) DEFAULT '0',
  `mesa_principal` int(11) DEFAULT '0',
  `orden_busqueda` varchar(50) DEFAULT '0',
  UNIQUE KEY `mesa` (`mesa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesas_estado`
--

LOCK TABLES `mesas_estado` WRITE;
/*!40000 ALTER TABLE `mesas_estado` DISABLE KEYS */;
INSERT INTO `mesas_estado` VALUES (25,'bloqueada','yellow',0,'DANIEL','2024-07-30 13:47:31','0',0,0,'0');
/*!40000 ALTER TABLE `mesas_estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opciones_menu`
--

DROP TABLE IF EXISTS `opciones_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opciones_menu` (
  `opcion_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ruta` varchar(100) NOT NULL,
  `icono` varchar(20) NOT NULL,
  `funcion` varchar(50) NOT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`opcion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opciones_menu`
--

LOCK TABLES `opciones_menu` WRITE;
/*!40000 ALTER TABLE `opciones_menu` DISABLE KEYS */;
INSERT INTO `opciones_menu` VALUES (1,'Comanda','','file','comanda()','Comanda'),(2,'Bar','','glass','bar()','Bar'),(3,'Cocina','','cutlery','cocina()','Cocina'),(4,'Caja','','usd','caja()','Caja'),(5,'Inventarios','','folder-close','','Inventarios'),(6,'Reportes','','open-file','','Reportes'),(7,'Configuraciones','','wrench','configs()','Configuraciones');
/*!40000 ALTER TABLE `opciones_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordenes` (
  `ORDEN_M` varchar(10) DEFAULT NULL,
  `ORDEN_D` varchar(10) DEFAULT NULL,
  `ORDEN_A` varchar(10) DEFAULT NULL,
  `ORDEN` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA_CREADO` datetime DEFAULT CURRENT_TIMESTAMP,
  `MESA` int(11) DEFAULT NULL,
  `SUBMESAS` varchar(50) DEFAULT NULL,
  `MESERO` varchar(50) DEFAULT NULL,
  `USUARIO` varchar(50) DEFAULT NULL,
  `LLEVAR` enum('SI','NO') DEFAULT 'NO',
  `ESTADO` enum('abierta','cerrada','facturada','cancelada') DEFAULT 'abierta',
  `DUI` varchar(50) DEFAULT NULL,
  `NUM_PERSONAS` int(11) DEFAULT NULL,
  UNIQUE KEY `ORDEN_M` (`ORDEN_M`,`ORDEN_D`,`ORDEN_A`,`ORDEN`),
  KEY `ORDEN` (`ORDEN`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes`
--

LOCK TABLES `ordenes` WRITE;
/*!40000 ALTER TABLE `ordenes` DISABLE KEYS */;
INSERT INTO `ordenes` VALUES ('04','27','2024',1,'2024-04-27 13:05:05',25,'','DANIEL','ADMIN','NO','abierta','016920519',2);
/*!40000 ALTER TABLE `ordenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordenes_lineas`
--

DROP TABLE IF EXISTS `ordenes_lineas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordenes_lineas` (
  `REGISTRO_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MESA` int(11) DEFAULT NULL,
  `ORDEN_M` varchar(10) DEFAULT NULL,
  `ORDEN_D` varchar(10) DEFAULT NULL,
  `ORDEN_A` varchar(10) DEFAULT NULL,
  `ORDEN_NUM` int(11) DEFAULT NULL,
  `ORDEN` varchar(20) DEFAULT NULL,
  `ORDEN_CORRELATIVO` bigint(20) DEFAULT NULL,
  `ORDEN_CORRELATIVOTXT` varchar(50) DEFAULT NULL,
  `CUENTA` varchar(50) DEFAULT NULL,
  `PRODUCTO_ID` varchar(50) DEFAULT NULL,
  `DETALLE` varchar(50) DEFAULT NULL,
  `PRECIO_UNI` decimal(10,2) DEFAULT NULL,
  `PROPINA_VAL` decimal(10,2) DEFAULT NULL,
  `PRECIO_STOT` decimal(10,2) DEFAULT NULL,
  `PRECIO_TOT` decimal(10,2) DEFAULT NULL,
  `CANTIDAD` int(11) DEFAULT NULL,
  `CANTIDAD_PERSONAS` int(11) DEFAULT NULL,
  `PROPINA` varchar(50) DEFAULT NULL,
  `PROPINA_PORC` decimal(10,2) DEFAULT NULL,
  `NOTAS` varchar(200) DEFAULT NULL,
  `MESERO` varchar(20) DEFAULT NULL,
  `COCINA_BAR` varchar(20) DEFAULT NULL,
  `CAJERO` varchar(20) DEFAULT NULL,
  `METODO_PAGO` varchar(20) DEFAULT NULL,
  `ESTADO` enum('abierta','cerrada','facturada','preparacion','despacho') DEFAULT 'abierta',
  `FECHA_CREADO` datetime DEFAULT NULL,
  `FECHA_MODIFICADO` datetime DEFAULT NULL,
  `FECHA_SISTEMA` datetime DEFAULT CURRENT_TIMESTAMP,
  `USUARIO` varchar(50) DEFAULT NULL,
  `REFREG` int(11) DEFAULT NULL,
  PRIMARY KEY (`REGISTRO_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes_lineas`
--

LOCK TABLES `ordenes_lineas` WRITE;
/*!40000 ALTER TABLE `ordenes_lineas` DISABLE KEYS */;
INSERT INTO `ordenes_lineas` VALUES (1,25,'04','27','2024',1,'000001',4272024000001,'04272024000001','Principal','CM','PENDIENTE X CONSUMIR',13.63,2.73,27.25,29.98,2,2,'true',10.00,'Consumo minimo: $15','DANIEL',NULL,'DANIEL','Efectivo','facturada','2024-04-27 13:05:05','2024-04-27 13:05:05','2024-04-27 13:05:05','ADMIN',NULL),(2,25,'04','27','2024',1,'000001',4272024000001,'04272024000001','Principal','CV','COVER',10.00,0.00,20.00,20.00,2,2,'false',0.00,'','DANIEL',NULL,'DANIEL','Efectivo','facturada','2024-04-27 13:05:05','2024-04-27 13:05:05','2024-04-27 13:05:05','ADMIN',NULL),(3,25,'04','27','2024',1,'000001',4272024000001,'04272024000001','Principal','1','QUESO BURGESA',2.50,0.25,2.50,2.75,1,2,'true',10.00,'CUANTAS CARNES?: SENCILLA\n','DANIEL','DANIEL','DANIEL','Efectivo','facturada','2024-04-27 13:05:05','2024-04-27 13:06:53','2024-04-27 13:05:05','ADMIN',NULL);
/*!40000 ALTER TABLE `ordenes_lineas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `printers`
--

DROP TABLE IF EXISTS `printers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `printers` (
  `area` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  UNIQUE KEY `printername` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printers`
--

LOCK TABLES `printers` WRITE;
/*!40000 ALTER TABLE `printers` DISABLE KEYS */;
INSERT INTO `printers` VALUES ('precuenta','EPSONP1');
/*!40000 ALTER TABLE `printers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privilegios`
--

DROP TABLE IF EXISTS `privilegios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privilegios` (
  `priv_id` int(11) NOT NULL AUTO_INCREMENT,
  `privilegio` varchar(50) DEFAULT NULL,
  `opcion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`priv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privilegios`
--

LOCK TABLES `privilegios` WRITE;
/*!40000 ALTER TABLE `privilegios` DISABLE KEYS */;
INSERT INTO `privilegios` VALUES (1,'Mantener Usuario',7),(2,'Mantener Roles',7),(3,'Mantener Usuario Grupo',7),(4,'Mantener Usuario Privilegio',7),(5,'Mantener Grupos',7),(6,'Mantener Grupos Opciones',7),(7,'Mantener Comanda',1),(8,'Mantener Proveedores',7),(9,'Mantener Clientes',7),(10,'Mantener Mesas',7),(11,'Mantener Productos',7),(12,'Mantener Ingredientes',7),(13,'Mantener Cat-Productos',7),(14,'Mantener Empresa',7),(15,'Mantener Cocina',7),(16,'Mantener Bar',7),(17,'Mantener Caja',7);
/*!40000 ALTER TABLE `privilegios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `producto_id` int(100) NOT NULL AUTO_INCREMENT,
  `nombre_prod` varchar(70) DEFAULT NULL,
  `precio_final` decimal(10,4) DEFAULT NULL,
  `precio_sugerido` decimal(10,4) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `menu` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `urlimg` varchar(50) DEFAULT NULL,
  `fechadesde` date DEFAULT NULL,
  `horadesde` time DEFAULT NULL,
  `fechahasta` date DEFAULT NULL,
  `horahasta` time DEFAULT NULL,
  `lunes` varchar(6) DEFAULT NULL,
  `martes` varchar(6) DEFAULT NULL,
  `miercoles` varchar(6) DEFAULT NULL,
  `jueves` varchar(6) DEFAULT NULL,
  `viernes` varchar(6) DEFAULT NULL,
  `sabado` varchar(6) DEFAULT NULL,
  `domingo` varchar(6) DEFAULT NULL,
  `servicio` varchar(6) DEFAULT NULL,
  `propina` varchar(6) DEFAULT NULL,
  `porcmant` decimal(10,4) DEFAULT NULL,
  `porcganancia` decimal(10,4) DEFAULT NULL,
  `notas_obligatorias` varchar(6) DEFAULT NULL,
  `preguntas` varchar(255) DEFAULT NULL,
  `respuestas` varchar(255) DEFAULT NULL,
  `fecha_creado` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`producto_id`),
  UNIQUE KEY `nombre_prod` (`nombre_prod`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (2,'DOCENA DE CONCHAS',6.0000,5.9600,'ENTRADAS','ENTRANTES','DOCENA DE CONCHAS','Activo','2024-04-27','descarga.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-04-27 22:33:19'),(3,'DOCENA DE HUEVOS DE CODORNIZ ',3.0000,2.4810,'ENTRADAS','ENTRANTES','12 HUEVOS DE CODORNIZ ACOMPAÑADO DE SALSA ROSADA.','Activo','2024-04-28','huevo duro.png',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-04-27 22:44:57'),(4,'NACHOS CHILI CON CARNE',4.0000,3.2340,'ENTRADAS','ENTRANTES','CHILI CON CARNE PICANTE.','Activo','2024-04-27','WhatsApp Image 2024-04-27 at 23.11.25 (1).jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-04-27 23:12:33'),(5,'GUACAMOLE',3.5000,2.6670,'ENTRADAS','ENTRANTES','GUACAMOLE CON HUEVO, CUAJADA Y 2 TORTILLA FRITA','Activo','2024-04-27','IMG_0170.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-04-27 23:36:19'),(6,'PUPUSA REVUELTA',1.5000,1.4140,'ENTRADAS','ENTRANTES','ACOMPAÑADA DE SALSA DE TOMATE Y CURTIDO.','Activo','2024-04-28','pupusas1.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'true','MAIZ/ ARROZ','MAIZ/ ARROZ','2024-04-28 00:17:51'),(7,'PUPUSA DE FRIJOL CON QUESO',1.5000,1.4850,'ENTRADAS','ENTRANTES','ACOMPAÑADA DE CURTIDO Y SALSA','Activo','2024-04-28','pupusas1.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'true','MAIZ/ARROZ','MAIZ/ARROZ','2024-04-28 12:41:51'),(8,'PUPUSA DE QUESO',1.5000,1.3220,'ENTRADAS','ENTRANTES','ACOMPAÑADA DE CURTIDO Y SALSA DE TOMATE','Activo','2024-04-28','pupusas1.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'true','MAIZ/ARROZ','MAIZ/ARROZ','2024-04-28 13:23:31'),(9,'PUPUSA DE CAMARON',1.7500,1.6940,'ENTRADAS','ENTRANTES','ACOMPAÑADO DE CURTIDO Y SALSA DE TOMATE','Activo','2024-04-28','pupusas1.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'true','MAIZ/ARROZ','MAIZ/ARROZ','2024-04-28 13:34:49'),(10,'SOPA PAVESA ',4.5000,3.8990,'SOPAS','SOPAS Y CREMAS','SOPA DE CHORIZO ACOMPAÑADA DE CRUTONES','Activo','2024-04-28','WhatsApp Image 2024-04-28 at 14.19.49.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-04-28 14:24:52'),(11,'SOPA DE CAMARON',8.5000,7.5460,'SOPAS','SOPAS Y CREMAS','SOPA DE CAMARON CON HUEVO Y UNA TORTILLA','Activo','2024-05-03','afefea2e-9074-4653-80e7-9b50c6c8f786.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'true','CON HUEVO/SIN HUEVO','CON HUEVO/SIN HUEVO','2024-04-28 15:12:42'),(12,'CREMA DE CAMARON',9.5000,8.5000,'SOPAS','SOPAS Y CREMAS','ACOMPAÑADO DE UNA TORTILA','Activo','2024-05-04','WhatsApp Image 2024-04-28 at 15.14.34.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-04-28 15:18:49'),(13,'EXTRA JAMON',1.0000,0.5290,'PIZZAS','ORDEN EXTRA $1','2 LASCAS DE JAMON','Activo','2024-04-28','JAMON.png',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-04-28 16:16:12'),(14,'EXTRADE PEPPERONI',1.0000,0.8140,'PIZZAS','ORDEN EXTRA $1','2 ONZ DE PEPPERONI','Activo','2024-04-28','peperoni.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-04-28 16:18:57'),(15,'EXTRA DE CHORIZO',1.0000,0.8140,'PIZZAS','ORDEN EXTRA $1','UN CHORIZO DE PLATO ','Activo','2024-04-28','CHORIZO.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-04-28 16:21:27'),(20,'MARISCADA',18.5000,18.4770,'SOPAS','SOPAS Y CREMAS','MARISCADA CON UNA TORTILLA','Activo','2024-05-04','MARISCADA.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-03 16:14:38'),(21,'SOPON DE GALLINA',5.0000,4.9670,'SOPAS','SOPAS Y CREMAS','CON 1/8DE GALLINA','Activo','2024-05-04','SOPON.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-04 00:56:51'),(22,'COMBO DE GALLINA',7.5000,7.2110,'SOPAS','SOPAS Y CREMAS','1/2 SOPA ACOMPAÑADA DE 1/4 DE GALLINA ','Activo','2024-05-11','SOPA.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 15:39:02'),(23,'SOPA DE TORTILLA',4.5000,2.1010,'SOPAS','SOPAS Y CREMAS','SOPA DE TORTILLA CON AGUACATE QUESO Y CREMA','Activo','2024-05-11','SOPA_TORTILLA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 15:46:53'),(24,'CONCHAS GRATINADAS',7.0000,6.0190,'PLATOS','PABOTANEAR','CONCHAS GRATINADAS','Activo','2024-05-11','CONCHAS_GARTINA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 16:27:51'),(25,'PLATO DE PESCADETA',6.5000,6.4480,'PLATOS','PABOTANEAR','ACOMPAÑADO DE CHIMOL Y CEBOLLA CURTIDA','Activo','2024-05-11','PESCADETA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 16:32:36'),(26,'PLATILLO DE PESCADO',5.6000,5.5940,'PLATOS','PABOTANEAR','ACOMPAÑADO DE LIMON Y TORTILLA FRITA','Activo','2024-05-11','PESCADO.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 16:39:20'),(27,'CHORICERO TIPICO',5.5000,3.8950,'PLATOS','PABOTANEAR','ACOMPAÑADO DE AGUACATE Y TORTILLA Y CUAJADA','Activo','2024-05-11','CHORICERO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 19:52:04'),(28,'PLATO DE BOCAS CARNIVORO',17.2500,17.0390,'PLATOS','PABOTANEAR','ACOMPAÑADO DE PAPAS TORTILLA Y SUS SALSAS','Activo','2024-05-11','CARNIVORO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 20:01:32'),(29,'PLATO DE BOCAS MIXTO',17.2500,15.6960,'PLATOS','PABOTANEAR','ACOMPAÑADO DE PAPAS SALSAS Y TORTILLA FRITA','Activo','2024-05-11','MIXTO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 21:28:21'),(30,'PLATO DE BOCAS DEL MAR',17.2500,14.5170,'PLATOS','PABOTANEAR','ACOMPAÑADO DE PAPAS TORTILLA Y SALSAS','Activo','2024-05-11','BOCAS_DEL_MAR.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 21:40:21'),(31,'PLATILLO DE CAMARONES EMPANIZADOS',9.0000,6.3560,'PLATOS','PABOTANEAR','ACOMPAÑADOS DE SALSA TARTARA Y TORTILLA','Activo','2024-05-23','PLATILLO_CAMARONES_EMPA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 21:58:32'),(32,'PLATILLO DE CAMARONES AL AJILLO',8.5000,6.7180,'PLATOS','PABOTANEAR','ACOMPAÑADOS DE AGUACATE, TORTILLA FRITA.','Activo','2024-05-23','PLATILLO_CAMARONES_AL_AJILLO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 22:19:10'),(33,'PLATO DE COSTILLON',6.5000,6.2790,'PLATOS','PABOTANEAR','5 COSTILLON, ACOMPAÑADO, TORTILLA Y CHIMOL','Activo','2024-05-11','COSTILLON.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 22:32:45'),(34,'TROCITOS DE LONJA EMPANIZADA',8.0000,7.9000,'PLATOS','PABOTANEAR','ACOMPAÑADOS DE SALSA TARTARA Y TORTILLA FRITA.','Activo','2024-05-11','TROCITOS_DE_LONJA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-11 22:44:41'),(35,'CAMARONES SALTEADOS AL CAJUN',15.2500,15.1960,'PLATOS','PABOTANEAR','1 LB. CAMARONES AL ESTILO LOUISIANA.','Activo','2024-05-17','CAMARONES_CAJUN.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-12 00:01:36'),(36,'ENSALADA NATURAL',3.5000,2.2480,'ENTRADAS','ENSALADAS','ENSALADA FRESCA','Activo','2024-05-12','ENSALADA_NATU.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-12 00:58:24'),(37,'ENSALADA CESAR',7.8500,7.8470,'PLATOS','ENSALADAS','ENSALADA CESAR','Activo','2024-05-12','ENSALADD_CESAR.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-12 01:15:15'),(38,'CLUB SANDWICH DE POLLO',6.0000,5.8290,'ENTRADAS','SANDWICH','SANDWICH ACOMPAÑADO DE PAPAS ','Activo','2024-05-17','SANDWICH.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-17 21:42:15'),(39,'CLUB SANDWICH MIXTO',5.5000,3.4210,'ENTRADAS','SANDWICH','ACOMPAÑADO DE PAPAS FRANCESAS','Activo','2024-05-17','SANDWICH.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-17 21:51:02'),(40,'PEPITO DE RES',8.0000,7.9390,'ENTRADAS','SANDWICH','ACOMPAÑADO DE PAPAS FRANCESAS','Activo','2024-05-17','PEPITO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-17 22:08:55'),(41,'PEPITO DE PECHUGA',6.0000,5.8050,'ENTRADAS','SANDWICH','ACOMPAÑADO DE PAPAS FRANCESAS','Activo','2024-05-17','PEPITO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-17 22:21:29'),(42,'TACOS DE CERDO ADOBADO',6.5000,6.1940,'ENTRADAS','LO MEXICANO','4 TACOS DE CERDO ADOBADO','Activo','2024-05-17','TACOS__CERDO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-17 22:42:51'),(43,'TACOS DE RES ',6.7500,6.6980,'ENTRADAS','LO MEXICANO','4 TACOS DE RES','Activo','2024-05-17','TACOS__CERDO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-17 22:45:23'),(44,'TORTA MEXICANA DE RES',7.5000,7.3570,'ENTRADAS','LO MEXICANO','ACOMPAÑADA DE CHIMOL Y SALSA','Activo','2024-05-17','TORTA_MEXICANA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-17 22:57:15'),(45,'TOREADITO DE RES ',6.0000,5.7160,'ENTRADAS','LO MEXICANO','FAJITAS PICANTES ACOMPAÑADOS DE TORTILLA FRITA','Activo','2024-05-17','TOREADO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-17 23:04:59'),(46,'TOREADITO MIXTO',6.5000,6.2850,'ENTRADAS','LO MEXICANO','FAJITAS PICANTES CON TORTILLA FRITA','Activo','2024-05-17','TOREADO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-17 23:13:46'),(47,'BURRITO DE RES O CERDO',7.5000,7.2820,'ENTRADAS','LO MEXICANO','ACOMPAÑADO DE SU SALSA','Activo','2024-05-17','BURRITO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'true','RES/CERDO','RES/CERDO','2024-05-17 23:23:16'),(48,'ARROZ CON CAMARONES',7.2500,7.1170,'PLATOS','ARROCES','ACOMPAÑADO DE TORTILLA FRITA','Activo','2024-05-18','ARROZ_CAMARO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-18 00:33:00'),(49,'ARROZ CON CALAMARES',6.7500,6.6940,'PLATOS','ARROCES','ACOMPAÑADO DE TORTILLA FRITA','Activo','2024-05-18','ARROZ_CON_CALAMR.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-18 00:40:44'),(50,'ARROZ CON CONCHAS',7.7500,7.7370,'PLATOS','ARROCES','ACOMPAÑADO DE TORTILLA FRITA','Activo','2024-05-18','ARROZ_CON_CONCHAS.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-18 00:51:10'),(51,'PINCHO DE RES ',8.7500,8.6240,'PLATOS','PINCHOS','ACOMPAÑADO DE DOS TORTILLAS','Activo','2024-05-18','PINCHO_DE_RES.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-18 22:28:55'),(52,'PINCHO DE PECHUGA',6.5000,6.4290,'PLATOS','PINCHOS','ACOMPAÑADO DE DOS TORTILLA ','Activo','2024-05-18','PINCHO_DE_POLLO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-18 22:50:11'),(53,'PINCHO DE CERDO',6.0000,5.5350,'PLATOS','PINCHOS','ACOMPAÑADO DE DOS TORTILLAS','Activo','2024-05-18','PINCHO_DE_CERDO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-18 23:14:19'),(54,'COSTILLA RIBLET',6.7500,5.5730,'PLATOS','CARNES Y POLLOS','ACOMPAÑADO DE TORTILLA Y CEBOLLA Y SALSA','Activo','2024-05-18','COSTILLA_RIBLET.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-18 23:30:16'),(55,'PLATO DE PECHUGA DESHUEZADA',7.0000,6.1670,'PLATOS','CARNES Y POLLOS','ACOMPAÑADOS DE PAPAS AL AJO','Activo','2024-05-19','PECHUGA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-18 23:34:53'),(56,'PLATO DE POLLO ENCEBOLLADO',6.0000,5.6040,'PLATOS','CARNES Y POLLOS','ACOMPAÑADO DE ARROZ Y TORTILLA','Activo','2024-05-18','POLLO_ENCEBOLLADO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-18 23:42:13'),(57,'PLATO PUYAZO ',8.5000,7.6640,'PLATOS','CARNES Y POLLOS','ACOMPAÑADO DE UNA TORTILLA Y ENSALADA','Activo','2024-05-19','PUYAZO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'true','TERMINO MEDIO/TERMINO BIEN COCIDO/TERMINO TRES CUARTOS','TERMINO MEDIO/TERMINO BIEN COCIDO/TERMINO TRES CUARTOS','2024-05-18 23:57:04'),(58,'LOMO DE CERDO ADOBADO',6.5000,4.8670,'PLATOS','CARNES Y POLLOS','CERDO ADOBADO ACOMPAÑADO DE PAPAS Y TORTILLA','Activo','2024-05-19','PECHUGA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-19 00:00:08'),(59,'COSTILLA TIPICA AHUMADA',11.3000,11.2180,'PLATOS','CARNES Y POLLOS','ACOMPAÑADA DE SUS SALSAS','Activo','2024-05-19','TIPICA_AHUMADA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-19 00:08:32'),(60,'PLATO TIPICO',11.7500,11.7300,'PLATOS','CARNES Y POLLOS','ACOMPAÑADO DE UNA TORTILLA GUACAMOLE Y CUAJADA','Activo','2024-05-23','TIPICO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'true','TERMINO MEDIO/TERMINO TRES CUARTO/TERMINO BIEN COCIDO','TERMINO MEDIO/TERMINO TRES CUARTO/TERMINO BIEN COCID','2024-05-23 14:14:56'),(61,'LONJA A PLANCHA',9.0000,8.4040,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADA DE TORTILLA FRITA','Activo','2024-05-23','LONJA_A_LA_PLANCHA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'true','AL AJO/A LA PLANCHA','AL AJO/A LA PLANCHA','2024-05-23 18:06:09'),(62,'LONJA EMPANIZADA',9.3500,8.6970,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADA DE PAPAS Y SALSA TARTARA','Activo','2024-05-23','LONJA_EMPANIZADA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-23 18:17:05'),(63,'PLATO DE CAMARONES EMPANIZADOS',13.5000,12.4340,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADO DE PAPAS Y SALSA','Activo','2024-05-23','PLATO_DE_CAMARONES_EM.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-23 18:35:57'),(64,'PLATO DE CAMARONES A LA PLANCHA',12.5000,12.4070,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADO DE PAPAS Y TORTILLA','Activo','2024-05-23','PLATO_A_LA_PLANCHA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-23 19:05:56'),(65,'PLATO MIXTO',16.5000,16.4000,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADOS DE PAPA Y UNA TORTILLA','Activo','2024-05-23','PLATO_MIXTO.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'true','TERMINO MEDIO/TERMINO TRES CUARTOS/TERMINO BIEN COCIDO','TERMINO MEDIO/TERMINO TRES CUARTOS/TERMINO BIEN COCIDO','2024-05-23 19:20:09'),(66,'PLATO MAR TIERRA Y AIRE',19.0000,18.9830,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADO DE PAPAS Y UNA TORTILLA','Activo','2024-05-23','PLATO_MAR_Y_TIERRA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-23 19:24:24'),(67,'PARRILLADA MARINERA',31.5000,31.4250,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADA DE TORTILLA Y PAPAS AL AJO','Activo','2024-05-23','PARRILLADA_MARINERA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'true','TERMINO MEDIO/TERMINO TRES CUARTOS/TERMINO BIEN COCIDO','TERMINO MEDIO/TERMINO TRES CUARTOS/TERMINO BIEN COCIDO','2024-05-23 19:30:31'),(68,'COSTILLA SABOR ORIENTAL',8.5000,8.3660,'PLATOS','CARNES Y POLLOS','ACOMPAÑADA DE ARROZ Y ENSALADA','Activo','2024-05-24','COSTILLA_SABOR_ORIENTAL.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-24 14:30:40'),(69,'AZAFATON AUTOMARISCOS',26.0000,25.9950,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADO DE PAPAS Y DOS CHICLOSAS','Activo','2024-05-24','AZAFATON.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-24 14:52:14'),(70,'PLATO DE CHICHARRONES CON COSTILLA',13.5000,13.3150,'PLATOS','CARNES Y POLLOS','ACOMPAÑADO DE CEBOLLA Y TORTILLA FRITA','Activo','2024-05-30','CHICHARRONES.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-25 22:26:30'),(71,'PLATO DE CURVINA RELLENA MEDIANA',14.5000,14.1460,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADO DE ENSALADA Y TORTILLA FRITA','Activo','2024-05-25','CURBVINBA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-25 23:04:57'),(72,'PLATO DE CURVINA RELLENA GRANDE',17.0000,16.1800,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADO DE TORTILLA FRITA Y ENSALADA','Activo','2024-05-25','CURBVINBA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-25 23:10:19'),(73,'BOCA COLORADA RELLENA MEDIANA',16.0000,15.6720,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADO DE ENSALADA Y TORTILLA FRITA','Activo','2024-05-25','CURBVINBA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-25 23:21:45'),(74,'BOCA COLORADA RELLENA GRANDE',19.0000,18.7230,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADO DE TORTILLA FRITA Y ENSALADA','Activo','2024-05-25','CURBVINBA.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-25 23:25:06'),(75,'PLATO DE ALITAS ',7.5000,5.0420,'PLATOS','NUESTRAS ESPECIALIDADES','ACOMPAÑADO DE BASTONES DE APIO Y ZANAHORIA','Activo','2024-05-26','ALAS.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'true','BUFALO/BARBACOA/CHIPOTLE','BUFALO/BARBACOA/CHIPOTLE','2024-05-26 00:49:14'),(76,'COPA DE SORBETE',3.2500,3.1400,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','TRES BOLITAS DE SORBETE ','Activo','2024-05-30','COPA_SORBTE.jpeg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 13:40:05'),(77,'LIMONADA CON SODA',2.0000,1.6480,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','LIMONADA CON SODA','Activo','2024-05-30','LIMONADA_NAT.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 13:51:05'),(78,'LIMONADA CON HIERBABUENA',2.0000,0.6570,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','LIMONADA CO N HIERBA BUENA','Activo','2024-05-30','LIMONADA_NAT.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 13:59:21'),(79,'LIMONADA NATURAL',1.5000,0.5290,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','LIMONADA NATURAL','Activo','2024-05-30','LIMONADA_NAT.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 14:01:07'),(80,'JUGO DE NARANJA NATURAL',2.0000,1.8310,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','JUGO DE NARANJA','Activo','2024-05-30','JUGO_NARANJA.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 14:03:25'),(81,'CEVADA CON LECHE',2.0000,0.8440,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','CEVADA CON LECHE','Activo','2024-05-30','CEVADA.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 14:08:51'),(82,'BOTELLA CON AGUA',1.1500,0.7830,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','BOTELLA CON AGUA','Activo','2024-05-30','AGUA.png',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 14:11:36'),(83,'TE HELADO DE LIMON',1.5000,1.2920,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','TE HELADO DE LIMON','Activo','2024-05-30','TE_HELADO.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 14:13:18'),(84,'TE HELADO DE DURAZNO',1.5000,1.2920,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','TE HELADO DE DURAZNO','Activo','2024-05-30','TE_HELADO.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 14:34:36'),(85,'COCA COLA',1.5000,1.2310,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','COCA COLA','Activo','2024-05-30','COCA_COLA.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 14:51:22'),(86,'FANTA',1.5000,1.2310,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','FANTA','Activo','2024-05-30','FANTA.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 14:55:15'),(87,'UVA TROPICAL',1.5000,1.2310,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','UVA','Activo','2024-05-30','UVA.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 14:57:41'),(88,'FRESA TROPICAL',1.5000,1.2310,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','FRESA','Activo','2024-05-30','FRESA.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 14:59:26'),(89,'KINLEY',1.5000,1.2310,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','KINLEY','Activo','2024-05-30','KINLEY.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 15:02:28'),(90,'FRESCA',1.5000,1.2310,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','FRESCA LATA','Activo','2024-05-30','FRESCA.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-30 15:04:49'),(91,'SPRITE',1.5000,1.2310,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','SPRITE','Activo','2024-05-31','SPRITE.png',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-31 20:38:37'),(92,'BOTELLA DE ABSOLUT',44.0000,50.1450,'LICOR','BOTELLAS DE WHISKEY','ORDEN DE HIELO LIMON Y DOS SODAS','Activo','2024-07-30','ABSOLUT.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-05-31 20:50:38'),(93,'FROZEN DE COCOC',3.5000,1.7290,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','FROZEN DE COCO','Activo','2024-07-28','FROZEN_COCO.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-07-28 01:31:53'),(94,'HORCHATA CON LECHE',2.0000,1.3040,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','HORCHATA CON LECHE','Activo','2024-07-28','ORCHATA.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-07-28 01:42:28'),(95,'TAZA DE CAFE',1.0000,0.1830,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','TAZA DE CAFE','Activo','2024-08-10','CAFE.png',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-08-10 01:11:54'),(96,'TAZA DE LECHE',1.5000,0.4270,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','TAZON DE LECHE','Activo','2024-08-10','LECHE.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-08-10 01:17:44'),(97,'REFRESCO DE ENSALADA',2.5000,1.0190,'BEBIDAS','BEBIDAS FRIAS Y CALIENTES','REFRESCO DE ENSALADA','Activo','2024-08-10','ENSALADA_REFRESCO.jpg',NULL,NULL,NULL,NULL,'true','true','true','true','true','true','true','true','true',50.0000,20.0000,'false','','','2024-08-10 01:24:37');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_categorias`
--

DROP TABLE IF EXISTS `productos_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_categorias` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` enum('categoria','subcategoria') DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `asignado` int(11) DEFAULT NULL,
  `urlcat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `tipo` (`tipo`,`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_categorias`
--

LOCK TABLES `productos_categorias` WRITE;
/*!40000 ALTER TABLE `productos_categorias` DISABLE KEYS */;
INSERT INTO `productos_categorias` VALUES (1,'categoria','BARRA',0,'bar.png'),(2,'categoria','BEBIDAS',0,'bebidas.png'),(3,'categoria','BOCAS',0,'bocas.png'),(4,'categoria','COCKTEL',0,'cocktel.png'),(5,'categoria','ENTRADAS',0,'entradas.png'),(6,'categoria','LICOR',0,'licor.png'),(7,'categoria','PLATOS',0,'platos.png'),(8,'categoria','SOPAS',0,'sopas.png'),(9,'subcategoria','ARROCES',7,NULL),(10,'subcategoria','BEBIDAS FRIAS Y CALIENTES',2,NULL),(11,'subcategoria','BOCAS DE $1.25',3,NULL),(12,'subcategoria','BOCAS ESPECIALES',3,NULL),(13,'subcategoria','BOTELLAS DE RON',1,NULL),(14,'subcategoria','BOTELLAS DE WHISKEY',1,NULL),(15,'subcategoria','CARNES Y POLLOS',7,NULL),(16,'subcategoria','CERVEZA EXTRANJERA',2,NULL),(17,'subcategoria','CERVEZA NACIONAL',2,NULL),(18,'subcategoria','CIGARROS',NULL,NULL),(19,'subcategoria','COCKTELES Y CEVICHES',4,NULL),(20,'subcategoria','ENSALADAS',7,NULL),(22,'subcategoria','LO MEXICANO',7,NULL),(23,'subcategoria','PABOTANEAR',7,NULL),(24,'subcategoria','MENU NAVIDENO 2022',7,NULL),(25,'subcategoria','NUESTRAS ESPECIALIDADES',7,NULL),(26,'subcategoria','ORDENES EXTRAS',7,NULL),(27,'subcategoria','PINCHOS',3,NULL),(28,'subcategoria','PIZZAS',7,NULL),(29,'subcategoria','PROMOCIONES',7,NULL),(30,'subcategoria','SANDWICH',21,NULL),(31,'subcategoria','SOPAS Y CREMAS',8,NULL),(32,'subcategoria','UTENSILIOS',7,NULL),(33,'subcategoria','VINOS',6,NULL),(34,'subcategoria','ENTRANTES',5,NULL),(35,'categoria','PIZZAS',0,'PIZZAICON.png'),(37,'subcategoria','EXTRA $1.50',28,NULL),(38,'subcategoria','ORDEN EXTRA $1',28,NULL),(39,'subcategoria','VODKA',NULL,NULL),(40,'subcategoria','BOTELLAS DE VODKA',NULL,NULL);
/*!40000 ALTER TABLE `productos_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_comanda_cat`
--

DROP TABLE IF EXISTS `productos_comanda_cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_comanda_cat` (
  `categoria` varchar(40) NOT NULL,
  `area` enum('BAR','COCINA') DEFAULT NULL,
  PRIMARY KEY (`categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_comanda_cat`
--

LOCK TABLES `productos_comanda_cat` WRITE;
/*!40000 ALTER TABLE `productos_comanda_cat` DISABLE KEYS */;
INSERT INTO `productos_comanda_cat` VALUES ('BARRA','BAR'),('BEBIDAS','BAR'),('BOCAS','COCINA'),('COCKTEL','COCINA'),('ENTRADAS','COCINA'),('LICOR','BAR'),('PLATOS','COCINA'),('SOPAS','COCINA');
/*!40000 ALTER TABLE `productos_comanda_cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_sustitutos`
--

DROP TABLE IF EXISTS `productos_sustitutos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_sustitutos` (
  `producto_id` int(11) DEFAULT NULL,
  `nombre_prod` varchar(50) DEFAULT NULL,
  `substituto_id` int(11) DEFAULT NULL,
  `nombre_sust` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_sustitutos`
--

LOCK TABLES `productos_sustitutos` WRITE;
/*!40000 ALTER TABLE `productos_sustitutos` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos_sustitutos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedores` (
  `proveedor_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `telefono` decimal(8,0) DEFAULT NULL,
  `celular` decimal(8,0) DEFAULT NULL,
  `correo` varchar(40) DEFAULT NULL,
  `direccion` varchar(60) DEFAULT NULL,
  `departamento` varchar(20) DEFAULT NULL,
  `municipio` varchar(20) DEFAULT NULL,
  `pais` varchar(20) DEFAULT NULL,
  `contactos` varchar(100) DEFAULT NULL,
  `reg_iva` decimal(7,0) DEFAULT NULL,
  `nit` decimal(14,0) DEFAULT NULL,
  `giro` varchar(20) DEFAULT NULL,
  `clasificacion_dgii` varchar(20) DEFAULT NULL,
  `estado` varchar(10) DEFAULT NULL,
  `fecha_creado` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`proveedor_id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (1,'LA CONSTANCIA',77664306,87666666,'industria@constancia.com','juan pablo II 6a 10ma avenida espana','San Salvador','San Salvador','El Salvador','Carlos Perez, Julio Martinez',1234567,12345678901234,'Comercial','Pequeno','Inactivo','2023-04-09 15:17:18'),(2,'PROVEEDOR 2',15656556,45656565,'industria@proveedor.com','san jacinto pasaje 2, calle 9','San Salvador','Nejapa','El Salvador','Mario Perez',1234567,12345678901235,'Comercial','Pequeno','Activo','2023-04-09 15:17:18'),(3,'PROVEEDOR 23',15656556,45656565,'industria@proveedor.com','san jacinto pasaje 2, calle 9','San Salvador','Ilopango','El Salvador','Carlos Perez, Julio Martinez',1234567,12345678901235,'Comercial','Pequeno','Activo','2023-04-09 15:17:18'),(7,'LA CONSTANCIA23',77664306,87664430,'industria@constancia.com','juan pablo II 6a 10ma avenida espana','San Salvador','San Salvador','El Salvador','Carlos Perez, Julio Martinez',1234567,12345678901234,'Comercial','Pequeno','Activo','2023-04-09 15:17:18'),(9,'LA CONSTANCIA232',77664306,87664430,'industria@constancia.com','juan pablo II 6a 10ma avenida espana','San Salvador','San Salvador','El Salvador','Carlos Perez, Julio Martinez',1234567,12345678901234,'Comercial','Pequeno','Activo','2023-04-09 15:17:18'),(12,'LA CONSTANCIA23211122',77664306,87664430,'industria@constancia.com','juan pablo II 6a 10ma avenida espana','San Salvador','San Salvador','El Salvador','Carlos Perez, Julio Martinez',1234567,12345678901234,'Comercial','Pequeno','Activo','2023-04-09 15:17:18'),(15,'OTRO PROVEEDOR',12212221,88888888,'correo@correo.com','otro direccion valida','Ahuachapan','Apaneca','El Salvador','nombre1, nombre2',1111111,44564656456455,'Comercial','Pequeno','Inactivo','2023-04-09 15:17:18'),(17,'super selectos',45546456,78997897,'selectos@selectos.com','direccion de muestra','Ahuachapan','Ahuachapan','El Salvador','alguien del lugar, sin nombre',5444664,65446546565456,'Comercial','Pequeno','Activo','2023-04-09 15:17:18'),(19,'MAURICIO FUENTES',54564545,44644664,'mfuente11111s@gmail.com','col yumury calle guantanamo','San Salvador','Mejicanos','El Salvador','cualquiera',1111111,11111111111111,'Comercial','Pequeno','Activo','2023-04-09 15:17:18');
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `reporte_ordenes_facturadas`
--

DROP TABLE IF EXISTS `reporte_ordenes_facturadas`;
/*!50001 DROP VIEW IF EXISTS `reporte_ordenes_facturadas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `reporte_ordenes_facturadas` AS SELECT 
 1 AS `FECHA_IN`,
 1 AS `MESA`,
 1 AS `ORDEN_CORRELATIVOTXT`,
 1 AS `TOTAL`,
 1 AS `CANT_PERSONAS`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `reporte_ordenes_nofacturadas`
--

DROP TABLE IF EXISTS `reporte_ordenes_nofacturadas`;
/*!50001 DROP VIEW IF EXISTS `reporte_ordenes_nofacturadas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `reporte_ordenes_nofacturadas` AS SELECT 
 1 AS `FECHA_IN`,
 1 AS `MESA`,
 1 AS `ORDEN_CORRELATIVOTXT`,
 1 AS `TOTAL`,
 1 AS `CANT_PERSONAS`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `grupo_id` int(11) NOT NULL COMMENT 'grupo',
  `opcion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de construccion de menu principal';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (6,4),(1,2),(1,4),(1,5),(1,6),(1,1),(1,3),(1,7),(2,1),(9,2),(10,3);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_fijos`
--

DROP TABLE IF EXISTS `roles_fijos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_fijos` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombrerol` varbinary(30) DEFAULT NULL,
  PRIMARY KEY (`rol_id`),
  UNIQUE KEY `nombrerol` (`nombrerol`),
  KEY `rol_id` (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_fijos`
--

LOCK TABLES `roles_fijos` WRITE;
/*!40000 ALTER TABLE `roles_fijos` DISABLE KEYS */;
INSERT INTO `roles_fijos` VALUES (1,_binary 'ADMINISTRADOR'),(15,_binary 'BARTENDER'),(2,_binary 'CAJERO'),(14,_binary 'COCINERO'),(3,_binary 'INVENTARIO'),(4,_binary 'MESERO'),(6,_binary 'MISC');
/*!40000 ALTER TABLE `roles_fijos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subproductos_asignados`
--

DROP TABLE IF EXISTS `subproductos_asignados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subproductos_asignados` (
  `producto_id` int(11) DEFAULT NULL,
  `subproducto_id` int(11) DEFAULT NULL,
  `cantidad` decimal(10,4) DEFAULT NULL,
  UNIQUE KEY `producto_id` (`producto_id`,`subproducto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subproductos_asignados`
--

LOCK TABLES `subproductos_asignados` WRITE;
/*!40000 ALTER TABLE `subproductos_asignados` DISABLE KEYS */;
/*!40000 ALTER TABLE `subproductos_asignados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidades`
--

DROP TABLE IF EXISTS `unidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidades` (
  `id_unidad` int(100) NOT NULL AUTO_INCREMENT,
  `unidad` varchar(10) NOT NULL,
  PRIMARY KEY (`id_unidad`),
  UNIQUE KEY `unidad` (`unidad`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidades`
--

LOCK TABLES `unidades` WRITE;
/*!40000 ALTER TABLE `unidades` DISABLE KEYS */;
INSERT INTO `unidades` VALUES (1,'BOTELLA'),(2,'CAJA'),(3,'LIBRA'),(4,'MANO'),(5,'MEDIA'),(6,'ONZA'),(7,'ORDEN'),(8,'PORCION'),(9,'UNIDAD');
/*!40000 ALTER TABLE `unidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL COMMENT 'password encriptado',
  `estado` varchar(20) NOT NULL,
  `rol` varchar(20) NOT NULL,
  `meta` decimal(10,0) NOT NULL,
  `comision_venta` decimal(10,2) DEFAULT '0.00',
  `comision_propina` decimal(10,2) DEFAULT '0.00',
  `fecha_creacion` datetime DEFAULT NULL,
  `fondo` varchar(10) DEFAULT 'false',
  `zona1` varchar(10) DEFAULT 'false',
  `zona2` varchar(10) DEFAULT 'false',
  `zona3` varchar(10) DEFAULT 'false',
  `zona4` varchar(10) DEFAULT 'false',
  `zona5` varchar(10) DEFAULT 'false',
  `zona6` varchar(10) DEFAULT 'false',
  `zona7` varchar(10) DEFAULT 'false',
  `zona8` varchar(10) DEFAULT 'false',
  `zona9` varchar(10) DEFAULT 'false',
  `zona10` varchar(10) DEFAULT 'false',
  `fecha_creado` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`,`usuario`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'ADMIN','ADMIN AUTO','b521caa6e1db82e5a01c924a419870cb72b81635','ACTIVO','ADMINISTRADOR',0,0.00,0.00,'2022-09-17 11:17:58','azul','true','true','true','true','true','false','false','false','false','false','2023-04-09 15:18:12'),(30,'VIDAL','VIDAL','b521caa6e1db82e5a01c924a419870cb72b81635','ACTIVO','ADMINISTRADOR',1299,0.00,0.00,'2022-09-17 11:17:58','gris','true','true','false','false','false','false','false','false','false','false','2023-04-09 15:18:12'),(31,'MESERO2','MESERO2','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','ACTIVO','MESERO',12,11.00,17.00,'2022-09-18 07:27:14','verde','true','true','true','true','true','true','true','true','true','true','2023-04-09 15:18:12'),(32,'MESERO3','MESERO3','b521caa6e1db82e5a01c924a419870cb72b81635','ACTIVO','MESERO',122,0.00,1.00,'2022-09-18 07:27:40','verde','true','true','true','true','true','true','true','true','true','true','2023-04-09 15:18:12'),(34,'CAJERO1','CAJERO1','0d1e869f6fea5a8d3a94c031954124e9774bea65','ACTIVO','CAJERO',11,0.00,0.30,'2022-09-18 07:28:29','blanco','true','true','true','true','true','true','true','true','true','true','2023-04-09 15:18:12'),(37,'TEST','TEST USER DE','a204f93d88a0486af4798131b0babd88b3a7f69e','INACTIVO','MESERO',0,18.00,1.00,'2022-09-18 10:53:52','celeste','true','true','true','true','true','true','true','true','true','true','2023-04-09 15:18:12'),(38,'TEST2','TEST2','0aec4d9bc52ab96e424cd057a59cc45eff314107','ACTIVO','ADMINISTRADOR',0,0.00,0.00,'2022-09-19 09:47:11','celeste','false','false','false','false','false','false','false','false','false','false','2023-04-09 15:18:12'),(39,'TEST3','TEST3','512d4c2e2a63ac8c385a1e2315abcf4b3d5c7a9f','ACTIVO','ADMINISTRADOR',0,0.00,0.00,'2022-09-19 09:47:23','celeste','false','false','false','false','false','false','false','false','false','false','2023-04-09 15:18:12'),(40,'TEST4','TEST4','4034a54700430b6a37e56b5c38070f6b1f333b7b','ACTIVO','CAJERO',0,0.00,0.00,'2022-09-19 09:47:38','celeste','false','false','false','false','false','false','false','false','false','false','2023-04-09 15:18:12'),(41,'TEST1234','TEST1234','984816fd329622876e14907634264e6f332e9fb3','ACTIVO','CAJERO',0,0.00,0.00,'2022-09-21 06:52:15','celeste','false','false','false','false','false','false','false','false','false','false','2023-04-09 15:18:12'),(42,'DANIEL','DANIEL','b521caa6e1db82e5a01c924a419870cb72b81635','ACTIVO','MESERO',0,0.00,0.00,'2022-09-28 06:05:45','celeste','true','true','true','false','false','false','false','false','false','false','2023-04-09 15:18:12'),(43,'USERMESERO','USER MESERO','b521caa6e1db82e5a01c924a419870cb72b81635','ACTIVO','MESERO',0,1.00,1.00,'2022-10-13 05:30:15','gris','true','true','true','true','true','true','true','true','true','true','2023-04-09 15:18:12'),(47,'MESEROS','MESEROS','83ac33546620c53121522c2283118b4f44ec2e7b','ACTIVO','MESERO',0,1.00,1.00,'2023-02-23 06:11:30','azul','true','true','true','true','true','true','true','true','true','true','2023-04-09 15:18:12'),(49,'COCINERO','COCINERO','105a1ecf7f9502f1409fb94970d092cf8ae4ae8d','ACTIVO','COCINERO',0,0.00,0.00,'2023-05-31 06:14:27','azul','false','false','false','false','false','false','false','false','false','false','2023-05-31 06:14:27'),(50,'BAR','BARTENDER','a5d5c1bba91fdb6c669e1ae0413820885bbfc455','ACTIVO','BARTENDER',0,0.00,0.00,'2023-05-31 06:15:01','azul','false','false','false','false','false','false','false','false','false','false','2023-05-31 06:15:01');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_asignaciones`
--

DROP TABLE IF EXISTS `usuarios_asignaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_asignaciones` (
  `grupo_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_asignaciones`
--

LOCK TABLES `usuarios_asignaciones` WRITE;
/*!40000 ALTER TABLE `usuarios_asignaciones` DISABLE KEYS */;
INSERT INTO `usuarios_asignaciones` VALUES (1,1),(2,2),(2,43),(1,30),(2,31),(2,47),(10,49),(9,50);
/*!40000 ALTER TABLE `usuarios_asignaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_privilegios`
--

DROP TABLE IF EXISTS `usuarios_privilegios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_privilegios` (
  `grupo_id` int(11) DEFAULT NULL,
  `priv_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `ver` tinyint(1) DEFAULT '1',
  `modificar` tinyint(1) DEFAULT '1',
  `borrar` tinyint(1) DEFAULT '1',
  `precuenta` tinyint(1) DEFAULT '1',
  `separar` tinyint(1) DEFAULT '1',
  `cortesia` tinyint(1) DEFAULT '1',
  `imprimir` tinyint(1) DEFAULT '1',
  `fecha_creado` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_privilegios`
--

LOCK TABLES `usuarios_privilegios` WRITE;
/*!40000 ALTER TABLE `usuarios_privilegios` DISABLE KEYS */;
INSERT INTO `usuarios_privilegios` VALUES (1,5,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(1,3,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(1,6,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(1,7,2,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(1,7,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(2,7,43,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(1,1,30,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(1,2,30,0,1,0,0,0,0,1,'2023-04-09 15:18:49'),(1,3,30,0,1,0,1,0,0,1,'2023-04-09 15:18:49'),(1,4,30,0,1,0,0,1,1,1,'2023-04-09 15:18:49'),(1,5,30,1,1,0,1,1,0,1,'2023-04-09 15:18:49'),(1,6,30,1,1,0,1,1,1,1,'2023-04-09 15:18:49'),(1,7,30,1,1,0,1,1,1,1,'2023-04-09 15:18:49'),(8,7,31,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(1,4,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(8,2,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(8,1,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(1,8,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(1,9,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(1,10,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(1,11,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(8,12,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(8,13,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(8,14,1,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(8,8,30,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(8,9,30,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(8,10,30,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(8,11,30,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(8,12,30,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(8,13,30,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(8,14,30,1,1,1,1,1,1,1,'2023-04-09 15:18:49'),(2,7,47,1,0,0,0,0,0,0,'2023-04-09 15:18:49'),(8,7,42,1,1,1,1,1,1,1,'2023-04-30 19:48:47'),(8,9,42,1,1,1,0,0,1,1,'2023-04-30 19:55:21'),(2,15,1,1,1,1,1,1,1,1,'2023-05-31 06:10:06'),(3,16,1,1,1,1,1,1,1,1,'2023-05-31 06:10:15'),(8,15,49,1,1,1,1,1,1,1,'2023-05-31 06:24:46'),(8,16,50,1,1,1,1,1,1,1,'2023-05-31 06:24:56'),(1,17,1,1,1,1,1,1,1,1,'2023-09-11 15:20:54'),(8,15,30,1,1,1,1,1,1,1,'2023-09-11 15:21:32'),(8,16,30,1,1,1,1,1,1,1,'2023-09-11 15:21:33'),(8,17,30,1,1,1,1,1,1,1,'2023-09-11 15:21:34');
/*!40000 ALTER TABLE `usuarios_privilegios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vista_accesos_usuarios`
--

DROP TABLE IF EXISTS `vista_accesos_usuarios`;
/*!50001 DROP VIEW IF EXISTS `vista_accesos_usuarios`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_accesos_usuarios` AS SELECT 
 1 AS `usuario`,
 1 AS `Nombre_usuario`,
 1 AS `grupo_nombre`,
 1 AS `nombre`,
 1 AS `opcion_id`,
 1 AS `icono`,
 1 AS `funcion`,
 1 AS `titulo`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_grupo_opcion`
--

DROP TABLE IF EXISTS `vista_grupo_opcion`;
/*!50001 DROP VIEW IF EXISTS `vista_grupo_opcion`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_grupo_opcion` AS SELECT 
 1 AS `grupo_nombre`,
 1 AS `opcion_id`,
 1 AS `nombre`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_grupo_usuarios`
--

DROP TABLE IF EXISTS `vista_grupo_usuarios`;
/*!50001 DROP VIEW IF EXISTS `vista_grupo_usuarios`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_grupo_usuarios` AS SELECT 
 1 AS `grupo_id`,
 1 AS `grupo_nombre`,
 1 AS `usuario_id`,
 1 AS `usuario`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_privilegios`
--

DROP TABLE IF EXISTS `vista_privilegios`;
/*!50001 DROP VIEW IF EXISTS `vista_privilegios`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_privilegios` AS SELECT 
 1 AS `grupo_id`,
 1 AS `priv_id`,
 1 AS `usuario_id`,
 1 AS `ver`,
 1 AS `modificar`,
 1 AS `borrar`,
 1 AS `imprimir`,
 1 AS `precuenta`,
 1 AS `separar`,
 1 AS `cortesia`,
 1 AS `grupo_nombre`,
 1 AS `privilegio`,
 1 AS `USUARIO`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_prods_ingredientes`
--

DROP TABLE IF EXISTS `vista_prods_ingredientes`;
/*!50001 DROP VIEW IF EXISTS `vista_prods_ingredientes`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_prods_ingredientes` AS SELECT 
 1 AS `PRODUCTO_ID`,
 1 AS `INGREDIENTE_ID`,
 1 AS `CANTIDAD`,
 1 AS `NOMBRE_PROD`,
 1 AS `INGREDIENTE`,
 1 AS `UNIDAD`,
 1 AS `urlimg`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_resumen_mesas`
--

DROP TABLE IF EXISTS `vista_resumen_mesas`;
/*!50001 DROP VIEW IF EXISTS `vista_resumen_mesas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_resumen_mesas` AS SELECT 
 1 AS `ESTADO`,
 1 AS `COUNT`,
 1 AS `POR`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_subcategorias_asignadas`
--

DROP TABLE IF EXISTS `vista_subcategorias_asignadas`;
/*!50001 DROP VIEW IF EXISTS `vista_subcategorias_asignadas`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_subcategorias_asignadas` AS SELECT 
 1 AS `CAT`,
 1 AS `SUBCAT`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_tickets_activos`
--

DROP TABLE IF EXISTS `vista_tickets_activos`;
/*!50001 DROP VIEW IF EXISTS `vista_tickets_activos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_tickets_activos` AS SELECT 
 1 AS `REGISTRO_ID`,
 1 AS `MESA`,
 1 AS `ORDEN_ACTUAL`,
 1 AS `PRODUCTO_ID`,
 1 AS `DETALLE`,
 1 AS `CANTIDAD`,
 1 AS `NOTAS`,
 1 AS `ESTADO`,
 1 AS `AREA`,
 1 AS `FECHA_CREADO`*/;
SET character_set_client = @saved_cs_client;

--
-- Current Database: `automariscos`
--

USE `automariscos`;

--
-- Final view structure for view `reporte_ordenes_facturadas`
--

/*!50001 DROP VIEW IF EXISTS `reporte_ordenes_facturadas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `reporte_ordenes_facturadas` AS select max(`ordenes_lineas`.`FECHA_CREADO`) AS `FECHA_IN`,max(`ordenes_lineas`.`MESA`) AS `MESA`,`ordenes_lineas`.`ORDEN_CORRELATIVOTXT` AS `ORDEN_CORRELATIVOTXT`,sum(`ordenes_lineas`.`PRECIO_TOT`) AS `TOTAL`,max(`ordenes_lineas`.`CANTIDAD_PERSONAS`) AS `CANT_PERSONAS` from `ordenes_lineas` where (`ordenes_lineas`.`ESTADO` = 'facturada') group by `ordenes_lineas`.`ORDEN_CORRELATIVOTXT` order by `ordenes_lineas`.`ORDEN_CORRELATIVOTXT` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `reporte_ordenes_nofacturadas`
--

/*!50001 DROP VIEW IF EXISTS `reporte_ordenes_nofacturadas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `reporte_ordenes_nofacturadas` AS select max(`ordenes_lineas`.`FECHA_CREADO`) AS `FECHA_IN`,max(`ordenes_lineas`.`MESA`) AS `MESA`,`ordenes_lineas`.`ORDEN_CORRELATIVOTXT` AS `ORDEN_CORRELATIVOTXT`,sum(`ordenes_lineas`.`PRECIO_TOT`) AS `TOTAL`,max(`ordenes_lineas`.`CANTIDAD_PERSONAS`) AS `CANT_PERSONAS` from `ordenes_lineas` where (`ordenes_lineas`.`ESTADO` <> 'facturada') group by `ordenes_lineas`.`ORDEN_CORRELATIVOTXT` order by `ordenes_lineas`.`ORDEN_CORRELATIVOTXT` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_accesos_usuarios`
--

/*!50001 DROP VIEW IF EXISTS `vista_accesos_usuarios`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_accesos_usuarios` AS select `a`.`usuario` AS `usuario`,`a`.`nombre` AS `Nombre_usuario`,`c`.`grupo_nombre` AS `grupo_nombre`,`e`.`nombre` AS `nombre`,`e`.`opcion_id` AS `opcion_id`,`e`.`icono` AS `icono`,`e`.`funcion` AS `funcion`,`e`.`titulo` AS `titulo` from ((((`usuarios` `a` join `usuarios_asignaciones` `b`) join `grupos_accesos` `c`) join `roles` `d`) join `opciones_menu` `e`) where ((`a`.`usuario_id` = `b`.`usuario_id`) and (`b`.`grupo_id` = `c`.`grupo_id`) and (`c`.`grupo_id` = `d`.`grupo_id`) and (`d`.`opcion_id` = `e`.`opcion_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_grupo_opcion`
--

/*!50001 DROP VIEW IF EXISTS `vista_grupo_opcion`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_grupo_opcion` AS select `a`.`grupo_nombre` AS `grupo_nombre`,`c`.`opcion_id` AS `opcion_id`,`c`.`nombre` AS `nombre` from ((`grupos_accesos` `a` join `roles` `b`) join `opciones_menu` `c`) where ((`a`.`grupo_id` = `b`.`grupo_id`) and (`b`.`opcion_id` = `c`.`opcion_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_grupo_usuarios`
--

/*!50001 DROP VIEW IF EXISTS `vista_grupo_usuarios`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_grupo_usuarios` AS select `a`.`grupo_id` AS `grupo_id`,`b`.`grupo_nombre` AS `grupo_nombre`,`a`.`usuario_id` AS `usuario_id`,`c`.`usuario` AS `usuario` from ((`usuarios_asignaciones` `a` join `grupos_accesos` `b`) join `usuarios` `c`) where ((`a`.`grupo_id` = `b`.`grupo_id`) and (`a`.`usuario_id` = `c`.`usuario_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_privilegios`
--

/*!50001 DROP VIEW IF EXISTS `vista_privilegios`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_privilegios` AS select `a`.`grupo_id` AS `grupo_id`,`a`.`priv_id` AS `priv_id`,`a`.`usuario_id` AS `usuario_id`,`a`.`ver` AS `ver`,`a`.`modificar` AS `modificar`,`a`.`borrar` AS `borrar`,`a`.`imprimir` AS `imprimir`,`a`.`precuenta` AS `precuenta`,`a`.`separar` AS `separar`,`a`.`cortesia` AS `cortesia`,`b`.`grupo_nombre` AS `grupo_nombre`,`c`.`privilegio` AS `privilegio`,`d`.`usuario` AS `USUARIO` from (((`usuarios_privilegios` `a` join `grupos_accesos` `b`) join `privilegios` `c`) join `usuarios` `d`) where ((`a`.`grupo_id` = `b`.`grupo_id`) and (`a`.`priv_id` = `c`.`priv_id`) and (`d`.`usuario_id` = `a`.`usuario_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_prods_ingredientes`
--

/*!50001 DROP VIEW IF EXISTS `vista_prods_ingredientes`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_prods_ingredientes` AS select `a`.`producto_id` AS `PRODUCTO_ID`,`b`.`ingrediente_id` AS `INGREDIENTE_ID`,`b`.`cantidad` AS `CANTIDAD`,`a`.`nombre_prod` AS `NOMBRE_PROD`,`c`.`ingrediente` AS `INGREDIENTE`,`c`.`unidad` AS `UNIDAD`,`a`.`urlimg` AS `urlimg` from ((`productos` `a` join `ingredientes_asignados` `b`) join `ingredientes` `c`) where ((`a`.`producto_id` = `b`.`producto_id`) and (`b`.`ingrediente_id` = `c`.`ingrediente_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_resumen_mesas`
--

/*!50001 DROP VIEW IF EXISTS `vista_resumen_mesas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_resumen_mesas` AS select `a`.`estado` AS `ESTADO`,count(`a`.`estado`) AS `COUNT`,concat(round(((count(0) / (select count(0) from `mesas_estado`)) * 100),2),'%') AS `POR` from `mesas_estado` `a` group by `a`.`estado` union select 'TOTAL PERSONAS : ' AS `Name_exp_4`,sum(`mesas_estado`.`num_personas`) AS `SUM(NUM_PERSONAS)`,'' AS `Name_exp_6` from `mesas_estado` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_subcategorias_asignadas`
--

/*!50001 DROP VIEW IF EXISTS `vista_subcategorias_asignadas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_subcategorias_asignadas` AS select `a`.`nombre` AS `CAT`,`b`.`nombre` AS `SUBCAT` from (`productos_categorias` `a` join `productos_categorias` `b`) where ((`a`.`cat_id` = `b`.`asignado`) and (`b`.`tipo` = 'subcategoria')) order by `a`.`nombre` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_tickets_activos`
--

/*!50001 DROP VIEW IF EXISTS `vista_tickets_activos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_tickets_activos` AS select `b`.`REGISTRO_ID` AS `REGISTRO_ID`,`a`.`mesa` AS `MESA`,`a`.`orden_actual` AS `ORDEN_ACTUAL`,`b`.`PRODUCTO_ID` AS `PRODUCTO_ID`,`b`.`DETALLE` AS `DETALLE`,`b`.`CANTIDAD` AS `CANTIDAD`,`b`.`NOTAS` AS `NOTAS`,`b`.`ESTADO` AS `ESTADO`,`d`.`area` AS `AREA`,`b`.`FECHA_CREADO` AS `FECHA_CREADO` from (((`mesas_estado` `a` join `ordenes_lineas` `b`) join `productos` `c`) join `productos_comanda_cat` `d`) where ((`a`.`orden_actual` = `b`.`ORDEN_CORRELATIVOTXT`) and (`c`.`producto_id` = `b`.`PRODUCTO_ID`) and (`c`.`estado` = 'Activo') and (`c`.`categoria` = `d`.`categoria`) and (`a`.`orden_actual` <> 0) and (`b`.`DETALLE` not in ('PENDIENTE X CONSUMIR','COVER')) and (`b`.`ESTADO` in ('abierta','preparacion','despacho'))) union select `b`.`REGISTRO_ID` AS `REGISTRO_ID`,concat('LLEVAR_',`a`.`ORDEN_D`,`a`.`ORDEN_A`,`a`.`ORDEN`) AS `MESA`,concat(`a`.`ORDEN_M`,`a`.`ORDEN_D`,`a`.`ORDEN_A`,convert(lpad(`a`.`ORDEN`,6,'0') using utf8mb4)) AS `ORDEN_ACTUAL`,`b`.`PRODUCTO_ID` AS `PRODUCTO_ID`,`b`.`DETALLE` AS `DETALLE`,`b`.`CANTIDAD` AS `CANTIDAD`,`b`.`NOTAS` AS `NOTAS`,`b`.`ESTADO` AS `ESTADO`,`d`.`area` AS `AREA`,`b`.`FECHA_CREADO` AS `FECHA_CREADO` from (((`ordenes` `a` join `ordenes_lineas` `b`) join `productos` `c`) join `productos_comanda_cat` `d`) where ((concat(`a`.`ORDEN_M`,`a`.`ORDEN_D`,`a`.`ORDEN_A`,convert(lpad(`a`.`ORDEN`,6,'0') using utf8mb4)) = `b`.`ORDEN_CORRELATIVOTXT`) and (`c`.`producto_id` = `b`.`PRODUCTO_ID`) and (`c`.`estado` = 'Activo') and (`c`.`categoria` = `d`.`categoria`) and (`a`.`LLEVAR` = 'SI') and (`a`.`ESTADO` = 'abierta') and (`b`.`DETALLE` not in ('PENDIENTE X CONSUMIR','COVER')) and (`b`.`ESTADO` in ('abierta','preparacion','despacho'))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-10  4:00:00
