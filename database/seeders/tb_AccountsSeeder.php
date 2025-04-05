<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use App\Models\Client_Model;
use App\Models\AccountsModel;

class tb_AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userList = [
            [
                'name' => 'Henry Kim',
                'email' => 'admin@example.com',
                'role' => 'superuser',
                'password' => bcrypt('123456')

            ],
            [
                'name' => 'Chwili',
                'email' => 'moderator@example.com',
                'password' => bcrypt('123456')
            ],
        ];

        foreach ($userList as $user) {
            AccountsModel::create($user);
        }
    }
}
