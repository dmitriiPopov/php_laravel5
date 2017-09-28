-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: laravel5_database
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

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
-- Table structure for table `brends`
--

DROP TABLE IF EXISTS `brends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brends` (
  `brends_id` int(11) NOT NULL AUTO_INCREMENT,
  `brends_tech` int(1) NOT NULL DEFAULT '1',
  `brends_zapros` int(1) NOT NULL DEFAULT '1',
  `brends_name` varchar(255) NOT NULL,
  `brends_name_rus` varchar(255) NOT NULL,
  `brends_name_rus_ua` varchar(255) NOT NULL,
  `brends_name_rus_en` varchar(255) NOT NULL,
  `brends_url` varchar(255) NOT NULL,
  `brends_description` text NOT NULL,
  `brends_sort` int(11) NOT NULL,
  PRIMARY KEY (`brends_id`)
) ENGINE=InnoDB AUTO_INCREMENT=265 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `brends_tech`
--

DROP TABLE IF EXISTS `brends_tech`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brends_tech` (
  `brends_tech_id` int(11) NOT NULL AUTO_INCREMENT,
  `brend_id` int(11) NOT NULL,
  `tech_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `brends_tech_time` int(11) NOT NULL,
  PRIMARY KEY (`brends_tech_id`),
  KEY `brend_id` (`brend_id`),
  KEY `tech_id` (`tech_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1247 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `goods`
--

DROP TABLE IF EXISTS `goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `tech_id` int(11) NOT NULL,
  `detail_id` int(11) NOT NULL,
  `goods_cod` varchar(20) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_description` text NOT NULL,
  `goods_description2` text NOT NULL,
  `goods_description_shablon` text NOT NULL,
  `goods_title` varchar(255) NOT NULL,
  `goods_keywords` text NOT NULL,
  `goods_description_seo` text NOT NULL,
  `goods_sort` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`goods_id`),
  KEY `tech_id` (`tech_id`),
  KEY `detail_id` (`detail_id`),
  KEY `goods_cod` (`goods_cod`(5)),
  KEY `goods_name` (`goods_name`(5)),
  KEY `goods_description` (`goods_description`(5)),
  KEY `goods_sort` (`goods_sort`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `goods_cod`
--

DROP TABLE IF EXISTS `goods_cod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods_cod` (
  `goods_cod_id` int(10) unsigned NOT NULL,
  `goods_id` int(11) NOT NULL,
  `brends_id` int(10) unsigned NOT NULL,
  `goods_cod_name` varchar(255) NOT NULL,
  `goods_cod_time` int(11) NOT NULL,
  `goods_cod_sort` longtext NOT NULL,
  PRIMARY KEY (`goods_cod_id`),
  KEY `goods_id` (`goods_id`),
  KEY `goods_cod_name` (`goods_cod_name`(5)),
  KEY `brends_id` (`brends_id`),
  KEY `goods_cod_name AND brends_id AND goods_id` (`goods_cod_name`(5),`brends_id`,`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model` (
  `model_id` int(11) NOT NULL AUTO_INCREMENT,
  `brends_id` int(11) NOT NULL,
  `tech_id` int(11) NOT NULL,
  `model_name` varchar(255) NOT NULL,
  `model_serial` varchar(100) NOT NULL,
  `model_url` varchar(255) NOT NULL,
  `model_name1` varchar(255) NOT NULL,
  PRIMARY KEY (`model_id`),
  KEY `brends_id` (`brends_id`),
  KEY `tech_id` (`tech_id`),
  KEY `model_name` (`model_name`(5)),
  KEY `model_url` (`model_url`(5)),
  KEY `model_name1` (`model_name1`(5)),
  KEY `model_name OR model_name1 AND brends_id` (`model_name`(5),`model_name1`(5),`brends_id`)
) ENGINE=InnoDB AUTO_INCREMENT=536529 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `model_goods`
--

DROP TABLE IF EXISTS `model_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_goods` (
  `model_goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  PRIMARY KEY (`model_goods_id`),
  KEY `model_id` (`model_id`),
  KEY `goods_id` (`goods_id`),
  KEY `model_id AND goods_id` (`model_id`,`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3879877 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `object`
--

DROP TABLE IF EXISTS `object`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `object` (
  `object_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT '0',
  `object_parent` int(11) DEFAULT '0',
  `object_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_name_alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_rankplus` int(6) DEFAULT '0',
  `object_rankminus` int(6) DEFAULT '0',
  `object_visible` tinyint(1) DEFAULT '1',
  `object_visible2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_visible3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_date` datetime DEFAULT NULL,
  `object_date2` datetime NOT NULL,
  `object_picture_icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_picture_icon_add_alt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_picture_banner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_picture_banner_add_alt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(6) DEFAULT '0',
  `view_id` tinyint(3) DEFAULT '0',
  `object_sort` int(11) DEFAULT '0',
  PRIMARY KEY (`object_id`),
  KEY `category_id` (`category_id`),
  KEY `v_id` (`view_id`),
  KEY `u_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1355 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='объектов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `object_name`
--

DROP TABLE IF EXISTS `object_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `object_name` (
  `object_name_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) DEFAULT '0',
  `object_name_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_name_name_alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_name_description` longtext COLLATE utf8_unicode_ci,
  `object_name_description2` text COLLATE utf8_unicode_ci NOT NULL,
  `object_name_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_name_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_name_keywords` text COLLATE utf8_unicode_ci,
  `object_name_descriptions` text COLLATE utf8_unicode_ci,
  `lang_id` tinyint(3) DEFAULT '1',
  `object_name_sort` tinyint(3) DEFAULT '0',
  `object_name_materials` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`object_name_id`),
  KEY `o_id` (`object_id`),
  KEY `l_id` (`lang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2197 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='описания';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `object_name_page`
--

DROP TABLE IF EXISTS `object_name_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `object_name_page` (
  `object_name_page_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_name_id` int(11) DEFAULT '0',
  `object_name_page_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_name_page_description` mediumtext COLLATE utf8_unicode_ci,
  `object_name_page_sort` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`object_name_page_id`),
  KEY `o_n_id` (`object_name_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1967 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='страниц';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-28 21:58:56