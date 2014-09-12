<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_venues_add_is_excluded_column extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('venues', array(
            'is_excluded' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'unsigned' => TRUE,
                'null' => TRUE
            ),
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('venues', 'is_excluded');
    }

}