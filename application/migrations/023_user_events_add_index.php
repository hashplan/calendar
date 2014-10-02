<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_user_events_add_index extends CI_Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE `user_events` ADD INDEX (userId, eventId)');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `user_events` DROP INDEX userId');
    }

}