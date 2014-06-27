<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Users_add_avatar_path_column extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('users', array(
			'avatar_path' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
		));
	}

	public function down() {
		$this->dbforge->drop_column('users', 'avatar_path');
	}

}