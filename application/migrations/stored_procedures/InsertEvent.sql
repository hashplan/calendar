DELIMITER $$
DROP PROCEDURE IF EXISTS `InsertEvent`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertEvent`(IN `eventName` VARCHAR(400) CHARSET utf8, IN `date` VARCHAR(45) CHARSET utf8, IN `venueName` VARCHAR(400) CHARSET utf8, IN `venueCity` VARCHAR(100) CHARSET utf8, IN `venueState` VARCHAR(100) CHARSET utf8, IN `booking_url` VARCHAR(500) CHARSET utf8, IN `venue_url` VARCHAR(500) CHARSET utf8, IN `eventStatus` ENUM('active','cancelled') CHARSET utf8) NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER BEGIN
  DECLARE venueId INT;
  DECLARE venueUrl VARCHAR(500);
  DECLARE eventDateTime DATETIME;
  DECLARE eventNameClean VARCHAR(400);

  SET eventDateTime = STR_TO_DATE(date, '%Y-%m-%d %H:%i');
  SET eventNameClean = REPLACE(eventName, 'Tickets', '');
  SELECT id, IF(url IS NULL or url = '', 'empty', url) as url INTO venueId, venueUrl FROM venues where name = venueName and city = venueCity LIMIT 1;

  IF (SELECT venueId) THEN
    IF (venueUrl = 'empty') THEN UPDATE venues SET url = venue_url WHERE id = venueId; END IF;
  ELSE
    INSERT INTO venues(name, city, stateId, insertedby, insertedon, booking_url) VALUES(venueName, venueCity, (SELECT id FROM states WHERE abbrev = venueState AND countryID = 1), 'screenscrape', CURRENT_TIMESTAMP(), booking_url, venueUrl);
    SET venueId = (SELECT LAST_INSERT_ID());
  END IF;

  IF NOT EXISTS(SELECT id FROM events WHERE name = eventNameClean AND venueId = venueId AND datetime = eventDateTime)
  THEN
    INSERT INTO events (name, venueId, datetime, booking_link,insertedby, insertedon, status) VALUES(eventNameClean, venueId, eventDateTime, booking_url,'screenscrape', CURRENT_TIMESTAMP(), eventStatus);
  END IF;
END$$
DELIMITER ;