@extends('layouts.layout')

@section('content')

    <div class="row widget border-bottom white-bg dashboard-header">

        <div class="col-md-12">
            <h2>Bem Vindo(a) {{ Auth::user()->person->name  }}</h2>
            @if( count($tasks) > 0 )
            <small>Parabéns, Voce Realizou {{ count($tasks) }} Tarefas. </small>

            @else
              <p>Você não possui tarefas no momento.</p>
            @endif
        </div>

    </div>

    <div class="row">

        <div class="col-lg-3">

          <div class="widget style1 navy-bg">
              <div class="row">
                  <div class="col-md-4">
                      <i class="fa fa-thumbs-up fa-5x"></i>
                  </div>
                  <div class="col-md-8 text-right">
                      <span> Tarefas Realizadas Hoje <small class="stat-percent font-bold">0% </small></span>

                      <h2 class="font-bold">{{ App\Http\Controllers\HomeController::minutesToHour($concluded->sum('time')) }}</h2>
                  </div>
              </div>
          </div>

        </div>

        <div class="col-lg-3">

          <div class="widget style1 lazur-bg">
              <div class="row">
                  <div class="col-md-4">
                      <i class="fa fa-trophy fa-5x"></i>
                  </div>
                  <div class="col-md-8 text-right">
                      <span> Tarefas Realizadas nesta Semana {{ $concludedInThisWeek->count() }} <small class="stat-percent font-bold"> 0%</small></span>

                      <h2 class="font-bold">{{ App\Http\Controllers\HomeController::minutesToHour($concludedInThisWeek->sum('time')) }}</h2>
                  </div>
              </div>
          </div>

        </div>

        <div class="col-lg-3">

          <div class="widget style1 navy-bg">
              <div class="row">
                  <div class="col-md-4">
                      <i class="fa fa-calendar fa-5x"></i>
                  </div>
                  <div class="col-md-8 text-right">
                      <span> Tarefas Realizadas neste mês {{ $concludedInThisMount->count() }} <small class="stat-percent font-bold"> 0%</small></span>

                      <h2 class="font-bold">{{ App\Http\Controllers\HomeController::minutesToHour($concludedInThisMount->sum('time')) }}</h2>
                  </div>
              </div>
          </div>

        </div>

        <div class="col-lg-3">

          <div class="widget style1 red-bg">
              <div class="row">
                  <div class="col-md-4">
                      <i class="fa fa-bell fa-5x"></i>
                  </div>
                  <div class="col-md-8 text-right">
                      <span> Atrasos {{ $concludedInThisMountWithDelay->count() }} / {{ $concludedInThisMount->count() }} <small class="stat-percent font-bold">{{ $percentMount }}%</small></span>

                      <h2 class="font-bold">{{ App\Http\Controllers\HomeController::minutesToHour($concludedInThisMountWithDelay->sum('spent_time') - $concludedInThisMountWithDelay->sum('time')) }}</h2>
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

                    @forelse($activities as $activity)
                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-xs-3 date">
                                <i class="fa fa-comments"></i>
                                {{ $activity->created_at->format('H:i') }}
                                <br>
                                <small class="text-navy">{{ \App\Helpers\TimesAgo::render($activity->created_at) }}</small>
                            </div>
                            <div class="col-xs-7 content no-top-border">
                                <p>{{ $activity->description }}:
                                   {{ html_entity_decode(\App\Helpers\Helper::getTagHmtlForModel($activity->subject_type, $activity->subject_id)) }}</p>
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
                <h5>Mural de Recados</h5>
                @if(Auth::user()->isAdmin())
                    <div class="ibox-tools">
                        <a data-toggle="modal" data-target="#newTask" class="btn btn-white btn-xs">Nova Tarefa</a>
                    </div>
                @endif
            </div>
            <div class="ibox-content">
              <div class="feed-activity-list">
                @foreach($messages as $message)
                  <div class="feed-element">
                      <a class="float-left" href="profile.html">
                          <img alt="image" class="rounded-circle" src="img/profile.jpg">
                      </a>
                      <div class="media-body ">
                          <small class="float-right">5m ago</small>
                          <strong>Monica Smith</strong> posted a new blog. <br>
                          <small class="text-muted">Today 5:60 pm - 12.06.2014</small>

                      </div>
                  </div>
                @endforeach
                  <!--
                  <div class="feed-element">
                      <a class="float-left" href="profile.html">
                          <img alt="image" class="rounded-circle" src="img/a2.jpg">
                      </a>
                      <div class="media-body ">
                          <small class="float-right">2h ago</small>
                          <strong>Mark Johnson</strong> posted message on <strong>Monica Smith</strong> site. <br>
                          <small class="text-muted">Today 2:10 pm - 12.06.2014</small>
                      </div>
                  </div>
                  <div class="feed-element">
                      <a class="float-left" href="profile.html">
                          <img alt="image" class="rounded-circle" src="img/a3.jpg">
                      </a>
                      <div class="media-body ">
                          <small class="float-right">2h ago</small>
                          <strong>Janet Rosowski</strong> add 1 photo on <strong>Monica Smith</strong>. <br>
                          <small class="text-muted">2 days ago at 8:30am</small>
                      </div>
                  </div>
                  <div class="feed-element">
                      <a class="float-left" href="profile.html">
                          <img alt="image" class="rounded-circle" src="img/a4.jpg">
                      </a>
                      <div class="media-body ">
                          <small class="float-right text-navy">5h ago</small>
                          <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                          <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                          <div class="actions">
                              <a href="" class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                              <a href="" class="btn btn-xs btn-white"><i class="fa fa-heart"></i> Love</a>
                          </div>
                      </div>
                  </div>
                  <div class="feed-element">
                      <a class="float-left" href="profile.html">
                          <img alt="image" class="rounded-circle" src="img/a5.jpg">
                      </a>
                      <div class="media-body ">
                          <small class="float-right">2h ago</small>
                          <strong>Kim Smith</strong> posted message on <strong>Monica Smith</strong> site. <br>
                          <small class="text-muted">Yesterday 5:20 pm - 12.06.2014</small>
                          <div class="well">
                              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                              Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                          </div>
                          <div class="float-right">
                              <a href="" class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                          </div>
                      </div>
                  </div>
                  <div class="feed-element">
                      <a class="float-left" href="profile.html">
                          <img alt="image" class="rounded-circle" src="img/profile.jpg">
                      </a>
                      <div class="media-body ">
                          <small class="float-right">23h ago</small>
                          <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                          <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                      </div>
                  </div>
                  <div class="feed-element">
                      <a class="float-left" href="profile.html">
                          <img alt="image" class="rounded-circle" src="img/a7.jpg">
                      </a>
                      <div class="media-body ">
                          <small class="float-right">46h ago</small>
                          <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                          <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                      </div>
                  </div>
                  -->
              </div>
            </div>
          </div>
        </div>

    </div>

@endsection
