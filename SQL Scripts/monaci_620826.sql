-- Progettazione Web 
DROP DATABASE if exists monaci_620826; 
CREATE DATABASE monaci_620826; 
USE monaci_620826; 
-- MySQL dump 10.13  Distrib 5.7.28, for Win64 (x86_64)
--
-- Host: localhost    Database: monaci_620826
-- ------------------------------------------------------
-- Server version	8.0.23

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
-- Table structure for table `archiviomoto`
--

DROP TABLE IF EXISTS `archiviomoto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archiviomoto` (
  `marca` varchar(100) NOT NULL,
  `modello` varchar(100) NOT NULL,
  `cilindrata` int NOT NULL,
  PRIMARY KEY (`marca`,`modello`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archiviomoto`
--

LOCK TABLES `archiviomoto` WRITE;
/*!40000 ALTER TABLE `archiviomoto` DISABLE KEYS */;
INSERT INTO `archiviomoto` VALUES ('Aprilia','Dorsoduro 900',900),('Aprilia','RS 125',125),('Aprilia','RS 250',250),('Aprilia','RS 660',600),('Aprilia','RS V4',1000),('Aprilia','Tuono 660',600),('Aprilia','Tuono V4',1000),('Benelli','302 R',300),('Benelli','302 S',300),('Benelli','BN 600 R',600),('Benelli','TNT 1130',1000),('BMW','HP4',1000),('BMW','S1000 R',1000),('BMW','S1000 RR',1000),('Ducati','1098',1000),('Ducati','1198',1000),('Ducati','748',750),('Ducati','848',900),('Ducati','999',1000),('Ducati','Panigale 1099',1000),('Ducati','Panigale 1199',1000),('Ducati','Panigale 899',900),('Ducati','Panigale 959',1000),('Ducati','Panigale V2',1000),('Ducati','Panigale V4',1000),('Ducati','Panigale V4R',1000),('Ducati','Streetfighter V4',1000),('Guzzi','Griso 1100',1000),('Guzzi','Griso 850',900),('Honda','CB 1000 R',1000),('Honda','CB 600',600),('Honda','CBR 1000 RR',1000),('Honda','CBR 300 RR',300),('Honda','CBR 600 RR',600),('Husqvarna','Nuda 900',900),('Kawasaki','Ninja 300',300),('Kawasaki','Z1000',1000),('Kawasaki','Z900',900),('Kawasaki','ZX10R',1000),('Kawasaki','ZX6R',600),('KTM','Duke 390',300),('KTM','Duke 790',900),('KTM','Duke 890R',900),('KTM','RC 390',300),('KTM','RC 8 C',900),('KTM','Superduke 1299 R',1000),('MV Agusta','Brutale 675',600),('MV Agusta','Brutale 800',900),('MV Agusta','F3 675',600),('MV Agusta','F3 800',800),('MV Agusta','F4 1000',1000),('Suzuki','GSXR 1000',1000),('Suzuki','GSXR 600',600),('Triumph','Daytona 675R',600),('Triumph','Speed Triple RS 1200',1000),('Yamaha','MT07',600),('Yamaha','MT09',900),('Yamaha','MT10',1000),('Yamaha','R1',1000),('Yamaha','R3',300),('Yamaha','R6',600);
/*!40000 ALTER TABLE `archiviomoto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `circuito`
--

DROP TABLE IF EXISTS `circuito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `circuito` (
  `nome` varchar(100) NOT NULL,
  `localita` varchar(255) NOT NULL,
  `lunghezza` float NOT NULL,
  `urlsito` varchar(255) NOT NULL,
  `urlmaps` varchar(255) NOT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `circuito`
--

LOCK TABLES `circuito` WRITE;
/*!40000 ALTER TABLE `circuito` DISABLE KEYS */;
INSERT INTO `circuito` VALUES ('Autodromo del Levante','Bari BA',1577,'https://www.levantecircuit.com/','https://goo.gl/maps/SKgWQjfL3c3AMmoM9'),('Autodromo dell\'Umbria','Magione PG',2507,'https://www.autodromomagione.com/','https://goo.gl/maps/cymoYrFPRtsSogfAA'),('Autodromo di Imola','Imola BO',4936,'https://www.autodromoimola.it/','https://goo.gl/maps/kwzzqzb9XB3g13tQ6'),('Autodromo Nazionale Gianni de Luca','Benevento BN',1400,'http://www.autodromogiannideluca.it/sito/','https://goo.gl/maps/mf3JhdDoH8ntCpPq5'),('Autodromo Vallelunga','Campagnano di Roma RM',4085,'https://vallelunga.it/','https://goo.gl/maps/Fhptph5T9Ddeux536'),('Circuito Tazio Nuvolari Cervesina','Pavia PV',2804,'https://www.circuitotazionuvolari.it/','https://goo.gl/maps/q7GJftJH9meBJq4u8'),('Cremona Circuit','Cremona CR',3702,'https://cremonacircuit.it/it/','https://goo.gl/maps/QC8d8f3Edjza8tSSA'),('Misano World Circuit','Misano sull\'Adriatico RN',4226,'https://www.misanocircuit.com/','https://goo.gl/maps/YAfTMPTrckiP86S99'),('Motodromo Castelletto di Branduzzo','Pavia PV',1900,'https://www.motodromo.it/','https://goo.gl/maps/PtTXet24bGAnFXmD9'),('Mugello Circuit','Barberino del Mugello FI',5245,'https://www.mugellocircuit.com/it/','https://goo.gl/maps/f1JYEAZLLqs4LUnr8');
/*!40000 ALTER TABLE `circuito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tempo`
--

DROP TABLE IF EXISTS `tempo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tempo` (
  `id_tempo` int NOT NULL AUTO_INCREMENT,
  `pilota` varchar(100) NOT NULL,
  `moto` varchar(100) NOT NULL,
  `circuito` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `t_lap` int NOT NULL,
  `t_s1` int NOT NULL,
  `t_s2` int NOT NULL,
  `t_s3` int NOT NULL,
  `t_s4` int NOT NULL,
  PRIMARY KEY (`id_tempo`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tempo`
--

LOCK TABLES `tempo` WRITE;
/*!40000 ALTER TABLE `tempo` DISABLE KEYS */;
INSERT INTO `tempo` VALUES (1,'Lorenzo11','Yamaha R6','Autodromo Vallelunga','2022-12-11',115980,43420,24608,27707,20245),(2,'Mario22','Yamaha R6','Autodromo Vallelunga','2022-02-11',124332,44420,25264,33957,20691),(3,'Luigi33','Yamaha R6','Autodromo Vallelunga','2022-12-11',110914,34823,28367,29503,18221),(4,'toad44','Yamaha R1','Autodromo Vallelunga','2021-10-11',118373,43212,25871,28836,20454),(5,'Lorenzo11','Yamaha R6','Mugello Circuit','2020-12-11',114461,26809,37810,17885,31957),(6,'Mario22','Yamaha R6','Mugello Circuit','2020-12-11',131369,31460,42549,15597,41763),(7,'Luigi33','Yamaha R6','Mugello Circuit','2020-12-11',118443,36224,35121,14693,32405),(8,'toad44','Yamaha R1','Mugello Circuit','2019-07-11',120538,30864,40820,15740,33114),(9,'Lorenzo11','Yamaha R3','Autodromo dell\'Umbria','2021-02-10',90246,21876,11603,23788,32979),(10,'Mario22','Yamaha R3','Autodromo dell\'Umbria','2022-04-21',87216,21507,12485,21641,31583),(11,'Luigi33','Yamaha R3','Autodromo dell\'Umbria','2022-04-21',87484,23501,11858,19757,32368),(12,'toad44','Yamaha R3','Autodromo dell\'Umbria','2022-04-21',97006,25430,11487,21237,38852),(13,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',114281,39570,24879,27170,22662),(14,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',115157,37395,28865,32000,16897),(15,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',125177,40951,32968,33591,17667),(16,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',107508,34852,25828,27217,19611),(17,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',110696,33809,28600,28248,20039),(18,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',115618,42367,26996,29340,16915),(19,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',115847,43549,25991,27752,18555),(20,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',111569,32667,24720,34446,19736),(21,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',115678,42456,24849,28634,19739),(22,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',130872,46190,28131,34232,22319),(23,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',122014,34786,31110,33327,22791),(24,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',119303,40562,33561,26216,18964),(25,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',114490,35011,29246,29768,20465),(26,'Lorenzo11','Benelli 302 R','Autodromo Vallelunga','2023-01-17',121788,41096,29631,30779,20282),(27,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',50592,14173,19803,9070,7546),(28,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',50633,11953,20862,10265,7553),(29,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',56289,13145,22868,11980,8296),(30,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',52531,15105,19886,10465,7075),(31,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',57743,14136,24022,11428,8157),(32,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',51395,12087,20257,11538,7513),(33,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',54421,13568,22768,11370,6715),(34,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',53156,11238,24223,9273,8422),(35,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',54306,12045,23648,9870,8743),(36,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',48130,12748,18776,9802,6804),(37,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',53097,12217,23340,9950,7590),(38,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',46603,11081,17806,9908,7808),(39,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',49496,11815,19538,9703,8440),(40,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',50431,11342,19898,11221,7970),(41,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',50749,15470,19294,9139,6846),(42,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',55048,15226,21195,11867,6760),(43,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',55642,12055,22592,12182,8813),(44,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',48387,14137,17610,9043,7597),(45,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',54303,11792,22606,11539,8366),(46,'Lorenzo11','Aprilia Tuono V4','Autodromo Nazionale Gianni de Luca','2023-01-17',57520,13593,23460,11789,8678);
/*!40000 ALTER TABLE `tempo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utente`
--

DROP TABLE IF EXISTS `utente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utente` (
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `domanda` varchar(255) NOT NULL,
  `risposta` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utente`
--

LOCK TABLES `utente` WRITE;
/*!40000 ALTER TABLE `utente` DISABLE KEYS */;
INSERT INTO `utente` VALUES ('Lorenzo11','$2y$10$0zWcEV56xoXuvcIVPxhcg.qgUDPd4akHX.HuFjqnMEBqvuapKH8RS','lorenzo.mail@example.it','Qual\' è il tuo colore preferito?','rosso'),('Luigi33','$2y$10$KSW.MEK1hzdZJAOOmRGUueM6Ux6ZI2xLHvMaqReoyF4z/3CLqsDKa','verdi.luigi@example.it','Qual\' è il nome del tuo amico immaginario da bambino?','gianni'),('Mario22','$2y$10$BD6JsHZPefBCE/y0GoXCHeM6LF/bhqxQvQOso7Lo4JgX7Idl524eK','rossi.mario@example.it','Qual\' è il primo esame che hai passato?','analisi'),('Toad44','$2y$10$rvYLv1qo/.Fo75pVBaySKeAuGhp30LPJHdo/zRIFa1zLIFL.Rcfli','gialli.toad@example.it','Qual\' è il nome del tuo amico immaginario da bambino?','mario');
/*!40000 ALTER TABLE `utente` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-18 11:15:25
