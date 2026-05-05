-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2024 at 12:22 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_booking_tecket`
--

-- --------------------------------------------------------

--
-- Table structure for table `booked`
--

CREATE TABLE `booked` (
  `Bk_Id` int(6) NOT NULL,
  `B_Id` int(6) NOT NULL,
  `Created_at_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `B_Id` int(6) NOT NULL,
  `P_Names` varchar(60) NOT NULL,
  `P_Phone` text NOT NULL,
  `P_Email` text NOT NULL,
  `Id` int(6) NOT NULL,
  `Seat_Count` int(6) NOT NULL DEFAULT 1,
  `Seat_Number` int(6) DEFAULT NULL,
  `Ticket_Code` varchar(5) DEFAULT NULL,
  `activityi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `Car_Id` int(6) NOT NULL,
  `Car_Plaque` text NOT NULL,
  `C_Id` int(6) NOT NULL,
  `Number_Place` int(6) NOT NULL,
  `Emp_Id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`Car_Id`, `Car_Plaque`, `C_Id`, `Number_Place`, `Emp_Id`) VALUES
(14, 'ADD123', 27, 30, 18),
(15, 'VXW4', 27, 60, 19),
(16, 'RAB', 30, 30, 20),
(17, 'RBAA', 30, 30, 21);

-- --------------------------------------------------------

--
-- Table structure for table `cars_to_leave`
--

CREATE TABLE `cars_to_leave` (
  `id` int(6) NOT NULL,
  `Car_Id` int(6) NOT NULL,
  `D_Id` int(11) NOT NULL,
  `Time_to_leave` text NOT NULL,
  `date_car_to` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `timing` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars_to_leave`
--

INSERT INTO `cars_to_leave` (`id`, `Car_Id`, `D_Id`, `Time_to_leave`, `date_car_to`, `timing`) VALUES
(47, 14, 29, '12:16 AM', '2024-08-17 10:14:31', NULL),
(48, 15, 32, '12:16 PM', '2024-08-17 10:14:47', NULL),
(49, 15, 30, '12:20 AM', '2024-08-17 10:16:33', NULL),
(50, 14, 33, '12:21 PM', '2024-08-17 10:16:53', NULL),
(51, 17, 34, '12:24 AM', '2024-08-17 10:19:02', NULL),
(52, 16, 36, '12:20 PM', '2024-08-17 10:19:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `C_Id` int(6) NOT NULL,
  `C_Name` varchar(45) NOT NULL,
  `C_Logo` text NOT NULL,
  `C_Phone` text NOT NULL,
  `C_Email` text NOT NULL,
  `C_Ceo` varchar(60) NOT NULL,
  `C_Username` varchar(45) NOT NULL,
  `C_Password` text NOT NULL,
  `C_Checking` varchar(45) NOT NULL DEFAULT 'pending....'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`C_Id`, `C_Name`, `C_Logo`, `C_Phone`, `C_Email`, `C_Ceo`, `C_Username`, `C_Password`, `C_Checking`) VALUES
(27, 'RITCO', 'agency_logo/(RITCO)__(66c075986f2826.43674496).png', '0788888888', 'ritco@gmail.com', 'eugene', 'ritco', '123', 'activated'),
(28, 'Horizon', 'agency_logo/(Horizon)__(66c075ef6911f8.88976787).png', '0799999999', 'horizon@gmail.com', 'ndayishimiye', 'horizon', '1234', 'activated'),
(29, 'Matunda', 'agency_logo/(Matunda)__(66c07638a4eca3.03478217).png', '0722222222', 'matunda@gmail.com', 'yollamu', 'matunda', '123', 'activated'),
(30, 'KBS', 'agency_logo/(KBS)__(66c0766d08c674.97358280).png', '0733333333', 'kbs@gmail.com', 'aimecoll', 'kbs', '1234', 'activated'),
(31, 'Stella', 'agency_logo/(Stella)__(66c076ab3d5702.37734045).png', '0788899999', 'stella@gmail.com', 'fablice', 'stella@gmail.com', '1234', 'activated'),
(32, 'Volcano', 'agency_logo/(Volcano)__(66c076ea63f8c9.50706665).png', '0799988888', 'volcano@gmail.com', 'Mazimpaka', 'volcano', '12345', 'activated'),
(33, 'Yahoo', 'agency_logo/(Yahoo)__(66c07725d81b05.65351042).png', '0723232323', 'yahoo@gmail.com', 'IGIRANEZA', 'yahoo', '123456', 'activated');

-- --------------------------------------------------------

--
-- Table structure for table `destination`
--

CREATE TABLE `destination` (
  `D_Id` int(6) NOT NULL,
  `L_id` int(6) NOT NULL,
  `C_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`D_Id`, `L_id`, `C_Id`) VALUES
(29, 38, 27),
(30, 34, 27),
(31, 36, 27),
(32, 32, 27),
(33, 35, 27),
(34, 38, 30),
(35, 36, 30),
(36, 35, 30);

-- --------------------------------------------------------

--
-- Table structure for table `employeers`
--

CREATE TABLE `employeers` (
  `Emp_Id` int(6) NOT NULL,
  `Emp_Fname` varchar(50) NOT NULL,
  `Emp_Lname` varchar(50) NOT NULL,
  `Emp_Phone` text NOT NULL,
  `Emp_Idcard` bigint(16) NOT NULL,
  `C_Id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employeers`
--

INSERT INTO `employeers` (`Emp_Id`, `Emp_Fname`, `Emp_Lname`, `Emp_Phone`, `Emp_Idcard`, `C_Id`) VALUES
(18, 'Irenee', 'KWIZERA', '0785750116', 1200042356789087, 27),
(19, 'murindahabi', 'fredy', '0785750017', 3566312345678787, 27),
(20, 'gashumba', 'nuru', '0785750117', 6665674747837872, 30),
(21, 'ngeni', 'munesa', '0733333330', 1200242356789009, 30);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `fid` int(6) NOT NULL,
  `names` text NOT NULL,
  `femail` text NOT NULL,
  `fsub` text NOT NULL,
  `fcoment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`fid`, `names`, `femail`, `fsub`, `fcoment`) VALUES
(1, 'eugene', 'nendayishimiye@gmail.com', 'news', 'muraho\r\n'),
(2, 'eugene', 'nendayishimiye@gmail.com', 'news', 'muraho\r\n'),
(3, 'eugene', 'nendayishimiye@gmail.com', 'news', 'muraho\r\n'),
(4, 'mugisha', 'mugisha@gmail.com', 'report', 'turarambiwe');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `L_id` int(6) NOT NULL,
  `L_from` varchar(50) NOT NULL,
  `L_to` varchar(50) NOT NULL,
  `price` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`L_id`, `L_from`, `L_to`, `price`) VALUES
(32, 'kigali', 'gisenyi', '5000'),
(34, 'Gisenyi', 'musanze', '1900'),
(35, 'musanze ', 'Kigali', '2000'),
(36, 'karongi', 'gisenyi', '2500'),
(38, 'gikongoro', 'nyange', '3800');

-- --------------------------------------------------------

--
-- Table structure for table `system_controller`
--

CREATE TABLE `system_controller` (
  `S_Id` int(6) NOT NULL,
  `S_Username` varchar(50) NOT NULL,
  `S_Password` text NOT NULL,
  `S_Phone` text NOT NULL,
  `Rolee` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_controller`
--

INSERT INTO `system_controller` (`S_Id`, `S_Username`, `S_Password`, `S_Phone`, `Rolee`) VALUES
(1, 'ne', 'ne', '0785750117', 'admini');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked`
--
ALTER TABLE `booked`
  ADD PRIMARY KEY (`Bk_Id`),
  ADD KEY `B_Id` (`B_Id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`B_Id`),
  ADD KEY `Id` (`Id`),
  ADD UNIQUE KEY `uniq_trip_seat` (`Id`,`Seat_Number`),
  ADD UNIQUE KEY `uniq_ticket_code` (`Ticket_Code`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`Car_Id`),
  ADD UNIQUE KEY `Car_Plaque` (`Car_Plaque`) USING HASH,
  ADD KEY `C_Id` (`C_Id`),
  ADD KEY `Emp_Id` (`Emp_Id`);

--
-- Indexes for table `cars_to_leave`
--
ALTER TABLE `cars_to_leave`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Car_Id` (`Car_Id`),
  ADD KEY `D_Id` (`D_Id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`C_Id`),
  ADD UNIQUE KEY `C_Username` (`C_Username`),
  ADD UNIQUE KEY `C_Name` (`C_Name`),
  ADD UNIQUE KEY `C_Email` (`C_Email`) USING HASH;

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`D_Id`),
  ADD KEY `C_Id` (`C_Id`),
  ADD KEY `L_id` (`L_id`);

--
-- Indexes for table `employeers`
--
ALTER TABLE `employeers`
  ADD PRIMARY KEY (`Emp_Id`),
  ADD UNIQUE KEY `Emp_Idcard` (`Emp_Idcard`),
  ADD UNIQUE KEY `Emp_Phone` (`Emp_Phone`) USING HASH,
  ADD KEY `C_Id` (`C_Id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`L_id`);

--
-- Indexes for table `system_controller`
--
ALTER TABLE `system_controller`
  ADD PRIMARY KEY (`S_Id`),
  ADD UNIQUE KEY `S_Username` (`S_Username`),
  ADD UNIQUE KEY `S_Phone` (`S_Phone`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked`
--
ALTER TABLE `booked`
  MODIFY `Bk_Id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `B_Id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `Car_Id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cars_to_leave`
--
ALTER TABLE `cars_to_leave`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `C_Id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `D_Id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `employeers`
--
ALTER TABLE `employeers`
  MODIFY `Emp_Id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `fid` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `L_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `system_controller`
--
ALTER TABLE `system_controller`
  MODIFY `S_Id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked`
--
ALTER TABLE `booked`
  ADD CONSTRAINT `booked_ibfk_1` FOREIGN KEY (`B_Id`) REFERENCES `booking` (`B_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Id`) REFERENCES `cars_to_leave` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`C_Id`) REFERENCES `company` (`C_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cars_ibfk_2` FOREIGN KEY (`Emp_Id`) REFERENCES `employeers` (`Emp_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cars_to_leave`
--
ALTER TABLE `cars_to_leave`
  ADD CONSTRAINT `cars_to_leave_ibfk_1` FOREIGN KEY (`Car_Id`) REFERENCES `cars` (`Car_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cars_to_leave_ibfk_2` FOREIGN KEY (`D_Id`) REFERENCES `destination` (`D_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `destination`
--
ALTER TABLE `destination`
  ADD CONSTRAINT `destination_ibfk_1` FOREIGN KEY (`L_id`) REFERENCES `locations` (`L_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `destination_ibfk_2` FOREIGN KEY (`C_Id`) REFERENCES `company` (`C_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `destination_ibfk_3` FOREIGN KEY (`L_id`) REFERENCES `locations` (`L_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employeers`
--
ALTER TABLE `employeers`
  ADD CONSTRAINT `employeers_ibfk_1` FOREIGN KEY (`C_Id`) REFERENCES `company` (`C_Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
