@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>Endereço: {{ $client->name }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">Painel Principal</a>
                </li>
                <li>
                    <a href="{{route('client_addresses', $client->uuid)}}">Endereços</a>
                </li>
                <li class="active">
                    <strong>Novo Endereço</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">

                <div class="ibox float-e-margins ibox-loading">
                    <div class="ibox-title">
                        <h5>Novo Endereço</h5>
                    </div>
                    <div class="ibox-content">

                      <div class="sk-spinner sk-spinner-cube-grid">
                          <div class="sk-cube"></div>
                          <div class="sk-cube"></div>
                          <div class="sk-cube"></div>
                          <div class="sk-cube"></div>
                          <div class="sk-cube"></div>
                          <div class="sk-cube"></div>
                          <div class="sk-cube"></div>
                          <div class="sk-cube"></div>
                          <div class="sk-cube"></div>
                      </div>

                      <form action="{{route('client_addresses_store', [$client->uuid])}}" method="post">
                          {{csrf_field()}}
                      <div class="row">

                      <input type="hidden" name="client_id" value="{{ $client->uuid }}"/>

                      <div class="form-group col-md-12"><label class="control-label">Descrição</label>
                          <input type="text" name="description" required class="form-control" id="description" placeholder="Ex: Matriz">
                      </div>

                      <div class="form-group col-md-3"><label class="control-label">CEP</label>
                          <input type="text" data-cep="{{ route('cep') }}" name="zip" required class="form-control inputCep">
                      </div>

                      <div class="form-group col-md-6"><label class="control-label">Rua</label>
                          <input type="text" name="street" required class="form-control" id="street">
                      </div>

                      <div class="form-group col-md-3"><label class="control-label">Numero</label>
                          <input type="text" name="number" class="form-control" id="number">
                      </div>

                      <div class="form-group col-md-4"><label class="control-label">Bairro</label>
                          <input type="text" name="district" required class="form-control" id="district">
                      </div>

                      <div class="form-group col-md-6"><label class="control-label">Cidade</label>
                          <input type="text" name="city" required class="form-control" id="city">
                      </div>

                      <div class="form-group col-md-2"><label class="control-label">Estado</label>
                          <input type="text" name="state" required class="form-control" id="state">
                      </div>

                      <div class="form-group col-md-6"><label class="control-label">Complemento</label>
                          <input type="text" name="complement" class="form-control" id="complement">
                      </div>

                      <div class="form-group col-md-6"><label class="control-label">Referência</label>
                          <input type="text" name="reference" class="form-control" id="reference">
                      </div>

                      <div class="form-group col-md-6"><label class="control-label">Longitude</label>
                          <input type="text" name="long" class="form-control" id="long">
                      </div>

                      <div class="form-group col-md-6"><label class="control-label">Latitude</label>
                          <input type="text" name="lat" class="form-control" id="lat">
                      </div>

                      <div class="form-group col-md-6">
                          <input type="checkbox" name="is_default" id="is_default" value="1"/>
                          <label class="control-label">Endereço Principal</label>
                      </div>

                      </div>

                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <a href="{{ route('clients.show', $client->uuid) }}" class="btn btn-white">Cancelar</a>

                      </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
