<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'user')->first();
        $role_admin  = Role::where('name', 'admin')->first();

        $admin = new User();
        $admin->name = 'Administrador';
        $admin->email = 'admin@admin.com';
        $admin->password = bcrypt('secret');
        $admin->do_task = false;
        $admin->department_id = 1;
        $admin->save();
        $admin->roles()->attach($role_admin);

        $user = new User();
        $user->name = 'Usuario';
        $user->email = 'user@user.com';
        $user->password = bcrypt('secret');
        $user->department_id = 1;
        $user->save();
        $user->roles()->attach($role_user);
    }
}
