<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Added_tables_for_favourite_deleted_events extends CI_Migration {

	public function up() {
		$this->dbforge->add_field(array(
			'eventId' => array(
				'type' => 'INT',
				'constraint' => '10',
			),
			'userId' => array(
				'type' => 'INT',
				'constraint' => '10',
			),
		));

		$this->dbforge->add_key('eventId', TRUE);
		$this->dbforge->add_key('userId', TRUE);
		$this->dbforge->create_table('events_favourited');

		$this->dbforge->add_field(array(
			'eventId' => array(
				'type' => 'INT',
				'constraint' => '10',
			),
			'userId' => array(
				'type' => 'INT',
				'constraint' => '10',
			),
		));

		$this->dbforge->add_key('eventId', TRUE);
		$this->dbforge->add_key('userId', TRUE);
		$this->dbforge->create_table('events_deleted');
	}

	public function down() {
		$this->dbforge->drop_table('events_favourited');
		$this->dbforge->drop_table('events_deleted');
	}

}