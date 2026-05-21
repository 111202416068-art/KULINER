<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id'    => ['type' => 'VARCHAR', 'constraint' => '50'],
            'user_id'     => ['type' => 'INT', 'constraint' => 11],
            'kuliner_id'  => ['type' => 'INT', 'constraint' => 11],
            'nominal'     => ['type' => 'INT', 'constraint' => 11],
            'status_bayar'=> ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'pending'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        
        $this->forge->addKey('order_id', true);
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}