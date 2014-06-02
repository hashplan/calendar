<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_User_events_add_owner_support extends CI_Migration {

	public function up() {
		$this->dbforge->drop_column('user_events', 'deleted');
		$this->dbforge->add_column('user_events', array(
			'ownerId integer',
		));
	}

	public function down() {
		$this->dbforge->add_column('user_events', array(
			'deleted tinyint(4) NOT NULL',
		));
		$this->dbforge->drop_column('user_events', 'ownerId');
	}

}