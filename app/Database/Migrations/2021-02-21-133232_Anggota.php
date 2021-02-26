<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Anggota extends Migration
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
			'nik'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'unique' => true
			],
			'nama'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'tgllahir'       => [
				'type'       => 'DATE',
				'null' => true

			],
			'alanat'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'telpon'       => [
				'type'       => 'VARCHAR',
				'constraint' => '30',
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true
			],
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'unique' => true
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
		$this->forge->createTable('anggota');
	}

	public function down()
	{
		$this->forge->dropTable('anggota');
	}
}
