/*
SQLyog Ultimate v11.5 (64 bit)
MySQL - 5.6.26 : Database - 7c_report
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `auth_ips` */

DROP TABLE IF EXISTS `auth_ips`;

CREATE TABLE `auth_ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lab_id` int(11) DEFAULT NULL,
  `ip` varchar(250) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `auth_ips` */

insert  into `auth_ips`(`id`,`lab_id`,`ip`,`ts`) values (1,0,'::1','2016-06-23 17:03:24');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `labs` */

insert  into `labs`(`lab_id`,`name`,`description`,`phone`,`contact_person`,`keypass`,`passcode`,`timestamp`) values (1,'Test lab',NULL,'0000000000','CEO','6dde1e8317ab07d722c02b3bdba8d5a4','1234','2016-06-23 16:19:18'),(2,'Test lab',NULL,'0000100000','CEO','3d970e724debcd391803098afb91cba1','1234','2016-06-23 16:54:48'),(3,'Test lab',NULL,'00010100000','CEO','a2b59c02cda02344ea53600bc117f751','1234','2016-06-23 17:03:24');

/*Table structure for table `patients` */

DROP TABLE IF EXISTS `patients`;

CREATE TABLE `patients` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `timestemp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `patients` */

insert  into `patients`(`p_id`,`name`,`phone`,`email`,`timestemp`) values (1,'Patient ABC','123456','adb@gmail.com','2016-06-25 14:48:30'),(2,NULL,'123456','adb@gmail.com','2016-06-25 14:53:35'),(3,NULL,'123456','adb@gmail.com','2016-06-25 14:53:50'),(4,NULL,'123456','adb@gmail.com','2016-06-25 14:54:48'),(5,NULL,'123456','adb@gmail.com','2016-06-25 14:54:50'),(6,NULL,'123456','adb@gmail.com','2016-06-25 14:57:50'),(7,NULL,'123456','adb@gmail.com','2016-06-25 14:57:53');

/*Table structure for table `reports` */

DROP TABLE IF EXISTS `reports`;

CREATE TABLE `reports` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) DEFAULT NULL,
  `document_url` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `reports` */

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `reports_names` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
