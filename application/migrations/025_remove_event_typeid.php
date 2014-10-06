<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_remove_event_typeid extends CI_Migration
{
    public function up()
    {
        $this->dbforge->drop_column('events', 'typeId');

    }

    public function down()
    {
        $this->dbforge->modify_column('events', array(
            'typeId' => array(
                'type' => 'TINYINT',
                'constraint' => 2,
                'default' => NULL,
                'null' => TRUE
            ),
        ));
    }

}