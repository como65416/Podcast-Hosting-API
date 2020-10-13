CREATE DATABASE  `podcast_host`;

USE `podcast_host`;

DROP TABLE IF EXISTS `channel`;
CREATE TABLE `channel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `deleted_at` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `__member_id__index` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `channel_id` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `audio_path` varchar(200) NOT NULL DEFAULT '',
  `publish_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `deleted_at` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `__channel_id__index` (`channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(30) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(30) NOT NULL DEFAULT '',
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `__account__unique` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
