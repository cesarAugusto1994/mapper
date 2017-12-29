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
            'name' => 'Cesar',
            'email' => 'cezzaar@gmail.com',
            'password' => bcrypt('secret'),
            'department_id' => 3,
        ]);

        DB::table('users')->insert([
            'name' => 'Vagner',
            'email' => 'vagner@gmail.com',
            'password' => bcrypt('secret'),
            'department_id' => 2,
        ]);

        DB::table('users')->insert([
            'name' => 'Wanessa',
            'email' => 'wanessa@gmail.com',
            'password' => bcrypt('secret'),
            'department_id' => 1,
        ]);
    }
}
