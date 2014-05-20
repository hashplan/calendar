<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Remove_old_categories extends CI_Migration {
	public function up() {
		$this->dbforge->drop_table('category');
		$this->dbforge->drop_table('eventcategories');
		$this->dbforge->drop_table('subcategory');
	}

	public function down() {
		// category
		$this->dbforge->add_field("`categoryId` int(11) NOT NULL ");
		$this->dbforge->add_field("`category` varchar(255) NOT NULL ");
		$this->dbforge->create_table("category", TRUE);
		$this->db->query('ALTER TABLE  `category` ENGINE = InnoDB');

		// eventcategories
		$this->dbforge->add_field("`id` int(11) NOT NULL ");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`name` varchar(45) NULL ");
		$this->dbforge->create_table("eventcategories", TRUE);
		$this->db->query('ALTER TABLE  `eventcategories` ENGINE = InnoDB');

		// subcategory
		$this->dbforge->add_field("`subcategoryId` int(11) NOT NULL ");
		$this->dbforge->add_field("`categoryId` int(11) NOT NULL ");
		$this->dbforge->add_field("`subcategory` varchar(255) NOT NULL ");
		$this->dbforge->create_table("subcategory", TRUE);
		$this->db->query('ALTER TABLE  `subcategory` ENGINE = InnoDB');
	}
}