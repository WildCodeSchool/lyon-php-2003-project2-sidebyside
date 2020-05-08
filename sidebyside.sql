CREATE DATABASE  IF NOT EXISTS `sidebyside` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sidebyside`;
-- MySQL dump 10.13  Distrib 8.0.19, for Linux (x86_64)
--
-- Host: localhost    Database: sidebyside
-- ------------------------------------------------------
-- Server version	8.0.19-0ubuntu0.19.10.3

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Batiment'),(2,'Electronic'),(3,'Jardinage'),(4,'Internet');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_has_collaborators`
--

DROP TABLE IF EXISTS `project_has_collaborators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `project_has_collaborators` (
  `projet_id` int NOT NULL,
  `user_id` int NOT NULL,
  `join_at` date NOT NULL,
  `comment` varchar(600) DEFAULT NULL,
  `comment_at` datetime DEFAULT NULL,
  PRIMARY KEY (`projet_id`,`user_id`),
  KEY `fk_projet_has_users_users1_idx` (`user_id`),
  KEY `fk_projet_has_users_projet1_idx` (`projet_id`),
  CONSTRAINT `fk_projet_has_users_projet1` FOREIGN KEY (`projet_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `fk_projet_has_users_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_has_collaborators`
--

LOCK TABLES `project_has_collaborators` WRITE;
/*!40000 ALTER TABLE `project_has_collaborators` DISABLE KEYS */;
INSERT INTO `project_has_collaborators` VALUES (1,2,'2020-04-10',NULL,NULL),(1,5,'2020-04-01',NULL,NULL),(2,3,'2020-03-12','',NULL),(3,7,'2020-02-01',NULL,NULL),(4,5,'2020-04-04','',NULL);
/*!40000 ALTER TABLE `project_has_collaborators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_has_messages`
--

DROP TABLE IF EXISTS `project_has_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `project_has_messages` (
  `user_id` int NOT NULL,
  `project_id` int NOT NULL,
  `message` varchar(600) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`project_id`),
  KEY `fk_users_has_projets_projets2_idx` (`project_id`),
  KEY `fk_users_has_projets_users2_idx` (`user_id`),
  CONSTRAINT `fk_users_has_projets_projets2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `fk_users_has_projets_users2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_has_messages`
--

LOCK TABLES `project_has_messages` WRITE;
/*!40000 ALTER TABLE `project_has_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_has_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_need_skills`
--

DROP TABLE IF EXISTS `project_need_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `project_need_skills` (
  `skill_id` int NOT NULL,
  `project_id` int NOT NULL,
  PRIMARY KEY (`skill_id`,`project_id`),
  KEY `fk_skills_has_projets_projets1_idx` (`project_id`),
  KEY `fk_skills_has_projets_skills1_idx` (`skill_id`),
  CONSTRAINT `fk_skills_has_projets_projets1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `fk_skills_has_projets_skills1` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_need_skills`
--

LOCK TABLES `project_need_skills` WRITE;
/*!40000 ALTER TABLE `project_need_skills` DISABLE KEYS */;
INSERT INTO `project_need_skills` VALUES (1,1),(2,1),(5,1),(8,2),(9,2),(7,3),(3,4),(5,4);
/*!40000 ALTER TABLE `project_need_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `plan` mediumtext,
  `zip_code` varchar(6) NOT NULL,
  `deadline` date DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `team_description` varchar(200) DEFAULT NULL,
  `project_owner_id` int NOT NULL,
  `category_id` int NOT NULL,
  `created_at` datetime NOT NULL,	
  PRIMARY KEY (`id`,`project_owner_id`,`category_id`),
  KEY `fk_projets_users1_idx` (`project_owner_id`),
  KEY `fk_projets_category1_idx` (`category_id`),
  CONSTRAINT `fk_projets_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `fk_projets_users1` FOREIGN KEY (`project_owner_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Maison en bois','Voici mon projet de maison en bois naturel bla blaokjauihsiufruifi','PLAN oijfeorijjehgegoijeroigjeroijgeoijrgoijeg','54879','2020-04-18',NULL,NULL,1,1,'2020-01-01'),(2,'Cabanon de jardin','Je voudrais une cabane de jardin pour mes enfant, venez maidez','PLAN oijfeorijjehgegoijeroigjeroijgeoijrgoijeg','01589','2020-08-22',NULL,NULL,2,1,'2020-01-10'),(3,'Jardin autonome partager','Créeons ensemble un jardin que l\'on partagerait ensemble','PLAN oijfeorijjehgegoijeroigjeroijgeoijrgoijeg','73000','2020-08-22',NULL,NULL,3,3,'2020-01-20'),(4,'Plateforme d\'echange','Developpont une plateforme d\'echange entre particulier','PLAN oijfeorijjehgegoijeroigjeroijgeoijrgoijeg','95000','2021-04-10',NULL,NULL,4,4,'2020-02-15');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `skills` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (1,'Menuisier'),(2,'Macon'),(3,'Electricien'),(4,'Devellopeur'),(5,'Electricien'),(6,'Bucheron'),(7,'Ingenieur'),(8,'Boulanger'),(9,'Guitariste');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_ask_collaboration_projets`
--

DROP TABLE IF EXISTS user_ask_collaboration_projects;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `user_ask_collaboration_projets` (
  `user_id` int NOT NULL,
  `project_id` int NOT NULL,
  `message` varchar(500) NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`project_id`),
  KEY `fk_users_has_projets_projets1_idx` (`project_id`),
  KEY `fk_users_has_projets_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_has_projets_projets1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `fk_users_has_projets_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_ask_collaboration_projets`
--

LOCK TABLES user_ask_collaboration_projects WRITE;
/*!40000 ALTER TABLE user_ask_collaboration_projects DISABLE KEYS */;
/*!40000 ALTER TABLE user_ask_collaboration_projects ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_follow_projects`
--

DROP TABLE IF EXISTS `user_follow_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `user_follow_projects` (
  `users_id` int NOT NULL,
  `projects_id` int NOT NULL,
  `follow` tinyint NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`users_id`,`projects_id`),
  KEY `fk_users_has_projects_projects1_idx` (`projects_id`),
  KEY `fk_users_has_projects_users1_idx` (`users_id`),
  CONSTRAINT `fk_users_has_projects_projects1` FOREIGN KEY (`projects_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `fk_users_has_projects_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_follow_projects`
--

LOCK TABLES `user_follow_projects` WRITE;
/*!40000 ALTER TABLE `user_follow_projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_follow_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_has_comments`
--

DROP TABLE IF EXISTS `user_has_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `user_has_comments` (
  `users_id` int NOT NULL,
  `author_id` int NOT NULL,
  `content` varchar(600) NOT NULL,
  `rate` int NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`users_id`,`author_id`),
  KEY `fk_users_has_users_users2_idx` (`author_id`),
  KEY `fk_users_has_users_users1_idx` (`users_id`),
  CONSTRAINT `fk_users_has_users_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_users_has_users_users2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_has_comments`
--

LOCK TABLES `user_has_comments` WRITE;
/*!40000 ALTER TABLE `user_has_comments` DISABLE KEYS */;
INSERT INTO `user_has_comments` VALUES (1,2,'Super user',1,'2020-04-17 21:56:52'),(1,3,'Super user',4,'2020-04-15 21:57:02'),(2,1,'Super user',5,'2020-04-17 21:56:52'),(2,3,'Super user',2,'2020-04-15 21:57:02'),(3,4,'Super user',1,'2020-04-17 21:56:52'),(3,5,'Super user',2,'2020-04-15 21:57:02'),(4,1,'Super user',5,'2020-04-17 21:56:52'),(4,2,'Super user',3,'2020-04-15 21:57:02'),(5,3,'Super user',1,'2020-04-09 21:57:37'),(5,4,'Super user',2,'2020-04-11 21:56:52'),(5,6,'Super user',4,'2020-04-14 21:57:58'),(5,7,'Super user',3,'2020-04-17 21:56:52'),(7,1,'Super user',5,'2020-04-17 21:56:52');
/*!40000 ALTER TABLE `user_has_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_has_skills`
--

DROP TABLE IF EXISTS `user_has_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `user_has_skills` (
  `user_id` int NOT NULL,
  `skill_id` int NOT NULL,
  PRIMARY KEY (`skill_id`,`user_id`),
  KEY `fk_users_has_skills_skills1_idx` (`skill_id`),
  KEY `fk_users_has_skills_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_has_skills_skills1` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`),
  CONSTRAINT `fk_users_has_skills_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_has_skills`
--

LOCK TABLES `user_has_skills` WRITE;
/*!40000 ALTER TABLE `user_has_skills` DISABLE KEYS */;
INSERT INTO `user_has_skills` VALUES (7,1),(1,3),(1,4),(5,4),(6,5),(3,6),(2,7),(4,7),(5,8),(6,8),(3,9),(4,9);
/*!40000 ALTER TABLE `user_has_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_like_projects`
--

DROP TABLE IF EXISTS `user_like_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `user_like_projects` (
  `user_id` int NOT NULL,
  `project_id` int NOT NULL,
  `like` tinyint NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`project_id`),
  KEY `fk_users_has_projets_projets3_idx` (`project_id`),
  KEY `fk_users_has_projets_users3_idx` (`user_id`),
  CONSTRAINT `fk_users_has_projets_projets3` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `fk_users_has_projets_users3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_like_projects`
--

LOCK TABLES `user_like_projects` WRITE;
/*!40000 ALTER TABLE `user_like_projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_like_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `last_name` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `zip_code` varchar(6) NOT NULL,
  `profil_picture` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `is_admin` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Tomb','Jean','mail@mail.com','123456','73590',NULL,NULL,'Salut les amis',NULL,'2020-01-17 19:35:59'),(2,'Marteau','Luc','mail@mail.com','123456','45698',NULL,NULL,'Description de moi',NULL,'2020-02-17 19:36:42'),(3,'Caillou','Pierre','mail@mail.com','123456','89523',NULL,NULL,'J\'aime les oiseaux',NULL,'2020-02-25 19:37:45'),(4,'Siceaux','Mickael','mail@mail.com','123456','05896',NULL,NULL,'Ma description de fou',NULL,'2020-03-17 19:39:12'),(5,'Balais','Patrick','mail@mail.com','124597','54632',NULL,NULL,'Salut les petite loutres',NULL,'2020-03-20 19:44:11'),(6,'Palais','Martin','mail@mail.com','8zedi6','974',NULL,NULL,'Ma description de fou',NULL,'2020-03-20 19:44:11'),(7,'Pates','Jeremy','mail@mail.com','54zefze','01695',NULL,NULL,'Description de moi',NULL,'2020-04-17 19:46:11');
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

-- Dump completed on 2020-04-21  9:55:38
