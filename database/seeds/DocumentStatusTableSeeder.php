<?php

use Illuminate\Database\Seeder;
use App\Models\Documents\Status;

class DocumentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = ['Criado', 'Pendente', 'Em Transito', 'Entregue', 'Perca'];

        foreach ($itens as $key => $item) {
            Status::create(['name' => $item]);
        }
    }
}
