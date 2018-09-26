-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 02, 2018 at 06:53 PM
-- Server version: 10.1.29-MariaDB-6
-- PHP Version: 7.0.29-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `guidance_monitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `modified_at`, `created_at`) VALUES
(1, 'BSIT', '2018-01-21 05:18:22', '2018-01-21 05:18:22'),
(2, 'BSBA', '2018-01-21 05:18:22', '2018-01-21 05:18:22'),
(3, 'ACS', '2018-01-22 03:11:16', '2018-01-22 03:11:16'),
(4, 'ACT', '2018-01-22 03:11:16', '2018-01-22 03:11:16'),
(5, 'BSTM', '2018-01-21 19:01:07', '2018-01-21 19:01:07'),
(6, 'ATM', '2018-01-21 20:01:36', '2018-01-21 20:01:36'),
(7, 'AOM', '2018-01-21 20:01:26', '2018-01-21 20:01:26'),
(9, 'AHRM', '2018-01-21 20:01:26', '2018-01-21 20:01:26'),
(10, 'BSTMT', '2018-01-21 20:01:47', '2018-01-21 20:01:47'),
(11, 'ACTC', '2018-01-21 20:01:09', '2018-01-21 20:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(6, '2016_06_01_000004_create_oauth_clients_table', 2),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'IOPEQucSOaPmATOTRBras31OxJ81LlLjvIfGISWl', 'http://localhost', 1, 0, 0, '2018-01-21 05:00:06', '2018-01-21 05:00:06'),
(2, NULL, 'Laravel Password Grant Client', 'Jp9MVor0w6eeFVimHNR3Fc7ROWzszyh12XVZCI2y', 'http://localhost', 0, 1, 0, '2018-01-21 05:00:06', '2018-01-21 05:00:06');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2018-01-21 05:00:06', '2018-01-21 05:00:06');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('ghostephemeral@gmail.com', '$2y$10$YRUHPSKldIMDJWZjuigXyOvMeECR4dKDPom8tSRh/vVOox6h.6LVy', '2018-03-24 09:50:18');

-- --------------------------------------------------------

--
-- Table structure for table `students_data`
--

CREATE TABLE `students_data` (
  `student_data_id` int(11) NOT NULL,
  `student_details_id` int(11) NOT NULL,
  `student_id_number` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `current_section` varchar(255) NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students_data`
--

INSERT INTO `students_data` (`student_data_id`, `student_details_id`, `student_id_number`, `course`, `current_section`, `modified_at`, `created_at`) VALUES
(1, 1, '1106-14', '1', '2Y1-1', '2018-05-22 21:43:47', '2018-01-30 14:01:49'),
(2, 2, '1106-15', '1', '1Y1-1', '2018-01-30 17:01:24', '2018-01-30 17:01:24'),
(3, 3, '1106-16', '1', '3y3-2', '2018-02-03 17:02:42', '2018-02-03 17:02:42');

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE `student_details` (
  `student_detail_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `student_image_id` varchar(255) NOT NULL,
  `guardian_name` varchar(255) NOT NULL,
  `guardian_contact_number` varchar(255) NOT NULL,
  `guardian_address` varchar(255) NOT NULL,
  `guardian_email` varchar(255) NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_details`
--

INSERT INTO `student_details` (`student_detail_id`, `firstname`, `middlename`, `lastname`, `gender`, `address`, `birth_date`, `mobile_number`, `contact_email`, `student_image_id`, `guardian_name`, `guardian_contact_number`, `guardian_address`, `guardian_email`, `modified_at`, `created_at`) VALUES
(1, 'Jerick Son', 'Lasat', 'Icamina', 'Male', 'North Circle St. Country Homes Cainta, Rizal', '1996-07-15', '09396831332', 'icaminajerick@gmail.com', 'NA', 'Gildarts Clive', '09834997612', 'Magnolia Town Kindom of Fiore', 'gildarts@gmail.com', '2018-05-22 21:43:47', '2018-01-30 14:01:49'),
(2, 'Kirigaya', 'N/A', 'Kazuto', 'Male', 'Ygdrassil Holy Land', '2001-04-26', '0', 'kirito@blade.game', 'NA', 'Yato Kaiba', '0', 'Aincard Floating Tower', 'yato@dev.virtual', '2018-01-30 17:01:24', '2018-01-30 17:01:24'),
(3, 'Shirou', 'Archer', 'Emiya', 'Male', 'Tokyo Japan', '2008-03-05', '09587779516', 'shirou@gmail.com', 'NA', 'Kiritsugu Emiya', '09587779516', 'Tokyo Japan', 'kiritsugu@gmail.com', '2018-02-03 17:02:42', '2018-02-03 17:02:42');

-- --------------------------------------------------------

--
-- Table structure for table `student_image`
--

CREATE TABLE `student_image` (
  `student_image_id` int(11) NOT NULL,
  `file_source` varchar(255) NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `modified_at`, `created_at`) VALUES
(1, 'ENGLISH 101', '2018-02-05 03:17:17', '2018-02-05 03:11:06'),
(2, 'ENGLISH 102', '2018-02-05 15:02:40', '2018-02-05 15:02:40'),
(3, 'ENGLISH 103', '2018-02-05 15:02:21', '2018-02-05 15:02:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'csjp.guidance@gmail.com', '$2y$10$CCw5gJSoQMdhFjeZsFoFA.fMlplc17i5xUMbLoj43/7YzZUjkjatC', 'XHldQNPQZvpEQ89BMvmwDqfp6wrjSe9GcSgvDpcgbDaarvwJhkzgwa2xNLqo', '2018-01-14 10:23:46', '2018-03-24 10:09:58');

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `violation_id` int(11) NOT NULL,
  `student_data_id` int(11) NOT NULL,
  `violation_type` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `instructor_name` varchar(255) NOT NULL,
  `violation_occur` datetime NOT NULL,
  `violation_comment` varchar(255) NOT NULL,
  `modified_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `violations`
--

INSERT INTO `violations` (`violation_id`, `student_data_id`, `violation_type`, `section`, `subject`, `instructor_name`, `violation_occur`, `violation_comment`, `modified_at`, `created_at`) VALUES
(1, 2, 'Absent', '1Y1-1', '2', 'Jerickson Icamina', '2018-02-06 09:02:00', 'Late...', '2018-02-05 17:02:49', '2018-02-05 17:02:49'),
(2, 2, 'Tardiness', '1Y1-1', '2', 'Icamina', '2018-02-21 18:02:00', 'Go...', '2018-02-05 18:02:29', '2018-02-05 18:02:29'),
(3, 1, 'Behaviour', '2Y1-1', '3', 'Lasat', '2018-02-06 10:02:00', '', '2018-02-05 18:02:17', '2018-02-05 18:02:17'),
(4, 1, 'Tardiness', '2Y1-1', '1', 'Icamina', '2018-02-08 06:02:00', 'Bones and flesh', '2018-02-05 18:02:52', '2018-02-05 18:02:52'),
(5, 1, 'Tardiness', '2Y1-1', '1', 'Juan Delacruz', '2018-05-22 18:05:00', 'He\'s Late', '2018-05-22 13:05:10', '2018-05-22 13:05:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `students_data`
--
ALTER TABLE `students_data`
  ADD PRIMARY KEY (`student_data_id`);

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
  ADD PRIMARY KEY (`student_detail_id`);

--
-- Indexes for table `student_image`
--
ALTER TABLE `student_image`
  ADD PRIMARY KEY (`student_image_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`violation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `students_data`
--
ALTER TABLE `students_data`
  MODIFY `student_data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `student_details`
--
ALTER TABLE `student_details`
  MODIFY `student_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `student_image`
--
ALTER TABLE `student_image`
  MODIFY `student_image_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `violation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
