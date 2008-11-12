-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 12, 2008 at 07:24 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mab`
--

-- --------------------------------------------------------

--
-- Table structure for table `contactgroup`
--

CREATE TABLE `contactgroup` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `owner` int(11) NOT NULL,
  `parentID` int(11) NOT NULL,
  `avatar` varchar(300) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `contactgroup`
--

INSERT INTO `contactgroup` (`id`, `name`, `owner`, `parentID`, `avatar`) VALUES
(13, 'Hackers', 58, 0, '../views/images/hackers.png'),
(14, 'Csed', 58, 0, '../views/images/csed.png'),
(15, 'Depiak', 58, 0, '../views/images/depiak.png'),
(16, 'Friends', 58, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `messagestatus`
--

CREATE TABLE `messagestatus` (
  `id` int(11) NOT NULL auto_increment,
  `userID` int(11) NOT NULL,
  `messageID` int(11) NOT NULL,
  `status` set('DISCARDED','ACCEPTED','IGNORED') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `messagestatus`
--


-- --------------------------------------------------------

--
-- Table structure for table `phonebook`
--

CREATE TABLE `phonebook` (
  `id` int(11) NOT NULL auto_increment,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `gender` varchar(10) default NULL,
  `birthday` date default NULL,
  `country` varchar(100) default NULL,
  `city` varchar(100) default NULL,
  `homeAddress` mediumtext,
  `workAddress` mediumtext,
  `homePhone` varchar(14) default NULL,
  `mobilePhone` varchar(14) default NULL,
  `workPhone` varchar(14) default NULL,
  `webSite` mediumtext,
  `msn` varchar(50) default NULL,
  `yahoo` varchar(50) default NULL,
  `aol` varchar(50) default NULL,
  `gmail` varchar(50) default NULL,
  `facebook` varchar(50) default NULL,
  `myspace` varchar(50) default NULL,
  `company` varchar(255) default NULL,
  `contactGroupID` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `photo` varchar(200) default NULL,
  `isBc` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=99 ;

--
-- Dumping data for table `phonebook`
--

INSERT INTO `phonebook` (`id`, `firstName`, `lastName`, `gender`, `birthday`, `country`, `city`, `homeAddress`, `workAddress`, `homePhone`, `mobilePhone`, `workPhone`, `webSite`, `msn`, `yahoo`, `aol`, `gmail`, `facebook`, `myspace`, `company`, `contactGroupID`, `owner`, `photo`, `isBc`) VALUES
(56, 'Mohamedasdsad', 'Atiaasdasdasd', '0', '1999-11-30', 'eg', 'dasdasd', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', 0, 0, '0', 0),
(55, 'Mohamed', 'Atiaasad', '0', '1999-11-30', 'eg', 'asdasd', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', 0, 0, '0', 0),
(54, 'Mohamed', 'Atia', '', '1999-11-30', 'eg', 'asdsd', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', 0),
(53, 'Mohamed', 'Atia', '', '1999-11-30', 'eg', 'sadsad', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', 0),
(52, 'Mohamed', 'Atia', '', '1970-01-01', 'Egypt', 'Mansoura', 'Mansoura,....', '', '123', '123', 'wef', 'www.mohamed-atia.com', '', '', '', 'snap4422@gmail.com', '', '', '', 0, 58, '../views/images/snap.jpg', 0),
(93, 'Osama', 'Gamal', '', '1923-01-01', 'Egypt', 'Mansoura', '', '', '3546757889', '', '', '', '', '', '', '', '', '', '', 14, 58, '', 0),
(62, 'The', 'Snap', '0', '1971-01-02', 'eg', 'SAD', 'ASDd', '0', 'adsf', 'asdfcw', '0', 'df', '0', '0', '0', '0', '0', '0', '0', 0, 59, '0', 0),
(63, '', '', '0', '1908-01-01', '0', '', '', '0', '', '', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 60, '0', 0),
(64, 'saa', 'saa', '0', '1908-01-01', '0', 'asd', '', '0', '124', '124r', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 61, '0', 0),
(65, 'Z', 'Snap', '0', '1908-01-01', '0', '', '', '0', '', '', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 62, '0', 0),
(68, 'Mohamed', 'Atia', '0', '1908-01-01', 'Egypt', '', '', '', '2350265', '', '', '', '', '', '', '', '', '', '', 0, 61, '', 0),
(69, 'Amr', 'Atia', '0', '1908-01-01', '0', '', '', '0', '', '', '0', '', '0', '0', '0', '0', '0', '0', '0', 0, 63, '0', 0),
(70, 'Ahmed', 'Madkour', '0', '1970-01-01', '0', 'Mansoura', 'Ahmed Maher St', '0', '050-2344565', '0111950055', '0', 'www.ahmedmadkour.blogspot.com', 'ahm_madkour@hotmail.com', 'ahm_madkour@yahoo.com', '0', 'ahm.madkour@gmail.com', '0', '0', '0', 0, 64, '0', 0),
(71, 'Khaled2', 'Abd2', '0', '1970-01-01', '0', 'Mansoura', '', '0', '2350265', 'q', '0', 'sadsad', '0', '0', '0', '0', '0', '0', '0', 0, 65, '0', 0),
(72, 'No', 'qwe', '0', '1954-03-05', '0', 'q', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 0, 66, '0', 0),
(73, 'WE', 'ARRR', '0', '1908-01-01', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 0, 67, '0', 0),
(74, 'ss', 'aSD', '0', '1913-01-03', '0', '0', 'sadf', '0', 'adf', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 0, 68, '0', 0),
(1, 'wd', 'wesdf', '1', '1908-01-01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 1, 1, '1', 0),
(75, 'sa', 'ASD', '0', '1908-01-01', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 0, 69, '0', 0),
(76, 'sda', 'asdd', '', '1970-01-01', 'Bahrain', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 70, '', 0),
(95, 'Ahmed', 'Seleeman', '', '1923-11-04', 'Egypt', 'Mansoura', '', '', '32456789', '', '', '', '', '', '', '', '', '', '', 13, 58, '', 0),
(96, 'Mohamed', 'Mahmoud', '', '1908-01-01', 'Egypt', 'Mansoura', '', '', '12345678', '', '', '', '', '', '', '', '', '', '', 15, 58, '', 0),
(92, 'El-Sayed', 'Gamal', '', '1917-06-11', 'Egypt', 'Mansoura', 'el modereya st', 'Origin', '234567', '', '', '', '', '', '', '', '', '', '', 15, 58, '../views/images/sayed.jpg', 0),
(91, 'Marwan', 'Mohamed', '', '1908-01-01', 'Egypt', 'Cairo', 'Aswan', 'Cairo', '546734543', '24532454', '32436', '', '', '', '', '', '', '', '', 16, 58, '', 0),
(88, 'Muhhamed', 'Daif', '', '1984-04-01', 'Egypt', 'Mansoura', 'El gala2', 'uni', '2343546', '024304214', '43245394', 'www.daif.com', 'ssad@msn.com', '', '', '', '', '', '', 14, 58, '', 0),
(89, 'Ahmed ', 'el banna', '', '1984-01-02', 'Egypt', 'Mansoura', 'gehaan', 'Uni', '123456789', '6568532', '32445678', '', '', '', '', '', '', '', '../views/images/csed.png', 14, 58, '', 0),
(90, 'Ahmed', 'Madkour', '', '1990-06-12', 'Egypt', 'Mansoura', 'Ahmed maher\r\n', 'uni', '2345789', '23456768', '234534657687', 'ser', '', '', '', '', '', '', '', 13, 58, '', 0),
(97, 'Sayed', 'Fat-hey', '', '1908-01-01', 'Egypt', 'Mansoura', '', '', '3423546578', '', '', '', '', '', '', '', '', '', '', 15, 58, '', 0),
(98, 'Bahaa', 'Beih', '', '1908-01-01', 'Egypt', 'Cairo', '', '', '65743568', '', '', '', '', '', '', '', '', '', '', 16, 58, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sentcontact`
--

CREATE TABLE `sentcontact` (
  `id` int(11) NOT NULL auto_increment,
  `srcUserID` int(11) NOT NULL,
  `destID` int(11) NOT NULL,
  `destType` set('USER','CATEGORY') NOT NULL,
  `date` datetime NOT NULL,
  `validity` int(11) NOT NULL,
  `contactID` int(11) NOT NULL,
  `note` mediumtext,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sentcontact`
--


-- --------------------------------------------------------

--
-- Table structure for table `sharing`
--

CREATE TABLE `sharing` (
  `id` int(11) NOT NULL auto_increment,
  `userID` int(11) NOT NULL,
  `destID` int(11) NOT NULL,
  `destType` set('USER','CATEGORY') NOT NULL,
  `srcID` int(11) NOT NULL,
  `srcType` set('CONTACT','GROUP') NOT NULL,
  `permission` int(3) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sharing`
--


-- --------------------------------------------------------

--
-- Table structure for table `usercategory`
--

CREATE TABLE `usercategory` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `avatar` blob,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `usercategory`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `eMail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `userCatID` int(11) NOT NULL,
  `pri` tinyint(1) NOT NULL,
  `status` varchar(250) NOT NULL,
  `bcID` int(11) NOT NULL,
  `bcAccess` tinyint(2) NOT NULL default '0',
  `numOfRowsPerPage` smallint(3) NOT NULL default '10',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `eMail`, `password`, `disabled`, `userCatID`, `pri`, `status`, `bcID`, `bcAccess`, `numOfRowsPerPage`) VALUES
(58, 'snap4422@hotmail.com', '1235', 0, 0, 0, '', 52, 0, 10),
(59, 'snap1', '123', 0, 0, 0, '0', 62, 0, 10),
(60, '', '123', 0, 0, 0, '0', 63, 0, 10),
(61, 'sss', '123', 0, 0, 0, '0', 64, 0, 10),
(62, 's1', '123', 0, 0, 0, '0', 65, 0, 10),
(63, 'ss2', '1234', 0, 0, 0, '0', 69, 0, 10),
(64, 'ahm.madkour@gmail.com', 'mab', 0, 0, 0, '0', 70, 0, 10),
(65, 'sn', '12', 0, 0, 0, '0', 71, 0, 10),
(66, 'ssss', '123', 0, 0, 0, '0', 72, 0, 10),
(67, 's3', '123', 0, 0, 0, '0', 73, 0, 10),
(68, 's4', '123', 0, 0, 0, '0', 74, 0, 10),
(1, 's5', '123', 1, 1, 1, '1', 1, 0, 10),
(69, '111', '123', 0, 0, 0, '0', 75, 0, 10),
(70, 's6', '123', 0, 0, 0, '', 76, 0, 10);
