<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\UserModel;

        $users = [
            'email' => 'ademiro@admin.com',
            'name' => 'ademiro',
            'username' => 'cordylus',
            'password' => '123qweasd',
            'is_admin' => true,
            'active' => true,
        ];

        $userModel->skipValidation(true)->protect(false)->insert($users);

        // dd($userModel->errors());
    }
}
