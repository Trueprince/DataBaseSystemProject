-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 15, 2023 at 12:11 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `students_residence_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `residence`
--

DROP TABLE IF EXISTS `residence`;
CREATE TABLE IF NOT EXISTS `residence` (
  `Residence_ID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Capacity` int DEFAULT NULL,
  `Current_Occupancy` int DEFAULT NULL,
  `Residence_Manager` varchar(255) DEFAULT NULL,
  `Application_Deadline` date DEFAULT NULL,
  `Availability_Status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Residence_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `residence`
--

INSERT INTO `residence` (`Residence_ID`, `Name`, `Address`, `Capacity`, `Current_Occupancy`, `Residence_Manager`, `Application_Deadline`, `Availability_Status`) VALUES
(3, 'Moroka', 'Sol Plaatje University', 200, 6, 'sethu', '2024-12-12', 'Available'),
(4, 'South Campus', 'Sol Plaatje University', 300, 3, 'sethu', '2024-10-14', 'Available'),
(5, 'Caritas', 'Sol Plaatje University', 20, 1, 'prince', '2023-12-20', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
CREATE TABLE IF NOT EXISTS `room` (
  `Student_ID` int DEFAULT NULL,
  `Room_ID` int NOT NULL AUTO_INCREMENT,
  `Room_Number` varchar(255) DEFAULT NULL,
  `Room_Type` varchar(255) DEFAULT NULL,
  `Room_Status` varchar(255) DEFAULT NULL,
  `Residence_ID` int DEFAULT NULL,
  PRIMARY KEY (`Room_ID`),
  KEY `Student_ID` (`Student_ID`),
  KEY `Residence` (`Residence_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`Student_ID`, `Room_ID`, `Room_Number`, `Room_Type`, `Room_Status`, `Residence_ID`) VALUES
(7, 8, '1', 'Single', 'Occupied', 3),
(9, 9, '2', 'Shared', 'Occupied', 4),
(10, 10, '3', 'Single', 'Occupied', 3),
(12, 11, '4', 'Single', 'Occupied', 4),
(11, 18, '10', 'Shared', 'Occupied', 3),
(13, 25, 'D11', 'Single', 'Occupied', 4),
(14, 26, 'D13', 'Single', 'Occupied', 3),
(15, 27, 'D14', 'Single', 'Occupied', 3),
(16, 28, 'D15', 'Single', 'Occupied', 3),
(17, 29, 'C12', 'Single', 'Occupied', 5);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `Student_ID` int NOT NULL AUTO_INCREMENT,
  `First_Name` varchar(255) DEFAULT NULL,
  `Last_Name` varchar(255) DEFAULT NULL,
  `Gender` varchar(255) DEFAULT NULL,
  `Date_of_Birth` date DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Program_Department` varchar(255) DEFAULT NULL,
  `Current_Year_of_Study` int DEFAULT NULL,
  `Application_Status` varchar(255) DEFAULT NULL,
  `Room_ID` int DEFAULT NULL,
  `Residence_Preference` varchar(255) DEFAULT NULL,
  `Application_Date` date DEFAULT NULL,
  PRIMARY KEY (`Student_ID`),
  KEY `fk_room_allocation` (`Room_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_ID`, `First_Name`, `Last_Name`, `Gender`, `Date_of_Birth`, `Phone`, `Email`, `Program_Department`, `Current_Year_of_Study`, `Application_Status`, `Room_ID`, `Residence_Preference`, `Application_Date`) VALUES
(7, 'Khosi', 'Mashego', 'female', '1996-10-05', '0767975313', 'km@gmail.com', 'Data science', 2, 'Allocated', 8, 'Single', '2023-09-19'),
(9, 'Sentra', 'Mokeona', 'female', '2022-02-02', '0768865245', 'sm@gmail.com', 'ICT', 2, 'Allocated', 9, 'Shared', '2023-09-20'),
(10, 'Sbu', 'Lubisi', 'male', '2000-03-04', '0720109668', 'sbul@gmail.com', 'Data science', 2, 'Allocated', 10, 'Shared', '2023-09-20'),
(11, 'sbuda', 'mlambo', 'male', '2010-12-01', '02020252535', 'sbudam@gmail.com', 'ICT', 4, 'Allocated', 11, 'Single', '2023-09-21'),
(12, 'lovedelia', 'maregwa', 'female', '2002-12-05', '0728940985', '202226599@spu.ac.za', 'Data science', 2, 'Allocated', 18, 'Shared', '2023-09-23'),
(13, 'nomfundo', 'hlatswayo', 'female', '1995-06-01', '64587996', 'nomfundo@gmail.com', 'ICT', 4, 'Allocated', 25, 'Single', '2023-09-24'),
(14, 'cindy', 'magaguala', 'female', '2002-07-01', '79055577', 'cindym@gmail.com', 'BEd', 4, 'Allocated', 26, 'Single', '2023-09-24'),
(15, 'indi', 'Lubisi', 'male', '2000-06-02', '072589634', 'indiL@gmail.com', 'BEd', 4, 'Allocated', 27, 'Single', '2023-09-24'),
(16, 'langelihle', 'malinga', 'male', '2000-02-02', '0815073947', '202208282@spu.ac.za', 'Data science', 2, 'Allocated', 28, 'Single', '2023-10-14'),
(17, 'happy', 'nkate', 'male', '2002-12-12', '88825211', 'h@gmail.com', 'ICT', 4, 'Allocated', 29, 'Single', '2023-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(6, 'prince', '$2y$10$yFmGOH/tnNGsOJuRE1Ey2ewO9RQ1QucmE5wHUJHhp0fzgg1pYOU7q', 'admin'),
(7, 'khosi', '$2y$10$ME0OH9oWAjXL6ApSjBxpT.oqsFUx2zFxID8OYRfOOq.mI4ZR00BD.', 'student'),
(8, 'nomsa', '$2y$10$0HqF2ciyBSHqDA7XWvvlIO2hHQYnTbnx2jaQn4mkW/iW6AadoDZGK', 'manager'),
(9, 'sentra', '$2y$10$0RB2R2esGyc4PsmcRA555ui4gF0E8z0JuD214p75qA1RGHNBWaQp6', 'student'),
(10, 'sbu', '$2y$10$bob9ZC1SNf/M6joa1iDLc.aFqBBG/ZrhF42pwmsj/McwvTypkzksm', 'student'),
(11, 'sbuda', '$2y$10$E/O7jsvQFBgOP0jkqfvrJ.XFI6mLQ0tE4EqwEhz0MZ3K3x0UwoCRW', 'student'),
(12, 'maregwa', '$2y$10$G0gcMorqL3Ypq4nBhZ/lK.uWbcpeKnErqfGDcvQo/tvldYakH3m4a', 'student'),
(13, 'nomfundo', '$2y$10$pz2TzDqZ0O9.2bCZ8mFRheMvOO6BYdtSRfBkzwANUqSldMsP/uTiq', 'student'),
(14, 'cindy', '$2y$10$.Hb01PrM38GhEPjRbpnB2.WBYBCwcSi4/2/mLZSl6iv1rYMX6R7lG', 'student'),
(15, 'indi', '$2y$10$ChLFeCKy3nhIOQZQl65ilum8EKZkphh1/Fsu263UT1rSXGZqSAoZu', 'student'),
(16, 'langelinhle', '$2y$10$bG3Y5UiSh3v00JesCpuvGu1lYiwdg5o5RvG9P2g.J0Ej7D/hXEd56', 'student'),
(17, 'happy', '$2y$10$ol3FGAphgut/GsqsP2h2c.qMIv4MYvbki.7os5eFMeCJyVUSOz/gG', 'student');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `fk_room_residence` FOREIGN KEY (`Residence_ID`) REFERENCES `residence` (`Residence_ID`),
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `student` (`Student_ID`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_room_allocation` FOREIGN KEY (`Room_ID`) REFERENCES `room` (`Room_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
