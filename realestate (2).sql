-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2023 at 07:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realestate`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `AdminID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AdminID`, `Username`, `Password`) VALUES
(2, 'Admin', '$2y$10$LfbXZGE6Ik8V1nTr9IpBEe.W4zFFH06Sr.ncttkaHJxweAl018GKa');

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `AmenityID` int(11) NOT NULL,
  `AmenityName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `PropertyID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Type` enum('House','Apartment','Condo','Land','Commercial') NOT NULL,
  `Price` decimal(15,2) NOT NULL,
  `Bedrooms` tinyint(4) DEFAULT NULL,
  `Bathrooms` tinyint(4) DEFAULT NULL,
  `Size_sqft` int(11) DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `Status` enum('For Sale','For Rent','Sold') DEFAULT 'For Sale',
  `ListedDate` date NOT NULL,
  `SoldDate` date DEFAULT NULL
) ;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`PropertyID`, `UserID`, `Title`, `Description`, `Type`, `Price`, `Bedrooms`, `Bathrooms`, `Size_sqft`, `Location`, `Status`, `ListedDate`, `SoldDate`) VALUES
(1, 1, 'Test2', 'Test1', 'House', 0.00, NULL, NULL, NULL, NULL, 'For Sale', '0000-00-00', NULL),
(3, 1, 'Test1', 'Test1', 'House', 0.00, NULL, NULL, NULL, NULL, 'For Sale', '0000-00-00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `propertyamenities`
--

CREATE TABLE `propertyamenities` (
  `PropertyID` int(11) DEFAULT NULL,
  `AmenityID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `propertyimages`
--

CREATE TABLE `propertyimages` (
  `ImageID` int(11) NOT NULL,
  `PropertyID` int(11) DEFAULT NULL,
  `ImageURL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `propertyimages`
--

INSERT INTO `propertyimages` (`ImageID`, `PropertyID`, `ImageURL`) VALUES
(7, 3, '../../uploads/0fgjhs1bljaq0qsop8.webp'),
(8, 1, '../../uploads/929-1102.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `TransactionID` int(11) NOT NULL,
  `PropertyID` int(11) DEFAULT NULL,
  `BuyerID` int(11) DEFAULT NULL,
  `SellerID` int(11) DEFAULT NULL,
  `TransactionDate` date DEFAULT NULL,
  `Price` decimal(15,2) NOT NULL,
  `TransactionType` enum('Buy','Rent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `RegistrationDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FullName`, `Email`, `Password`, `RegistrationDate`) VALUES
(1, 'Client1', 'Client1@email.com', '$2y$10$JPiig/rJCmlKCS7PoiQpXuJvZW1EecTMMSimAqiadExuIQwKYhwfG', '2023-12-02 23:20:08'),
(4, 'Admin', '', '$2y$10$r4DcWkPFMxhkEf1aJHuLpe7VCYtVisWB5qVyUT.s944x5YnVdl83i', '2023-12-05 04:51:50'),
(9, 'Client2', 'Client2@email.com', '$2y$10$INPMRRfLnjwZT5t20YJfAOFwdFBJ1HtCTSiqrFel2Bd0buRmi8Vjq', '2023-12-07 07:53:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`AmenityID`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`PropertyID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `propertyamenities`
--
ALTER TABLE `propertyamenities`
  ADD KEY `PropertyID` (`PropertyID`),
  ADD KEY `AmenityID` (`AmenityID`);

--
-- Indexes for table `propertyimages`
--
ALTER TABLE `propertyimages`
  ADD PRIMARY KEY (`ImageID`),
  ADD KEY `PropertyID` (`PropertyID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `PropertyID` (`PropertyID`),
  ADD KEY `BuyerID` (`BuyerID`),
  ADD KEY `SellerID` (`SellerID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `AmenityID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `PropertyID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `propertyimages`
--
ALTER TABLE `propertyimages`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `propertyamenities`
--
ALTER TABLE `propertyamenities`
  ADD CONSTRAINT `propertyamenities_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`) ON DELETE CASCADE,
  ADD CONSTRAINT `propertyamenities_ibfk_2` FOREIGN KEY (`AmenityID`) REFERENCES `amenities` (`AmenityID`) ON DELETE CASCADE;

--
-- Constraints for table `propertyimages`
--
ALTER TABLE `propertyimages`
  ADD CONSTRAINT `propertyimages_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`BuyerID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`SellerID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
