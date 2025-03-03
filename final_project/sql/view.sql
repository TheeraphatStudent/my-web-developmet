CREATE VIEW EventUserCount AS
SELECT 
    e.eventId,
    e.title AS eventTitle,
    COUNT(r.userId) AS totalParticipants
FROM Event e
LEFT JOIN Registration r ON e.eventId = r.eventId
GROUP BY e.eventId;