/*
SQLyog Community v9.51 
MySQL - 5.5.16-log : Database - hcmfbapp
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminID` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `reseller` varchar(255) NOT NULL DEFAULT '',
  `dated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `admin` */

insert  into `admin`(`id`,`adminID`,`password`,`reseller`,`dated`) values (3,'admin','0c6387b11e133b6b','','0000-00-00 00:00:00');

/*Table structure for table `answers` */

DROP TABLE IF EXISTS `answers`;

CREATE TABLE `answers` (
  `a_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `a_fbid` varchar(255) DEFAULT NULL,
  `a_answer` text,
  `a_active` varchar(10) DEFAULT 'checked',
  `a_qid` int(11) DEFAULT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `answers` */

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `p_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `p_type` varchar(255) DEFAULT NULL,
  `p_fbid` varchar(255) DEFAULT NULL,
  `p_dated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `p_postfbid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `posts` */

/*Table structure for table `questions` */

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `q_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `q_to` varchar(255) DEFAULT NULL,
  `q_question` text,
  `q_dateposted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `q_postfbid` varchar(255) DEFAULT NULL,
  `q_email` varchar(255) DEFAULT NULL,
  `q_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`q_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `questions` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
