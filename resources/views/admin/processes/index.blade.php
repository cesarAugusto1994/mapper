@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Processos</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('home')}}">Painel</a>
                </li>
                <li class="active">
                    <strong>Processos</strong>
                </li>
            </ol>
        </div>
    </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Processos</h5>
                        <div class="ibox-tools">
                            <a href="{{route('process_create')}}" class="btn btn-primary btn-xs">Criar novo Processo</a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">

                            <table class="table table-hover">
                                <tbody>
                                @foreach($processes as $process)
                                <tr>
                                    <td class="project-status">
                                        <span class="label label-primary">{{$process->department->name}}</span>
                                    </td>
                                    <td class="project-title">
                                        <a href="{{route('process', ['id' => $process->id])}}">{{$process->name}}</a>
                                        <br/>
                                        <small>Criado em {{ $process->created_at->format('d/m/Y H:i:s')}}</small>
                                    </td>
                                    <td class="project-actions">
                                        <a href="{{route('process_edit', ['id' => $process->id])}}" class="btn btn-white btn-xs"><i class="fa fa-pencil"></i> Editar </a>
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
