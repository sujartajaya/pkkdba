<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usersaddstatus extends Migration
{
	public function up()
	{
		$this->forge->addColumn('users', [
			'type VARCHAR(50)  AFTER password'
		]);
	}

	public function down()
	{
		$this->forge->dropColumn('users', 'type');
	}
}
