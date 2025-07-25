-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql112.byetcluster.com
-- Generation Time: Jul 25, 2025 at 03:40 AM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_39179476_marinaHeights`
--

-- --------------------------------------------------------

--
-- Table structure for table `facility_bookings`
--

CREATE TABLE `facility_bookings` (
  `id` int(11) NOT NULL,
  `resident_id` int(11) DEFAULT NULL,
  `facility_name` varchar(100) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` time DEFAULT NULL,
  `paid` tinyint(1) DEFAULT 0,
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `facility_bookings`
--

INSERT INTO `facility_bookings` (`id`, `resident_id`, `facility_name`, `booking_date`, `booking_time`, `paid`, `payment_method`, `created_at`) VALUES
(1, 1, 'multi_purpose_hall', '2025-07-24', '12:00:00', 0, 'credit_card', '2025-07-23 13:52:47'),
(2, 1, 'basketball_court', '2025-07-25', '12:00:00', 0, 'credit_card', '2025-07-23 13:59:43'),
(3, 1, 'game_room', '2025-07-26', '12:00:00', 0, 'credit_card', '2025-07-23 14:02:55'),
(4, 1, 'game_room', '2025-07-26', '12:00:00', 0, 'credit_card', '2025-07-23 14:07:40'),
(5, 1, 'multi_purpose_hall', '2025-07-25', '12:00:00', 0, 'e_wallet', '2025-07-24 04:50:37'),
(6, 1, 'basketball_court', '2025-07-26', '12:00:00', 0, 'credit_card', '2025-07-25 05:51:53');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_fees`
--

CREATE TABLE `maintenance_fees` (
  `id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `month` year(4) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT 150.00,
  `status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `payment_method` varchar(50) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `maintenance_fees`
--

INSERT INTO `maintenance_fees` (`id`, `resident_id`, `month`, `year`, `amount`, `status`, `payment_method`, `paid_at`, `due_date`) VALUES
(1, 1, 2007, 2025, '150.00', 'Unpaid', 'credit_card', NULL, '2025-07-10'),
(2, 2, 2007, 2025, '150.00', 'Unpaid', NULL, NULL, '2025-07-10');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `posted_at` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `unit_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `approved` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `first_name`, `last_name`, `unit_number`, `email`, `password`, `approved`, `created_at`) VALUES
(1, 'John', 'Doe', 'A-101', 'johndoe@example.com', 'test123', 1, '2025-07-22 08:04:58'),
(2, 'w', 'a', 'aaaaa', 'john@e.com', '$2y$10$oBuvq6AOVctxcyq65/0qyeDxeDLt9CRQCYYClRuNFdGE4SIQNmboG', 1, '2025-07-24 06:47:59'),
(5, 'a', 'a', 'aa', 're@admin.com', '$2y$10$EeG8c71HbdMsxSkt7AuTruSkiSYIaIee7jCMlY8HeNUhSXrf4ysbe', 1, '2025-07-24 18:22:47'),
(4, 'aa', 'aaaa', 'A-12-05', 'jinghangme@gmail.com', '$2y$10$DnpWQU0F1liLOA03A34XpeqK3aF9kkS.tdToPQRTN49MlcnvG82UO', 1, '2025-07-24 17:36:14');

-- --------------------------------------------------------

--
-- Table structure for table `resident_reports`
--

CREATE TABLE `resident_reports` (
  `id` int(11) NOT NULL,
  `reporter` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Pending','Resolving','Completed') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `resident_reports`
--

INSERT INTO `resident_reports` (`id`, `reporter`, `title`, `description`, `status`, `created_at`) VALUES
(1, '1', 'Electrical', 'aaa', 'Pending', '2025-07-24 13:43:42'),
(2, '1', 'Plumbing', 'ffdfsef', 'Pending', '2025-07-25 01:19:54'),
(3, '1', 'Plumbing', 'ffdfsef', 'Pending', '2025-07-25 01:19:55'),
(4, '1', 'Plumbing', 'xdse', 'Pending', '2025-07-25 01:20:09'),
(6, '1', 'qwe', 'kjhgfdsdfgh', 'Resolving', '2025-07-25 05:37:09'),
(7, '1', 'Plumbing', 'yuy', 'Resolving', '2025-07-25 05:39:14'),
(8, '1', 'Plumbing', 'afeagfwg', 'Pending', '2025-07-25 06:43:20'),
(9, '1', 'Plumbing', 'QDQGVEDH', 'Pending', '2025-07-25 06:43:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_votes`
--

CREATE TABLE `user_votes` (
  `user_id` varchar(255) NOT NULL,
  `vote_id` varchar(255) NOT NULL,
  `option_id` varchar(255) DEFAULT NULL,
  `voted_at` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `visitor_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `visit_date` date NOT NULL,
  `num_visitors` int(11) NOT NULL,
  `purpose` text NOT NULL,
  `status` enum('Pending','Approved','Rejected','Used') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `visitor_name`, `email`, `unit`, `visit_date`, `num_visitors`, `purpose`, `status`, `created_at`) VALUES
(3, 'Tim Lee', 'm-10321859@moe-dl.edu.my', 'A-01-01', '2025-07-31', 2, 'Visiting', 'Used', '2025-07-23 12:40:53'),
(4, 'Tim Lee', 'm-10321859@moe-dl.edu.my', 'A-01-01', '2025-07-31', 2, 'Visiting', 'Approved', '2025-07-23 12:42:41'),
(7, 'Tim Lee', 'm-10321859@moe-dl.edu.my', 'A-01-01', '2025-07-30', 2, 'ooo', 'Approved', '2025-07-24 13:05:37'),
(6, 'John', 'a@gmail.com', 'B-01-01', '2025-07-26', 2, 'aaa', 'Rejected', '2025-07-23 12:52:52'),
(9, 'Ambert', 'hyper@coderthemes.com', 'aaa', '2025-07-30', 2, 'aaaaa', 'Rejected', '2025-07-25 02:06:19');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `deadline` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vote_options`
--

CREATE TABLE `vote_options` (
  `id` varchar(255) NOT NULL,
  `vote_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `votes` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `facility_bookings`
--
ALTER TABLE `facility_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `maintenance_fees`
--
ALTER TABLE `maintenance_fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `resident_reports`
--
ALTER TABLE `resident_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_votes`
--
ALTER TABLE `user_votes`
  ADD PRIMARY KEY (`user_id`,`vote_id`),
  ADD KEY `option_id` (`option_id`),
  ADD KEY `idx_user_votes_user_id` (`user_id`),
  ADD KEY `idx_user_votes_vote_id` (`vote_id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_votes_deadline` (`deadline`);

--
-- Indexes for table `vote_options`
--
ALTER TABLE `vote_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vote_options_vote_id` (`vote_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `facility_bookings`
--
ALTER TABLE `facility_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `maintenance_fees`
--
ALTER TABLE `maintenance_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `resident_reports`
--
ALTER TABLE `resident_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
