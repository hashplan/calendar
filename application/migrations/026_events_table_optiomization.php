<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_events_table_optiomization extends CI_Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE `events` ADD INDEX (status)');
        $this->db->query('ALTER TABLE `events` ADD INDEX (ownerId, is_public)');
        $this->db->query('ANALYZE TABLE `areas`, `categories`, `cities`, `ci_sessions`, `countries`, `crawlstatus`, `events`, `events_deleted`, `events_favourited`, `event_categories`, `groups`, `holiday`, `holiday_date`, `login_attempts`, `metroareas`, `migrations`, `pollstar_cities`, `restaurants`, `states`, `stubhub`, `users`, `users_groups`, `user_connections`, `user_events`, `user_profile`, `user_settings`, `venues`, `venuetypes`');
        $this->db->query('OPTIMIZE TABLE `areas`, `categories`, `cities`, `ci_sessions`, `countries`, `crawlstatus`, `events`, `events_deleted`, `events_favourited`, `event_categories`, `groups`, `holiday`, `holiday_date`, `login_attempts`, `metroareas`, `migrations`, `pollstar_cities`, `restaurants`, `states`, `stubhub`, `users`, `users_groups`, `user_connections`, `user_events`, `user_profile`, `user_settings`, `venues`, `venuetypes`');

    }

    public function down()
    {
        $this->db->query('ALTER TABLE `events` DROP INDEX status');
        $this->db->query('ALTER TABLE `events` DROP INDEX ownerId');
        $this->db->query('ANALYZE TABLE `areas`, `categories`, `cities`, `ci_sessions`, `countries`, `crawlstatus`, `events`, `events_deleted`, `events_favourited`, `event_categories`, `groups`, `holiday`, `holiday_date`, `login_attempts`, `metroareas`, `migrations`, `pollstar_cities`, `restaurants`, `states`, `stubhub`, `users`, `users_groups`, `user_connections`, `user_events`, `user_profile`, `user_settings`, `venues`, `venuetypes`');
        $this->db->query('OPTIMIZE TABLE `areas`, `categories`, `cities`, `ci_sessions`, `countries`, `crawlstatus`, `events`, `events_deleted`, `events_favourited`, `event_categories`, `groups`, `holiday`, `holiday_date`, `login_attempts`, `metroareas`, `migrations`, `pollstar_cities`, `restaurants`, `states`, `stubhub`, `users`, `users_groups`, `user_connections`, `user_events`, `user_profile`, `user_settings`, `venues`, `venuetypes`');
    }

}