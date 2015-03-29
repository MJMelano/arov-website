-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 09, 2014 at 03:23 PM
-- Server version: 5.5.37-log
-- PHP Version: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `arovmbco_arov`
--
DROP DATABASE `arovmbco_arov`;
CREATE DATABASE `arovmbco_arov` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `arovmbco_arov`;

-- --------------------------------------------------------

--
-- Table structure for table `arov_admins`
--

DROP TABLE IF EXISTS `arov_admins`;
CREATE TABLE IF NOT EXISTS `arov_admins` (
  `adm_id` int(11) NOT NULL AUTO_INCREMENT,
  `adm_first_name` varchar(25) NOT NULL,
  `adm_middle_initial` varchar(3) DEFAULT NULL,
  `adm_last_name` varchar(25) DEFAULT NULL,
  `adm_phone` varchar(10) NOT NULL,
  `adm_user_name` varchar(50) NOT NULL,
  `adm_permissions` int(11) NOT NULL DEFAULT '1',
  `adm_password` varchar(100) NOT NULL DEFAULT '13d8c9009647abffee45341993ab3952f57c361d',
  PRIMARY KEY (`adm_id`),
  UNIQUE KEY `arov_admin_names` (`adm_first_name`,`adm_middle_initial`,`adm_last_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `arov_admins`
--

INSERT INTO `arov_admins` (`adm_id`, `adm_first_name`, `adm_middle_initial`, `adm_last_name`, `adm_phone`, `adm_user_name`, `adm_permissions`, `adm_password`) VALUES
(35, 'Moises', 'M', 'Melano', '8317102207', 'mmelano@csumb.edu', 0, '8a1080839b26a6d49fb815bc985b4ba7541e0508'),
(38, 'Juan', '', 'Hernandez', '', 'juhernandez@csumb.edu', 0, '13d8c9009647abffee45341993ab3952f57c361d'),
(39, 'Joshua', '', 'Frea', '', 'jfrea@csumb.edu', 0, '13d8c9009647abffee45341993ab3952f57c361d');

-- --------------------------------------------------------

--
-- Table structure for table `arov_bld_category`
--

DROP TABLE IF EXISTS `arov_bld_category`;
CREATE TABLE IF NOT EXISTS `arov_bld_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(60) NOT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_name` (`cat_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `arov_bld_category`
--

INSERT INTO `arov_bld_category` (`cat_id`, `cat_name`) VALUES
(1, 'Academic'),
(2, 'Dining'),
(3, 'Residential'),
(4, 'Services');

-- --------------------------------------------------------

--
-- Table structure for table `arov_buildings`
--

DROP TABLE IF EXISTS `arov_buildings`;
CREATE TABLE IF NOT EXISTS `arov_buildings` (
  `bld_id` int(11) NOT NULL AUTO_INCREMENT,
  `bld_num` int(3) NOT NULL,
  `bld_name` varchar(80) NOT NULL,
  `bld_latitude` double(24,20) NOT NULL,
  `bld_longitude` double(24,20) NOT NULL,
  `bld_bool` tinyint(1) NOT NULL DEFAULT '1',
  `bld_description` text NOT NULL,
  `bld_category` int(11) NOT NULL,
  PRIMARY KEY (`bld_id`),
  UNIQUE KEY `bld_num` (`bld_num`,`bld_name`),
  UNIQUE KEY `arov_building_num_name` (`bld_num`,`bld_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=256 ;

--
-- Dumping data for table `arov_buildings`
--

INSERT INTO `arov_buildings` (`bld_id`, `bld_num`, `bld_name`, `bld_latitude`, `bld_longitude`, `bld_bool`, `bld_description`, `bld_category`) VALUES
(254, 18, 'Media Learning Center', 36.65412575487886000000, -121.79983690381050000000, 1, 'The Media Learning Center is the home of CSUMB''s Computer Science and Information Technology and Communication Design departments. ', 1),
(255, 504, 'Tanimura & Antle Memorial Library', 36.65242150044828400000, -121.79616227746010000000, 1, 'The Library has set the stage for this campus to evolve from the surrounding military environment to shape the intellectual heart of the campus as well as set the tone for future development. The building ise of the appropriate scale and architectural quality to reflect its'' function as the cultural, social, and intellectual center of the campus, and is designed to be compatible with the built environment of the region and the unique qualities of the site. ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `arov_departments`
--

DROP TABLE IF EXISTS `arov_departments`;
CREATE TABLE IF NOT EXISTS `arov_departments` (
  `dep_id` int(11) NOT NULL AUTO_INCREMENT,
  `dep_name` varchar(60) NOT NULL,
  PRIMARY KEY (`dep_id`),
  UNIQUE KEY `dep_name` (`dep_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `arov_events`
--

DROP TABLE IF EXISTS `arov_events`;
CREATE TABLE IF NOT EXISTS `arov_events` (
  `evt_id` int(11) NOT NULL AUTO_INCREMENT,
  `evt_name` varchar(80) NOT NULL,
  `evt_date` varchar(20) NOT NULL,
  `evt_summary` varchar(140) DEFAULT NULL,
  `evt_longitude` double(24,20) NOT NULL,
  `evt_latitude` double(24,20) NOT NULL,
  PRIMARY KEY (`evt_id`),
  UNIQUE KEY `evt_name` (`evt_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `arov_events`
--

INSERT INTO `arov_events` (`evt_id`, `evt_name`, `evt_date`, `evt_summary`, `evt_longitude`, `evt_latitude`) VALUES
(1, 'CSiT/CD Capstone Festival', '05-17-2014', 'Let''s rock the show guys!', -121.80014535784721000000, 36.65428068522937400000);

-- --------------------------------------------------------

--
-- Table structure for table `arov_evt_poi`
--

DROP TABLE IF EXISTS `arov_evt_poi`;
CREATE TABLE IF NOT EXISTS `arov_evt_poi` (
  `evt_id` int(11) NOT NULL,
  `poi_id` int(11) NOT NULL,
  UNIQUE KEY `evt_id` (`evt_id`,`poi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coordinates`
--

DROP TABLE IF EXISTS `coordinates`;
CREATE TABLE IF NOT EXISTS `coordinates` (
  `id` int(11) NOT NULL,
  `latitude` double(24,20) NOT NULL,
  `longitude` double(24,20) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paths`
--

DROP TABLE IF EXISTS `paths`;
CREATE TABLE IF NOT EXISTS `paths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` varchar(5) NOT NULL,
  `end` varchar(5) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `from` (`start`),
  KEY `to` (`end`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coordinates`
--
ALTER TABLE `coordinates`
  ADD CONSTRAINT `coordinates_ibfk_1` FOREIGN KEY (`id`) REFERENCES `paths` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
