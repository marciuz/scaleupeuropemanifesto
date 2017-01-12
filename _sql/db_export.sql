-- MySQL dump 10.13  Distrib 5.5.53, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: edfx2
-- ------------------------------------------------------
-- Server version	5.5.53-0ubuntu0.14.04.1

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
-- Temporary table structure for view `_country`
--

DROP TABLE IF EXISTS `_country`;
/*!50001 DROP VIEW IF EXISTS `_country`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `_country` (
  `id_country` tinyint NOT NULL,
  `country` tinyint NOT NULL,
  `abbr` tinyint NOT NULL,
  `flag_url` tinyint NOT NULL,
  `summary` tinyint NOT NULL,
  `is_eu` tinyint NOT NULL,
  `visible` tinyint NOT NULL,
  `id_ctype` tinyint NOT NULL,
  `ctype` tinyint NOT NULL,
  `order_num` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `action`
--

DROP TABLE IF EXISTS `action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action` (
  `action_n` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_area` int(11) unsigned NOT NULL,
  `action` text NOT NULL,
  `short_desc` varchar(255) DEFAULT '',
  `number` varchar(6) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `long_desc` text,
  PRIMARY KEY (`action_n`),
  KEY `fk_area` (`id_area`),
  CONSTRAINT `fk_area` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area` (
  `id_area` int(11) unsigned NOT NULL,
  `area` varchar(255) DEFAULT NULL,
  `label` varchar(100) NOT NULL,
  PRIMARY KEY (`id_area`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `count_indicators`
--

DROP TABLE IF EXISTS `count_indicators`;
/*!50001 DROP VIEW IF EXISTS `count_indicators`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `count_indicators` (
  `action_n` tinyint NOT NULL,
  `tot` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `id_country` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(50) NOT NULL,
  `abbr` char(3) DEFAULT NULL,
  `flag_url` varchar(255) NOT NULL,
  `summary` text,
  `is_eu` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Is a EU member?',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `id_ctype` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_country`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 COMMENT='The 28 european MS + specials';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `country_type`
--

DROP TABLE IF EXISTS `country_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country_type` (
  `id_ctype` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_type` varchar(10) DEFAULT NULL,
  `order_num` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_ctype`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `dashboard01`
--

DROP TABLE IF EXISTS `dashboard01`;
/*!50001 DROP VIEW IF EXISTS `dashboard01`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `dashboard01` (
  `id_country` tinyint NOT NULL,
  `action_n` tinyint NOT NULL,
  `deadline` tinyint NOT NULL,
  `n` tinyint NOT NULL,
  `tot` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `dashboard02`
--

DROP TABLE IF EXISTS `dashboard02`;
/*!50001 DROP VIEW IF EXISTS `dashboard02`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `dashboard02` (
  `id_country` tinyint NOT NULL,
  `id_area` tinyint NOT NULL,
  `action_n` tinyint NOT NULL,
  `anumber` tinyint NOT NULL,
  `yes` tinyint NOT NULL,
  `no` tinyint NOT NULL,
  `na` tinyint NOT NULL,
  `tot` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `indicator`
--

DROP TABLE IF EXISTS `indicator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indicator` (
  `id_indicator` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ind_label` varchar(10) NOT NULL,
  `num` int(1) DEFAULT NULL,
  `action_n` int(10) unsigned NOT NULL,
  `indicator` text,
  `evidence_eg` text,
  `in_dashboard` int(11) DEFAULT '1' COMMENT 'The indicator is used for dashbord (1|0)',
  `audience` enum('country','ec','startup','ecosys') DEFAULT 'country' COMMENT 'EC, MS, none',
  `explanation` text,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `deadline` date DEFAULT NULL,
  PRIMARY KEY (`id_indicator`),
  KEY `action_n` (`action_n`),
  KEY `visible` (`visible`),
  KEY `audience` (`audience`),
  CONSTRAINT `indicator_ibfk_1` FOREIGN KEY (`action_n`) REFERENCES `action` (`action_n`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8 COMMENT='The action''s indicators';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_access`
--

DROP TABLE IF EXISTS `log_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_access` (
  `id_log` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `access_date` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `log_access_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ms_form`
--

DROP TABLE IF EXISTS `ms_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_form` (
  `id_ms_form` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_country` int(11) unsigned NOT NULL,
  `presence` int(1) DEFAULT NULL,
  `id_indicator` int(10) unsigned NOT NULL,
  `evidence` text,
  `lastdata` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int(10) unsigned NOT NULL,
  `confirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_ms_form`),
  UNIQUE KEY `id_country` (`id_country`,`id_indicator`),
  KEY `confirmed` (`confirmed`),
  KEY `id_indicator` (`id_indicator`),
  CONSTRAINT `ms_form_ibfk_1` FOREIGN KEY (`id_country`) REFERENCES `country` (`id_country`) ON UPDATE CASCADE,
  CONSTRAINT `ms_form_ibfk_2` FOREIGN KEY (`id_indicator`) REFERENCES `indicator` (`id_indicator`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ms_gen_info`
--

DROP TABLE IF EXISTS `ms_gen_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_gen_info` (
  `id_country` int(10) unsigned NOT NULL,
  `ministry` varchar(255) NOT NULL,
  `link_action_plan` text NOT NULL,
  `progress_summary` text NOT NULL,
  `lastdata` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='general info from form';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `responses`
--

DROP TABLE IF EXISTS `responses`;
/*!50001 DROP VIEW IF EXISTS `responses`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `responses` (
  `id_ms_form` tinyint NOT NULL,
  `id_country` tinyint NOT NULL,
  `presence` tinyint NOT NULL,
  `id_indicator` tinyint NOT NULL,
  `evidence` tinyint NOT NULL,
  `lastdata` tinyint NOT NULL,
  `id_user` tinyint NOT NULL,
  `id_area` tinyint NOT NULL,
  `action` tinyint NOT NULL,
  `number` tinyint NOT NULL,
  `start_date` tinyint NOT NULL,
  `end_date` tinyint NOT NULL,
  `area` tinyint NOT NULL,
  `num` tinyint NOT NULL,
  `action_n` tinyint NOT NULL,
  `indicator` tinyint NOT NULL,
  `in_dashboard` tinyint NOT NULL,
  `deadline` tinyint NOT NULL,
  `audience` tinyint NOT NULL,
  `country` tinyint NOT NULL,
  `abbr` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `id_country` int(10) unsigned DEFAULT NULL,
  `type` enum('admin','ms') NOT NULL DEFAULT 'ms' COMMENT 'ms, admin, ec',
  `other_info` text,
  `title` varchar(255) DEFAULT NULL,
  `organisation` varchar(255) DEFAULT NULL,
  `visible_web` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_user`),
  KEY `id_country` (`id_country`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='Users table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vars`
--

DROP TABLE IF EXISTS `vars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vars` (
  `var` varchar(100) NOT NULL DEFAULT '',
  `val` text,
  `val_plural` text,
  PRIMARY KEY (`var`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `_country`
--

/*!50001 DROP TABLE IF EXISTS `_country`*/;
/*!50001 DROP VIEW IF EXISTS `_country`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `_country` AS select `c`.`id_country` AS `id_country`,`c`.`country` AS `country`,`c`.`abbr` AS `abbr`,`c`.`flag_url` AS `flag_url`,`c`.`summary` AS `summary`,`c`.`is_eu` AS `is_eu`,`c`.`visible` AS `visible`,`c`.`id_ctype` AS `id_ctype`,`ct`.`country_type` AS `ctype`,`ct`.`order_num` AS `order_num` from (`country` `c` join `country_type` `ct` on((`ct`.`id_ctype` = `c`.`id_ctype`))) order by `ct`.`order_num` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `count_indicators`
--

/*!50001 DROP TABLE IF EXISTS `count_indicators`*/;
/*!50001 DROP VIEW IF EXISTS `count_indicators`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `count_indicators` AS select `indicator`.`action_n` AS `action_n`,count(0) AS `tot` from `indicator` where (`indicator`.`visible` = 1) group by `indicator`.`action_n` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `dashboard01`
--

/*!50001 DROP TABLE IF EXISTS `dashboard01`*/;
/*!50001 DROP VIEW IF EXISTS `dashboard01`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `dashboard01` AS select `c`.`id_country` AS `id_country`,`i`.`action_n` AS `action_n`,`i`.`deadline` AS `deadline`,count(0) AS `n`,`t1`.`tot` AS `tot` from (((`country` `c` join `ms_form` `f` on((`c`.`id_country` = `f`.`id_country`))) join `indicator` `i` on(((`i`.`id_indicator` = `f`.`id_indicator`) and (`i`.`visible` = 1)))) join `count_indicators` `t1` on((`t1`.`action_n` = `i`.`action_n`))) where (`f`.`presence` = 1) group by `f`.`id_country`,`i`.`action_n`,`i`.`deadline` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `dashboard02`
--

/*!50001 DROP TABLE IF EXISTS `dashboard02`*/;
/*!50001 DROP VIEW IF EXISTS `dashboard02`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `dashboard02` AS select `c`.`id_country` AS `id_country`,`a`.`id_area` AS `id_area`,`a`.`action_n` AS `action_n`,`a`.`number` AS `anumber`,count(`f1`.`presence`) AS `yes`,count(`f2`.`presence`) AS `no`,((count(`i`.`id_indicator`) - count(`f1`.`presence`)) - count(`f2`.`presence`)) AS `na`,count(`i`.`id_indicator`) AS `tot` from ((((`country` `c` join `action` `a`) join `indicator` `i` on(((`i`.`action_n` = `a`.`action_n`) and (`i`.`visible` = 1)))) left join `ms_form` `f1` on(((`f1`.`id_country` = `c`.`id_country`) and (`f1`.`id_indicator` = `i`.`id_indicator`) and (`f1`.`presence` = 1)))) left join `ms_form` `f2` on(((`f2`.`id_country` = `c`.`id_country`) and (`f2`.`id_indicator` = `i`.`id_indicator`) and (`f2`.`presence` = 2)))) group by `c`.`id_country`,`a`.`action_n` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `responses`
--

/*!50001 DROP TABLE IF EXISTS `responses`*/;
/*!50001 DROP VIEW IF EXISTS `responses`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `responses` AS select `f`.`id_ms_form` AS `id_ms_form`,`f`.`id_country` AS `id_country`,`f`.`presence` AS `presence`,`f`.`id_indicator` AS `id_indicator`,`f`.`evidence` AS `evidence`,`f`.`lastdata` AS `lastdata`,`f`.`id_user` AS `id_user`,`a`.`id_area` AS `id_area`,`a`.`action` AS `action`,`a`.`number` AS `number`,`a`.`start_date` AS `start_date`,`a`.`end_date` AS `end_date`,`aa`.`area` AS `area`,`i`.`num` AS `num`,`i`.`action_n` AS `action_n`,`i`.`indicator` AS `indicator`,`i`.`in_dashboard` AS `in_dashboard`,`i`.`deadline` AS `deadline`,`i`.`audience` AS `audience`,`c`.`country` AS `country`,`c`.`abbr` AS `abbr` from ((((`ms_form` `f` join `indicator` `i` on(((`i`.`id_indicator` = `f`.`id_indicator`) and (`i`.`visible` = 1)))) join `country` `c` on((`c`.`id_country` = `f`.`id_country`))) join `action` `a` on((`a`.`action_n` = `i`.`action_n`))) join `area` `aa` on((`aa`.`id_area` = `a`.`id_area`))) */;
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

-- Dump completed on 2017-01-12 16:24:55
-- MySQL dump 10.13  Distrib 5.5.53, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: edfx2
-- ------------------------------------------------------
-- Server version	5.5.53-0ubuntu0.14.04.1

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
-- Dumping data for table `action`
--

LOCK TABLES `action` WRITE;
/*!40000 ALTER TABLE `action` DISABLE KEYS */;
INSERT INTO `action` VALUES (55,1,'Online pan-European VAT clearing house','','1.1',NULL,NULL,'Create an online pan-European VAT clearing house. The product should be created through PPP by competitive tender and meet a maximal ease-of-use standard. The resulting VAT recovery process should be transparent and uniform throughout the EU'),(56,1,'SME test in all 28 member states','','1.2',NULL,NULL,'Enforce the SME test in all 28 member states. Add a “scale up” component to include potential effect of new regulation on growth and scaling'),(57,1,'Copyright - Copyright harmonization ','','1.3a',NULL,NULL,'Widening and harmonising exceptions and limitations in copyright  '),(58,1,'Copyright - TDM exception ','','1.3b',NULL,NULL,'TDM exception / Unified rules across Europe for innovative ways to generate value with data, e.g. text-and data mining'),(59,1,'Copyright - A pan-European licence','','1.3c',NULL,NULL,'A pan-European licence'),(60,1,'Data - Restore European policy in the data-protection area','','1.4a',NULL,NULL,'Restore European policy in the data-protection area'),(61,1,'Data - Structured dialogue regulators/startup on data protection ','','1.4b',NULL,NULL,'A structured dialogue between regulators and the startup community around impact assessments and guidelines by the European Data Protection Supervisor'),(62,1,'Data - No forced data localisation','','1.4c',NULL,NULL,'No forced data localisation'),(63,1,'Data - Legal basis for data transfer ','','1.4d',NULL,NULL,'Safe and reliable legal basis for data transfer '),(64,1,'e-Identity - Acceptance of national eIDs','','1.5a',NULL,NULL,'Accelerate member-state acceptance of national eIDs'),(65,1,'e-Identity - European eIDAS & private sector','','1.5b',NULL,NULL,'Open the European eIDAS system to the private sector'),(66,1,'Ratify the EU patent proposal. ','','1.6 ',NULL,NULL,'Make patent filing cheaper and easier in one language via European Patent Office'),(67,1,'Better information, less administration - Documents publication requirements ','','1.7a',NULL,NULL,'Require EU member states to publish all official documents online in certified translations (multi-language). All documents necessary for doing business in another member state should be readily and easily available in other EU member states in usable, certified translations.'),(68,1,'Better information, less administration - Digital by default. No exceptions','','1.7b',NULL,NULL,'Digital by default. No exceptions'),(69,1,'Invest in Europe’s digital infrastructure','','1.8 ',NULL,NULL,'Invest in Europe’s digital infrastructure'),(70,1,'Single contract','','1.9',NULL,NULL,'Harmonise consumer acquis through speedy approval of the proposed ‘single contract.'),(71,2,'Complete the capital markets union - Insolvency recommendations','','2.1a',NULL,NULL,'Make the 2014 insolvency recommendations mandatory in all 28 EU member states'),(72,2,'Complete the capital markets union - Startup visa','','2.1b',NULL,NULL,'Startup visa'),(73,2,'Complete the capital markets union - Cross-border crowdfunding','','2.1c',NULL,NULL,'Increase access to cross-border crowdfunding'),(74,2,'Build incentives for growth within the tax system - Stock options taxation','','2.2a',NULL,NULL,'Stock options should be taxed when sold, not when received '),(75,2,'Build incentives for growth within the tax system - Tax treatment of debt and equity','','2.2b',NULL,NULL,'Reduction of discriminatory tax treatment of debt over equity. Member states should adopt a notional interest deduction or similar measure to end discriminatory tax treatment of debt over equity'),(76,2,'Build incentives for growth within the tax system - Tax shelters for angel investments ','','2.2c',NULL,NULL,'Use tax shelters for angel investments across Europe'),(77,2,'Crowd in capital - European Fund for Strategic Investments','','2.3a',NULL,NULL,'Greater use should be made of the European Fund for Strategic Investments. It should be made permanent and use of the “crowd in” model replicated for other risk-driven budgetary decisions'),(78,2,'Crowd in capital -Fund of funds','','2.3b',NULL,NULL,'Europe should adopt a “fund of funds” to “crowd in” investment alongside the private sector'),(79,2,'Crowd in capital - Alternative markets on local stock exchanges','','2.3c',NULL,NULL,'Deepen and develop alternative markets on local stock exchanges'),(80,2,'Crowd in capital - Late payments directive','','2.3d',NULL,NULL,'Strengthen and enforce the late payments directive, particularly across borders'),(81,4,'Coordinated cut in non-wage labour taxes','','3.1',NULL,NULL,'Coordinated cut in non-wage labour taxes'),(82,4,'Additional employee for startups','','3.2',NULL,NULL,'Startups, as part of their manifesto pledge, should hire or train at least one additional employee this year'),(83,4,'Make it easier to hire European workers ','','3.3',NULL,NULL,'Make it easier to hire European workers '),(84,4,'Easier to hire skilled non-EU workers','','3.4 ',NULL,NULL,'Easier to hire skilled non-EU workers'),(85,5,'Open government data','','4.1',NULL,NULL,'Open government data'),(86,5,'Sandboxes for regulators ','','4.2',NULL,NULL,'Regulators should make greater use of so-called “sandboxes,” where new models are tested in safe environments'),(87,5,'Open research and innovation funding - Research and innovation funding for wider community ','','4.3a',NULL,NULL,'Research and innovation funding should be more open to a wider community, including scale ups'),(88,5,'Open research and innovation funding - Research funding, risk aversion and applicants turnover','','4.3b',NULL,NULL,'Research funding should be less risk averse with more turnover in successful applicants. Declared success rates are too high; failure in some areas should be considered as a sign that at least the bold was attempted'),(89,5,'Open research and innovation funding - Inclusion of SMEs and scale ups in key decisions','','4.3c',NULL,NULL,'SMEs and scale ups should be included in key decisions, including programme goal setting and monitoring'),(90,5,'Open research and innovation funding - Monitorable targets for SME involvement ','','4.3d',NULL,NULL,'Member states should open public procurement up to scale ups by setting and meeting monitorable targets for SME involvement (3% for pre-commercial procurement (R&D) and 20% for public procurement of innovation)'),(91,5,'Don’t ban new business models','','4.4',NULL,NULL,'Don’t ban new business models'),(92,5,'Startup corporate collaboration - Funding for corporate-startup collaboration ','','4.5a',NULL,NULL,'Earmarking funding for corporate-startup collaboration within overall innovation funding'),(93,5,'Startup corporate collaboration - Governments can assist with data and match-making services','','4.5b',NULL,NULL,'Governments can assist with data and match-making services'),(94,6,'Entrepreneurship education - Teach entrepreneurship in schools','','5.1a',NULL,NULL,'Teach entrepreneurship in schools'),(95,6,'Entrepreneurship education - Incentivize and celebrate academic entrepreneurship','','5.1b',NULL,NULL,'Incentivize and celebrate academic entrepreneurship'),(96,6,'ICT skills - Teach coding in schools','','5.2a',NULL,NULL,'Teach coding in schools'),(97,6,'ICT skills - Teachers’ training ','','5.2b',NULL,NULL,'Teachers’ training '),(98,6,'Open the educational path - Students work placement in their curricula','','5.3b',NULL,NULL,'Ensure educational institutions guarantee students work placement in their curricula'),(99,6,'Education for business - Ensure adequate skills for business growth','','5.4',NULL,NULL,'Ensure adequate skills for business growth'),(100,7,'Track and evaluate all legislation, European and national. ','','6.1',NULL,NULL,'To be overseen by an annual survey and on-the-ground, open, collaborative monitoring, pulled together and distributed in a major publication. It should include scores for each national government and for the EU collectively, including a breakdown of actions not taken and areas not completed'),(101,7,'Set up a think tank ','','6.2',NULL,NULL,'Set up a think tank to continue exploring these issues, serving as a powerful platform for discussion of the future'),(102,7,'Annual meeting of the European Startup Network','','6.3',NULL,NULL,'Convene an annual meeting of the European Startup Network and other startup community representatives and leaders with high-level input and patronage'),(103,6,'Open the educational path - Lifelong learning ','','5.3a',NULL,NULL,'Open the educational path to lifelong learning. Recognise informal learning and degrees based on MOOCs');
/*!40000 ALTER TABLE `action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` VALUES (1,'Complete the Single Market','Complete the Single Market'),(2,'Mobilise Capital','Mobilise Capital'),(3,'My area test','My area test'),(4,'Activate Talent','Activate Talent'),(5,'Power Innovation ','Power Innovation '),(6,'Broaden Education ','Broaden Education '),(7,'Monitor Measure and Evaluate','Monitor Measure and Evaluate');
/*!40000 ALTER TABLE `area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,'Austria','AT','http://europa.eu/about-eu/member-countries/countries/images/austria_flag.gif','Recent years have seen Austria – and in particular Vienna – evolve from an entrepreneurial desert to a promising home for young startups. Still, despite the improving infrastructure and growing awareness of entrepreneur-driven issues (aided by successful local exits and flourishing business angels), there is a lack of venture capital for follow-up financing – and of the right entrepreneurial spirit. One of the initiatives to promote entrepreneurship in Austria is Pioneers Festival, an annual event gathering startups, investors, and technology-driven corporations with a specific focus on Europe, especially Central and Eastern Europe. Labour costs are also high, due to payroll-taxes and health insurance costs, but perhaps the biggest issue for entrepreneurs is a lack of real tax incentives for startups and startup investors. There are some political initiatives to adapt current law to modern day requirements. The government has recently presented its digital strategy, which echoes several suggestions of the Startup Manifesto',1,1,1),(2,'Belgium','BE','http://europa.eu/about-eu/member-countries/countries/images/belgium_flag.gif','Belgium is home to a vibrant, active and fast growing startup scene. Startup Weekends, Hackathlons, Café Numériques, Meetups, Open Coffees and other events are very common in every part of the country. Every large town has its own acceleration programme; and co-working spaces are mushrooming. In early 2015, a group of successful Belgian entrepreneurs launched the Belgian Startup Manifesto. And a few months later, Alexander de Croo, deputy prime minister and minister of development co-operation, digital agenda, telecom and postal services, announced a bold plan to give entrepreneurs extra benefits to grow their new venture. The policies will focus on making crowdfunding easier and keeping lower labour costs for startups. This commitment to innovation is an opening move and is expected to impact upon the local entrepreneurial scene. A Startup Plan to Stimulate Growth for Newly-Formed Companies is a concrete first step to encourage young and beginning entrepreneurs to set up new businesses in innovative sectors. The plan provides more accessible financing, such as a tax shelter for startups, tax incentives for crowdfunding, and lower labour costs for newly formed companies. SMEs and microenterprises investing in digital will also receive incentives.',1,1,1),(3,'Bulgaria','BG','http://europa.eu/about-eu/member-countries/countries/images/bulgaria_flag.gif','The startup ecosystem in Bulgaria has emerged recently and is evolving significantly. Thanks to coworking spaces such as Betahaus, SOHO and CowOrKing as well as local venture funds (LAUNCHub and Eleven) – boosted by investment through the Joint European Resources for Micro and Medium Enterprises (JEREMIE) programme of the European Investment Fund – the startup ecosystem is growing. Several international venture capital funds and strong angel investors backed local companies and there are a few dozen global success stories today. The boom of information-technology outsourcing, hardware and software solutions opened the eyes of a lot of international companies, resulting in a rising reputation for Bulgaria as an excellent source of bright minds. These developments activated entrepreneurship, as many professionals with years of corporate experience started their own ventures and were motivated to reach international recognition and investment. But there is still a long way to go to implement all recommendations of the Startup Manifesto.',1,1,1),(4,'Cyprus','CY','http://europa.eu/about-eu/member-countries/countries/images/cyprus_flag.gif','The government of Cyprus has implemented some policy initiatives in line with the Startup Manifesto recommendations, with the pro-active support of authors of the inspiring national startup manifesto. The country has incorporated the national startup manifesto in the National Policy Statement for Entrepreneurship ratified by the Council of Ministers in December 2015, a concise action plan. Since then, Cyprus rightly positions itself as a good place for any startup to be at the beginning of their lifecycle, as you get the benefit of five times cheaper running and living costs than most other major cities. With a thriving and buzzing supportive ecosystem under the umbrella of Startup Cyprus, Cyprus is evolving into a hot European startup ecosystem driving change, supported by a liberal economy with competitive startup and investment incentives. Its small size makes minimum viable products testing really lean and mean, while funding carries organisations longer with significantly lower rental prices and availability of highly educated talent well versed in English.',1,1,1),(5,'Czech Republic','CZ','http://europa.eu/about-eu/member-countries/countries/images/czechrepublic_flag.gif','Startups play an important role in the Czech economy, where they are known to quickly innovate, find market gaps and create new jobs. The Czech Republic is popular for skilled and relatively cheap information-technology skills, especially among big corporations (e.g. Novartis established its global information and communications technology hub in Prague). But many interesting young companies have also been born there – GoodData, Socialbakers, Cognitive Security, to name a few. The Czech government acknowledges the critical importance of tech entrepreneurship and the pivotal role of startups for the economy. CzechInvest, a government agency, runs accelerator, incubation and mentorship programmes. Recently, CzechInvest launched a new website portal CzechStartups.org. Under one roof, it provides information on incubation possibilities, contacts and consulting as well as possibilities of financing. There are several strong private incubation and venture-capital funds.',1,1,1),(6,'Denmark','DK','http://europa.eu/about-eu/member-countries/countries/images/denmark_flag.gif','Denmark has produced some of the hottest tech startups on the planet. The capital, Copenhagen, is vibrant. Many exciting programmes have been established to promote entrepreneurship. ICT is widely taught in educational institutions. The national government leads Startup Denmark, an initiative to promote entrepreneurship and startups. It is meant as a gateway for talented foreign entrepreneurs to Denmark’s vast startup opportunities, such as accelerators, co-working spaces, investment funds, research centres, as well as grassroots initiatives.',1,1,1),(7,'Estonia','EE','http://europa.eu/about-eu/member-countries/countries/images/estonia_flag.gif','Estonia has highly developed e-government and a business-friendly environment. The country has made progress in promoting entrepreneurship and providing support to fast-growing innovative firms, and it has the potential to become a strong startup hub. Its e-services, mobile communications and Internet applications are among the most progressive in the world. Estonians are adaptable towards new technologies, and use them willingly. The large number of foreign investors doing business in Estonia and the dominance of world-renowned foreign companies in several economic sectors is evidence of the country’s high investment attractiveness. This small Baltic nation is home to around 400 startups, and the number is set to grow. Recently, the Estonian government launched Startup Estonia. The aim is to boost the development of the Estonian startup ecosystem with training activities to support the emergence and development of startup companies and improve their accessibility for “smart money.” The mission and objectives are consistent with the objectives of the Startup Manifesto.',1,1,1),(8,'Finland','FI','http://europa.eu/about-eu/member-countries/countries/images/finland_flag.gif','Just a few years ago, the Finnish startup ecosystem was relatively small and inward-looking. Now it is drawing in the brightest high-tech minds and most innovative companies from around the world. The startup scene in Finland has given birth to two “unicorns” (startups whose valuation exceeds the value of €1 billion) – Rovio (Angry Birds) and Supercell. Since 2009, more than 200 gaming startups have set up shop in Finland. The trend can be attributed to the successes of Nokia’s mobile and tech innovations, now carried on by hundreds of ex-employees. ICT is strongly embedded in the Finnish education system that excels in STEM (science, technology, engineering and mathematics) subjects. Helsinki is home to Slush, an annual mega conference where thousands of startups showcase their products to investors and media. Historically, Finland hasn’t had a strong culture of serial entrepreneurship and the access to risk capital has been very limited. That is changing now: there is an influx of local venture capital funds and an increase in direct investment from international venture capitalists. One of the players helping local startups is Tekes, a state-run funding agency that provided funding to Rovio and Supercell.',1,1,1),(9,'France','FR','http://europa.eu/about-eu/member-countries/countries/images/france_flag.gif','A buoyant legislative movement around tech entrepreneurship started in France a few years ago, engaging a vibrant and energetic community of entrepreneurs, technology geeks and policymakers. Launched in 2013, La French Tech is aimed at fostering and supporting a collective movement around the startup ecosystem. It is financed by the French Economy Ministry and supported at the highest political level. The fact that the policymakers are already strongly engaging with the startup community probably explains why there is no national startup manifesto; a diagnosis has already been made and political leaders understand it’s a priority to make France a “startup nation.” Thus, the emphasis is now on legislative actions and implementation of a startup–friendly environment. On 26 January 2016, the French National Assembly adopted a law “Towards the Digital Republic.” Axelle Lemaire, minister of state for digital affairs, introduced the bill, which was the product of a large public consultation. It intends to tackle many of the uncertainties faced by tech startups and to simplify rules.',1,1,1),(10,'Germany','DE','http://europa.eu/about-eu/member-countries/countries/images/germany_flag.gif','Germany’s thriving startup scene is one of the most unique in Europe. The capital Berlin is home to a mixture of tech entrepreneurs, digital startups, experts and scientists that are making waves in the technology scene. A large and growing number of co-working spaces, accelerators, incubators, innovation labs and entrepreneurship programmes provide the infrastructure for creative ideas to flourish and develop into successful new businesses. The challenge for entrepreneurship in Germany is a low tolerance for failure. According to the 2014 edition of the German Startup Monitor, 63.3% of startup entrepreneurs say this attitude is widespread in German society. Still, startups create jobs and contribute to growth. The country is home to unicorns like Delivery Hero, Home24, Rocket Internet and Zalando. The German government has highlighted their support for startups in their “High-Tech Strategy,” recognising the importance of startups to support today’s and tomorrow’s needs for research and development to sustain economic wellbeing.',1,1,1),(11,'Greece','EL','http://europa.eu/about-eu/member-countries/countries/images/greece_flag.gif','As the authors of the Greek Startup Manifesto – the first national startup manifesto – put it, the Greek economy has experienced an unprecedented collapse since 2009, resulting in a gross domestic product decrease by almost 30% (the greatest for any European country in peace time), unemployment of 28% and youth unemployment as high as 65%. For Greece to recover, the country needs to achieve high growth rates – rates which no traditional economic activity promises to provide in short and medium term. Technology-enabled businesses, and especially highly innovative startup companies offering disruptive solutions with global reach, are well positioned to generate growth and employment. Greece is today definitely not the country of choice for startups for a variety of reasons. Among the most important is a complex and volatile tax framework as well as excessive bureaucracy and digital infrastructure that lags behind the EU average.',1,1,1),(12,'Hungary','HU','http://europa.eu/about-eu/member-countries/countries/images/hungary_flag.gif','Hungary’s capital Budapest is one of the most attractive metropolitan cities in Europe, and it also has a young, blossoming startup scene. Several successful Hungarian companies – Ustream, Prezi and LogMeIn – managed to build exceptional products and enter global markets. These startups are a big inspiration to a lot of people and had a significant impact on the startup culture emerging in Hungary. The startup scene is just awakening and the ecosystem in Budapest has only started its growth. As it evolves, it fosters new ideas and ways of doing business, and it makes it easier for aspiring young talent to get enthusiastic about starting a business. A startup ecosystem of accelerators, funding sources and coworking spaces is also emerging.',1,1,1),(13,'Ireland','IE','http://europa.eu/about-eu/member-countries/countries/images/ireland_flag.gif','Ireland, whose growing economy has had the highest growth rate in the eurozone in recent quarters, has been generating a lot of buzz in the startup community recently. Many of the international tech giants – such as Facebook, Google and Twitter – have European headquarters there and cities like Dublin are ablaze with startups. Uber recently announced that it will open a centre of excellence in Limerick that will initially generate 150 jobs and enable the city to further promote itself as a smart hub. Irish entrepreneurs have enthusiastically committed to creating a Startup Manifesto for Ireland in advance of hosting the Startup Nations Summit in Ireland in November 2016 (this is the first time this conference will take place in Europe). Startup Ireland, representing the Irish startup sector, aims to make Ireland the best place in the world to establish a high-growth startup by 2020. Ireland’s startup ecosystem seems to be at a phase of network growth where individual pockets of excellence are increasing in density and starting to connect with each other nationally. Arguably, this process could be accelerated by further adoption of the triple-helix model – deepening university, business and government collaboration with high-growth startups.',1,1,1),(14,'Italy','IT','http://europa.eu/about-eu/member-countries/countries/images/italy_flag.gif','Since 2012, Italy – the second manufacturing country in the European Union and the fifth in the world – has endowed itself with a powerful arsenal of legislation aimed at strengthening the national startup ecosystem. The groundbreaking Italian Startup Act provides the following: 1) Italian startups can be incorporated online and for free; 2) they are exempted from any fee otherwise due to the Chambers of Commerce; 3) they have a free-of-charge access to an online, bilingual, tailor-made platform for national and foreign investors, called #ItalyFrontiers; 4) the team can be paid with variable performance-based salaries; 5) employees and consultants can be remunerated with stock options and work for equity tools, taxed only in the event of capital gain; 6) they can raise money in exchange for shares through equity crowdfunding campaigns (this is the first ad hoc regulation in the world); 7) startups get access to free, automatic public guarantee on bank loans; 8) they benefit from robust tax relief on equity investment made by individuals (19% tax credit up to a maximum investment of €500,000) or legal entities (20% fiscal deduction up to a maximum investment of €1.8 million); 9) in case things go wrong, startups benefit from a fail-fast mechanism. Recently, the Investment Compact Decree has extended most of the benefits previously attributable just to innovative startups to a broader range of companies.',1,1,1),(15,'Latvia','LV','http://europa.eu/about-eu/member-countries/countries/images/latvia_flag.gif','A former Soviet republic, this Baltic state is an otherwise dynamic and vibrant economy whose growth has been fuelled by foreign direct investment. Now Latvia rediscovers entrepreneurship. In 2015, the Latvian startup community platform “Labs of Latvia” was officially launched. The platform provides information from and about Latvian startups to the world. Its database includes more than 100 Latvian startups, investors and communities. The 2015 Latvian presidency of the Council of the European Union was crucial too. Riga hosted #InnoWeek2015 – “First Innovative Enterprise Week,” with a focus on access to finance for research, innovation and SMEs. The conference brought together EU policymakers and Baltic startup scene representatives. Despite these positive developments, the country still faces many challenges in adopting Startup Manifesto-based recommendations.',1,1,1),(16,'Lithuania','LT','http://europa.eu/about-eu/member-countries/countries/images/lithuania_flag.gif','When it comes to startups, this tiny country of three million is starting to make a name for itself. There are more than 100 annual events, meetups, hackathons and workshops in Lithuania. Among those gathering the most participants yearly are LOGIN (attracting more than 80 speakers and 3500 visitors from all over the world), StartupWeekend Lithuania and SV2B. Currently there are several co-working spaces: Hub Vilnius, StartupHighway X, Namas Hub, Sunrise Valley and Talent Garden Kaunas. Lithuania offers the lowest corporate profit tax rate among its neighbours. It has about 1.5 million people in its labour force, including 26,000 IT professionals. Half of all Lithuanians have higher education and are fluent in at least two foreign languages. Lithuania has a very low cost of living, with labour running roughly a quarter of the EU average. Enterprise Lithuania, a state agency tasked with supporting the establishment and development of competitive businesses in Lithuania, runs the Startup Lithuania initiative. It aims to foster the Lithuanian startup ecosystem by providing consultancy, mentoring, matchmaking with venture capital funds and improving the political and economic environment for startups to flourish.',1,1,1),(17,'Luxembourg','LU','http://europa.eu/about-eu/member-countries/countries/images/luxembourg_flag.gif','The startup community in Luxembourg is wide, dynamic and international. The country boasts a stable business environment and political system as well as easy access to administrations and government and favourable taxation environment. Businesses have access to good digital infrastructure. The Luxembourg Entrepreneur and Startup Community has quickly become one of the fastest-growing communities made up entirely of entrepreneurs, investors and startup aficionados. Hundreds of members have joined the network and attended the numerous meetups organised each month, with early adopters, techies, entrepreneurs, investors and others. On the government side, LuxInnovation, a state-run agency, provides support to startups and other innovative businesses. “Fit for Start” supports startups in their establishment phase by offering early-stage funding and coaching. The aim of the programme is to improve the startup conditions for young innovative enterprises in the ICT sector.',1,1,1),(18,'Malta','MT','http://europa.eu/about-eu/member-countries/countries/images/malta_flag.gif','Malta is a stable eurozone economy, offering a safe business environment, friendly taxation and good business ownership regulation. For startup companies, Malta offers a history of small enterprise, a vibrant location with a workforce of young naturally English-speaking graduates. Startup Weekend Malta is a 54-hour event that brings together designers, developers, entrepreneurs, and experts from all domains. All Startup Weekend events follow the same basic model: anyone is welcome to pitch their startup idea and receive feedback from their peers. Teams form around the top ideas (as determined by popular vote) and embark on a three-day frenzy of business model creation, coding, designing, and market validation. The weekend culminates with presentations in front of local entrepreneur leaders with an opportunity for critical feedback. On the government side, state-owned Malta Enterprise provides support to startups and dynamic businesses, including financial support, seeking to implement the Startup Manifesto recommendations. Malta’s recently launched Digital Strategy echoes the Startup Manifesto and translates its recommendations into specific national policy priorities.',1,1,1),(19,'Netherlands','NL','http://europa.eu/about-eu/member-countries/countries/images/netherlands_flag.gif','The Netherlands is a relatively small country with a relatively large entrepreneurial impact. It all happens in 10+ leading innovation hubs that are 90 minutes apart – giving entrepreneurs access to top talent, technology and ecosystems to help them grow their business. The Netherlands is a fast-changing, dynamic economy that presents opportunities to all entrepreneurs, innovators and great minds who think on an international scale. Startups, such as Booking.com and Adyen, are changing the way we travel and pay. The Netherlands has a unique proposition as a “testbed” and “launch pad” for startups and scale-ups. Dutch consumers are also very open to change and tech savvy. To give an extra boost, the government has initiated the StartupDelta initiative: a dedicated team with excellent connections in enterprise, government, research and all aspects of the startup community. StartupDelta, led by Special Envoy Neelie Kroes, former European Commission vice-president for the digital agenda, closely collaborates with the innovation hubs to make the Netherlands the leading startup ecosystem in Europe. To support the European initiative in this area, local entrepreneurs launched the Dutch Startup Manifesto.',1,1,1),(20,'Poland','PL','http://europa.eu/about-eu/member-countries/countries/images/poland_flag.gif','Entrepreneurship has deep roots in Poland, and has helped the country achieve a level of independence and relative strength over the years. There is an ever increasing number of innovative companies which strengthen and develop the Polish startup ecosystem. Successes achieved in complex industries like biotechnology and programming demonstrate the unlimited potential of Polish talent. However, in order to fully utilise this capacity, there is a need for an ecosystem that supports innovation in Poland. The country is well on the way of implementing the recommendations of the Startup Manifesto. Importantly, this work is supported by the national Startup Poland association and echoed in Poland Startup Manifesto.',1,1,1),(21,'Portugal','PT','http://europa.eu/about-eu/member-countries/countries/images/portugal_flag.gif','After several years of economic hardship, Portugal is witnessing a real entrepreneurial boom, as more young people are choosing to start their own business. This has resulted in an explosive growth in the number of startups. To boost entrepreneurship even more, the Portuguese government created an investment agency called Portugal Ventures, a €450 million fund focusing on investments in innovative, scientific and technology-based companies. In the last year several Portuguese startups – such as Aptoide, Anubisnetworks, Feedzai, OutSystems, Talkdesk, Unbabel, Uniplaces and Veniam – raised significant amounts of international capital (more than €150 million in total). Moreover, the new government just announced a new strategy named Startup Portugal, that will include a very ambitious programme of investment tax incentives and matching funds for business angels and venture capital, along with a strong focus on accelerators and incubation networks, and incentives for startups and innovation. A number of startup incubators have been established, offering new businesses an office or desk to get them off the ground. Startup Lisboa, for example, one of the largest incubators in the country, hosts around 80 startups at any one time from various areas of business, from tech to tourism and everything in between. Based in Lisbon, Beta-i is an organisation with the mission to improve entrepreneurship through creating and boosting a network of entrepreneurship, accelerating startups with global ambition (over 550 in the last five years) and facilitating their access to investment (over €50 million raised). In June 2014, Beta-i was recognised as the biggest startup and entrepreneurship promoter in Europe by the European Enterprise Promotion Awards.',1,1,1),(22,'Romania','RO','http://europa.eu/about-eu/member-countries/countries/images/romania_flag.gif','Romania’s troubled past and extremes of economic hardship have given rise to an enforced entrepreneurial culture of self-sufficiency and resilience, which has spawned a strengthening business sector, a wealth of technical skills and resources and a flourishing startup community. A strong culture of programming, innovation and incubation is emerging. Universities in Bucharest, Timișoara, Cluj-Napoca, Iași and Constanța provide a regular source of talented people and drive tech innovation. The Romanian startup ecosystem now boasts numerous incubators, co-working spaces and dedicated events to help emerging entrepreneurs. National startup figures are modest, but growing. However there are barriers to business growth including a lack of startup funding, bank lending and equity investment, as well as a relatively small domestic consumer market.',1,1,1),(23,'Slovakia','SK','http://europa.eu/about-eu/member-countries/countries/images/slovakia_flag.gif','Slovaks are natural problem solvers, and the forefathers of the Slovak tech scene started to work on their first business ventures not long after the collapse of communism in 1989. A big advantage is the small size of the country. Everyone knows everyone, and mentors, angel investors and venture capitalists are easily approachable at various events. It is also a great test market for business-to-business products as one can easily meet top-level executives and corporate partners. SAPIE (The Slovak Alliance for Internet Economy), a major driver of the innovative and Internet economy in the country, was formed two years ago with over 40 members ranging from multinational players to domestic business icons. Slovak President Andrej Kiska – a former serial entrepreneur himself – avidly promotes an innovation agenda that would unite ecosystems with a strong vision. In 2015, the Slovak government in co-operation with SAPIE prepared and passed the first wave of pro-startup legislation. Among the key elements are new forms of enterprise structure tailored for the needs of high-growth companies, a plan for tax incentives and support for angel investors.',1,1,1),(24,'Slovenia','SI','http://europa.eu/about-eu/member-countries/countries/images/slovenia_flag.gif','Startup companies and the high-tech industry in Slovenia are growing and expanding. Unfortunately, it still happens on a small scale, and the impact on the overall Slovenian economy is limited. The Slovenian startup ecosystem is still fragile and fragmented. The country has developed a framework for general support to entrepreneurship but it doesn’t yet bring as many results as it could, as there is still no differentiation between entrepreneurship and startups, and tailored startup-oriented measures are lacking. Some foundations of a national startup ecosystem have been developed but still more has to be done. Local entrepreneurs have produced a Slovenian Startup Manifesto – a national roadmap in support of the (European) Startup Manifesto. Over the course of the next five years, the initiative aims to create hundreds of new jobs in startups, to connect at least 50 startups with the most important startup ecosystems in the world and to create or attract high-impact startups with global potential.',1,1,1),(25,'Spain','ES','http://europa.eu/about-eu/member-countries/countries/images/spain_flag.gif','Some 89% of employment in Spain is generated by companies with 20 employees – or less. And yet, the Spanish startup ecosystem lacks connection between different initiatives as well as useful and objective information about available resources. Furthermore, since the ecosystem is so young, there is a large disproportion of experienced and unskilled entrepreneurs. The Spanish entrepreneurial ecosystem has made a lot of progress in the last couple of years. However, there are still some individual and cultural elements that damage entrepreneurial activity and affect personal and corporate decision making processes. To drive the much-needed change, a group of entrepreneurs launched the Spanish Startup Manifesto in support of the Startup Manifesto.',1,1,1),(26,'Sweden','SE','http://europa.eu/about-eu/member-countries/countries/images/sweden_flag.gif','Sweden is one of the most competitive economies in the world with a strong business environment and an efficient public administration. The country has a large and diversified export market reaching beyond Europe. Sweden is – paradoxically enough – the second best country in the world when it comes to producing modern billion-dollar startups. Only Silicon Valley beats Stockholm when it comes to unicorns per capita. But this refers to only a handful of companies. Ninety-nine percent of all companies in Sweden are small businesses and today they account for four of five jobs. This is not reflected in Sweden’s politics where the focus lies on big corporations, and where the biggest slice of state funds are allocated to mature companies and regional policy regulations, with a very slim investment in, and understanding of, new and growing businesses. To overcome this problem, leading Swedish entrepreneurs have joined forces to promote the Startup Manifesto. They produced the Swedish Startup Manifesto with an ambitious goal – to make Sweden the most startup-friendly country in the world where many young companies can grow, thrive and stay.',1,1,1),(27,'United Kingdom','UK','http://europa.eu/about-eu/member-countries/countries/images/unitedkingdom_flag.gif','The United Kingdom is an advanced, high-income market economy. The services sector dominates the UK economy, contributing up to 80% of its gross domestic product; the financial services industry is particularly important. The United Kingdom also has one of the most vital startup ecosystems worldwide. A vibrant cultural scene, an international workforce and a wide network of tech hubs and accelerators also help London continue to attract young businesses. The national government is business-oriented and seeks to create a startup-friendly climate in the country. In September 2014, the Coalition for a Digital Economy (COADEC) launched the UK Startup Manifesto, to support the Startup Manifesto and translate its recommendations into country-specific initiatives. It has been backed by over 200 leading startups and investors, including founders and partners from King, TransferWise, SwiftKey, Lovestruck, Funding Circle, MOO, Index Ventures, Passion Capital, Seedcamp and Accel Partners. The UK Startup Manifesto sets out 24 ways the government can make the UK a world leader on digital innovation.',1,1,1),(100,'European Commission','EC','../img/flags/ec.jpg','',0,1,2),(103,'Startup','STR','','',0,1,3),(104,'Ecosystem','ECO','','',0,1,4);
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `country_type`
--

LOCK TABLES `country_type` WRITE;
/*!40000 ALTER TABLE `country_type` DISABLE KEYS */;
INSERT INTO `country_type` VALUES (1,'country',5),(2,'ec',1),(3,'startup',2),(4,'ecosys',3);
/*!40000 ALTER TABLE `country_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `indicator`
--

LOCK TABLES `indicator` WRITE;
/*!40000 ALTER TABLE `indicator` DISABLE KEYS */;
INSERT INTO `indicator` VALUES (1,'1',NULL,55,'Initiate work on a pan-European VAT clearing house. It should be online, effective and easy to use. And it should pass the SME test easily',NULL,1,'ec',NULL,1,NULL),(2,'1',NULL,55,'Create an effective legal base for a European VAT clearing house to enable cross-border declarations and recovery ',NULL,1,'country',NULL,1,NULL),(3,'1',NULL,55,'Endorse, accept and quickly take up the new cross-border system',NULL,1,'startup',NULL,1,NULL),(4,'1',NULL,55,'The new system should be developed through PPP based on consortia and competitive tenders',NULL,1,'ecosys',NULL,1,NULL),(5,'2',NULL,56,'Enforce the usage of the SME Test in EU legislative process \n',NULL,1,'ec',NULL,1,NULL),(6,'3',NULL,56,'Develop an adapted methodology for scale-ups',NULL,1,'ec',NULL,1,NULL),(7,'2',NULL,56,'Enforce usage of SME Test mechanisms in the national legislative process ',NULL,1,'country',NULL,1,NULL),(8,'2',NULL,56,'Participate systematically in the legislative consultations under the think small first principle',NULL,1,'startup',NULL,1,NULL),(9,'2',NULL,56,'Private-sector participants are politely invited to “think small first” as well',NULL,1,'ecosys',NULL,1,NULL),(10,'4',NULL,57,'Widen and harmonise exceptions and limitations in copyright with innovation-driven businesses in mind; include inventors of new business models in impact assessment and structured dialogue',NULL,1,'ec',NULL,1,NULL),(11,'4',NULL,57,'Widen and harmonise exceptions and limitations in copyright with innovation-driven businesses in mind; include inventors of new business models in impact assessment and structured dialogue',NULL,1,'country',NULL,1,NULL),(12,'4',NULL,57,'Recognise “fair use” in copyrighted material by other entities',NULL,1,'startup',NULL,1,NULL),(13,'4',NULL,57,'Recognise “fair use” in copyrighted material by other entities',NULL,1,'ecosys',NULL,1,NULL),(14,'5',NULL,58,'Adopt a new text and data mining exception, commercial and non-commercial, when content has been rightfully obtained',NULL,1,'ec',NULL,1,NULL),(15,'5',NULL,58,'Introduce text and data mining exception, commercial and non-commercial use, when content has been rightfully obtained',NULL,1,'country',NULL,1,NULL),(16,'5',NULL,58,'Use text and data mining to build, better, stronger, more customer-driven businesses',NULL,1,'startup',NULL,1,NULL),(17,'5',NULL,58,'Use text and data mining to build, better, stronger, more customer-driven businesses',NULL,1,'ecosys',NULL,1,NULL),(18,'6',NULL,59,'Introduce a European regulation creating a single European copyright licence',NULL,1,'ec',NULL,1,NULL),(19,'6',NULL,59,'Ensure national recognition and enforcement of pan-European copyright licences',NULL,1,'country',NULL,1,NULL),(20,'6',NULL,59,'Use the licenced content to build great, innovative, cross-border businesses',NULL,1,'startup',NULL,1,NULL),(21,'6',NULL,59,'Use the licenced content to build great, innovative, cross-border businesses',NULL,1,'ecosys',NULL,1,NULL),(22,'7',NULL,60,'Restore coherence at the European level in the data-protection field',NULL,1,'ec',NULL,1,NULL),(23,'7',NULL,60,'Limit use of so-called “opening clauses” in GDPR to preserve a single ruleset',NULL,1,'country',NULL,1,NULL),(24,'7',NULL,60,'Build a climate of trust around data',NULL,1,'startup',NULL,1,NULL),(25,'8',NULL,61,'Initiate a structured dialogue with SMEs, startups and scale-ups on the effect of data rulings on small entities and cross-border businesses. The dialogue should be supplemented with impact assessments and evidence',NULL,1,'ec',NULL,1,NULL),(26,'8',NULL,61,'Data protection regulators to establish a structured dialogue with the startup community ',NULL,1,'country',NULL,1,NULL),(27,'8',NULL,61,'Participate in local startup/data protection supervisor dialogue constructively',NULL,1,'startup',NULL,1,NULL),(28,'8',NULL,61,' Associations initiate dialogue and ensure exchange of best practise',NULL,1,'ecosys',NULL,1,NULL),(29,'9',NULL,62,'Drop all data localisation requirements',NULL,1,'ec',NULL,1,NULL),(30,'9',NULL,62,'Remove national storage requirements',NULL,1,'country',NULL,1,NULL),(31,'10',NULL,63,'Work to keep transatlantic data flows secure and open and to make the new privacy shield a success',NULL,1,'ec',NULL,1,NULL),(32,'10',NULL,63,'Encourage and support full use of improved privacy shield.',NULL,1,'country',NULL,1,NULL),(33,'10',NULL,63,'Sign up and fully implement provisions of improved privacy shield where necessary',NULL,1,'startup',NULL,1,NULL),(34,'10',NULL,63,'Companies to use and promote privacy shield and respect its provisions',NULL,1,'ecosys',NULL,1,NULL),(35,'11',NULL,64,'Encourage e-ID interoperability standards adoption today; don’t let others stall\n',NULL,1,'ec',NULL,1,NULL),(36,'11',NULL,64,'Ensure that the system of eID EU interoperable by following EU technical specifications for eIDAS interoperability correctly\n',NULL,1,'country',NULL,1,NULL),(37,'11',NULL,64,'Adopt and encourage the use of robust e-Identity protocols including eID',NULL,1,'startup',NULL,1,NULL),(38,'12',NULL,65,'Offer the e-IDAS standards to the private sector for the development of robust, pan-European authentication systems',NULL,1,'ec',NULL,1,NULL),(39,'12',NULL,64,'Recognise ID from other MSs and ensured its online services accept your citizens’',NULL,1,'country',NULL,1,NULL),(40,'12',NULL,64,'Use emerging e-Identity standards to facilitate and expand cross-border commerce',NULL,1,'startup',NULL,1,NULL),(41,'12',NULL,64,' Lead by example and adopt eID technologies ',NULL,1,'ecosys',NULL,1,NULL),(42,'14',NULL,66,'Ensure that the Unified Patent Court starts to function\n',NULL,1,'ec',NULL,1,NULL),(43,'13',NULL,66,'Provide adequate information for startups on Unitary Patent Protection',NULL,1,'country',NULL,1,NULL),(44,'13',NULL,66,'Ensure uptake of unitary patent by startups and scale-ups',NULL,1,'startup',NULL,1,NULL),(45,'14',NULL,66,'Ratify Agreement on Unitary Patent Court (at least 13 member states)',NULL,1,'country',NULL,1,NULL),(46,'16',NULL,68,'Adopt a “Digital by default” principle ',NULL,1,'ec',NULL,1,NULL),(47,'16',NULL,68,'Adopt a “Digital by default” principle ',NULL,1,'country',NULL,1,NULL),(48,'15',NULL,67,'Publish all official documents online in certified translations (multi-language)',NULL,1,'country',NULL,1,NULL),(49,'16',NULL,68,'Ensure uptake of online government by startups and scaleups',NULL,1,'startup',NULL,1,NULL),(50,'16',NULL,68,'Adopt “Digital by default” principle for startup clients and vendors.',NULL,1,'ecosys',NULL,1,NULL),(51,'17',NULL,69,'Adopt a target of widespread 1 Gbps access by 2025 and roll out the networks',NULL,1,'ec',NULL,1,NULL),(52,'17',NULL,69,'Adopt a target of widespread 1 Gbps access by 2025 and roll out the networks',NULL,1,'country',NULL,1,NULL),(53,'18',NULL,70,'Develop a single crossborder commercial contract including agreed definitions on dispute resolution, consumer protection, crossborder sales and other relevant points',NULL,1,'ec',NULL,1,NULL),(54,'18',NULL,70,'Adopt and implement the single crossborder commercial contract including agreed definitions on dispute resolution, consumer protection, crossborder sales and other relevant points',NULL,1,'country',NULL,1,NULL),(55,'18',NULL,70,'Use the unified contract, once it is available',NULL,1,'startup',NULL,1,NULL),(56,'19',NULL,71,'Propose a legislative initiative to harmonise the regulatory framework on business insolvency and allow for quick bankruptcy',NULL,1,'ec',NULL,1,NULL),(57,'19',NULL,71,'Adopt the 2014 Insolvency Recommendation, which would bring much needed transparency to balance sheets and make it easy for honest entrepreneurs to get a second start',NULL,1,'country',NULL,1,NULL),(58,'19',NULL,71,'Promote second chance entrepreneurship',NULL,1,'startup',NULL,1,NULL),(59,'20',NULL,72,'Provide guidelines on criteria, procedures and fees for “startup visas,” which will remain member-state competence; create a single point of contact for all EU member states.',NULL,1,'ec',NULL,1,NULL),(60,'21',NULL,73,'Set up a simple and transparent cross-border framework for crowdfunding\n',NULL,1,'ec',NULL,1,NULL),(61,'22',NULL,73,'Coordinate the alignment of national crowdfunding policies ',NULL,1,'ec',NULL,1,NULL),(62,'20',NULL,72,'Launch and/ harmonise existing startup visa programmes to facilitate investments in startups and scale-ups',NULL,1,'country',NULL,1,NULL),(63,'21',NULL,73,'Mutually recognise crowdfunding platforms, in particular if MiFID compliant',NULL,1,'country',NULL,1,NULL),(64,'20',NULL,72,'Hire the best you can get. Keep an eye out for talent',NULL,1,'startup',NULL,1,NULL),(65,'21',NULL,73,'National startup and business communities  should use crowdfunding as an alternative financing tool and promote awareness through trainings and best-practice promotion ',NULL,1,'startup',NULL,1,NULL),(66,'23',NULL,74,'Use European Commission “bully pulpit” to encourage national tax systems to allow more effective “attraction of talent” measures',NULL,1,'ec',NULL,1,NULL),(67,'23',NULL,74,'Introduce a tax regime allowing taxation of stock options upon execution',NULL,1,'country',NULL,1,NULL),(68,'23',NULL,74,'Use a stock/share option as an effective way to attract talent and reimburse top-performing employees',NULL,1,'startup',NULL,1,NULL),(69,'24',NULL,75,'Use European Commission “bully pulpit” to encourage national tax systems to neutralize the decision of debt v. equity',NULL,1,'ec',NULL,1,NULL),(70,'24',NULL,75,'Implement notional interest deductions ',NULL,1,'country',NULL,1,NULL),(71,'24',NULL,75,'Take advantage of new measures (when they come) to make better, smarter scale-up decisions.',NULL,1,'startup',NULL,1,NULL),(72,'25',NULL,76,'Use European Commission “bully pulpit” to encourage national governments to provide incentives for angel investment',NULL,1,'ec',NULL,1,NULL),(73,'25',NULL,76,'Adopt tax incentives to promote angel investment. The private sector should be encouraged to invest in promising businesses',NULL,1,'country',NULL,1,NULL),(74,'25',NULL,76,'Encourage and inform potential investors about possible tax advantage in angel investing. ',NULL,1,'startup',NULL,1,NULL),(75,'25',NULL,76,'Angel investors should be active and engaged, providing funding and mentorship at all stages of company life',NULL,1,'ecosys',NULL,1,NULL),(76,'26',NULL,77,'Make European Fund for Strategic Investments (EFSI) permanent ',NULL,1,'ec',NULL,1,NULL),(77,'27',NULL,78,'Develop the proposal for a pan-European venture capital funds-of-funds supported by EU funds \n',NULL,1,'ec',NULL,1,NULL),(78,'28',NULL,78,'Develop multi-country funds supported by the EU budget to mobilise private capital ',NULL,1,'ec',NULL,1,NULL),(79,'29',NULL,79,'Encourage pan- European high growth stock markets ',NULL,1,'ec',NULL,1,NULL),(80,'31',NULL,80,'Monitor payments in member states and provide benchmarking services\n',NULL,1,'ec',NULL,1,NULL),(81,'32',NULL,80,'Support member states in developing prompt payment policies',NULL,1,'ec',NULL,1,NULL),(82,'29',NULL,79,'Establish dedicated high growth segments on national stock market or alternative investment markets\n',NULL,1,'country',NULL,1,NULL),(83,'30',NULL,79,'Reduce entry costs and administrative requirements to a stock exchange entry for scaleups',NULL,1,'country',NULL,1,NULL),(84,'31',NULL,80,'Improve the public payment - an average time to pay an invoice in business to government transactions to be below 30 days in the country\n',NULL,1,'country',NULL,1,NULL),(85,'32',NULL,80,'Ensure full implementation of Late Payments directive, in particular by making redress measures easier and more accessible',NULL,1,'country',NULL,1,NULL),(86,'31',NULL,80,'Pay suppliers promptly',NULL,1,'startup',NULL,1,NULL),(87,'29',NULL,79,'Banks and accelerators to educate startups and scale-ups on stock market possibilities, Provide support and help to go public',NULL,1,'ecosys',NULL,1,NULL),(88,'31',NULL,80,'Large companies should set a good example and try to reach an average time to pay an invoice in business to business transactions below 30 days',NULL,1,'ecosys',NULL,1,NULL),(89,'33',NULL,81,'Support a coordinated tax wedge cut in all 28 EU member states',NULL,1,'ec',NULL,1,NULL),(90,'33',NULL,81,'Implement a coordinated tax-wedge cut on labour costs and bring it in line with OECD average. Countries that don’t have them should adopt first-hire incentives',NULL,1,'country',NULL,1,NULL),(91,'34',NULL,82,'Member state governments should fund or subsidise training vouchers, facilitating the training of young people in successful scale ups without creating additional financial burden for the startups',NULL,1,'country',NULL,1,NULL),(92,'34',NULL,82,'Startups and scale-ups should hire or train at least one employee in 2017',NULL,1,'startup',NULL,1,NULL),(93,'35',NULL,83,'Recognise the concept of remote hiring and set up a framework to facilitate European legislation changes',NULL,1,'ec',NULL,1,NULL),(94,'35',NULL,83,'Introduce a “knowledge worker visa” with the same eligibility requirement as the EU blue card. ',NULL,1,'country',NULL,1,NULL),(95,'36',NULL,84,'Adopt the new Blue Card scheme\n',NULL,1,'ec',NULL,1,NULL),(96,'36',NULL,84,'Implement the Blue Card directive effectively in the country',NULL,1,'country',NULL,1,NULL),(97,'37',NULL,85,'Make all public data available for innovative new businesses and services',NULL,1,'ec',NULL,1,NULL),(98,'37',NULL,85,'Make all public data available for innovative new businesses and services',NULL,1,'country',NULL,1,NULL),(99,'37',NULL,85,'Develop innovative new businesses and services with open data',NULL,1,'startup',NULL,1,NULL),(100,'38',NULL,86,'Provide guidelines on sandboxes and other experimental policy-making tools; include sandbox evaluations in impact assessments',NULL,1,'ec',NULL,1,NULL),(101,'38',NULL,86,'Use sandboxes and other experimental policy-making tools',NULL,1,'country',NULL,1,NULL),(102,'38',NULL,86,'Take an active role in sandbox experiments and consultations.',NULL,1,'startup',NULL,1,NULL),(103,'39',NULL,87,'Involve startups throughout the funding cycle\n',NULL,1,'ec',NULL,1,NULL),(104,'40',NULL,87,'Adopt a percentage of new beneficiaries for R&I funding instruments\n',NULL,1,'ec',NULL,1,NULL),(105,'39',NULL,87,'Report startups involvement throughout the funding cycle\n',NULL,1,'country',NULL,1,NULL),(106,'40',NULL,87,'Adopt a percentage of new beneficiaries for R&I funding instruments\n',NULL,1,'country',NULL,1,NULL),(107,'39',NULL,87,'Educate yourselves on all of the options available to you and participate as and where appropriate ',NULL,1,'startup',NULL,1,NULL),(108,'39',NULL,87,'Large companies to invite startups and SMEs to consortia for public funding',NULL,1,'ecosys',NULL,1,NULL),(109,'41',NULL,88,'Adopt multi-stage and fail-fast measures in funding programmes',NULL,1,'ec',NULL,1,NULL),(110,'41',NULL,88,'Adopt multi-stage and fail-fast measures in the funding programmes',NULL,1,'country',NULL,1,NULL),(111,'42',NULL,89,'Simplify procedures and make them consistent across different instruments (H2020 and Structural Funds)',NULL,1,'ec',NULL,1,NULL),(112,'42',NULL,89,'Simplify procedures and make them consistent across different instruments (H2020 and Structural Funds)',NULL,1,'country',NULL,1,NULL),(113,'43',NULL,90,'Initiate new European public procurement monitoring tool\n',NULL,1,'ec',NULL,1,NULL),(114,'44',NULL,90,'Report percent of procurement from startups and scale-ups on a yearly basis ',NULL,1,'ec',NULL,1,NULL),(115,'43',NULL,90,'Devote 3% of the budget to procurement of R&D and 20% of innovative products and services \n',NULL,1,'country',NULL,1,NULL),(116,'44',NULL,90,'Report percent of procurement from startups and scale-ups on a yearly basis',NULL,1,'country',NULL,1,NULL),(117,'43',NULL,90,'Participate in public procurement',NULL,1,'startup',NULL,1,NULL),(118,'43',NULL,90,'Large companies to invite startups and SMEs to consortia for public tendering',NULL,1,'ecosys',NULL,1,NULL),(119,'45',NULL,91,'Develop a common EU approach to innovative business model, based on “banning as last resort”',NULL,1,'ec',NULL,1,NULL),(120,'45',NULL,91,'Adopt a “banning as last resort” approach, with full justification',NULL,1,'country',NULL,1,NULL),(121,'45',NULL,91,'Take part in dialogue with EU and national regulators',NULL,1,'startup',NULL,1,NULL),(122,'45',NULL,91,'Associations and stakeholders support and engage in policy dialogue',NULL,1,'ecosys',NULL,1,NULL),(123,'46',NULL,92,'Devote funding quota to corporate-startup collaboration\n',NULL,1,'ec',NULL,1,NULL),(124,'46',NULL,92,'Devote funding quota to corporate-startup collaboration\n',NULL,1,'country',NULL,1,NULL),(125,'47',NULL,93,'Continue to support and expand EU-wide initiatives such as Startup Europe Partnership that facilitate collaboration between corporates and startups \n',NULL,1,'ec',NULL,1,NULL),(126,'48',NULL,93,'Support national adaptation of SEP',NULL,1,'ec',NULL,1,NULL),(127,'47',NULL,93,'Replicate and adopt startup Europe partnerships on the national level. Encourage the participation of leading large and medium-sized corporations in matchmaking initiatives',NULL,1,'country',NULL,1,NULL),(128,'47',NULL,93,'Take part in matchmaking initiatives',NULL,1,'startup',NULL,1,NULL),(129,'47',NULL,93,'Large and medium-sized companies should take part in matchmaking initiatives',NULL,1,'ecosys',NULL,1,NULL),(130,'49',NULL,94,'Develop European Framework for practical entrepreneurial education (Erasmus for Entrepreneurs version for students)',NULL,1,'ec',NULL,1,NULL),(131,'49',NULL,94,'Introduce courses / activities aimed at enhancing entrepreneurship skills as a part of the core curriculum in a primary and a secondary education system (e.g. willingness to take risks, ability and willingness to take initiative)\n',NULL,1,'country',NULL,1,NULL),(132,'49',NULL,94,'Schools to introduce entrepreneurship education activities in connection with existing initiatives\n',NULL,1,'ecosys',NULL,1,NULL),(133,'50',NULL,95,'Launch initiatives connecting teachers with business leaders such as funders4school in UK \n',NULL,1,'country',NULL,1,NULL),(134,'51',NULL,95,'Launch initiatives to promote and recognize entrepreneurial activity by researchers, including career mechanisms',NULL,1,'country',NULL,1,NULL),(135,'50',NULL,95,'Participate in initiatives such as founders4schools',NULL,1,'startup',NULL,1,NULL),(136,'50',NULL,95,'Universities to promote and support entrepreneurship by researchers',NULL,1,'ecosys',NULL,1,NULL),(137,'52',NULL,96,'ICT as a part of the core curriculum\n',NULL,1,'country',NULL,1,NULL),(138,'53',NULL,96,'National initiatives to teach coding in school\n',NULL,1,'country',NULL,1,NULL),(139,'52',NULL,96,'Participate in teaching coding in schools',NULL,1,'startup',NULL,1,NULL),(140,'52',NULL,96,'Schools to organize collaboration with startups',NULL,1,'ecosys',NULL,1,NULL),(141,'54',NULL,97,'National initiatives to train teachers in ICT',NULL,1,'country',NULL,1,NULL),(142,'55',NULL,103,'Develop a European Framework for inter-operablity and recognition of informal learning, and professional certifications ',NULL,1,'ec',NULL,1,NULL),(143,'55',NULL,103,'Put in place national arrangements for validation of informal and informal learning in line with The 2012 Council recommendation and revised guidelines of 2015',NULL,1,'country',NULL,1,NULL),(144,'56',NULL,99,'Establish EU networks for training for scale-ups ',NULL,1,'ec',NULL,1,NULL),(145,'56',NULL,99,'Establish national networks for training for scale-ups ',NULL,1,'country',NULL,1,NULL),(146,'56',NULL,99,'Offer places for vocational trainings / Erasmus  candidates',NULL,1,'startup',NULL,1,NULL),(147,'56',NULL,99,'Universities to provide dedicated training for scale-ups',NULL,1,'ecosys',NULL,1,NULL),(148,'57',NULL,100,'Launch an annual survey and on-the-ground, open, collaborative monitoring, providing scores for each national government and for the EU ',NULL,1,'ec',NULL,1,NULL),(149,'57',NULL,100,'Provide input in the annual monitoring',NULL,1,'country',NULL,1,NULL),(150,'57',NULL,100,'Provide input in the annual monitoring',NULL,1,'startup',NULL,1,NULL),(151,'58',NULL,101,'Set up an observatory or  think tank to continue exploring scale-up issues',NULL,1,'ec',NULL,1,NULL),(152,'58',NULL,101,'Contribute to the think tank activities',NULL,1,'country',NULL,1,NULL),(153,'58',NULL,101,'Contribute to the think tank activities',NULL,1,'startup',NULL,1,NULL),(154,'59',NULL,102,'Convene an annual meeting of the European Startup Network and other startup leaders with high-level input and patronage',NULL,1,'ec',NULL,1,NULL),(155,'59',NULL,102,'Send high-level delegations of policymakers and decision makers to the meeting (director general level). ',NULL,1,'country',NULL,1,NULL),(156,'59',NULL,102,'Send CEOs and other senior representatives (not just marketing managers or lobbyists) ',NULL,1,'startup',NULL,1,NULL),(157,'59',NULL,102,'Come with an open mind, to speak and to listen',NULL,1,'ecosys',NULL,1,NULL);
/*!40000 ALTER TABLE `indicator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `log_access`
--

LOCK TABLES `log_access` WRITE;
/*!40000 ALTER TABLE `log_access` DISABLE KEYS */;
INSERT INTO `log_access` VALUES (1,1,'2016-12-22 19:47:01','78.15.242.140'),(2,1,'2016-12-23 00:42:43','78.15.242.140'),(3,1,'2016-12-23 00:46:07','78.15.242.140'),(4,39,'2017-01-10 10:30:59','213.73.37.103'),(5,1,'2017-01-10 10:40:08','46.253.162.226'),(6,1,'2017-01-11 12:40:28','46.253.162.226'),(7,39,'2017-01-11 12:57:41','213.73.37.103'),(8,39,'2017-01-11 14:26:02','213.73.37.103'),(9,39,'2017-01-11 15:32:12','213.73.37.103'),(10,39,'2017-01-11 16:10:14','213.73.37.103'),(11,39,'2017-01-11 16:11:11','213.73.37.103'),(12,39,'2017-01-11 16:12:15','213.73.37.103'),(13,39,'2017-01-11 16:16:51','213.73.37.103');
/*!40000 ALTER TABLE `log_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `ms_form`
--

LOCK TABLES `ms_form` WRITE;
/*!40000 ALTER TABLE `ms_form` DISABLE KEYS */;
INSERT INTO `ms_form` VALUES (40,100,1,95,'In June 2016, the Commission proposed to reform the EU Blue Card to better attract highly-qualified third-country national workers.\r\n\r\nhttps://ec.europa.eu/home-affairs/sites/homeaffairs/files/what-we-do/policies/european-agenda-migration/background-information/docs/20160607/factsheet_revision_eu_blue_card_en.pdf','2017-01-11 14:34:07',39,0),(41,1,1,131,'Entrepreneurship education is part of the curricula of schools and colleges teaching technical subjects and business administration, of part-time vocational schools for apprentices, of schools and colleges of tourism, and of colleges of agriculture and forestry. So all VET schools and colleges include some entrepreneurship component in the curriculum. In some college curricula, entrepreneurship and management is a specialist subject area. http://ec.europa.eu/enterprise/policies/sme/files/smes/vocational/entr_voca_en.pdf http://www.cedefop.europa.eu/en/publications-and-resources/country-reports/austria-vet-europe-country-report-2012','2017-01-11 16:26:27',39,0);
/*!40000 ALTER TABLE `ms_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `ms_gen_info`
--

LOCK TABLES `ms_gen_info` WRITE;
/*!40000 ALTER TABLE `ms_gen_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_gen_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `vars`
--

LOCK TABLES `vars` WRITE;
/*!40000 ALTER TABLE `vars` DISABLE KEYS */;
INSERT INTO `vars` VALUES ('label_action','action','actions'),('label_area','priority','priorities'),('label_country','country','countries'),('label_indicator','measure','measures');
/*!40000 ALTER TABLE `vars` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-12 16:24:55
