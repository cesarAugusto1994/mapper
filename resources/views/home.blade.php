@extends('layouts.layout')

@section('content')


    <div class="row border-bottom white-bg dashboard-header">

        <div class="col-sm-3">
            <h2>Bem Vindo(a) {{ Auth()->User()->name  }}</h2>
            @if( count($tasks) > 0 )
            <small>Voce tem {{ count($tasks) }} Tarefas.</small>
            <ul class="list-group clear-list m-t">
              @foreach($tasks as $key => $task)
                  <li class="list-group-item fist-item"><a href="{{route('task', ['id' => $task->id])}}">
                        <span class="label label-default">{{$key+1}}</span>
                         {{$task->description}}
                        @if($task->status->id == 2)
                          <span class="label label-success pull-right">Em andamento</span>
                        @elseif($task->status->id == 3)
                          <span class="label label-primary pull-right">Finalizado</span>
                        @elseif($task->status->id == 4)
                          <span class="label label-danger pull-right">Cancelado</span>
                        @else
                          <span class="label label-warning pull-right">Aguardando</span>
                        @endif</a>
                  </li>
              @endforeach
            </ul>
            <a href="{{route('board')}}" class="btn btn-default full-width">Ver Quadro</a>
            @else
              <p>Bom trabalho, Você não possui tarefas no momento.</p>
            @endif
        </div>
        <div class="col-sm-6">
            <div class="flot-chart dashboard-chart">
                <div class="flot-chart-content" id="flot-dashboard-chart"></div>
            </div>
            <div class="row text-left">
                <div class="col-xs-4">
                    <div class=" m-l-md">
                        <span class="h4 font-bold m-t block">{{ count($concluded) }}</span>
                        <small class="text-muted m-b block">Tarefas concluídas</small>
                    </div>
                </div>
                <div class="col-xs-4">
                    <span class="h4 font-bold m-t block">{{$spentTime}} minutos</span>
                    <small class="text-muted m-b block">Tempo Gasto Esta Semana</small>
                </div>
                <div class="col-xs-4">
                    <span class="h4 font-bold m-t block">{{$spentTime}} minutos</span>
                    <small class="text-muted m-b block">Tempo Gasto</small>
                </div>

            </div>
        </div>
        <div class="col-sm-3">
            <div class="statistic-box">
                <h4>
                    Seu Desempenho
                </h4>
                <p>
                    Você realizou até o momento {{count($concluded)}} tarefas.
                </p>
                <div class="row text-center">
                    <div class="col-lg-6">
                        <canvas id="polarChart" width="80" height="80"></canvas>
                        <h5 >Kolter</h5>
                    </div>
                    <div class="col-lg-6">
                        <canvas id="doughnutChart" width="78" height="78"></canvas>
                        <h5 >Maxtor</h5>
                    </div>
                </div>
                <div class="m-t">
                    <small>Gráficos que medem o seu desempenho.</small>
                </div>

            </div>
        </div>

    </div>

    <div class="row">
      <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Recente</h5>
                </div>
                <div class="ibox-content">

                    <div>
                        <div class="feed-activity-list">

                            @foreach($logs as $log)
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
                            @endforeach

                        <!--<button class="btn btn-primary btn-block m-t"><i class="fa fa-arrow-down"></i> Show More</button>-->

                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

@section('js')


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


            var data1 = {{$proposedTime}};/*[[0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,30],[11,10],[12,13],[13,4],[14,3],[15,3],[16,6]];*/
            var data2 = {{$spent}};/*[[0,1],[1,0],[2,2],[3,0],[4,1],[5,3],[6,1],[7,5],[8,2],[9,3],[10,2],[11,1],[12,0],[13,2],[14,8],[15,0],[16,0]];*/
            $("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
                    data1, data2
                ],
                {
                    series: {
                        lines: {
                            show: false,
                            fill: true
                        },
                        splines: {
                            show: true,
                            tension: 0.4,
                            lineWidth: 1,
                            fill: 0.4
                        },
                        points: {
                            radius: 0,
                            show: true
                        },
                        shadowSize: 2
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: "#d5d5d5",
                        borderWidth: 1,
                        color: '#d5d5d5'
                    },
                    colors: ["#1ab394", "#464f88"],
                    xaxis:{
                    },
                    yaxis: {
                        ticks: 4
                    },
                    tooltip: false
                }
            );

            var doughnutData = [
                {
                    value: 300,
                    color: "#a3e1d4",
                    highlight: "#1ab394",
                    label: "App"
                },
                {
                    value: 50,
                    color: "#dedede",
                    highlight: "#1ab394",
                    label: "Software"
                },
                {
                    value: 100,
                    color: "#b5b8cf",
                    highlight: "#1ab394",
                    label: "Laptop"
                }
            ];

            var doughnutOptions = {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                percentageInnerCutout: 45, // This is 0 for Pie charts
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
            };

            var ctx = document.getElementById("doughnutChart").getContext("2d");
            var DoughnutChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);

            var polarData = [
                {
                    value: 300,
                    color: "#a3e1d4",
                    highlight: "#1ab394",
                    label: "App"
                },
                {
                    value: 140,
                    color: "#dedede",
                    highlight: "#1ab394",
                    label: "Software"
                },
                {
                    value: 200,
                    color: "#b5b8cf",
                    highlight: "#1ab394",
                    label: "Laptop"
                }
            ];

            var polarOptions = {
                scaleShowLabelBackdrop: true,
                scaleBackdropColor: "rgba(255,255,255,0.75)",
                scaleBeginAtZero: true,
                scaleBackdropPaddingY: 1,
                scaleBackdropPaddingX: 1,
                scaleShowLine: true,
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
            };
            var ctx = document.getElementById("polarChart").getContext("2d");
            var Polarchart = new Chart(ctx).PolarArea(polarData, polarOptions);

        });
    </script>


@endsection
