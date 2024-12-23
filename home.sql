-- MariaDB dump 10.19  Distrib 10.11.6-MariaDB, for debian-linux-gnu (aarch64)
--
-- Host: localhost    Database: home
-- ------------------------------------------------------
-- Server version	10.11.6-MariaDB-0+deb12u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `downSched`
--

DROP TABLE IF EXISTS `downSched`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `downSched` (
  `name` varchar(100) DEFAULT NULL,
  `endTime` int(11) DEFAULT NULL,
  `temp` tinyint(10) DEFAULT NULL,
  `id` tinyint(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `downSched`
--

LOCK TABLES `downSched` WRITE;
/*!40000 ALTER TABLE `downSched` DISABLE KEYS */;
/*!40000 ALTER TABLE `downSched` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extLog`
--

DROP TABLE IF EXISTS `extLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extLog` (
  `date` bigint(20) DEFAULT NULL,
  `temp` float(5,2) DEFAULT NULL,
  `pressure` float(5,2) DEFAULT NULL,
  `humidity` float(5,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extLog`
--

LOCK TABLES `extLog` WRITE;
/*!40000 ALTER TABLE `extLog` DISABLE KEYS */;
/*!40000 ALTER TABLE `extLog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `freq`
--

DROP TABLE IF EXISTS `freq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `freq` (
  `timestamp` bigint(20) DEFAULT NULL,
  `freq` float(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `freq`
--

LOCK TABLES `freq` WRITE;
/*!40000 ALTER TABLE `freq` DISABLE KEYS */;
/*!40000 ALTER TABLE `freq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `security`
--

DROP TABLE IF EXISTS `security`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security` (
  `name` varchar(50) DEFAULT NULL,
  `queued` int(11) DEFAULT NULL,
  `state` tinyint(5) DEFAULT NULL,
  `updated` bigint(20) DEFAULT NULL,
  `lastPic` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `security`
--

LOCK TABLES `security` WRITE;
/*!40000 ALTER TABLE `security` DISABLE KEYS */;
INSERT INTO `security` VALUES
('secPic',0,0,1642016801,'164195027361'),
('sec',1,1,1643044611,NULL),
('secEvent',0,1,1579756073,NULL);
/*!40000 ALTER TABLE `security` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `name` varchar(50) DEFAULT NULL,
  `queued` int(11) DEFAULT NULL,
  `state` tinyint(5) DEFAULT NULL,
  `updated` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES
('gDoor',0,0,1684349126),
('ceVac',1,0,NULL),
('dHeat',67,0,NULL),
('uHeat',68,0,NULL),
('alarm',800,0,NULL),
('sec',0,0,1505339293),
('secPic',0,0,1505341007);
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thermostat`
--

DROP TABLE IF EXISTS `thermostat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thermostat` (
  `id` tinyint(5) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `temp` float(5,2) DEFAULT NULL,
  `floor` tinyint(10) DEFAULT NULL,
  `override` int(10) DEFAULT NULL,
  `overrideFrom` int(10) DEFAULT NULL,
  `humi` float(5,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thermostat`
--

LOCK TABLES `thermostat` WRITE;
/*!40000 ALTER TABLE `thermostat` DISABLE KEYS */;
INSERT INTO `thermostat` VALUES
(1,'Master Bedroom',68.11,2,68,2,NULL),
(2,'Office',76.10,2,70,2,119.00),
(3,'TV Room',68.00,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `thermostat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `upSched`
--

DROP TABLE IF EXISTS `upSched`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `upSched` (
  `name` varchar(100) DEFAULT NULL,
  `endTime` int(11) DEFAULT NULL,
  `temp` tinyint(10) DEFAULT NULL,
  `id` tinyint(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `upSched`
--

LOCK TABLES `upSched` WRITE;
/*!40000 ALTER TABLE `upSched` DISABLE KEYS */;
INSERT INTO `upSched` VALUES
('morning',800,68,1),
('night',1200,68,2);
/*!40000 ALTER TABLE `upSched` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-23 12:50:24
