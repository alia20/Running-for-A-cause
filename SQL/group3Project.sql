-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2017 at 12:01 AM
-- Server version: 5.6.36
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `group3Project`
--

-- --------------------------------------------------------

--
-- Table structure for table `Participant`
--

CREATE TABLE IF NOT EXISTS `Participant` (
  `Id` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `PhoneNumber` varchar(50) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Participant`
--

INSERT INTO `Participant` (`Id`, `FirstName`, `LastName`, `PhoneNumber`, `EmailAddress`) VALUES
(1, 'John', 'Smith', '(612)123-4567', 'JohnSmith@gmail.com');

-- --------------------------------------------------------
--
-- Table structure for table `race`
--

CREATE TABLE IF NOT EXISTS `race` (
  `raceID` int(11) NOT NULL AUTO_INCREMENT,
  `raceName` varchar(25) DEFAULT NULL,
  `raceCourse` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`raceID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `race`
--

INSERT INTO `race` (`raceID`, `raceName`, `raceCourse`) VALUES
(1, 'TourdeCure', '5k'),
(2, 'raceName', 'raceCourse'),
(3, 'raceName', 'raceCourse'),
(4, 'raceName', 'raceCourse'),
(5, 'Tour DeFrance', '50 K'),
(6, 'Tour DeFrance', '50 K');

-- --------------------------------------------------------

--
-- Table structure for table `RaceDetails`
--

CREATE TABLE IF NOT EXISTS `RaceDetails` (
  `Id` int(11) NOT NULL,
  `RaceName` varchar(100) NOT NULL,
  `Location` varchar(100) NOT NULL,
  `Date` date NOT NULL,
  `Distance` float NOT NULL,
  `DistanceUnits` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `RaceDetails`
--

INSERT INTO `RaceDetails` (`Id`, `RaceName`, `Location`, `Date`, `Distance`, `DistanceUnits`) VALUES
(1, 'TestRace', 'Minneapolis, MN', '2017-09-22', 10, 'Kilometers');

-- --------------------------------------------------------

--
-- Table structure for table `RaceResult`
--

CREATE TABLE IF NOT EXISTS `RaceResult` (
  `Id` int(11) NOT NULL,
  `RegistrationId` int(11) NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `Place` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `RaceResult`
--

INSERT INTO `RaceResult` (`Id`, `RegistrationId`, `StartTime`, `EndTime`, `Place`) VALUES
(1, 1, '2017-09-21 19:00:04', '2017-09-21 19:00:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Registration`
--

CREATE TABLE IF NOT EXISTS `Registration` (
  `Id` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `RaceId` int(11) NOT NULL,
  `ParticipantId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Registration`
--

INSERT INTO `Registration` (`Id`, `DateTime`, `RaceId`, `ParticipantId`) VALUES
(1, '2017-09-21 18:56:58', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Participant`
--
ALTER TABLE `Participant`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `RaceDetails`
--
ALTER TABLE `RaceDetails`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `RaceResult`
--
ALTER TABLE `RaceResult`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `RegistrationId` (`RegistrationId`);

--
-- Indexes for table `Registration`
--
ALTER TABLE `Registration`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `I2` (`RaceId`,`ParticipantId`),
  ADD KEY `RaceId` (`RaceId`),
  ADD KEY `ParticipantId` (`ParticipantId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Participant`
--
ALTER TABLE `Participant`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `RaceDetails`
--
ALTER TABLE `RaceDetails`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `RaceResult`
--
ALTER TABLE `RaceResult`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Registration`
--
ALTER TABLE `Registration`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `RaceResult`
--
ALTER TABLE `RaceResult`
  ADD CONSTRAINT `raceresult_ibfk_1` FOREIGN KEY (`RegistrationId`) REFERENCES `Registration` (`Id`);

--
-- Constraints for table `Registration`
--
ALTER TABLE `Registration`
  ADD CONSTRAINT `registration_ibfk_1` FOREIGN KEY (`RaceId`) REFERENCES `RaceDetails` (`Id`),
  ADD CONSTRAINT `registration_ibfk_2` FOREIGN KEY (`ParticipantId`) REFERENCES `Participant` (`Id`) ON DELETE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
