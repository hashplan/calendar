<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_base extends CI_Migration {

	public function up() {

		## Create Table areas
		$this->dbforge->add_field("`id` int(11) NOT NULL ");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`area` varchar(45) NULL ");
		$this->dbforge->add_field("`cityid` int(11) NULL ");
		$this->dbforge->create_table("areas", TRUE);
		$this->db->query('ALTER TABLE  `areas` ENGINE = InnoDB');
		## Create Table category
		$this->dbforge->add_field("`categoryId` int(11) NOT NULL ");
		$this->dbforge->add_field("`category` varchar(255) NOT NULL ");
		$this->dbforge->create_table("category", TRUE);
		$this->db->query('ALTER TABLE  `category` ENGINE = InnoDB');
		## Create Table ci_sessions
		$this->dbforge->add_field("`session_id` varchar(40) NOT NULL ");
		$this->dbforge->add_key("session_id",true);
		$this->dbforge->add_field("`ip_address` varchar(45) NOT NULL ");
		$this->dbforge->add_field("`user_agent` varchar(120) NOT NULL ");
		$this->dbforge->add_field("`last_activity` int(10) unsigned NOT NULL ");
		$this->dbforge->add_field("`user_data` text NOT NULL ");
		$this->dbforge->create_table("ci_sessions", TRUE);
		$this->db->query('ALTER TABLE  `ci_sessions` ENGINE = InnoDB');
		## Create Table cities
		$this->dbforge->add_field("`id` int(11) NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`city` varchar(100) NULL ");
		$this->dbforge->add_field("`stateid` int(11) NULL ");
		$this->dbforge->add_field("`metroid` int(11) NULL ");
		$this->dbforge->create_table("cities", TRUE);
		$this->db->query('ALTER TABLE  `cities` ENGINE = InnoDB');
		## Create Table countries
		$this->dbforge->add_field("`id` int(11) NOT NULL ");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`country` varchar(45) NULL ");
		$this->dbforge->add_field("`phonecode` int(11) NULL ");
		$this->dbforge->add_field("`lable` varchar(45) NULL ");
		$this->dbforge->create_table("countries", TRUE);
		$this->db->query('ALTER TABLE  `countries` ENGINE = InnoDB');
		## Create Table crawlstatus
		$this->dbforge->add_field("`id` int(11) NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`crawler` varchar(200) NOT NULL ");
		$this->dbforge->add_field("`datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ");
		$this->dbforge->add_field("`city` varchar(200) NOT NULL ");
		$this->dbforge->create_table("crawlstatus", TRUE);
		$this->db->query('ALTER TABLE  `crawlstatus` ENGINE = InnoDB');
		## Create Table eventcategories
		$this->dbforge->add_field("`id` int(11) NOT NULL ");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`name` varchar(45) NULL ");
		$this->dbforge->create_table("eventcategories", TRUE);
		$this->db->query('ALTER TABLE  `eventcategories` ENGINE = InnoDB');
		## Create Table events
		$this->dbforge->add_field("`id` int(11) NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`name` varchar(500) NULL ");
		$this->dbforge->add_field("`description` varchar(8000) NULL ");
		$this->dbforge->add_field("`typeId` int(11) NULL ");
		$this->dbforge->add_field("`datetime` datetime NULL ");
		$this->dbforge->add_field("`venueId` int(11) NULL ");
		$this->dbforge->add_field("`stubhub_url` varchar(500) NOT NULL ");
		$this->dbforge->add_field("`insertedon` datetime NULL ");
		$this->dbforge->add_field("`insertedby` varchar(200) NULL ");
		$this->dbforge->add_field("`updatedon` datetime NULL ");
		$this->dbforge->add_field("`updatedby` varchar(200) NULL ");
		$this->dbforge->create_table("events", TRUE);
		$this->db->query('ALTER TABLE  `events` ENGINE = InnoDB');
		## Create Table holiday
		$this->dbforge->add_field("`holidayid` int(4) NOT NULL auto_increment");
		$this->dbforge->add_key("holidayid",true);
		$this->dbforge->add_field("`holiday` varchar(50) NOT NULL ");
		$this->dbforge->create_table("holiday", TRUE);
		$this->db->query('ALTER TABLE  `holiday` ENGINE = InnoDB');
		## Create Table holiday_date
		$this->dbforge->add_field("`holidayid` int(4) NOT NULL auto_increment");
		$this->dbforge->add_field("`holiday_date` date NOT NULL ");
		$this->dbforge->create_table("holiday_date", TRUE);
		$this->db->query('ALTER TABLE  `holiday_date` ENGINE = InnoDB');
		## Create Table metroareas
		$this->dbforge->add_field("`id` int(11) NOT NULL ");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`city` varchar(45) NULL ");
		$this->dbforge->add_field("`stateid` varchar(45) NULL ");
		$this->dbforge->add_field("`PollstarID` int(11) NULL ");
		$this->dbforge->add_field("`Crawl` int(11) NULL ");
		$this->dbforge->create_table("metroareas", TRUE);
		$this->db->query('ALTER TABLE  `metroareas` ENGINE = InnoDB');
		## Create Table migrations
		$this->dbforge->add_field("`version` int(3) NOT NULL ");
		$this->dbforge->create_table("migrations", TRUE);
		$this->db->query('ALTER TABLE  `migrations` ENGINE = InnoDB');
		## Create Table pollstar_cities
		$this->dbforge->add_field("`psCityId` int(11) NOT NULL ");
		$this->dbforge->add_field("`City` varchar(100) NULL ");
		$this->dbforge->add_field("`stateId` int(11) NULL ");
		$this->dbforge->add_field("`insertedon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ");
		$this->dbforge->create_table("pollstar_cities", TRUE);
		$this->db->query('ALTER TABLE  `pollstar_cities` ENGINE = InnoDB');
		## Create Table restaurants
		$this->dbforge->add_field("`ID` bigint(11) NULL ");
		$this->dbforge->add_field("`Category` varchar(1500) NULL ");
		$this->dbforge->add_field("`Sub Category` varchar(1500) NULL ");
		$this->dbforge->add_field("`Name` varchar(1500) NULL ");
		$this->dbforge->add_field("`Address` varchar(1500) NULL ");
		$this->dbforge->add_field("`City` varchar(1500) NULL ");
		$this->dbforge->add_field("`State` varchar(1500) NULL ");
		$this->dbforge->add_field("`Zip` int(11) NULL ");
		$this->dbforge->add_field("`Phone` varchar(100) NULL ");
		$this->dbforge->add_field("`Fax` varchar(100) NULL ");
		$this->dbforge->add_field("`Email` varchar(1500) NULL ");
		$this->dbforge->add_field("`URL` varchar(1500) NULL ");
		$this->dbforge->add_field("`AreaCode` varchar(100) NULL ");
		$this->dbforge->add_field("`FIPS` varchar(100) NULL ");
		$this->dbforge->add_field("`TimeZone` varchar(1500) NULL ");
		$this->dbforge->add_field("`DST` varchar(1500) NULL ");
		$this->dbforge->add_field("`Lat` varchar(1500) NULL ");
		$this->dbforge->add_field("`Long` varchar(1500) NULL ");
		$this->dbforge->add_field("`MSA` varchar(1500) NULL ");
		$this->dbforge->add_field("`PMSA` varchar(1500) NULL ");
		$this->dbforge->add_field("`County` varchar(1500) NULL ");
		$this->dbforge->add_field("`CONTACTNAME` varchar(1500) NULL ");
		$this->dbforge->add_field("`Cuisines` text NULL ");
		$this->dbforge->add_field("`Hours` float NULL ");
		$this->dbforge->add_field("`Payment` text NULL ");
		$this->dbforge->add_field("`Others Category` text NULL ");
		$this->dbforge->create_table("restaurants", TRUE);
		$this->db->query('ALTER TABLE  `restaurants` ENGINE = InnoDB');
		## Create Table states
		$this->dbforge->add_field("`id` int(11) NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`countryid` int(11) NULL ");
		$this->dbforge->add_field("`state` varchar(45) NULL ");
		$this->dbforge->add_field("`abbrev` varchar(45) NULL ");
		$this->dbforge->create_table("states", TRUE);
		$this->db->query('ALTER TABLE  `states` ENGINE = InnoDB');
		## Create Table stubhub
		$this->dbforge->add_field("`id` int(11) NOT NULL ");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`event` varchar(500) NULL ");
		$this->dbforge->add_field("`date` varchar(45) NULL ");
		$this->dbforge->add_field("`venue` varchar(500) NULL ");
		$this->dbforge->create_table("stubhub", TRUE);
		$this->db->query('ALTER TABLE  `stubhub` ENGINE = InnoDB');
		## Create Table subcategory
		$this->dbforge->add_field("`subcategoryId` int(11) NOT NULL ");
		$this->dbforge->add_field("`categoryId` int(11) NOT NULL ");
		$this->dbforge->add_field("`subcategory` varchar(255) NOT NULL ");
		$this->dbforge->create_table("subcategory", TRUE);
		$this->db->query('ALTER TABLE  `subcategory` ENGINE = InnoDB');
		## Create Table user_events
		$this->dbforge->add_field("`id` int(11) NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`userId` int(11) NOT NULL ");
		$this->dbforge->add_field("`eventId` int(11) NOT NULL ");
		$this->dbforge->add_field("`deleted` tinyint(4) NOT NULL ");
		$this->dbforge->add_field("`insertedon` datetime NULL ");
		$this->dbforge->add_field("`insertedby` varchar(200) NULL ");
		$this->dbforge->add_field("`updatedon` datetime NULL ");
		$this->dbforge->add_field("`updatedby` varchar(200) NULL ");
		$this->dbforge->create_table("user_events", TRUE);
		$this->db->query('ALTER TABLE  `user_events` ENGINE = InnoDB');
		## Create Table user_profile
		$this->dbforge->add_field("`userId` int(11) NOT NULL ");
		$this->dbforge->add_field("`categoryId` int(11) NOT NULL ");
		$this->dbforge->add_field("`subcategoryId` int(11) NOT NULL ");
		$this->dbforge->create_table("user_profile", TRUE);
		$this->db->query('ALTER TABLE  `user_profile` ENGINE = InnoDB');
		## Create Table user_settings
		$this->dbforge->add_field("`userId` int(11) NOT NULL ");
		$this->dbforge->add_key("userId",true);
		$this->dbforge->add_field("`metroId` int(11) NULL ");
		$this->dbforge->create_table("user_settings", TRUE);
		$this->db->query('ALTER TABLE  `user_settings` ENGINE = InnoDB');
		## Create Table venues
		$this->dbforge->add_field("`id` int(11) NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`name` varchar(250) NULL ");
		$this->dbforge->add_field("`address` varchar(500) NULL ");
		$this->dbforge->add_field("`city` varchar(45) NULL ");
		$this->dbforge->add_field("`cityId` int(11) NOT NULL ");
		$this->dbforge->add_field("`stateId` int(11) NULL ");
		$this->dbforge->add_field("`zip` varchar(10) NULL ");
		$this->dbforge->add_field("`phone` varchar(12) NULL ");
		$this->dbforge->add_field("`website` varchar(150) NULL ");
		$this->dbforge->add_field("`description` varchar(8000) NULL ");
		$this->dbforge->add_field("`typeId` int(11) NULL ");
		$this->dbforge->add_field("`insertedon` datetime NULL ");
		$this->dbforge->add_field("`insertedby` varchar(200) NULL ");
		$this->dbforge->add_field("`updatedon` datetime NULL ");
		$this->dbforge->add_field("`updatedby` varchar(200) NULL ");
		$this->dbforge->create_table("venues", TRUE);
		$this->db->query('ALTER TABLE  `venues` ENGINE = InnoDB');
		## Create Table venuetypes
		$this->dbforge->add_field("`id` int(11) NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`type` varchar(50) NULL ");
		$this->dbforge->create_table("venuetypes", TRUE);
		$this->db->query('ALTER TABLE  `venuetypes` ENGINE = InnoDB');
	 }

	public function down()	{
		### Drop table areas ##
		$this->dbforge->drop_table("areas", TRUE);
		### Drop table category ##
		$this->dbforge->drop_table("category", TRUE);
		### Drop table ci_sessions ##
		$this->dbforge->drop_table("ci_sessions", TRUE);
		### Drop table cities ##
		$this->dbforge->drop_table("cities", TRUE);
		### Drop table countries ##
		$this->dbforge->drop_table("countries", TRUE);
		### Drop table crawlstatus ##
		$this->dbforge->drop_table("crawlstatus", TRUE);
		### Drop table eventcategories ##
		$this->dbforge->drop_table("eventcategories", TRUE);
		### Drop table events ##
		$this->dbforge->drop_table("events", TRUE);
		### Drop table holiday ##
		$this->dbforge->drop_table("holiday", TRUE);
		### Drop table holiday_date ##
		$this->dbforge->drop_table("holiday_date", TRUE);
		### Drop table metroareas ##
		$this->dbforge->drop_table("metroareas", TRUE);
		### Drop table migrations ##
		$this->dbforge->drop_table("migrations", TRUE);
		### Drop table pollstar_cities ##
		$this->dbforge->drop_table("pollstar_cities", TRUE);
		### Drop table restaurants ##
		$this->dbforge->drop_table("restaurants", TRUE);
		### Drop table states ##
		$this->dbforge->drop_table("states", TRUE);
		### Drop table stubhub ##
		$this->dbforge->drop_table("stubhub", TRUE);
		### Drop table subcategory ##
		$this->dbforge->drop_table("subcategory", TRUE);
		### Drop table user_events ##
		$this->dbforge->drop_table("user_events", TRUE);
		### Drop table user_profile ##
		$this->dbforge->drop_table("user_profile", TRUE);
		### Drop table user_settings ##
		$this->dbforge->drop_table("user_settings", TRUE);
		### Drop table venues ##
		$this->dbforge->drop_table("venues", TRUE);
		### Drop table venuetypes ##
		$this->dbforge->drop_table("venuetypes", TRUE);

	}
}