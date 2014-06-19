<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Added_event_id_column_to_user_connections extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('user_connections', array(
			'eventId' => array(
				'type' => 'INT',
				'constraint' => '10',
				'null' => TRUE,
			),
		));
	}

	public function down() {
		$this->dbforge->drop_column('user_connections', 'eventId');
	}

}
