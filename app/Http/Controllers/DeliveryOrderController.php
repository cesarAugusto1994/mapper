<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Models\{Documents,Client, People};
use App\Models\Department\Occupation;
use App\Models\DeliveryOrder\Documents as DeliveryOrderDocuments;
use Auth;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->hasPermission('view.ordem.entrega')) {
            return abort(403, 'Unauthorized action.');
        }

        $orders = DeliveryOrder::all();
        return view('admin.delivery-order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.delivery-order.create');
    }

    public function conference(Request $request)
    {
        if(!$request->has('document')) {

          notify()->flash('Documento não informado!', 'error', [
            'text' => 'Um documento deve ser informado para a geração da Ordem de entrega.'
          ]);

          return back();
        }

        $data = $request->request->all();

        $occupation = Occupation::where('name', 'Entregador')->get();

        if($occupation->isEmpty()) {
          notify()->flash('Cargo de Entregador não existe.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário criar o cargo Entregador.'
          ]);

          return back();
        }

        $occupation = $occupation->first();

        $delivers = People::where('occupation_id', $occupation->id)->get();

        if($delivers->isEmpty()) {
          notify()->flash('Nenhum usuário com o cargo de Entregador.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário ao menos um usuário com o cargo de Entregador.'
          ]);

          return back();
        }

        $documents = Documents::whereIn('uuid', $data['document'])->get();

        foreach ($documents as $key => $document) {
            if(!$document->address) {
              notify()->flash('Endereço não informado!', 'error', [
                'text' => 'O documento ' . $document->description . ' não possui endereço de entrega, e é obrigatória essa informação.'
              ]);

              return back();
            }
        }

        return view('admin.delivery-order.conference', compact('documents', 'delivers'));
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

        $deliverUuid = $data['delivered_by'];

        $deliver = People::uuid($deliverUuid);
        $data['delivered_by'] = $deliver->id;

        $documents = Documents::whereIn('uuid', $data['documents'])->get();

        $documentsGroupedByClients = [];

        foreach ($documents as $key => $document) {
            $documentsGroupedByClients[$document->client->id][] = $document;
        }

        foreach ($documentsGroupedByClients as $keyClient => $documentsGroupedByClient) {

            $deliveryOrder = DeliveryOrder::create([
              'client_id' => $keyClient,
              'status_id' => 1,
              'delivered_by' => $data['delivered_by']
            ]);

            foreach ($documentsGroupedByClient as $key => $document) {
                DeliveryOrderDocuments::create([
                  'document_id' => $document->id,
                  'delivery_order_id' => $deliveryOrder->id,
                  'user_id' => $request->user()->id
                ]);
            }

        }

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Nova Ordem de Entrega Gerada com sucesso.'
        ]);

        return redirect()->route('delivery-order.index');
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
