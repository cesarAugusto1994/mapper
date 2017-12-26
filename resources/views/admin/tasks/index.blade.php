@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Tarefas</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('home')}}">Painel</a>
                </li>
                <li class="active">
                    <strong>Tarefas</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Tarefas</h5>
                        <div class="ibox-tools">
                            <a href="{{route('task_create')}}" class="btn btn-primary btn-xs">Criar nova Tarefa</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-1">
                                <button type="button" id="loading-example-btn" class="btn btn-white btn-sm" ><i class="fa fa-refresh"></i> Refresh</button>
                            </div>
                            <div class="col-md-11">
                                <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>
                            </div>
                        </div>

                        <div class="project-list">

                            <table class="table table-hover">
                                <tbody>
                                @forelse ($tasks as $task)
                                    <tr>
                                        <td class="project-status">
                                            <span class="label label-primary">Active</span>
                                        </td>
                                        <td class="project-title">
                                            <a href="{{route('task', ['id' => $task->id])}}">{{$task->description}}</a>
                                            <br/>
                                            <small>Criada em {{$task->created_at->format('d/m/Y H:i')}}</small>
                                        </td>
                                        <td class="project-completion">
                                            <small>Situação  <b>{{$task->status->name}}</b></small>
                                        @if($task->status_id == 4)
                                            <br/>
                                            <label class="label label-danger">Cancelado</label>
                                        @else
                                            <div class="progress progress-mini">
                                                <div style="width:
                                                @if ($task->status_id == 1) 0%
                                                @elseif ($task->status_id == 2) 50%
                                                @elseif ($task->status_id == 3) 100%
                                                @endif;" class="progress-bar"></div>
                                            </div>
                                        @endif
                                        </td>
                                        <td class="project-people">
                                            <a href="{{route('user', ['id' => $task->sponsor->id])}}">
                                            <img alt="image" class="img-circle" src="@if ($task->sponsor->avatar) {{asset('admin/avatars/'.$task->sponsor->avatar)}} @else {{asset('admin/avatars/profile.png')}} @endif"></a>
                                        </td>
                                        <td class="project-actions">
                                            <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                            <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
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
            </div>
        </div>
    </div>

@endsection