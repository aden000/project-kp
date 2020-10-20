<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KomentarMigration extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_komentar' => [
				'type' 			=> 'INT',
				'constraint'	=> 11,
				'unsigned'		=> true
			],
			'id_artikel' => [
				'type'			=> 'INT',
				'constraint' 	=> 11,
				'unsigned'		=> true,
				'null'			=> true
			],
			'refer_id' => [
				'type'			=> 'INT',
				'constraint'	=> 11,
				'unsigned'		=> true,
				'null'			=> true
			],
			'nama_komentar' => [
				'type' 			=> 'VARCHAR',
				'constraint'	=> 50
			],
			'email_komentar' => [
				'type' 			=> 'VARCHAR',
				'constraint'	=> 100
			],
			'isi_komentar' => [
				'type'			=> 'TEXT'
			],
			'created_at' => [
				'type'			=> 'DATETIME',
				'null'			=> true
			],
			'created_at' => [
				'type'			=> 'DATETIME',
				'null'			=> true
			]
		]);

		$this->forge->addPrimaryKey('id_komentar');
		$this->forge->addForeignKey('id_artikel', 'artikel', 'id_artikel');

		$this->forge->createTable('komentar');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('komentar');
	}
}
