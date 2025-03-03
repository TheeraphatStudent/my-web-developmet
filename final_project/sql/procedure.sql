-- Event
DELIMITER $$

CREATE PROCEDURE GetAllEventsByUserId(IN getUserId VARCHAR(255))
BEGIN
    SELECT * FROM Event WHERE userId = getUserId;
END $$

DELIMITER ;

-- Register
