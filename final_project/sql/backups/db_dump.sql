-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: database:3306
-- Generation Time: Mar 06, 2025 at 12:55 PM
-- Server version: 9.1.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final-database`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`final-activity`@`%` PROCEDURE `GetAllEventsByUserId` (IN `getUserId` VARCHAR(255))   BEGIN
    SELECT
        e.eventId,
        e.cover,
        e.title,
        e.maximum,
        e.type,
        e.start,
        e.end,
        e.created,
        COUNT(r.regId) AS attendee
    FROM Event e
    LEFT JOIN Registration r ON e.eventId = r.eventId
    WHERE e.organizeId = getUserId
    GROUP BY 
        e.eventId, 
        e.cover, 
        e.title, 
        e.maximum, 
        e.type, 
        e.start, 
        e.end, 
        e.created;
END$$

CREATE DEFINER=`final-activity`@`%` PROCEDURE `GetMail` (IN `getUserId` VARCHAR(255))   BEGIN
    SELECT
        e.title,
        e.cover,
        e.start,
        r.status
    FROM Registration r
    JOIN User u ON u.userId = r.userId
    JOIN Event e ON r.eventId = e.eventId
    WHERE u.userId = getUserId;
END$$

CREATE DEFINER=`final-activity`@`%` PROCEDURE `GetUserEventDetails` (IN `getUserId` VARCHAR(255) CHARSET utf8mb4)   BEGIN
    SELECT 
        u.userId,
        u.name,
        u.birth,
        u.email,
        u.gender,
        u.education,
        u.telno,
        u.created,

        (SELECT COUNT(*) FROM Event e WHERE e.organizeId = u.userId) AS totalOrganize,
        (SELECT COUNT(*) FROM Registration r WHERE r.userId = u.userId) AS totalAttendee

    FROM User u
    WHERE u.userId = getUserId;
END$$

CREATE DEFINER=`final-activity`@`%` PROCEDURE `GetUsersByEvent` (IN `getUserId` VARCHAR(255), IN `getEventId` VARCHAR(255))   BEGIN
    SELECT 
        u.userId,
        u.name,
        u.gender,
        u.telno,
        u.email,
        r.status,
        r.created
    FROM Registration r
    JOIN Event e ON r.eventId = e.eventId
    JOIN User u ON u.userId = r.userId 
    WHERE e.eventId = getEventId 
    AND (e.organizeId = getUserId OR getUserId IS NULL OR getUserId = '');
END$$

CREATE DEFINER=`final-activity`@`%` PROCEDURE `GetUsersRegByEventId` (IN `getUserId` VARCHAR(255), IN `getEventId` VARCHAR(255))   BEGIN
    SELECT DISTINCT
        u.userId,
        u.name,
        u.birth,
        r.status,
        r.created as regDate,
        r.regId
    FROM Event e
    JOIN User u
    JOIN Registration r
    WHERE e.organizeId = getUserId
    AND u.userId = r.userId
    AND r.eventId = e.eventId
    AND e.eventId = getEventId;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Attendance`
--

CREATE TABLE `Attendance` (
  `id` int NOT NULL,
  `regId` varchar(255) NOT NULL,
  `verifyBy` int DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(100) DEFAULT NULL,
  `rejectMessage` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Author`
--

CREATE TABLE `Author` (
  `id` int NOT NULL,
  `authorId` varchar(255) NOT NULL,
  `eventId` varchar(255) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Author`
--

INSERT INTO `Author` (`id`, `authorId`, `eventId`, `role`, `created`, `updated`) VALUES
(1, 'AGU-0000001_user-b57204e202489c3e67c4baecd336c', 'AG-20250000001_event-da2a60c465e8b17b67c4c366aef51', 'staff', '2025-02-05 13:14:09', '2025-02-05 13:14:09'),
(2, 'AGU-0000002_user-06be76cd93ff47f167c520af53d14', 'AG-20250000001_event-da2a60c465e8b17b67c4c366aef51', 'sponser', '2025-02-05 13:14:09', '2025-02-05 13:14:09'),
(3, 'AGU-0000003_user-c2ea0fe4fd7215ae67c528a145449', 'AG-20250000001_event-da2a60c465e8b17b67c4c366aef51', 'guest', '2025-02-05 13:14:09', '2025-02-05 13:14:09'),
(4, 'AGU-0000004_user-0e8f582fbdc5f35f67c54c802b88e', 'AG-20250000001_event-da2a60c465e8b17b67c4c366aef51', 'guest', '2025-02-05 13:14:09', '2025-02-05 13:14:09'),
(5, 'AGU-0000001_user-b57204e202489c3e67c4baecd336c', 'AG-20250000003_event-2eaf94dc6704470067c4c3aae2dba', 'sponser', '2025-03-02 13:31:08', '2025-03-02 13:31:08'),
(6, 'AGU-0000002_user-06be76cd93ff47f167c520af53d14', 'AG-20250000003_event-2eaf94dc6704470067c4c3aae2dba', 'staff', '2025-03-02 13:31:08', '2025-03-02 13:31:08'),
(7, 'AGU-0000003_user-c2ea0fe4fd7215ae67c528a145449', 'AG-20250000003_event-2eaf94dc6704470067c4c3aae2dba', 'guest', '2025-03-02 13:31:08', '2025-03-02 13:31:08'),
(8, 'AGU-0000004_user-0e8f582fbdc5f35f67c54c802b88e', 'AG-20250000003_event-2eaf94dc6704470067c4c3aae2dba', 'host', '2025-03-02 13:31:08', '2025-03-02 13:31:08'),
(9, 'AGU-0000001_user-b57204e202489c3e67c4baecd336c', 'AG-20250000004_event-072e8a55a8d2382467c5218b35d99', 'guest', '2025-03-02 13:31:08', '2025-03-02 13:31:08'),
(10, 'AGU-0000002_user-06be76cd93ff47f167c520af53d14', 'AG-20250000004_event-072e8a55a8d2382467c5218b35d99', 'host', '2025-03-02 13:31:08', '2025-03-02 13:31:08'),
(11, 'AGU-0000003_user-c2ea0fe4fd7215ae67c528a145449', 'AG-20250000004_event-072e8a55a8d2382467c5218b35d99', 'staff', '2025-03-02 13:31:08', '2025-03-02 13:31:08'),
(12, 'AGU-0000004_user-0e8f582fbdc5f35f67c54c802b88e', 'AG-20250000004_event-072e8a55a8d2382467c5218b35d99', 'sponser', '2025-03-02 13:31:08', '2025-03-02 13:31:08'),
(13, 'AGU-0000001_user-b57204e202489c3e67c4baecd336c', 'AG-20250000005_event-c161f6a807dd24ee67c5487d763b2', 'sponser', '2025-03-02 13:31:08', '2025-03-02 13:31:08'),
(14, 'AGU-0000002_user-06be76cd93ff47f167c520af53d14', 'AG-20250000005_event-c161f6a807dd24ee67c5487d763b2', 'staff', '2025-03-02 13:31:08', '2025-03-02 13:31:08'),
(15, 'AGU-0000003_user-c2ea0fe4fd7215ae67c528a145449', 'AG-20250000005_event-c161f6a807dd24ee67c5487d763b2', 'guest', '2025-03-02 13:31:08', '2025-03-02 13:31:08'),
(16, 'AGU-0000004_user-0e8f582fbdc5f35f67c54c802b88e', 'AG-20250000005_event-c161f6a807dd24ee67c5487d763b2', 'host', '2025-03-02 13:31:08', '2025-03-02 13:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `Event`
--

CREATE TABLE `Event` (
  `id` int NOT NULL,
  `eventId` varchar(255) NOT NULL,
  `organizeId` varchar(255) NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `morePics` text,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `venue` varchar(20) DEFAULT NULL,
  `maximum` json DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `start` varchar(255) DEFAULT NULL,
  `end` varchar(255) DEFAULT NULL,
  `location` json DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Event`
--

INSERT INTO `Event` (`id`, `eventId`, `organizeId`, `cover`, `morePics`, `title`, `description`, `venue`, `maximum`, `type`, `link`, `start`, `end`, `location`, `created`, `updated`) VALUES
(2, 'AG-20250000001_event-da2a60c465e8b17b67c4c366aef51', 'AGU-0000001_user-b57204e202489c3e67c4baecd336c', '67c4c366a6593_cover-9413412.jpg', '[\"67c4c366a8ac8_more-cover.jpg\",\"67c4c366a9ba0_more-banner.jpg\",\"67c4c366ab30c_more-6721801.jpg\"]', 'My Event', '<h1 id=\"hello-world\">Hello World</h1>', '0', '100', 'onsite', '-', '[\"2025-03-03T03:44\"]', '[\"2025-03-03T03:44\"]', '{\"lat\": \"16.24558727178143\", \"lon\": \"103.24909020150005\"}', '2025-03-02 20:45:26', '2025-03-02 20:45:26'),
(3, 'AG-20250000003_event-2eaf94dc6704470067c4c3aae2dba', 'AGU-0000001_user-b57204e202489c3e67c4baecd336c', '67c4c3aadff0f_cover-banner.jpg', '[\"67c4c3aae17ff_more-cover.jpg\"]', 'Test', '<h1 id=\"hello-world\">hello World</h1><p><em>it Working</em></p>', '0', '100', 'any', 'Hello Link', '[\"2025-03-04T03:45\",\"2025-03-05T03:46\",\"2025-03-06T03:46\"]', '[\"2025-03-04T03:45\",\"2025-03-05T03:46\",\"2025-03-06T03:46\"]', '{\"lat\": \"16.243195680748585\", \"lon\": \"103.24748087609134\"}', '2025-03-02 20:46:34', '2025-03-02 20:46:34'),
(4, 'AG-20250000004_event-072e8a55a8d2382467c5218b35d99', 'AGU-0000002_user-06be76cd93ff47f167c520af53d14', '67c5218b2719d_cover-perfect.jpg', '[\"67c5218b28603_more-Insertion Sort.png\",\"67c5218b2a26f_more-Bubble .png\",\"67c5218b2c4d1_more-Selection .png\",\"67c5218b2ec0d_more-RADIX.png\",\"67c5218b30aab_more-SHELLSORT.png\",\"67c5218b32bd1_more-Quicksort.png\"]', '\' OR \'1\'=\'1', '<p>&#39; OR &#39;1&#39;=&#39;1</p>', '100', '30000', 'onsite', '\' OR \'1\'=\'1', '[\"2025-03-03T10:24\"]', '[\"2025-03-27T10:24\"]', '{\"lat\": 0, \"lon\": 0}', '2025-03-03 03:27:07', '2025-03-03 03:27:07'),
(5, 'AG-20250000005_event-c161f6a807dd24ee67c5487d763b2', 'AGU-0000001_user-b57204e202489c3e67c4baecd336c', '67c5487d6a4ca_cover-cover.jpg', '[\"67c5487d6d396_more-banner.jpg\",\"67c5487d6ffa0_more-9413412.jpg\",\"67c5487d73233_more-6721801.jpg\"]', 'Sawaddee', '<h1 id=\"sawaddee\">Sawaddee</h1>', '0', '100', 'online', '-', '[\"2025-03-03T13:12\",\"2025-03-04T13:13\"]', '[\"2025-03-03T13:12\",\"2025-03-04T13:13\"]', '{\"lat\": \"16.245484560236832\", \"lon\": \"103.24791697865192\"}', '2025-03-03 06:13:17', '2025-03-03 06:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `Registration`
--

CREATE TABLE `Registration` (
  `id` int NOT NULL,
  `regId` varchar(255) NOT NULL,
  `eventId` varchar(255) NOT NULL,
  `userId` varchar(255) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int NOT NULL,
  `userId` varchar(255) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `telno` varchar(50) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `userId`, `username`, `password`, `email`, `name`, `gender`, `education`, `telno`, `birth`, `created`, `updated`) VALUES
(1, 'AGU-0000001_user-b57204e202489c3e67c4baecd336c', '12345678', '$2y$10$8hm55DmnrQVHWZIlgDWDEuTzxHrMb/2uu4Pl65iRzi0aNDHuhg4k6', 'th33raphat@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-03-02 20:09:16', '2025-03-02 20:09:16'),
(2, 'AGU-0000002_user-06be76cd93ff47f167c520af53d14', 'นายภูมิ', '$2y$10$ftlw/yhStC7Vtz0GNtgCd.OEc8drelMC8KwECtC.zQTcG3RXywkqq', '66011212245@msu.ac.th', NULL, NULL, NULL, NULL, NULL, '2025-03-03 03:23:27', '2025-03-03 03:23:27'),
(3, 'AGU-0000003_user-c2ea0fe4fd7215ae67c528a145449', 'Tama', '$2y$10$lxrkoThjOo1vITGFIoBauOD56GSwWPTW/uHCK3n8XkAYKjcnfPWhu', 'Tama@1', NULL, NULL, NULL, NULL, NULL, '2025-03-03 03:57:21', '2025-03-03 03:57:21'),
(4, 'AGU-0000004_user-0e8f582fbdc5f35f67c54c802b88e', 'hello', '$2y$10$xoWLEpmV1IyoYF7it0rvPOEv/jvGpwsspQXQb7iJZnIVGlDrUIOHm', 'sample@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-03-03 06:30:24', '2025-03-03 06:30:24'),
(5, 'AGU-0000005_user-b57e116004eda81567c555c63aaeb', 'TestAuth', '$2y$10$KwxzFOb7bXG7HnjXDypiWO3lUGoAuoMz/3ttTluTe4hFVLTCdwUP.', 'tester@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-03-03 07:09:58', '2025-03-03 07:09:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Attendance`
--
ALTER TABLE `Attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Attendance_regId_fk` (`regId`),
  ADD KEY `Attendance_verifyBy_fk` (`verifyBy`);

--
-- Indexes for table `Author`
--
ALTER TABLE `Author`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Author_eventId_fk` (`eventId`),
  ADD KEY `Author_authorId_fk` (`authorId`);

--
-- Indexes for table `Event`
--
ALTER TABLE `Event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eventId` (`eventId`),
  ADD KEY `Event_organizeId_fk` (`organizeId`);

--
-- Indexes for table `Registration`
--
ALTER TABLE `Registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regId` (`regId`),
  ADD KEY `Registration_eventId_fk` (`eventId`),
  ADD KEY `Registration_userId_fk` (`userId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userId` (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Attendance`
--
ALTER TABLE `Attendance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Author`
--
ALTER TABLE `Author`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `Event`
--
ALTER TABLE `Event`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Registration`
--
ALTER TABLE `Registration`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Attendance`
--
ALTER TABLE `Attendance`
  ADD CONSTRAINT `Attendance_regId_fk` FOREIGN KEY (`regId`) REFERENCES `Registration` (`regId`) ON DELETE CASCADE,
  ADD CONSTRAINT `Attendance_verifyBy_fk` FOREIGN KEY (`verifyBy`) REFERENCES `Author` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `Author`
--
ALTER TABLE `Author`
  ADD CONSTRAINT `Author_authorId_fk` FOREIGN KEY (`authorId`) REFERENCES `User` (`userId`) ON DELETE CASCADE,
  ADD CONSTRAINT `Author_eventId_fk` FOREIGN KEY (`eventId`) REFERENCES `Event` (`eventId`) ON DELETE CASCADE;

--
-- Constraints for table `Event`
--
ALTER TABLE `Event`
  ADD CONSTRAINT `Event_organizeId_fk` FOREIGN KEY (`organizeId`) REFERENCES `User` (`userId`) ON DELETE CASCADE;

--
-- Constraints for table `Registration`
--
ALTER TABLE `Registration`
  ADD CONSTRAINT `Registration_eventId_fk` FOREIGN KEY (`eventId`) REFERENCES `Event` (`eventId`) ON DELETE CASCADE,
  ADD CONSTRAINT `Registration_userId_fk` FOREIGN KEY (`userId`) REFERENCES `User` (`userId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
