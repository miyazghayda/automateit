-- MySQL dump 10.13  Distrib 5.6.31, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: automateit
-- ------------------------------------------------------
-- Server version	5.6.31-0ubuntu0.14.04.2

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
-- Table structure for table `accountlists`
--

DROP TABLE IF EXISTS `accountlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accountlists` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) NOT NULL,
  `member_id` bigint(20) NOT NULL,
  `typeid` int(11) NOT NULL COMMENT '1 idol 2 blacklist',
  `allfollowersaved` tinyint(1) DEFAULT '0',
  `nextmaxid` varchar(1000) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '1',
  `proxy_id` int(11) NOT NULL DEFAULT '1',
  `pk` bigint(20) NOT NULL,
  `profpicurl` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `fullname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `followers` int(11) NOT NULL,
  `followings` int(11) NOT NULL,
  `contents` int(11) NOT NULL,
  `started` date DEFAULT NULL,
  `ended` date DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `statusid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 need to test login 2 test login failed 3 test login success 4 unpaid 5 paid 6 paused by user',
  `note` text COLLATE utf8_bin,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `profpicurlfixed` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cargos`
--

DROP TABLE IF EXISTS `cargos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cargos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) NOT NULL,
  `typeid` tinyint(4) NOT NULL COMMENT '1 photo 2 video 3 carousel 4 story',
  `schedule` datetime NOT NULL,
  `uploaded` tinyint(1) NOT NULL DEFAULT '0',
  `caption` text COLLATE utf8_bin NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `commentinglists`
--

DROP TABLE IF EXISTS `commentinglists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commentinglists` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) NOT NULL,
  `member_id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `typeid` tinyint(4) NOT NULL COMMENT '1 feed 2 hashtag 3 location',
  `commented` tinyint(1) NOT NULL DEFAULT '1',
  `uncommented` tinyint(1) NOT NULL DEFAULT '0',
  `commentedat` datetime DEFAULT NULL,
  `uncommentedat` datetime DEFAULT NULL,
  `who` tinyint(1) NOT NULL COMMENT '0 bot 1 user',
  `caption` text COLLATE utf8_bin NOT NULL,
  `note` text COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `fellows`
--

DROP TABLE IF EXISTS `fellows`;
/*!50001 DROP VIEW IF EXISTS `fellows`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `fellows` AS SELECT 
 1 AS `id`,
 1 AS `pk`,
 1 AS `username`,
 1 AS `fullname`,
 1 AS `description`,
 1 AS `profpicurl`,
 1 AS `followers`,
 1 AS `followings`,
 1 AS `contents`,
 1 AS `closed`,
 1 AS `created`,
 1 AS `modified`,
 1 AS `active`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `followinglists`
--

DROP TABLE IF EXISTS `followinglists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `followinglists` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vassal_id` bigint(20) NOT NULL DEFAULT '1',
  `member_id` bigint(20) NOT NULL DEFAULT '1',
  `fellow_id` bigint(20) NOT NULL DEFAULT '1',
  `typeid` tinyint(4) NOT NULL COMMENT '1 someone followers 2 hashtag 3 location',
  `followed` tinyint(1) NOT NULL DEFAULT '0',
  `unfollowed` tinyint(1) NOT NULL DEFAULT '0',
  `followedat` datetime DEFAULT NULL,
  `unfollowedat` datetime DEFAULT NULL,
  `who` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 bot 1 user',
  `account_id` bigint(20) NOT NULL,
  `note` text COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hashtaglists`
--

DROP TABLE IF EXISTS `hashtaglists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hashtaglists` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) NOT NULL,
  `typeid` tinyint(4) NOT NULL COMMENT '1 follow 2 like',
  `whitelist` tinyint(1) NOT NULL DEFAULT '1',
  `caption` varchar(255) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `likinglists`
--

DROP TABLE IF EXISTS `likinglists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likinglists` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) NOT NULL,
  `member_id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `typeid` tinyint(4) NOT NULL COMMENT '1 feed 2 hashtag 3 location',
  `liked` tinyint(1) NOT NULL DEFAULT '1',
  `unliked` tinyint(1) NOT NULL DEFAULT '0',
  `likedat` datetime DEFAULT NULL,
  `unlikedat` datetime DEFAULT NULL,
  `who` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 bot 1 user',
  `note` text COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `locationlists`
--

DROP TABLE IF EXISTS `locationlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locationlists` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) NOT NULL,
  `whitelist` tinyint(1) NOT NULL DEFAULT '1',
  `caption` varchar(255) COLLATE utf8_bin NOT NULL,
  `typeid` tinyint(4) NOT NULL COMMENT '1 follow 2 like',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pk` bigint(20) NOT NULL,
  `fbplacesid` bigint(20) NOT NULL DEFAULT '0',
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `address` text COLLATE utf8_bin NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `shortname` varchar(255) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=407 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pk` bigint(20) NOT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `fullname` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `profpicurl` varchar(1000) COLLATE utf8_bin NOT NULL,
  `followers` int(11) NOT NULL DEFAULT '0',
  `followings` int(11) NOT NULL DEFAULT '0',
  `contents` int(11) NOT NULL DEFAULT '0',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `profpicurlfixed` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1189 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pk` bigint(20) NOT NULL,
  `sourceid` varchar(1000) COLLATE utf8_bin NOT NULL,
  `location_id` bigint(20) NOT NULL,
  `member_id` bigint(20) NOT NULL,
  `typeid` tinyint(4) NOT NULL COMMENT '1 photo 2 video 3 carousel 4 story',
  `caption` text COLLATE utf8_bin,
  `likes` int(11) NOT NULL,
  `comments` int(11) NOT NULL,
  `takenat` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=145 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `preferences`
--

DROP TABLE IF EXISTS `preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preferences` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) NOT NULL,
  `maxlikeperday` int(11) NOT NULL DEFAULT '0',
  `maxcommentperday` int(11) NOT NULL DEFAULT '0',
  `maxfollowperday` int(11) NOT NULL DEFAULT '0',
  `maxpostperday` tinyint(4) NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `followidolfollower` tinyint(1) NOT NULL DEFAULT '0',
  `followbyhashtag` tinyint(1) NOT NULL DEFAULT '0',
  `followbylocation` tinyint(1) NOT NULL DEFAULT '0',
  `likefeed` tinyint(1) NOT NULL DEFAULT '0',
  `likebyhashtag` tinyint(1) NOT NULL DEFAULT '0',
  `likebylocation` tinyint(1) NOT NULL DEFAULT '0',
  `commentfeed` tinyint(1) NOT NULL DEFAULT '0',
  `commentbyhashtag` tinyint(1) NOT NULL DEFAULT '0',
  `commentbylocation` tinyint(1) NOT NULL DEFAULT '0',
  `followtoday` smallint(6) NOT NULL DEFAULT '0',
  `liketoday` smallint(6) NOT NULL DEFAULT '0',
  `commenttoday` smallint(6) NOT NULL DEFAULT '0',
  `posttoday` smallint(6) NOT NULL DEFAULT '0',
  `hashtagtofollowtoday` smallint(6) NOT NULL DEFAULT '0',
  `gethashtagtofollowtoday` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `proxies`
--

DROP TABLE IF EXISTS `proxies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proxies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '0.0.0.0',
  `username` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reaps`
--

DROP TABLE IF EXISTS `reaps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reaps` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cargo_id` bigint(20) NOT NULL,
  `typeid` tinyint(4) NOT NULL COMMENT '1 photo 2 video',
  `extension` varchar(255) COLLATE utf8_bin NOT NULL,
  `sequence` tinyint(4) NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `fullname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `groupid` tinyint(4) NOT NULL COMMENT '1 admin 2 manager 3 user',
  `statusid` tinyint(4) NOT NULL COMMENT '1 registered 2 activated 3 banned 4 deleted',
  `lastlog` datetime NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vassals`
--

DROP TABLE IF EXISTS `vassals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vassals` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) NOT NULL,
  `fellow_id` bigint(20) NOT NULL,
  `active` bigint(20) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wads`
--

DROP TABLE IF EXISTS `wads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wads` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `typeid` tinyint(4) NOT NULL DEFAULT '1',
  `sequence` tinyint(4) NOT NULL,
  `url` varchar(1000) COLLATE utf8_bin NOT NULL,
  `width` smallint(6) NOT NULL,
  `height` smallint(6) NOT NULL,
  `urlfixed` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=776 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `fellows`
--

/*!50001 DROP VIEW IF EXISTS `fellows`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`miyazghayda`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `fellows` AS select `members`.`id` AS `id`,`members`.`pk` AS `pk`,`members`.`username` AS `username`,`members`.`fullname` AS `fullname`,`members`.`description` AS `description`,`members`.`profpicurl` AS `profpicurl`,`members`.`followers` AS `followers`,`members`.`followings` AS `followings`,`members`.`contents` AS `contents`,`members`.`closed` AS `closed`,`members`.`created` AS `created`,`members`.`modified` AS `modified`,`members`.`active` AS `active` from `members` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-11  7:59:24
