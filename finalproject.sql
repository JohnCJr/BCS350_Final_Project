-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 29, 2023 at 02:41 AM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalproject`
-- Author: John Cabanas
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `assignmentid` int UNSIGNED NOT NULL,
  `assignmentname` varchar(100) NOT NULL,
  `classid` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`assignmentid`, `assignmentname`, `classid`) VALUES
(1, 'Week 1 HW', 1),
(2, 'Week 2 HW', 1),
(3, 'HW #1', 2),
(4, 'HW #2', 2),
(5, 'Assignment 1', 3),
(6, 'Assignment 2', 3),
(8, 'Assignment 3', 3),
(9, 'Assignment 4', 3),
(10, 'Assignment 5', 3),
(11, 'Assignment 6', 3);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `classid` int UNSIGNED NOT NULL,
  `classname` varchar(100) NOT NULL,
  `staffid` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`classid`, `classname`, `staffid`) VALUES
(1, 'Pre-Calculus', 2),
(2, 'Chemistry', 1),
(3, 'U.S History', 3);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffid` int UNSIGNED NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `id` char(13) NOT NULL,
  `email` varchar(80) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `role` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(80) NOT NULL,
  `photo` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffid`, `firstname`, `lastname`, `id`, `email`, `userid`, `role`, `password`, `photo`) VALUES
(1, 'Robert', 'Plant', 'R2000', 'RPLANT@WESTPINE.EDU', 'RPLANT', 'Teacher', 'RPLANT', NULL),
(2, 'Marcus', 'Bolan', 'R3000', 'ETUNNING@WESTPINE.EDU', 'ETUNNING', 'Teacher', 'ETUNNING', NULL),
(3, 'Patty', 'Smyth', 'R4000', 'PSMITH@WESTPINE.EDU', 'PSMITH', 'Teacher', 'PSMITH', 'profile pictures/faculty/3.jpg'),
(4, 'Harold', 'Parker', 'R1000', 'HPARKER@WESTPINE.EDU', 'HPARKER', 'Administrator', 'HPARKER', 'profile pictures/faculty/4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentid` int UNSIGNED NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `id` char(13) NOT NULL,
  `email` varchar(80) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL,
  `password` varchar(80) NOT NULL,
  `photo` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentid`, `firstname`, `lastname`, `id`, `email`, `userid`, `role`, `password`, `photo`) VALUES
(1, 'Jack', 'Smith', 'R0001', 'JSMITH@WESTPINE.EDU', 'JSMITH', 'Student', 'JSMITH', 'profile pictures/student/1.jpg'),
(2, 'Elroy', 'Tunning', 'R0002', 'ETUNNING@WESTPINE.EDU', 'ETUNNING', 'Student', 'ETUNNING', NULL),
(3, 'Nichol', 'Marks', 'R0003', 'NMARKS@WESTPINE.EDU', 'NMARKS', 'Student', 'NMARKS', NULL),
(4, 'Ellen', 'Cline', 'R0004', 'ECLINE@WESTPINE.EDU', 'ECLINE', 'Student', 'ECLINE', NULL),
(5, 'David', 'Ventura', 'R0005', 'DVENTURA@WESTPINE.EDU', 'DVENTURA', 'Student', 'DVENTURA', NULL),
(6, 'Maria', 'Flores', 'R0006', 'MFLORES@WESTPINE.EDU', 'MFLORES', 'Student', 'MFLORES', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `studentassignment`
--

CREATE TABLE `studentassignment` (
  `studentid` int UNSIGNED NOT NULL,
  `assignmentid` int UNSIGNED NOT NULL,
  `submitted` varchar(3) NOT NULL,
  `grade` int UNSIGNED DEFAULT NULL,
  `submission` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentassignment`
--

INSERT INTO `studentassignment` (`studentid`, `assignmentid`, `submitted`, `grade`, `submission`) VALUES
(1, 1, 'yes', 75, 'assignments/1-1.pdf'),
(1, 2, 'yes', 92, 'assignments/1-2.docx'),
(1, 3, 'yes', 75, 'assignments/1-3.pages'),
(1, 4, 'no', NULL, 'assignments/1-4.docx'),
(1, 5, 'no', NULL, NULL),
(1, 6, 'no', NULL, NULL),
(1, 8, 'no', NULL, NULL),
(1, 9, 'no', NULL, NULL),
(1, 10, 'no', NULL, NULL),
(1, 11, 'no', NULL, NULL),
(2, 1, 'yes', 78, NULL),
(2, 2, 'yes', 82, NULL),
(2, 3, 'yes', 75, NULL),
(2, 4, 'no', NULL, NULL),
(2, 5, 'no', NULL, NULL),
(2, 6, 'no', NULL, NULL),
(2, 8, 'no', NULL, NULL),
(2, 9, 'no', NULL, NULL),
(2, 10, 'no', NULL, NULL),
(2, 11, 'no', NULL, NULL),
(3, 1, 'yes', 85, NULL),
(3, 2, 'yes', 95, NULL),
(3, 3, 'yes', 75, NULL),
(3, 4, 'no', NULL, NULL),
(3, 5, 'no', NULL, NULL),
(3, 6, 'no', NULL, NULL),
(3, 8, 'no', NULL, NULL),
(3, 9, 'no', NULL, NULL),
(3, 10, 'no', NULL, NULL),
(3, 11, 'no', NULL, NULL),
(4, 1, 'yes', 96, NULL),
(4, 2, 'yes', 98, NULL),
(4, 3, 'yes', 75, NULL),
(4, 4, 'no', NULL, NULL),
(4, 5, 'yes', 95, NULL),
(4, 6, 'no', NULL, NULL),
(4, 8, 'no', NULL, NULL),
(4, 9, 'no', NULL, NULL),
(4, 10, 'no', NULL, NULL),
(4, 11, 'no', NULL, NULL),
(5, 1, 'yes', 85, NULL),
(5, 2, 'no', NULL, NULL),
(5, 3, 'yes', 75, NULL),
(5, 4, 'no', NULL, NULL),
(5, 5, 'yes', 90, NULL),
(5, 6, 'no', NULL, NULL),
(5, 8, 'no', NULL, NULL),
(5, 9, 'no', NULL, NULL),
(5, 10, 'no', NULL, NULL),
(5, 11, 'no', NULL, NULL),
(6, 1, 'yes', 83, NULL),
(6, 2, 'no', NULL, NULL),
(6, 3, 'yes', 75, NULL),
(6, 4, 'no', NULL, NULL),
(6, 5, 'no', NULL, NULL),
(6, 6, 'no', NULL, NULL),
(6, 8, 'no', NULL, NULL),
(6, 9, 'no', NULL, NULL),
(6, 10, 'no', NULL, NULL),
(6, 11, 'no', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`assignmentid`),
  ADD KEY `classid` (`classid`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`classid`),
  ADD KEY `staffid` (`staffid`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentid`);

--
-- Indexes for table `studentassignment`
--
ALTER TABLE `studentassignment`
  ADD PRIMARY KEY (`studentid`,`assignmentid`),
  ADD KEY `assignmentid` (`assignmentid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `assignmentid` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `classid` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffid` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentid` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`classid`) REFERENCES `class` (`classid`);

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`staffid`) REFERENCES `staff` (`staffid`);

--
-- Constraints for table `studentassignment`
--
ALTER TABLE `studentassignment`
  ADD CONSTRAINT `studentassignment_ibfk_1` FOREIGN KEY (`studentid`) REFERENCES `student` (`studentid`),
  ADD CONSTRAINT `studentassignment_ibfk_2` FOREIGN KEY (`assignmentid`) REFERENCES `assignment` (`assignmentid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
