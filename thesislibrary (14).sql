-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2024 at 08:46 AM
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
-- Database: `thesislibrary`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountroles`
--

CREATE TABLE `accountroles` (
  `roleID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accountroles`
--

INSERT INTO `accountroles` (`roleID`, `name`) VALUES
(1, 'admin'),
(2, 'staff'),
(3, 'student');

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1,
  `email` varchar(255) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `course` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`ID`, `username`, `password`, `role`, `description`, `date_created`, `status`, `email`, `department`, `course`) VALUES
(22, 'admin', '$2y$10$ijfh6aa33kjABaywVp/0numHsgd7UkM4X5Jqjdc1.w2RMpJZeCRyG', 1, NULL, '2024-12-13 04:49:08', 2, NULL, NULL, NULL),
(23, 'citylib', '$2y$10$nDiUsgCF8hW9iuyLZtzyUuE4LHriC1KQHYXZ8bnvRgD5X95uZdoXy', 2, NULL, '2024-12-13 04:49:22', 2, NULL, NULL, NULL),
(24, 'schoollib', '$2y$10$tRI3aEB7pnRxzmJSJskg6u3zamwyx0s8zNYZEpi0DnGSowxwy5gHS', 2, NULL, '2024-12-13 04:49:33', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `authorID` int(11) NOT NULL,
  `groupID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `departmentID` int(11) NOT NULL,
  `coursesID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseID` int(11) NOT NULL,
  `courseName` varchar(255) NOT NULL,
  `departmentID` int(11) NOT NULL,
  `courseType` enum('Undergrad','Graduate') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseID`, `courseName`, `departmentID`, `courseType`) VALUES
(1, 'BACHELOR OF LAWS', 1, 'Undergrad'),
(2, 'BACHELOR OF SCIENCE IN AGRICULTURE', 2, 'Undergrad'),
(3, 'BACHELOR OF SCIENCE IN FOOD TECHNOLOGY', 2, 'Undergrad'),
(4, 'BACHELOR OF SCIENCE IN AGRIBUSINESS', 2, 'Undergrad'),
(5, 'BACHELOR OF AGRICULTURAL TECHNOLOGY', 2, 'Undergrad'),
(6, 'MASTER OF SCIENCE IN AGRONOMY', 2, 'Graduate'),
(7, 'MASTERS IN FOOD PROCESSING AND MANAGEMENT', 2, 'Graduate'),
(8, 'BACHELOR OF SCIENCE IN COMPUTER SCIENCE', 3, 'Undergrad'),
(9, 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', 3, 'Undergrad'),
(10, 'ASSOCIATE IN COMPUTER TECHNOLOGY', 3, 'Undergrad'),
(11, 'MASTER IN INFORMATION TECHNOLOGY', 3, 'Graduate'),
(12, 'BACHELOR OF SCIENCE IN ACCOUNTANCY', 4, 'Undergrad'),
(13, 'BACHELOR OF ARTS IN HISTORY', 4, 'Undergrad'),
(14, 'BACHELOR OF ARTS IN ENGLISH', 4, 'Undergrad'),
(15, 'BACHELOR OF ARTS IN POLITICAL SCIENCE', 4, 'Undergrad'),
(16, 'BACHELOR OF ARTS IN MASS COMMUNICATION - JOURNALISM', 4, 'Undergrad'),
(17, 'BACHELOR OF ARTS IN MASS COMMUNICATION - BROADCASTING', 4, 'Undergrad'),
(18, 'BACHELOR OF SCIENCE IN ECONOMICS', 4, 'Undergrad'),
(19, 'BACHELOR OF SCIENCE IN PSYCHOLOGY', 4, 'Undergrad'),
(20, 'BACHELOR OF SCIENCE IN ARCHITECTURE', 5, 'Undergrad'),
(21, 'BACHELOR OF SCIENCE IN NURSING', 6, 'Undergrad'),
(22, 'BACHELOR OF SCIENCE IN FORESTRY', 8, 'Undergrad'),
(23, 'BACHELOR OF SCIENCE IN AGROFORESTRY', 8, 'Undergrad'),
(24, 'BACHELOR OF SCIENCE IN ENVIRONMENTAL SCIENCE', 8, 'Undergrad'),
(25, 'BACHELOR OF SCIENCE IN CRIMINOLOGY', 9, 'Undergrad'),
(26, 'BACHELOR OF SCIENCE IN HOME ECONOMICS', 10, 'Undergrad'),
(27, 'BACHELOR OF SCIENCE IN AGRICULTURAL AND BIOSYSTEMS ENGINEERING', 11, 'Undergrad'),
(28, 'BACHELOR OF SCIENCE IN CIVIL ENGINEERING', 11, 'Undergrad'),
(29, 'BACHELOR OF SCIENCE IN COMPUTER ENGINEERING', 11, 'Undergrad'),
(30, 'BACHELOR OF SCIENCE IN ELECTRICAL ENGINEERING', 11, 'Undergrad'),
(31, 'BACHELOR OF SCIENCE IN ELECTRONICS ENGINEERING', 11, 'Undergrad'),
(32, 'BACHELOR OF SCIENCE IN ENVIRONMENTAL ENGINEERING', 11, 'Undergrad'),
(33, 'BACHELOR OF SCIENCE IN GEODETIC ENGINEERING', 11, 'Undergrad'),
(34, 'BACHELOR OF SCIENCE IN INDUSTRIAL ENGINEERING', 11, 'Undergrad'),
(35, 'BACHELOR OF SCIENCE IN MECHANICAL ENGINEERING', 11, 'Undergrad'),
(36, 'BACHELOR OF SCIENCE IN SANITARY ENGINEERING', 11, 'Undergrad'),
(37, 'BACHELOR OF SCIENCE IN MEDICINE', 12, 'Undergrad'),
(38, 'BACHELOR OF PUBLIC ADMINISTRATION', 13, 'Undergrad'),
(39, 'MASTER OF PUBLIC ADMINISTRATION', 13, 'Graduate'),
(40, 'BACHELOR OF PHYSICAL EDUCATION', 14, 'Undergrad'),
(41, 'BACHELOR OF SCIENCE IN EXERCISE AND SPORTS SCIENCES', 14, 'Undergrad'),
(42, 'MASTER IN PHYSICAL EDUCATION', 14, 'Graduate'),
(43, 'BACHELOR OF SCIENCE IN BIOLOGY', 15, 'Undergrad'),
(44, 'BACHELOR OF SCIENCE IN CHEMISTRY', 15, 'Undergrad'),
(45, 'BACHELOR OF SCIENCE IN MATHEMATICS', 15, 'Undergrad'),
(46, 'BACHELOR OF SCIENCE IN PHYSICS', 15, 'Undergrad'),
(47, 'BACHELOR OF SCIENCE IN STATISTICS', 15, 'Undergrad'),
(48, 'BACHELOR OF SCIENCE IN SOCIAL WORK', 16, 'Undergrad'),
(49, 'BACHELOR OF SCIENCE IN COMMUNITY DEVELOPMENT', 16, 'Undergrad'),
(50, 'MASTER OF SCIENCE IN SOCIAL WORK', 16, 'Graduate'),
(51, 'BACHELOR OF CULTURE AND ARTS EDUCATION', 17, 'Undergrad'),
(52, 'BACHELOR OF EARLY CHILDHOOD EDUCATION', 17, 'Undergrad'),
(53, 'BACHELOR OF ELEMENTARY EDUCATION', 17, 'Undergrad'),
(54, 'BACHELOR OF SECONDARY EDUCATION', 17, 'Undergrad'),
(55, 'BACHELOR OF SPECIAL NEEDS EDUCATION', 17, 'Undergrad'),
(57, 'BACHELOR OF SCIENCE IN NUTRITION AND DIETETICS', 10, 'Undergrad'),
(58, 'BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT', 10, 'Undergrad'),
(65, 'BACHELOR OF ARTS IN ISLAMIC STUDIES', 7, 'Undergrad'),
(66, 'BACHELOR OF ARTS IN ASIAN STUDIES', 7, 'Undergrad');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentID` int(11) NOT NULL,
  `departmentName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentID`, `departmentName`) VALUES
(1, 'COLLEGE OF LAW'),
(2, 'COLLEGE OF AGRICULTURE'),
(3, 'COLLEGE OF COMPUTING STUDIES'),
(4, 'COLLEGE OF LIBERAL ARTS'),
(5, 'COLLEGE OF ARCHITECTURE'),
(6, 'COLLEGE OF NURSING'),
(7, 'COLLEGE OF ASIAN AND ISLAMIC STUDIES'),
(8, 'COLLEGE OF FORESTRY & ENVIRONMENTAL STUDIES'),
(9, 'COLLEGE OF CRIMINAL JUSTICE EDUCATION'),
(10, 'COLLEGE OF HOME ECONOMICS'),
(11, 'COLLEGE OF ENGINEERING'),
(12, 'COLLEGE OF MEDICINE'),
(13, 'COLLEGE OF PUBLIC ADMINISTRATION & DEVELOPMENT STUDIES'),
(14, 'COLLEGE OF SPORTS SCIENCE & PHYSICAL EDUCATION'),
(15, 'COLLEGE OF SCIENCE AND MATHEMATICS'),
(16, 'COLLEGE OF SOCIAL WORK & COMMUNITY DEVELOPMENT'),
(17, 'COLLEGE OF TEACHER EDUCATION');

-- --------------------------------------------------------

--
-- Table structure for table `groupmembers`
--

CREATE TABLE `groupmembers` (
  `studentID` int(11) NOT NULL,
  `groupID` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 2,
  `role` int(11) NOT NULL DEFAULT 3,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `middleName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffaccounts`
--

CREATE TABLE `staffaccounts` (
  `staffAdminID` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `statusID` int(11) NOT NULL,
  `statusName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`statusID`, `statusName`) VALUES
(1, 'Pending'),
(2, 'Approved'),
(3, 'Rejected'),
(4, 'Edit'),
(5, 'Delete');

-- --------------------------------------------------------

--
-- Table structure for table `thesis`
--

CREATE TABLE `thesis` (
  `thesisID` int(11) NOT NULL,
  `addedBy` int(11) NOT NULL,
  `advisorName` varchar(255) NOT NULL,
  `thesisTitle` varchar(255) NOT NULL,
  `status` int(11) DEFAULT 1,
  `dateAdded` datetime NOT NULL DEFAULT current_timestamp(),
  `datePublished` date NOT NULL,
  `abstract` varchar(255) DEFAULT NULL,
  `groupID` int(11) NOT NULL,
  `notes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thesisactionreq`
--

CREATE TABLE `thesisactionreq` (
  `thesisActionReqID` int(11) NOT NULL,
  `groupID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `thesisID` int(11) NOT NULL,
  `dateRequested` datetime NOT NULL DEFAULT current_timestamp(),
  `action` enum('Edit','Delete') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thesiseditreq`
--

CREATE TABLE `thesiseditreq` (
  `thesisID` int(11) NOT NULL,
  `thesisTitle` varchar(255) NOT NULL,
  `advisorName` varchar(255) NOT NULL,
  `abstract` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `dateAdded` datetime NOT NULL DEFAULT current_timestamp(),
  `datePublished` date NOT NULL,
  `groupID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thesislogs`
--

CREATE TABLE `thesislogs` (
  `approvalID` int(11) NOT NULL,
  `staffID` int(11) DEFAULT NULL,
  `groupID` int(11) NOT NULL,
  `thesisID` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `actionDate` datetime NOT NULL DEFAULT current_timestamp(),
  `action` enum('Edit','Delete') DEFAULT NULL,
  `studentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thesis_approval`
--

CREATE TABLE `thesis_approval` (
  `approvalID` int(11) NOT NULL,
  `groupID` int(11) NOT NULL,
  `staffID` int(11) NOT NULL,
  `thesisID` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `actionDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountroles`
--
ALTER TABLE `accountroles`
  ADD PRIMARY KEY (`roleID`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_role_accRoles` (`role`),
  ADD KEY `fk_dept` (`department`),
  ADD KEY `fk_course` (`course`),
  ADD KEY `fk_status` (`status`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`authorID`,`studentID`,`departmentID`,`coursesID`) USING BTREE,
  ADD KEY `fk_author_studentID` (`studentID`),
  ADD KEY `fk_author_departmentID` (`departmentID`),
  ADD KEY `fk_author_coursesID` (`coursesID`),
  ADD KEY `fk_author_groupID` (`groupID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courseID`),
  ADD UNIQUE KEY `courseName` (`courseName`),
  ADD KEY `fk_coursed_deptID` (`departmentID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentID`);

--
-- Indexes for table `groupmembers`
--
ALTER TABLE `groupmembers`
  ADD PRIMARY KEY (`studentID`,`groupID`),
  ADD KEY `fk_groupmembers_group` (`groupID`),
  ADD KEY `fk_groupmembers_role` (`role`),
  ADD KEY `fk_groupmembers_status` (`status`);

--
-- Indexes for table `staffaccounts`
--
ALTER TABLE `staffaccounts`
  ADD PRIMARY KEY (`staffAdminID`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`statusID`) USING BTREE;

--
-- Indexes for table `thesis`
--
ALTER TABLE `thesis`
  ADD PRIMARY KEY (`thesisID`),
  ADD KEY `fk_thesis_groupID` (`groupID`),
  ADD KEY `fk_thesis_status` (`status`),
  ADD KEY `fk_thesis_authorID` (`addedBy`);

--
-- Indexes for table `thesisactionreq`
--
ALTER TABLE `thesisactionreq`
  ADD PRIMARY KEY (`thesisActionReqID`,`groupID`,`thesisID`) USING BTREE,
  ADD KEY `fk_thesisactionreq_thesisID` (`thesisID`),
  ADD KEY `fk_thesisactionreq_groupID` (`groupID`),
  ADD KEY `fk_thesisactionreq_studentID` (`studentID`);

--
-- Indexes for table `thesiseditreq`
--
ALTER TABLE `thesiseditreq`
  ADD PRIMARY KEY (`thesisID`),
  ADD KEY `fk_thesis_groupID` (`groupID`),
  ADD KEY `fk_thesisditreq_status` (`status`),
  ADD KEY `fk_thesiseditreq_studentID` (`studentID`);

--
-- Indexes for table `thesislogs`
--
ALTER TABLE `thesislogs`
  ADD PRIMARY KEY (`approvalID`,`thesisID`,`groupID`) USING BTREE,
  ADD KEY `fk_approval_thesisID` (`thesisID`),
  ADD KEY `fk_approval_staffID` (`staffID`),
  ADD KEY `fk_approval_groupID` (`groupID`) USING BTREE,
  ADD KEY `fk_log_status` (`status`),
  ADD KEY `fk_log_studentID` (`studentID`);

--
-- Indexes for table `thesis_approval`
--
ALTER TABLE `thesis_approval`
  ADD PRIMARY KEY (`approvalID`,`groupID`,`staffID`) USING BTREE,
  ADD KEY `fk_approvalTH_groupID` (`groupID`),
  ADD KEY `fk_approvalTH_staffID` (`staffID`),
  ADD KEY `fk_approvalTH_thesisID` (`thesisID`),
  ADD KEY `fl_approvalTH_status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountroles`
--
ALTER TABLE `accountroles`
  MODIFY `roleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `authorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `staffaccounts`
--
ALTER TABLE `staffaccounts`
  MODIFY `staffAdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `thesis`
--
ALTER TABLE `thesis`
  MODIFY `thesisID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `thesisactionreq`
--
ALTER TABLE `thesisactionreq`
  MODIFY `thesisActionReqID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `thesiseditreq`
--
ALTER TABLE `thesiseditreq`
  MODIFY `thesisID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `thesislogs`
--
ALTER TABLE `thesislogs`
  MODIFY `approvalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `thesis_approval`
--
ALTER TABLE `thesis_approval`
  MODIFY `approvalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `fk_course` FOREIGN KEY (`course`) REFERENCES `courses` (`courseID`),
  ADD CONSTRAINT `fk_dept` FOREIGN KEY (`department`) REFERENCES `department` (`departmentID`),
  ADD CONSTRAINT `fk_role_accRoles` FOREIGN KEY (`role`) REFERENCES `accountroles` (`roleID`),
  ADD CONSTRAINT `fk_status` FOREIGN KEY (`status`) REFERENCES `status` (`statusID`);

--
-- Constraints for table `author`
--
ALTER TABLE `author`
  ADD CONSTRAINT `fk_author_coursesID` FOREIGN KEY (`coursesID`) REFERENCES `courses` (`courseID`),
  ADD CONSTRAINT `fk_author_departmentID` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`),
  ADD CONSTRAINT `fk_author_groupID` FOREIGN KEY (`groupID`) REFERENCES `accounts` (`ID`),
  ADD CONSTRAINT `fk_author_studentID` FOREIGN KEY (`studentID`) REFERENCES `groupmembers` (`studentID`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_coursed_deptID` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`);

--
-- Constraints for table `groupmembers`
--
ALTER TABLE `groupmembers`
  ADD CONSTRAINT `fk_groupmembers_role` FOREIGN KEY (`role`) REFERENCES `accountroles` (`roleID`),
  ADD CONSTRAINT `fk_groupmembers_status` FOREIGN KEY (`status`) REFERENCES `status` (`statusID`);

--
-- Constraints for table `thesis`
--
ALTER TABLE `thesis`
  ADD CONSTRAINT `fk_thesis_authorID` FOREIGN KEY (`addedBy`) REFERENCES `groupmembers` (`studentID`),
  ADD CONSTRAINT `fk_thesis_groupID` FOREIGN KEY (`groupID`) REFERENCES `accounts` (`ID`),
  ADD CONSTRAINT `fk_thesis_status` FOREIGN KEY (`status`) REFERENCES `status` (`statusID`);

--
-- Constraints for table `thesisactionreq`
--
ALTER TABLE `thesisactionreq`
  ADD CONSTRAINT `fk_thesisactionreq_groupID` FOREIGN KEY (`groupID`) REFERENCES `accounts` (`ID`),
  ADD CONSTRAINT `fk_thesisactionreq_studentID` FOREIGN KEY (`studentID`) REFERENCES `groupmembers` (`studentID`),
  ADD CONSTRAINT `fk_thesisactionreq_thesisID` FOREIGN KEY (`thesisID`) REFERENCES `thesis` (`thesisID`);

--
-- Constraints for table `thesiseditreq`
--
ALTER TABLE `thesiseditreq`
  ADD CONSTRAINT `fk_thesisditreq_status` FOREIGN KEY (`status`) REFERENCES `status` (`statusID`),
  ADD CONSTRAINT `fk_thesiseditreq_studentID` FOREIGN KEY (`studentID`) REFERENCES `groupmembers` (`studentID`);

--
-- Constraints for table `thesislogs`
--
ALTER TABLE `thesislogs`
  ADD CONSTRAINT `fk_approval_groupID` FOREIGN KEY (`groupID`) REFERENCES `accounts` (`ID`),
  ADD CONSTRAINT `fk_approval_staffID` FOREIGN KEY (`staffID`) REFERENCES `accounts` (`ID`),
  ADD CONSTRAINT `fk_approval_thesisID` FOREIGN KEY (`thesisID`) REFERENCES `thesis` (`thesisID`),
  ADD CONSTRAINT `fk_log_status` FOREIGN KEY (`status`) REFERENCES `status` (`statusID`),
  ADD CONSTRAINT `fk_log_studentID` FOREIGN KEY (`studentID`) REFERENCES `groupmembers` (`studentID`);

--
-- Constraints for table `thesis_approval`
--
ALTER TABLE `thesis_approval`
  ADD CONSTRAINT `fk_approvalTH_groupID` FOREIGN KEY (`groupID`) REFERENCES `accounts` (`ID`),
  ADD CONSTRAINT `fk_approvalTH_staffID` FOREIGN KEY (`staffID`) REFERENCES `accounts` (`ID`),
  ADD CONSTRAINT `fl_approvalTH_status` FOREIGN KEY (`status`) REFERENCES `status` (`statusID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
