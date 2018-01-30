@extends('layouts.layout')

@section('content')

    <div class="row border-bottom white-bg dashboard-header">

        <div class="col-md-3">
            <h2>Bem Vindo(a) {{ Auth()->User()->name  }}</h2>
            @if( count($tasks) > 0 )
            <small>Parabéns, Voce Realizou {{ count($tasks) }} Tarefas. </small><a href="{{route('board')}}" class="btn btn-link btn-xs">Ver Quadro</a>

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
                                <h1 class="no-margins">{{ count($concluded) }}</h1>
                                <div class="stat-percent font-bold text-navy">0% </div>
                                <small>Tempo: {{ App\Http\Controllers\HomeController::minutesToHour($concluded->sum('time')) }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Tarefas Realizadas nesta Semana</h5>
                                <h1 class="no-margins">{{ count($concludedInThisWeek) }}</h1>
                                <div class="stat-percent font-bold text-navy">0% </div>
                                <small>Tempo: {{ App\Http\Controllers\HomeController::minutesToHour($concludedInThisWeek->sum('time')) }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Tarefas Realizadas neste mês</h5>
                                <h1 class="no-margins">{{ count($concludedInThisMount) }}</h1>
                                <div class="stat-percent font-bold text-navy">0% </div>
                                <small>Tempo: {{ App\Http\Controllers\HomeController::minutesToHour($concludedInThisMount->sum('time')) }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox danger">
                            <div class="ibox-content">
                                <h5>Atrasos</h5>
                                <h1 class="no-margins">{{ count($concludedInThisMountWithDelay) }} / {{ count($concludedInThisMount) }}</h1>
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
                        <div class="alert alert-info">
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
                          <a data-toggle="modal" data-target="#newTask" class="btn btn-primary btn-xs">Criar nova Tarefa</a>
                      </div>
                  @endif
              </div>
              <div class="ibox-content">
                  <div class="project-list">
                    @if($tasks->isNotEmpty())
                      <table class="table table-hover table-responsive">
                        <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <td class="project-title">
                                    <a href="{{route('task', ['id' => $task->id])}}">{{$task->description}}</a>
                                    <br/>
                                    <small>Criada em {{$task->created_at->format('d/m/Y H:i')}}</small>
                                </td>
                                <td class="project-completion">
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
                            @empty
                              <div class="alert alert-info">
                                  Nenhuma tarefa até o momento.
                              </div>
                        @endforelse
                        </tbody>
                    </table>
                    @else

                    <div class="alert alert-info">
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

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                //toastr.success('Mapeador de Processos', 'Seja Bem vindo {{ Auth::user()->name }}');

            }, 1300);
        });
    </script>

    <script>
        $(document).ready(function() {

            var data2 = [
                [gd(2012, 1, 1), 7], [gd(2012, 1, 2), 6], [gd(2012, 1, 3), 4], [gd(2012, 1, 4), 8],
                [gd(2012, 1, 5), 9], [gd(2012, 1, 6), 7], [gd(2012, 1, 7), 5], [gd(2012, 1, 8), 4],
                [gd(2012, 1, 9), 7], [gd(2012, 1, 10), 8], [gd(2012, 1, 11), 9], [gd(2012, 1, 12), 6],
                [gd(2012, 1, 13), 4], [gd(2012, 1, 14), 5], [gd(2012, 1, 15), 11], [gd(2012, 1, 16), 8],
                [gd(2012, 1, 17), 8], [gd(2012, 1, 18), 11], [gd(2012, 1, 19), 11], [gd(2012, 1, 20), 6],
                [gd(2012, 1, 21), 6], [gd(2012, 1, 22), 8], [gd(2012, 1, 23), 11], [gd(2012, 1, 24), 13],
                [gd(2012, 1, 25), 7], [gd(2012, 1, 26), 9], [gd(2012, 1, 27), 9], [gd(2012, 1, 28), 8],
                [gd(2012, 1, 29), 5], [gd(2012, 1, 30), 8], [gd(2012, 1, 31), 25]
            ];

            var list = {!! App\Http\Controllers\TaskController::toGraph() !!}

            console.log(list.delay);

            var obj = list.delay;
            var data3 = Object.keys(obj).map(function (key, value) {
              return [gd(key), obj[key]];
            });

            console.log(data3);

            //var data3 = arr;

            var data4 = [
                [gd(2012, 1, 1), 800], [gd(2012, 1, 2), 500], [gd(2012, 1, 3), 600], [gd(2012, 1, 4), 700],
                [gd(2012, 1, 5), 500], [gd(2012, 1, 6), 456], [gd(2012, 1, 7), 800], [gd(2012, 1, 8), 589],
                [gd(2012, 1, 9), 467], [gd(2012, 1, 10), 876], [gd(2012, 1, 11), 689], [gd(2012, 1, 12), 700],
                [gd(2012, 1, 13), 500], [gd(2012, 1, 14), 600], [gd(2012, 1, 15), 700], [gd(2012, 1, 16), 786],
                [gd(2012, 1, 17), 345], [gd(2012, 1, 18), 888], [gd(2012, 1, 19), 888], [gd(2012, 1, 20), 888],
                [gd(2012, 1, 21), 987], [gd(2012, 1, 22), 444], [gd(2012, 1, 23), 999], [gd(2012, 1, 24), 567],
                [gd(2012, 1, 25), 786], [gd(2012, 1, 26), 666], [gd(2012, 1, 27), 888], [gd(2012, 1, 28), 900],
                [gd(2012, 1, 29), 178], [gd(2012, 1, 30), 555], [gd(2012, 1, 31), 993]
            ];


            var dataset = [
                {
                    label: "Tarefas",
                    data: data3,
                    color: "#1ab394",
                    bars: {
                        show: true,
                        align: "center",
                        barWidth: 24 * 60 * 60 * 600,
                        lineWidth:0
                    }

                }, {
                    label: "Atraso",
                    data: data2,
                    yaxis: 2,
                    color: "#1C84C6",
                    lines: {
                        lineWidth:1,
                            show: true,
                            fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.2
                            }, {
                                opacity: 0.4
                            }]
                        }
                    },
                    splines: {
                        show: false,
                        tension: 0.6,
                        lineWidth: 1,
                        fill: 0.1
                    },
                }
            ];


            var options = {
                xaxis: {
                    mode: "time",
                    tickSize: [3, "day"],
                    tickLength: 0,
                    axisLabel: "Date",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 10,
                    color: "#d5d5d5"
                },
                yaxes: [{
                    position: "left",
                    max: 1070,
                    color: "#d5d5d5",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 3
                }, {
                    position: "right",
                    clolor: "#d5d5d5",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: ' Arial',
                    axisLabelPadding: 67
                }
                ],
                legend: {
                    noColumns: 1,
                    labelBoxBorderColor: "#000000",
                    position: "nw"
                },
                grid: {
                    hoverable: false,
                    borderWidth: 0
                }
            };

            function gd(year, month, day) {
                return new Date(year, month - 1, day).getTime();
            }

            var previousPoint = null, previousLabel = null;

            $.plot($("#flot-dashboard-chart"), dataset, options);

        });
    </script>


@endpush
