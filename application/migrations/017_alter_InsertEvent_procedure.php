<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Alter_InsertEvent_procedure  extends CI_Migration {

	public function up() {

            $query =  <<<EOD
   
        CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertEvent`(IN `eventName` VARCHAR(400), IN `date` VARCHAR(45), IN `venueName` VARCHAR(400), IN `venueCity` VARCHAR(100), IN `venueState` VARCHAR(100), IN `booking_url` VARCHAR(500))
        BEGIN







        Declare venueId int;

        Declare venueUrl varchar(500);

        Declare eventDateTime datetime;

        Declare eventNameClean varchar(400);





        set eventDateTime = STR_TO_DATE(date, '%Y-%m-%d %H:%i');

        set eventNameClean = replace(eventName, 'Tickets', '');



        If exists(select * from venues where name = venueName and city = venueCity) THEN
                set venueId = (select id from venues where name = venueName and city = venueCity LIMIT 1);
                set venueUrl = (SELECT IF(url IS NULL or url = '', 'empty', url) as url FROM venues where id = venueId);
                IF venueUrl = 'empty' THEN 
                        update venues set url = booking_url where id = venueId;
                end if;

        Else

           insert into venues(name, city, stateId, insertedby, insertedon, url) values(venueName, venueCity, (select id from states where abbrev = venueState and countryID = 1), 'screenscrape', CURRENT_TIMESTAMP(), booking_url);

           set venueId = (select LAST_INSERT_ID());

        END IF;







        If not exists(select * from events where name = eventNameClean and venueId = venueId and datetime = eventDateTime) THEN

          insert into events (name, venueId, datetime, booking_link,insertedby, insertedon) values(eventNameClean, venueId, eventDateTime, booking_link,'screenscrape', CURRENT_TIMESTAMP());

        END IF;







        END
        
EOD;

        $this->db->query($query);

}
                    

	public function down() {

		$query = <<<EOD
DELIMITER $$
DROP PROCEDURE IF EXISTS InsertEvent $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertEvent`(IN `eventName` VARCHAR(400), IN `date` VARCHAR(45), IN `venueName` VARCHAR(400), IN `venueCity` VARCHAR(100), IN `venueState` VARCHAR(100), IN `stubhub_url` VARCHAR(500))
BEGIN







Declare venueId int;

Declare eventDateTime datetime;

Declare eventNameClean varchar(400);





set eventDateTime = STR_TO_DATE(date, '%Y-%m-%d %H:%i');

set eventNameClean = replace(eventName, 'Tickets', '');



If exists(select * from venues where name = venueName and city = venueCity) THEN

   set venueId = (select id from venues where name = venueName and city = venueCity LIMIT 1);

Else

   insert into venues(name, city, stateId, insertedby, insertedon) values(venueName, venueCity, (select id from states where abbrev = venueState and countryID = 1), 'screenscrape', CURRENT_TIMESTAMP());

   set venueId = (select LAST_INSERT_ID());

END IF;







If not exists(select * from events where name = eventNameClean and venueId = venueId and datetime = eventDateTime) THEN

  insert into events (name, venueId, datetime, stubhub_url,insertedby, insertedon) values(eventNameClean, venueId, eventDateTime, stubhub_url,'screenscrape', CURRENT_TIMESTAMP());

END IF;







END$$
DELIMITER;
EOD;

        $this->db->query($query);
                
	}

}

