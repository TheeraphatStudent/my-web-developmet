CREATE TABLE `Author` (
  `authorId` bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `eventId` bigint,
  `role` bigint,
  `created` bigint,
  `updated` bigint
);

CREATE TABLE `Attendence` (
  `attId` bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `regId` bigint,
  `verifyBy` bigint,
  `created` bigint
);

CREATE TABLE `Registration` (
  `regId` bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `eventId` bigint NOT NULL,
  `userId` bigint,
  `status` bigint,
  `updated` bigint,
  `created` bigint
);

CREATE TABLE `Event` (
  `eventId` bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `organizeId` bigint NOT NULL,
  `cover` bigint,
  `title` bigint,
  `descriprion` bigint,
  `venue` bigint,
  `maximunm` bigint,
  `type` bigint,
  `link` bigint,
  `start` bigint,
  `end` bigint,
  `location` json,
  `updated` bigint,
  `created` bigint
);

CREATE TABLE `User` (
  `userId` bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(100),
  `password` varchar(100),
  `email` varchar(100),
  `name` varchar(100),
  `gender` varchar(100),
  `education` varchar(100),
  `telno` varchar(100),
  `birth` date,
  `created` date,
  `updated` date
);

ALTER TABLE `Attendence` ADD CONSTRAINT `Attendence_regId_fk` FOREIGN KEY (`regId`) REFERENCES `Registration` (`regId`);
ALTER TABLE `Attendence` ADD CONSTRAINT `Attendence_verifyBy_fk` FOREIGN KEY (`verifyBy`) REFERENCES `Author` (`authorId`);
ALTER TABLE `Author` ADD CONSTRAINT `Author_eventId_fk` FOREIGN KEY (`eventId`) REFERENCES `Event` (`eventId`);
ALTER TABLE `Author` ADD CONSTRAINT `Author_stafId_fk` FOREIGN KEY (`authorId`) REFERENCES `User` (`userId`);
ALTER TABLE `Event` ADD CONSTRAINT `Event_organizeId_fk` FOREIGN KEY (`organizeId`) REFERENCES `User` (`userId`);
ALTER TABLE `Registration` ADD CONSTRAINT `Registration_eventId_fk` FOREIGN KEY (`eventId`) REFERENCES `Event` (`eventId`);
ALTER TABLE `Registration` ADD CONSTRAINT `Registration_userId_fk` FOREIGN KEY (`userId`) REFERENCES `User` (`userId`);