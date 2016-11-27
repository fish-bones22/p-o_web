-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2016 at 05:52 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `po`
--

-- --------------------------------------------------------

--
-- Table structure for table `bus2`
--

CREATE TABLE `bus2` (
  `Bus_No` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Bus_Type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Bus_Code` int(15) NOT NULL,
  `Seats` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_cubao` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bus2`
--

INSERT INTO `bus2` (`Bus_No`, `Bus_Type`, `Bus_Code`, `Seats`, `check_cubao`) VALUES
('055455', 'Ordinary', 56, '45', NULL),
('055905', 'Ordinary', 57, '55', NULL),
('055325', 'Ordinary', 58, '45', NULL),
('005535', 'Ordinary', 59, '55', NULL),
('055555', 'Ordinary', 60, '55', NULL),
('055105', 'Ordinary', 61, '45', NULL),
('055235', 'Ordinary', 62, '55', NULL),
('055475', 'Ordinary', 63, '45', NULL),
('055335', 'Ordinary', 64, '45', NULL),
('551205', 'Aircon', 65, '45', NULL),
('551105', 'Aircon', 66, '45', NULL),
('055565', 'Ordinary', 67, '55', NULL),
('055865', 'Aircon', 68, '45', NULL),
('551005', 'Aircon', 69, '45', NULL),
('055955', 'Ordinary', 70, '55', NULL),
('055465', 'Ordinary', 71, '55', NULL),
('055395', 'Ordinary', 72, '45', NULL),
('055675', 'Ordinary', 73, '55', NULL),
('055695', 'Ordinary', 74, '55', NULL),
('055805', 'Ordinary', 75, '55', NULL),
('055725', 'Ordinary', 76, '45', NULL),
('055755', 'Aircon', 77, '45', NULL),
('551305', 'Aircon', 78, '55', NULL),
('055565', 'Ordinary', 79, '45', NULL),
('055405', 'Ordinary', 80, '55', NULL),
('005595', 'Ordinary', 81, '45', NULL),
('055615', 'Ordinary', 82, '45', NULL),
('055645', 'Ordinary', 83, '45', NULL),
('055205', 'Ordinary', 84, '55', NULL),
('055295', 'Ordinary', 85, '45', NULL),
('055115', 'Ordinary', 86, '55', NULL),
('055995', 'Ordinary', 87, '55', NULL),
('055895', 'Ordinary', 88, '55', NULL),
('551505', 'Aircon', 89, '45', 'Yes'),
('551605', 'Aircon', 90, '45', 'Yes'),
('551705', 'Aircon', 91, '55', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `About` longtext NOT NULL,
  `smart_number` varchar(20) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `fb_link` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`About`, `smart_number`, `mobile_number`, `fb_link`, `email`, `id`) VALUES
('P&O Transport Corporation is devoted in giving our passengers a safe and happy trip. Our business is divided into two entity; first, P&O TRANSPORTATION which is a sole proprietorship named to Edwin D. Chito and another is P&O TRANSPORT CORP. which is registered as a Corporation. We are previously known as BARNEY AUTO LINES founded by Mr. Guillermo Chito and now divided and managed by his children which is now known as BALGCO (managed by Mr. Barney Chito, eldest son), P&O TRANSPORT SYSTEM (managed by Mr. Edwin D. Chito, 3rd son) and BAL Company (managed by the whole family).', '5577-xxxx-xxxx-xxxx', '09xx-xxx-xxxx', 'facebook.com/po.transport', 'po@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `From_G` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `From_A` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `O_Price` int(4) UNSIGNED ZEROFILL NOT NULL,
  `A_Price` int(4) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`From_G`, `From_A`, `O_Price`, `A_Price`) VALUES
('Calauag', 'Sto. Tomas', 0025, 0025),
('Lopez', 'Alaminos', 0045, 0045),
('Gumaca', 'San Pablo', 0060, 0060),
('Atimonan', 'Tiaong', 0080, 0080),
('Siain', 'Candelaria', 0090, 0090),
('Atimonan', 'Sariaya', 0100, 0100),
('Pagbilao', 'Lucena', 0120, 0120),
('Lucena', 'Pagbilao', 0140, 0140),
('Sariaya', 'Atimonan', 0165, 0165),
('Candelaria', 'Siain', 0190, 0190),
('Tiaong', 'Gumaca', 0220, 0220),
('San Pablo', 'Lopez', 0240, 0240),
('Alaminos', 'Calauag', 0260, 0260),
('Alabang', 'Guinayangan', 0275, 0275),
('Cubao', '', 0320, 0320);

-- --------------------------------------------------------

--
-- Table structure for table `reserve`
--

CREATE TABLE `reserve` (
  `Bus_No` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rDate` date NOT NULL,
  `status` set('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Reserve_Code` int(15) UNSIGNED ZEROFILL NOT NULL,
  `DeptTime` time NOT NULL,
  `route` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seatplan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tPrice` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Trip_Code` int(15) UNSIGNED ZEROFILL NOT NULL,
  `tDate` date NOT NULL,
  `time_verifier` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reserve`
--

INSERT INTO `reserve` (`Bus_No`, `rDate`, `status`, `email`, `Reserve_Code`, `DeptTime`, `route`, `seatplan`, `tPrice`, `Trip_Code`, `tDate`, `time_verifier`) VALUES
('055455', '2016-11-27', 'Yes', 'samuelquinto22@gmail.com', 000000000000021, '12:20:00', '', '12', '60', 000000000000001, '2016-11-26', '2016-11-26 05:34:11'),
('055955', '2016-11-27', 'No', 'jeru@gmail.com', 000000000000023, '10:40:00', '', '30,31,20', '0', 000000000000015, '2016-11-26', '2016-11-26 07:46:31'),
('055895', '2016-11-27', 'No', 'jeru@gmail.com', 000000000000024, '01:00:00', '', '9,8', '0', 000000000000033, '2016-11-26', '2016-11-26 07:52:53'),
('055895', '2016-11-28', 'No', 'samuelquinto22@gmail.com', 000000000000025, '08:00:00', 'Alabang', '2,7,12', '75', 000000000000033, '2016-11-27', '2016-11-27 04:18:56');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `Transaction_Code` int(15) UNSIGNED ZEROFILL NOT NULL,
  `Bus_No` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rdate` date NOT NULL,
  `tPrice` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Reserve_Code` int(15) UNSIGNED ZEROFILL NOT NULL,
  `tdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trip3`
--

CREATE TABLE `trip3` (
  `Dept_A` time NOT NULL,
  `Dept_B` time NOT NULL,
  `Bus_No` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Trip_Code` int(15) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trip3`
--

INSERT INTO `trip3` (`Dept_A`, `Dept_B`, `Bus_No`, `Trip_Code`) VALUES
('05:20:00', '12:20:00', '055455', 000000000000001),
('05:40:00', '12:40:00', '055905', 000000000000002),
('06:10:00', '13:10:00', '055325', 000000000000003),
('06:30:00', '13:30:00', '005535', 000000000000004),
('07:00:00', '14:00:00', '055555', 000000000000005),
('07:20:00', '14:20:00', '055105', 000000000000006),
('07:40:00', '14:40:00', '055235', 000000000000007),
('08:00:00', '15:00:00', '055475', 000000000000008),
('08:20:00', '15:20:00', '055335', 000000000000009),
('08:40:00', '15:40:00', '551205', 000000000000010),
('09:00:00', '16:00:00', '551105', 000000000000011),
('09:30:00', '16:30:00', '055565', 000000000000012),
('09:50:00', '16:50:00', '055865', 000000000000013),
('10:10:00', '17:10:00', '551005', 000000000000014),
('10:40:00', '17:40:00', '055955', 000000000000015),
('11:00:00', '18:00:00', '055465', 000000000000016),
('11:30:00', '18:30:00', '055395', 000000000000017),
('12:00:00', '19:00:00', '055675', 000000000000018),
('12:30:00', '19:30:00', '055695', 000000000000019),
('06:20:00', '13:20:00', '055805', 000000000000020),
('06:40:00', '13:40:00', '055725', 000000000000021),
('07:00:00', '14:00:00', '055755', 000000000000022),
('09:00:00', '16:00:00', '551305', 000000000000023),
('09:20:00', '16:20:00', '055565', 000000000000024),
('09:50:00', '16:50:00', '055405', 000000000000025),
('10:10:00', '17:10:00', '005595', 000000000000026),
('10:30:00', '17:30:00', '055615', 000000000000027),
('10:50:00', '17:50:00', '055645', 000000000000028),
('11:20:00', '18:20:00', '055205', 000000000000029),
('11:40:00', '18:40:00', '055295', 000000000000030),
('12:10:00', '19:10:00', '055115', 000000000000031),
('12:40:00', '19:40:00', '055995', 000000000000032),
('01:00:00', '08:00:00', '055895', 000000000000033),
('01:20:00', '08:20:00', '551505', 000000000000034),
('01:40:00', '08:40:00', '551605', 000000000000035),
('02:00:00', '09:00:00', '551705', 000000000000036);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Fname` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Lname` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Admin_Check` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Address` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Fname`, `Lname`, `email`, `password`, `phone`, `Admin_Check`, `Address`) VALUES
('Adame', 'dsa', 'asdf@gmail.com', '12345678', '09183289722', 'No', ''),
('JD', 'Reyes', 'jdreyes662@gmail.com', 'flatron26', '09183289722', 'Yes', ''),
('Jeru', 'Barlos', 'jeru@gmail.com', '12345678', '09183256889', 'No', ''),
('Sam', 'Quinto', 'samuelquinto22@gmail.com', '12345678', '09183289850', 'No', 'Lucena City');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bus2`
--
ALTER TABLE `bus2`
  ADD PRIMARY KEY (`Bus_Code`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`O_Price`);

--
-- Indexes for table `reserve`
--
ALTER TABLE `reserve`
  ADD PRIMARY KEY (`Reserve_Code`),
  ADD KEY `email_2` (`email`),
  ADD KEY `Trip_Code` (`Trip_Code`) USING BTREE;

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`Transaction_Code`),
  ADD UNIQUE KEY `Reserve_Code` (`Reserve_Code`),
  ADD KEY `email` (`email`) USING BTREE;

--
-- Indexes for table `trip3`
--
ALTER TABLE `trip3`
  ADD PRIMARY KEY (`Trip_Code`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bus2`
--
ALTER TABLE `bus2`
  MODIFY `Bus_Code` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `reserve`
--
ALTER TABLE `reserve`
  MODIFY `Reserve_Code` int(15) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `Transaction_Code` int(15) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trip3`
--
ALTER TABLE `trip3`
  MODIFY `Trip_Code` int(15) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `reserve`
--
ALTER TABLE `reserve`
  ADD CONSTRAINT `reserve_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `reserve_ibfk_2` FOREIGN KEY (`Trip_Code`) REFERENCES `trip3` (`Trip_Code`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `auto_delete_if_not_verified` ON SCHEDULE EVERY 1 DAY STARTS '2016-11-26 09:38:18' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'pang auto delete to, naka 1 minute pa lang ngayon pero babaguhin' DO DELETE FROM reserve WHERE time_verifier >= (CURRENT_TIMESTAMP - INTERVAL 1 DAY) AND status = "No"$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
