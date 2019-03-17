<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Auth;

class ClientController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
       $this->middleware('auth');
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->hasPermission('view.clientes')) {
            return abort(403, 'Unauthorized action.');
        }

        if($request->has('search')) {

          $search = $request->get('search');

          $clients = Client::where('name', 'like', "%$search%")
          ->orWhere('phone', 'like', "%$search%")
          ->orWhere('email', 'like', "%$search%");

          $clients = $clients->paginate(15);

        } else {
          $clients = Client::paginate(15);
        }

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->request->all();

      Client::create($data);

      notify()->flash('Sucesso!', 'success', [
        'text' => 'Novo Cliente adicionado com sucesso.'
      ]);

      return redirect()->route('clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::uuid($id);
        return view('admin.clients.show', compact('client'));
    }

    public function addresses(Request $request)
    {
        $id = $request->get('param');

        try {

          $client = Client::uuid($id);

          return response()->json([
            'success' => true,
            'message' => 'Registros retornados',
            'data' => $client->addresses
          ]);

        } catch(\Exception $e) {

          activity()
         ->causedBy($request->user())
         ->log('Erro ao buscar endereço do cliente: '. $e->getMessage());

          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado',
            'data' => []
          ]);

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::uuid($id);
        return view('admin.clients.edit', compact('client'));
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
        $data = $request->request->all();

        $client = Client::uuid($id);
        $client->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'As Informações do cliente foram alteradas com sucesso.'
        ]);

        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

          $client = Client::uuid($id);

          if($client->addresses->isNotEmpty()) {
            return response()->json([
              'success' => false,
              'message' => 'O cliente não pode ser removido: existem endereços vinculados a ele.'
            ]);
          }

          if($client->documents->isNotEmpty()) {
            return response()->json([
              'success' => false,
              'message' => 'O cliente não pode ser removido: existem movimentações.'
            ]);
          }

          $client->delete();

          return response()->json([
            'success' => true,
            'message' => 'cliente removido com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage()
          ]);
        }
    }
}
