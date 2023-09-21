/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : myproject

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2017-01-06 20:25:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ads`
-- ----------------------------
DROP TABLE IF EXISTS `ads`;
CREATE TABLE `ads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ads
-- ----------------------------
INSERT INTO `ads` VALUES ('1', 'sadasd', 'pak.gif', 'www.dsdfsdf.com', '20170102125324-pak.gif', '2017-01-02 12:53:24', '2017-01-02 12:53:24', null);
INSERT INTO `ads` VALUES ('3', 'dsf', 'pak.gif', 'www.dfdfsdfsdf.com', '20170102130622-pak.gif', '2017-01-02 13:06:22', '2017-01-02 13:06:22', null);

-- ----------------------------
-- Table structure for `announcements`
-- ----------------------------
DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `long_description` text COLLATE utf8_unicode_ci,
  `banner_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_image_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `featured` tinyint(1) unsigned NOT NULL,
  `published` tinyint(1) unsigned NOT NULL,
  `sub_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of announcements
-- ----------------------------
INSERT INTO `announcements` VALUES ('1', 'Mr', '<p>fdsfsdafsdf</p>', '<p>sdfsdafsdf</p>', 'pak.gif', '20170102121144-pak.gif', null, null, '2017-01-02', 'Lahore', 'www.announcement.com', '2017-01-02 12:11:44', '2017-01-02 12:11:44', null, '1', '1', 'dr');
INSERT INTO `announcements` VALUES ('2', 'Mr', '<p>fdsfsdafsdf</p>', '<p>sdfsdafsdf</p>', 'pak.gif', '20170102121159-pak.gif', null, null, '2017-01-02', 'Lahore', 'www.announcement.com', '2017-01-02 12:11:59', '2017-01-02 12:11:59', null, '1', '1', 'dr');
INSERT INTO `announcements` VALUES ('3', 'Mr', '<p>fdsfsdafsdf</p>', '<p>sdfsdafsdf</p>', 'pak.gif', '20170102121214-pak.gif', null, null, '2017-01-02', 'Lahore', 'www.announcement.com', '2017-01-02 12:12:14', '2017-01-02 12:12:14', null, '1', '1', 'dr');

-- ----------------------------
-- Table structure for `banners`
-- ----------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sequence` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banner_type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text COLLATE utf8_unicode_ci,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of banners
-- ----------------------------
INSERT INTO `banners` VALUES ('4', 'Mr', 'www.dse.com', 'chi.gif', '20170102135021-chi.gif', 'dfdfds', '1', '2017-01-02 13:50:21', '<p>serefsd</p>', '2017-01-02 13:50:40', null);

-- ----------------------------
-- Table structure for `banner_types`
-- ----------------------------
DROP TABLE IF EXISTS `banner_types`;
CREATE TABLE `banner_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of banner_types
-- ----------------------------
INSERT INTO `banner_types` VALUES ('1', 'home', 'home', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `categories`
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(66) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('1', 'Category A', null, '2016-12-20 13:10:41', '2016-12-20 13:10:41');
INSERT INTO `categories` VALUES ('2', 'Category B', null, '2016-12-20 13:10:43', '2016-12-20 13:10:43');
INSERT INTO `categories` VALUES ('3', 'Category C', null, '2016-12-20 13:10:48', '2016-12-20 13:10:48');
INSERT INTO `categories` VALUES ('4', 'Category D', null, '2016-12-20 13:10:54', '2016-12-20 13:10:54');
INSERT INTO `categories` VALUES ('5', 'Subcategory A1', '1', '2016-12-20 13:11:41', '2016-12-20 13:11:41');
INSERT INTO `categories` VALUES ('6', 'Subcategory A2', '1', '2016-12-20 13:11:57', '2016-12-20 13:11:57');
INSERT INTO `categories` VALUES ('7', 'Subcategory B1', '2', '2016-12-20 13:12:30', '2016-12-20 13:12:30');
INSERT INTO `categories` VALUES ('8', 'Subcategory B2', '2', '2016-12-20 13:13:00', '2016-12-20 13:13:00');
INSERT INTO `categories` VALUES ('9', 'Subcategory C1', '3', '2016-12-20 13:13:19', '2016-12-20 13:13:19');
INSERT INTO `categories` VALUES ('10', 'Subcategory C2', '3', '2016-12-20 13:13:39', '0000-00-00 00:00:00');
INSERT INTO `categories` VALUES ('11', 'Subcategory D1', '4', '2016-12-20 13:14:01', '0000-00-00 00:00:00');
INSERT INTO `categories` VALUES ('12', 'Subcategory D2', '4', '2016-12-20 13:14:16', '0000-00-00 00:00:00');
INSERT INTO `categories` VALUES ('23', 'dfsdfsdf', '23', '2016-12-21 16:52:07', '2016-12-21 11:52:07');

-- ----------------------------
-- Table structure for `cities`
-- ----------------------------
DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(66) NOT NULL,
  `state_id` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cities_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cities
-- ----------------------------
INSERT INTO `cities` VALUES ('32', 'Lahore', '28', '2016-12-22 08:32:56', '2016-12-22 08:32:56');
INSERT INTO `cities` VALUES ('33', 'Karachi', '27', '2016-12-22 08:33:25', '2016-12-22 08:33:25');
INSERT INTO `cities` VALUES ('34', 'Peshawar', '31', '2016-12-22 13:41:32', '2016-12-22 08:41:32');
INSERT INTO `cities` VALUES ('36', 'Quetta', '33', '2016-12-22 11:21:16', '2016-12-22 11:21:16');
INSERT INTO `cities` VALUES ('37', 'Rawalpindi', '28', '2016-12-22 11:21:37', '2016-12-22 11:21:37');
INSERT INTO `cities` VALUES ('38', 'Faisalabad', '28', '2016-12-22 11:21:57', '2016-12-22 11:21:57');
INSERT INTO `cities` VALUES ('39', 'Multan', '28', '2016-12-22 11:22:12', '2016-12-22 11:22:12');
INSERT INTO `cities` VALUES ('40', 'Islamabad', '28', '2016-12-22 11:22:27', '2016-12-22 11:22:27');

-- ----------------------------
-- Table structure for `countries`
-- ----------------------------
DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(66) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of countries
-- ----------------------------
INSERT INTO `countries` VALUES ('20', 'Pakistan', '2016-12-21 16:45:13', '2016-12-21 11:45:13');
INSERT INTO `countries` VALUES ('37', 'Turkey', '2016-12-22 08:43:12', '2016-12-22 08:43:12');
INSERT INTO `countries` VALUES ('38', 'Iran', '2016-12-22 08:43:26', '2016-12-22 08:43:26');
INSERT INTO `countries` VALUES ('39', 'China', '2016-12-22 08:43:37', '2016-12-22 08:43:37');
INSERT INTO `countries` VALUES ('40', 'Russia', '2016-12-22 08:43:47', '2016-12-22 08:43:47');

-- ----------------------------
-- Table structure for `form_attributes`
-- ----------------------------
DROP TABLE IF EXISTS `form_attributes`;
CREATE TABLE `form_attributes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(66) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `form_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of form_attributes
-- ----------------------------
INSERT INTO `form_attributes` VALUES ('1', 'Experience', null, '2016-12-26 15:33:33', '2016-12-26 15:33:32');
INSERT INTO `form_attributes` VALUES ('2', 'Four year', '1', '2016-12-26 12:48:42', '2016-12-26 07:48:42');
INSERT INTO `form_attributes` VALUES ('7', 'Qualification', null, '2016-12-26 08:11:51', '2016-12-26 08:11:51');
INSERT INTO `form_attributes` VALUES ('18', 'Matric', '7', '2016-12-26 09:46:13', '2016-12-26 09:46:13');
INSERT INTO `form_attributes` VALUES ('19', 'Fsc', '7', '2016-12-26 09:46:14', '2016-12-26 09:46:14');
INSERT INTO `form_attributes` VALUES ('53', 'asea', null, '2016-12-29 15:40:31', '2016-12-29 10:40:31');
INSERT INTO `form_attributes` VALUES ('55', 'erwer', '53', '2016-12-29 10:42:29', '2016-12-29 10:42:29');
INSERT INTO `form_attributes` VALUES ('56', 'ewtwet', '53', '2016-12-29 10:42:29', '2016-12-29 10:42:29');
INSERT INTO `form_attributes` VALUES ('57', 'rwew534', '53', '2016-12-29 10:42:29', '2016-12-29 10:42:29');
INSERT INTO `form_attributes` VALUES ('62', 'dsad', null, '2016-12-29 10:57:34', '2016-12-29 10:57:34');
INSERT INTO `form_attributes` VALUES ('65', 'gfsdfg', '62', '2016-12-29 11:00:31', '2016-12-29 11:00:31');
INSERT INTO `form_attributes` VALUES ('70', 'dsf', '53', '2016-12-29 11:14:10', '2016-12-29 11:14:10');
INSERT INTO `form_attributes` VALUES ('80', 'dsadsd', '62', '2016-12-29 11:44:01', '2016-12-29 11:44:01');
INSERT INTO `form_attributes` VALUES ('81', 'eqerew', '62', '2016-12-29 11:44:01', '2016-12-29 11:44:01');
INSERT INTO `form_attributes` VALUES ('82', 'sdsd', '62', '2016-12-29 11:44:01', '2016-12-29 11:44:01');

-- ----------------------------
-- Table structure for `jobs`
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jobs
-- ----------------------------
INSERT INTO `jobs` VALUES ('1', 'job1', 'job1', '1', '10', '2016-12-30 16:45:14', '2016-12-30 16:45:17', null);
INSERT INTO `jobs` VALUES ('2', 'job2', 'job2', '1', '48', '2017-01-03 11:47:36', '2017-01-03 11:47:39', null);
INSERT INTO `jobs` VALUES ('3', 'job3', 'job3', '1', '44', '2017-01-03 11:49:34', '2017-01-03 11:49:36', null);
INSERT INTO `jobs` VALUES ('4', 'job4', 'job4', '1', '36', '2017-01-03 11:49:56', '2017-01-03 11:49:58', null);
INSERT INTO `jobs` VALUES ('5', 'job5', 'job5', '0', '43', '2016-12-30 18:10:15', '0000-00-00 00:00:00', null);
INSERT INTO `jobs` VALUES ('6', 'job6', 'job6', '1', '48', '2017-01-03 14:07:11', '2017-01-03 11:29:20', '2017-01-03 11:29:20');

-- ----------------------------
-- Table structure for `jobs_applied`
-- ----------------------------
DROP TABLE IF EXISTS `jobs_applied`;
CREATE TABLE `jobs_applied` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `job_id` int(10) NOT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`id`,`user_id`,`job_id`),
  UNIQUE KEY `idx_job_user_id` (`user_id`,`job_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jobs_applied
-- ----------------------------
INSERT INTO `jobs_applied` VALUES ('1', '2', '2', '2016-12-30', '2016-12-30', null);
INSERT INTO `jobs_applied` VALUES ('2', '51', '1', '2017-01-03', '2017-01-03', '2017-01-03');
INSERT INTO `jobs_applied` VALUES ('3', '53', '1', '2017-01-03', '2017-01-03', null);
INSERT INTO `jobs_applied` VALUES ('4', '28', '1', '2016-12-30', '2016-12-30', null);
INSERT INTO `jobs_applied` VALUES ('5', '48', '1', '2017-01-03', '2017-01-03', null);
INSERT INTO `jobs_applied` VALUES ('6', '50', '1', '2016-12-30', '2016-12-31', null);
INSERT INTO `jobs_applied` VALUES ('7', '53', '2', '2017-01-03', '2017-01-03', null);

-- ----------------------------
-- Table structure for `locations`
-- ----------------------------
DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of locations
-- ----------------------------

-- ----------------------------
-- Table structure for `pages`
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8_unicode_ci,
  `long_description` text COLLATE utf8_unicode_ci,
  `meta_keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES ('1', 'Home Page', 'home', null, null, 'test', '', 'test 1234', null, '0000-00-00 00:00:00', '2016-02-14 12:28:44', null);
INSERT INTO `pages` VALUES ('2', 'About Us', 'about-us', null, null, '', '', '', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00', null);

-- ----------------------------
-- Table structure for `page_ad_slots`
-- ----------------------------
DROP TABLE IF EXISTS `page_ad_slots`;
CREATE TABLE `page_ad_slots` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `slotable_id` int(11) DEFAULT NULL,
  `slotable_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sequence` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of page_ad_slots
-- ----------------------------

-- ----------------------------
-- Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'permission1', 'jdfsdkf', 'sdfsdf', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('2', 'permission2', 'dfsdfd', 'dfsdf', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `permissions` VALUES ('3', 'permission3', 'uiouiy', 'ghfgh', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `permission_role`
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(11) NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  UNIQUE KEY `permission_role_role_id_foreign` (`permission_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('2', '5', '2016-12-22 12:12:27', '2016-12-22 12:12:27');
INSERT INTO `permission_role` VALUES ('3', '5', '2016-12-22 12:11:25', '2016-12-22 12:11:25');

-- ----------------------------
-- Table structure for `registers`
-- ----------------------------
DROP TABLE IF EXISTS `registers`;
CREATE TABLE `registers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(60) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `email_address` varchar(60) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of registers
-- ----------------------------
INSERT INTO `registers` VALUES ('1', '0', '033445468452', 'asda@gmail.com', '2016-11-20', '2016-11-20');
INSERT INTO `registers` VALUES ('2', '11', '0798884984', 'fgasda@gmail.com', '2016-11-21', '2016-11-21');
INSERT INTO `registers` VALUES ('3', '12', '0798884984', 'fgasda@gmail.com', '2016-11-21', '2016-11-21');
INSERT INTO `registers` VALUES ('4', '12', '07988887', 'yfasda@gmail.com', '2016-11-21', '2016-11-21');
INSERT INTO `registers` VALUES ('5', '14', '0798884984', 'fasda@gmail.com', '2016-11-21', '2016-11-21');
INSERT INTO `registers` VALUES ('6', '15', '0798884984', 'fasda@gmail.com', '2016-11-21', '2016-11-21');
INSERT INTO `registers` VALUES ('7', '15', '07988887', null, '2016-11-21', '2016-11-21');
INSERT INTO `registers` VALUES ('11', '18', '', 'es@hh.com', '2016-11-21', '2016-11-21');
INSERT INTO `registers` VALUES ('12', '18', null, 'es@hh.com', '2016-11-21', '2016-11-21');
INSERT INTO `registers` VALUES ('13', '19', '', 'es@hh.com', '2016-11-21', '2016-11-21');
INSERT INTO `registers` VALUES ('14', '19', null, '', '2016-11-21', '2016-11-21');
INSERT INTO `registers` VALUES ('15', '20', '07988876876', '6asda@gmail.com', '2016-11-21', '2016-11-21');
INSERT INTO `registers` VALUES ('16', '20', null, '4asda@gmail.com', '2016-11-21', '2016-11-21');
INSERT INTO `registers` VALUES ('20', '22', '', '', '2016-11-22', '2016-11-22');
INSERT INTO `registers` VALUES ('21', '23', '079888', 'ashda@gmail.com', '2016-11-22', '2016-11-22');
INSERT INTO `registers` VALUES ('22', '23', '07988887', 'aosda@gmail.com', '2016-11-22', '2016-11-22');
INSERT INTO `registers` VALUES ('23', '24', '07988887', 'asdya@gmail.com', '2016-11-22', '2016-11-22');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(56) NOT NULL,
  `display_name` varchar(56) NOT NULL,
  `description` varchar(100) NOT NULL,
  `created_at` datetime(6) NOT NULL,
  `updated_at` datetime(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'admin', 'admin', 'admin', '2016-12-19 13:16:36.000000', '2016-12-19 13:16:38.000000');
INSERT INTO `roles` VALUES ('2', 'dfsdf', 'dsfsdf', 'sdfsdf', '2016-12-22 12:07:16.000000', '2016-12-22 12:07:16.000000');
INSERT INTO `roles` VALUES ('5', 'Adeel Ahmad', 'sdfsdf', 'gdsgfsd', '2016-12-22 12:11:25.000000', '2016-12-22 12:11:25.000000');

-- ----------------------------
-- Table structure for `role_user`
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `user_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  UNIQUE KEY `idx_role_user_id` (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of role_user
-- ----------------------------
INSERT INTO `role_user` VALUES ('68', '1', null, null);
INSERT INTO `role_user` VALUES ('69', '1', null, null);

-- ----------------------------
-- Table structure for `states`
-- ----------------------------
DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(66) NOT NULL,
  `country_id` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of states
-- ----------------------------
INSERT INTO `states` VALUES ('27', 'Sindh', '20', '2016-12-21 19:36:55', '2016-12-21 14:36:55');
INSERT INTO `states` VALUES ('28', 'Punjab', '20', '2016-12-21 14:29:21', '2016-12-21 14:29:21');
INSERT INTO `states` VALUES ('31', 'KPK', '20', '2016-12-21 19:52:22', '2016-12-21 14:52:22');
INSERT INTO `states` VALUES ('33', 'Balochistan', '20', '2016-12-22 08:42:44', '2016-12-22 08:42:44');
INSERT INTO `states` VALUES ('34', 'Kashmir', '20', '2016-12-22 11:23:06', '2016-12-22 11:23:06');
INSERT INTO `states` VALUES ('35', 'Gilgit', '20', '2016-12-22 11:23:20', '2016-12-22 11:23:20');

-- ----------------------------
-- Table structure for `sub_cities`
-- ----------------------------
DROP TABLE IF EXISTS `sub_cities`;
CREATE TABLE `sub_cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(66) NOT NULL,
  `city_id` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subcities_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sub_cities
-- ----------------------------
INSERT INTO `sub_cities` VALUES ('36', 'Iqbal Town', '32', '2016-12-22 09:26:13', '2016-12-22 09:26:13');
INSERT INTO `sub_cities` VALUES ('37', 'Bahria Town', '32', '2016-12-22 09:26:31', '2016-12-22 09:26:31');
INSERT INTO `sub_cities` VALUES ('38', 'Gulberg', '32', '2016-12-22 09:26:47', '2016-12-22 09:26:47');
INSERT INTO `sub_cities` VALUES ('39', 'Model Town', '32', '2016-12-22 09:27:05', '2016-12-22 09:27:05');
INSERT INTO `sub_cities` VALUES ('41', 'Defence', '32', '2016-12-22 14:28:14', '2016-12-22 09:28:14');

-- ----------------------------
-- Table structure for `testimonials`
-- ----------------------------
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sequence` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of testimonials
-- ----------------------------
INSERT INTO `testimonials` VALUES ('3', '<p>fdgdfgdf</p>', 'tur.gif', 'dxfsdfds', '20170102130943-tur.gif', '2017-01-02 13:08:26', '2017-01-02 13:09:43', null);

-- ----------------------------
-- Table structure for `time_zones`
-- ----------------------------
DROP TABLE IF EXISTS `time_zones`;
CREATE TABLE `time_zones` (
  `id` int(11) NOT NULL,
  `gmt_offset` varchar(10) DEFAULT NULL,
  `time_zone_name` varchar(60) DEFAULT NULL,
  `time_alias` varchar(20) DEFAULT NULL,
  `php_timezone` varchar(255) DEFAULT NULL,
  `js_timezone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of time_zones
-- ----------------------------
INSERT INTO `time_zones` VALUES ('0', 'GMT+12:00', 'Pacific/Fiji', 'Marshall Islands', 'Pacific/Fiji', null);
INSERT INTO `time_zones` VALUES ('1', 'GMT-11:00', 'Samoa Time', 'Samoa', 'US/Samoa', null);
INSERT INTO `time_zones` VALUES ('2', 'GMT-10:00', 'Hawaii Time', 'Honolulu', 'US/Hawaii', null);
INSERT INTO `time_zones` VALUES ('3', 'GMT-08:00', 'Alaska Daylight Time', 'Anchorage', 'America/Tijuana', null);
INSERT INTO `time_zones` VALUES ('4', 'GMT-07:00', 'Pacific Daylight Time', 'San Francisco', 'America/Mazatlan', null);
INSERT INTO `time_zones` VALUES ('5', 'GMT-07:00', 'Mountain Time', 'Arizona', 'America/Mazatlan', null);
INSERT INTO `time_zones` VALUES ('6', 'GMT-06:00', 'Mountain Daylight Time', 'Denver', 'US/Central', null);
INSERT INTO `time_zones` VALUES ('7', 'GMT-05:00', 'Central Daylight Time', 'Chicago', 'America/Lima', null);
INSERT INTO `time_zones` VALUES ('8', 'GMT-05:00', 'Mexico Daylight Time', 'Mexico City', null, null);
INSERT INTO `time_zones` VALUES ('9', 'GMT-06:00', 'Central Time', 'Saskatchewan', 'US/Central', null);
INSERT INTO `time_zones` VALUES ('10', 'GMT-05:00', 'S. America Pacific Time', 'Bogota', 'America/Lima', null);
INSERT INTO `time_zones` VALUES ('11', 'GMT-04:00', 'Eastern Daylight Time', 'New York', 'America/Santiago', null);
INSERT INTO `time_zones` VALUES ('12', 'GMT-04:00', 'Eastern Daylight Time', 'Indiana', 'America/Santiago', null);
INSERT INTO `time_zones` VALUES ('13', 'GMT-03:00', 'Atlantic Daylight Time', 'Halifax', 'America/Godthab', null);
INSERT INTO `time_zones` VALUES ('14', 'GMT-04:00', 'S. America Western Time', 'La Paz', 'America/Santiago', null);
INSERT INTO `time_zones` VALUES ('15', 'GMT-02:30', 'Newfoundland Daylight Time', 'Newfoundland', null, null);
INSERT INTO `time_zones` VALUES ('16', 'GMT-03:00', 'S. America Eastern Standard Time', 'Brasilia', 'America/Godthab', null);
INSERT INTO `time_zones` VALUES ('17', 'GMT-03:00', 'S. America Eastern Time', 'Buenos Aires', 'America/Godthab', null);
INSERT INTO `time_zones` VALUES ('18', 'GMT-02:00', 'Mid-Atlantic Time', 'Mid-Atlantic', 'Atlantic/Stanley', null);
INSERT INTO `time_zones` VALUES ('19', 'GMT', 'Azores Summer Time', 'Azores', 'Africa/Monrovia', null);
INSERT INTO `time_zones` VALUES ('20', 'GMT', 'Greenwich Time', 'Reykjavik', 'Africa/Monrovia', null);
INSERT INTO `time_zones` VALUES ('21', 'GMT+01:00', 'GMT Summer Time', 'London', 'Europe/Zagreb', null);
INSERT INTO `time_zones` VALUES ('22', 'GMT+02:00', 'Europe Summer Time', 'Amsterdam', 'Europe/Vilnius', null);
INSERT INTO `time_zones` VALUES ('23', 'GMT+02:00', 'Europe Summer Time', 'Paris', 'Europe/Vilnius', null);
INSERT INTO `time_zones` VALUES ('25', 'GMT+02:00', 'Europe Summer Time', 'Berlin', 'Europe/Vilnius', null);
INSERT INTO `time_zones` VALUES ('26', 'GMT+03:00', 'Greece Summer Time', 'Athens', 'Asia/Riyadh', null);
INSERT INTO `time_zones` VALUES ('28', 'GMT+02:00', 'Egypt Time', 'Cairo', 'Europe/Vilnius', null);
INSERT INTO `time_zones` VALUES ('29', 'GMT+02:00', 'South Africa Time', 'Pretoria', 'Europe/Vilnius', null);
INSERT INTO `time_zones` VALUES ('30', 'GMT+03:00', 'Northern Europe Summer Time, ', 'Helsinki', 'Asia/Riyadh', null);
INSERT INTO `time_zones` VALUES ('31', 'GMT+03:00', 'Israel Daylight Time', 'Tel Aviv', 'Asia/Riyadh', null);
INSERT INTO `time_zones` VALUES ('32', 'GMT+03:00', 'Saudi Arabia Time', 'Riyadh', 'Asia/Riyadh', null);
INSERT INTO `time_zones` VALUES ('33', 'GMT+04:00', 'Russian Time', 'Moscow', 'Asia/Yerevan', null);
INSERT INTO `time_zones` VALUES ('34', 'GMT+03:00', 'Nairobi Time', 'Nairobi', 'Asia/Riyadh', null);
INSERT INTO `time_zones` VALUES ('35', 'GMT+04:30', 'Iran Daylight Time', 'Tehran', 'Asia/Kabul', null);
INSERT INTO `time_zones` VALUES ('36', 'GMT+04:00', 'Arabian Time', 'Abu Dhabi, Muscat', 'Asia/Yerevan', null);
INSERT INTO `time_zones` VALUES ('37', 'GMT+05:00', 'Baku Daylight Time', 'Baku', 'Asia/Tashkent', null);
INSERT INTO `time_zones` VALUES ('38', 'GMT+04:30', 'Afghanistan Time', 'Kabul', 'Asia/Kabul', null);
INSERT INTO `time_zones` VALUES ('39', 'GMT+06:00', 'West Asia Time', 'Yekaterinburg', 'Asia/Dhaka', null);
INSERT INTO `time_zones` VALUES ('40', 'GMT+05:00', 'West Asia Time', 'Islamabad', 'Asia/Tashkent', null);
INSERT INTO `time_zones` VALUES ('41', 'GMT+05:30', 'India Time', 'Mumbai', 'Asia/Kolkata', null);
INSERT INTO `time_zones` VALUES ('42', 'GMT+05:30', 'Colombo Time', 'Colombo', 'Asia/Kolkata', null);
INSERT INTO `time_zones` VALUES ('43', 'GMT+06:00', 'Central Asia Time', 'Almaty', 'Asia/Dhaka', null);
INSERT INTO `time_zones` VALUES ('44', 'GMT+07:00', 'Bangkok Time', 'Bangkok', 'Asia/Jakarta', null);
INSERT INTO `time_zones` VALUES ('45', 'GMT+08:00', 'China Time', 'Beijing', 'Asia/Urumqi', null);
INSERT INTO `time_zones` VALUES ('46', 'GMT+08:00', 'Australia Western Time', 'Perth', 'Asia/Urumqi', null);
INSERT INTO `time_zones` VALUES ('47', 'GMT+08:00', 'Singapore Time', 'Singapore', 'Asia/Urumqi', null);
INSERT INTO `time_zones` VALUES ('48', 'GMT+08:00', 'Taipei Time', 'Taipei', 'Asia/Urumqi', null);
INSERT INTO `time_zones` VALUES ('49', 'GMT+09:00', 'Japan Time', 'Tokyo', 'Asia/Tokyo', null);
INSERT INTO `time_zones` VALUES ('50', 'GMT+09:00', 'Korea Time', 'Seoul', 'Asia/Tokyo', null);
INSERT INTO `time_zones` VALUES ('51', 'GMT+10:00', 'Yakutsk Time', 'Yakutsk', 'Australia/Sydney', null);
INSERT INTO `time_zones` VALUES ('52', 'GMT+09:30', 'Australia Central Standard Time', 'Adelaide', 'Australia/Darwin', null);
INSERT INTO `time_zones` VALUES ('53', 'GMT+09:30', 'Australia Central Time', 'Darwin', 'Australia/Darwin', null);
INSERT INTO `time_zones` VALUES ('54', 'GMT+10:00', 'Australia Eastern Time', 'Brisbane', 'Australia/Sydney', null);
INSERT INTO `time_zones` VALUES ('55', 'GMT+10:00', 'Australia Eastern Standard Time', 'Sydney', 'Australia/Sydney', null);
INSERT INTO `time_zones` VALUES ('56', 'GMT+10:00', 'West Pacific Time~', 'Guam', 'Australia/Sydney', null);
INSERT INTO `time_zones` VALUES ('57', 'GMT+10:00', 'Tasmania Standard Time', 'Hobart', 'Australia/Sydney', null);
INSERT INTO `time_zones` VALUES ('58', 'GMT+11:00', 'Vladivostok Time', 'Vladivostok', 'Asia/Vladivostok', null);
INSERT INTO `time_zones` VALUES ('59', 'GMT+11:00', 'Central Pacific Time', 'Solomon Is', 'Asia/Vladivostok', null);
INSERT INTO `time_zones` VALUES ('60', 'GMT+12:00', 'New Zealand Standard Time', 'Wellington', 'Pacific/Fiji', null);
INSERT INTO `time_zones` VALUES ('61', 'GMT+12:00', 'Fiji Standard Time', 'Fiji', 'Pacific/Fiji', null);
INSERT INTO `time_zones` VALUES ('130', 'GMT+02:00', 'Sweden Summer Time', 'Stockholm', 'Europe/Vilnius', null);
INSERT INTO `time_zones` VALUES ('131', 'GMT-07:00', 'Mexico Pacific Daylight Time', 'Tijuana', 'America/Mazatlan', null);
INSERT INTO `time_zones` VALUES ('132', 'GMT-06:00', 'Mexico Mountain Daylight Time', 'Chihuahua', 'US/Central', null);
INSERT INTO `time_zones` VALUES ('133', 'GMT-04:30', 'S. America Western Time', 'Caracas', 'America/Caracas', null);
INSERT INTO `time_zones` VALUES ('134', 'GMT+08:00', 'Malaysia Time', 'Kuala Lumpur', 'Asia/Urumqi', null);
INSERT INTO `time_zones` VALUES ('135', 'GMT-03:00', 'S. America Eastern Time', 'Recife', 'America/Godthab', null);
INSERT INTO `time_zones` VALUES ('136', 'GMT+01:00', 'Morocco Summer Time', 'Casablanca', 'Europe/Zagreb', null);
INSERT INTO `time_zones` VALUES ('137', 'GMT-06:00', 'Honduras Time', 'Tegucigalpa', 'US/Central', null);
INSERT INTO `time_zones` VALUES ('138', 'GMT-02:00', 'Greenland Daylight Time', 'Nuuk', 'Atlantic/Stanley', null);
INSERT INTO `time_zones` VALUES ('139', 'GMT+03:00', 'Jordan Daylight Time', 'Amman', 'Asia/Riyadh', null);
INSERT INTO `time_zones` VALUES ('140', 'GMT+03:00', 'Eastern Europe Summer Time', 'Istanbul', 'Asia/Riyadh', null);
INSERT INTO `time_zones` VALUES ('141', 'GMT+05:45', 'Nepal Time', 'Kathmandu', 'Asia/Kathmandu', null);
INSERT INTO `time_zones` VALUES ('142', 'GMT+02:00', 'Europe Summer Time', 'Rome', 'Europe/Vilnius', null);
INSERT INTO `time_zones` VALUES ('143', 'GMT+01:00', 'West Africa Time', 'West Africa', 'Europe/Zagreb', null);
INSERT INTO `time_zones` VALUES ('144', 'GMT+02:00', 'Europe Summer Time', 'Madrid', 'Europe/Vilnius', null);
INSERT INTO `time_zones` VALUES ('145', 'GMT-04:00', 'S. America Western Standard Time', 'Santiago', 'America/Santiago', null);
INSERT INTO `time_zones` VALUES ('146', 'GMT-05:00', 'Eastern Time', 'Panama', null, null);
INSERT INTO `time_zones` VALUES ('147', 'GMT+02:00', 'Europe Summer Time', 'Brussels', 'Europe/Vilnius', null);
INSERT INTO `time_zones` VALUES ('148', 'GMT-04:00', 'Paraguay Time', 'Asuncion', 'America/Santiago', null);
INSERT INTO `time_zones` VALUES ('149', 'GMT-03:00', 'Uruguay Time', 'Montevideo', 'America/Godthab', null);
INSERT INTO `time_zones` VALUES ('150', 'GMT-01:00', 'Cape Verde Time', 'Cape Verde', 'Atlantic/Cape_Verde', null);
INSERT INTO `time_zones` VALUES ('151', 'GMT+01:00', 'West Africa Time', 'Windhoek', 'Europe/Zagreb', null);
INSERT INTO `time_zones` VALUES ('152', 'GMT+06:30', 'Myanmar Time', 'Yangon', null, null);
INSERT INTO `time_zones` VALUES ('153', 'GMT+13:00', 'Tonga Time', 'Tonga', null, null);
INSERT INTO `time_zones` VALUES ('154', 'GMT+07:00', 'Western Indonesia Time', 'Jakarta', 'Asia/Jakarta', null);
INSERT INTO `time_zones` VALUES ('155', 'GMT-05:00', 'Eastern', 'Eastern', 'America/New_York', null);
INSERT INTO `time_zones` VALUES ('156', 'GMT-06:00', 'Central', 'Central', 'America/Chicago', null);
INSERT INTO `time_zones` VALUES ('157', 'GMT-07:00', 'Mountain', 'Mountain', 'America/Denver', null);
INSERT INTO `time_zones` VALUES ('158', 'GMT-08:00', 'Pacific', 'Pacific', 'America/Los_Angeles', null);
INSERT INTO `time_zones` VALUES ('159', 'GMT-09:00', 'Alaska', 'Alaska', 'America/Anchorage', null);
INSERT INTO `time_zones` VALUES ('160', 'GMT-10:00', 'Hawaii', 'Hawaii', 'America/Adak', null);
INSERT INTO `time_zones` VALUES ('161', 'GMT+05:00', 'Asia/Karachi', 'Asia/Karachi', 'Asia/Karachi', null);

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `father_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_education` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_of_attempts` int(11) DEFAULT NULL,
  `is_admin` int(5) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email_address`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin user', '', null, null, 'babar@aliens-tech.com', '$2y$10$To5KxbaBvYSh/JAz40PxB.EE/eIqUc8OVLdlYVSXw7iexZsQ.M9xy', null, null, null, null, null, null, '1', 'NIYs4lVGEAYlUYnZQRFaln6m1qyrJEfteYCdDDnYQp6XdchKss5VMHbT8NQ8', '0', '1', null, '2016-02-13 06:24:31', '2017-01-06 09:32:14', null);
INSERT INTO `users` VALUES ('2', 'bilal', '', null, null, 'awan.bilal94@yahoo.com', '$2y$10$C5iqWuhtsXSCw/f7DxkEy.sSIt9K5eXxViwMG1WGPyaGRlIEGDjR.', null, null, null, null, null, null, '1', '', null, null, null, '2016-02-13 06:24:31', '2016-02-13 06:24:31', null);
INSERT INTO `users` VALUES ('3', 'yasir', 'Imtiaz', null, null, 'yasir.aliens.tech@gmail.com', '$2y$10$Zr1Z7zh8VJeZEeht28uTiekuNrgkgd7ANtJ9rYdcWxviUEZtuy6mO', null, null, null, null, null, null, '1', 'LA5E4Y7xBk6ztetaw6SeVcq0cAAOmDmFIIIMFIwNolMqX9AqFz0zHfHmcIni', '0', '0', null, '2016-02-13 06:24:31', '2017-01-06 10:01:11', null);
INSERT INTO `users` VALUES ('4', 'irfan', '', null, null, 'mrUHkqwT29@gmail.com', '$2y$10$Az8kF9m83Kg5qXTTJgOUF.e1jwpJ2O3HLb06egH2hB1cleq60YDO2', null, null, null, null, null, null, '1', '', null, null, null, '2016-02-13 06:24:32', '2016-02-13 06:24:32', null);
INSERT INTO `users` VALUES ('5', 'aamir', '', null, null, '1qsXnBrlAn@gmail.com', '$2y$10$VmC7CZKJ8RsfYSEYzKddy.HxnwK133YsFpHuUulf07149S1OUD/Hy', null, null, null, null, null, null, '1', '', null, null, null, '2016-02-13 06:24:32', '2016-02-13 06:24:32', null);
INSERT INTO `users` VALUES ('6', 'waqar', '', null, null, 'WZAdGvv6Os@gmail.com', '$2y$10$snHcT/sYnjGBDcNN/J1MKeKFVKknFun31XDuWsmGCi8j3og05yl2C', null, null, null, null, null, null, '1', '', null, null, null, '2016-02-13 06:24:32', '2016-02-13 06:24:32', null);
INSERT INTO `users` VALUES ('7', 'usman', '', null, null, 'HLFQZycHHY@gmail.com', '$2y$10$gmJDwttBBpPYcbwaNrKStui0zoqvXzmY/U5Pl4aNTZAF67rt.wUue', null, null, null, null, null, null, '1', '', null, null, null, '2016-02-13 06:24:32', '2016-02-13 06:24:32', null);
INSERT INTO `users` VALUES ('8', 'junaid', '', null, null, 'ABYH5VliJz@gmail.com', '$2y$10$c.InSi7zBt6xxn05xQXZj.4Nti.YbnipKWg6sh656pBfuLwG0Yr/G', null, null, null, null, null, null, '1', '', null, null, null, '2016-02-13 06:24:32', '2016-02-13 06:24:32', null);
INSERT INTO `users` VALUES ('9', 'Adeel', 'Ahmad', null, null, 'adeel1@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-04 14:25:49', '2016-05-04 14:25:49', null);
INSERT INTO `users` VALUES ('10', 'Babar', 'Sajjad', null, null, 'babar@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-04 14:37:39', '2016-05-04 14:37:39', null);
INSERT INTO `users` VALUES ('11', 'Nabeel', 'Ahmad', null, null, 'nabeel@gmail.com', '123', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-05 08:45:29', '2016-05-10 14:25:47', null);
INSERT INTO `users` VALUES ('12', 'Adeel', 'Ahmad', null, null, 'adeel2@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-05 08:46:16', '2016-05-05 08:46:16', null);
INSERT INTO `users` VALUES ('13', 'Adeel', 'Ahmad', null, null, 'adeel4s@gmail.com', '1234', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-05 08:48:30', '2016-05-10 11:55:28', null);
INSERT INTO `users` VALUES ('23', 'Babar', 'Sajjad', null, null, 'adeel4564@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 16:56:58', '2016-05-06 16:56:58', null);
INSERT INTO `users` VALUES ('24', 'Adeel', 'Ahmad', null, null, 'asdasdasd@gmail.coms', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 17:00:55', '2016-05-10 14:24:37', null);
INSERT INTO `users` VALUES ('25', 'Bilal', 'Ah', null, null, 'adeelsxdas1@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 17:01:28', '2016-05-06 17:01:28', null);
INSERT INTO `users` VALUES ('26', 's', 'Ahmed', null, null, 'adeel4sxs564@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 17:01:58', '2016-05-06 17:01:58', null);
INSERT INTO `users` VALUES ('27', 'Bilal', 'Sajjad', null, null, 'adeel1drser@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 17:05:25', '2016-05-06 17:05:25', null);
INSERT INTO `users` VALUES ('28', 'bilal', 'Ahmad', null, null, 'bilal@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 17:07:19', '2016-05-06 17:07:19', null);
INSERT INTO `users` VALUES ('30', 'Babar', 'Ah', null, null, 'ddfdf@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 17:17:01', '2016-05-06 17:17:01', null);
INSERT INTO `users` VALUES ('31', 'sdfefwe', 'dsfeefs', null, null, 'asdkjtkt@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 17:17:38', '2016-05-06 17:17:38', null);
INSERT INTO `users` VALUES ('32', 'Adeel', 'Ahmed', null, null, 'asdassdd@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 17:18:09', '2016-05-06 17:18:09', null);
INSERT INTO `users` VALUES ('33', 'Bilal', 'Ahmad', null, null, 'sddfsd@gfhn.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 17:18:52', '2016-05-06 17:18:52', null);
INSERT INTO `users` VALUES ('34', 'Adeel', 'Ahmad', null, null, 'adeel1dw@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 17:30:54', '2016-05-06 17:30:54', null);
INSERT INTO `users` VALUES ('35', 'Babar', 'Ahmed', null, null, 'asdasdd@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 17:48:54', '2016-05-06 17:48:54', null);
INSERT INTO `users` VALUES ('36', 'Bilal', 'Ah', null, null, 'adeeledfdsd1@gmail.com', '', null, null, null, null, null, null, '0', '', null, null, null, '2016-05-06 17:49:29', '2016-05-06 17:49:29', null);
INSERT INTO `users` VALUES ('37', 'jhbdhsghj', 'dbfksjbdj', null, null, 'sdfsd@gfhn.com', '', null, null, null, null, null, null, '1', '', '0', null, null, '2016-05-06 17:49:52', '2016-05-06 17:49:52', null);
INSERT INTO `users` VALUES ('39', 'Bilal', 'Ah', null, null, 'asdassxd@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-06 17:55:15', '2016-05-06 17:55:15', null);
INSERT INTO `users` VALUES ('40', 'Nabeel', 'Ahmad', null, null, 'nabeel1@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-09 08:32:21', '2016-05-09 08:32:21', null);
INSERT INTO `users` VALUES ('41', 'Adeel', 'Ahmad', null, null, 'adeel45@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-09 08:41:46', '2016-05-09 08:41:46', null);
INSERT INTO `users` VALUES ('42', 'Adeel', 'Ahmad', null, null, 'adeel64@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-09 08:47:03', '2016-05-09 08:47:03', null);
INSERT INTO `users` VALUES ('43', 'Bilal', 'Ahmad', null, null, 'bilal2@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-09 08:50:28', '2016-05-09 08:50:28', null);
INSERT INTO `users` VALUES ('44', 'Adeel', 'Ahmad', null, null, 'adeel56@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-09 08:55:23', '2016-05-09 08:55:23', null);
INSERT INTO `users` VALUES ('45', 'Adeel', 'Ahmad', null, null, 'adeel44@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-09 09:12:56', '2016-05-09 09:12:56', null);
INSERT INTO `users` VALUES ('46', 'Adeel', 'Ahmad', null, null, 'adeel54@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-09 09:14:56', '2016-05-09 09:14:56', null);
INSERT INTO `users` VALUES ('47', 'Adeel', 'Ahmad', null, null, 'adeel12@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-09 09:25:40', '2016-05-09 09:25:40', null);
INSERT INTO `users` VALUES ('48', 'Adeel', 'Ahmad', null, null, 'assdassdd@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-09 10:07:40', '2016-05-09 10:07:40', null);
INSERT INTO `users` VALUES ('50', 'Babar', 'Sajjad', null, null, 'babar@yahoo.com', '$2y$10$mfhG7kW9eJMH4z6WZQl/ruaOUmCXviq3xDiOR1wLGoWNmNfKXZLAy', null, null, null, null, null, null, '1', '218d077040274f1bcb25559b2aa33421e88b04b4fd008a3bf0e84fff146df9f7', null, null, null, '2016-05-09 11:23:55', '2017-01-05 15:02:02', null);
INSERT INTO `users` VALUES ('51', 'Adeel', 'Ahmad', null, null, 'adeel851@gmail.com', '', null, null, null, null, null, null, '1', '', null, null, '2017-01-03 11:34:45', '2016-05-09 13:23:27', '2017-01-03 11:34:45', null);
INSERT INTO `users` VALUES ('53', 'Adeel', 'Ahmad', null, null, 'adeel6s4@gmail.com', '$2y$10$4FV2EPSAoIGVel7vAaSRQeUiIUUSqIDBTiZuTDT0Z60kmkqV.XWlq', null, null, null, null, null, null, '1', '', null, null, null, '2016-05-09 14:34:33', '2017-01-05 08:38:10', null);
INSERT INTO `users` VALUES ('66', 'Adeel', 'Ahmad', null, null, 'adeel.aliens.tech@gmail.com', '$2y$10$SwYjmC2hWyozg3Wy0mDBEe69Xisp./T1vDYbrK0g4ENYwWvXx4WMy', null, null, null, null, null, null, '0', '218d077040274f1bcb25559b2aa33421e88b04b4fd008a3bf0e84fff146df9f7', null, '1', null, '2016-12-16 15:07:39', '2016-12-16 15:07:39', null);
INSERT INTO `users` VALUES ('68', 'Adeel', 'Ahmad', null, null, 'adeel@gmail.com', '$2y$10$B11f9SN6T29OQuwb94P.FOlHSYlwD4f9.XCLufhtwl1oXsMp2VnYW', null, null, null, null, null, null, '1', 'O0oNJe4x5fRf41HCJEWr1j4f4kjTwmL8WBkqGVlcCwTkoIPQnQyYrwwGmxmX', '0', '1', null, '2016-12-29 11:45:30', '2016-12-29 14:15:43', null);
INSERT INTO `users` VALUES ('69', 'Adeel', 'Ahmad', null, null, 'admin@gmail.com', '$2y$10$JK9V2j0VY9R9mJ.foAJ/dOtcCziEI3xDQ.M3g0geWNsQJAbg.evAe', null, null, null, null, null, null, '1', null, null, '1', null, '2016-12-29 14:11:30', '2016-12-29 14:17:20', null);

-- ----------------------------
-- Table structure for `user_register`
-- ----------------------------
DROP TABLE IF EXISTS `user_register`;
CREATE TABLE `user_register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(66) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_register
-- ----------------------------
INSERT INTO `user_register` VALUES ('1', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('2', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('3', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('4', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('5', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('6', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('7', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('8', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('9', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('10', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('11', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('12', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('13', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('14', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('15', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('20', 'Adeel Ahmad', '2016-11-21', '2016-11-21');
INSERT INTO `user_register` VALUES ('23', 'Adeel Ahmad', '2016-11-22', '2016-11-22');
INSERT INTO `user_register` VALUES ('24', 'Adeel Ahmad', '2016-11-22', '2016-11-22');
