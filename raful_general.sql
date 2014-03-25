-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: mysql.query.co.il
-- Generation Time: Mar 12, 2014 at 12:22 AM
-- Server version: 5.1.56
-- PHP Version: 5.3.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `raful_general`
--

-- --------------------------------------------------------

--
-- Table structure for table `wibiya_timeclock_info`
--

CREATE TABLE IF NOT EXISTS `wibiya_timeclock_info` (
  `uid` int(5) NOT NULL,
  `day` date NOT NULL,
  `time_in` varchar(100) NOT NULL,
  `time_out` varchar(100) NOT NULL,
  `notes` varchar(255) NOT NULL,
  UNIQUE KEY `uid` (`uid`,`day`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wibiya_timeclock_users`
--

CREATE TABLE IF NOT EXISTS `wibiya_timeclock_users` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;
