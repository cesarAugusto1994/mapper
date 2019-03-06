<?php

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = [
          [
            'name' => 'Painel Principal',
            'slug' => str_slug('Painel Principal'),
            'description' => 'Painel Principal',
            'route' => '/',
          ],
          [
            'name' => 'Clientes',
            'slug' => str_slug('Clientes'),
            'description' => 'Clientes',
            'route' => '/clients',
          ],
          [
            'name' => 'Gestão de Entregas',
            'slug' => str_slug('Gestão de Entregas'),
            'description' => 'Gestão de Entregas',
            'route' => '',
          ],
          [
            'name' => 'Documentos',
            'slug' => str_slug('Documentos'),
            'description' => 'Documentos',
            'route' => '/documents',
          ],
          [
            'name' => 'Ordem Entrega',
            'slug' => str_slug('Ordem Entrega'),
            'description' => 'Ordem Entrega',
            'route' => '/delivery-order',
          ],
          [
            'name' => 'Gestão de Processos',
            'slug' => str_slug('Gestão de Processos'),
            'description' => 'Gestão de Processos',
            'route' => '',
          ],
          [
            'name' => 'Board',
            'slug' => str_slug('Board'),
            'description' => 'Board',
            'route' => '/boards',
          ],
          [
            'name' => 'Mapeamentos',
            'slug' => str_slug('Mapeamentos'),
            'description' => 'Mapeamentos',
            'route' => '/mappings',
          ],
          [
            'name' => 'Processos',
            'slug' => str_slug('Processos'),
            'description' => 'Processos',
            'route' => '/processes',
          ],
          [
            'name' => 'Tarefas',
            'slug' => str_slug('Tarefas'),
            'description' => 'Tarefas',
            'route' => '/tasks',
          ],
          [
            'name' => 'Administrativo',
            'slug' => str_slug('Administrativo'),
            'description' => 'Administrativo',
            'route' => '',
          ],
          [
            'name' => 'Departamentos',
            'slug' => str_slug('Departamentos'),
            'description' => 'Departamentos',
            'route' => '/departments',
          ],
          [
            'name' => 'Usuarios',
            'slug' => str_slug('Usuarios'),
            'description' => 'Usuarios',
            'route' => '/users',
          ],

          [
            'name' => 'Privilégios',
            'slug' => str_slug('Privilegios'),
            'description' => 'Privilégios',
            'route' => '/roles',
          ],

          [
            'name' => 'Permissões',
            'slug' => str_slug('Permissoes'),
            'description' => 'Permissões',
            'route' => '/permissions',
          ],

          [
            'name' => 'Calendário',
            'slug' => str_slug('Calendario'),
            'description' => 'Calendário',
            'route' => '/task/calendar/list',
          ],
        ];

        foreach ($itens as $key => $value) {
            Module::create($value);
        }
    }
}
