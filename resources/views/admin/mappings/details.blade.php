@extends('layouts.layout')

@push('stylesheets')
        <link href="{{asset('admin/css/custom.css')}}" rel="stylesheet">
@endpush

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Mapeamento - {{ $mapper->name }}
              @if($mapper->active != 1)
              @if($mapper->tasks->isNotEmpty())
                  <form method="post" action="{{ route('mapping_start', ['id' => $mapper->id]) }}">
                      {{ csrf_field() }}
                      <button type="submit" class="btn btn-lg bottom-right btn-primary pull-right">Iniciar</button>
                  </form>
              @endif
              @else
                <span class="bottom-right label label-primary pull-right">Em Execução</span>
              @endif
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li class="active">
                    <strong>Mapeamento</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row animated fadeInRight">
            <div class="col-lg-2 col-md-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Mapeamento Detalhes</h5>
                    </div>
                    <div>
                        <div class="ibox-content no-padding border-left-right">

                            <div class="avatar">
                                <img class="img" src="{{Gravatar::get($mapper->user->email)}}" alt="Avatar">
                            </div>

                        </div>
                        <div class="ibox-content profile-content">
                            <h4><strong>{{$mapper->user->name}}</strong></h4>

                            <p><b>Tempo Total</b> <label class="lead">{{ App\Http\Controllers\HomeController::minutesToHour($mapper->tasks->sum('time')) }}<label></p>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-10 col-md-8">
              <div class="ibox float-e-margins">
                  <div class="ibox-title">
                      <h5>Tarefas</h5>
                      <div class="ibox-tools">
                          <a href="{{route('mapping_tasks', ['id' => $mapper->id])}}" class="btn btn-primary btn-xs">Adicionar Tarefa</a>
                      </div>
                  </div>
                  <div class="ibox-content">
                      <div class="project-list">
                        <table class="table table-hover">
                            <tbody>
                            @forelse ($mapper->tasks as $task)
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
                                  <td class="project-completion hidden-xs">
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

                                  <td class="project-title text-center">
                                      Tempo <a>{{ App\Http\Controllers\HomeController::minutesToHour($task->time) }}</a>
                                  </td>
                                  <td class="project-actions">
                                      @if($task->status->id == 1)
                                          <a href="{{route('mapper_remove_task', ['id' => $mapper->id, 'task' => $task->id])}}" class="btn btn-danger btn-outline btn-xs"> Desvincular </a>
                                      @endif
                                  </td>
                              </tr>
                                @empty
                                <tr>
                                    <td>Nenhuma tarefa até o momento.</td>
                                </tr>

                            @endforelse
                            </tbody>
                        </table>
                      </div>
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

                </div>
                <form action="{{route('user_update', ['id' => $mapper->user->id])}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">

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
