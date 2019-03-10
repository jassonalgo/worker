-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: drupal
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

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
-- Table structure for table `node`
--

DROP TABLE IF EXISTS `node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `node` (
  `nid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier for a node.',
  `vid` int(10) unsigned DEFAULT NULL COMMENT 'The current node_revision.vid version identifier.',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT 'The node_type.type of this node.',
  `language` varchar(12) NOT NULL DEFAULT '' COMMENT 'The languages.language of this node.',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'The title of this node, always treated as non-markup plain text.',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid that owns this node; initially, this is the user that created it.',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Boolean indicating whether the node is published (visible to non-administrators).',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the node was created.',
  `changed` int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the node was most recently saved.',
  `comment` int(11) NOT NULL DEFAULT '0' COMMENT 'Whether comments are allowed on this node: 0 = no, 1 = closed (read only), 2 = open (read/write).',
  `promote` int(11) NOT NULL DEFAULT '0' COMMENT 'Boolean indicating whether the node should be displayed on the front page.',
  `sticky` int(11) NOT NULL DEFAULT '0' COMMENT 'Boolean indicating whether the node should be displayed at the top of lists in which it appears.',
  `tnid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The translation set id for this node, which equals the node id of the source post in each set.',
  `translate` int(11) NOT NULL DEFAULT '0' COMMENT 'A boolean indicating whether this translation page needs to be updated.',
  PRIMARY KEY (`nid`),
  UNIQUE KEY `vid` (`vid`),
  KEY `node_changed` (`changed`),
  KEY `node_created` (`created`),
  KEY `node_frontpage` (`promote`,`status`,`sticky`,`created`),
  KEY `node_status_type` (`status`,`type`,`nid`),
  KEY `node_title_type` (`title`,`type`(4)),
  KEY `node_type` (`type`(4)),
  KEY `uid` (`uid`),
  KEY `tnid` (`tnid`),
  KEY `translate` (`translate`),
  KEY `language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='The base table for nodes.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `node`
--

LOCK TABLES `node` WRITE;
/*!40000 ALTER TABLE `node` DISABLE KEYS */;
INSERT INTO `node` VALUES (1,1,'article','und','Dolore Humo Refoveo Ullamcorper',0,1,1551515524,1552097405,2,1,0,0,0),(2,2,'article','und','Luctus Pecus Pneum',0,1,1551527855,1552097405,2,0,0,0,0),(3,3,'article','und','Distineo Pertineo Ut',0,1,1551868855,1552097405,2,1,0,0,0),(4,4,'article','und','Caecus',0,1,1551709778,1552097405,2,1,0,0,0),(5,5,'article','und','Aliquam Venio',1,1,1551699199,1552097405,2,0,0,0,0),(6,6,'article','und','Caecus Pagus Saluto',0,1,1551861474,1552097405,2,0,0,0,0),(7,7,'article','und','Abigo Blandit Elit Vereor',0,1,1551644632,1552097405,2,1,0,0,0),(8,8,'article','und','Camur Natu Si Suscipere',0,1,1552053723,1552097405,2,1,0,0,0),(9,9,'article','und','Ratis Typicus',0,1,1551712177,1552097405,2,0,0,0,0),(10,10,'article','und','Consectetuer Praemitto Utinam Velit',0,1,1552049175,1552097405,2,1,0,0,0),(11,11,'article','und','Augue Esse Huic Suscipit',1,1,1551503291,1552097405,2,1,0,0,0),(12,12,'article','und','Aliquam Eros Persto',1,1,1552052614,1552097405,2,0,0,0,0),(13,13,'article','und','Iaceo Interdico Sagaciter',0,1,1551736845,1552097405,2,1,0,0,0),(14,14,'article','und','Abbas Vel',0,1,1551916944,1552097405,2,0,0,0,0),(15,15,'article','und','Hendrerit Luctus',1,1,1551754275,1552097405,2,0,0,0,0),(16,16,'article','und','Capto Suscipit',0,1,1551662833,1552097405,2,1,0,0,0),(17,17,'article','und','Lobortis',0,1,1551637414,1552097405,2,1,0,0,0),(18,18,'article','und','Adipiscing Aliquam Melior Similis',1,1,1551712364,1552097405,2,1,0,0,0),(19,19,'article','und','Neque Nibh',0,1,1551924785,1552097405,2,0,0,0,0),(20,20,'article','und','Utrum',0,1,1551835470,1552097405,2,1,0,0,0),(21,21,'article','und','Ludus Pneum Premo Quadrum',0,1,1551939205,1552097405,2,1,0,0,0),(22,22,'article','und','Acsi Eligo Nobis',0,1,1551647712,1552097405,2,1,0,0,0),(23,23,'article','und','Gilvus',1,1,1551499388,1552097405,2,0,0,0,0),(24,24,'article','und','Velit',1,1,1551800794,1552097405,2,1,0,0,0),(25,25,'article','und','Abico Accumsan Metuo',0,1,1551730437,1552097405,2,1,0,0,0),(26,26,'article','und','Genitus Gravis Jugis Neque',1,1,1552048945,1552097405,2,0,0,0,0),(27,27,'article','und','Antehabeo Lobortis Sagaciter',0,1,1551523247,1552097405,2,1,0,0,0),(28,28,'article','und','Elit Natu Odio Ut',0,1,1551983874,1552097405,2,1,0,0,0),(29,29,'article','und','Pecus Suscipit Ut',0,1,1551780984,1552097405,2,1,0,0,0),(30,30,'article','und','Aliquip Virtus',0,1,1552085619,1552097405,2,0,0,0,0),(31,31,'article','und','Premo Quidne Utinam',1,1,1551902575,1552097405,2,1,0,0,0),(32,32,'article','und','Nibh',1,1,1551789707,1552097405,2,0,0,0,0),(33,33,'article','und','Sit Tum',0,1,1551897802,1552097405,2,0,0,0,0),(34,34,'article','und','Jus Nostrud Patria',0,1,1552064150,1552097405,2,1,0,0,0),(35,35,'article','und','Commodo Probo Turpis Valetudo',0,1,1551911369,1552097405,2,0,0,0,0),(36,36,'article','und','Luctus Metuo Os',1,1,1552080987,1552097405,2,0,0,0,0),(37,37,'article','und','Defui Nibh Nimis Zelus',1,1,1551648190,1552097405,2,1,0,0,0),(38,38,'article','und','Dolore Ratis Verto',0,1,1551811075,1552097405,2,0,0,0,0),(39,39,'article','und','Modo Neque Rusticus',1,1,1552089938,1552097405,2,0,0,0,0),(40,40,'article','und','Brevitas',0,1,1551954501,1552097405,2,0,0,0,0),(41,41,'article','und','Exerci Si',0,1,1551985021,1552097405,2,1,0,0,0),(42,42,'article','und','Nunc Quis',0,1,1551652649,1552097405,2,0,0,0,0),(43,43,'article','und','Gemino Mauris Roto Usitas',0,1,1551541528,1552097405,2,1,0,0,0),(44,44,'article','und','Iriure Pertineo',0,1,1552072757,1552097405,2,1,0,0,0),(45,45,'article','und','Humo Roto',0,1,1551868222,1552097405,2,0,0,0,0),(46,46,'article','und','Adipiscing Jumentum Neque Populus',1,1,1551565629,1552097405,2,0,0,0,0),(47,47,'article','und','Dolus Plaga',0,1,1551748979,1552097405,2,1,0,0,0),(48,48,'article','und','Utinam',1,1,1551696133,1552097405,2,0,0,0,0),(49,49,'article','und','Vero',0,1,1551720651,1552097405,2,1,0,0,0),(50,50,'article','und','Diam',1,1,1551864196,1552097405,2,1,0,0,0);
/*!40000 ALTER TABLE `node` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-10 10:21:19
