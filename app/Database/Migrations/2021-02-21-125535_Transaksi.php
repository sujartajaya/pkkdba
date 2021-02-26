<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'nonota'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' => true

			],
			'tgltransaksi'       => [
				'type'       => 'DATE',

			],
			'jumlah'       => [
				'type'       => 'DOUBLE',
			],
			'type'       => [
				'type'       => 'VARCHAR',
				'constraint' => '1',
			],
			'keterangan' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'input' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('transaksi');
	}

	public function down()
	{
		$this->forge->dropTable('transaksi');
	}
}
