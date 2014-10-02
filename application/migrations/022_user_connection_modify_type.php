<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_user_connection_modify_type extends CI_Migration
{
    public function up()
    {
        $this->dbforge->modify_column('user_connections', array(
            'type' => array(
                'type' => 'ENUM',
                'constraint' => "'event_invite', 'event_invite_accept', 'friend', 'friend_request', 'removed'",
                'null' => FALSE
            ),
        ));
    }

    public function down()
    {

    }

}