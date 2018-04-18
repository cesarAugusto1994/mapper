@extends('layouts.layout')

@section('content')

    <div class="row widget border-bottom white-bg dashboard-header">

        <div class="col-md-3">
            <h2>Bem Vindo(a) {{ Auth()->User()->name  }}</h2>
            @if( count($tasks) > 0 )
            <small>Parabéns, Voce Realizou {{ count($tasks) }} Tarefas. </small>

            @else
              <p>Você não possui tarefas no momento.</p>
            @endif
        </div>

        <div class="col-md-9">

          <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Tarefas Realizadas Hoje</h5>
                                <h1 class="no-margins">{{ $concluded->count() }}</h1>
                                <div class="stat-percent font-bold text-navy">0% </div>
                                <small>Tempo: {{ App\Http\Controllers\HomeController::minutesToHour($concluded->sum('time')) }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Tarefas Realizadas nesta Semana</h5>
                                <h1 class="no-margins">{{ $concludedInThisWeek->count() }}</h1>
                                <div class="stat-percent font-bold text-navy">0% </div>
                                <small>Tempo: {{ App\Http\Controllers\HomeController::minutesToHour($concludedInThisWeek->sum('time')) }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Tarefas Realizadas neste mês</h5>
                                <h1 class="no-margins">{{ $concludedInThisMount->count() }}</h1>
                                <div class="stat-percent font-bold text-navy">0% </div>
                                <small>Tempo: {{ App\Http\Controllers\HomeController::minutesToHour($concludedInThisMount->sum('time')) }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox danger">
                            <div class="ibox-content">
                                <h5>Atrasos</h5>
                                <h1 class="no-margins">{{ $concludedInThisMountWithDelay->count() }} / {{ $concludedInThisMount->count() }}</h1>
                                <div class="stat-percent font-bold text-danger">{{ $percentMount }}% </div>
                                <small>Tempo: {{ App\Http\Controllers\HomeController::minutesToHour($concludedInThisMountWithDelay->sum('spent_time') - $concludedInThisMountWithDelay->sum('time')) }}</small>
                            </div>
                        </div>
                    </div>
                </div>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Recente</h5>
                </div>
                @if($peddingTasks->isNotEmpty())
                <div class="ibox-content ibox-heading">
                    <h3>Você tem tarefas Pendentes para hoje!</h3>
                    @foreach($peddingTasks->take(3) as $pedding)
                    <p>
                        <small><i class="fa fa-go"></i> <a class="text-navy" href="{{ route('task', ['id' => $pedding->id]) }}">{{ $pedding->description }}</a></small>
                    </p>
                    @endforeach
                </div>
                @endif
                <div class="ibox-content inspinia-timeline">

                    @forelse($logs as $log)
                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-xs-3 date">
                                <i class="fa fa-comments"></i>
                                {{ $log->created_at->format('H:i') }}
                                <br>
                                <small class="text-navy">{{ App\Helpers\TimesAgo::render($log->created_at) }}</small>
                            </div>
                            <div class="col-xs-7 content no-top-border">
                                <p class="m-b-xs"><strong>{{$log->user->name == Auth::user()->name ? 'Você' : $log->user->name}}</strong></p>
                                <p>{{ $log->message }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="alert alert-warning">
                            Voce não possui nenhum log até o momento>.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-8">
          <div class="ibox">
              <div class="ibox-title">
                  <h5>Suas Tarefas</h5>
                  @if(Auth::user()->isAdmin())
                      <div class="ibox-tools">
                          <a data-toggle="modal" data-target="#newTask" class="btn btn-white btn-xs">Nova Tarefa</a>
                      </div>
                  @endif
              </div>
              <div class="ibox-content">
                  <div class="project-list">
                    @if($tasks->isNotEmpty())
                      <table class="table table-hover table-responsive">
                        <tbody>
                        @forelse ($tasks as $task)

                        @if($task->is_model)
                          @continue
                        @endif

                        @if($task->status_id == 3 || $task->status_id == 4)
                          @continue
                        @endif

                            <tr>
                                <td class="project-title">
                                    <a href="{{route('task', ['id' => $task->id])}}">{{$task->description}}</a>
                                    <br/>
                                    <small>Criada em {{$task->created_at->format('d/m/Y H:i')}}</small>
                                    <div class="visible-xs">

                                        <small>GUT: <b>{{$task->severity * $task->urgency * $task->trend}}</b></small>
                                        <br/>
                                        <small>Tempo Aprox.: <b>{{App\Http\Controllers\HomeController::minutesToHour($task->time)}}</b></small>
                                        @if($task->status_id == 3)
                                            <br/>
                                            <small>Tempo Gasto: <b>{{App\Http\Controllers\HomeController::minutesToHour($task->spent_time - $task->time)}}</b></small>
                                        @endif

                                        @if($task->status_id == 2)
                                            <br/>
                                            <small>Iniciada em: <b>{{$task->begin ? $task->begin->format('d/m/Y H:i') : ''}}</b></small>
                                        @endif
                                    </div>
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
                                        @elseif ($task->status_id == 2) 40%
                                        @elseif ($task->status_id == 3 || $task->status_id == 4) 100%
                                        @endif;" class="progress-bar
                                        @if ($task->status_id == 2) progress-bar-warning
                                        @elseif ($task->status_id == 4) progress-bar-danger
                                        @endif;"></div>
                                    </div>
                                </td>
                                <td class="project-actions hidden-xs">
                                    <a href="{{route('task', ['id' => $task->id])}}" class="btn btn-white btn-sm"> Visualizar </a>
                                </td>
                            </tr>
                            @empty
                              <div class="alert alert-warning">
                                  Nenhuma tarefa até o momento.
                              </div>
                        @endforelse
                        </tbody>
                    </table>
                    @else

                    <div class="alert alert-warning">
                        Nenhuma tarefa até o momento.
                    </div>

                    @endif
                  </div>
              </div>
          </div>

          <div class="modal inmodal fade" id="newTask" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                          <h4 class="modal-title">Nova Tarefa</h4>
                      </div>
                      <form method="post" class="form-horizontal" action="{{route('task_store')}}">
                      <div class="modal-body">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Descrição</label>
                                <div class="col-sm-10">
                                    <input type="text" required name="description" autofocus
                                           placeholder="Informe a descrição da Tarefa" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Processo</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="process_id">
                                        @foreach($processes as $process)
                                            <option value="{{$process->id}}">{{$process->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Responsável</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="user_id" required>
                                        <option>Selecione um Responsável</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}" {{ $user->id == Auth::user()->id ? 'selected' : '' }}>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Frequencia</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="frequency">

                                        <option value="">Nenhuma</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tempo</label>
                                <div class="col-sm-10">
                                    <input type="time" required name="time"
                                           placeholder="Uma nova Tarefa" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Metodo</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="method">
                                        <option value="manual">Manual</option>
                                        <option value="sistema">Sistema</option>
                                        <option value="internet">Internet</option>
                                        <option value="outros">Outros</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">indicador</label>
                                <div class="col-sm-10">
                                    <input type="text" name="indicator" placeholder="Sem Indicador" class="form-control">
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label">Cliente</label>
                                <div class="col-sm-10"><select class="form-control m-b" name="client_id">
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}">{{$department->name}}</option>
                                        @endforeach
                                    </select></div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label">Fornecedor</label>
                                <div class="col-sm-10"><select class="form-control m-b" name="vendor_id">
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}">{{$department->name}}</option>
                                        @endforeach
                                    </select></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Gravidade</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="severity">
                                        <option value="1">1 (baixissima)</option>
                                        <option value="2">2 (baixa)</option>
                                        <option value="3">3 (moderada)</option>
                                        <option value="4">4 (alta)</option>
                                        <option value="5">5 (altissima)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Urgencia</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="urgency">
                                        <option value="1">1 (baixissima)</option>
                                        <option value="2">2 (baixa)</option>
                                        <option value="3">3 (moderada)</option>
                                        <option value="4">4 (alta)</option>
                                        <option value="5">5 (altissima)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tendencia</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="trend">
                                        <option value="1">1 (baixissima)</option>
                                        <option value="2">2 (baixa)</option>
                                        <option value="3">3 (moderada)</option>
                                        <option value="4">4 (alta)</option>
                                        <option value="5">5 (altissima)</option>
                                    </select>
                                </div>
                            </div>

                      </div>

                      <div class="modal-footer">
                          <button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
                          <button type="submit" class="btn btn-primary">Criar Tarefa</button>
                      </div>
                      </form>
                  </div>
              </div>
          </div>



@endsection

@push('scripts')



@endpush
