-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2026 at 04:23 AM
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
-- Database: `student_club_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `proposal_id` int(11) DEFAULT NULL,
  `event_name` varchar(150) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `location` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `status` enum('Upcoming','Completed','Cancelled') DEFAULT 'Upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `proposal_id`, `event_name`, `event_date`, `event_time`, `location`, `description`, `budget`, `status`, `created_at`) VALUES
(2, 3, 'Blood Donation Campaign', '2026-06-25', '10:00:00', 'Student Centre', 'A collaboration with the National Blood Centre to collect blood donations from students and staff.', 300.00, 'Upcoming', '2026-06-20 10:17:17'),
(3, 2, 'Sports Day 2026', '2026-06-23', '08:00:00', 'Main Stadium', 'A sports event involving football, netball, badminton, and various recreational activities.', 1200.00, 'Upcoming', '2026-06-20 14:31:15'),
(4, 1, 'Tech Talk: AI & Future', '2026-07-15', '08:30:00', 'DKP Hall', 'This program will invite industry experts to share knowledge about AI trends, career opportunities, and future technologies.', 500.00, 'Upcoming', '2026-06-20 14:31:30');

-- --------------------------------------------------------

--
-- Table structure for table `program_proposals`
--

CREATE TABLE `program_proposals` (
  `proposal_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `program_name` varchar(150) NOT NULL,
  `club_name` varchar(100) NOT NULL,
  `objective` text NOT NULL,
  `description` text DEFAULT NULL,
  `proposal_date` date NOT NULL,
  `proposal_time` time NOT NULL,
  `location` varchar(150) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `admin_remark` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_proposals`
--

INSERT INTO `program_proposals` (`proposal_id`, `user_id`, `program_name`, `club_name`, `objective`, `description`, `proposal_date`, `proposal_time`, `location`, `budget`, `status`, `admin_remark`, `created_at`) VALUES
(1, 1, 'Tech Talk: AI & Future', 'IT Club', 'To increase awareness and knowledge about Artificial Intelligence among students.', 'This program will invite industry experts to share knowledge about AI trends, career opportunities, and future technologies.', '2026-07-15', '08:30:00', 'DKP Hall', 500.00, 'Approved', NULL, '2026-06-20 10:01:17'),
(2, 1, 'Sports Day 2026', 'Sports Club', 'To promote a healthy lifestyle and strengthen teamwork among students.', 'A sports event involving football, netball, badminton, and various recreational activities.', '2026-06-23', '08:00:00', 'Main Stadium', 1200.00, 'Approved', NULL, '2026-06-20 10:02:45'),
(3, 1, 'Blood Donation Campaign', 'Red Crescent Club', 'To encourage students to participate in blood donation activities.', 'A collaboration with the National Blood Centre to collect blood donations from students and staff.', '2026-06-25', '10:00:00', 'Student Centre', 300.00, 'Rejected', NULL, '2026-06-20 10:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `registration_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `matric_no` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `payment_status` enum('Pending','Paid') DEFAULT 'Pending',
  `register_date` datetime DEFAULT current_timestamp(),
  `attendance_status` enum('Registered','Attended','Absent') DEFAULT 'Registered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`registration_id`, `event_id`, `user_id`, `full_name`, `matric_no`, `email`, `phone`, `payment_status`, `register_date`, `attendance_status`) VALUES
(1, 2, 1, 'MUHAMMD SHAHRUL ABDULLAH', '2024655539', 'shah223@gmail.com', '011-32256831', 'Pending', '2026-06-20 18:20:14', 'Registered');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `matric_no` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('Admin','Club Leader','Student') NOT NULL,
  `faculty` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `matric_no`, `email`, `password`, `phone`, `role`, `faculty`, `created_at`) VALUES
(1, 'Admin User', 'ADMIN001', 'admin@gmail.com', '12345', '0111111111', 'Admin', 'Faculty of Information Management', '2026-06-20 09:34:15'),
(2, 'John Doe', 'A21EC1234', 'john@student.edu.my', '12345', '0112345678', 'Student', 'Information Management', '2026-06-20 10:21:36'),
(3, 'Nur Syazwani', 'A21EC1256', 'syazwani@student.edu.my', '12345', '0123456789', 'Student', 'Information Management', '2026-06-20 10:21:36'),
(4, 'Raihan Ahmad', 'CLUB001', 'raihan@student.edu.my', '12345', '0134567890', 'Club Leader', 'Information Management', '2026-06-20 10:21:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `proposal_id` (`proposal_id`);

--
-- Indexes for table `program_proposals`
--
ALTER TABLE `program_proposals`
  ADD PRIMARY KEY (`proposal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `matric_no` (`matric_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `program_proposals`
--
ALTER TABLE `program_proposals`
  MODIFY `proposal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`proposal_id`) REFERENCES `program_proposals` (`proposal_id`);

--
-- Constraints for table `program_proposals`
--
ALTER TABLE `program_proposals`
  ADD CONSTRAINT `program_proposals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
