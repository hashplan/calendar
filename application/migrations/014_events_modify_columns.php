<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Events_modify_columns extends CI_Migration {

	public function up() {
		$this->dbforge->modify_column('events', array(
			'stubhub_url' => array(
				'name' => 'booking_link',
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE,
			),
		));

		$this->dbforge->add_column('events', array(
            'status' => array(
                'type' => 'ENUM',
                'constraint' => "'active', 'cancelled'",
   				'default'=> "active",
            ),
        ));

		$this->dbforge->add_column('metroareas', array(
            'picture_path' => array(
                'type' => 'TEXT',
   				'null' => TRUE,
            ),
        ));

	}

	public function down() {
		$this->dbforge->modify_column('events', array(
			'stubhub_url' => array(
				'name' => 'stubhub_url',
				'type' => 'VARCHAR',
				'constraint' => 500,
				'null' => TRUE,
			),
		));

		$this->dbforge->drop_column('events', 'status');
		$this->dbforge->drop_column('metroareas', 'picture_path');
	}

}