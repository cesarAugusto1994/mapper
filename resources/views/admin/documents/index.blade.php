@extends('layouts.layout')

@section('content')

      <div class="row wrapper border-bottom white-bg page-heading">
          <div class="col-lg-10">
              <h2>Documentos</h2>
              <ol class="breadcrumb">
                  <li>
                      <a href="{{ route('home') }}">Painel Principal</a>
                  </li>
                  <li class="active">
                      <strong>Documentos</strong>
                  </li>
              </ol>
          </div>

          <div class="col-lg-2">
            @permission('create.documentos')
              <a href="{{route('documents.create')}}" class="btn btn-primary btn-block dim m-t-lg">Novo Documento</a>
            @endpermission
          </div>

      </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">

                @include('flash::message')

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Documentos</h5>
                        <div class="ibox-tools">
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">
                            @if($documents->isNotEmpty())
                            <table class="table table-hover table-responsive">
                                <tbody>
                                @foreach($documents as $document)
                                <tr>
                                    <td class="project-title">
                                        <p>ID:</p>
                                        <a>{{$document->id}}</a>
                                    </td>

                                    <td class="project-title">
                                        <p>Descrição:</p>
                                        <p><a href="{{route('documents.show', ['id' => $document->id])}}">{{ $document->description }}</a></p>
                                    </td>

                                    <td class="project-title">
                                        <p>Cliente:</p>
                                        <p><a href="{{route('documents.show', ['id' => $document->id])}}">{{ $document->client->name }}</a></p>
                                    </td>

                                    <td class="project-title">
                                        <p>Adicionado por:</p>
                                        <p><a>{{ $document->creator->person->name }}</a></p>
                                    </td>

                                    <td class="project-title">
                                        <p>Adicionado em:</p>
                                        <p><a>{{ $document->created_at->format('d/m/Y H:i') }}</a></p>
                                    </td>

                                    <td class="project-title">
                                        <p>Tempo passado:</p>
                                        <p><a>{{ $document->created_at->diffForHumans() }}</a></p>
                                    </td>

                                    <td class="project-actions">
                                      @permission('edit.documentos')
                                        <a href="{{route('documents.edit', ['id' => $document->uuid])}}" class="btn btn-white"><i class="fa fa-pencil"></i> Editar</a>
                                      @endpermission
                                      @permission('delete.documentos')
                                        <a data-route="{{route('documents.destroy', ['id' => $document->uuid])}}" class="btn btn-danger btnRemoveItem"><i class="fa fa-close"></i> Remover</a>
                                      @endpermission
                                    </td>

                                </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">{{ $documents->links() }}</div>

                            @else
                                <div class="alert alert-warning">Nenhuma ordem de entrega foi registrada até o momento.</div>
                            @endif
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>

@endsection
