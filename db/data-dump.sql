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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` varchar(10) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `creditCardNumber` varchar(50) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

-- LOCK TABLES `user` WRITE;
INSERT INTO `user` VALUES ('aaaa','8a9a60a0ded26ca6e68132b039383f94e580a493c1e8e540ac18faa8ba959caf','XKQNBCOIUY','admin','George'),('bbbb','b37dfcdb9677b8c8ae9f3e0d5268afc40ac89f25757e1fab9a9d74ef3352a00a','APEOLDNFJF','user','Alphonse');
UNLOCK TABLES;


--
-- Table structure for table `support`
--

DROP TABLE IF EXISTS `support`;
CREATE TABLE `support` (
  `id` varchar(32) NOT NULL,
  `user` varchar(10) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `subject` varchar(256) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `filename` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dump completed on 2019-07-08 14:10:02
