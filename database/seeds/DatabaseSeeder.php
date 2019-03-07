<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TaskStatusTableSeeder::class);
        $this->call(ModulesTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        // Role comes before User seeder here.
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        // User seeder will use the roles above created.
        $this->call(UserTableSeeder::class);

        $this->call(FrequencyTableSeeder::class);
        $this->call(DocumentStatusTableSeeder::class);
        
        $this->call(MapperStatusTableSeeder::class);
    }
}
