<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GaleriMigration extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_galeri' => [
				'type' 				=> 'INT',
				'unsigned'			=> true,
				'constraint'		=> 11,
				'auto_increment'	=> true
			],
			'id_user' => [
				'type' 				=> 'INT',
				'unsigned' 			=> true,
				'constraint' 		=> 11
			],
			'nama_gambar' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 100,
			]
		]);

		$this->forge->addPrimaryKey('id_galeri');
		$this->forge->addForeignKey('id_user', 'user', 'id_user');
		$this->forge->createTable('galeri');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('galeri');
	}
}
