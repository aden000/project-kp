<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
	public function run()
	{
		//
		$model = new UserModel();
		$model->insert([
			'username' => 'admin',
			'nama_user' => 'Administrator',
			'password' =>  password_hash('admin', PASSWORD_BCRYPT),
			'role' => 0 // Role 0 - Full Access, Role 1 - Posting Only
		]);
	}
}
