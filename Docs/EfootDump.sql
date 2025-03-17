-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: efoot
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `role` varchar(10) NOT NULL,
  `num_telephone` int DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `profile_path` varchar(200) DEFAULT NULL,
  `password` varchar(300) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buts`
--

DROP TABLE IF EXISTS `buts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `match_id` int DEFAULT NULL,
  `buteur_id` int DEFAULT NULL,
  `assisteur_id` int DEFAULT NULL,
  `minute` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_match_buts` (`match_id`),
  KEY `fk_buteur_buts` (`buteur_id`),
  KEY `fk_assisteur_buts` (`assisteur_id`),
  CONSTRAINT `fk_assisteur_buts` FOREIGN KEY (`assisteur_id`) REFERENCES `joueurs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_buteur_buts` FOREIGN KEY (`buteur_id`) REFERENCES `joueurs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_match_buts` FOREIGN KEY (`match_id`) REFERENCES `matchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buts`
--

LOCK TABLES `buts` WRITE;
/*!40000 ALTER TABLE `buts` DISABLE KEYS */;
/*!40000 ALTER TABLE `buts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;


/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `match_id` int DEFAULT NULL,
  `joueur_id` int DEFAULT NULL,
  `type` char(1) NOT NULL,
  `minute` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_match_carts` (`match_id`),
  KEY `fk_joueur_carts` (`joueur_id`),
  CONSTRAINT `fk_joueur_carts` FOREIGN KEY (`joueur_id`) REFERENCES `joueurs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_match_carts` FOREIGN KEY (`match_id`) REFERENCES `matchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `changements`
--

DROP TABLE IF EXISTS `changements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `changements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `match_id` int DEFAULT NULL,
  `joueur_id` int DEFAULT NULL,
  `remplacant_id` int DEFAULT NULL,
  `minute` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_match_changements` (`match_id`),
  KEY `fk_joueur_changements` (`joueur_id`),
  KEY `fk_remplacant_changements` (`remplacant_id`),
  CONSTRAINT `fk_joueur_changements` FOREIGN KEY (`joueur_id`) REFERENCES `joueurs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_match_changements` FOREIGN KEY (`match_id`) REFERENCES `matchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_remplacant_changements` FOREIGN KEY (`remplacant_id`) REFERENCES `joueurs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `changements`
--

LOCK TABLES `changements` WRITE;
/*!40000 ALTER TABLE `changements` DISABLE KEYS */;
/*!40000 ALTER TABLE `changements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `text` varchar(500) NOT NULL,
  `user_id` int DEFAULT NULL,
  `match_id` int DEFAULT NULL,
  `replied_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_comment` (`user_id`),
  KEY `fk_match_comment` (`match_id`),
  CONSTRAINT `fk_match_comment` FOREIGN KEY (`match_id`) REFERENCES `matchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_user_comment` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipes`
--

DROP TABLE IF EXISTS `equipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `nickname` varchar(10) NOT NULL,
  `logo_path` varchar(200) DEFAULT NULL,
  `entraineur_id` int DEFAULT NULL,
  `stad_id` int DEFAULT NULL,
  `created_at` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_staff_equipes` (`entraineur_id`),
  KEY `fk_stad_equipes` (`stad_id`),
  CONSTRAINT `fk_stad_equipes` FOREIGN KEY (`stad_id`) REFERENCES `stads` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_equipes` FOREIGN KEY (`entraineur_id`) REFERENCES `staffs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipes`
--

LOCK TABLES `equipes` WRITE;
/*!40000 ALTER TABLE `equipes` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipes_joueurs`
--

DROP TABLE IF EXISTS `equipes_joueurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipes_joueurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `equipe_id` int DEFAULT NULL,
  `joueur_id` int DEFAULT NULL,
  `started_at` date NOT NULL,
  `end_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_equipe_equipe_joueurs` (`equipe_id`),
  KEY `fk_joueur_equipe_joueurs` (`joueur_id`),
  CONSTRAINT `fk_equipe_equipe_joueurs` FOREIGN KEY (`equipe_id`) REFERENCES `equipes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_joueur_equipe_joueurs` FOREIGN KEY (`joueur_id`) REFERENCES `joueurs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipes_joueurs`
--

LOCK TABLES `equipes_joueurs` WRITE;
/*!40000 ALTER TABLE `equipes_joueurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipes_joueurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `joueurs`
--

DROP TABLE IF EXISTS `joueurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joueurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `date_naissance` date NOT NULL,
  `poid` decimal(4,2) DEFAULT NULL,
  `taill` decimal(5,2) DEFAULT NULL,
  `pied` char(1) DEFAULT NULL,
  `photo_path` varchar(200) DEFAULT NULL,
  `nationalite_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pays_joueur` (`nationalite_id`),
  CONSTRAINT `fk_pays_joueur` FOREIGN KEY (`nationalite_id`) REFERENCES `pays` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joueurs`
--

LOCK TABLES `joueurs` WRITE;
/*!40000 ALTER TABLE `joueurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `joueurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lignups`
--

DROP TABLE IF EXISTS `lignups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lignups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `match_id` int DEFAULT NULL,
  `equipe_id` int DEFAULT NULL,
  `joeur_id` int DEFAULT NULL,
  `position_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_match_lignup` (`match_id`),
  KEY `fk_equipe_lignup` (`equipe_id`),
  KEY `fk_joeur_lignup` (`joeur_id`),
  KEY `fk_position_lignup` (`position_id`),
  CONSTRAINT `fk_equipe_lignup` FOREIGN KEY (`equipe_id`) REFERENCES `equipes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_joeur_lignup` FOREIGN KEY (`joeur_id`) REFERENCES `joueurs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_match_lignup` FOREIGN KEY (`match_id`) REFERENCES `matchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_position_lignup` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lignups`
--

LOCK TABLES `lignups` WRITE;
/*!40000 ALTER TABLE `lignups` DISABLE KEYS */;
/*!40000 ALTER TABLE `lignups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match_arbitres`
--

DROP TABLE IF EXISTS `match_arbitres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `match_arbitres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `match_id` int DEFAULT NULL,
  `arbitre_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_match_arbitres_match` (`match_id`),
  KEY `fk_arbitre_arbitres_match` (`arbitre_id`),
  CONSTRAINT `fk_arbitre_arbitres_match` FOREIGN KEY (`arbitre_id`) REFERENCES `staffs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_match_arbitres_match` FOREIGN KEY (`match_id`) REFERENCES `matchs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_arbitres`
--

LOCK TABLES `match_arbitres` WRITE;
/*!40000 ALTER TABLE `match_arbitres` DISABLE KEYS */;
/*!40000 ALTER TABLE `match_arbitres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matchs`
--

DROP TABLE IF EXISTS `matchs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `matchs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tournoie_id` int DEFAULT NULL,
  `equipe1_id` int DEFAULT NULL,
  `equipe2_id` int DEFAULT NULL,
  `jour_match` date DEFAULT NULL,
  `played_time` datetime DEFAULT NULL,
  `stad_id` int DEFAULT NULL,
  `round` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tournoie_match` (`tournoie_id`),
  KEY `fk_equipe1_match` (`equipe1_id`),
  KEY `fk_equipe2_match` (`equipe2_id`),
  KEY `fk_stad_match` (`stad_id`),
  CONSTRAINT `fk_equipe1_match` FOREIGN KEY (`equipe1_id`) REFERENCES `equipes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_equipe2_match` FOREIGN KEY (`equipe2_id`) REFERENCES `equipes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_stad_match` FOREIGN KEY (`stad_id`) REFERENCES `stads` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_tournoie_match` FOREIGN KEY (`tournoie_id`) REFERENCES `tournoies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matchs`
--

LOCK TABLES `matchs` WRITE;
/*!40000 ALTER TABLE `matchs` DISABLE KEYS */;
/*!40000 ALTER TABLE `matchs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pays`
--

DROP TABLE IF EXISTS `pays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pays` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nationalite` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pays`
--

LOCK TABLES `pays` WRITE;
/*!40000 ALTER TABLE `pays` DISABLE KEYS */;
/*!40000 ALTER TABLE `pays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penalties`
--

DROP TABLE IF EXISTS `penalties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penalties` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `penalty` char(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_penalty` (`user_id`),
  KEY `fk_admin_penalty` (`admin_id`),
  CONSTRAINT `fk_admin_penalty` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_user_penalty` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penalties`
--

LOCK TABLES `penalties` WRITE;
/*!40000 ALTER TABLE `penalties` DISABLE KEYS */;
/*!40000 ALTER TABLE `penalties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `positions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `position` varchar(3) NOT NULL,
  `position_full_name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reporter_id` int DEFAULT NULL,
  `reported_id` int DEFAULT NULL,
  `etat` char(2) NOT NULL DEFAULT 'US',
  PRIMARY KEY (`id`),
  KEY `fk_reporter_report` (`reporter_id`),
  KEY `fk_reported_report` (`reported_id`),
  CONSTRAINT `fk_reported_report` FOREIGN KEY (`reported_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_reporter_report` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stads`
--

DROP TABLE IF EXISTS `stads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `capacity` int NOT NULL,
  `ville_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ville_stad` (`ville_id`),
  CONSTRAINT `fk_ville_stad` FOREIGN KEY (`ville_id`) REFERENCES `villes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stads`
--

LOCK TABLES `stads` WRITE;
/*!40000 ALTER TABLE `stads` DISABLE KEYS */;
/*!40000 ALTER TABLE `stads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staffs`
--

DROP TABLE IF EXISTS `staffs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staffs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `date_naissance` date NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffs`
--

LOCK TABLES `staffs` WRITE;
/*!40000 ALTER TABLE `staffs` DISABLE KEYS */;
/*!40000 ALTER TABLE `staffs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tournoies`
--

DROP TABLE IF EXISTS `tournoies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tournoies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `nbr_equipes` int NOT NULL,
  `logo_path` varchar(200) DEFAULT NULL,
  `nbr_round` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tournoies`
--

LOCK TABLES `tournoies` WRITE;
/*!40000 ALTER TABLE `tournoies` DISABLE KEYS */;
/*!40000 ALTER TABLE `tournoies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `displayed_name` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `profile_path` varchar(200) DEFAULT NULL,
  `password` varchar(300) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `villes`
--

DROP TABLE IF EXISTS `villes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `villes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ville` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `villes`
--

LOCK TABLES `villes` WRITE;
/*!40000 ALTER TABLE `villes` DISABLE KEYS */;
/*!40000 ALTER TABLE `villes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-15 12:16:02
