<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_update_stubhub_booking_url extends CI_Migration
{
    public function up()
    {
        $this->db->trans_start();
        $this->db->query("
                UPDATE `calendar_ext`.`events`
                SET `booking_link` = CONCAT('http://www.stubhub.com', `booking_link`)
                WHERE LOCATE('http://www.stubhub.com', `booking_link`) = '' OR LOCATE('http://www.stubhub.com', `booking_link`) IS NULL;
        ");
        $this->db->trans_complete();
    }

    public function down()
    {
        $this->db->trans_start();
        $this->db->query("
                UPDATE `calendar_ext`.`events`
                SET `booking_link` = REPLACE(`booking_link`, 'http://www.stubhub.com', '')
                WHERE LOCATE('http://www.stubhub.com', `booking_link`) != '' AND  LOCATE('http://www.stubhub.com', `booking_link`) IS NOT NULL;
        ");
    }

}