/*
SQLyog Ultimate v10.42 
MySQL - 5.5.5-10.1.13-MariaDB : Database - 7c_report
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`jeftest2_lab_db` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `jeftest2_lab_db`;

/*Table structure for table `auth_ips` */

DROP TABLE IF EXISTS `auth_ips`;

CREATE TABLE `auth_ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_id` int(11) DEFAULT NULL,
  `ip` varchar(250) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `auth_ips` */

insert  into `auth_ips`(`id`,`lab_id`,`ip`,`ts`) values (1,1,'::1','2016-06-23 17:03:24'),(2,4,'::1','2016-12-05 17:20:52'),(3,5,'::1','2016-12-08 16:11:55'),(4,6,'::1','2016-12-08 16:15:49'),(5,7,'::1','2016-12-08 16:30:28'),(6,8,'::1','2016-12-13 17:54:32'),(7,9,'::1','2016-12-13 18:39:08'),(8,10,'::1','2016-12-13 18:42:36'),(9,11,'::1','2016-12-13 18:51:23'),(10,12,'::1','2016-12-13 19:04:48'),(11,13,'::1','2016-12-13 19:05:26'),(12,14,'::1','2016-12-13 19:06:06'),(13,15,'::1','2016-12-13 19:08:31'),(14,16,'::1','2016-12-13 19:09:32'),(15,17,'::1','2016-12-13 19:19:26'),(16,18,'::1','2016-12-15 14:41:27');

/*Table structure for table `labs` */

DROP TABLE IF EXISTS `labs`;

CREATE TABLE `labs` (
  `lab_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `phone` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `keypass` text,
  `passcode` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`lab_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `labs` */

insert  into `labs`(`lab_id`,`name`,`description`,`phone`,`contact_person`,`keypass`,`passcode`,`timestamp`) values (1,'Test lab',NULL,'0000000000','CEO','6dde1e8317ab07d722c02b3bdba8d5a4','1234','2016-06-23 16:19:18'),(2,'Test lab',NULL,'0000100000','CEO','3d970e724debcd391803098afb91cba1','1234','2016-06-23 16:54:48'),(3,'Test lab',NULL,'00010100000','CEO','a2b59c02cda02344ea53600bc117f751','1234','2016-06-23 17:03:24'),(4,'Test ABC',NULL,'123456','adb@gmail.com','0140a4c3b6b5979e87272029bb54d8e5','1234','2016-12-05 17:20:52'),(5,'Test ABCD',NULL,'123456','adb321@gmail.com','d3df06f7f058081d01c5e16597bbca76','1234','2016-12-08 16:11:54'),(6,'Test 123',NULL,'123456','adb@gmail.com','7adef3b3e2b35048bd75ce7d03189a06','1234','2016-12-08 16:15:49'),(7,'Test 1234',NULL,'123456','adb@gmail.com','62b0de5729519137fdc1d9494db11dd4','1234','2016-12-08 16:30:28'),(8,'Test 123456',NULL,'123456','adb@gmail.com','6e28592204960a33c55df4a0812cb3a4','1234','2016-12-13 17:54:32'),(9,'Test 1234343',NULL,'123456','adb@gmail.com','8ce67fba5035411f54e74db41c954e0a','123456','2016-12-13 18:39:08'),(10,NULL,NULL,'123456','adb@gmail.com','d1109ce4553067de3975a9b55c08f402','1234','2016-12-13 18:42:36'),(11,'Testinggg',NULL,'123456','adb@gmail.com','f71ea987a6de2534859bad61c506249b','1234','2016-12-13 18:51:23'),(12,'Test 100',NULL,'123456','adb@gmail.com','bc0662867d09bf673e3774b43f90f3e4','1234','2016-12-13 19:04:48'),(13,'Test 1000',NULL,'123456','adb@gmail.com','847cfcec9cf78dd9cbf0dec71ac84851','1234','2016-12-13 19:05:26'),(14,'Test 123',NULL,'1234564324','adb@gmail.com','dffb8fc140ab340b37d0e839a6cb813d','1234','2016-12-13 19:06:05'),(15,'Test 1230909',NULL,'123456','adb@gmail.com','5ea6332a159e9eefd8b00b447166b7a9','1234','2016-12-13 19:08:31'),(16,'Test 123',NULL,'10101010','adb@gmail.com','b636fd739bb614bd17bb25210c68bed0','1234','2016-12-13 19:09:32'),(17,'Test 1232020',NULL,'12345654321','adb@gmail.com','edb55bb5fb3b7df1ef93c3a626c33ed3','123499','2016-12-13 19:19:26'),(18,'RZA 123',NULL,'123456','adb@gmail.com','5f40c48afd104bd2f73412783de3b4c9','1234','2016-12-15 14:41:27');

/*Table structure for table `patients` */

DROP TABLE IF EXISTS `patients`;

CREATE TABLE `patients` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `nic` varchar(16) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `timestemp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

/*Data for the table `patients` */

insert  into `patients`(`p_id`,`lab_id`,`name`,`phone`,`nic`,`email`,`timestemp`) values (1,NULL,'Patient 1','123456',NULL,'adb1@gmail.com','2016-06-25 14:48:30'),(2,NULL,'Patient 2','987654',NULL,'adb2@gmail.com','2016-06-25 14:53:35'),(3,NULL,'Patient 3','765432',NULL,'adb3@gmail.com','2016-06-25 14:53:50'),(4,NULL,'Patient 4','654321',NULL,'adb4@gmail.com','2016-06-25 14:54:48'),(5,NULL,'Patient 5','121212',NULL,'adb5@gmail.com','2016-06-25 14:54:50'),(6,NULL,'Patient 6','424242',NULL,'adb6@gmail.com','2016-06-25 14:57:50'),(7,NULL,'Patient 7','515151',NULL,'adb7@gmail.com','2016-06-25 14:57:53'),(8,NULL,'Patient 8','919191',NULL,'adb8@gmail.com','2016-06-27 13:01:53'),(49,NULL,'abc','090909',NULL,'test@gmail.com','2016-12-13 19:23:25'),(50,NULL,NULL,'090909',NULL,'test@gmail.com','2016-12-13 19:24:34'),(51,NULL,'abc','090909',NULL,NULL,'2016-12-13 19:37:26'),(52,NULL,'abcd','090909',NULL,'test@gmail.com','2016-12-13 19:43:00'),(53,NULL,'abc','101010',NULL,'test@gmail.com','2016-12-13 19:44:57'),(54,NULL,'abc_xyz','090909',NULL,'test@gmail.com','2016-12-16 15:52:25'),(55,NULL,'abcd','101010',NULL,'majid.7ctech@gmail.com','2016-12-16 16:53:51');

/*Table structure for table `reports` */

DROP TABLE IF EXISTS `reports`;

CREATE TABLE `reports` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) DEFAULT NULL,
  `document_url` text,
  `document_hash` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

/*Data for the table `reports` */

insert  into `reports`(`type_id`,`p_id`,`document_url`,`document_hash`,`timestamp`) values (31,55,'55_1481890169.docx','09c17d8832c6125e69ffa4eca39ceb3d','2016-12-16 17:09:29'),(32,55,'55_1481890187.docx','29e5760910d624ed50ae90bffc4ba66f','2016-12-16 17:09:47');

/*Table structure for table `reports_names` */

DROP TABLE IF EXISTS `reports_names`;

CREATE TABLE `reports_names` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `report_name` varchar(255) DEFAULT NULL,
  `description` text,
  `type` varchar(255) DEFAULT NULL,
  `cost` varchar(255) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

/*Data for the table `reports_names` */

insert  into `reports_names`(`report_id`,`report_name`,`description`,`type`,`cost`,`type_id`,`lab_id`,`timestamp`) values (1,'My Report',NULL,NULL,NULL,1,1,'2016-06-28 15:31:50'),(10,'My First Report',NULL,NULL,NULL,10,1,'2016-12-13 19:37:26'),(11,'My First Report',NULL,NULL,NULL,11,1,'2016-12-13 19:40:19'),(12,'My First Report',NULL,NULL,NULL,12,1,'2016-12-13 19:50:25'),(13,'My First Report',NULL,NULL,NULL,13,1,'2016-12-13 19:54:25'),(14,'My First Report',NULL,NULL,NULL,14,1,'2016-12-16 15:38:02'),(15,'My First Report',NULL,NULL,NULL,15,1,'2016-12-16 15:38:51'),(16,'My First Report',NULL,NULL,NULL,16,1,'2016-12-16 15:39:25'),(17,'My First Report',NULL,NULL,NULL,17,1,'2016-12-16 15:50:10'),(18,'My First Reporttt',NULL,NULL,NULL,18,1,'2016-12-16 15:52:25'),(19,'My Report12',NULL,NULL,NULL,19,1,'2016-12-16 16:54:33'),(20,'My Report12',NULL,NULL,NULL,20,1,'2016-12-16 16:56:19'),(21,'My Report12',NULL,NULL,NULL,21,1,'2016-12-16 16:57:25'),(22,'My Report12',NULL,NULL,NULL,22,1,'2016-12-16 16:59:11'),(23,'My Report12',NULL,NULL,NULL,23,1,'2016-12-16 16:59:45'),(24,'My Report12',NULL,NULL,NULL,24,1,'2016-12-16 17:00:03'),(25,'My Report12',NULL,NULL,NULL,25,1,'2016-12-16 17:00:55'),(26,'My Report12',NULL,NULL,NULL,26,1,'2016-12-16 17:01:50'),(27,'My Report12',NULL,NULL,NULL,27,1,'2016-12-16 17:05:26'),(28,'My Report12',NULL,NULL,NULL,28,1,'2016-12-16 17:05:51'),(29,'My Report12',NULL,NULL,NULL,29,1,'2016-12-16 17:06:28'),(30,'My Report12',NULL,NULL,NULL,30,1,'2016-12-16 17:08:21'),(31,'My Report12',NULL,NULL,NULL,31,1,'2016-12-16 17:09:29'),(32,'My Report12',NULL,NULL,NULL,32,1,'2016-12-16 17:09:47');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
