@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Board <a href="{{route('user_create')}}" class="btn btn-lg bottom-right btn-primary pull-right">Novo</a></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('home')}}">Painel</a>
                </li>
                <li class="active">
                    <strong>Board</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

      <div class="row">
          @foreach($users as $user)
          <div class="col-lg-3 col-md-4 col-xs-12">
              <div class="ibox">
                  <div class="ibox-title">
                      <span class="label label-danger pull-right">{!! App\Http\Controllers\UsersController::getLatestTask($user->id) !!}</span>
                      <h5>{{ $user->name }}</h5>
                  </div>
                  <div class="ibox-content">
                      <div class="team-members text-center">
                          <a href="{{ route('user', ['id' => $user->id]) }}"><img alt="member" class="img-circle" src="{{Gravatar::get($user->email)}}"></a>
                      </div>
                      <div class="col-lg-12 text-center">

                        <h2>{!! App\Http\Controllers\UsersController::getTaskPercentage($user->id) !!}%</h2>

                        <div class="progress progress-mini">
                            <div style="width: {!! App\Http\Controllers\UsersController::getTaskPercentage($user->id) !!}%;" class="progress-bar {!! App\Http\Controllers\UsersController::getTaskPercentageProgress($user->id) !!}"></div>
                        </div>
                        <br/>

                      </div>

                      <div>

                      @forelse($user->tasks->sortByDesc('id')->take(6) as $task)
                        <span><a href="{{ route('task', ['id' => $task->id]) }}" style="color: #2f4050">{{ $task->description }}</a>:</span>
                        <div class="stat-percent">@if ($task->status_id == 1) 0%
                        @elseif ($task->status_id == 2) 50%
                        @elseif ($task->status_id == 3 || $task->status_id == 4) 100%
                        @endif</div>

                        <div class="progress progress-striped active progress-mini">
                          <div style="width:
                          @if ($task->status_id == 1) 0%
                          @elseif ($task->status_id == 2) 50%
                          @elseif ($task->status_id == 3 || $task->status_id == 4) 100%
                          @endif;" class="progress-bar
                          @if ($task->status_id == 2) progress-bar-warning
                          @elseif ($task->status_id == 4) progress-bar-danger
                          @endif;"></div>
                      </div>
                      @empty
                          <p>Nenhuma tarefa registrada</p>
                      @endforelse

                      @if($user->logs->isNotEmpty())
                      <div class="inspinia-timeline">

                        <br/>
                        <h3>Histórico</h3>

                          @forelse(App\Http\Controllers\UsersController::getTodayLogs($user->id) as $log)
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
                              <p>Nenhum registro encontrado.</p>
                          @endforelse
                      </div>
                      @endif


                      </div>
                      <!--
                      <div class="row  m-t-sm">
                          <div class="col-sm-4">
                              <div class="font-bold">PROJECTS</div>
                              12
                          </div>
                          <div class="col-sm-4">
                              <div class="font-bold">RANKING</div>
                              4th
                          </div>
                          <div class="col-sm-4 text-right">
                              <div class="font-bold">BUDGET</div>
                              $200,913 <i class="fa fa-level-up text-navy"></i>
                          </div>
                      </div>
                    -->

                  </div>
              </div>
          </div>
          @endforeach
    </div>

@endsection
