<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\People;

use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::whereName('Administrador')->first();
        $userRole = Role::whereName('Usuario')->first();
        $permissions = Permission::pluck('id');

        $faker = Faker\Factory::create();

        // Seed test admin
        $seededAdminEmail = 'admin@admin.com';
        $user = User::where('email', '=', $seededAdminEmail)->first();
        if ($user === null) {

            $name = $faker->name;

            //$avatarlocation = storage_path('avatars').'/avatars/avatar-'.str_slug($name).'.png';
            $avatar = \Avatar::create($name)->toBase64();

            $person = People::create([
              'name' => $name,
              'department_id'=> 1,
              'occupation_id'=> 1,
              'cpf' => '12345678987'
            ]);

            $user = User::create([
              'nick'                           => str_slug($name),
              'email'                          => $seededAdminEmail,
              'password'                       => Hash::make('123123'),
              'avatar' => $avatar,
              'do_task' => false,
              'person_id' => $person->id,

              'login_soc' => 'cesar.sousa',
              'password_soc' => 'cesar1507',
              'id_soc' => '6662',

            ]);

            //$user->profile()->save($profile);
            $user->attachRole($adminRole);

            if($adminRole->id == 1) {
                $user->syncPermissions($permissions);
            }

            $user->save();
        }

        // Seed test user
        $user = User::where('email', '=', 'user@user.com')->first();
        if ($user === null) {

            $name = $faker->name;

            $avatar = \Avatar::create($name)->toBase64();

            $person = People::create([
              'name' => $name,
              'department_id'=> 1,
              'occupation_id'=> 1,
              'cpf' => '12345678987'
            ]);

            $user = User::create([
              'nick'                           => str_slug($name),
              'email'                          => 'user@user.com',
              'password'                       => Hash::make('123123'),
              'avatar' => $avatar,
              'do_task' => true,
              'person_id' => $person->id,

              'login_soc' => 'cesar.sousa',
              'password_soc' => 'cesar1507',
              'id_soc' => '6662',

            ]);

            //$user->profile()->save(new Profile());
            $user->attachRole($userRole);
            $user->save();
        }

    }
}
