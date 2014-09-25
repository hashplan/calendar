<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_venues_add_is_sticky_column extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('venues', array(
            'is_sticky' => array(
                'type' => 'TINYINT',
                'constraint' => 0,
                'default' => 0,
                'unsigned' => TRUE,
                'null' => TRUE
            ),
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('venues', 'is_sticky');
    }

}