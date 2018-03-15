@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Sub Processos <a href="{{route('sub_process_create')}}" class="btn btn-lg bottom-right btn-primary pull-right">Novo</a></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('home')}}">Painel</a>
                </li>
                <li class="active">
                    <strong>Sub Processos</strong>
                </li>
            </ol>
        </div>
    </div>


    <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">

                @include('flash::message')

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Sub-Processos</h5>
                        <div class="ibox-tools">
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">

                            @if($processes->isNotEmpty())
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
                            @else
                                <div class="alert alert-warning">Nenhum sub processo registrado até o momento.</div>
                            @endif
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>

@endsection
