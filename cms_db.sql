-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 04:52 AM
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
-- Table structure for table `design_settings`
--

CREATE TABLE `design_settings` (
  `id` int(11) NOT NULL,
  `project_owner` int(10) UNSIGNED DEFAULT NULL,
  `template_owner` int(10) UNSIGNED DEFAULT NULL,
  `font_family` varchar(100) DEFAULT NULL,
  `background_color` varchar(20) DEFAULT NULL,
  `text_color` varchar(20) DEFAULT NULL,
  `heading_color` varchar(20) DEFAULT NULL,
  `custom_css` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `design_settings`
--

INSERT INTO `design_settings` (`id`, `project_owner`, `template_owner`, `font_family`, `background_color`, `text_color`, `heading_color`, `custom_css`) VALUES
(1, NULL, 1, 'Impact', 'Blue', 'Red', 'Yellow', 'body{padding: 50px;}');

-- --------------------------------------------------------

--
-- Table structure for table `elements`
--

CREATE TABLE `elements` (
  `element_id` int(30) UNSIGNED NOT NULL,
  `element_name` varchar(50) NOT NULL,
  `element_type` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `section_owner` int(10) UNSIGNED DEFAULT NULL,
  `nav_owner` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('template','project') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `elements`
--

INSERT INTO `elements` (`element_id`, `element_name`, `element_type`, `content`, `date_created`, `date_updated`, `section_owner`, `nav_owner`, `type`) VALUES
(1, 'Title Text', 'title', '{\"content\":\"\\ud835\\ude47\\ud835\\ude4a\\ud835\\ude4a\\ud835\\ude46 | The Inang Pamantasan\'s Guidance and Counseling Office (GCO) organized a workshop, \\\"Help Me Help You: Mastering Peer Facilitation,\\\" empowering its Peer Facilitators\' Group today, April 14.\"}', '2025-04-16 23:29:56', '2025-04-21 10:52:30', 1, NULL, 'template'),
(2, 'Title Text', 'title', '{\"content\":\"Second Title Text\"}', '2025-04-16 23:30:13', '2025-04-16 23:30:13', 2, NULL, 'template'),
(3, 'Title Text', 'title', '{\"content\":\"Third Title Text\"}', '2025-04-16 23:30:27', '2025-04-16 23:30:27', 3, NULL, 'template'),
(4, 'Paragraph Text', 'paragraph', '{\"content\":\"The event, held at the PLP Function Hall, gathered members from various colleges.\\nResource speaker, Mr. Mark M. Francisco emphasized the vital role of peer facilitators as a \'bridge\' between students and the university\'s GCO.\\nHe equipped them with practical strategies for empathetic listening, conflict resolution, and resource referral, enabling facilitators to provide immediate support and guide co-students towards professional help when needed.\\nThe workshop\'s success signals a promising future for student mental health support at PLP, with peer facilitators playing a vital role in ensuring students receive timely and appropriate assistance.\\n\"}', '2025-04-16 23:31:15', '2025-04-21 10:52:40', 1, NULL, 'template'),
(5, 'Paragraph Text', 'paragraph', '{\"content\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae, consectetur dolorum facilis esse porro sint unde modi accusamus quidem, quaerat doloribus, accusantium amet fugit? Odio autem a quos voluptatum quae.\"}', '2025-04-16 23:31:23', '2025-04-16 23:31:23', 2, NULL, 'template'),
(6, 'Paragraph Text', 'paragraph', '{\"content\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae, consectetur dolorum facilis esse porro sint unde modi accusamus quidem, quaerat doloribus, accusantium amet fugit? Odio autem a quos voluptatum quae.\"}', '2025-04-16 23:31:30', '2025-04-16 23:31:30', 3, NULL, 'template'),
(7, 'Button1', 'button', '{\"content\":\"Click Me\"}', '2025-04-20 12:49:37', '2025-04-21 02:28:52', 1, NULL, 'template'),
(8, 'Sub Text', 'sub', '{\"content\":\"First Sub Heading Text\"}', '2025-04-20 12:51:07', '2025-04-20 12:51:07', 1, NULL, 'template'),
(9, 'Home', 'anchor', '{\r\n\"link\":\"page_handler.php?page=1\";\r\n}', '2025-04-20 17:31:37', '2025-04-20 17:31:37', NULL, 1, 'template'),
(10, 'Services', 'anchor', '{\r\n\"link\":\"page_handler.php?page=2\";\r\n}', '2025-04-20 17:33:00', '2025-04-20 17:33:00', NULL, 1, 'template'),
(11, 'titles', 'title', '{\"content\":\"Here are our services\"}', '2025-04-21 00:41:02', '2025-04-21 02:42:52', 4, NULL, 'template'),
(12, 'service paragraph', 'paragraph', '{\"content\":\"Second Paragraph Lorem ipsum dolor sit...\"\r\n}', '2025-04-21 00:45:08', '2025-04-21 00:45:08', 4, NULL, 'template'),
(13, 'title', 'title', '{\r\n\"content\":\"HELLO WORLD\"\r\n}', '2025-04-21 02:39:58', '2025-04-21 02:39:58', 1, NULL, 'template');

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE `navigation` (
  `id` int(11) NOT NULL,
  `nav_name` varchar(50) NOT NULL,
  `project_owner` int(11) UNSIGNED DEFAULT NULL,
  `template_owner` int(11) UNSIGNED DEFAULT NULL,
  `styles` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `navigation`
--

INSERT INTO `navigation` (`id`, `nav_name`, `project_owner`, `template_owner`, `styles`) VALUES
(1, 'template1 nav', NULL, 1, '@import url(\'https://fonts.googleapis.com/css2?family=Boldonse&family=Nanum+Gothic&family=Nanum+Myeongjo&display=swap\');\r\n\r\n@font-face {\r\n    font-family: \'main\';\r\n    src: url(fonts/nanum_myeongjo/NanumMyeongjo-Regular.ttf);\r\n    color: #161616;\r\n}\r\n\r\n@font-face {\r\n    font-family: \'sub\';\r\n    src: url(fonts/nanum_gothic/NanumGothic-Regular.ttf);\r\n    color: #161616;\r\n}\r\n\r\n\r\n.nav_items {\r\n    display: flex;\r\n    flex-direction: row;\r\n    justify-content: flex-end;\r\n    gap: 5em;\r\n}\r\n\r\n.nav_items li {\r\n    /*  */\r\n}\r\n\r\n.nav_items li a {\r\n    text-decoration: none;\r\n    color: #161616;\r\n    transition: 0.3s ease-in-out;\r\n}\r\n\r\n.nav_items li a:hover {\r\n    color: #555;\r\n}\r\n\r\n.nav_container {\r\n    display: grid;\r\n    grid-template-columns: 30% 70%;\r\n    background-color: white;\r\n    padding: 20px 50px 20px 50px;\r\n    height: 4vh;\r\n    font-family: \'sub\';\r\n    font-size: smaller;\r\n    border-bottom: 1px solid #e9e9e9;\r\n    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;\r\n    align-items: center;\r\n}\r\n\r\n.nav_container_container {\r\n    position: fixed;\r\n    width: 100vw;\r\n    z-index: 99;\r\n}');

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
(3, 'section 3', '2025-04-16 23:27:44', '2025-04-16 23:27:44', 1, 'template'),
(4, 'Service Section 1', '2025-04-21 00:39:58', '2025-04-21 00:39:58', 2, 'template');

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
(1, 'Template 1', 'Portfolio');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_pass` varchar(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `user_type` enum('editor','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_pass`, `date_created`, `date_updated`, `user_type`) VALUES
(1, 'klarenz', 'klarenzcobie99@gmail.com', 'helloworld', '2025-04-16 22:53:56', '2025-04-16 22:53:56', 'editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `design_settings`
--
ALTER TABLE `design_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_design_constraint` (`project_owner`),
  ADD KEY `template_design_constraint` (`template_owner`);

--
-- Indexes for table `elements`
--
ALTER TABLE `elements`
  ADD PRIMARY KEY (`element_id`),
  ADD KEY `section_element_constraint` (`section_owner`);

--
-- Indexes for table `navigation`
--
ALTER TABLE `navigation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_nav_constraint` (`project_owner`);

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
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `design_settings`
--
ALTER TABLE `design_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `elements`
--
ALTER TABLE `elements`
  MODIFY `element_id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `navigation`
--
ALTER TABLE `navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `design_settings`
--
ALTER TABLE `design_settings`
  ADD CONSTRAINT `project_design_constraint` FOREIGN KEY (`project_owner`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `template_design_constraint` FOREIGN KEY (`template_owner`) REFERENCES `templates` (`template_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `elements`
--
ALTER TABLE `elements`
  ADD CONSTRAINT `section_element_constraint` FOREIGN KEY (`section_owner`) REFERENCES `sections` (`section_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `navigation`
--
ALTER TABLE `navigation`
  ADD CONSTRAINT `project_nav_constraint` FOREIGN KEY (`project_owner`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `template_nav_constraint` FOREIGN KEY (`project_owner`) REFERENCES `templates` (`template_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
