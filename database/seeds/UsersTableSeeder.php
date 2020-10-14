<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'admin',
                'email' => 'admin@admin.loc',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'name' => 'user',
                'email' => 'user@user.loc',
                'password' => bcrypt('user'),
                'role' => 'user',
                'status' => 'active'
            ]
        ];

        DB::table('users')->insert($data);
    }
}
