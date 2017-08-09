-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: landdrupdans
-- ------------------------------------------------------
-- Server version	5.6.24

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
-- Table structure for table `agegroups`
--

DROP TABLE IF EXISTS `agegroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agegroups` (
  `ageGrpId` int(11) NOT NULL AUTO_INCREMENT,
  `ageGrpName` varchar(15) NOT NULL,
  PRIMARY KEY (`ageGrpId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agegroups`
--

LOCK TABLES `agegroups` WRITE;
/*!40000 ALTER TABLE `agegroups` DISABLE KEYS */;
INSERT INTO `agegroups` VALUES (3,'Voksne'),(4,'Senior'),(5,'3-5 år '),(6,'6-8 år '),(7,' 9-14 år '),(8,'15-18 år ');
/*!40000 ALTER TABLE `agegroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructors`
--

DROP TABLE IF EXISTS `instructors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructors` (
  `insId` int(11) NOT NULL AUTO_INCREMENT,
  `insDescription` text NOT NULL,
  `fkUser` int(11) NOT NULL,
  `fkPicture` int(11) DEFAULT NULL,
  PRIMARY KEY (`insId`),
  KEY `fkUserDetail_idx` (`fkUser`),
  KEY `fkPicture_idx` (`fkPicture`),
  CONSTRAINT `fkPicture` FOREIGN KEY (`fkPicture`) REFERENCES `media` (`mediaId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkUser` FOREIGN KEY (`fkUser`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructors`
--

LOCK TABLES `instructors` WRITE;
/*!40000 ALTER TABLE `instructors` DISABLE KEYS */;
INSERT INTO `instructors` VALUES (19,'Dette er en test',12,23);
/*!40000 ALTER TABLE `instructors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `levels`
--

DROP TABLE IF EXISTS `levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `levels` (
  `levelId` int(11) NOT NULL AUTO_INCREMENT,
  `levelName` varchar(10) NOT NULL,
  PRIMARY KEY (`levelId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `levels`
--

LOCK TABLES `levels` WRITE;
/*!40000 ALTER TABLE `levels` DISABLE KEYS */;
INSERT INTO `levels` VALUES (1,'Begynder'),(2,'Øvet'),(3,'Elite');
/*!40000 ALTER TABLE `levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `mediaId` int(11) NOT NULL AUTO_INCREMENT,
  `filePath` varchar(255) NOT NULL,
  `mediaType` varchar(90) NOT NULL,
  PRIMARY KEY (`mediaId`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,'1495542860_Asset 9.png','image/png'),(2,'slide1.jpg','image/jpg'),(11,'1496144111_14285731_10210710275215966_1931852580_o.jpg','image/jpeg'),(12,'1496144355_14407966_10210710274415946_1959970432_o.jpg','image/jpeg'),(13,'1496146924_14456654_10210710275255967_731082206_o.jpg','image/jpeg'),(14,'1496147101_14798776_10210982926432076_692545190_n.jpg','image/jpeg'),(15,'1496148344_14285731_10210710275215966_1931852580_o.jpg','image/jpeg'),(16,'1496211436_14446467_10210710274615951_543779710_o.jpg','image/jpeg'),(17,'1496212190_15416000_10211559312361364_1640855836_n.jpg','image/jpeg'),(18,'1496212261_14801239_10210982926512078_843849156_n.jpg','image/jpeg'),(19,'1496225391_14801239_10210982926512078_843849156_n.jpg','image/jpeg'),(20,'1496226656_slide1.jpg','image/jpeg'),(21,'1496233024_slide1.jpg','image/jpeg'),(23,'1496318087_55077575.jpg','image/jpeg');
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `pageId` int(11) NOT NULL AUTO_INCREMENT,
  `pageText` text NOT NULL,
  `pageTitle` varchar(30) NOT NULL,
  `pagePicture` int(11) DEFAULT NULL,
  `pageUrl` varchar(45) NOT NULL,
  PRIMARY KEY (`pageId`),
  KEY `fkPagePicture_idx` (`pagePicture`),
  CONSTRAINT `fkPagePicture` FOREIGN KEY (`pagePicture`) REFERENCES `media` (`mediaId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod rem natus earum, tenetur consectetur cupiditate optio aliquid repellendus, minima necessitatibus similique iste, sunt delectus nostrum qui in commodi ea dolor.','Landdrup danseskole',21,'home');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participants` (
  `pId` int(11) NOT NULL AUTO_INCREMENT,
  `fkTeam` int(11) NOT NULL,
  `fkUser` int(11) NOT NULL,
  PRIMARY KEY (`pId`),
  KEY `fkTeam_idx` (`fkTeam`),
  KEY `fkUser_idx` (`fkUser`),
  CONSTRAINT `fkTeamId` FOREIGN KEY (`fkTeam`) REFERENCES `teams` (`teamId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkUserId` FOREIGN KEY (`fkUser`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participants`
--

LOCK TABLES `participants` WRITE;
/*!40000 ALTER TABLE `participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliderpictures`
--

DROP TABLE IF EXISTS `sliderpictures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sliderpictures` (
  `slideId` int(11) NOT NULL AUTO_INCREMENT,
  `picturePath` varchar(128) NOT NULL,
  `slidePosition` tinyint(2) NOT NULL,
  `slideGrp` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`slideId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliderpictures`
--

LOCK TABLES `sliderpictures` WRITE;
/*!40000 ALTER TABLE `sliderpictures` DISABLE KEYS */;
/*!40000 ALTER TABLE `sliderpictures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `styles`
--

DROP TABLE IF EXISTS `styles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `styles` (
  `stylesId` int(11) NOT NULL AUTO_INCREMENT,
  `stylesName` varchar(25) NOT NULL,
  `stylesDescription` text NOT NULL,
  `stylesPicture` int(11) DEFAULT NULL,
  PRIMARY KEY (`stylesId`),
  UNIQUE KEY `stylesName_UNIQUE` (`stylesName`),
  KEY `fkStylePicture_idx` (`stylesPicture`),
  CONSTRAINT `fkStylePicture` FOREIGN KEY (`stylesPicture`) REFERENCES `media` (`mediaId`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `styles`
--

LOCK TABLES `styles` WRITE;
/*!40000 ALTER TABLE `styles` DISABLE KEYS */;
INSERT INTO `styles` VALUES (1,'Hip-Hop','Hippie hop',NULL),(2,'Breakdance','Break med dans',NULL),(3,'Disko','Dasko',NULL),(4,'Funk','Funky',NULL),(5,'House','in the',NULL);
/*!40000 ALTER TABLE `styles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `teamId` int(11) NOT NULL AUTO_INCREMENT,
  `teamName` varchar(12) NOT NULL,
  `fkStyle` int(11) DEFAULT NULL,
  `fkAgeGrp` int(11) DEFAULT NULL,
  `fkLevel` int(11) DEFAULT NULL,
  `fkInstructor` int(11) DEFAULT NULL,
  `teamPrice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`teamId`),
  UNIQUE KEY `teamName_UNIQUE` (`teamName`),
  KEY `fkInstructor_idx` (`fkInstructor`),
  KEY `fkStyle_idx` (`fkStyle`),
  KEY `fkAgeGrp_idx` (`fkAgeGrp`),
  KEY `fkLevel_idx` (`fkLevel`),
  CONSTRAINT `fkAgeGrp` FOREIGN KEY (`fkAgeGrp`) REFERENCES `agegroups` (`ageGrpId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkInstructor` FOREIGN KEY (`fkInstructor`) REFERENCES `instructors` (`insId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkLevel` FOREIGN KEY (`fkLevel`) REFERENCES `levels` (`levelId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkStyle` FOREIGN KEY (`fkStyle`) REFERENCES `styles` (`stylesId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (3,'42a',1,8,3,19,800.00);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userprofile`
--

DROP TABLE IF EXISTS `userprofile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userprofile` (
  `profileId` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `birthdate` date NOT NULL,
  `street` varchar(68) NOT NULL,
  `zipcode` int(5) NOT NULL,
  `city` varchar(25) NOT NULL,
  `phone` int(8) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`profileId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userprofile`
--

LOCK TABLES `userprofile` WRITE;
/*!40000 ALTER TABLE `userprofile` DISABLE KEYS */;
INSERT INTO `userprofile` VALUES (1,'System','Admin','2017-05-31','Asweome 666',4000,'Roskilde',66666688,'2017-05-18 15:50:41'),(2,'test','test','0000-00-00','testervej 12',4000,'Roskilde',42205055,'2017-05-19 12:21:21'),(8,'awesome','test','2017-05-24','testervej 12',4000,'Roskilde',88888888,'2017-05-22 10:47:03'),(10,'Awesome','Test','2002-05-09','testervej 12',4000,'Roskilde',12345678,'2017-05-24 08:43:02'),(11,'mr','test','2017-05-29','testervej 12',4000,'Roskilde',55667788,'2017-05-24 09:28:10'),(12,'mr','test','2003-05-09','testervej 12',4000,'Roskilde',55664477,'2017-05-24 11:48:35');
/*!40000 ALTER TABLE `userprofile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userroles`
--

DROP TABLE IF EXISTS `userroles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userroles` (
  `roleId` int(11) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(15) NOT NULL,
  `roleLevel` tinyint(2) NOT NULL,
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userroles`
--

LOCK TABLES `userroles` WRITE;
/*!40000 ALTER TABLE `userroles` DISABLE KEYS */;
INSERT INTO `userroles` VALUES (1,'Super Admin',99),(2,'Administartor',90),(3,'Medarbejder',50),(4,'Kunde',30);
/*!40000 ALTER TABLE `userroles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userEmail` varchar(128) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `fkProfile` int(11) DEFAULT NULL,
  `fkRole` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userEmail_UNIQUE` (`userEmail`),
  KEY `fkRole_idx` (`fkRole`),
  KEY `fkDetail_idx` (`fkProfile`),
  CONSTRAINT `fkProfile` FOREIGN KEY (`fkProfile`) REFERENCES `userprofile` (`profileId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fkRole` FOREIGN KEY (`fkRole`) REFERENCES `userroles` (`roleId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@admin.dk','$2y$12$Em7m9c0x09tcmR9X/EcKrO41C5S5X1dMPf8Ba.sJeT9FMZ.BSnSRS',1,1),(2,'test@test.dk','$2y$12$FqWZnbHpfdPUaaphk3CuyOcT8yhpQCH7msZtV88x2ADqVPhDHcIBq',2,4),(8,'awesome@test.dk','$2y$12$BavAzOXjlUgEK8lbFC16WeAGCrogNCLX0tG/r7wO1qkpjWlCvmOPq',8,3),(11,'mr@test.net','$2y$12$UU4Yrc3VH1cvk3YuiLiwx.3Z9DBTmC2eRteMuOA5eJvNyb4yUPUN6',11,4),(12,'mere@test.nu','$2y$12$44PihOCYRss4VxFsNI8wdeguemvebZmNMcrUtVKpw2nqnkBkh3vgS',12,2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 13:06:46
