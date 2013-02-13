# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.44)
# Database: sc_db
# Generation Time: 2013-02-13 23:38:04 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table sc_activities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sc_activities`;

CREATE TABLE `sc_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `author` bigint(20) unsigned DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content` longtext CHARACTER SET utf8,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` varchar(20) CHARACTER SET utf8 DEFAULT 'message',
  `comment_count` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table sc_login_attempts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sc_login_attempts`;

CREATE TABLE `sc_login_attempts` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `time` varchar(30) DEFAULT '',
  `user_id` bigint(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table sc_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sc_users`;

CREATE TABLE `sc_users` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(265) NOT NULL DEFAULT '',
  `birthday` date DEFAULT NULL,
  `role` varchar(10) DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
