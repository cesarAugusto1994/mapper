@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Cliente</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">Painel Principal</a>
                </li>

                <li>
                    <a href="{{ route('clients.index') }}">Clientes</a>
                </li>

                <li class="active">
                    <strong>{{ $client->name }}</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">

                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-b-md">
                                    <a href="{{route('clients.edit', ['id' => $client->uuid])}}"
                                       style="margin-left: 4px;"
                                       class="btn btn-info pull-right">Editar</a>
                                    <h2>{{ $client->name}} </h2>
                                    <p>CPF/CNPJ: {{ $client->document }}</p>
                                    <p>Email: {{ $client->email }}</p>
                                    <p>Telefone: {{ $client->phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Endereços</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">
                          @if($client->addresses->isNotEmpty())
                              <table class="table table-hover">
                                  <tbody>
                                      @foreach($client->addresses as $address)
                                          <tr>

                                              <td class="project-title">
                                                  <p>ID:</p>
                                                  <a>{{$address->id}}</a>
                                              </td>

                                              <td class="project-title">
                                                  <p>Descrição:</p>
                                                  <a>{{$address->description}}</a>
                                              </td>

                                              <td class="project-title">
                                                  <p>Logradouro:</p>
                                                  <a>{{$address->street}}, {{$address->number}} - {{$address->district}}</a>
                                              </td>

                                              <td class="project-title">
                                                  <p>Cidade:</p>
                                                  <a>{{$address->city}} - {{$address->zip}}</a>
                                              </td>

                                              <td class="project-title">
                                                  <p>Adicionado em:</p>
                                                  <a>{{$address->created_at->format('d/m/Y H:i')}}</a>
                                              </td>

                                              <td class="project-actions">
                                                @permission('edit.clientes')
                                                  <a href="{{route('client_addresses_edit', [$client->uuid, $address->uuid])}}" class="btn btn-white"><i class="fa fa-pencil"></i> Editar</a>
                                                @endpermission

                                                @permission('delete.clientes')
                                                  <a data-route="{{route('client_address_destroy', ['id' => $address->uuid])}}" class="btn btn-danger btnRemoveItem"><i class="fa fa-close"></i> Remover</a>
                                                @endpermission
                                              </td>

                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>

                          @else
                              <div class="alert alert-warning text-center">Nenhum cliente registrado até o momento.</div>
                          @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('js')

@endsection
