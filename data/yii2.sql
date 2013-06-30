-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 30, 2013 at 09:04 PM
-- Server version: 5.6.10-log
-- PHP Version: 5.4.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yii2`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog`
--

CREATE TABLE IF NOT EXISTS `tbl_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tbl_blog`
--

INSERT INTO `tbl_blog` (`id`, `author_id`, `title`, `content`, `status`, `create_time`, `update_time`) VALUES
(1, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589399, 1372589399),
(2, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(3, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(4, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(5, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(6, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(7, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(8, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(9, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(10, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(11, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(12, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(13, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(14, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(15, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(16, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(17, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(18, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(19, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555),
(20, 1, 'Errem pertinax theophrastus his ut.', 'Errem pertinax theophrastus his ut. Sale ipsum officiis cum at, aliquid assueverit ad mei. Pro lorem oporteat at. Dicant nemore eu vix. Vel cu eripuit labores, per et molestie dissentiunt, eu agam delicata scriptorem ius. Nec ex simul urbanitas, legimus corpora pri ut.\r\nEa nec case minim tamquam, an vix indoctum forensibus. Vim ne quando detracto, atomorum disputationi cu sea. Vis an omnium audire, in pri consul rationibus, tollit commodo eloquentiam ut nec. In vis dicta verear, lucilius delicatissimi ad sed, simul nobis eu est.\r\nIusto molestiae vis ea, graece officiis laboramus sed ei. Eu eius saepe volumus sed, ne vim novum viderer maluisset. In cetero iisque disputando sea, modo honestatis mei id. Per habeo nonumes scriptorem no, ex torquatos philosophia vim. Omnium tibique quo ex, erant quidam semper no mea.', 1, 1372589555, 1372589555);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE IF NOT EXISTS `tbl_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `FK_comment_model_id` (`model_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_comment`
--

INSERT INTO `tbl_comment` (`id`, `author_id`, `model_id`, `content`, `status`, `create_time`, `update_time`) VALUES
(1, 1, 1, 'Comment #1', 1, 1372589630, 1372589630),
(2, 1, 1, 'Comment #2', 1, 1372589635, 1372589635),
(3, 1, 2, 'Comment #3', 1, 1372589648, 1372589648),
(4, 1, 3, 'Comment #4', 1, 1372589659, 1372589659),
(5, 1, 4, 'Comment #5', 1, 1372589668, 1372589668),
(6, 1, 5, 'Comment #6', 1, 1372589902, 1372589919);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1372584985),
('m130622_063909_create_users_tbl', 1372584987),
('m130626_203236_create_blogs_tbl', 1372584987),
('m130627_213012_create_comments_tbl', 1372584987);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `activkey` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password_hash`, `activkey`, `email`, `role`, `status`, `create_time`, `update_time`) VALUES
(1, 'admin', '$2y$13$00gAJw5qmPThYAMVMCw6EO52vwMFtzTCvz4UELu2FQuFty.8Bf7zy', 'Rqq8EEIYxKe0FVZ6mUnea797IFvNMmAQ', 'admin@admin.com', 1, 1, 1372585014, 1372585050),
(2, 'test1', '$2y$13$6k/sPIEVVML5lFwIVeIhEuaKvS8.1k55kLttM8wEiOYQJechD32h6', 'kiDBlDwy/41dIbdwYVp2bsKVv+pl/+Hf', 'test1@test.com', 0, 1, 1372585089, 1372585089),
(3, 'test2', '$2y$13$YF6tHLJ0TcfLGyn.V3jYReGz.O94YZ.Z28sa1egzplUbwVFmNGJAS', 'xbpzEvMO1jGbgqXuc5QGyrEozQSRHOJe', 'test2@test.com', 0, 1, 1372585090, 1372585090),
(4, 'test3', '$2y$13$SroL5a5UDlH8dbUPS/Y/dOFWrCSTyP7qi1mlSf.JAqU/zGwmhTNPO', 'iDbr6KCw+QfZmfruuu5JdetEdjFXRsvV', 'test3@test.com', 0, 1, 1372585091, 1372585091),
(5, 'test4', '$2y$13$.OiK2vCLJ944gu9G1OPlJux6ThdQwF5r9sw5imdFJ809eReNmVGtS', '7rehsXBf2OdxwgJr/JoqQOKfvLW9mAwg', 'test4@test.com', 0, 1, 1372585092, 1372585092),
(6, 'test5', '$2y$13$i9ddMLaf/6022aaCcuwixub3XNvfnFzy7FmOqsqqk2dEGzqsylB42', 'tw2+Eci1/CSjseonZnex6fYzbHBeVPW3', 'test5@test.com', 0, 1, 1372585093, 1372585093),
(7, 'test6', '$2y$13$J.tZWMlqVDOmGhw9cfxwTuqjKLlQjgpDRO3WMpfgb86UtEBZwfnSG', 'iPjoeQnr+oRUKTnD8xlUcYffjyVJixZq', 'test6@test.com', 0, 1, 1372585093, 1372585093),
(8, 'test7', '$2y$13$AZ/Nyk5YWRIHy63.SWiMU.GsfnSAen996TxU6680lFMTpLLutRMai', '3YrLlGl2mB1Z6QFtJB1Gox79OvdQzraN', 'test7@test.com', 0, 1, 1372585094, 1372585094),
(9, 'test8', '$2y$13$WyJeRzlYd4Aw2Itfl3y2DONcrEshccSs8ojMD2eSQOqiML.2cBf4S', 'neV4Dsgome8oP+A0COZp9gZ+VdAaVeJ4', 'test8@test.com', 0, 1, 1372585095, 1372585095),
(10, 'test9', '$2y$13$ALiI6MOguZ7XCrvfmShOkOS119GSU.kFEqRDQJsbyZMwoVVT.7EGK', 'QtYTeOG1YEFj7bOh3FcV3NRaP937diNI', 'test9@test.com', 0, 1, 1372585096, 1372585096),
(11, 'test10', '$2y$13$zHjGHzRWZfo8HMOh58gupO45qt1uuXCAvn.sVJJja6CGLX4XC5BGy', 'x337VkL+LwrvRmZICwjosBckYWjMIau2', 'test10@test.com', 0, 1, 1372585096, 1372585096),
(12, 'test11', '$2y$13$TbvDCG7fm9bPBQvNt/qK6uG6IN/UQ8Nm3E1mp331R73uR1s1ajZhi', 'qkAGolJtwVE9JwlfTS/iYq7t9KdyPINN', 'test11@test.com', 0, 1, 1372585097, 1372585097),
(13, 'test12', '$2y$13$UXpYHRJPaicLHs6STqaJWOpzBZ0BOHEN7oKX8isCdPy9E9O71Yr1e', 'ULrlBbR0NgBcTvqV5g1bshBz6Ekrh8X6', 'test12@test.com', 0, 1, 1372585098, 1372585098),
(14, 'test13', '$2y$13$BYbbcIBBOS36QdobXjO1g.GZnbvy3bcGYQe9pSnp17pRlI.CGpZuW', 'tfRHo9CNNME8NXDril10juu9kmKa/rGD', 'test13@test.com', 0, 1, 1372585099, 1372585099),
(15, 'test14', '$2y$13$xsz6/nGlK64Zd0PPLgtZc.5HmdM.PcUNqMTRBYShwVOtEkWNl9MdC', 'lPoYRsnS74pFu6EfMj2LTXWXXA3uognh', 'test14@test.com', 0, 1, 1372585100, 1372585100),
(16, 'test15', '$2y$13$32E6ct.fWuNhWUGlDOKkWOwt6Te0SPS5I2ZBkHDUH2hsXJzz6UL9q', 'ta0xwS7dYV1moOoiYqvNTUds8IpAl5zn', 'test15@test.com', 0, 1, 1372585100, 1372585100),
(17, 'test16', '$2y$13$6mUXwBAq.Rx9Fcl1LcoqHu4kc3dao5R2hxnDiiVE3ORwUFTPKSD9i', '+SZSJTASkHwE3HXC8mkax0teZooBj0Gm', 'test16@test.com', 0, 1, 1372585101, 1372585101),
(18, 'test17', '$2y$13$Vns3FfEtvnQa60b66jdC.u0Tp1erjaAAyYLE573RtAx03fUnRUxmC', 'BlEZi66HyitoktGYctob/QpRyoLhfQQ7', 'test17@test.com', 0, 1, 1372585102, 1372585102),
(19, 'test18', '$2y$13$n2dRvBpUQknBhkFtT5KlQOaxiqdfTgWxue6YXMh7dDrgzLEhs5lH2', 'QF7JwKz7PgEGVjKhZUePycZGUm+dutmY', 'test18@test.com', 0, 1, 1372585103, 1372585103),
(20, 'test19', '$2y$13$KYT5D5onupCsZkR7pxmU0ekMw.PKx5kf7d9DLwI/JmjmSG4NjP1Ta', 'HBWosueQNBGGxVANAazhQwDldRmfrIcA', 'test19@test.com', 0, 1, 1372585104, 1372585104),
(21, 'test20', '$2y$13$G8s0REpS0pUYb9.2GO9LxuDltuN8JYIpEi2HMcsUwgXmuPFXrSTae', 'GmJG7a06IAItcnodCzKvlygnMirvCxkF', 'test20@test.com', 0, 1, 1372585105, 1372585105),
(22, 'test21', '$2y$13$alhgX9pp1WPZU9WDj6NcE.gLxSzdVBvfmYyywMZjlpp3gxZhVHFa6', 'DblRbQirCZrUN7wSu+Nm+DpQWvVlLT8W', 'test21@test.com', 0, 1, 1372585106, 1372585106),
(23, 'test22', '$2y$13$ag1JbXzvQW3W1BUUHF6gIus9qcRGRTQqOvYTdEtiI5NUzt7HsH9iW', 'MsYjW2WYtTUn4nu8y3P+UlwZ5rMkKfGh', 'test22@test.com', 0, 1, 1372585106, 1372585106),
(24, 'test23', '$2y$13$lXxGBAlPIOgNWGEm5aGS9eZ0N4uQskke9BH0gWzhDWxHgqcKIfTbe', '/tNnXE0KmUiOLUwXglsjCR2XcI8RVY9A', 'test23@test.com', 0, 1, 1372585107, 1372585107),
(25, 'test24', '$2y$13$HCU10CGYLpC/fs/.GWyC1.5GJvMHjMJZTiYlhzO3Dhuo8b.pi6Jou', 'jEfqGjN4z9q4adzRXivzuW/ylpXnAzCE', 'test24@test.com', 0, 1, 1372585108, 1372585108),
(26, 'test25', '$2y$13$8lFeD6PJZmBaRglCb8aIv.yYPMNfvW4AkDt7uDjHWhSQWjaAQzDha', '83HNjvQkhScP9sNKMKw/+cVPfSBPg1oo', 'test25@test.com', 0, 1, 1372585109, 1372585109),
(27, 'test26', '$2y$13$Z4WnTQPfSd5qS0R2RovPA.XKPtbNer3KmUV.mFJO2OglsvYIoydue', 'G94nJAvdvOB4H73mi/qyQOqyammrlpXp', 'test26@test.com', 0, 1, 1372585110, 1372585110),
(28, 'test27', '$2y$13$pllv4uIp/iMhVhEE/CLateYCw8iVKOS.IQlj1fybUmlkFs3SpPbBm', 'NyBld7AXY56zojdN42KK6ukh6c6Rdtqq', 'test27@test.com', 0, 1, 1372585111, 1372585111),
(29, 'test28', '$2y$13$dR5MESQOYlraZHwUQvWZr.3UMuBXdOh6sc1NCegf03jLGBUNzRhg2', 'z5os7KXSVUjlcIKKvhPrUx7IHT9xMOcV', 'test28@test.com', 0, 1, 1372585111, 1372585111),
(30, 'test29', '$2y$13$hCslJlfk6ypx7h4hghXUIea.ZywH7/tpUrVtQECZvusc.8DDt1iR6', 'xuL4cEOuXnU6vdPR73YQb4lN44OqbHMk', 'test29@test.com', 0, 1, 1372585112, 1372585112),
(31, 'test30', '$2y$13$7QItNHFFQcPLnuzVa8j.M.ZyTXhj5CgFJ.IRRw1kpSBuZd4VTuh3a', 'xKUxwiiCTqaGfQY4jsundzZxCprQ2l8C', 'test30@test.com', 0, 1, 1372585113, 1372585113);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  ADD CONSTRAINT `FK_blog_author` FOREIGN KEY (`author_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD CONSTRAINT `FK_comment_model_id` FOREIGN KEY (`model_id`) REFERENCES `tbl_blog` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_comment_author` FOREIGN KEY (`author_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
