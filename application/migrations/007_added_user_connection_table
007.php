<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Added_user_connection_table extends CI_Migration {

	public function up() {
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '10',
				'auto_increment' => TRUE,
			),
			'userId' => array(
				'type' => 'INT',
				'constraint' => '10',
			),
			'connectionUserId' => array(
				'type' => 'INT',
				'constraint' => '10',
			),
			'type' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			),
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('userId');
		$this->dbforge->add_key('connectionUserId');
		$this->dbforge->create_table('user_connections');
	}

	public function down() {
		$this->dbforge->drop_table('user_connections');
	}

}