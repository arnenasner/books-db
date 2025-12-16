-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: db_bibliography
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `secondname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `gender_id` int(1) DEFAULT NULL,
  `author_country_of_origin_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author_FK` (`author_country_of_origin_id`),
  KEY `author_FK_1` (`gender_id`),
  CONSTRAINT `author_FK` FOREIGN KEY (`author_country_of_origin_id`) REFERENCES `countries` (`id`),
  CONSTRAINT `author_FK_1` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author`
--

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` VALUES (1,'Albert',NULL,'Camus',1,3),(2,'Stephen',NULL,'King',1,4),(3,'Stieg',NULL,'Larsson',1,5),(4,'Dean',NULL,'Koontz',1,4),(5,'Kataro',NULL,'Isaka',1,6),(6,'Yukio',NULL,'Mishima',1,6),(7,'Hans',NULL,'Rosling',1,5),(8,'Peter',NULL,'Straub',1,4),(9,'Aldous',NULL,'Huxley',1,2),(10,'George ',NULL,'Orwell',1,2),(11,'Philip ','Kindred','Dick',1,4),(12,'Ray',NULL,'Dalio',1,4),(13,'Ron',NULL,'Burgundy',1,4),(14,'Richard','David','Precht',1,1),(15,'Harald',NULL,'Welzer',1,1),(16,'Fjodor','','Dostojewski',1,7),(17,'Sibyllle',NULL,'Anderl',2,1),(18,'Alexander',NULL,'Solschenizyn',1,7);
/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `german_title` varchar(100) DEFAULT NULL,
  `original_title` varchar(100) DEFAULT NULL,
  `edition` varchar(100) DEFAULT NULL,
  `page_number` smallint(5) DEFAULT NULL,
  `publishing_year` char(4) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `rating` enum('sehr gut','gut','befriedigend','ausreichend','mangelhaft','ungenügend') DEFAULT NULL,
  `genre` enum('Horror','SiFi','Thriller','Sachbuch','Geschichte','Roman','Fabel','Comedy','Fantasy') DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `author1_id` int(11) DEFAULT NULL,
  `translator_id` int(11) DEFAULT NULL,
  `translator1_id` int(11) DEFAULT NULL,
  `translator2_id` int(11) DEFAULT NULL,
  `publisher_id` int(11) DEFAULT NULL,
  `place_of_publication_id` int(11) DEFAULT NULL,
  `series_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `books_un` (`isbn`),
  KEY `books_FK` (`author_id`),
  KEY `books_FK_1` (`publisher_id`),
  KEY `books_FK_2` (`translator_id`),
  KEY `books_FK_3` (`author1_id`),
  KEY `books_FK_4` (`translator1_id`),
  KEY `books_FK_5` (`translator2_id`),
  KEY `books_FK_6` (`place_of_publication_id`),
  KEY `books_FK_7` (`series_id`),
  CONSTRAINT `books_FK` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  CONSTRAINT `books_FK_1` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`),
  CONSTRAINT `books_FK_2` FOREIGN KEY (`translator_id`) REFERENCES `translator` (`id`),
  CONSTRAINT `books_FK_3` FOREIGN KEY (`author1_id`) REFERENCES `author` (`id`),
  CONSTRAINT `books_FK_4` FOREIGN KEY (`translator1_id`) REFERENCES `translator` (`id`),
  CONSTRAINT `books_FK_5` FOREIGN KEY (`translator2_id`) REFERENCES `translator` (`id`),
  CONSTRAINT `books_FK_6` FOREIGN KEY (`place_of_publication_id`) REFERENCES `countries` (`id`),
  CONSTRAINT `books_FK_7` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'Die Pest','La Peste','2 Auflage August 2021',358,'1947','978-3-499-00616-6','gut','Roman',1,NULL,1,NULL,NULL,1,3,NULL),(2,'Schwarz','The Dark Tower: The Gunslinger','Taschenbuchausgabe 1/2000',285,'1982','3-453-16316-8','sehr gut','Fantasy',2,NULL,2,NULL,NULL,2,4,1),(3,'tot','The Dark Tower III: The Waste Lands',NULL,608,'1991','3-453-09644-4','sehr gut','Fantasy',2,NULL,2,NULL,NULL,2,4,1),(4,'drei','The Dark Tower: The Drawing Of The Three','7. Auflage',463,'1987','3-453-12385-9','sehr gut','Fantasy',2,NULL,2,NULL,NULL,2,4,1),(5,'Verblendung','Män som hatar kvinnor','28. Auflage',688,'2005','978-3-465-43245-1','gut','Thriller',3,NULL,3,NULL,NULL,2,5,NULL),(6,'Verdammnis','Flickan som lekte med elden','8. Auflage',760,'2006','978-3-453-43317-5','gut','Thriller',3,NULL,3,NULL,NULL,2,5,NULL),(7,'Vergebung','Luftslotted som sprängdes','6. Auflage',861,'2007','978-3-453-43406-6','sehr gut','Thriller',3,NULL,3,NULL,NULL,2,5,NULL),(8,'Des Teufels Saat','Demon Seed',NULL,158,'1973','3-404-00764-6','gut','SiFi',4,NULL,4,NULL,NULL,3,4,NULL),(9,'Schattenfeuer','Shadowfires','7. Auflage',477,'1978','3-453-02952-6','ausreichend','Horror',4,NULL,5,NULL,NULL,2,4,NULL),(10,'Bullet Train','Mariabitoru','1. Auflage 2022',379,'2010','978-3-455-01322-1','befriedigend','Thriller',5,NULL,6,NULL,NULL,4,6,NULL),(11,'Leben Zu Verkaufen','Inochi urimasu','Deutsche Erstausgabe 2020',238,'1968','978-3-0369-5824-8','gut','Roman',6,NULL,7,NULL,NULL,5,6,NULL),(12,'Factfulness','Factfulness','15. Auflage September 2022',393,'2018','978-3-548-06041-5','gut','Sachbuch',7,NULL,10,11,12,6,4,NULL),(13,'Der Talisman','The Talisman','3. Auflage',959,'1999','978-3-453-87760-3','gut','Horror',2,8,8,NULL,NULL,2,4,NULL),(14,'Das Schwarze Haus','Black House','2. Auflage',832,'2001','978-3-453-87370-4','sehr gut','Horror',2,8,9,NULL,NULL,2,4,NULL),(15,'Schöne Neue Welt','Brave New World','7. Auflage Januar 2018',363,'1932','978-3-596-90573-7','gut','SiFi',9,NULL,13,NULL,NULL,7,2,NULL),(16,'Farm Der Tiere','Animal Farm',NULL,141,'1945','978-3-7306-0977-4','gut','Fabel',10,NULL,14,NULL,NULL,8,2,NULL),(17,'1984','Nineteen Eighty-Four',NULL,399,'1949','978-3-7306-0976-7','sehr gut','SiFi',10,NULL,15,NULL,NULL,8,2,NULL),(18,'Blade Runner','Do Androids Dream of Electric Sheep','2. Auflage November 2019',268,'1968','978-3-596-90716-8','gut','SiFi',11,NULL,16,NULL,NULL,7,4,NULL),(19,'Weltordnung im Wandel','Principles for Dealing with the Changing World Order','2. Auflage 2022',668,'2021','978-3-959-72-407-4','befriedigend','Sachbuch',12,NULL,17,NULL,NULL,10,4,NULL),(20,NULL,'Let Me Off At The Top',NULL,223,'2013','9781780892252',NULL,'Comedy',13,NULL,NULL,NULL,NULL,9,4,NULL),(21,'Die vierte Gewalt',NULL,NULL,288,'2022','978-3-10-397507-9','gut','Sachbuch',14,15,NULL,NULL,NULL,7,1,NULL),(22,'Die Dämonen','Besy','',928,'1872','978-3-86647-864-0','gut','Roman',16,NULL,18,NULL,NULL,8,7,NULL),(23,'Dunkle Materie',NULL,NULL,128,'2022','978-3-406-78360-9','sehr gut','Sachbuch',17,NULL,NULL,NULL,NULL,11,1,NULL),(25,'Wolfsmond','The Dark Tower V: Wolves Of The Calla','Taschenbuchausgabe 12/2004',939,'2003','3-453-53023-3','gut','Fantasy',2,NULL,19,NULL,NULL,2,4,1),(26,'Susannah','The Dark Tower VI: Song Of Susannah','Taschenbuchausgabe 10/2005',494,'2003','3-453-43103-0','gut','Fantasy',2,NULL,19,NULL,NULL,2,4,1),(27,'Der Turm','The Dark Tower VII: The Dark Tower','Taschenbuchausgabe 04/2006',1009,'2004','3-453-43161-8','gut','Fantasy',2,NULL,19,NULL,NULL,2,4,1),(28,'Glas','Wizard And Glass','Taschenbuchausgabe 01/2000',893,'1997','3-453-16318-4','sehr gut','Fantasy',2,NULL,2,NULL,NULL,2,4,1),(29,'Der Archipel Gulag 1',NULL,'8.  Auflage November 2022',581,'1973','978-3-596-18424-8',NULL,'Geschichte',18,NULL,20,NULL,NULL,7,3,2),(30,'Der Archipel Gulag 2',NULL,'6. Auflage Januar 2022',634,'1973','978-3-596-18425-5',NULL,'Geschichte',18,NULL,20,21,NULL,7,3,2),(31,'Der Archipel Gulag 3',NULL,'6. Auflage April 2021',550,'1973','978-596-18426-2',NULL,'Geschichte',18,NULL,20,21,NULL,7,3,2);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Deutschland'),(2,'England'),(3,'Frankreich'),(4,'USA'),(5,'Schweden'),(6,'Japan'),(7,'Russland');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gender`
--

DROP TABLE IF EXISTS `gender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gender`
--

LOCK TABLES `gender` WRITE;
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` VALUES (1,'m'),(2,'w');
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publisher`
--

DROP TABLE IF EXISTS `publisher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publisher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publisher`
--

LOCK TABLES `publisher` WRITE;
/*!40000 ALTER TABLE `publisher` DISABLE KEYS */;
INSERT INTO `publisher` VALUES (1,'Rowohlt Taschenbuch Verlag'),(2,'Wilhelm Heyne Verlag München'),(3,'Bastei-Verlag Gustav H. Lübbe'),(4,'Hoffman und Campe'),(5,'Kein & Aber'),(6,'Ullstein Buchverlage GmbH'),(7,'Fischer'),(8,'Anaconda'),(9,'Century'),(10,'FBV'),(11,'C.H. Beck ');
/*!40000 ALTER TABLE `publisher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `series`
--

DROP TABLE IF EXISTS `series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `series` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `series_german` varchar(100) DEFAULT NULL,
  `series_original` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `series`
--

LOCK TABLES `series` WRITE;
/*!40000 ALTER TABLE `series` DISABLE KEYS */;
INSERT INTO `series` VALUES (1,'Der Dunkle Turm','The Dark Tower'),(2,'Der Archipel Gulag',NULL);
/*!40000 ALTER TABLE `series` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translator`
--

DROP TABLE IF EXISTS `translator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `translator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `translator_country_of_origin_id` int(11) DEFAULT NULL,
  `gender_id` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `translator_FK` (`translator_country_of_origin_id`),
  KEY `translator_FK_1` (`gender_id`),
  CONSTRAINT `translator_FK` FOREIGN KEY (`translator_country_of_origin_id`) REFERENCES `countries` (`id`),
  CONSTRAINT `translator_FK_1` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translator`
--

LOCK TABLES `translator` WRITE;
/*!40000 ALTER TABLE `translator` DISABLE KEYS */;
INSERT INTO `translator` VALUES (1,'Uli','Aumüller',1,2),(2,'Joachim','Körber',1,1),(3,'Wibke','Kuhn',1,2),(4,'Peter','Pape',1,1),(5,'Andreas','Brandhorst',1,1),(6,'Katja','Busson',1,2),(7,'Nora','Bierich',1,2),(8,'Christel','Wiemken',1,2),(9,'Wulf','Bergner',1,1),(10,'Hans','Freundl',1,1),(11,'Hans-Peter','Remmler',1,1),(12,'Albrecht','Schreiber',1,1),(13,'Uda','Strätling',1,2),(14,'Heike ','Holtsch',1,2),(15,'Jan','Strümpel',1,1),(16,'Manfred','Allié',1,1),(17,'Petra','Pyka',1,2),(18,'Hermann','Röhl',1,1),(19,'Wulf','Bergner',1,1),(20,'Anna ','Peturnig',1,2),(21,'Ernst','Walter',1,1);
/*!40000 ALTER TABLE `translator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin@buch.de','Putt','Volker','$2y$10$KegZxB68CJQqZku8ONp3muBN5u9b6knn/TpvnK5mpthAYSfNioF.y','2024-02-08 12:52:17');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'db_bibliography'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-08 15:25:32
