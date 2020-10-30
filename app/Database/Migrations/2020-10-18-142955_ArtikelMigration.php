<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ArtikelMigration extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_artikel' => [
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
			'judul_artikel' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 255,
			],
			'slug' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 255,
			],
			'link_gambar' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 100,
			],
			'isi_artikel' => [
				'type'				=> 'MEDIUMTEXT'
			],
			'id_kategori' => [
				'type' 				=> 'INT',
				'unsigned'			=> true,
				'constraint'		=> 11
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
			],
			'published_at'	=> [
				'type'				=> 'DATETIME',
				'null'				=> true
			],
		]);

		$this->forge->addPrimaryKey('id_artikel');
		$this->forge->addForeignKey('id_user', 'user', 'id_user');
		$this->forge->addForeignKey('id_kategori', 'kategori', 'id_kategori');
		$this->forge->addUniqueKey('slug');

		$this->forge->createTable('artikel');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('artikel');
	}
}
