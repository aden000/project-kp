<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserMigration extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_user'	=> [
				'type' 				=> 'INT',
				'constraint'		=> 11,
				'unsigned'			=> TRUE,
				'auto_increment' 	=> true
			],
			'nama_user'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> 50
			],
			'username'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> 30
			],
			'password'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> 100
			],
			'role' 		=> [
				'type'				=> 'INT',
				'constraint'		=> 11,
			],
			'created_at'	=> [
				'type'				=> 'DATETIME',
				'null'				=> true
			],
			'updated_at'	=> [
				'type'				=> 'DATETIME',
				'null'				=> true
			],
			'deleted_at'	=> [
				'type'				=> 'DATETIME',
				'null'				=> true
			]
		]);

		$this->forge->addPrimaryKey('id_user');
		$this->forge->addUniqueKey('username');
		$this->forge->createTable('user');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('user');
	}
}
