<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Cities_renamed_columns extends CI_Migration {

	public function up() {
		$this->dbforge->modify_column('cities', array(
			'stateid' => array(
				'name' => 'stateId',
				'type' => 'INTEGER',
				'null' => TRUE,
			),
			'metroid' => array(
				'name' => 'metroId',
				'type' => 'INTEGER',
				'null' => TRUE,
			),
		));
	}

	public function down() {
		$this->dbforge->modify_column('cities', array(
			'stateId' => array(
				'name' => 'stateid',
				'type' => 'INTEGER',
				'null' => TRUE,
			),
			'metroId' => array(
				'name' => 'metroid',
				'type' => 'INTEGER',
				'null' => TRUE,
			),
		));
	}

}