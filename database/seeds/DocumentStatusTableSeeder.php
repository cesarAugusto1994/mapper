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
        $itens = ['Criado', 'Ordem Entrega Gerada', 'Pendente', 'Em Transito', 'Entregue', 'Perca'];

        foreach ($itens as $key => $item) {
            Status::create(['name' => $item]);
        }
    }
}
