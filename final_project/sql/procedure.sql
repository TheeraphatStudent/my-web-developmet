-- ====================== Event - Get User by event id with regid

-- DELIMITER $$

-- CREATE PROCEDURE GetAllEventsByUserId(IN getUserId VARCHAR(255))
-- BEGIN
--     SELECT * FROM Event WHERE userId = getUserId;
-- END $$

-- DELIMITER ;

-- DELIMITER $$

-- CREATE PROCEDURE `GetAllEventsByUserId`(IN `getUserId` VARCHAR(255))
-- BEGIN
--     SELECT 
--         e.eventId,
--         e.cover,
--         e.title,
--         e.maximum,
--         e.type,
--         e.start,
--         e.status,
--         e.created,
--         COUNT(r.id) AS totalRegistrations
--     FROM Event e
--     LEFT JOIN Registration r ON e.eventId = r.eventId
--     WHERE e.organizeId = getUserId
--     GROUP BY e.eventId;

-- END$$

-- DELIMITER ;

-- ====================== Register - Get all event by user id

DELIMITER $$

CREATE PROCEDURE `GetAllEventsByUserId` (IN `getUserId` VARCHAR(255))
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

DELIMITER ;

-- ====================== User - Count all user joined on event

DELIMITER $$
CREATE PROCEDURE `CountAllEventCreatedByUserId`(
    IN `getUserId` VARCHAR(255)
)
BEGIN
    SELECT COUNT(*)
    FROM Registration r
    JOIN Event e ON r.eventId = e.eventId
    JOIN User u ON r.userId = u.userId
    WHERE e.organizeId = getUserId;
END$$
DELIMITER ;

DELIMITER $$

-- ====================== Reg - get user counter 

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
