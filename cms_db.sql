-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 25, 2026 at 06:45 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `status`, `created_at`) VALUES
(1, 'My First Post', 'my-first-post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent a scelerisque elit. Phasellus lobortis massa metus, ut lobortis justo porta sit amet. Vivamus interdum venenatis malesuada. Phasellus at commodo quam. Vivamus ultrices lectus eget leo aliquam egestas. Nulla vulputate venenatis augue, sed viverra arcu interdum in. Praesent congue rutrum nisl ac tempor. Nam eu massa risus. Vestibulum non molestie augue, sed facilisis magna. Suspendisse lobortis, risus non faucibus vestibulum, massa erat aliquam eros, et dignissim nibh sapien a nisl. Etiam hendrerit velit id gravida convallis. Fusce suscipit sapien et iaculis gravida. Aliquam erat volutpat. Duis erat massa, pellentesque ac turpis vel, pretium lacinia neque.', 'published', '2026-08-23 14:27:58'),
(3, 'My second post', 'my-second-post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent a scelerisque elit. Phasellus lobortis massa metus, ut lobortis justo porta sit amet. Vivamus interdum venenatis malesuada. Phasellus at commodo quam. Vivamus ultrices lectus eget leo aliquam egestas. Nulla vulputate venenatis augue, sed viverra arcu interdum in. Praesent congue rutrum nisl ac tempor. Nam eu massa risus. Vestibulum non molestie augue, sed facilisis magna. Suspendisse lobortis, risus non faucibus vestibulum, massa erat aliquam eros, et dignissim nibh sapien a nisl. Etiam hendrerit velit id gravida convallis. Fusce suscipit sapien et iaculis gravida. Aliquam erat volutpat. Duis erat massa, pellentesque ac turpis vel, pretium lacinia neque.', 'published', '2026-08-25 15:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'admin', '$2y$10$mWF/SCG9ReI7tI.FYDf4LuQl5Sgyd0rWI/i6gJcbU.IpTxo.lvmea', '2026-08-23 15:51:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
