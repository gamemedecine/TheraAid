-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 06:53 PM
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
-- Database: `theraaid`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment`
--

CREATE TABLE `tbl_appointment` (
  `appointment_id` int(11) NOT NULL,
  `num_of_session` int(11) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `is_aggreed` tinyint(1) NOT NULL,
  `date_accepted` date NOT NULL,
  `therapists_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `rate` float NOT NULL,
  `Date_creadted` timestamp NOT NULL DEFAULT current_timestamp(),
  `schedle_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_appointment`
--

INSERT INTO `tbl_appointment` (`appointment_id`, `num_of_session`, `payment_type`, `start_date`, `is_aggreed`, `date_accepted`, `therapists_id`, `patient_id`, `status`, `rate`, `Date_creadted`, `schedle_id`) VALUES
(24, 5, 'PS', '2024-10-09', 1, '0000-00-00', 7, 10, 'On-Going', 1000, '2024-10-03 16:00:00', 90),
(25, 8, 'PS', '2024-10-16', 1, '0000-00-00', 7, 13, 'On-Going', 1000, '2024-10-10 14:51:33', 170);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`notification_id`, `user_id`, `appointment_id`, `type`, `is_read`, `created_at`) VALUES
(1, 30, 14, 'Request Appointment', NULL, '2024-10-02 22:40:42'),
(10, 34, 18, 'Therapists Have Responded to your request', NULL, '2024-10-03 20:42:14'),
(11, 33, 23, 'Request Appointment', NULL, '2024-10-04 10:53:34'),
(12, 30, 24, 'Request Appointment', NULL, '2024-10-04 10:59:45'),
(13, 34, 24, 'Therapists Have Responded to your request', NULL, '2024-10-04 19:47:26'),
(14, 34, 24, 'Therapists Have Responded to your request', NULL, '2024-10-04 20:07:46'),
(15, 34, 24, 'Therapists Have Responded to your request', NULL, '2024-10-04 21:18:34'),
(16, 34, 24, 'Therapists Have Responded to your request', NULL, '2024-10-06 19:21:26'),
(17, 30, 25, 'Request Appointment', NULL, '2024-10-10 22:51:33'),
(18, 34, 25, 'Therapists Have Responded to your request', NULL, '2024-10-10 22:53:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient`
--

CREATE TABLE `tbl_patient` (
  `patient_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `P_case` varchar(50) NOT NULL,
  `case_desc` varchar(200) NOT NULL,
  `City` varchar(100) NOT NULL,
  `street` varchar(200) NOT NULL,
  `assement_photo` varchar(500) NOT NULL,
  `mid_hisotry_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_patient`
--

INSERT INTO `tbl_patient` (`patient_id`, `user_id`, `P_case`, `case_desc`, `City`, `street`, `assement_photo`, `mid_hisotry_photo`) VALUES
(7, 23, 'asdas', 'qweqwewq', 'lapu lapu', 'top 1 julies streer', '66e026b5d1eee1.00409695.png', '66e026b5d1ed92.54785540.png'),
(9, 25, 'dislocated knee', 'numbness', 'mandaue', 'purok 1', '66e0f060ac5d81.62408335.png', '66e0f060ac5c50.60406651.png'),
(10, 34, 'back pain', 'asdasdasdsa', 'mandaue', 'purok1', '66f3d166528e47.58260178.jpg', '66f3d166528c87.34273945.png'),
(11, 37, 'backpaim', 'numbness', 'lapu lapu', 'purok1', '66fbd9e0e28424.81401484.png', '66fbd9e0e28319.96332170.png'),
(12, 38, 'spine injury', 'numbness', 'asdasdas', 'asdasasdas', '66fc02e4ad3ac1.35170976.png', '66fc02e4ad3817.95557303.png'),
(13, 40, 'back  pain', 'numbness', 'mandaue', 'purok 1', '6707e4e1233268.29010755.jpg', '6707e4e1233142.17812919.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `payment_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date_paid` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`payment_id`, `appointment_id`, `amount`, `status`, `date_paid`) VALUES
(11, 24, 1000, 'Paid', '2024-10-08 08:57:41'),
(12, 24, 1000, 'Paid', '2024-10-08 08:59:07'),
(13, 24, 1000, 'Paid', '2024-10-08 09:01:29'),
(14, 24, 2000, 'Paid', '2024-10-08 09:01:57'),
(15, 24, 1000, 'Paid', '2024-10-08 09:02:18'),
(16, 24, 1000, 'Paid', '2024-10-08 09:08:23'),
(17, 24, 1000, 'Paid', '2024-10-08 09:10:09'),
(18, 24, 1000, 'Paid', '2024-10-08 09:10:12'),
(19, 24, 1000, 'Paid', '2024-10-08 10:04:14'),
(20, 24, 1000, 'Paid', '2024-10-08 15:22:14'),
(21, 24, 200, 'Paid', '2024-10-08 19:54:05'),
(22, 24, 3000, 'Paid', '2024-10-08 19:54:14'),
(23, 24, 1000, 'Paid', '2024-10-09 13:52:55'),
(24, 24, 1000, 'Paid', '2024-10-09 13:53:33'),
(25, 24, 1000, 'Paid', '2024-10-09 14:03:17'),
(26, 24, 1000, 'Paid', '2024-10-09 14:03:52'),
(27, 24, 1000, 'Paid', '2024-10-09 14:04:23'),
(28, 24, 1000, 'Paid', '2024-10-09 14:06:28'),
(29, 24, 1000, 'Paid', '2024-10-09 14:06:42'),
(30, 24, 1000, 'Paid', '2024-10-09 14:07:09'),
(31, 24, 1000, 'Paid', '2024-10-09 14:07:12'),
(32, 24, 1000, 'Paid', '2024-10-09 14:08:19'),
(33, 25, 1000, 'Paid', '2024-10-10 22:57:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reminder`
--

CREATE TABLE `tbl_reminder` (
  `reminder_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `reminder_date` varchar(200) NOT NULL,
  `reminder_messsage` varchar(250) NOT NULL,
  `reminder_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reminder`
--

INSERT INTO `tbl_reminder` (`reminder_id`, `appointment_id`, `reminder_date`, `reminder_messsage`, `reminder_status`) VALUES
(1, 24, '2024-10-09,2024-10-11,2024-10-14,2024-10-16,2024-10-18', 'You Have An appointment Today', 'unread'),
(2, 25, '2024-10-16,2024-10-21,2024-10-23,2024-10-28,2024-10-30,2024-11-04,2024-11-06,2024-11-11', 'You Have An appointment Today', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sched`
--

CREATE TABLE `tbl_sched` (
  `shed_id` int(11) NOT NULL,
  `therapists_id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `note` varchar(150) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sched`
--

INSERT INTO `tbl_sched` (`shed_id`, `therapists_id`, `day`, `start_time`, `end_time`, `note`, `status`, `date_created`) VALUES
(80, 3, 'Tue', '07:00:00', '08:00:00', 'asdasd', 'Done', '2024-09-15'),
(87, 3, 'Wed,Thu', '10:00:00', '11:00:00', 'asdsa', 'Available', '2024-09-17'),
(88, 3, 'Tue', '10:00:00', '11:00:00', 'asdsa', 'Available', '2024-09-17'),
(89, 3, 'Wed,Thu', '10:00:00', '11:00:00', '125123', 'Available', '2024-09-17'),
(90, 7, 'Mon,Wed,Fri', '07:00:00', '08:00:00', 'asdasdsa', 'On-Going', '2024-09-18'),
(91, 7, 'Tue,Wed', '08:00:00', '10:00:00', 'asdas', 'Available', '2024-09-18'),
(92, 7, 'Tue,Thu', '12:00:00', '14:00:00', 'hapon', 'Available', '2024-09-18'),
(157, 5, 'Sat', '07:00:00', '10:00:00', 'asdasd', 'Available', '2024-09-24'),
(161, 5, 'Sat', '11:00:00', '14:00:00', 'asdasdas', 'Available', '2024-09-24'),
(164, 10, 'Sat', '07:00:00', '08:00:00', 'qweqwe', 'Available', '2024-09-25'),
(165, 10, 'Fri', '09:00:00', '11:00:00', 'fourth patient of the day ', 'Available', '2024-09-25'),
(166, 10, 'Tue,Thu,Sat', '11:00:00', '12:00:00', 'second patient of the day', 'Available', '2024-09-25'),
(168, 13, 'Thu', '08:00:00', '09:00:00', 'asdasd', 'Available', '2024-10-03'),
(169, 3, 'Tue', '07:00:00', '09:00:00', 'asdasdas', 'Available', '2024-10-08'),
(170, 7, 'Mon,Wed', '07:00:00', '09:00:00', 'sdasdasd', 'On-Going', '2024-10-08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_therapists`
--

CREATE TABLE `tbl_therapists` (
  `therapist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `case_handled` varchar(200) NOT NULL,
  `city` varchar(100) NOT NULL,
  `Radius` varchar(200) NOT NULL,
  `license_img` varchar(100) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_therapists`
--

INSERT INTO `tbl_therapists` (`therapist_id`, `user_id`, `case_handled`, `city`, `Radius`, `license_img`, `date_created`) VALUES
(3, 24, 'broken arm', 'mandaue', ' 500', '66e0290cea75c5.96685475.png', '2024-09-10'),
(4, 26, '', '', ' ', '66e11fdcd00c26.06533774.png', '2024-09-11'),
(5, 28, 'spine injury,stroke', 'mandaue', ' 600', '66e1913c7d3744.62839285.jpg', '2024-09-11'),
(6, 29, 'kneee,ejjry', 'mandaue', ' 200', '66e9703370ae59.50936008.png', '2024-09-17'),
(7, 30, 'back pain,post surgury,sport inujury', 'mandaue', ' 500', '66ea4dc5493205.23800666.jpg', '2024-09-18'),
(8, 31, 'back pain', 'mandaue', ' 200', '66eadabfecab90.45350236.jpg', '2024-09-18'),
(9, 32, 'post surgury', 'mandaue', ' 100', '66ebcf4e50ddc9.73838259.jpg', '2024-09-19'),
(10, 33, 'broken arm', 'mandaue', ' 500', '66f37320d5a6e6.72484005.jpg', '2024-09-25'),
(11, 35, 'back pain,', 'mandaue', ' 600', '66f4f8145e33d8.74793816.png', '2024-09-26'),
(12, 36, 'broken arm', 'mandaue', ' 600', '66fbd78c346d97.12243825.jpg', '2024-10-01'),
(13, 39, 'back pain', 'mandaue', ' 600', '66fd79fcaa43c4.45276027.png', '2024-10-03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `User_id` int(11) NOT NULL,
  `Fname` varchar(50) NOT NULL,
  `Lname` varchar(50) NOT NULL,
  `Mname` varchar(30) NOT NULL,
  `Bday` date NOT NULL,
  `UserName` varchar(30) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `ContactNum` varchar(11) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `user_type` char(1) NOT NULL,
  `profilePic` varchar(100) NOT NULL,
  `E_wallet` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`User_id`, `Fname`, `Lname`, `Mname`, `Bday`, `UserName`, `Password`, `ContactNum`, `Email`, `user_type`, `profilePic`, `E_wallet`) VALUES
(23, 'mark', 'doe', 'man', '2007-02-07', 'pol', '4dedc734a083dfce9c873395c234e9b1', '12312421321', 'mark@test.com', 'P', '', 0),
(24, 'earth', 'shaker', 'totem', '2008-03-20', 'shaker', '4dedc734a083dfce9c873395c234e9b1', '24233123125', 'shaker@test.com', 'T', '', 0),
(25, 'storm', 'spirit', 'panda', '2009-08-28', 'storm', '4dedc734a083dfce9c873395c234e9b1', '12312521213', 'storm@test.com', 'P', '', 0),
(26, 'rash', 'guard', 'illuminate', '2001-06-07', 'guard', '4dedc734a083dfce9c873395c234e9b1', '38712509123', 'guard@test.com', 'T', '', 0),
(27, 'sky', 'light', 'nature', '2000-02-18', 'sky', '4dedc734a083dfce9c873395c234e9b1', '12312512312', 'sky@test.com', 'T', '', 0),
(28, 'bane', 'mask', 'break', '2000-06-03', 'bane', '4dedc734a083dfce9c873395c234e9b1', '12312421421', 'bane@test.com', 'T', '66e1900d721677.32361119.jpg', 0),
(29, 'ikaw', 'ako', 'siya', '2001-03-09', 'siya', '4dedc734a083dfce9c873395c234e9b1', '12341234123', 'siya@test.com', 'T', '66e96fc78a59a9.91816993.jpg', 0),
(30, 'cee', 'Lo', 'Balt', '2002-06-26', 'cee', '4dedc734a083dfce9c873395c234e9b1', '13124123124', 'cee-lo@test.com', 'T', '66ea4d99ab7156.41903384.jpg', 20200),
(31, 'baril', 'gun', 'bala', '2012-02-02', 'bala', '4dedc734a083dfce9c873395c234e9b1', '12321312312', 'bala@test.com', 'T', '66eada41c81936.09615725.jpg', 0),
(32, 'THERAAID', 'RONALD', 'RON', '2007-02-07', 'ron', '4dedc734a083dfce9c873395c234e9b1', '12312312412', 'RON@TEST.COM', 'T', '66ebcedce83928.14748114.jpg', 0),
(33, 'basta', 'kana', 'kani', '1999-06-11', 'basta', '4dedc734a083dfce9c873395c234e9b1', '31263716813', 'basta@test.com', 'T', '66f373006c25d6.76125622.jpg', 0),
(34, 'patient1', 'patient', 'pat', '2005-05-12', 'pat', '4dedc734a083dfce9c873395c234e9b1', '23123123123', 'pat@test.com', 'P', '66f3d14a5c11c4.88662640.jpg', 2000),
(35, 'sanje', 'straw', 'hat', '1990-02-08', 'sanje', '4dedc734a083dfce9c873395c234e9b1', '17351267362', 'sanje@test.com', 'T', '66f4f7ffb1bc84.59687980.jpg', 0),
(36, 'john', 'paul', 'mike', '2002-07-12', 'mike', '4dedc734a083dfce9c873395c234e9b1', '12312412313', 'mike@test.com', 'T', '66fbd37aa69b31.80425191.jpg', 0),
(37, 'patotoya', 'toy', 'patoto', '2007-03-08', 'toy', '4dedc734a083dfce9c873395c234e9b1', '12312312312', 'test@test.com', 'P', '66fbd945bf6392.88829915.jpg', 0),
(38, 'batak', 'tak', 'ba', '2002-06-11', 'tak', '4dedc734a083dfce9c873395c234e9b1', '12312412312', 'tak@test.com', 'P', '66fc02ad202917.63308732.png', 0),
(39, 'saki', 'kasi', 'wiki', '2005-02-09', 'waki', '4dedc734a083dfce9c873395c234e9b1', '12321512312', 'waki@test.com', 'T', '66fd79ea45b835.66099556.png', 0),
(40, 'milk', 'cali', 'cat', '2004-06-19', 'cat', '4dedc734a083dfce9c873395c234e9b1', '12312512321', 'cat@test.com', 'P', '6707e4b220b730.75157912.jpg', 7000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `therapists_id` (`therapists_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `schedle_id` (`schedle_id`);

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tbl_reminder`
--
ALTER TABLE `tbl_reminder`
  ADD PRIMARY KEY (`reminder_id`);

--
-- Indexes for table `tbl_sched`
--
ALTER TABLE `tbl_sched`
  ADD PRIMARY KEY (`shed_id`),
  ADD KEY `therapists_id` (`therapists_id`);

--
-- Indexes for table `tbl_therapists`
--
ALTER TABLE `tbl_therapists`
  ADD PRIMARY KEY (`therapist_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`User_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_reminder`
--
ALTER TABLE `tbl_reminder`
  MODIFY `reminder_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_sched`
--
ALTER TABLE `tbl_sched`
  MODIFY `shed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `tbl_therapists`
--
ALTER TABLE `tbl_therapists`
  MODIFY `therapist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  ADD CONSTRAINT `tbl_appointment_ibfk_1` FOREIGN KEY (`therapists_id`) REFERENCES `tbl_therapists` (`therapist_id`),
  ADD CONSTRAINT `tbl_appointment_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `tbl_patient` (`patient_id`),
  ADD CONSTRAINT `tbl_appointment_ibfk_3` FOREIGN KEY (`schedle_id`) REFERENCES `tbl_sched` (`shed_id`);

--
-- Constraints for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD CONSTRAINT `tbl_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`User_id`);

--
-- Constraints for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  ADD CONSTRAINT `tbl_patient_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`User_id`);

--
-- Constraints for table `tbl_sched`
--
ALTER TABLE `tbl_sched`
  ADD CONSTRAINT `tbl_sched_ibfk_1` FOREIGN KEY (`therapists_id`) REFERENCES `tbl_therapists` (`therapist_id`);

--
-- Constraints for table `tbl_therapists`
--
ALTER TABLE `tbl_therapists`
  ADD CONSTRAINT `tbl_therapists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`User_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
