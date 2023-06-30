<?php

use Illuminate\Database\Seeder;

class Admin_usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('admin_users')->insert([
            'name' => 'SupperAdmin',
            'email' => 'admin@test.com',
            'password' => bcrypt('1212123'),
            'avata_img' => 'admin.png',            
        ]);
    }
}
