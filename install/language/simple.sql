SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `auctions` (
`id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `due` date NOT NULL,
  `val` decimal(10,0) NOT NULL,
  `gval` decimal(10,0) NOT NULL,
  `ival` decimal(10,0) NOT NULL,
  `user` int(11) NOT NULL,
  `info` varchar(100) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1 - selling, 2 - biding, 3 - bought, 4 - cancelled',
  `buyer` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='data will be remove within 12 days.';

CREATE TABLE IF NOT EXISTS `blog_posts` (
`id` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `body` longtext NOT NULL,
  `date` date NOT NULL,
  `user` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `countries` (
`id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=243 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `friends` (
  `user_id_1` int(11) NOT NULL,
  `user_id_2` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_in` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `items` (
`id` int(11) NOT NULL,
  `img` longtext NOT NULL,
  `name` varchar(200) NOT NULL,
  `desc` longtext NOT NULL,
  `type` int(11) NOT NULL,
  `value_min` decimal(9,2) NOT NULL,
  `value_max` decimal(9,2) NOT NULL,
  `momentum` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `item_type` (
`id` int(11) NOT NULL,
  `label` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `navigation` (
  `pageid` int(200) NOT NULL,
  `label` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `url` varchar(300) NOT NULL,
  `position` int(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `pages` (
`id` mediumint(9) NOT NULL,
  `header` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `label` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `body` mediumtext COLLATE utf8_spanish2_ci NOT NULL,
  `user` int(11) NOT NULL,
  `slug` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  `type` mediumint(9) NOT NULL DEFAULT '1' COMMENT '1page,2blog,3list,4register,5error',
  `on_field_editable` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE IF NOT EXISTS `post_types` (
`id` mediumint(9) NOT NULL,
  `name` mediumtext COLLATE utf8_spanish2_ci NOT NULL,
  `label` mediumtext COLLATE utf8_spanish2_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE IF NOT EXISTS `reports` (
`id` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `desc` varchar(300) NOT NULL,
  `comment` int(11) NOT NULL,
  `auction` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `settings` (
  `id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `label` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `value` varchar(300) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE IF NOT EXISTS `users` (
`id` mediumint(9) NOT NULL,
  `nickname` mediumtext NOT NULL,
  `email` mediumtext NOT NULL,
  `location` int(100) NOT NULL DEFAULT '0',
  `name` mediumtext NOT NULL,
  `profile_summary` varchar(300) DEFAULT NULL,
  `level` int(3) NOT NULL DEFAULT '0',
  `password` longtext NOT NULL,
  `permissions` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


ALTER TABLE `auctions`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `blog_posts`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `countries`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `items`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`), ADD KEY `type` (`type`), ADD KEY `type_2` (`type`);

ALTER TABLE `item_type`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `navigation`
 ADD UNIQUE KEY `pageid` (`pageid`);

ALTER TABLE `pages`
 ADD PRIMARY KEY (`id`), ADD KEY `type` (`type`), ADD KEY `on_field_editable` (`on_field_editable`);

ALTER TABLE `post_types`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `reports`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);


ALTER TABLE `auctions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `blog_posts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `countries`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `item_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pages`
MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;
ALTER TABLE `post_types`
MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;
ALTER TABLE `reports`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users`
MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;