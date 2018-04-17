@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Departamento</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">Painel Principal</a>
                </li>
                <li>
                    <a href="{{ route('departments') }}">Departamentos</a>
                </li>
                <li class="active">
                    <strong>Novo Departamento</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">

                @include('flash::message')

                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Novo Usuario</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" action="{{route('user_store')}}">
                            {{csrf_field()}}
                            <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}"><label class="col-sm-2 control-label">Nome</label>
                                <div class="col-sm-10">
                                  <input type="text" value="{{ old('name') }}" required name="name" placeholder="Informe seu Nome" class="form-control">
                                  {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}"><label class="col-sm-2 control-label">E-mail</label>
                                <div class="col-sm-10">
                                  <input type="text" value="{{ old('email') }}" required name="email" placeholder="Informe seu E-mail" class="form-control">
                                  {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}"><label class="col-sm-2 control-label">Senha</label>
                                <div class="col-sm-10">
                                  <input type="text" value="{{ old('password') }}" required name="password" placeholder="Informe a Senha" class="form-control">
                                  {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {!! $errors->has('roles') ? 'has-error' : '' !!}"><label class="col-sm-2 control-label">Acesso</label>
                                <div class="col-sm-10">
                                  <select id="roles" name="roles" required="required" class="form-control col-md-7 col-xs-12">
                                      <option value="user">Usuário</option>
                                      <option value="admin">Administrador</option>
                                  </select>
                                  {!! $errors->first('roles', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Departamento</label>
                              <div class="col-sm-10">
                              <select class="form-control" name="department_id">
                                <option value=""></option>
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                @endforeach

                              </select>
                              </div>
                            </div>

                            <button class="btn btn-primary">Salvar</button>
                            <a class="btn btn-white" href="{{ back() }}">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
