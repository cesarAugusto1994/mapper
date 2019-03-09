@extends('layouts.layout')

@push('stylesheets')
        <link href="{{asset('admin/css/custom.css')}}" rel="stylesheet">
@endpush

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Perfil</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">Painel Principal</a>
                </li>
                <li class="active">
                    <strong>Perfil</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content">

        <div class="row animated fadeInRight">
            <div class="col-lg-3 col-md-4 col-sm-4">

                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Opções  </h5>
                        @if(!$user->active)
                        <span class="pull-right label label-danger">Inativo</span>
                        @endif
                    </div>
                    <div>

                        <div class="ibox-content profile-content">
                            <h4><strong>{{$user->name}}</strong></h4>
                                @if($user->department)<p><i class="fa fa-map-marker"></i> {{$user->department->name ?? ''}} </p>@endif
                                <button class="btn btn-info btn-block" data-toggle="modal" data-target="#editar">Editar</button>
                                <button class="btn btn-white btn-block" data-toggle="modal" data-target="#editar-configuracoes">Cofigurações</button>
                                <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#editar-senha">Alterar Senha</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-8 col-sm-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Atividades</h5>
                    </div>
                    <div class="ibox-content">

                      <div>
                          <div class="feed-activity-list">

                              @forelse($logs as $log)
                                  <div class="feed-element">
                                      <a href="{{ route('user', ['id' => $log->user->id]) }}" class="pull-left">
                                          <img alt="image" class="img-circle" src="{{Gravatar::get($log->user->email)}}">
                                      </a>
                                      <div class="media-body ">
                                          <small class="pull-right"></small>
                                          <strong>{{$log->user->name == Auth::user()->name ? 'Você' : $log->user->name}}</strong> {{ $log->message }} <br>
                                          <small class="text-muted">{{ $log->created_at->format('H:i - d.m.Y') }}</small>

                                      </div>
                                  </div>

                              @empty
                                  <div class="alert alert-warning">
                                      Você não possui nenhum registro até o momento.
                                  </div>
                              @endforelse

                      </div>

                    </div>
                </div>
            </div>

          </div>

            <div class="col-lg-5">
              <div class="ibox float-e-margins">
                  <div class="ibox-title">
                      <h5>Tarefas</h5>
                      <div class="ibox-tools">
                          <a href="{{route('task_create')}}" class="btn btn-white btn-xs">Criar Tarefa</a>
                      </div>
                  </div>
                  <div class="ibox-content">
                      <div class="project-list">
                        @if($tasks->isNotEmpty())
                        <table class="table table-hover">
                            <tbody>
                            @foreach ($tasks as $task)

                            @if($task->is_model)
                              @continue
                            @endif

                                <tr>
                                    <td class="project-title">
                                        <a href="{{route('task', ['id' => $task->id])}}">{{$task->description}}</a>
                                        <br/>
                                        <small>Criada em {{$task->created_at->format('d/m/Y H:i')}}</small>
                                    </td>
                                    <td class="project-completion hidden-xs">
                                        <small>GUT:  <b>
                                          <span class="label label-{!! App\Http\Controllers\TaskController::getColorFromValue($task->severity); !!}">{{$task->severity}}</span>
                                          <span class="label label-{!! App\Http\Controllers\TaskController::getColorFromValue($task->urgency); !!}">{{$task->urgency}}</span>
                                          <span class="label label-{!! App\Http\Controllers\TaskController::getColorFromValue($task->trend); !!}">{{$task->trend}}</span>
                                        </b></small>
                                    </td>
                                    <td class="project-completion">
                                        <small>Situação  <b>{{$task->status->name}}</b></small>
                                        <div class="progress progress-mini">
                                            <div style="width:
                                            @if ($task->status_id == 1) 0%
                                            @elseif ($task->status_id == 2) 50%
                                            @elseif ($task->status_id == 3 || $task->status_id == 4) 100%
                                            @endif;" class="progress-bar
                                            @if ($task->status_id == 2) progress-bar-warning
                                            @elseif ($task->status_id == 4) progress-bar-danger
                                            @endif;"></div>
                                        </div>
                                    </td>
                                    <td class="project-actions">
                                        <a href="{{route('task', ['id' => $task->id])}}" class="btn btn-white btn-sm"> Visualizar </a>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                        @else
                            <div class="alert alert-warning">
                                Nenhuma tarefa delegada à você até o momento.
                            </div>
                        @endif
                      </div>
                  </div>
              </div>

            </div>
        </div>
    </div>

    <div class="modal inmodal" id="editar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Editar Informações</h4>
                </div>
                <form action="{{route('user_update', ['id' => $user->id])}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group"><label>Seu Nome</label> <input type="text" name="name" placeholder="Informe seu Nome" value="{{$user->person->name}}" class="form-control" required></div>
                        <div class="form-group"><label>E-mail</label> <input type="email" readonly name="email" placeholder="Informe seu E-mail" value="{{$user->email}}" class="form-control"></div>
                        <div class="form-group"><label>CPF</label> <input type="text" name="cpf" placeholder="Informe seu CPF" value="{{$user->person->cpf}}" class="form-control inputCpf" required></div>
                        <div class="form-group"><label>Departamento</label>
                            <select class="selectpicker show-tick select-occupations" data-live-search="true" title="Selecione" data-style="btn-white" data-width="100%" data-search-occupations="{{ route('occupation_search') }}" name="department_id" required>

                                @foreach($departments as $department)
                                    <option value="{{$department->uuid}}" {{ $user->person->department_id == $department->id ? 'selected' : '' }}>{{$department->name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group"><label>Cargo</label>
                            <select class="selectpicker show-tick" data-live-search="true" title="Selecione" data-style="btn-white" data-width="100%"  id="occupation" name="occupation_id" required>

                                @foreach($occupations as $occupation)
                                    <option value="{{$occupation->uuid}}" {{ $user->person->occupation_id == $occupation->id ? 'selected' : '' }}>{{$occupation->name}}</option>
                                @endforeach

                            </select>
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

    <div class="modal inmodal" id="editar-configuracoes" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                    <h4 class="modal-title">Configurações</h4>
                </div>
                <form action="{{route('user_update_configurations', ['id' => $user->uuid])}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">

                        <div class="row">

                          <!--

                          <div class="form-group col-sm-6"><label>Horario Chegada</label>
                            <input type="time" name="begin" value="{{ $user->begin ? $user->begin : '07:30' }}" class="form-control">
                          </div>

                          <div class="form-group col-sm-6"><label>Horario Saída para Almoçar</label>
                            <input type="time" name="lunch" value="{{ $user->lunch ? $user->lunch : '12:00' }}" class="form-control">
                          </div>

                          <div class="form-group col-sm-6"><label>Retorno do Almoço</label>
                            <input type="time" name="lunch_return" value="{{ $user->lunch_return ? $user->lunch_return : '13:00' }}" class="form-control">
                          </div>

                          <div class="form-group col-sm-6"><label>Fim de Expediente</label>
                            <input type="time" name="end" value="{{ $user->end ? $user->end : '17:30' }}" class="form-control">
                          </div>

                          <div class="form-group col-sm-6"><label>Carga horária Semanal</label>
                            <input type="number" name="weekly_workload" value="{{ $user->weekly_workload ? $user->weekly_workload : '' }}" placeholder="Ex:. 44 hrs" autocomplete="off" class="form-control">
                          </div>

                        -->

                          <div class="form-group col-sm-4"><label>Usuário SOC</label>
                            <input type="text" name="login_soc" value="{{ $user->login_soc ? $user->login_soc : '' }}" placeholder="" autocomplete="off" class="form-control">
                          </div>

                          <div class="form-group col-sm-4"><label>Senha SOC</label>
                            <input type="password" name="password_soc" value="{{ $user->password_soc ? $user->password_soc : '' }}" placeholder="" autocomplete="off" class="form-control">
                          </div>

                          <div class="form-group col-sm-4"><label>ID SOC</label>
                            <input type="text" name="id_soc" value="{{ $user->id_soc ? $user->id_soc : '' }}" placeholder="" autocomplete="off" class="form-control">
                          </div>

                          <div class="form-group col-sm-12 {!! $errors->has('roles') ? 'has-error' : '' !!}"><label>Acesso</label>

                                <select id="role" name="roles" required="required" class="form-control">
                                    <option value="Usuario">Usuario</option>
                                    <option value="Gerente">Gerente</option>
                                    <option value="Administrador">Administrador</option>
                                </select>
                                {!! $errors->first('roles', '<p class="help-block">:message</p>') !!}

                          </div>

                          <div class="form-group col-sm-6"><label>Executa Tarefas</label>
                              <br/>
                              <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary {{ $user->do_task ? 'active' : '' }}">
                                  <input type="radio" name="do_task" id="option1" value="1" autocomplete="off" {{ $user->do_task ? 'checked' : '' }}> Sim
                                </label>
                                <label class="btn btn-primary {{ !$user->do_task ? 'active' : '' }}">
                                  <input type="radio" name="do_task" id="option2" value="0" autocomplete="off" {{ !$user->do_task ? 'checked' : '' }}> Não
                                </label>
                              </div>
                          </div>

                          <div class="form-group col-sm-6"><label>Ativo</label>
                            <br/>
                            <div class="btn-group" data-toggle="buttons">
                              <label class="btn btn-primary {{ $user->active ? 'active' : '' }}">
                                <input type="radio" name="active" id="option3" value="1" autocomplete="off" {{ $user->active ? 'checked' : '' }}> Sim
                              </label>
                              <label class="btn btn-primary {{ !$user->active ? 'active' : '' }}">
                                <input type="radio" name="active" id="option4" value="0" autocomplete="off" {{ !$user->active ? 'checked' : '' }}> Não
                              </label>
                            </div>
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

    <div class="modal inmodal" id="editar-senha" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <img alt="image" style="max-width:64px;max-height:64px" class="img-circle" src="{{Gravatar::get($user->email)}}" />
                    <br/>
                    <h4 class="modal-title">Alterar Senha</h4>
                </div>
                <form action="{{route('user_update_password', ['id' => $user->uuid])}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group"><label>Nova Senha</label>
                          <input type="password" required autofocus name="password" placeholder="Informe a sua nova senha" autocomplete="off" class="form-control">

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
