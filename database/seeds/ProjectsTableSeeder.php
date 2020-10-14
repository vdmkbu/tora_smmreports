<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => 'test project',
            'user_id' => 2,
            'url' => 'https://vk.com/sysodmins'
        ];

        DB::table('projects')->insert($data);
    }
}
