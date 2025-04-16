-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 06:34 PM
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
-- Database: `cms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `elements`
--

CREATE TABLE `elements` (
  `element_id` int(30) UNSIGNED NOT NULL,
  `element_name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `section_owner` int(10) UNSIGNED NOT NULL,
  `type` enum('template','project') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `elements`
--

INSERT INTO `elements` (`element_id`, `element_name`, `content`, `date_created`, `date_updated`, `section_owner`, `type`) VALUES
(1, 'Title Text', 'Una', '2025-04-16 23:29:56', '2025-04-16 23:29:56', 1, 'template'),
(2, 'Title Text', 'Pangalawa', '2025-04-16 23:30:13', '2025-04-16 23:30:13', 2, 'template'),
(3, 'Title Text', 'Pangatlo', '2025-04-16 23:30:27', '2025-04-16 23:30:27', 3, 'template'),
(4, 'Paragraph Text', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2025-04-16 23:31:15', '2025-04-16 23:31:15', 1, 'template'),
(5, 'Paragraph Text', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2025-04-16 23:31:23', '2025-04-16 23:31:23', 2, 'template'),
(6, 'Paragraph Text', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2025-04-16 23:31:30', '2025-04-16 23:31:30', 3, 'template');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(10) UNSIGNED NOT NULL,
  `page_name` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `project_owner` int(10) UNSIGNED DEFAULT NULL,
  `template_owner` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('template','project') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page_name`, `date_created`, `date_updated`, `project_owner`, `template_owner`, `type`) VALUES
(1, 'home', '2025-04-16 23:25:26', '2025-04-16 23:25:26', NULL, 1, 'template'),
(2, 'services', '2025-04-16 23:25:42', '2025-04-16 23:25:42', NULL, 1, 'template'),
(3, 'contact', '2025-04-16 23:25:51', '2025-04-16 23:25:51', NULL, 1, 'template'),
(4, 'about', '2025-04-16 23:25:59', '2025-04-16 23:25:59', NULL, 1, 'template');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(10) UNSIGNED NOT NULL,
  `project_name` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `user_owner` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `section_id` int(10) UNSIGNED NOT NULL,
  `section_name` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `page_owner` int(10) UNSIGNED NOT NULL,
  `type` enum('template','project') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `section_name`, `date_created`, `date_updated`, `page_owner`, `type`) VALUES
(1, 'section 1', '2025-04-16 23:27:29', '2025-04-16 23:27:29', 1, 'template'),
(2, 'section 2', '2025-04-16 23:27:37', '2025-04-16 23:27:37', 1, 'template'),
(3, 'section 3', '2025-04-16 23:27:44', '2025-04-16 23:27:44', 1, 'template');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `template_id` int(10) UNSIGNED NOT NULL,
  `template_name` varchar(50) NOT NULL,
  `template_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`template_id`, `template_name`, `template_type`) VALUES
(1, 'template 1', 'home');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_pass` varchar(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `user_type` enum('editor','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `date_created`, `date_updated`, `user_type`) VALUES
(1, 'klarenz', 'helloworld', '2025-04-16 22:53:56', '2025-04-16 22:53:56', 'editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `elements`
--
ALTER TABLE `elements`
  ADD PRIMARY KEY (`element_id`),
  ADD KEY `section_element_constraint` (`section_owner`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`),
  ADD KEY `project_page_constraint` (`project_owner`),
  ADD KEY `template_page_constraint` (`template_owner`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `user_project_constraint` (`user_owner`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `page_section_constraint` (`page_owner`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `elements`
--
ALTER TABLE `elements`
  MODIFY `element_id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `template_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `elements`
--
ALTER TABLE `elements`
  ADD CONSTRAINT `section_element_constraint` FOREIGN KEY (`section_owner`) REFERENCES `sections` (`section_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `project_page_constraint` FOREIGN KEY (`project_owner`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `template_page_constraint` FOREIGN KEY (`template_owner`) REFERENCES `templates` (`template_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `user_project_constraint` FOREIGN KEY (`user_owner`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `page_section_constraint` FOREIGN KEY (`page_owner`) REFERENCES `pages` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
