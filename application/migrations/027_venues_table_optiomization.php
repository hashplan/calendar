<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_venues_table_optiomization extends CI_Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE `venues` ADD INDEX (is_excluded, is_sticky)');
        $this->db->query('ALTER TABLE `venues` ADD INDEX (name, address, city)');
        $this->db->query('ANALYZE TABLE `areas`, `categories`, `cities`, `ci_sessions`, `countries`, `crawlstatus`, `events`, `events_deleted`, `events_favourited`, `event_categories`, `groups`, `holiday`, `holiday_date`, `login_attempts`, `metroareas`, `migrations`, `pollstar_cities`, `restaurants`, `states`, `stubhub`, `users`, `users_groups`, `user_connections`, `user_events`, `user_profile`, `user_settings`, `venues`, `venuetypes`');
        $this->db->query('OPTIMIZE TABLE `areas`, `categories`, `cities`, `ci_sessions`, `countries`, `crawlstatus`, `events`, `events_deleted`, `events_favourited`, `event_categories`, `groups`, `holiday`, `holiday_date`, `login_attempts`, `metroareas`, `migrations`, `pollstar_cities`, `restaurants`, `states`, `stubhub`, `users`, `users_groups`, `user_connections`, `user_events`, `user_profile`, `user_settings`, `venues`, `venuetypes`');

    }

    public function down()
    {
        $this->db->query('ALTER TABLE `venues` DROP INDEX is_excluded');
        $this->db->query('ALTER TABLE `venues` DROP INDEX name');
        $this->db->query('ANALYZE TABLE `areas`, `categories`, `cities`, `ci_sessions`, `countries`, `crawlstatus`, `events`, `events_deleted`, `events_favourited`, `event_categories`, `groups`, `holiday`, `holiday_date`, `login_attempts`, `metroareas`, `migrations`, `pollstar_cities`, `restaurants`, `states`, `stubhub`, `users`, `users_groups`, `user_connections`, `user_events`, `user_profile`, `user_settings`, `venues`, `venuetypes`');
        $this->db->query('OPTIMIZE TABLE `areas`, `categories`, `cities`, `ci_sessions`, `countries`, `crawlstatus`, `events`, `events_deleted`, `events_favourited`, `event_categories`, `groups`, `holiday`, `holiday_date`, `login_attempts`, `metroareas`, `migrations`, `pollstar_cities`, `restaurants`, `states`, `stubhub`, `users`, `users_groups`, `user_connections`, `user_events`, `user_profile`, `user_settings`, `venues`, `venuetypes`');
    }

}