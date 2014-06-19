<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Added_public_column_to_event extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('events', array(
			'is_public' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'default' => 0,
			),
			'ownerId' => array(
				'type' => 'INT',
				'constraint' => '10',
				'null' => TRUE,
			),
		));
	}

	public function down() {
		$this->dbforge->drop_column('events', 'is_public');
		$this->dbforge->drop_column('events', 'ownerId');
	}

}