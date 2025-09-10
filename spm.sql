-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 10, 2025 at 05:00 PM
-- Server version: 5.7.44
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spm`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE IF NOT EXISTS `appointment` (
  `AppointmentID` int(11) NOT NULL AUTO_INCREMENT,
  `PatientUserName` varchar(75) NOT NULL,
  `MgtUserName` varchar(75) NOT NULL,
  `MgtCategory` char(1) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`AppointmentID`)
) ENGINE=MyISAM AUTO_INCREMENT=1031 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`AppointmentID`, `PatientUserName`, `MgtUserName`, `MgtCategory`, `Date`, `Time`) VALUES
(1004, 'Brenden.Powell@gmail.com', 'emma.jane@healthcare.com', 'C', '2023-04-02', '12:00:00'),
(1005, 'ionarachelthomas@gmail.com', 'James.Liu@healthcare.com', 'D', '2023-04-05', '06:00:00'),
(1022, 'Josephine.Lauzon@gmail.com', 'James.Liu@healthcare.com', 'D', '2023-04-07', '13:00:00'),
(1023, 'rachelthomas@gmail.com', 'emma.jane@healthcare.com', 'C', '2023-04-08', '12:00:00'),
(1024, 'ionarthomas98@gmail.com', 'emma.jane@healthcare.com', 'C', '2023-04-15', '13:00:00'),
(1028, 'karran1697@gmail.com', 'emma.jane@healthcare.com', 'C', '2023-04-29', '16:00:00'),
(1030, 'ionarachelthomas@gmail.com', 'James.Liu@healthcare.com', 'D', '2023-04-13', '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `assessmentresults`
--

DROP TABLE IF EXISTS `assessmentresults`;
CREATE TABLE IF NOT EXISTS `assessmentresults` (
  `UserName` varchar(75) NOT NULL,
  `Result` varchar(9) NOT NULL,
  `Score` int(11) NOT NULL,
  PRIMARY KEY (`UserName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assessmentresults`
--

INSERT INTO `assessmentresults` (`UserName`, `Result`, `Score`) VALUES
('ionarachelthomas@gmail.com', '121212110', 11),
('rachelthomas@gmail.com', '121212121', 13),
('Josephine.Lauzon@gmail.com', '123211233', 18),
('Brenden.Powell@gmail.com', '222222222', 18),
('ionarthomas98@gmail.com', '111221102', 11),
('karran1697@gmail.com', '021313103', 14);

-- --------------------------------------------------------

--
-- Table structure for table `assignpatient`
--

DROP TABLE IF EXISTS `assignpatient`;
CREATE TABLE IF NOT EXISTS `assignpatient` (
  `PatientUserName` varchar(75) NOT NULL,
  `PatientDOB` date NOT NULL,
  `AdminUserName` varchar(75) NOT NULL,
  `AdminCategory` varchar(1) NOT NULL,
  `AssignedBy` varchar(75) NOT NULL,
  `AssignerCategory` varchar(1) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignpatient`
--

INSERT INTO `assignpatient` (`PatientUserName`, `PatientDOB`, `AdminUserName`, `AdminCategory`, `AssignedBy`, `AssignerCategory`, `TimeStamp`) VALUES
('ionarachelthomas@gmail.com', '1998-03-06', 'James.Liu@healthcare.com', 'D', 'Joy.Joy@healthcare.com', 'M', '2023-04-01 16:39:28'),
('Josephine.Lauzon@gmail.com', '1997-07-30', 'emma.jane@healthcare.com', 'C', 'Joy.Joy@healthcare.com', 'M', '2023-04-01 16:54:29'),
('Brenden.Powell@gmail.com', '1982-01-01', 'emma.jane@healthcare.com', 'C', 'Joy.Joy@healthcare.com', 'M', '2023-04-01 16:54:46'),
('Josephine.Lauzon@gmail.com', '1997-07-30', 'James.Liu@healthcare.com', 'D', 'emma.jane@healthcare.com', 'C', '2023-04-02 00:54:33'),
('rachelthomas@gmail.com', '2001-01-01', 'emma.jane@healthcare.com', 'C', 'Joy.Joy@healthcare.com', 'M', '2023-04-05 20:25:39');

-- --------------------------------------------------------

--
-- Table structure for table `counselor`
--

DROP TABLE IF EXISTS `counselor`;
CREATE TABLE IF NOT EXISTS `counselor` (
  `UserName` varchar(75) NOT NULL,
  `CounselorID` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `PhoneNumber` bigint(20) NOT NULL,
  `QNR` varchar(15) NOT NULL,
  PRIMARY KEY (`CounselorID`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=MyISAM AUTO_INCREMENT=1016 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `counselor`
--

INSERT INTO `counselor` (`UserName`, `CounselorID`, `FullName`, `Address`, `DOB`, `PhoneNumber`, `QNR`) VALUES
('olivia.smith@healthcare.com', 1000, 'Olivia Smith', '2681 St-Jerome Street, St Jerome QC S4P 3Y2', '1995-08-22', 5873444402, 'OLSM-1995-5991'),
('emma.jane@healthcare.com', 1001, 'Emma Jane', '2764 rue des Erables, Clermont QC G4A 1J8', '1985-01-03', 5062231887, 'EMJA-1985-5891'),
('charlotte.richards@healthcare.com', 1002, 'Charlotte Richards', '2290 rue de la Gauchetiere, Montreal QC H3B 2M3', '1988-07-30', 5144296020, 'CHRI-1988-8991'),
('amelia.hart@healthcare.com', 1003, 'Amelia Hart', '833 Nelson Street, Nobel QC P0G 1G0', '1994-07-20', 2043301636, 'AMHA-1994-4991'),
('ava.gomez@healthcare.com', 1004, 'Ava Gomez', '559 rue Fournier, St Jerome QC J7Z 4V1', '1990-08-14', 7808524416, 'AVGO-1990-0991'),
('liam.tims@healthcare.com', 1005, 'Liam Tims', '4096 rue Ellice, Joliette QC J6E 3E8', '1992-05-04', 4189042491, 'LITI-1992-2991'),
('noah.ark@healthcare.com', 1006, 'Noah Ark', 'e391 rue Saint-Edouard, Trois Rivieres QC G9A 5S8', '1993-07-06', 4182706809, 'NOAR-1993-3991'),
('oliver.queen@healthcare.com', 1007, 'Oliver Queen', '2667 rue des Eglises Est, Lavenir QC J0C 1B0', '1988-07-27', 4388631619, 'OLQU-1988-8991'),
('james.john@healthcare.com', 1008, 'James John', '1519 Rene-Levesque Blvd, Montreal QC H3B 4W8', '1991-04-10', 4185024050, 'JAJO-1991-1991'),
('lucas.scott@healthcare.com', 1009, 'Lucas Scott', '2650 St Jean Baptiste St, St Magloire QC G0R 3M0', '1991-05-19', 5199641512, 'LUSC-1991-1991');

-- --------------------------------------------------------

--
-- Table structure for table `deletepatient`
--

DROP TABLE IF EXISTS `deletepatient`;
CREATE TABLE IF NOT EXISTS `deletepatient` (
  `patientUsername` varchar(75) NOT NULL,
  `mgtUsername` varchar(75) NOT NULL,
  `reason` varchar(300) NOT NULL,
  PRIMARY KEY (`patientUsername`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

DROP TABLE IF EXISTS `doctor`;
CREATE TABLE IF NOT EXISTS `doctor` (
  `UserName` varchar(75) NOT NULL,
  `DoctorID` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `PhoneNumber` bigint(20) NOT NULL,
  `QNR` varchar(15) NOT NULL,
  PRIMARY KEY (`DoctorID`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=MyISAM AUTO_INCREMENT=1017 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`UserName`, `DoctorID`, `FullName`, `Address`, `DOB`, `PhoneNumber`, `QNR`) VALUES
('Nathan.Salazar@healthcare.com', 1001, 'Nathan Salazar', '4096 rue Ellice, Joliette QC J6E 3E8', '1992-01-21', 7782857515, 'NASA-1992-2991'),
('Joanna.Woods@healthcare.com', 1002, 'Joanna Woods', '2650 St Jean Baptiste St, St Magloire QC G0R 3M0', '1990-03-16', 6134677142, 'JOWO-1990-0991'),
('James.Liu@healthcare.com', 1003, 'James Liu', '1818 Main St, Black Lake QC S0J 0H0', '1994-09-02', 4502896811, 'JALA-1994-4991'),
('Gustavo.Roth@healthcare.com', 1004, 'Gustavo Roth', '169 rue des Eglises Est, Malartic QC J0Y 1Z0', '1991-04-21', 6472839131, 'GARA-1991-1991'),
('Carmela.Blevins@healthcare.com', 1005, 'Carmela Blevins', '557 rue Saint-Antoine, Granby QC J2H 2H5', '1994-04-09', 4163362797, 'CABA-1994-4991'),
('Loraine.Hurst@healthcare.com', 1006, 'Loraine Hurst', '3145 Richford Road, Napierville QC J0J 1L0', '1986-08-14', 7803106327, 'LAHA-1986-6981'),
('Mariano.Brown@healthcare.com', 1007, 'Mariano Brown', '4798 Rene-Levesque Blvd, Montreal QC H3B 4W8', '1991-06-08', 5142831981, 'MABA-1991-1991'),
('Adrian.Arias@healthcare.com', 1008, 'Adrian Arias', '2681 St-Jerome Street, St Jerome QC S4P 3Y2', '1982-02-04', 6042036166, 'AAAA-1982-2981'),
('Tammie.Pham@healthcare.com', 1009, 'Tammie Pham', '2249 Rene-Levesque Blvd, Montreal QC H3B 4W8', '1980-11-20', 5196316203, 'TAPA-1980-0981'),
('Eugenia.Figueroa@healthcare.com', 1010, 'Eugenia Figueroa', '51 rue St-Henri, Ville Le Gardeur QC J5Z 1R6', '1989-12-27', 9053504904, 'EAFA-1989-9981');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

DROP TABLE IF EXISTS `manager`;
CREATE TABLE IF NOT EXISTS `manager` (
  `UserName` varchar(75) NOT NULL,
  `ManagerID` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `PhoneNumber` bigint(20) NOT NULL,
  PRIMARY KEY (`ManagerID`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`UserName`, `ManagerID`, `FullName`, `Address`, `DOB`, `PhoneNumber`) VALUES
('Joy.Joy@healthcare.com', 1, 'Joy Joy', '1152 rue Levy, Montreal QC H3C 5K4', '1991-03-06', 5192097533);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_temp`
--

DROP TABLE IF EXISTS `password_reset_temp`;
CREATE TABLE IF NOT EXISTS `password_reset_temp` (
  `email` varchar(250) NOT NULL,
  `passKey` varchar(250) NOT NULL,
  `expDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `UserName` varchar(75) NOT NULL,
  `PatientID` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `PhoneNumber` bigint(20) NOT NULL,
  `Assigned` tinyint(1) NOT NULL DEFAULT '0',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`PatientID`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=MyISAM AUTO_INCREMENT=1011 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`UserName`, `PatientID`, `FullName`, `Address`, `DOB`, `PhoneNumber`, `Assigned`, `Timestamp`) VALUES
('ionarachelthomas@gmail.com', 1001, 'Iona Thomas', '777 Boul. Robert Bourassa Montreal, Quebec H3C 3Z7', '1998-03-06', 5147177815, 1, '2023-03-15 06:34:52'),
('rachelthomas@gmail.com', 1002, 'Rachel Thompson', '777 Boul. Robert Bourassa Montreal, Quebec H3C 3Z7', '2001-01-01', 5147177818, 1, '2023-03-24 06:35:42'),
('Josephine.Lauzon@gmail.com', 1003, 'Josephine Lauzon', '557 rue Saint-Antoine, Granby QC J2H 2H5', '1997-07-30', 2262256311, 1, '2023-04-06 06:34:52'),
('Brenden.Powell@gmail.com', 1004, 'Brenden Powell', '796 avenue Royale, Quebec QC G1P 4R5', '1982-01-01', 9055989872, 1, '2023-04-06 06:34:52'),
('Jeannie.Lebrun@gmail.com', 1005, 'Jeannie Lebrun', '833 Nelson Street, Nobel QC P0G 1G0', '1997-03-28', 7095737655, 0, '2023-04-06 06:34:52'),
('ionarthomas98@gmail.com', 1009, 'Isaac Thomas', '777 Boul. Rob-Bour Montreal QC H3C 3Z7', '2001-07-02', 5147177814, 1, '2023-04-06 06:34:52'),
('karran1697@gmail.com', 1010, 'Karansinh Matroja', '1280 rue saint marc,, Appartment no. 508', '1997-12-16', 4376841570, 1, '2023-04-06 15:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `pending_appointment`
--

DROP TABLE IF EXISTS `pending_appointment`;
CREATE TABLE IF NOT EXISTS `pending_appointment` (
  `AppointmentID` int(11) NOT NULL AUTO_INCREMENT,
  `PatientUserName` varchar(75) NOT NULL,
  `MgtUserName` varchar(75) NOT NULL,
  `MgtCategory` char(1) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  PRIMARY KEY (`AppointmentID`)
) ENGINE=MyISAM AUTO_INCREMENT=1031 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pending_appointment`
--

INSERT INTO `pending_appointment` (`AppointmentID`, `PatientUserName`, `MgtUserName`, `MgtCategory`, `Date`, `Time`) VALUES
(1021, 'Josephine.Lauzon@gmail.com', 'James.Liu@healthcare.com', 'D', '2023-04-09', '11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UserName` varchar(75) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `UserCategory` char(1) NOT NULL,
  PRIMARY KEY (`UserName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserName`, `Password`, `UserCategory`) VALUES
('ionarachelthomas@gmail.com', 'VbanGubznf1', 'P'),
('Nathan.Salazar@healthcare.com', 'AngunaFnynmne', 'D'),
('olivia.smith@healthcare.com', 'ByvivnFzvgu', 'C'),
('rachelthomas@gmail.com', 'Gubznf12', 'P'),
('Joy.Joy@healthcare.com', 'Znantre123', 'M'),
('emma.jane@healthcare.com', 'RzznWnar', 'C'),
('charlotte.richards@healthcare.com', 'PuneybggrEvpuneqf', 'C'),
('amelia.hart@healthcare.com', 'NzryvnUneg', 'C'),
('ava.gomez@healthcare.com', 'NinTbzrm', 'C'),
('liam.tims@healthcare.com', 'YvnzGvzf', 'C'),
('noah.ark@healthcare.com', 'AbnuNex1', 'C'),
('oliver.queen@healthcare.com', 'ByvireDhrra', 'C'),
('james.john@healthcare.com', 'WnzrfWbua', 'C'),
('lucas.scott@healthcare.com', 'YhpnfFpbgg', 'C'),
('Joanna.Woods@healthcare.com', 'WbnaanJbbqf', 'D'),
('James.Liu@healthcare.com', 'WnzrfYvh', 'D'),
('Gustavo.Roth@healthcare.com', 'ThfgnibEbgu', 'D'),
('Carmela.Blevins@healthcare.com', 'PnezrynOyrivaf', 'D'),
('Loraine.Hurst@healthcare.com', 'YbenvarUhefg', 'D'),
('Mariano.Brown@healthcare.com', 'ZnevnabOebja', 'D'),
('Adrian.Arias@healthcare.com', 'NqevnaNevnf', 'D'),
('Tammie.Pham@healthcare.com', 'GnzzvrCunz', 'D'),
('Eugenia.Figueroa@healthcare.com', 'RhtravnSvthrebn', 'D'),
('Josephine.Lauzon@gmail.com', 'WbfrcuvarYnhmb', 'P'),
('Brenden.Powell@gmail.com', 'OeraqraCbjryy', 'P'),
('Jeannie.Lebrun@gmail.com', 'WrnaavrYroeha', 'P'),
('ionarthomas98@gmail.com', 'VfnnpGubznf1', 'P'),
('karran1697@gmail.com', 'Xnena1234', 'P');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
