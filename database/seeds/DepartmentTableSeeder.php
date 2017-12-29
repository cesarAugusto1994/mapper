<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => 'RH',
        ]);

        DB::table('departments')->insert([
            'name' => 'Contabil',
        ]);

        DB::table('departments')->insert([
            'name' => 'TI',
        ]);
    }
}
