DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`final-activity`@`%` PROCEDURE `GetAllEventsByUserId`(IN `getUserId` VARCHAR(255))
BEGIN
    SELECT
    e.eventId,
    e.cover,
    e.title,
    e.maximum,
    e.type,
    e.start,
    e.end,
    e.created,
    COUNT(CASE WHEN r.status = 'pending' THEN r.regId END) AS request,
    COUNT(CASE WHEN a.status IN ('pending', 'accept') THEN a.regId END) AS attendee
FROM Event e
LEFT JOIN Registration r ON e.eventId = r.eventId
LEFT JOIN Attendance a ON r.regId = a.regId
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

CREATE PROCEDURE `GetMail` (IN `getUserId` VARCHAR(255))   BEGIN
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

CREATE PROCEDURE `GetUserEventDetails` (IN `getUserId` VARCHAR(255) CHARSET utf8mb4)   BEGIN
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

CREATE PROCEDURE `GetUsersByEvent` (IN `getUserId` VARCHAR(255), IN `getEventId` VARCHAR(255))   BEGIN
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

CREATE PROCEDURE `GetUsersRegByEventId` (IN `getUserId` VARCHAR(255), IN `getEventId` VARCHAR(255))   BEGIN
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

CREATE TABLE `Attendance` (
  `id` int NOT NULL,
  `regId` varchar(255) NOT NULL,
  `verifyBy` int DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(100) DEFAULT NULL,
  `rejectMessage` text
);

CREATE TABLE `Author` (
  `id` int NOT NULL,
  `authorId` varchar(255) NOT NULL,
  `eventId` varchar(255) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL
);


CREATE TABLE `Event` (
  `id` int NOT NULL,
  `eventId` varchar(255) NOT NULL,
  `organizeId` varchar(255) NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `morePics` text,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `venue` varchar(20) DEFAULT NULL,
  `maximum` int DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `start` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `end` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `location` text,
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL
);

CREATE TABLE `Registration` (
  `id` int NOT NULL,
  `regId` varchar(255) NOT NULL,
  `eventId` varchar(255) NOT NULL,
  `userId` varchar(255) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL
);


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
);

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
