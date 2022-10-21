-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3302
-- Generation Time: Jun 02, 2021 at 06:51 AM

--  Password: y4^h]%]&e?Nz

-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sowdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `boards`
--

DROP TABLE IF EXISTS `boards`;
CREATE TABLE IF NOT EXISTS `boards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `board_type_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `id_number` int(11) NOT NULL,
  `condition` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'פגום-0 תקין-1',
  `length` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `thickness` float NOT NULL,
  `time_borrowed` timestamp NULL DEFAULT NULL,
  `time_returned` timestamp NULL DEFAULT NULL,
  `number_of_rents` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_number` (`id_number`),
  KEY `FK_equipments_board_types` (`board_type_id`),
  KEY `FK_equipments_customers` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `boards`
--

INSERT INTO `boards` (`id`, `board_type_id`, `customer_id`, `id_number`, `condition`, `length`, `width`, `thickness`, `time_borrowed`, `time_returned`, `number_of_rents`) VALUES
(1, 1, NULL, 12004, 1, 190, 48, 6.5, NULL, '2021-04-12 15:17:42', 2),
(2, 1, NULL, 12000, 1, 190, 48, 6.5, NULL, NULL, 0),
(3, 1, NULL, 12001, 1, 190, 48, 6.5, NULL, NULL, 0),
(4, 1, NULL, 12006, 1, 190, 48, 6.5, NULL, NULL, 0),
(5, 1, NULL, 11000, 1, 178, 48, 5.7, NULL, '2021-05-07 13:00:32', 6),
(6, 1, NULL, 11001, 1, 178, 48, 5.7, NULL, NULL, 0),
(7, 1, NULL, 12002, 1, 190, 48, 6.5, NULL, NULL, 0),
(8, 1, NULL, 12003, 1, 190, 48, 6.5, NULL, NULL, 0),
(9, 1, NULL, 11002, 1, 178, 48, 5.7, NULL, NULL, 0),
(10, 1, NULL, 11003, 1, 178, 48, 5.7, NULL, NULL, 0),
(11, 1, NULL, 11004, 0, 175, 48, 5.7, NULL, '2021-04-20 07:51:47', 3),
(12, 1, NULL, 11005, 1, 178, 48, 5.7, NULL, NULL, 0),
(13, 1, NULL, 11006, 1, 178, 48, 5.7, NULL, NULL, 0),
(14, 1, NULL, 12005, 1, 190, 48, 6.5, NULL, NULL, 0),
(15, 1, NULL, 13000, 1, 200, 58, 7.5, NULL, '2021-04-20 07:52:02', 3),
(16, 1, NULL, 13001, 1, 230, 58, 7, NULL, '2021-05-07 09:21:57', 3),
(17, 1, NULL, 13002, 1, 200, 58, 7, NULL, '2021-05-27 18:21:24', 1),
(18, 1, NULL, 13003, 0, 200, 58, 7, NULL, '2021-01-07 19:49:58', 1),
(19, 2, NULL, 21000, 1, 200, 58, 7, NULL, NULL, 0),
(20, 2, NULL, 21001, 1, 200, 58, 7, NULL, NULL, 0),
(21, 2, NULL, 21002, 1, 200, 58, 7, NULL, NULL, 0),
(22, 2, NULL, 21003, 1, 200, 58, 7, NULL, NULL, 0),
(23, 2, NULL, 21004, 1, 200, 58, 7, NULL, NULL, 0),
(24, 2, NULL, 21005, 1, 200, 58, 7, NULL, NULL, 0),
(25, 2, NULL, 22000, 1, 200, 58, 7.5, NULL, NULL, 0),
(26, 3, NULL, 31000, 0, 200, 58, 7.5, NULL, '2021-01-09 17:57:20', 1),
(27, 3, NULL, 31001, 0, 200, 58, 7.5, NULL, NULL, 0),
(28, 3, NULL, 31002, 1, 200, 58, 7.5, NULL, '2021-05-06 09:21:13', 1),
(29, 3, NULL, 31003, 1, 200, 58, 7, NULL, NULL, 0),
(30, 3, NULL, 31004, 1, 190, 58, 7.5, NULL, NULL, 0),
(31, 2, NULL, 210010, 1, 200, 58, 7, NULL, NULL, 0),
(32, 2, NULL, 220011, 1, 200, 58, 7.5, NULL, NULL, 0),
(33, 2, NULL, 210012, 1, 200, 58, 7, NULL, NULL, 0),
(34, 2, NULL, 220013, 0, 200, 58, 7.5, NULL, NULL, 0),
(35, 1, NULL, 13009, 1, 250, 58, 7, NULL, '2021-05-23 17:17:16', 1),
(36, 1, NULL, 130010, 1, 187, 50, 7, NULL, NULL, 0),
(37, 1, NULL, 13000009, 1, 228, 54, 7.5, NULL, NULL, 0),
(38, 2, NULL, 1111111111, 1, 200, 58, 7, NULL, NULL, 0),
(40, 3, NULL, 1111222, 1, 178, 54, 5.7, NULL, NULL, 0),
(42, 3, NULL, 11112222, 1, 178, 58, 7, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `board_types`
--

DROP TABLE IF EXISTS `board_types`;
CREATE TABLE IF NOT EXISTS `board_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `board_types`
--

INSERT INTO `board_types` (`id`, `name`) VALUES
(1, 'Soft'),
(2, 'Funboard'),
(3, 'Hard');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_number` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `max_participants` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_number` (`course_number`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_number`, `name`, `price`, `max_participants`) VALUES
(1, 4000, 'הדרכת גלישה', 150, 6);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `id_number` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `insurance` tinyint(4) NOT NULL DEFAULT '0',
  `gender` tinyint(4) NOT NULL COMMENT '1 - female, 2 - male',
  `weight` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `level_id` int(11) NOT NULL DEFAULT '1',
  `board_type_id` int(11) NOT NULL DEFAULT '1',
  `suit_size_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_number` (`id_number`),
  KEY `FK_customers_board_types` (`board_type_id`),
  KEY `FK_customers_levels` (`level_id`),
  KEY `FK_customers_suits_sizes` (`suit_size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `id_number`, `date_of_birth`, `email`, `phone`, `city`, `address`, `insurance`, `gender`, `weight`, `height`, `level_id`, `board_type_id`, `suit_size_id`) VALUES
(5, 'ליחן אברהם', 209865435, '2000-10-30', 'lihenav7@gmail.com', '0545668995', 'ראשון לציון', 'חללי דקר 4', 1, 1, 67, 167, 1, 1, 1),
(6, 'שחר בן שמעון', 209655435, '2001-10-23', 'shahar66@gmail.com', '0545668954', 'הרצליה', 'בן גוריון 902', 0, 1, 68, 168, 2, 2, 1),
(7, 'איתי פלג', 207865456, '1993-07-07', 'plg@gmail.com', '05435550882', 'אור עקיבא', 'בן גוריון 8', 1, 2, 60, 164, 1, 1, 2),
(9, 'פרח אפרגן', 720547124, '2021-04-06', 'per@gmail.com', '0522369983', 'בית שאן', 'תאנה', 1, 1, 77, 170, 1, 1, 3),
(10, 'נעמה כהן', 205471246, '1994-09-12', 'staveu1994@gmail.com', '0545776005', 'בית שאן', 'עדולם', 1, 1, 60, 164, 1, 1, 2),
(11, 'חלי רביב', 205471288, '1988-05-05', 'per@gmail.com', '0522369983', 'הרצליה', 'תאנה', 1, 1, 58, 160, 1, 1, 1),
(12, 'שחר גולדשטיין', 304534321, '1993-06-22', 'shahrgo@gmail.com', '0545667885', 'הרצליה', 'הדר ב', 1, 1, 65, 162, 1, 1, 1),
(13, 'דנית זוארץ', 207654565, '1987-04-04', 'danitplg@gmail.com', '0524565445', 'תל אביב', 'מש/ה שרת 5', 1, 1, 66, 155, 2, 1, 1),
(14, 'נאור צור שדי', 205467976, '1992-06-09', 'naor.zur@gmail.com', '0508665446', 'הרצליה', 'הרצל 15', 1, 2, 70, 165, 3, 1, 1),
(15, 'שיר ניצן', 203431235, '1994-08-12', 'shir@gmail.com', '0509889776', 'פתח תקווה', 'האצל 8', 1, 1, 59, 166, 2, 1, 1),
(16, 'שיר זיו', 203431233, '1994-07-12', 'shir@gmail.com', '0509889776', 'פתח תקווה', 'האצל 8', 1, 1, 59, 166, 2, 1, 1),
(17, 'שיר אלבז', 203431287, '1994-07-12', 'shirel@gmail.com', '0509889789', 'כפר סבא', 'האצל 9', 1, 1, 59, 167, 1, 1, 1),
(18, 'מיכל שבתאי', 205465899, '1994-07-20', 'mic@gmail.com', '0545668990', 'תל אביב', 'העצמאות 8', 1, 1, 68, 158, 1, 1, 1),
(19, 'שימי הדר', 205466787, '1994-07-07', 'shimil@gmail.com', '0545667665', 'הרצליה', 'הרקפת 9', 1, 2, 72, 166, 2, 1, 3),
(21, 'איתי ממן', 305456545, '1992-07-09', 'itay7@gmail.com', '0523445667', 'חדרה', 'גיבורים 98', 1, 2, 90, 175, 2, 1, 4),
(22, 'משה אטיאס', 204712587, '1994-03-09', 'mosh@gmail.com', '0509887665', 'חדרה', 'תאנה 13', 1, 2, 66, 167, 1, 1, 2),
(23, 'פרח אלבז', 308909865, '1991-08-09', 'per44@gmail.com', '0522369922', 'אור עקיבא', 'בן גוריון 88', 1, 1, 62, 166, 1, 1, 2),
(26, 'משה חי', 305423128, '1992-05-09', 'ran8@gmail.com', '0505776009', 'כפר שמריהו', ' נוף 9', 1, 2, 70, 170, 1, 1, 2),
(27, 'אראל מנחם', 205676896, '1994-02-17', 'arel@gmail.com', '0546882331', 'תל אביב', 'דוד רמז 3 ', 1, 1, 58, 163, 3, 1, 2),
(28, 'איתייי', 123456788, '2021-05-05', 'ran8@gmail.com', '0522369983', 'בית שאן', 'תאנה', 1, 2, 5, 66, 1, 1, 1),
(29, 'רעות פז', 303765678, '1995-08-19', 'reut@gmail.com', '0505776887', 'הוד השרון', 'הרצל 7', 1, 1, 60, 166, 3, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `customers_schedules`
--

DROP TABLE IF EXISTS `customers_schedules`;
CREATE TABLE IF NOT EXISTS `customers_schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `is_cancelled` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`,`schedule_id`),
  KEY `FK_customers_schedules_customer` (`customer_id`),
  KEY `FK_customers_schedules_schedules` (`schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers_schedules`
--

INSERT INTO `customers_schedules` (`id`, `customer_id`, `schedule_id`, `is_cancelled`) VALUES
(18, 5, 19, 0),
(19, 5, 11, 0),
(20, 5, 13, 0),
(22, 6, 19, 0),
(39, 7, 21, 0),
(40, 7, 1, 0),
(53, 7, 38, 1),
(55, 11, 38, 1),
(56, 10, 98, 0),
(57, 10, 118, 0),
(58, 10, 136, 0);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '3',
  `id_number` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_number` (`id_number`),
  KEY `FK_role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `role_id`, `id_number`, `username`, `password`, `name`, `email`, `phone`, `city`, `address`) VALUES
(1, 1, '209897656', 'dotan', '1234', 'דותן', 'dotan@reef.co.il', '0523334556', 'הרצליה', 'בן גוריון 8'),
(2, 2, '304532123', 'liaam', '1111', 'ליאם', 'liam@reef.co.il', '0545342334', 'הרצליה', 'סטנלי מאיר 902'),
(3, 3, '205765676', 'adik', '1993', 'עדי בר', 'adi@reef.co.il', '0545776009', 'תל אביב', 'הרצל 16'),
(4, 3, '205895676', 'romi10', '2054', 'רומי פלג', 'romi@reef.co.il', '0525778009', 'תל אביב', 'יוסף פעמוני 10'),
(5, 4, '056456056', 'rotia', '0564', 'רותי אברהם', 'roti@reef.co.il', '0545776009', 'הרצליה', 'הגיבורים 9'),
(6, 3, '205457898', 'noam12', '123456', 'נועם גולן', 'noam@reef.co.il', '0545667990', 'הרצליה', 'המסגר 10'),
(8, 3, '303456765', 'moshelev', '123456789', 'משה לוי', 'moshe@reef.co.il', '0524556889', 'ראשון לציון', 'המסגר 10');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

DROP TABLE IF EXISTS `levels`;
CREATE TABLE IF NOT EXISTS `levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`) VALUES
(1, 'מתחיל'),
(2, 'בינוני'),
(3, 'מתקדם');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'מנהל'),
(2, 'אחראי מדריכים'),
(3, 'מדריך'),
(4, 'מזכירה');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `date_at` date NOT NULL,
  `start_at` int(11) NOT NULL,
  `is_approved` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_schedules_courses` (`course_id`),
  KEY `FK_schedules_employees` (`employee_id`),
  KEY `course_id` (`course_id`,`employee_id`,`date_at`,`start_at`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `course_id`, `employee_id`, `date_at`, `start_at`, `is_approved`) VALUES
(1, 1, 3, '2021-02-03', 10, 1),
(2, 1, 4, '2020-11-15', 12, 1),
(3, 1, 3, '2020-11-15', 14, 1),
(4, 1, 8, '2020-01-02', 10, 1),
(5, 1, 4, '2021-02-02', 12, 1),
(6, 1, 6, '2021-05-09', 14, 1),
(9, 1, 3, '2020-11-17', 16, 1),
(10, 1, 2, '2021-02-02', 8, 1),
(11, 1, 3, '2020-11-15', 16, 1),
(12, 1, 4, '2020-11-18', 16, 1),
(13, 1, 4, '2020-12-29', 12, 1),
(14, 1, 2, '2021-02-15', 8, 1),
(15, 1, 3, '2021-02-02', 14, 1),
(16, 1, 3, '2021-05-13', 14, 1),
(17, 1, 3, '2021-05-13', 14, 1),
(18, 1, 3, '2021-02-03', 12, 1),
(19, 1, 2, '2021-02-15', 16, 1),
(20, 1, 4, '2021-01-10', 14, 1),
(21, 1, 3, '2021-01-08', 14, 1),
(22, 1, 2, '2021-01-06', 12, 1),
(27, 1, 3, '2021-02-04', 12, 1),
(28, 1, 3, '2021-02-04', 10, 1),
(29, 1, 3, '2021-02-05', 12, 1),
(30, 1, 2, '2021-02-04', 8, 1),
(31, 1, 8, '2021-02-04', 14, 1),
(32, 1, NULL, '2021-02-05', 12, 1),
(33, 1, 2, '2021-01-06', 8, 1),
(34, 1, NULL, '2021-02-06', 10, 1),
(35, 1, NULL, '2021-02-06', 8, 1),
(36, 1, NULL, '2021-02-06', 16, 1),
(37, 1, 2, '2021-05-09', 10, 1),
(38, 1, NULL, '2021-05-09', 8, 1),
(39, 1, 3, '2021-05-02', 8, 1),
(41, 1, NULL, '2021-05-09', 10, 1),
(42, 1, NULL, '2021-05-11', 12, 1),
(43, 1, NULL, '2021-05-10', 10, 1),
(44, 1, NULL, '2021-05-12', 14, 1),
(45, 1, NULL, '2021-05-12', 16, 1),
(46, 1, NULL, '2021-05-12', 14, 1),
(47, 1, NULL, '2021-05-14', 12, 1),
(48, 1, NULL, '2021-05-14', 8, 1),
(49, 1, NULL, '2021-05-12', 14, 1),
(50, 1, NULL, '2021-05-09', 8, 1),
(51, 1, NULL, '2021-05-13', 10, 1),
(97, 1, 6, '2021-05-26', 14, 1),
(98, 1, 2, '2021-05-25', 12, 1),
(99, 1, 6, '2021-05-25', 12, 1),
(102, 1, 2, '2021-05-26', 8, 1),
(103, 1, 6, '2021-05-26', 8, 1),
(104, 1, 2, '2021-05-16', 8, 1),
(105, 1, NULL, '2021-05-11', 10, 0),
(106, 1, NULL, '2021-05-17', 8, 0),
(107, 1, NULL, '2021-05-16', 10, 0),
(108, 1, NULL, '2021-05-16', 12, 0),
(109, 1, NULL, '2021-05-17', 8, 0),
(110, 1, NULL, '2021-05-19', 12, 0),
(111, 1, NULL, '2021-05-19', 12, 0),
(112, 1, NULL, '2021-05-21', 10, 0),
(113, 1, 2, '2021-05-26', 10, 1),
(114, 1, 2, '2021-05-24', 8, 1),
(115, 1, 3, '2021-05-24', 8, 1),
(116, 1, NULL, '2021-05-22', 8, 0),
(117, 1, 3, '2021-05-28', 12, 1),
(118, 1, 3, '2021-05-30', 8, 1),
(119, 1, 4, '2021-05-30', 8, 1),
(120, 1, 3, '2021-05-30', 10, 1),
(121, 1, 3, '2021-05-31', 8, 1),
(122, 1, 6, '2021-05-31', 10, 1),
(123, 1, 3, '2021-05-31', 10, 1),
(124, 1, 4, '2021-05-31', 14, 1),
(125, 1, 6, '2021-05-31', 14, 1),
(126, 1, 3, '2021-05-31', 16, 1),
(127, 1, 3, '2021-06-01', 8, 1),
(128, 1, 3, '2021-06-01', 10, 1),
(129, 1, 6, '2021-06-01', 10, 1),
(130, 1, 6, '2021-06-02', 10, 1),
(131, 1, 8, '2021-06-02', 10, 1),
(132, 1, 6, '2021-06-02', 12, 1),
(133, 1, 8, '2021-06-02', 12, 1),
(134, 1, 6, '2021-06-02', 14, 1),
(135, 1, 8, '2021-06-02', 16, 1),
(136, 1, 6, '2021-06-03', 10, 1),
(137, 1, 8, '2021-06-03', 14, 1),
(138, 1, 8, '2021-06-04', 14, 1),
(139, 1, 6, '2021-06-04', 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `suits`
--

DROP TABLE IF EXISTS `suits`;
CREATE TABLE IF NOT EXISTS `suits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_number` int(11) NOT NULL,
  `condition` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'פגום-0 תקין-1',
  `customer_id` int(11) DEFAULT NULL,
  `brand` varchar(50) NOT NULL,
  `size_id` int(11) NOT NULL,
  `gender` tinyint(4) NOT NULL COMMENT '1 - female, 2 - male',
  `time_borrowed` timestamp NULL DEFAULT NULL,
  `time_returned` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_number` (`id_number`),
  UNIQUE KEY `customer_id` (`customer_id`),
  KEY `FK_suits_suits_sizes` (`size_id`),
  KEY `FK_suits_customers` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `suits`
--

INSERT INTO `suits` (`id`, `id_number`, `condition`, `customer_id`, `brand`, `size_id`, `gender`, `time_borrowed`, `time_returned`) VALUES
(1, 435457, 1, 11, 'Onil', 2, 1, NULL, '2021-04-29 13:31:45'),
(2, 436345, 1, NULL, 'Rip Curl', 2, 2, NULL, '2021-05-14 14:11:48'),
(3, 435458, 1, NULL, 'Onil', 2, 1, NULL, '2021-05-30 16:44:41'),
(4, 435460, 1, NULL, 'Onil', 4, 2, NULL, NULL),
(5, 435461, 1, NULL, 'Onil', 2, 1, NULL, NULL),
(6, 435459, 1, NULL, 'Onil', 4, 2, NULL, NULL),
(7, 435462, 1, NULL, 'Onil', 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suits_sizes`
--

DROP TABLE IF EXISTS `suits_sizes`;
CREATE TABLE IF NOT EXISTS `suits_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size_name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `suits_sizes`
--

INSERT INTO `suits_sizes` (`id`, `size_name`) VALUES
(1, 'Small'),
(2, 'Medium'),
(3, 'Large'),
(4, 'XLarge');

-- --------------------------------------------------------

--
-- Table structure for table `working_days`
--

DROP TABLE IF EXISTS `working_days`;
CREATE TABLE IF NOT EXISTS `working_days` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_id` (`employee_id`,`date`),
  KEY `FK_working_houres_employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `working_days`
--

INSERT INTO `working_days` (`id`, `employee_id`, `date`) VALUES
(140, 1, '2021-06-02'),
(3, 2, '2020-11-19'),
(6, 2, '2020-12-20'),
(7, 2, '2020-12-21'),
(10, 2, '2020-12-22'),
(13, 2, '2020-12-27'),
(8, 2, '2020-12-28'),
(9, 2, '2020-12-29'),
(12, 2, '2020-12-30'),
(32, 2, '2021-02-05'),
(31, 2, '2021-02-13'),
(141, 2, '2021-05-02'),
(30, 2, '2021-05-09'),
(11, 2, '2021-05-10'),
(2, 2, '2021-05-12'),
(45, 2, '2021-05-16'),
(48, 2, '2021-05-24'),
(53, 2, '2021-05-25'),
(51, 2, '2021-05-26'),
(136, 2, '2021-07-25'),
(125, 2, '2021-07-28'),
(124, 2, '2021-07-29'),
(154, 2, '2021-08-19'),
(14, 3, '2020-12-15'),
(15, 3, '2020-12-16'),
(16, 3, '2020-12-20'),
(17, 3, '2020-12-27'),
(37, 3, '2021-02-04'),
(36, 3, '2021-02-05'),
(35, 3, '2021-02-14'),
(39, 3, '2021-05-11'),
(38, 3, '2021-05-12'),
(34, 3, '2021-05-13'),
(47, 3, '2021-05-19'),
(49, 3, '2021-05-24'),
(5, 3, '2021-05-28'),
(56, 3, '2021-05-30'),
(57, 3, '2021-05-31'),
(60, 3, '2021-06-01'),
(72, 3, '2021-06-06'),
(73, 3, '2021-06-09'),
(74, 3, '2021-06-13'),
(75, 3, '2021-06-20'),
(76, 3, '2021-06-27'),
(137, 3, '2021-06-28'),
(130, 3, '2021-07-08'),
(144, 3, '2021-07-22'),
(155, 3, '2021-08-27'),
(18, 4, '2020-12-15'),
(19, 4, '2020-12-16'),
(20, 4, '2020-12-17'),
(21, 4, '2020-12-20'),
(22, 4, '2020-12-21'),
(23, 4, '2020-12-22'),
(24, 4, '2020-12-23'),
(25, 4, '2020-12-24'),
(26, 4, '2020-12-28'),
(27, 4, '2020-12-29'),
(28, 4, '2020-12-30'),
(44, 4, '2021-02-02'),
(29, 4, '2021-05-09'),
(33, 4, '2021-05-10'),
(4, 4, '2021-05-11'),
(61, 4, '2021-05-30'),
(64, 4, '2021-05-31'),
(97, 4, '2021-06-14'),
(96, 4, '2021-06-17'),
(95, 4, '2021-06-22'),
(94, 4, '2021-06-24'),
(122, 4, '2021-07-08'),
(150, 4, '2021-08-09'),
(151, 4, '2021-08-10'),
(55, 5, '2021-05-26'),
(52, 6, '2021-05-25'),
(54, 6, '2021-05-26'),
(69, 6, '2021-05-31'),
(1, 6, '2021-06-01'),
(65, 6, '2021-06-02'),
(68, 6, '2021-06-03'),
(92, 6, '2021-06-04'),
(104, 6, '2021-06-16'),
(111, 6, '2021-06-21'),
(103, 6, '2021-06-23'),
(110, 6, '2021-06-28'),
(102, 6, '2021-06-29'),
(105, 6, '2021-06-30'),
(118, 6, '2021-07-04'),
(129, 6, '2021-07-14'),
(133, 6, '2021-07-21'),
(127, 6, '2021-07-22'),
(82, 8, '2021-06-02'),
(83, 8, '2021-06-03'),
(88, 8, '2021-06-04'),
(120, 8, '2021-06-10'),
(114, 8, '2021-06-23'),
(115, 8, '2021-06-27'),
(89, 8, '2021-06-28'),
(132, 8, '2021-07-20'),
(146, 8, '2021-08-15'),
(147, 8, '2021-08-16');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boards`
--
ALTER TABLE `boards`
  ADD CONSTRAINT `FK_equipments_board_types` FOREIGN KEY (`board_type_id`) REFERENCES `board_types` (`id`),
  ADD CONSTRAINT `FK_equipments_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `FK_customers_board_types` FOREIGN KEY (`board_type_id`) REFERENCES `board_types` (`id`),
  ADD CONSTRAINT `FK_customers_levels` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`),
  ADD CONSTRAINT `FK_customers_suits_sizes` FOREIGN KEY (`suit_size_id`) REFERENCES `suits_sizes` (`id`);

--
-- Constraints for table `customers_schedules`
--
ALTER TABLE `customers_schedules`
  ADD CONSTRAINT `FK_customers_schedules_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `FK_customers_schedules_schedules` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `FK_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `FK_schedules_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `FK_schedules_employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `suits`
--
ALTER TABLE `suits`
  ADD CONSTRAINT `FK_suits_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `FK_suits_suits_sizes` FOREIGN KEY (`size_id`) REFERENCES `suits_sizes` (`id`);

--
-- Constraints for table `working_days`
--
ALTER TABLE `working_days`
  ADD CONSTRAINT `FK_working_houres_employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
