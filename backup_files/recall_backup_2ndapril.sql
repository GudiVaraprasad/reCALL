-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2022 at 09:23 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recall`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `sno` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `tstamp` datetime NOT NULL DEFAULT current_timestamp(),
  `id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`, `id`) VALUES
(33, 'pranav is champ', 'just a lol', '2022-03-23 11:44:35', '109501823479799371687'),
(34, 'random', 'random done 2.0', '2022-03-23 15:19:42', '110673071958317830089'),
(35, 'usernotes', 'pdv tsp reports', '2022-03-26 15:57:43', '110673071958317830089'),
(40, 'computer ', 'ge', '2022-04-02 21:51:17', '110673071958317830089');

-- --------------------------------------------------------

--
-- Table structure for table `organizetask`
--

CREATE TABLE `organizetask` (
  `id` int(11) NOT NULL,
  `task` varchar(65) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `user_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `google_id` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `google_id`, `name`, `email`, `profile_image`) VALUES
(1, '110673071958317830089', 'Gudi Varaprasad', 'gudi.varaprasad@gmail.com', 'https://lh3.googleusercontent.com/a-/AOh14Gjkn6ath4ved911-BRH6b1zeAGQQdZehXFJBk1CbA=s96-c'),
(2, '109501823479799371687', 'Sesha Pranav', 'seshapranav@gmail.com', 'https://lh3.googleusercontent.com/a-/AOh14GhponNXyCoEHBziYrmD_I6hsFbIvTbbbdAwX54HMw=s96-c'),
(3, '103013404779558319953', 'ANTIDOTE', 'krishpalaparthy6768@gmail.com', 'https://lh3.googleusercontent.com/a-/AOh14GiMmFt4EmWXHiRtlizVCE-d1y6HLl_lnFzNy4hZu-I=s96-c'),
(4, '101661526643603239071', 'Nikhilesh Gunnam', 'nikhileshgunnam@gmail.com', 'https://lh3.googleusercontent.com/a-/AOh14GhCaFXTsykypDb1ZcjOVm37mpeTQ8ftf3tNoj371Q=s96-c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `organizetask`
--
ALTER TABLE `organizetask`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `sno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `organizetask`
--
ALTER TABLE `organizetask`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
