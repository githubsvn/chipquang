-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 17, 2013 at 03:56 PM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `local.tyhv`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl_classes`
--

CREATE TABLE IF NOT EXISTS `acl_classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_69DD750638A36066` (`class_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `acl_classes`
--


-- --------------------------------------------------------

--
-- Table structure for table `acl_entries`
--

CREATE TABLE IF NOT EXISTS `acl_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(10) unsigned NOT NULL,
  `object_identity_id` int(10) unsigned DEFAULT NULL,
  `security_identity_id` int(10) unsigned NOT NULL,
  `field_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ace_order` smallint(5) unsigned NOT NULL,
  `mask` int(11) NOT NULL,
  `granting` tinyint(1) NOT NULL,
  `granting_strategy` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `audit_success` tinyint(1) NOT NULL,
  `audit_failure` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4` (`class_id`,`object_identity_id`,`field_name`,`ace_order`),
  KEY `IDX_46C8B806EA000B103D9AB4A6DF9183C9` (`class_id`,`object_identity_id`,`security_identity_id`),
  KEY `IDX_46C8B806EA000B10` (`class_id`),
  KEY `IDX_46C8B8063D9AB4A6` (`object_identity_id`),
  KEY `IDX_46C8B806DF9183C9` (`security_identity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `acl_entries`
--


-- --------------------------------------------------------

--
-- Table structure for table `acl_object_identities`
--

CREATE TABLE IF NOT EXISTS `acl_object_identities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_object_identity_id` int(10) unsigned DEFAULT NULL,
  `class_id` int(10) unsigned NOT NULL,
  `object_identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entries_inheriting` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9407E5494B12AD6EA000B10` (`object_identifier`,`class_id`),
  KEY `IDX_9407E54977FA751A` (`parent_object_identity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `acl_object_identities`
--


-- --------------------------------------------------------

--
-- Table structure for table `acl_object_identity_ancestors`
--

CREATE TABLE IF NOT EXISTS `acl_object_identity_ancestors` (
  `object_identity_id` int(10) unsigned NOT NULL,
  `ancestor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`object_identity_id`,`ancestor_id`),
  KEY `IDX_825DE2993D9AB4A6` (`object_identity_id`),
  KEY `IDX_825DE299C671CEA1` (`ancestor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acl_object_identity_ancestors`
--


-- --------------------------------------------------------

--
-- Table structure for table `acl_security_identities`
--

CREATE TABLE IF NOT EXISTS `acl_security_identities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `username` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8835EE78772E836AF85E0677` (`identifier`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `acl_security_identities`
--


-- --------------------------------------------------------

--
-- Table structure for table `mtx_branch`
--

CREATE TABLE IF NOT EXISTS `mtx_branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CAB0DCA8727ACA70` (`parent_id`),
  KEY `IDX_CAB0DCA85EE01E44` (`created_id`),
  KEY `IDX_CAB0DCA8960CC7F3` (`updated_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `mtx_branch`
--

INSERT INTO `mtx_branch` (`id`, `parent_id`, `created_id`, `updated_id`, `lft`, `rgt`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 1, 2, NULL, NULL, NULL),
(2, NULL, 1, 1, 3, 8, 1, '2013-07-12 10:44:41', '2013-07-12 10:44:41'),
(3, 2, 1, 1, 4, 5, 1, '2013-07-12 10:44:50', '2013-07-12 10:44:50'),
(4, 2, 1, 1, 6, 7, 1, '2013-07-12 10:45:03', '2013-07-12 10:45:03'),
(5, NULL, 1, 1, 9, 14, 1, '2013-07-12 10:45:16', '2013-07-12 10:45:16'),
(6, 5, 1, 1, 10, 11, 1, '2013-07-12 10:45:30', '2013-07-12 10:45:30'),
(7, 5, 1, 1, 12, 13, 1, '2013-07-12 10:45:38', '2013-07-12 10:45:38');

-- --------------------------------------------------------

--
-- Table structure for table `mtx_branch_language`
--

CREATE TABLE IF NOT EXISTS `mtx_branch_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_64D3050082F1BAF4` (`language_id`),
  KEY `IDX_64D30500DCD6CC49` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `mtx_branch_language`
--

INSERT INTO `mtx_branch_language` (`id`, `language_id`, `branch_id`, `name`) VALUES
(1, 1, 2, 'ĐIỆN THOẠI'),
(2, 1, 3, 'Nokia'),
(3, 1, 4, 'Samsung'),
(4, 1, 5, 'MÁY TÍNH BẢNG'),
(5, 1, 6, 'Appel'),
(6, 1, 7, 'Samsung');

-- --------------------------------------------------------

--
-- Table structure for table `mtx_category`
--

CREATE TABLE IF NOT EXISTS `mtx_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A8C8079B727ACA70` (`parent_id`),
  KEY `IDX_A8C8079B5EE01E44` (`created_id`),
  KEY `IDX_A8C8079B960CC7F3` (`updated_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `mtx_category`
--

INSERT INTO `mtx_category` (`id`, `parent_id`, `created_id`, `updated_id`, `lft`, `rgt`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 1, 2, NULL, NULL, NULL),
(2, NULL, 1, 1, 3, 8, 1, '2013-07-12 10:46:32', '2013-07-12 10:46:32'),
(3, 2, 1, 1, 4, 5, 1, '2013-07-12 10:46:50', '2013-07-12 10:46:50'),
(4, 2, 1, 1, 6, 7, 1, '2013-07-12 10:46:58', '2013-07-12 10:46:58'),
(5, NULL, 1, 1, 9, 14, 1, '2013-07-12 10:47:06', '2013-07-12 10:47:06'),
(6, 5, 1, 1, 10, 11, 1, '2013-07-12 10:47:16', '2013-07-12 10:47:16'),
(7, 5, 1, 1, 12, 13, 1, '2013-07-12 10:47:24', '2013-07-12 10:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `mtx_category_language`
--

CREATE TABLE IF NOT EXISTS `mtx_category_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B2A3A34012469DE2` (`category_id`),
  KEY `IDX_B2A3A34082F1BAF4` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `mtx_category_language`
--

INSERT INTO `mtx_category_language` (`id`, `category_id`, `language_id`, `name`) VALUES
(1, 2, 1, 'XÃ HỘI'),
(2, 3, 1, 'Giáo Dục'),
(3, 4, 1, 'Văn Hóa'),
(4, 5, 1, 'THỂ THAO'),
(5, 6, 1, 'Bóng Đá'),
(6, 7, 1, 'Tennis');

-- --------------------------------------------------------

--
-- Table structure for table `mtx_company`
--

CREATE TABLE IF NOT EXISTS `mtx_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `charter_capital` double DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mst` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1ACB19A7C54C8C93` (`type_id`),
  KEY `IDX_1ACB19A75EE01E44` (`created_id`),
  KEY `IDX_1ACB19A7960CC7F3` (`updated_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mtx_company`
--

INSERT INTO `mtx_company` (`id`, `type_id`, `created_id`, `updated_id`, `charter_capital`, `phone`, `fax`, `mst`, `email`, `status`, `created_at`, `updated_at`, `logo`, `website`) VALUES
(1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, '2013-07-12 10:44:11', '2013-07-12 10:44:11', NULL, NULL),
(2, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, '2013-07-12 10:44:19', '2013-07-12 10:44:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_companytype`
--

CREATE TABLE IF NOT EXISTS `mtx_companytype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9AF919955EE01E44` (`created_id`),
  KEY `IDX_9AF91995960CC7F3` (`updated_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mtx_companytype`
--

INSERT INTO `mtx_companytype` (`id`, `created_id`, `updated_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2013-07-12 10:43:52', '2013-07-12 10:43:52'),
(2, 1, 1, 1, '2013-07-12 10:43:59', '2013-07-12 10:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `mtx_companytype_language`
--

CREATE TABLE IF NOT EXISTS `mtx_companytype_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companytype_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_54F6538B1E00F65` (`companytype_id`),
  KEY `IDX_54F6538B82F1BAF4` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mtx_companytype_language`
--

INSERT INTO `mtx_companytype_language` (`id`, `companytype_id`, `language_id`, `name`) VALUES
(1, 1, 1, 'TNHH'),
(2, 2, 1, 'CP');

-- --------------------------------------------------------

--
-- Table structure for table `mtx_company_language`
--

CREATE TABLE IF NOT EXISTS `mtx_company_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `adress` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `representation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_757D1B7C82F1BAF4` (`language_id`),
  KEY `IDX_757D1B7C979B1AD6` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mtx_company_language`
--

INSERT INTO `mtx_company_language` (`id`, `language_id`, `company_id`, `name`, `description`, `adress`, `representation`) VALUES
(1, 1, 1, 'ABC', NULL, NULL, NULL),
(2, 1, 2, 'DEF', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_group`
--

CREATE TABLE IF NOT EXISTS `mtx_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `active` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mtx_group`
--

INSERT INTO `mtx_group` (`id`, `name`, `created_at`, `updated_at`, `active`) VALUES
(1, 'Administrators', '2013-07-08 09:58:04', '2013-07-08 09:58:04', 1),
(2, 'Manager', '2013-07-08 09:58:04', '2013-07-08 09:58:04', 1),
(3, 'Users', '2013-07-08 09:58:04', '2013-07-08 09:58:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_group_role`
--

CREATE TABLE IF NOT EXISTS `mtx_group_role` (
  `group_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`role_id`),
  KEY `IDX_C468F723FE54D947` (`group_id`),
  KEY `IDX_C468F723D60322AC` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mtx_group_role`
--

INSERT INTO `mtx_group_role` (`group_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_language`
--

CREATE TABLE IF NOT EXISTS `mtx_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lang_key` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7A5F6FEF30F485F4` (`lang_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mtx_language`
--

INSERT INTO `mtx_language` (`id`, `name`, `lang_key`, `is_default`) VALUES
(1, 'Vi', 'vi', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_media`
--

CREATE TABLE IF NOT EXISTS `mtx_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_ED6E9F4812469DE2` (`category_id`),
  KEY `IDX_ED6E9F485EE01E44` (`created_id`),
  KEY `IDX_ED6E9F48960CC7F3` (`updated_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mtx_media`
--

INSERT INTO `mtx_media` (`id`, `category_id`, `created_id`, `updated_id`, `name`, `width`, `height`, `created_at`, `updated_at`, `active`) VALUES
(1, 3, NULL, NULL, '51df7b3c63328.jpeg', NULL, NULL, '2013-07-12 10:42:52', '2013-07-12 10:42:52', 1),
(2, 3, NULL, NULL, '51df7b4786131.jpeg', NULL, NULL, '2013-07-12 10:43:03', '2013-07-12 10:43:03', 1),
(3, 7, NULL, NULL, '51df7b57893bc.jpg', NULL, NULL, '2013-07-12 10:43:19', '2013-07-12 10:43:19', 1),
(4, 6, NULL, NULL, '51df7b615ed9c.jpeg', NULL, NULL, '2013-07-12 10:43:29', '2013-07-12 10:43:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_mediacategory`
--

CREATE TABLE IF NOT EXISTS `mtx_mediacategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_70EAB08727ACA70` (`parent_id`),
  KEY `IDX_70EAB085EE01E44` (`created_id`),
  KEY `IDX_70EAB08960CC7F3` (`updated_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `mtx_mediacategory`
--

INSERT INTO `mtx_mediacategory` (`id`, `parent_id`, `created_id`, `updated_id`, `lft`, `rgt`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 1, 2, NULL, NULL, NULL),
(2, NULL, 1, 1, 3, 8, 1, '2013-07-12 10:41:23', '2013-07-12 10:41:23'),
(3, 2, 1, 1, 4, 5, 1, '2013-07-12 10:41:39', '2013-07-12 10:41:39'),
(4, 2, 1, 1, 6, 7, 1, '2013-07-12 10:41:48', '2013-07-12 10:41:48'),
(5, NULL, 1, 1, 9, 14, 1, '2013-07-12 10:41:59', '2013-07-12 10:41:59'),
(6, 5, 1, 1, 10, 11, 1, '2013-07-12 10:42:12', '2013-07-12 10:42:12'),
(7, 5, 1, 1, 12, 13, 1, '2013-07-12 10:42:20', '2013-07-12 10:42:20');

-- --------------------------------------------------------

--
-- Table structure for table `mtx_mediacategory_language`
--

CREATE TABLE IF NOT EXISTS `mtx_mediacategory_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mediacategory_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FBDE26F27B28A30E` (`mediacategory_id`),
  KEY `IDX_FBDE26F282F1BAF4` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `mtx_mediacategory_language`
--

INSERT INTO `mtx_mediacategory_language` (`id`, `mediacategory_id`, `language_id`, `name`) VALUES
(1, 2, 1, 'SẢN PHẨM'),
(2, 3, 1, 'Điệnt Thoại'),
(3, 4, 1, 'Máy Tính'),
(4, 5, 1, 'TIN TỨC'),
(5, 6, 1, 'Xã Hội'),
(6, 7, 1, 'Thể Thao');

-- --------------------------------------------------------

--
-- Table structure for table `mtx_menu`
--

CREATE TABLE IF NOT EXISTS `mtx_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `param` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3798AC02727ACA70` (`parent_id`),
  KEY `IDX_3798AC025EE01E44` (`created_id`),
  KEY `IDX_3798AC02960CC7F3` (`updated_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Dumping data for table `mtx_menu`
--

INSERT INTO `mtx_menu` (`id`, `parent_id`, `created_id`, `updated_id`, `lft`, `rgt`, `status`, `created_at`, `updated_at`, `url`, `type`, `param`, `position`) VALUES
(1, NULL, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, NULL, 1, 1, 3, 4, 1, '2013-07-12 11:01:01', '2013-07-12 11:01:01', '#', 9, NULL, 1),
(10, NULL, 1, 1, 5, 10, 1, '2013-07-12 11:12:41', '2013-07-12 11:12:41', '#', 9, NULL, 1),
(11, 10, 1, 1, 6, 7, 1, '2013-07-12 11:13:19', '2013-07-12 11:13:19', '/news/view-cat/xa_hoi_2.html', 6, 2, 1),
(13, 10, 1, 1, 8, 9, 1, '2013-07-12 11:18:52', '2013-07-12 11:18:52', '/news/view-cat/the_thao_5.html', 6, 5, 1),
(14, NULL, 1, 1, 11, 12, 1, '2013-07-12 11:19:44', '2013-07-12 11:19:44', '/page/detail/gioi_thieu_1.html', 8, 1, 1),
(15, NULL, 1, 1, 13, 24, 1, '2013-07-12 11:20:52', '2013-07-12 11:20:52', '#', 9, NULL, 2),
(16, 15, 1, 1, 14, 21, 1, '2013-07-12 11:21:21', '2013-07-12 11:21:21', '/product/view-branch/dien_thoai_2.html', 3, 2, 2),
(17, 16, 1, 1, 15, 16, 1, '2013-07-12 11:21:41', '2013-07-12 11:21:41', '/product/view-branch/nokia_18_3.html', 3, 3, 2),
(18, 16, 1, 1, 19, 20, 1, '2013-07-12 11:22:12', '2013-07-12 11:22:12', '/product/view-branch/samsung_4.html', 3, 4, 2),
(22, 16, 1, 1, 17, 18, 1, '2013-07-12 11:56:36', '2013-07-12 11:56:36', '/product/view-branch/appel_23_6.html', 3, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_menu_language`
--

CREATE TABLE IF NOT EXISTS `mtx_menu_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EC57E1DECCD7E912` (`menu_id`),
  KEY `IDX_EC57E1DE82F1BAF4` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `mtx_menu_language`
--

INSERT INTO `mtx_menu_language` (`id`, `menu_id`, `language_id`, `name`, `alias`) VALUES
(8, 9, 1, 'TRANG CHỦ', NULL),
(9, 10, 1, 'TIN TỨC', NULL),
(10, 11, 1, 'Xã Hội', NULL),
(12, 13, 1, 'Thể Thao', NULL),
(13, 14, 1, 'GIỚI THIỆU', NULL),
(14, 15, 1, 'SẢN PHẨM', NULL),
(15, 16, 1, 'Điện Thoại', NULL),
(16, 17, 1, 'Nokia', NULL),
(17, 18, 1, 'Samsung', NULL),
(21, 22, 1, 'Appel', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_news`
--

CREATE TABLE IF NOT EXISTS `mtx_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_574E0FC112469DE2` (`category_id`),
  KEY `IDX_574E0FC15EE01E44` (`created_id`),
  KEY `IDX_574E0FC1960CC7F3` (`updated_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mtx_news`
--

INSERT INTO `mtx_news` (`id`, `category_id`, `created_id`, `updated_id`, `status`, `created_at`, `updated_at`, `image`) VALUES
(1, 3, 1, 1, 1, '2013-07-12 10:47:43', '2013-07-12 10:47:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_news_language`
--

CREATE TABLE IF NOT EXISTS `mtx_news_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) DEFAULT NULL,
  `news_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_8938071982F1BAF4` (`language_id`),
  KEY `IDX_89380719B5A459A0` (`news_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mtx_news_language`
--

INSERT INTO `mtx_news_language` (`id`, `language_id`, `news_id`, `name`, `intro`, `description`) VALUES
(1, 1, 1, 'Giáo dục 1', '<p>Gi&aacute;o dục</p>\r\n<p>&nbsp;</p>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_news_media`
--

CREATE TABLE IF NOT EXISTS `mtx_news_media` (
  `news_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`,`media_id`),
  KEY `IDX_AAC8006BB5A459A0` (`news_id`),
  KEY `IDX_AAC8006BEA9FDD75` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mtx_news_media`
--


-- --------------------------------------------------------

--
-- Table structure for table `mtx_page`
--

CREATE TABLE IF NOT EXISTS `mtx_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5E9720B15EE01E44` (`created_id`),
  KEY `IDX_5E9720B1960CC7F3` (`updated_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mtx_page`
--

INSERT INTO `mtx_page` (`id`, `created_id`, `updated_id`, `status`, `created_at`, `updated_at`, `image`) VALUES
(1, 1, 1, 1, '2013-07-12 10:32:52', '2013-07-12 10:32:52', NULL),
(2, 1, 1, 1, '2013-07-12 10:48:06', '2013-07-12 10:48:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_page_language`
--

CREATE TABLE IF NOT EXISTS `mtx_page_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_4099A36882F1BAF4` (`language_id`),
  KEY `IDX_4099A368C4663E4` (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mtx_page_language`
--

INSERT INTO `mtx_page_language` (`id`, `language_id`, `page_id`, `name`, `intro`, `description`) VALUES
(1, 1, 1, 'Giới Thiệu', '<p>Giới thiệu</p>\r\n<p>&nbsp;</p>', NULL),
(2, 1, 2, 'Liên Hệ', '<p>aaaa</p>\r\n<p>&nbsp;</p>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_page_media`
--

CREATE TABLE IF NOT EXISTS `mtx_page_media` (
  `page_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`page_id`,`media_id`),
  KEY `IDX_B6F678E3C4663E4` (`page_id`),
  KEY `IDX_B6F678E3EA9FDD75` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mtx_page_media`
--


-- --------------------------------------------------------

--
-- Table structure for table `mtx_product`
--

CREATE TABLE IF NOT EXISTS `mtx_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_863E14455EE01E44` (`created_id`),
  KEY `IDX_863E1445960CC7F3` (`updated_id`),
  KEY `IDX_863E1445DCD6CC49` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mtx_product`
--

INSERT INTO `mtx_product` (`id`, `created_id`, `updated_id`, `branch_id`, `price`, `unit`, `discount`, `thumb`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 0, NULL, 0, NULL, 0, 1, '2013-07-12 10:46:16', '2013-07-12 10:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `mtx_product_language`
--

CREATE TABLE IF NOT EXISTS `mtx_product_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_A65A64864584665A` (`product_id`),
  KEY `IDX_A65A648682F1BAF4` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mtx_product_language`
--

INSERT INTO `mtx_product_language` (`id`, `product_id`, `language_id`, `name`, `description`) VALUES
(1, 1, 1, 'Nokia Lumia 520', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_product_media`
--

CREATE TABLE IF NOT EXISTS `mtx_product_media` (
  `products_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`products_id`,`media_id`),
  KEY `IDX_DFAD0FAD6C8A81A9` (`products_id`),
  KEY `IDX_DFAD0FADEA9FDD75` (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mtx_product_media`
--

INSERT INTO `mtx_product_media` (`products_id`, `media_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_role`
--

CREATE TABLE IF NOT EXISTS `mtx_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mtx_role`
--

INSERT INTO `mtx_role` (`id`, `role`) VALUES
(1, 'ROLE_SUPER_ADMIN'),
(2, 'ROLE_ADMIN'),
(3, 'ROLE_USER');

-- --------------------------------------------------------

--
-- Table structure for table `mtx_user`
--

CREATE TABLE IF NOT EXISTS `mtx_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `active` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mtx_user`
--

INSERT INTO `mtx_user` (`id`, `username`, `fullname`, `salt`, `password`, `email`, `created_at`, `updated_at`, `active`) VALUES
(1, 'admin', 'Administrator', '3dff5ba95b920c2831d6e2666fc4490a', 'db7eff32e29916c6fb776666de765a33fd1de00d', 'admin@sm.com', '2013-07-08 09:58:04', '2013-07-08 09:58:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_user_group`
--

CREATE TABLE IF NOT EXISTS `mtx_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `IDX_355999A4A76ED395` (`user_id`),
  KEY `IDX_355999A4FE54D947` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mtx_user_group`
--

INSERT INTO `mtx_user_group` (`user_id`, `group_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mtx_user_role`
--

CREATE TABLE IF NOT EXISTS `mtx_user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_A6F8FA57A76ED395` (`user_id`),
  KEY `IDX_A6F8FA57D60322AC` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mtx_user_role`
--

INSERT INTO `mtx_user_role` (`user_id`, `role_id`) VALUES
(1, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acl_entries`
--
ALTER TABLE `acl_entries`
  ADD CONSTRAINT `FK_46C8B8063D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_46C8B806DF9183C9` FOREIGN KEY (`security_identity_id`) REFERENCES `acl_security_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_46C8B806EA000B10` FOREIGN KEY (`class_id`) REFERENCES `acl_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `acl_object_identities`
--
ALTER TABLE `acl_object_identities`
  ADD CONSTRAINT `FK_9407E54977FA751A` FOREIGN KEY (`parent_object_identity_id`) REFERENCES `acl_object_identities` (`id`);

--
-- Constraints for table `acl_object_identity_ancestors`
--
ALTER TABLE `acl_object_identity_ancestors`
  ADD CONSTRAINT `FK_825DE2993D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_825DE299C671CEA1` FOREIGN KEY (`ancestor_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mtx_branch`
--
ALTER TABLE `mtx_branch`
  ADD CONSTRAINT `FK_CAB0DCA85EE01E44` FOREIGN KEY (`created_id`) REFERENCES `mtx_user` (`id`),
  ADD CONSTRAINT `FK_CAB0DCA8727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `mtx_branch` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_CAB0DCA8960CC7F3` FOREIGN KEY (`updated_id`) REFERENCES `mtx_user` (`id`);

--
-- Constraints for table `mtx_branch_language`
--
ALTER TABLE `mtx_branch_language`
  ADD CONSTRAINT `FK_64D3050082F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `mtx_language` (`id`),
  ADD CONSTRAINT `FK_64D30500DCD6CC49` FOREIGN KEY (`branch_id`) REFERENCES `mtx_branch` (`id`);

--
-- Constraints for table `mtx_category`
--
ALTER TABLE `mtx_category`
  ADD CONSTRAINT `FK_A8C8079B5EE01E44` FOREIGN KEY (`created_id`) REFERENCES `mtx_user` (`id`),
  ADD CONSTRAINT `FK_A8C8079B727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `mtx_category` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_A8C8079B960CC7F3` FOREIGN KEY (`updated_id`) REFERENCES `mtx_user` (`id`);

--
-- Constraints for table `mtx_category_language`
--
ALTER TABLE `mtx_category_language`
  ADD CONSTRAINT `FK_B2A3A34012469DE2` FOREIGN KEY (`category_id`) REFERENCES `mtx_category` (`id`),
  ADD CONSTRAINT `FK_B2A3A34082F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `mtx_language` (`id`);

--
-- Constraints for table `mtx_company`
--
ALTER TABLE `mtx_company`
  ADD CONSTRAINT `FK_1ACB19A75EE01E44` FOREIGN KEY (`created_id`) REFERENCES `mtx_user` (`id`),
  ADD CONSTRAINT `FK_1ACB19A7960CC7F3` FOREIGN KEY (`updated_id`) REFERENCES `mtx_user` (`id`),
  ADD CONSTRAINT `FK_1ACB19A7C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `mtx_companytype` (`id`);

--
-- Constraints for table `mtx_companytype`
--
ALTER TABLE `mtx_companytype`
  ADD CONSTRAINT `FK_9AF919955EE01E44` FOREIGN KEY (`created_id`) REFERENCES `mtx_user` (`id`),
  ADD CONSTRAINT `FK_9AF91995960CC7F3` FOREIGN KEY (`updated_id`) REFERENCES `mtx_user` (`id`);

--
-- Constraints for table `mtx_companytype_language`
--
ALTER TABLE `mtx_companytype_language`
  ADD CONSTRAINT `FK_54F6538B1E00F65` FOREIGN KEY (`companytype_id`) REFERENCES `mtx_companytype` (`id`),
  ADD CONSTRAINT `FK_54F6538B82F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `mtx_language` (`id`);

--
-- Constraints for table `mtx_company_language`
--
ALTER TABLE `mtx_company_language`
  ADD CONSTRAINT `FK_757D1B7C82F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `mtx_language` (`id`),
  ADD CONSTRAINT `FK_757D1B7C979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `mtx_company` (`id`);

--
-- Constraints for table `mtx_group_role`
--
ALTER TABLE `mtx_group_role`
  ADD CONSTRAINT `FK_C468F723D60322AC` FOREIGN KEY (`role_id`) REFERENCES `mtx_role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C468F723FE54D947` FOREIGN KEY (`group_id`) REFERENCES `mtx_group` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mtx_media`
--
ALTER TABLE `mtx_media`
  ADD CONSTRAINT `FK_ED6E9F4812469DE2` FOREIGN KEY (`category_id`) REFERENCES `mtx_mediacategory` (`id`),
  ADD CONSTRAINT `FK_ED6E9F485EE01E44` FOREIGN KEY (`created_id`) REFERENCES `mtx_user` (`id`),
  ADD CONSTRAINT `FK_ED6E9F48960CC7F3` FOREIGN KEY (`updated_id`) REFERENCES `mtx_user` (`id`);

--
-- Constraints for table `mtx_mediacategory`
--
ALTER TABLE `mtx_mediacategory`
  ADD CONSTRAINT `FK_70EAB085EE01E44` FOREIGN KEY (`created_id`) REFERENCES `mtx_user` (`id`),
  ADD CONSTRAINT `FK_70EAB08727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `mtx_mediacategory` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_70EAB08960CC7F3` FOREIGN KEY (`updated_id`) REFERENCES `mtx_user` (`id`);

--
-- Constraints for table `mtx_mediacategory_language`
--
ALTER TABLE `mtx_mediacategory_language`
  ADD CONSTRAINT `FK_FBDE26F27B28A30E` FOREIGN KEY (`mediacategory_id`) REFERENCES `mtx_mediacategory` (`id`),
  ADD CONSTRAINT `FK_FBDE26F282F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `mtx_language` (`id`);

--
-- Constraints for table `mtx_menu`
--
ALTER TABLE `mtx_menu`
  ADD CONSTRAINT `FK_3798AC025EE01E44` FOREIGN KEY (`created_id`) REFERENCES `mtx_user` (`id`),
  ADD CONSTRAINT `FK_3798AC02727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `mtx_menu` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_3798AC02960CC7F3` FOREIGN KEY (`updated_id`) REFERENCES `mtx_user` (`id`);

--
-- Constraints for table `mtx_menu_language`
--
ALTER TABLE `mtx_menu_language`
  ADD CONSTRAINT `FK_EC57E1DE82F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `mtx_language` (`id`),
  ADD CONSTRAINT `FK_EC57E1DECCD7E912` FOREIGN KEY (`menu_id`) REFERENCES `mtx_menu` (`id`);

--
-- Constraints for table `mtx_news`
--
ALTER TABLE `mtx_news`
  ADD CONSTRAINT `FK_574E0FC112469DE2` FOREIGN KEY (`category_id`) REFERENCES `mtx_category` (`id`),
  ADD CONSTRAINT `FK_574E0FC15EE01E44` FOREIGN KEY (`created_id`) REFERENCES `mtx_user` (`id`),
  ADD CONSTRAINT `FK_574E0FC1960CC7F3` FOREIGN KEY (`updated_id`) REFERENCES `mtx_user` (`id`);

--
-- Constraints for table `mtx_news_language`
--
ALTER TABLE `mtx_news_language`
  ADD CONSTRAINT `FK_8938071982F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `mtx_language` (`id`),
  ADD CONSTRAINT `FK_89380719B5A459A0` FOREIGN KEY (`news_id`) REFERENCES `mtx_news` (`id`);

--
-- Constraints for table `mtx_news_media`
--
ALTER TABLE `mtx_news_media`
  ADD CONSTRAINT `FK_AAC8006BB5A459A0` FOREIGN KEY (`news_id`) REFERENCES `mtx_news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_AAC8006BEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `mtx_media` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mtx_page`
--
ALTER TABLE `mtx_page`
  ADD CONSTRAINT `FK_5E9720B15EE01E44` FOREIGN KEY (`created_id`) REFERENCES `mtx_user` (`id`),
  ADD CONSTRAINT `FK_5E9720B1960CC7F3` FOREIGN KEY (`updated_id`) REFERENCES `mtx_user` (`id`);

--
-- Constraints for table `mtx_page_language`
--
ALTER TABLE `mtx_page_language`
  ADD CONSTRAINT `FK_4099A36882F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `mtx_language` (`id`),
  ADD CONSTRAINT `FK_4099A368C4663E4` FOREIGN KEY (`page_id`) REFERENCES `mtx_page` (`id`);

--
-- Constraints for table `mtx_page_media`
--
ALTER TABLE `mtx_page_media`
  ADD CONSTRAINT `FK_B6F678E3C4663E4` FOREIGN KEY (`page_id`) REFERENCES `mtx_page` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B6F678E3EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `mtx_media` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mtx_product`
--
ALTER TABLE `mtx_product`
  ADD CONSTRAINT `FK_863E14455EE01E44` FOREIGN KEY (`created_id`) REFERENCES `mtx_user` (`id`),
  ADD CONSTRAINT `FK_863E1445960CC7F3` FOREIGN KEY (`updated_id`) REFERENCES `mtx_user` (`id`),
  ADD CONSTRAINT `FK_863E1445DCD6CC49` FOREIGN KEY (`branch_id`) REFERENCES `mtx_branch` (`id`);

--
-- Constraints for table `mtx_product_language`
--
ALTER TABLE `mtx_product_language`
  ADD CONSTRAINT `FK_A65A64864584665A` FOREIGN KEY (`product_id`) REFERENCES `mtx_product` (`id`),
  ADD CONSTRAINT `FK_A65A648682F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `mtx_language` (`id`);

--
-- Constraints for table `mtx_product_media`
--
ALTER TABLE `mtx_product_media`
  ADD CONSTRAINT `FK_DFAD0FAD6C8A81A9` FOREIGN KEY (`products_id`) REFERENCES `mtx_product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DFAD0FADEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `mtx_media` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mtx_user_group`
--
ALTER TABLE `mtx_user_group`
  ADD CONSTRAINT `FK_355999A4A76ED395` FOREIGN KEY (`user_id`) REFERENCES `mtx_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_355999A4FE54D947` FOREIGN KEY (`group_id`) REFERENCES `mtx_group` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mtx_user_role`
--
ALTER TABLE `mtx_user_role`
  ADD CONSTRAINT `FK_A6F8FA57A76ED395` FOREIGN KEY (`user_id`) REFERENCES `mtx_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A6F8FA57D60322AC` FOREIGN KEY (`role_id`) REFERENCES `mtx_role` (`id`) ON DELETE CASCADE;
