@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
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

        <div class="col-lg-2">
            @permission('create.clientes')
                <a href="{{route('client_addresses_create', $client->uuid)}}" class="btn btn-primary btn-block dim m-t-lg"><i class="fas fa-map-marked-alt"></i> Novo Endereço</a>
            @endpermission

            @permission('create.clientes')
                <a href="{{route('client_employee_create', $client->uuid)}}" class="btn btn-success btn-block dim m-t-lg"><i class="fas fa-user-plus"></i> Novo Funcionário</a>
            @endpermission

        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">

                <div class="row">

                    <div class="col-lg-12">
                        <div class="row widget style1">
                            <div class="col-lg-12">
                                <div class="m-b-md">
                                    <a href="{{route('clients.edit', ['id' => $client->uuid])}}"
                                       style="margin-left: 4px;"
                                       class="btn btn-primary btn-outline pull-right"><i class="far fa-edit"></i> Editar</a>
                                    <h2>{{ $client->name}} </h2>
                                    <p>

                                      @if($client->active)
                                          <i class="fa fa-circle text-navy"></i> Ativo
                                      @else
                                          <i class="fa fa-circle text-danger"></i> Inativo
                                      @endif

                                    </p>
                                    <p>CPF/CNPJ: {{ $client->document }}</p>
                                    <p>Email: {{ $client->email }}</p>
                                    <p>Telefone: {{ $client->phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">

                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Funcionários</h5>
                            </div>
                            <div class="ibox-content">

                                <div class="project-list">
                                  @if($client->employees->isNotEmpty())
                                      <table class="table table-hover">
                                          <thead>
                                              <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>Email</th>
                                                <th>CPF</th>
                                                <th>Opções</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @foreach($client->employees as $employee)
                                                  <tr>

                                                      <td class="project-title">
                                                          <a>{{$employee->id}}</a>
                                                      </td>

                                                      <td class="project-title">
                                                          <a>{{$employee->name}}</a>
                                                      </td>

                                                      <td class="project-title">
                                                          <a>{{$employee->email}}</a>
                                                      </td>

                                                      <td class="project-title">
                                                          <a>{{$employee->cpf}}</a>
                                                      </td>

                                                      <td class="project-actions">
                                                        @permission('edit.clientes')
                                                          <a href="{{route('client_employee_edit', [$client->uuid, $employee->uuid])}}" class="btn btn-white btn-block"><i class="far fa-edit"></i>  Editar</a>
                                                        @endpermission

                                                        @permission('delete.clientes')
                                                          <a data-route="{{route('client_employee_destroy', ['id' => $employee->uuid])}}" class="btn btn-danger btn-outline btn-block btnRemoveItem"><i class="fas fa-trash-alt"></i> Remover</a>
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
                    <div class="col-lg-6">

                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Endereços</h5>
                            </div>
                            <div class="ibox-content">

                                <div class="project-list">
                                  @if($client->addresses->isNotEmpty())
                                      <table class="table table-hover">
                                          <thead>
                                              <tr>
                                                <th>ID</th>
                                                <th>Descrição</th>
                                                <th>Endereço</th>
                                                <th>Principal</th>
                                                <th>Opções</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @foreach($client->addresses as $address)
                                                  <tr>

                                                      <td class="project-title">
                                                          <a>{{$address->id}}</a>
                                                      </td>

                                                      <td class="project-title">
                                                          <a>{{$address->description}}</a>
                                                      </td>

                                                      <td class="project-title">
                                                          <a>{{$address->street}}, {{$address->number}} - {{$address->district}}, {{$address->city}} - {{$address->zip}}</a>
                                                      </td>

                                                      <td class="project-title">
                                                          <a>{{$address->is_default ? 'SIM' : 'NÃO' }}</a>
                                                      </td>

                                                      <td class="project-actions">
                                                        @permission('edit.clientes')
                                                          <a href="{{route('client_addresses_edit', [$client->uuid, $address->uuid])}}" class="btn btn-white btn-block"><i class="far fa-edit"></i>  Editar</a>
                                                        @endpermission

                                                        @permission('delete.clientes')
                                                          <a data-route="{{route('client_address_destroy', ['id' => $address->uuid])}}" class="btn btn-danger btn-outline btn-block btnRemoveItem"><i class="fas fa-trash-alt"></i> Remover</a>
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
        </div>
    </div>


@endsection

@section('js')

@endsection
