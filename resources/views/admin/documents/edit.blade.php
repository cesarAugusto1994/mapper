@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Documentos</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">Painel Principal</a>
                </li>
                <li>
                    <a href="{{route('documents.index')}}">Documentos</a>
                </li>
                <li class="active">
                    <strong>Editar Documento</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">

              @foreach ($errors->all() as $error)

                  <div class="alert alert-danger">{{ $error }}</div>

              @endforeach

                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Novo Documento</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" action="{{route('documents.update', $document->uuid)}}">
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}"><label class="col-sm-2 control-label">Descrição</label>
                                <div class="col-sm-10">
                                  <input type="text" required placeholder="Este campo é opcional" name="description" value="{{ $document->description }}" class="form-control"/>
                                    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {!! $errors->has('user') ? 'has-error' : '' !!}"><label class="col-sm-2 control-label">Cliente</label>
                                <div class="col-sm-10">
                                  <select class="selectpicker show-tick" data-style="btn-white" data-width="100%" name="client_id" required>
                                        @foreach($clients as $client)
                                                <option value="{{$client->id}}" {{ $client->id == $document->client_id ? 'selected' : '' }}>{{$client->name}}</option>

                                        @endforeach
                                    </select>
                                      {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
                                  </div>
                            </div>
                            <button class="btn btn-primary">Salvar</button>
                            <a class="btn btn-white" href="{{ route('documents.index') }}">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
