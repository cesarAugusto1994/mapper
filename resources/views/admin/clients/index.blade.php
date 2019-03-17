@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.3/chosen.min.css">
@endpush

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Clientes</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">Painel Principal</a>
                </li>
                <li class="active">
                    <strong>Clientes</strong>
                </li>
            </ol>
        </div>

        <div class="col-lg-2">
            @permission('create.clientes')
                <a href="#" data-toggle="modal" data-target="#adicionar-cliente-modal" class="btn btn-primary btn-block dim m-t-lg">Novo Cliente</a>
            @endpermission

        </div>

    </div>


    <div class="row">
            <div class="wrapper wrapper-content animated fadeInUp">

                <div class="col-lg-12">

                    <div class="ibox">
                    <div class="ibox-title">
                        <h5>Listagem</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-12">
                              <form method="get" action="?">
                                <div class="input-group"><input type="text" name="search" placeholder="Informe o que deseja pesquisar" class="form-control-sm form-control">
                                  <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary"> Buscar</button>
                                  </span>
                                </div>
                              </form>
                            </div>
                        </div>

                        <div class="project-list">
                            @if($clients->isNotEmpty())
                                <table class="table table-hover">
                                    <thead>

                                      <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Telefone</th>
                                        <th>Email</th>
                                        <th>Adicionado em</th>
                                        <th></th>
                                      </tr>

                                    </thead>

                                    <tbody>
                                        @foreach($clients as $client)
                                            <tr>

                                                <td class="project-title">
                                                    <a>{{$client->id}}</a>
                                                </td>

                                                <td class="project-title">
                                                    <a>{{$client->name}}</a>
                                                </td>

                                                <td class="project-title">
                                                    <a>{{$client->phone}}</a>
                                                </td>

                                                <td class="project-title">
                                                    <a>{{$client->email}}</a>
                                                </td>

                                                <td class="project-title">
                                                    <a>{{$client->created_at->format('d/m/Y H:i')}}</a>
                                                </td>

                                                <td class="project-actions">

                                                  @permission('view.clientes')
                                                    <a href="{{route('clients.show', ['id' => $client->uuid])}}" class="btn btn-primary btn-outline"><i class="fa fa-info"></i> </a>
                                                  @endpermission

                                                  @permission('edit.clientes')
                                                    <a href="{{route('clients.edit', ['id' => $client->uuid])}}" class="btn btn-white"><i class="fa fa-pencil"></i> </a>
                                                  @endpermission

                                                  <a href="{{route('client_addresses', $client->uuid)}}" class="btn btn-info btn-outline"><i class="fa fa-map-marker"></i> </a>

                                                  @permission('delete.clientes')
                                                    <a data-route="{{route('clients.destroy', ['id' => $client->uuid])}}" class="btn btn-danger btn-outline btnRemoveItem"><i class="fa fa-close"></i> </a>
                                                  @endpermission
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $clients->links() }}

                            @else
                                <div class="alert alert-warning text-center">Nenhum cliente registrado até o momento.</div>
                            @endif
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div class="modal inmodal" id="adicionar-cliente-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Novo Cliente</h4>
                    </div>
                    <form action="{{route('clients.store')}}" method="post">
                        {{csrf_field()}}
                        <div class="modal-body">

                        <div class="form-group"><label class="control-label">Nome</label>
                            <input type="text" name="name" autofocus required class="form-control">
                        </div>

                        <div class="form-group"><label class="control-label">Telefone</label>
                            <input type="text" name="phone" required class="form-control inputPhone">
                        </div>

                        <div class="form-group"><label class="control-label">Email</label>
                            <input type="email" name="email" required class="form-control">
                        </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection

@push('scripts')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.3/chosen.jquery.min.js"></script>

@endpush
