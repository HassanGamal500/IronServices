<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('administration')->insert([
            'name' => 'Admin',
            'email' => 'admin@service.com',
            'phone' => '01010101010',
            'image' => '/images/user/avatar_user.png',
            'password' => bcrypt('admin123'),
            'type' => '1'
        ]);
    }
}
