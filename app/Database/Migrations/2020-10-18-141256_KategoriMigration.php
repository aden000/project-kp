<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KategoriMigration extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_kategori'	=> [
				'type'				=> 'INT',
				'constraint'		=> 11,
				'unsigned'			=> true,
				'auto_increment'	=> true
			],
			'nama_kategori'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> 50
			]
		]);

		$this->forge->addPrimaryKey('id_kategori');
		$this->forge->createTable('kategori');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('kategori');
	}
}
