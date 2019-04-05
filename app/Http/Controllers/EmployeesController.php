<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Okipa\LaravelTable\Table;
use App\Models\Client;
use App\Models\Client\Employee;
use Auth;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = (new Table)
          ->model(Employee::class)
          ->routes(['index' => ['name' => 'employees.index']]);
        $table->column('name')->title('Name')->sortable()->searchable();
        $table->column('cpf')->title('CPF')->sortable()->searchable();
        $table->column('phone')->title('Telefone')->sortable()->searchable();
        $table->column('email')->title('E-mail')->sortable()->searchable();

        return view('admin.clients.employees.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermission('create.alunos')) {
            return abort(403, 'Unauthorized action.');
        }

        $companies = Client::all();

        //$companies= $companies->pluck('id','name');



        return view('admin.clients.employees.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
