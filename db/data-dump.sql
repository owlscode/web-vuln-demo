-- MariaDB dump 10.17  Distrib 10.4.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: BddForInjection
-- ------------------------------------------------------
-- Server version	10.4.6-MariaDB-1:10.4.6+maria~bionic

--
-- Current Database: `BddForInjection`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `WebHole` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `WebHole`;

--
-- Table structure for table `Utilisateur`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` char(10) DEFAULT NULL,
  `password` char(50) DEFAULT NULL,
  `creditCardNumber` char(50) DEFAULT NULL,
  `role` char(10) DEFAULT NULL,
  `firstname` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Utilisateur`
--

LOCK TABLES `user` WRITE;
INSERT INTO `user` VALUES ('aaaa','aafdc23870ecbcd3d557b6423a8982134e17927e','XKQNBCOIUY','admin','George'),('bbbb','abcdefg','APEOLDNFJF','user','Alphonse');
UNLOCK TABLES;

-- Dump completed on 2019-07-08 14:10:02
