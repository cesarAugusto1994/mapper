@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Usuários</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">Painel Principal</a>
                </li>
                <li class="active">
                    <strong>Usuários</strong>
                </li>
            </ol>
        </div>

        <div class="col-lg-2">
            <a data-toggle="modal" data-target="#add-user-modal" class="btn btn-primary btn-block dim m-t-lg">Novo Usuário</a>
        </div>

    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

            @foreach($users as $user)

                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                  <div class="widget white-bg">

                    <div class="row">

                      <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 text-center">
                          <img src="{{$user->avatar}}" class="rounded-circle circle-border m-b-md" style="max-width:128px;max-height:128px" alt=""/>
                      </div>

                      <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">

                        <h2>
                            {{ $user->person->name }}
                        </h2>
                        <ul class="list-unstyled m-t-md">
                            <li>
                                <span class="fa fa-envelope m-r-xs"></span>
                                <label>Email:</label>
                                {{$user->email}}
                            </li>

                            <li>
                                <span class="fa fa-user m-r-xs"></span>
                                <label>Dept:</label>
                                {{$user->person->department->name}} /
                                {{$user->person->occupation->name}}
                            </li>

                            <li>
                                <span class="fa fa-key m-r-xs"></span>
                                <label>Previlégio:</label>
                                {{$user->roles->first()->name}}
                            </li>
                            <li>
                                <span class="fa fa-sign-in m-r-xs"></span>
                                <label>Logado em:</label>
                                {{ $user->lastLoginAt() ? $user->lastLoginAt()->format('d/m/Y H:i') : '' }}
                            </li>
                        </ul>

                      </div>

                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="row">

                          <div class="col-sm-6 col-xs-12">
                              <a class="btn btn-white btn-block" href="{{route('user', ['id' => $user->uuid])}}"><i class="fa fa-pencil"></i> Editar</a>
                          </div>

                          <div class="col-sm-6 col-xs-12">
                              <a class="btn btn-danger btn-block btn-outline" href="{{route('user_permissions', ['id' => $user->uuid])}}"><i class="fa fa-key"></i> Permissões</a>
                          </div>

                        </div>

                      </div>

                  </div>
                  </div>
                </div>

            @endforeach
        </div>
    </div>

    <div class="modal inmodal" id="add-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                    <h4 class="modal-title">Adicionar Usuário</h4>
                </div>
                <form method="post" class="form-horizontal" action="{{route('user_store')}}">
                    <div class="modal-body">
                      {{csrf_field()}}
                          <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}"><label class="col-sm-2 control-label">Nome</label>
                              <div class="col-sm-10">
                                <input type="text" value="{{ old('name') }}" required name="name" autofocus class="form-control">
                                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                              </div>
                          </div>
                          <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}"><label class="col-sm-2 control-label">E-mail</label>
                              <div class="col-sm-10">
                                <input type="text" value="{{ old('email') }}" required name="email" class="form-control">
                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                              </div>
                          </div>

                          <div class="form-group {!! $errors->has('cpf') ? 'has-error' : '' !!}"><label class="col-sm-2 control-label">CPF</label>
                              <div class="col-sm-10">
                                <input type="text" value="{{ old('cpf') }}" required name="cpf" class="form-control inputCpf">
                                {!! $errors->first('cpf', '<p class="help-block">:message</p>') !!}
                              </div>
                          </div>

                          <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}"><label class="col-sm-2 control-label">Senha</label>
                              <div class="col-sm-10">
                                <input type="password" value="{{ old('password') }}" required name="password" class="form-control">
                                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                              </div>
                          </div>
                          <div class="form-group {!! $errors->has('roles') ? 'has-error' : '' !!}"><label class="col-sm-2 control-label">Acesso</label>
                              <div class="col-sm-10">
                                <select id="roles" name="roles" required="required" class="form-control col-md-7 col-xs-12">
                                  @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                  @endforeach
                                </select>
                                {!! $errors->first('roles', '<p class="help-block">:message</p>') !!}
                              </div>
                          </div>

                          <div class="form-group"><label class="col-sm-2 control-label">Departamento</label>
                            <div class="col-sm-10">
                            <select class="selectpicker show-tick select-occupations" name="department_id" data-live-search="true" title="Selecione" data-style="btn-white" data-width="100%" data-search-occupations="{{ route('occupation_search') }}" required>
                              @foreach($departments as $department)
                                  <option value="{{$department->uuid}}">{{$department->name}}</option>
                              @endforeach
                            </select>
                            </div>
                          </div>

                          <div class="form-group"><label class="col-sm-2 control-label">Cargo</label>
                            <div class="col-sm-10">
                            <select class="selectpicker show-tick" data-live-search="true" title="Selecione" data-style="btn-white" data-width="100%"  id="occupation" name="occupation_id" required>
                              @foreach($occupations as $occupation)
                                  <option value="{{$occupation->uuid}}">{{$occupation->name}}</option>
                              @endforeach
                            </select>
                            </div>
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
    <script>

      $(document).ready(function() {

        let selectOccupations = $(".select-occupations");
        let occupation = $("#occupation");

        selectOccupations.on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {

          let self = $(this);
          let route = self.data('search-occupations');
          let value = self.val();

          $.ajax({
            type: 'GET',
            url: route + '?param=' + value,
            async: true,
            success: function(response) {

              let html = "";
              occupation.html("");
              occupation.selectpicker('refresh');

              $.each(response.data, function(idx, item) {

                  html += "<option value="+ item.uuid +">"+ item.name +"</option>";

              });

              occupation.append(html);
              occupation.selectpicker('refresh');

            }
          })

        });

      });

    </script>
@endpush
