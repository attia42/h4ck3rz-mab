-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 27, 2008 at 09:34 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

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
  `avatar` blob,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `contactgroup`
--


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
  `title` varchar(10) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `homeAddress` mediumtext,
  `workAddress` mediumtext,
  `homePhone` varchar(14) default NULL,
  `mobilePhone` varchar(14) default NULL,
  `workPhone` varchar(14) default NULL,
  `eMail` varchar(255) default NULL,
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
  `photo` blob,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `phonebook`
--


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

UPDATE `usercategory` SET `id` = 1,`name` = 'General',`avatar` = NULL WHERE  `usercategory`.`id` = 1;
UPDATE `usercategory` SET `id` = 2,`name` = 'H4ck3rZ',`avatar` = NULL WHERE  `usercategory`.`id` = 2;
UPDATE `usercategory` SET `id` = 3,`name` = 'CAT',`avatar` = NULL WHERE  `usercategory`.`id` = 3;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `userCatID` int(11) NOT NULL,
  `pri` tinyint(1) NOT NULL,
  `status` varchar(250) NOT NULL,
  `bcID` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

