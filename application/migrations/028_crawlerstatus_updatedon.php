<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_crawlerstatus_updatedon extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('crawlstatus', array(
            'updatedon' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('crawlstatus', 'updatedon');
    }

}