<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Venues_add_url_column extends CI_Migration {

	public function up() {
            $this->dbforge->add_column('venues', array(
            'url' => array(
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true
            ),
        ));

	}

	public function down() {

		$this->dbforge->drop_column('venues', 'url');
	}

}