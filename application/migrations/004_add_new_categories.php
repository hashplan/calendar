<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_new_categories extends CI_Migration {

	public function up() {
		// Table structure for table 'categories'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'path' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('path');
		$this->dbforge->create_table('categories');

		// Table structure for table 'event_categories'
		$this->dbforge->add_field(array(
			'event_id' => array(
				'type' => 'INT',
				'constraint' => '10',
			),
			'category_id' => array(
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => TRUE,
			),
		));
		$this->dbforge->add_key('event_id', TRUE);
		$this->dbforge->add_key('category_id', TRUE);
		$this->dbforge->create_table('event_categories');
	}

	public function down() {
		$this->dbforge->drop_table('event_categories');
		$this->dbforge->drop_table('categories');
	}
}