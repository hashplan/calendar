<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_add_facebook_id_to_settings extends CI_Migration {

    public function up() {
        $this->dbforge->add_column('user_settings', array(
            'fb_id' => array(
                'type' => 'INTEGER',
                'constraint' => 11,
                'null' => TRUE,
            )
        ));
    }

    public function down() {
        $this->dbforge->drop_column('user_settings', 'fb_id');
    }

}