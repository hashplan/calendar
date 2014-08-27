<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_stubhub_crawler_additional_fields extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('crawlstatus', array(
			'total_event' => array(
				'type' => 'INT',
				'constraint' => 10,
                'default' => 0,
			),
            'processed_events' => array(
                'type' => 'INT',
                'constraint' => 10,
                'default' => 0,
            )
		));
	}

	public function down() {
		$this->dbforge->drop_column('crawlstatus', 'total_event');
		$this->dbforge->drop_column('crawlstatus', 'processed_events');
	}

}