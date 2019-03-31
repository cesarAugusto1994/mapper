<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

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

    public function usersByDepartment(Request $request)
    {
        if(!$request->has('id')) {
          return response()->json([
            'success' => false,
            'message' => 'Departamento não informado',
            'data' => []
          ]);
        }

        if($request->get('id')) {

          $ids = explode(',', $request->get('id'));

          $departments = Department::whereIn('id', $ids)->get();
        } else {
          $departments = Department::all();
        }

        $result = [];

        $result[] = [
          'id' => 0,
          'name' => 'Todos Usuários',
          'email' => 'Todos Usuários',
        ];

        foreach ($departments as $key => $department) {

          foreach ($department->people as $key => $person) {
              $result[] = [
                'id' => $person->id,
                'name' => $person->name,
                'email' => $person->user->email,
              ];
          }

        }

        return response()->json([
          'success' => true,
          'message' => 'Usuários encontrados',
          'data' => $result
        ]);
    }
}
