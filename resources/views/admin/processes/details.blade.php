@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Processo Detalhes</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('home')}}">Home</a>
                </li>
                <li class="active">
                    <strong>Processo Detalhes</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-b-md">
                                    <a href="{{route('process_edit', ['id' => $process->id])}}"
                                       style="margin-left: 4px;"
                                       class="btn btn-white pull-right">Editar Departamento</a>
                                    <a href="{{route('job_create')}}"
                                       class="btn btn-primary btn pull-right">Criar Tarefa</a>
                                    <h2>{{$process->name}} </h2>
                                    <small>{{$process->department->name}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Tarefas</h5>
                        <div class="ibox-tools">
                            <a href="{{route('job_create')}}" class="btn btn-primary btn-xs">Criar nova Tarefa</a>
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
                                @foreach($jobs as $job)
                                    <tr>
                                        <td class="project-status">
                                            <span class="label label-primary">Aguardando</span>
                                        </td>
                                        <td class="project-title">
                                            <a href="{{route('job', ['id' => $job->id])}}">{{$job->description}}</a>
                                            <br/>
                                            <small>Criado em {{ $job->created_at->format('d/m/Y H:i:s')}}</small>
                                        </td>
                                        <td class="project-actions">
                                            <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                            <a href="{{route('process_edit', ['id' => $job->id])}}" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('js')

@endsection