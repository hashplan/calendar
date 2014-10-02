<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_venues_modify_is_sticky_column extends CI_Migration
{
    public function up()
    {
        $this->dbforge->modify_column('venues', array(
            'is_sticky' => array(
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
        $this->dbforge->modify_column('venues', array(
            'is_sticky' => array(
                'type' => 'TINYINT',
                'constraint' => 0,
                'default' => 0,
                'unsigned' => TRUE,
                'null' => TRUE
            ),
        ));
    }

}