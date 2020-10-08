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
			'username' => 'bejo',
			'nama_user' => 'Bejo Subejo',
			'password' =>  password_hash('bejodeso', PASSWORD_BCRYPT),
			'role' => 1 // Role 0 - Full Access, Role 1 - Posting Only
		]);
	}
}
