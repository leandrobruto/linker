<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableConnect extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'requester_user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'requested_user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('requester_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('requested_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('connections');
    }

    public function down()
    {
        $this->forge->dropTable('connections');
    }
}