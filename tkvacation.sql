-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: localhost    Database: tkvacation
-- ------------------------------------------------------
-- Server version	5.7.16-log

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
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `destinations` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `img` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destinations`
--

LOCK TABLES `destinations` WRITE;
/*!40000 ALTER TABLE `destinations` DISABLE KEYS */;
INSERT INTO `destinations` VALUES (1,'img/destination_1.jpg','Ha Long'),(2,'img/destination_2.jpg','Nha Trang'),(3,'img/destination_3.jpg','Da Nang'),(4,'img/destination_4.jpg','Hoi An'),(5,'img/destination_5.jpg','Sa Pa');
/*!40000 ALTER TABLE `destinations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tours`
--

DROP TABLE IF EXISTS `tours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `period` varchar(45) NOT NULL,
  `availability` varchar(45) DEFAULT NULL,
  `overview` text,
  `price` decimal(10,2) DEFAULT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `booking` int(11) DEFAULT '0',
  `price_vnd` decimal(10,2) DEFAULT NULL,
  `img` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_TOUR_DES_idx` (`destination_id`),
  CONSTRAINT `FK_TOURS_DES` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tours`
--

LOCK TABLES `tours` WRITE;
/*!40000 ALTER TABLE `tours` DISABLE KEYS */;
INSERT INTO `tours` VALUES (1,'Mekong 1 day, Cai Lay','1 Day','2 Days','Enjoy full day at the local house and join their activities, a wish of so many people live at the busy city such at Saigon. This is a beautiful destination with less tourist.',200.00,1,0,5200000.00,'img/tour_1.jpg'),(2,'City full day','1 Day','1 Day','You will explore Saigon in deep 1 full day. Enjoy walking around the Chinese market and the park, have a talk with the guide at the local coffee shop.',100.00,1,0,2000000.00,'img/tour_2.jpg'),(4,'Ha Long','3213','eqwe','ded',100.00,2,0,NULL,NULL);
/*!40000 ALTER TABLE `tours` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02  0:14:03
