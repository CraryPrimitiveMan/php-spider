CREATE DATABASE IF NOT EXISTS `spider` DEFAULT CHARSET utf8 COLLATE utf8_general_ci;

use `spider`;

DROP TABLE IF EXISTS `github`;

CREATE TABLE IF NOT EXISTS `github` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `avatar` varchar(120) NOT NULL DEFAULT '',
  `fullname` varchar(80) NOT NULL DEFAULT '',
  `username` varchar(40) NOT NULL DEFAULT '',
  `email` varchar(40) NOT NULL DEFAULT '',
  `works_for` varchar(40) NOT NULL DEFAULT '',
  `home_location` varchar(20) NOT NULL DEFAULT '',
  `blog_url` varchar(100) NOT NULL DEFAULT '',
  `join_date` int(11) NOT NULL,
  `url` varchar(100) NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniquename` (`username`)
) ENGINE=InnoDB;
