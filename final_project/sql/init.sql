DROP TABLE Attendance;
DROP TABLE Author;
DROP TABLE Registration;
DROP TABLE Event;
DROP TABLE User;

CREATE TABLE Author (
  `id`          int AUTO_INCREMENT PRIMARY KEY,
  `authorId`    varchar(255) NOT NULL,
  `eventId`     varchar(255) NOT NULL,
  `role`        varchar(100),
  `created`     timestamp,
  `updated`     timestamp
);

CREATE TABLE Attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    regId VARCHAR(255) NOT NULL,
    verifyBy VARCHAR(255),       
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(100),
    -- message: ข้อความปฏิเศษ
    rejectMessage TEXT
);

CREATE TABLE Registration (
  `id`        int AUTO_INCREMENT PRIMARY KEY,
  `regId`     varchar(255) NOT NULL UNIQUE,
  `eventId`   varchar(255) NOT NULL,
  `userId`    varchar(255) NOT NULL,
  `status`    varchar(100),
  `updated`   timestamp,
  `created`   timestamp
);

CREATE TABLE `Event` (
  `id`          int AUTO_INCREMENT PRIMARY KEY,
  `eventId`     varchar(255) NOT NULL UNIQUE,
  `organizeId`  varchar(255) NOT NULL,
  `cover`       varchar(255),
  `morePics`    text,
  `title`       varchar(100),
  `description` text,
  `venue`       varchar(20),
  `maximum`     json,
  `type`        varchar(10),
  `link`        varchar(255),
  `start`       varchar(255),
  `end`         varchar(255),
  `location`    json,
  `created`     timestamp,
  `updated`     timestamp
);

CREATE TABLE `User` (
  `id`          int AUTO_INCREMENT PRIMARY KEY,
  `userId`      varchar(255) NOT NULL UNIQUE,
  `username`    varchar(100),
  `password`    varchar(100),
  `email`       varchar(100),
  `name`        varchar(100),
  `gender`      varchar(50),
  `education`   varchar(100),
  `telno`       varchar(50),
  `birth`       date,
  `created`     timestamp,
  `updated`     timestamp
);

ALTER TABLE `Attendance` ADD CONSTRAINT `Attendance_regId_fk` FOREIGN KEY (`regId`) REFERENCES `Registration` (`regId`) ON DELETE CASCADE;
-- ALTER TABLE `Attendance` ADD CONSTRAINT `Attendance_regId_fk` FOREIGN KEY (`regId`) REFERENCES `Registration` (`regId`) ON DELETE CASCADE;
-- ALTER TABLE `Attendance` ADD CONSTRAINT `Attendance_verifyBy_fk` FOREIGN KEY (`verifyBy`) REFERENCES `Author` (`authorId`) ON DELETE CASCADE;
ALTER TABLE `Author` ADD CONSTRAINT `Author_eventId_fk` FOREIGN KEY (`eventId`) REFERENCES `Event` (`eventId`) ON DELETE CASCADE;
ALTER TABLE `Author` ADD CONSTRAINT `Author_stafId_fk` FOREIGN KEY (`authorId`) REFERENCES `User` (`userId`) ON DELETE CASCADE;
ALTER TABLE `Event` ADD CONSTRAINT `Event_organizeId_fk` FOREIGN KEY (`organizeId`) REFERENCES `User` (`userId`) ON DELETE CASCADE;
ALTER TABLE `Registration` ADD CONSTRAINT `Registration_eventId_fk` FOREIGN KEY (`eventId`) REFERENCES `Event` (`eventId`) ON DELETE CASCADE;
ALTER TABLE `Registration` ADD CONSTRAINT `Registration_userId_fk` FOREIGN KEY (`userId`) REFERENCES `User` (`userId`) ON DELETE CASCADE;