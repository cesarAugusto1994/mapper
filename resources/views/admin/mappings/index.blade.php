@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Mapeamentos</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('home')}}">Painel</a>
                </li>
                <li class="active">
                    <strong>Mapeamentos</strong>
                </li>
            </ol>
        </div>
    </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Mapeamentos</h5>
                        <div class="ibox-tools">
                            <a href="{{route('mapping_create')}}" class="btn btn-primary btn-xs">Criar novo Mapeamento</a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">

                            <table class="table table-hover">
                                <tbody>
                                @foreach($mappings as $map)
                                <tr>
                                    <td class="project-status">
                                        <span class="label label-{!! $map->active == 1 ? 'primary' : 'danger' !!}">{!! $map->active == 1 ? 'Ativo' : 'Inativo' !!}</span>
                                    </td>
                                    <td class="project-title">
                                        <a href="{{route('mapping', ['id' => $map->id])}}">{{$map->name}}</a>
                                        <br/>
                                        <small>Criado em {{ $map->created_at->format('d/m/Y H:i:s')}}</small>
                                    </td>
                                    <td class="project-title">
                                        <p>Tempo Previsto <a>{{ App\Http\Controllers\HomeController::minutesToHour($map->tasks->sum('time')) }}<a></p>
                                    </td>
                                    <td class="project-people">
                                        <a href="{{route('user', ['id' => $map->user->id])}}">
                                        <img alt="image" class="img-circle" src="{{Gravatar::get($map->user->email)}}"></a>
                                    </td>
                                    <td class="project-actions">
                                        <a href="{{route('mapping_edit', ['id' => $map->id])}}" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Editar </a>
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
