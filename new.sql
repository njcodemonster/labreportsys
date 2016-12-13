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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`jeftest_labreportsys` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `jeftest_labreportsys`;

/*Table structure for table `auth_ips` */

DROP TABLE IF EXISTS `auth_ips`;

CREATE TABLE `auth_ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_id` int(11) DEFAULT NULL,
  `ip` varchar(250) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `auth_ips` */

insert  into `auth_ips`(`id`,`lab_id`,`ip`,`ts`) values (1,1,'::1','2016-06-23 17:03:24'),(2,4,'::1','2016-12-05 17:20:52'),(3,5,'::1','2016-12-08 16:11:55'),(4,6,'::1','2016-12-08 16:15:49'),(5,7,'::1','2016-12-08 16:30:28');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `labs` */

insert  into `labs`(`lab_id`,`name`,`description`,`phone`,`contact_person`,`keypass`,`passcode`,`timestamp`) values (1,'Test lab',NULL,'0000000000','CEO','6dde1e8317ab07d722c02b3bdba8d5a4','1234','2016-06-23 16:19:18'),(2,'Test lab',NULL,'0000100000','CEO','3d970e724debcd391803098afb91cba1','1234','2016-06-23 16:54:48'),(3,'Test lab',NULL,'00010100000','CEO','a2b59c02cda02344ea53600bc117f751','1234','2016-06-23 17:03:24'),(4,'Test ABC',NULL,'123456','adb@gmail.com','0140a4c3b6b5979e87272029bb54d8e5','1234','2016-12-05 17:20:52'),(5,'Test ABCD',NULL,'123456','adb321@gmail.com','d3df06f7f058081d01c5e16597bbca76','1234','2016-12-08 16:11:54'),(6,'Test 123',NULL,'123456','adb@gmail.com','7adef3b3e2b35048bd75ce7d03189a06','1234','2016-12-08 16:15:49'),(7,'Test 1234',NULL,'123456','adb@gmail.com','62b0de5729519137fdc1d9494db11dd4','1234','2016-12-08 16:30:28');

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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

/*Data for the table `patients` */

insert  into `patients`(`p_id`,`lab_id`,`name`,`phone`,`nic`,`email`,`timestemp`) values (1,NULL,'Patient 1','123456',NULL,'adb1@gmail.com','2016-06-25 14:48:30'),(2,NULL,'Patient 2','987654',NULL,'adb2@gmail.com','2016-06-25 14:53:35'),(3,NULL,'Patient 3','765432',NULL,'adb3@gmail.com','2016-06-25 14:53:50'),(4,NULL,'Patient 4','654321',NULL,'adb4@gmail.com','2016-06-25 14:54:48'),(5,NULL,'Patient 5','121212',NULL,'adb5@gmail.com','2016-06-25 14:54:50'),(6,NULL,'Patient 6','424242',NULL,'adb6@gmail.com','2016-06-25 14:57:50'),(7,NULL,'Patient 7','515151',NULL,'adb7@gmail.com','2016-06-25 14:57:53'),(8,NULL,'Patient 8','919191',NULL,'adb8@gmail.com','2016-06-27 13:01:53'),(46,NULL,'abc','090909',NULL,'test@gmail.com','2016-12-08 15:31:09'),(47,NULL,'abcd','090909',NULL,'test@gmail.com','2016-12-08 15:31:49'),(48,NULL,'testing','090909',NULL,'test@gmail.com','2016-12-08 17:13:53');

/*Table structure for table `reports` */

DROP TABLE IF EXISTS `reports`;

CREATE TABLE `reports` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) DEFAULT NULL,
  `document_url` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `reports` */

insert  into `reports`(`type_id`,`p_id`,`document_url`,`timestamp`) values (1,1,'14671099105577252166cf1e.docx','2016-06-28 15:31:50'),(4,1,'14811931985584936eeb14dd.docx','2016-12-08 15:33:18'),(5,1,'148119334355849377f9cd41.docx','2016-12-08 15:35:43'),(6,46,'14811934705584937fe8e630.docx','2016-12-08 15:37:50'),(7,46,'14811937005584938e4410d9.docx','2016-12-08 15:41:40'),(8,1,'14812038935584960b59c389.docx','2016-12-08 18:31:33'),(9,1,'148120407555849616b0ff9f.docx','2016-12-08 18:34:35');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `reports_names` */

insert  into `reports_names`(`report_id`,`report_name`,`description`,`type`,`cost`,`type_id`,`lab_id`,`timestamp`) values (1,'My Report',NULL,NULL,NULL,1,1,'2016-06-28 15:31:50'),(4,'My First Report',NULL,NULL,NULL,4,1,'2016-12-08 15:33:18'),(5,'My First Report',NULL,NULL,NULL,5,1,'2016-12-08 15:35:43'),(6,'My First Report',NULL,NULL,NULL,6,1,'2016-12-08 15:37:50'),(7,'My First Report',NULL,NULL,NULL,7,1,'2016-12-08 15:41:40'),(8,NULL,NULL,NULL,NULL,8,1,'2016-12-08 18:31:33'),(9,NULL,NULL,NULL,NULL,9,1,'2016-12-08 18:34:35');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
