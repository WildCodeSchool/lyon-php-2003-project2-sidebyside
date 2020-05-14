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
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_has_collaborators`
--

DROP TABLE IF EXISTS `project_has_collaborators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `project_has_collaborators` (
  `project_id` int NOT NULL,
  `user_id` int NOT NULL,
  `join_at` date NOT NULL,
  `comment` varchar(600) DEFAULT NULL,
  `comment_at` datetime DEFAULT NULL,
  PRIMARY KEY (`project_id`,`user_id`),
  KEY `fk_projet_has_users_users1_idx` (`user_id`),
  KEY `fk_projet_has_users_projet1_idx` (`project_id`),
  CONSTRAINT `fk_projet_has_users_projet1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `fk_projet_has_users_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_has_collaborators`
--

LOCK TABLES `project_has_collaborators` WRITE;
/*!40000 ALTER TABLE `project_has_collaborators` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_ask_collaboration_projects`
--

DROP TABLE IF EXISTS user_ask_collaboration_projects;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `user_ask_collaboration_projects` (
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
-- Dumping data for table `user_ask_collaboration_projects`
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
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE  `messages`
(
    id         int auto_increment
        primary key,
    author     int      not null,
    to_project int      null,
    to_user    int      null,
    message    text     not null,
    created_at datetime not null
);

--
-- Dumping data for table `user_like_projects`
--




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

INSERT INTO category (id, name) VALUES (1, 'Internet');
INSERT INTO category (id, name) VALUES (2, 'Construction');
INSERT INTO category (id, name) VALUES (3, 'Musique');
INSERT INTO category (id, name) VALUES (4, 'Rénovation');
INSERT INTO category (id, name) VALUES (5, 'Electronique');
INSERT INTO category (id, name) VALUES (6, 'Jardinage');
INSERT INTO project_has_collaborators (project_id, user_id, join_at, comment, comment_at) VALUES (5, 12, '2020-05-11', null, null);
INSERT INTO project_has_collaborators (project_id, user_id, join_at, comment, comment_at) VALUES (5, 13, '2020-05-11', null, null);
INSERT INTO project_has_collaborators (project_id, user_id, join_at, comment, comment_at) VALUES (7, 14, '2020-05-11', null, null);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (13, 5);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (14, 5);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (17, 5);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (18, 6);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (19, 6);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (1, 7);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (3, 7);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (4, 7);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (5, 7);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (7, 7);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (18, 8);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (19, 8);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (21, 9);
INSERT INTO project_need_skills (skill_id, project_id) VALUES (22, 9);
INSERT INTO projects (id, title, description, plan, zip_code, deadline, banner_image, team_description, project_owner_id, category_id, created_at) VALUES (5, 'Site d''échange', 'Bonjour,
J''ai comme projet de créer un site d''échange entre particuliers.', 'Création d''une maquette.
Création d''une charte graphique
Rédaction des US et création du Backlog
Création du Repo GitHub', '73000', '2020-12-01', '/assets/uploads/projects/5eb93739cb9d5.jpg', '', 14, 1, '2020-05-11 13:30:01');
INSERT INTO projects (id, title, description, plan, zip_code, deadline, banner_image, team_description, project_owner_id, category_id, created_at) VALUES (6, 'Groupe de musique', 'Mon projet:

Créer un groupe de musique Rock', null, '85000', '2021-01-08', '/assets/uploads/projects/5eb938748a6fd.jpg', null, 3, 1, '2020-05-11 13:35:16');
INSERT INTO projects (id, title, description, plan, zip_code, deadline, banner_image, team_description, project_owner_id, category_id, created_at) VALUES (7, 'Ma maison autonome', 'Bonjour,
Je décide enfin a poster sur le site le projet de ma vie.
Qui est la création de ma maison 100% autonome.
J''ai une faible expérience en construction donc j''ai besoin de votre aide.', null, '69000', '2020-11-21', '/assets/uploads/projects/5eb940ecaa80b.jpg', null, 5, 2, '2020-05-11 14:11:24');
INSERT INTO projects (id, title, description, plan, zip_code, deadline, banner_image, team_description, project_owner_id, category_id, created_at) VALUES (8, 'Création de musiques', 'Dans l''univers de la musique depuis petit je recherche des collaborateur pour créer et publier des musique libre de droit pour les créateur de continue Youtube.', null, '73000', '2021-12-24', '/assets/uploads/projects/5eb942a8efebc.jpg', null, 22, 3, '2020-05-11 14:18:48');
INSERT INTO projects (id, title, description, plan, zip_code, deadline, banner_image, team_description, project_owner_id, category_id, created_at) VALUES (9, 'Jardin collectif', 'Bonjour,
J''ai pour projet d''acheter et partager une parcelle de terre afin de partager un potager.', null, '69000', '2020-10-17', '/assets/uploads/projects/5eb94540a76f6.jpg', null, 12, 6, '2020-05-11 14:29:52');
INSERT INTO skills (id, name) VALUES (1, 'Menuiserie');
INSERT INTO skills (id, name) VALUES (2, 'Carrelage');
INSERT INTO skills (id, name) VALUES (3, 'Charpente');
INSERT INTO skills (id, name) VALUES (4, 'Couvreur');
INSERT INTO skills (id, name) VALUES (5, 'Électricité');
INSERT INTO skills (id, name) VALUES (6, 'Géométrie');
INSERT INTO skills (id, name) VALUES (7, 'Maconnerie');
INSERT INTO skills (id, name) VALUES (8, 'Mécanique auto');
INSERT INTO skills (id, name) VALUES (9, 'Peinture');
INSERT INTO skills (id, name) VALUES (10, 'Plomberie');
INSERT INTO skills (id, name) VALUES (11, 'Soudure');
INSERT INTO skills (id, name) VALUES (13, 'Informatique');
INSERT INTO skills (id, name) VALUES (14, 'Développement Web');
INSERT INTO skills (id, name) VALUES (15, 'Électronique');
INSERT INTO skills (id, name) VALUES (16, 'Pâtisserie');
INSERT INTO skills (id, name) VALUES (17, 'Art Graphique');
INSERT INTO skills (id, name) VALUES (18, 'Musique');
INSERT INTO skills (id, name) VALUES (19, 'M.A.O');
INSERT INTO skills (id, name) VALUES (20, 'Ingénierie');
INSERT INTO skills (id, name) VALUES (21, 'Jardinerie');
INSERT INTO skills (id, name) VALUES (22, 'Paysagiste');
INSERT INTO user_ask_collaboration_projects (user_id, project_id, message, status, created_at) VALUES (12, 5, 'Bonjour,
J''aimerais vous rejoindre dans le développement du site.

Cordialement', 'ok', '2020-05-11 14:53:29');
INSERT INTO user_ask_collaboration_projects (user_id, project_id, message, status, created_at) VALUES (13, 5, 'Salut,
Je suis développeuse et j''aimerais participer au projet.', 'ok', '2020-05-11 15:21:01');
INSERT INTO user_ask_collaboration_projects (user_id, project_id, message, status, created_at) VALUES (14, 7, 'Bonjour,
Je Voudrais collaborer', 'ok', '2020-05-11 15:26:55');
INSERT INTO user_has_skills (user_id, skill_id) VALUES (4, 1);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (14, 1);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (17, 1);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (18, 1);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (23, 1);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (30, 1);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (4, 3);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (14, 3);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (23, 3);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (24, 3);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (6, 4);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (10, 5);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (14, 5);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (20, 5);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (30, 5);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (18, 6);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (6, 7);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (8, 7);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (14, 7);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (3, 8);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (10, 8);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (21, 8);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (25, 8);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (7, 9);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (19, 9);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (30, 9);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (24, 10);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (7, 11);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (18, 11);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (21, 11);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (3, 13);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (9, 13);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (14, 13);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (15, 13);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (16, 13);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (17, 13);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (18, 13);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (9, 14);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (12, 14);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (13, 14);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (14, 14);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (15, 14);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (16, 14);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (17, 14);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (1, 15);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (19, 15);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (5, 16);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (26, 16);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (2, 17);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (22, 17);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (24, 17);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (2, 18);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (3, 18);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (15, 18);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (19, 18);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (22, 18);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (15, 19);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (1, 20);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (2, 20);
INSERT INTO user_has_skills (user_id, skill_id) VALUES (26, 20);
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (1, 'Siders', 'Bot', 'Bot@gmail.com', '$2y$10$JxL743/w0pp23xeDyTa7OOAwrCZcSKItyFh6O8ABIBX1VdEiL3Aq6', '73000', '/assets/uploads/profils/5eb91e2a8c8a8.gif', '/assets/uploads/profils/5eb91fc607c62.jpg', 'Bonjour,
Mon petit prénom pour les intimes c''est Side
C''es moi le Bot du site, qui m''occupe d''envoyer vos petit messages avec amour.', null, '2020-05-11 10:58:25');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (2, 'Carré', 'Alice', 'Alice@gmail.com', '$2y$10$UFeLRX2wfUfWf6niBmy91Or7u82G86ybGgaeYEzRDxTjJtI8.rflq', '73500', '/assets/uploads/profils/5eb920d636cae.png', '/assets/uploads/profils/5eb920d636ce6.png', 'Bonjour,
Alice, ingénieur de métiers, je suis passionné par la musique et l''art', null, '2020-05-11 10:41:27');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (3, 'Cugnard', 'Johnny', 'Johnny@gmail.com', '$2y$10$b0gSrE7FzF2YI/5WvTrJ3ONPoprSnUnrpVjtpaRXWg7QBytB6PxXy', '73000', '/assets/uploads/profils/5eb924351067d.jpg', '/assets/uploads/profils/5eb923054d683.jpg', 'Fan de Musique et mécanicien a mes heure perdu !', null, '2020-05-11 10:44:46');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (4, 'Bertrand', 'Hassan', 'Hassan@gmail.com', '$2y$10$ysepihPLd3weRthS0zwcHe7CvZRbm1XLXe9Qky6HD0o4e.ePYiN2u', '05000', '/assets/uploads/profils/5eb925012c67d.png', '/assets/uploads/profils/5eb9257be1fa4.jpg', 'Menuisier de père en fils, depuis 15 ans dans le bois, j''adore aider mon entourage.', null, '2020-05-11 10:45:16');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (5, 'Bardamu', 'Sylvia', 'Sylvia@gmail.com', '$2y$10$hUJDc.DI93w7wgIe1zGxU.mkF4wu53Liqu9vuNqovBtOYHDnhC8N6', '58000', '/assets/uploads/profils/5eb9260d3d16f.png', '/assets/uploads/profils/5eb91d6112983.png', 'Sylvia 45 ans
Je serais ravi de vous donner un coup de main dans vos projets de pâtisserie', null, '2020-05-11 10:46:14');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (6, 'Berrurier', 'Jessy', 'Jessy@gmail.com', '$2y$10$jlZC00kOXXVY1rZ2owWCLeBvtH8snRFLkXWt.AnoP.kyn.hCEexwG', '01000', '/assets/uploads/profils/5eb926c6d74d0.png', '/assets/uploads/profils/5eb926c6d74fe.jpg', 'Maçon de métier je suis disponible pour vous aider !', null, '2020-05-11 10:46:56');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (7, 'Coullon', 'Arthur', 'Arthur@gmail.com', '$2y$10$w1VEp2WbE8VzravcnpmNF.BViXIEd4qT4D/83WsaMCXIwKK9SsLMW', '69000', '/assets/uploads/profils/5eb927b3dcf60.png', '/assets/uploads/profils/5eb927b3dcf8b.jpg', 'Bonjour,
Arthur, Peintre, je suis passionné par la peinture et la nature.', null, '2020-05-11 10:47:39');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (8, 'Dejardin', 'Mohamed', 'Mohamed@gmail.com', '$2y$10$okNPn.HexywPC8OOoTThPuMc1QRNGenvkUeWL92dVtB2mZ4d6bAhu', '69000', '/assets/uploads/profils/5eb92db93e06b.png', '/assets/uploads/profils/5eb92db93e0a5.jpg', 'Moi c''est Mohamed,
Dispo les weekend-end pour vous aider.', null, '2020-05-11 10:48:15');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (9, 'Elalaoui', 'Renée', 'Renee@gmail.com', '$2y$10$1g3xxPOB3CF/Syg6IbLHoelC1395pW0/ZA/n0nXjWU1g5U6MtXPK2', '95000', '/assets/uploads/profils/5eb92e37b21b8.jpg', '/assets/uploads/profils/5eb92e37b21e6.jpg', 'Bonjour,
Dans le développement web et plus généralement dans l’informatique depuis 10ans', null, '2020-05-11 10:48:59');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (10, 'Dupont', 'Valérie', 'Valerie@gmail.com', '$2y$10$QAlBT8vTeo/vEIqNQmPVdudC.wkxSLClHVa3RPCxLQXvmfWN3ueY2', '85000', '/assets/uploads/profils/5eb92f3429963.png', '/assets/uploads/profils/5eb92f3429991.jpg', 'Bonjour,
Valérie, Mécanicienne, j''ai mon propre garage et je peut vous aider dans vos projet de rénovation automobile.', null, '2020-05-11 10:49:41');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (11, 'Francois', 'Martin', 'Martin@gmail.com', '$2y$10$oCWkyrKHG6mYpl0HBgkGQuwYQl2PYHzMa9j1Bvxs6WNcYN3ffQdzC', '85520', '/assets/uploads/profils/5eb92f976edc8.png', '/assets/uploads/profils/5eb92f976edee.jpg', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 10:50:10');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (12, 'Loupiot', 'Laura', 'Laura@gmail.com', '$2y$10$14hmIRkO9WzcwICadh6zGufvmOoBvewLpR3teqHevY8Qdc51uGHYm', '73000', '/assets/uploads/profils/5eb92fe361d5e.png', '/assets/uploads/profils/5eb92fe361da5.png', 'Je suis developpeuse PHP & Java', null, '2020-05-11 10:50:39');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (13, 'Sunna', 'Justine', 'Justine@gmail.com', '$2y$10$koDWfFoNPlCI/OWbhNDluutbS25DR4JgqBtPLFeZMFCW7u8KT46Oe', '73000', '/assets/uploads/profils/5eb93029c731c.png', '/assets/uploads/profils/5eb93029c738a.png', 'Justine,
Je suis developpeuse PHP & Symfony', null, '2020-05-11 10:51:17');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (14, 'Cr7t3k', 'Guillaume', 'Guillaume@gmail.com', '$2y$10$UejDrLYbJ0yqSDhxx3aUROhAUjVN2rmb15mt5KevvlEIfAUZrkUxu', '73520', '/assets/uploads/profils/5eb9309a39bfb.png', '/assets/uploads/profils/5eb9309a39c32.jpg', 'Bonjour,
Je suis Developpeur Web Full Stack', null, '2020-05-11 10:51:41');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (15, 'Simplito', 'Gael', 'Gael@gmail.com', '$2y$10$HfK9Qm0UvjGv7/FpK3xmf.wZxu312z0Kd8g5GsVTEgSj5Jw.eZnqa', '69000', '/assets/uploads/profils/5eb92f976edc8.png', '/assets/uploads/profils/5eb9309a39c32.jpg', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 10:52:18');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (16, 'Raph', 'Raphael', 'Raphael@gmail.com', '$2y$10$qgcnPZApw5EOOQgPdjzaGOKIOu7eIvdF5TBt/oeQKBhIY2XUsosHu', '69000', '/assets/uploads/profils/5eb927b3dcf60.png', '/assets/uploads/profils/5eb927b3dcf8b.jpg', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 10:52:42');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (17, 'Alc', 'Stephane', 'Stephane@gmail.com', '$2y$10$DKS0Y9JPRb1Vib9jScfQpOIkWy1tUYRHPx7PI8WzrDy4/uxdPD9wm', '69000', '/assets/uploads/profils/5eb927b3dcf60.png', '/assets/uploads/profils/5eb92f976edee.jpg', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 10:53:03');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (18, 'Thibault', 'Yvon', 'Yvon@gmail.com', '$2y$10$wKEhIOxBhJJmlIfF3YI4Bu030mFeehB6plLw3QNmNOQit0CDev0AO', '73000', '/assets/uploads/profils/5eb92db93e06b.png', '/assets/uploads/profils/5eb92db93e0a5.jpg', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 10:59:29');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (19, 'Smith', 'Alex', 'Alex@gmail.com', '$2y$10$US9Hao3MEh93i3l5pmJ.petPTB7biigtps4EhUhVb4aAkxBZFzmKW', '73000', '/assets/uploads/profils/5eb92f976edc8.png', '/assets/uploads/profils/5eb923054d683.jpg', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 10:59:52');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (20, 'Crosby', 'Julian', 'Julian@gmail.com', '$2y$10$lKLvDybld4BCr5kfGbVIhOpav6efERWahMllw6jMomF77/d7v1De2', '69001', '/assets/uploads/profils/5eb92db93e06b.png', '/assets/uploads/profils/5eb92f976edee.jpg', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 11:00:15');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (21, 'Bibeau', 'Martin', 'Martin@gmail.com', '$2y$10$XFuv7mkv3vhtUUe4HM2SMujzJoYlDSZNxwXr2g1h3wfbKbVW8QhR2', '69009', '/assets/uploads/profils/5eb92f976edc8.png', '/assets/uploads/profils/5eb9257be1fa4.jpg', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 11:00:40');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (22, 'Allard', 'Benoit', 'Benoit@gmail.com', '$2y$10$f8jigU9iyw/aPZ9xFqRj9OXNtPRm1QT8.84ROaVc8iBU32soEz0kK', '69005', '/assets/uploads/profils/5eb92db93e06b.png', '/assets/uploads/profils/5eb923054d683.jpg', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 11:01:03');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (23, 'Gingras', 'Marc', 'Marc@gmail.com', '$2y$10$YK2QH.NsvyPITDa.VINuWen6bPnFl8SOMlJ9.Zi04SCrSHev69hK6', '36150', '/assets/uploads/profils/5eb92f976edc8.png', '/assets/uploads/profils/5eb9257be1fa4.jpg', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 11:01:30');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (24, 'Bibeau', 'Rita', 'Rita@gmail.com', '$2y$10$o12E9HcOkmlXntTuqEVMpuebu60E4T/WrUQOFGETBWjEYipjN7qrq', '36150', '/assets/uploads/profils/5eb93029c731c.png', '/assets/uploads/profils/5eb91d6112983.png', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 11:01:48');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (25, 'Dupuis', 'Carole', 'Carole@gmail.com', '$2y$10$busyRaXLThSt4.lh5Lt.HO6THmfU4YoI6KEjsCebHXzj09d8idMzO', '48920', '/assets/uploads/profils/5eb92f3429963.png', '/assets/uploads/profils/5eb91d6112983.png', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 11:02:12');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (26, 'Pomme', 'Olivia', 'Olivia@gmail.com', '$2y$10$bvVEroPUxKakeMyBZe9YuOHV4engN3NU/4LrN.h2X.BeqmMtw8j56', '69050', '/assets/uploads/profils/5eb93029c731c.png', '/assets/uploads/profils/5eb92f3429991.jpg', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 11:04:37');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (27, 'Roulo', 'Emma', 'Emma@gmail.com', '$2y$10$YObJW4EAKEpI07z6gFqYvOtqiN68hemQ0ZHX/rdecjQE4lNtaT/Au', '86930', '/assets/uploads/profils/5eb92f3429963.png', '/assets/uploads/profils/5eb91d6112983.png', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 11:05:06');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (28, 'None', 'Ava', 'Ava@gmail.com', '$2y$10$pPxYxu5vnib029fUgb.h8Os6B0Dzz1tCKUD26tvR1w6k2Nh4Akafq', '73560', '/assets/uploads/profils/5eb93029c731c.png', '/assets/uploads/profils/5eb92f3429991.jpg', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 11:05:34');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (29, 'Mode', 'Mia', 'Mia@gmail.com', '$2y$10$t6bocb2tLsoWnDuSj1p21.iEvETVdAg7PO2AbY5OKfeNQo/Y6Tzba', '69000', '/assets/uploads/profils/5eb92f3429963.png', '/assets/uploads/profils/5eb91d6112983.png', 'Bonjour,
Disponible pour vos projet.
Hate de venir vous aider dans vos projets et apporter mon expertise', null, '2020-05-11 11:06:05');
INSERT INTO users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (30, 'Malin', 'Sophia', 'Sophia@gmail.com', '$2y$10$NCBNuO6E7gtxnV8nxuFG8ulFn6yZEvXkTdud6/gZzjgh/ouXtvPZu', '69000', '/assets/uploads/profils/5eb91ccbd23af.png', '/assets/uploads/profils/5eb91d6112983.png', 'Bonjour,
Moi c''est Sophia, Fan de bricolage depuis petite.
J''ai hâte de participer à vos projets.', null, '2020-05-11 11:06:26');
INSERT INTO sidebyside.users (id, last_name, first_name, email, password, zip_code, profil_picture, banner_image, description, is_admin, created_at) VALUES (32, 'Martinot', 'Matthieu', 'Matthieu@gmail.com', '$2y$10$FmFicDredTYzh4.23Yakl.07aBHSiSpLcJELjodpzMMjXoAtgcutG', '69005', '/assets/uploads/profils/5ebbff86a420d.png', '/assets/uploads/profils/5eb92db93e0a5.jpg', 'Zen comme Zen
Hub comme Hub
Soumissez', null, '2020-05-13 16:09:10');




LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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
