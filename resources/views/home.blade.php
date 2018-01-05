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
                                <h1 class="no-margins">{{ count($tasks) }}</h1>
                                <div class="stat-percent font-bold text-navy">98% <i class="fa fa-bolt"></i></div>
                                <small>Tempo: {{ App\Http\Controllers\HomeController::minutesToHour($tasks->sum('time')) }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Tarefas Realizadas nesta Semana</h5>
                                <h1 class="no-margins">{{ count($tasks) }}</h1>
                                <div class="stat-percent font-bold text-navy">98% <i class="fa fa-bolt"></i></div>
                                <small>Tempo: {{ App\Http\Controllers\HomeController::minutesToHour($tasks->sum('time')) }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Tarefas Realizadas no mês Anterior</h5>
                                <h1 class="no-margins">{{ count($tasks) }}</h1>
                                <div class="stat-percent font-bold text-navy">98% <i class="fa fa-bolt"></i></div>
                                <small>Tempo: {{ App\Http\Controllers\HomeController::minutesToHour($tasks->sum('time')) }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox danger">
                            <div class="ibox-content">
                                <h5>Atrasos</h5>
                                <h1 class="no-margins">{{ count($tasks)/2 }} / {{ count($tasks) }}</h1>
                                <div class="stat-percent font-bold text-danger">12% <i class="fa fa-level-down"></i></div>
                                <small>Tempo: 0</small>
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
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                @if($peddingTasks->isNotEmpty())
                <div class="ibox-content ibox-heading">
                    <h3>Você tem tarefas Pendentes para hoje!</h3>
                    @foreach($peddingTasks as $pedding)
                    <p>
                        <small><i class="fa fa-spinner fa-pulse fa-fw"></i> <a class="text-navy" href="{{ route('task', ['id' => $pedding->id]) }}">{{ $pedding->description }}</a></small>
                    </p>
                    @endforeach
                </div>
                @endif
                <div class="ibox-content inspinia-timeline">

                    @foreach($logs as $log)
                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-xs-3 date">
                                <i class="fa fa-comments"></i>
                                {{ $log->created_at->format('H:i') }}
                                <br>
                                <small class="text-navy">{{ App\Helpers\TimesAgo::render($log->created_at->format('Y-m-d H:i:s')) }}</small>
                            </div>
                            <div class="col-xs-7 content no-top-border">
                                <p class="m-b-xs"><strong>{{$log->user->name == Auth::user()->name ? 'Você' : $log->user->name}}</strong></p>

                                <p>{{ $log->message }}</p>


                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-8">
          <div class="ibox">
              <div class="ibox-title">
                  <h5>Suas Tarefas</h5>
                  <div class="ibox-tools">
                      <a href="{{route('task_create')}}" class="btn btn-primary btn-xs">Criar nova Tarefa</a>
                  </div>
              </div>
              <div class="ibox-content">
                  <div class="project-list">
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
                            <tr>
                                <td>
                            </tr>
                            Nenhuma tarefa até o momento.
                        @endforelse
                        </tbody>
                    </table>
                  </div>
              </div>
          </div>

          <div class="col-lg-12">
              <div class="ibox float-e-margins">
                  <div class="ibox-title">
                      <h5>Tarefas Realizadas</h5>
                      <div class="pull-right">
                          <div class="btn-group">
                              <button type="button" class="btn btn-xs btn-white active">Today</button>
                              <button type="button" class="btn btn-xs btn-white">Monthly</button>
                              <button type="button" class="btn btn-xs btn-white">Annual</button>
                          </div>
                      </div>
                  </div>
                  <div class="ibox-content">
                      <div class="row">
                      <div class="col-lg-9">
                          <div class="flot-chart">
                              <div class="flot-chart-content" id="flot-dashboard-chart" style="padding: 0px; position: relative;"><canvas class="flot-base" width="1187" height="200" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 1187.25px; height: 200px;"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px;"><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 98px; top: 185px; left: 97px; text-align: center;">Jan 03</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 98px; top: 185px; left: 208px; text-align: center;">Jan 06</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 98px; top: 185px; left: 319px; text-align: center;">Jan 09</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 98px; top: 185px; left: 430px; text-align: center;">Jan 12</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 98px; top: 185px; left: 542px; text-align: center;">Jan 15</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 98px; top: 185px; left: 653px; text-align: center;">Jan 18</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 98px; top: 185px; left: 764px; text-align: center;">Jan 21</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 98px; top: 185px; left: 875px; text-align: center;">Jan 24</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 98px; top: 185px; left: 986px; text-align: center;">Jan 27</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 98px; top: 185px; left: 1098px; text-align: center;">Jan 30</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 173px; left: 19px; text-align: right;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 132px; left: 6px; text-align: right;">250</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 92px; left: 6px; text-align: right;">500</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 52px; left: 6px; text-align: right;">750</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 12px; left: 0px; text-align: right;">1000</div></div><div class="flot-y-axis flot-y2-axis yAxis y2Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 173px; left: 1175px;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 144px; left: 1175px;">5</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 115px; left: 1175px;">10</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 87px; left: 1175px;">15</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 58px; left: 1175px;">20</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 29px; left: 1175px;">25</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 1px; left: 1175px;">30</div></div></div><canvas class="flot-overlay" width="1187" height="200" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 1187.25px; height: 200px;"></canvas><div class="legend"><div style="position: absolute; width: 111px; height: 30px; top: 13px; left: 35px; background-color: rgb(255, 255, 255); opacity: 0.85;"> </div><table style="position:absolute;top:13px;left:35px;;font-size:smaller;color:#545454"><tbody><tr><td class="legendColorBox"><div style="border:1px solid #000000;padding:1px"><div style="width:4px;height:0;border:5px solid #1ab394;overflow:hidden"></div></div></td><td class="legendLabel">Number of orders</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #000000;padding:1px"><div style="width:4px;height:0;border:5px solid #1C84C6;overflow:hidden"></div></div></td><td class="legendLabel">Payments</td></tr></tbody></table></div></div>
                          </div>
                      </div>
                      <div class="col-lg-3">
                          <ul class="stat-list">
                              <li>
                                  <h2 class="no-margins">2,346</h2>
                                  <small>Total orders in period</small>
                                  <div class="stat-percent">48% <i class="fa fa-level-up text-navy"></i></div>
                                  <div class="progress progress-mini">
                                      <div style="width: 48%;" class="progress-bar"></div>
                                  </div>
                              </li>
                              <li>
                                  <h2 class="no-margins ">4,422</h2>
                                  <small>Orders in last month</small>
                                  <div class="stat-percent">60% <i class="fa fa-level-down text-navy"></i></div>
                                  <div class="progress progress-mini">
                                      <div style="width: 60%;" class="progress-bar"></div>
                                  </div>
                              </li>
                              <li>
                                  <h2 class="no-margins ">9,180</h2>
                                  <small>Monthly income from orders</small>
                                  <div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i></div>
                                  <div class="progress progress-mini">
                                      <div style="width: 22%;" class="progress-bar"></div>
                                  </div>
                              </li>
                              </ul>
                          </div>
                      </div>
                      </div>

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
                toastr.success('Mapeador de Processos', 'Seja Bem vindo {{ Auth::user()->name }}');

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
