<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modify_insertby_updateby_field extends CI_Migration
{
    public function up()
    {
        $this->db->query('DELETE FROM `user_events` WHERE eventId IN (792,501,818);');
        $this->db->query('ALTER TABLE `user_events` MODIFY id INT NOT NULL;');
        $this->db->query('ALTER TABLE `user_events` DROP PRIMARY KEY;');
        $this->dbforge->drop_column('user_events', 'id');

        $this->db->query('ALTER TABLE `user_events` ADD PRIMARY KEY (userId, eventId);');

        $this->db->query('ALTER TABLE `user_events` DROP INDEX userId;');

        $this->dbforge->drop_column('user_events', 'insertedby');
        $this->dbforge->drop_column('user_events', 'updatedby');
        $this->dbforge->drop_column('user_events', 'updatedon');

        $fields = array(
            'insertedby' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'default' => NULL,
                'null' => TRUE
            ),
            'updatedby' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'default' => NULL,
                'null' => TRUE
            ),
        );
        $this->dbforge->modify_column('venues', $fields);
        $this->dbforge->modify_column('events', $fields);

    }

    public function down()
    {

    }

}