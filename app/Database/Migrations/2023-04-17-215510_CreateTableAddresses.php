<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAddresses extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'street' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'number' => [
                'type' => 'INT',
                'constraint' => '5',
            ],
            'complement' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'district' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'post_code' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('addresses');
    }

    public function down()
    {
        $this->forge->dropTable('addresses');
    }
}
