<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Events_stubhub_url_column_nullable extends CI_Migration {

	public function up() {
		$this->dbforge->modify_column('events', array(
			'stubhub_url' => array(
				'name' => 'stubhub_url',
				'type' => 'VARCHAR',
				'constraint' => 500,
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
				'null' => FALSE,
			),
		));
	}

}