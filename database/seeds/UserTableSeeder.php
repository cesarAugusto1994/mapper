<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
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

        $admin = new User();
        $admin->name = 'Cesar Augusto';
        $admin->email = 'cezzaar@gmail.com';
        $admin->password = bcrypt('mestre');
        $admin->do_task = true;
        $admin->department_id = 1;
        $admin->change_password = true;
        $admin->save();
        $admin->roles()->attach($role_admin);

        $itens = [
            [
              'name' => 'Wanessa',
              'email' => 'dpessoal@cossil.com.br'
            ],
            [
              'name' => 'Paulo Henrique',
              'email' => 'paulohenrique@cossil.com.br'
            ],
            [
              'name' => 'Mariani',
              'email' => 'mariani@cossil.com.br'
            ],
        ];

        foreach ($itens as $item) {
            $user = new User();
            $user->name = $item['name'];
            $user->email = $item['email'];
            $user->password = bcrypt(123);
            $user->department_id = 1;
            $user->weekly_workload = 44;
            $user->change_password = true;
            $user->save();
            $user->roles()->attach($role_user);
        }

    }
}
