-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2025 at 04:37 PM
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
-- Database: `code_vimarsh`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `join_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `heading`, `description`, `join_link`) VALUES
(1, 'Inspire. Create. Code.', 'Unleashing Innovation in Our Coding Club Community. Join the Journey to Empower, Learn, and Excel in the World of Programming!\"\r\n\r\nElevate your programming skills, tackle exciting challenges, & explore the endless possibilities of coding with Code Vimarsh', 'https://chat.whatsapp.com/L7IN0PRX9Q61UQYQfzhEpX');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'admin@codevimarsh.com', '$2y$10$drzUfR6ru5yN8MxZclOdW.5NbuSSykW6ohv0xF8rI4IJhVR.ecPsO', '2025-12-25 13:23:24');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `image`, `event_date`, `event_time`, `description`, `created_at`) VALUES
(3, 'A To Z for DSA Foundation', '1766939808_vision logo.png', '2025-10-05', '11:00:00', 'This session covers DSA\'s importance, guides beginners on starting with programming, IDEs, and platforms, explains problem-solving from brute-force to optimization, highlights overcoming challenges with consistency, and emphasizes goal setting for mastering DSA', '2025-12-28 13:15:54'),
(4, 'Fireside Chat with Manu Mishra', '1766939824_vision logo.png', '2025-08-02', '09:30:00', 'Fireside Chat: Tech Careers, Stories & Industry Secrets\n\nRegistration for this event is open.\n\nEvent Details: Date: Saturday, 2th August 2025\n\nTime: 9:30 AM onwards\n\nEligible: All CSE Studenta\n\nOffline Mode: Venue: CSE Seminar Hall\n\nReporting Time: 9:15 AM\n\nA Limited seats-selection random if over capacity\n\nRefreshments provided\n\nOnline Mode: Google Meet (limit: 100)\n\nOverflow Mode: YouTube Live (no limit)\n\nWhat You\'ll Gain: Real-world software challenges\n\nGrowth path in tech roles\n\nPeer & senior networking\n\nCareer Inspiration\n\nSpeaker Details: Manu Miura\n\nPrincipal Solbware Engineer-Walmart Global Tech (San Francisco Bay Area)\n\nDeep Technical Expertise\n\nStrong Leadership & Mentorship\n\nWhat he\'ll share\n\nIndustry challenges\n\nHow to grow professionally\n\nWhat matters in toch careers\n\nRegistration & Feedback:\n\nRegistration Forme\n\n\"Late registrations may not qualify for offline mode.', '2025-12-28 13:39:26'),
(5, 'Fireside Chat with Nishant Varmani', '1766939816_vision logo.png', '2025-09-26', '09:30:00', 'Speaker Details Guest Speaker: Nishant Virmani Technical Program Manager - YouTube (San Francisco Bay Area, USA) Meet Niraj Virmani, a Senior Technical Program Manager at Google who leads the YouTube Living Room ecosystem. A tech leader with past experience at Apple, he has shaped products you use daily-from launching Siri on Mac to managing global releases for Apple Maps and IOS. Learn from an expert whose work Impacts hundreds of millions.\n\nWhat He Brings to You The A Roadmap to Your Dream Job Learn how to build a standout profile that gets noticed by top tech companies like Google and Apple. The Inside Story of Iconic Products Discover how products like YouTube on TV, Siri, and Apple Maps are built and scaled for millions of users worldwide. A Career Path Beyond Pure Coding Explore how engineering, product, and design work together to create the technology that you use and love every day.\n\nWhy You Shouldn\'t Miss This Session As someone who\'s built his career from the ground up and now operates at a global level, Nishant Sir\'s Insights will be incredibly valuable for any student looking to succeed in the tech industry. He will share: Real-world challenges from industry\n\nHow to grow technically and professionally\n\nWhat matters most in shaping a successful software career\n\nWhether you\'re just getting started or planning your next step, this is a rare chance to learn from someone who\'s already walked the path you aim to follow.\n\nEvent Host: Sandip Parmar & Dhriti Gandhi (One of Team Member From Code Vimarsh) Sandip Parmar Sir is a proud alumnus of The Maharaja Sayajirao University of Baroda, from the CSE Department. Currently working at Google, he brings years of global industry experience and insight into high-impact technology roles. As a dedicated mentor and an active supporter of Code Vimarsh, Sandip Sir has consistently contributed towards uplifting students by sharing knowledge, guiding on career paths, and connecting academic learning to real-world industry demands. Their journey from MSU Baroda to Google serves as a living example of what\'s possible with the right mindset, skills, and support-something [he/she/they] now pay forward to the next generation of tech leaders from our very own department', '2025-12-28 13:41:17');

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `platform`, `icon`, `link`) VALUES
(2, 'Instagram', 'instagram.png', 'https://instagram.com'),
(3, 'LinkedIn', 'linkedin.png', 'https://linkedin.com'),
(4, 'GitHub', 'github.png', 'https://github.com'),
(5, 'WhatsApp', 'whatsapp.png', 'https://whatsapp.com');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `linkedin_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `role`, `category`, `image`, `linkedin_url`) VALUES
(9, 'Ashish Gokani', 'Coordinator', 'web team', '1767014560_1764168358755.jpg', 'https://www.linkedin.com/in/ashishgokani'),
(10, 'Jay Prajapati', 'Secretary', 'initiators', '1767014706_1723137063470.jpg', 'https://www.linkedin.com/in/jay-prajapati-853579246/'),
(11, 'Krupal Patel', 'President', 'initiators', '1767014806_1753565544691.jpg', 'https://www.linkedin.com/in/krupal-patel-7a0956241/'),
(12, 'Mihir Bhavsar', 'Graphic Designer', 'initiators', '1767014907_1734452312705.jpg', 'https://www.linkedin.com/in/mihirbhavsar3102/'),
(13, 'Shivam Parmar', 'Committee Member', 'family', '1767015547_resized-image.jpeg', 'https://www.linkedin.com/in/shivam-parmar007/'),
(14, 'Yash Solanki', 'Committee Member', 'family', '1767015902_1752171997764.jpg', 'https://www.linkedin.com/in/yashvsolanki/'),
(15, 'Jatin Prajapati', 'Head', 'web team', '1767016065_1738071539774.jpg', 'https://www.linkedin.com/in/jatin-prajapati-000065263/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
