<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilController extends Controller
{
    public function cep(Request $request)
    {
        if(!$request->has('search')) {
          return response()->json([
            'success' => false,
            'message' => 'O Cep deve ser informado',
            'data' => []
          ]);
        }

        $search = $request->get('search');

        if(strlen($search) < 8) {
          return response()->json([
            'success' => true,
            'message' => 'O Cep deve conter 8 caracteres',
            'data' => []
          ]);
        }

        $cep = cep($search);

        $cepInfo = $cep->toJson();

        $cepResult = $cepInfo->result();

        if($cepResult) {

          $cepResult = json_decode($cepResult);
          $address = "";

          if(!empty($cepResult->logradouro)) {
              $address .= $cepResult->logradouro . " ";
          } elseif (!empty($cepResult->bairro)) {
              $address .= $cepResult->bairro . " ";
          } elseif (!empty($cepResult->localidade)) {
              $address .= $cepResult->localidade . " ";
          } elseif (!empty($cepResult->uf)) {
              $address .= $cepResult->uf . " ";
          }

          $address .= $cepResult->cep;

          $response = \GoogleMaps::load('geocoding')
          ->setParam (['address' => $address])
          ->get();

          $local = json_decode($response);
          $coordenadas = null;

          if($local && $local->results) {
              $coordenadas = $local->results[0]->geometry->location;
          }

        }

        if(!$cepInfo->result()) {
          return response()->json([
            'success' => false,
            'message' => 'CEP não encontrado!',
            'data' => []
          ]);
        }

        return response()->json([
          'success' => true,
          'message' => 'Cep encontrado',
          'data' => ['response' => $cepResult, 'coordenadas' => $coordenadas]
        ]);

    }
}
