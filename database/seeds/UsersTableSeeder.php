<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Member',
            'email' => 'member@test.com',
            'password' => bcrypt('member'),
            'address' => 'Ywang - BMT - DL',
            'phone' => '0123568563',
            'avata_img' => 'mem.png',
        ]);
    }
}
