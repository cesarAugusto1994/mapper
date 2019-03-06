@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Ordem Entrega</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">Painel Principal</a>
                </li>
                <li class="active">
                    <strong>Ordem Entrega</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <a href="{{route('delivery-order.create')}}" class="btn btn-primary btn-block dim m-t-lg">Nova Ordem de Entrega</a>
        </div>
    </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">

                @include('flash::message')

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Ordem Entrega</h5>
                        <div class="ibox-tools">
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">
                            @if($orders->isNotEmpty())
                            <table class="table table-hover table-responsive">
                                <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td class="project-title">
                                        <a href="{{route('delivery-order.show', ['id' => $order->id])}}">{{ $order->description }}</a>
                                    </td>
                                    <td class="project-completion">
                                        <span>Tempo Tarefas {{ App\Http\Controllers\HomeController::minutesToHour($map->tasks->sum('time')) }}</span>
                                    </td>
                                    <td class="project-completion">
                                        <span>Tarefas: {{ $map->tasks->count() }}<a></span>
                                    </td>
                                    <td class="project-completion">
                                        <span>Tempo Trabalhado: {{App\Helpers\Mapper::getDoneTimeByUser($map->user->id) }}<a></span>
                                    </td>
                                    <td class="project-completion">
                                        <span>Tempo Ocioso: {{ App\Http\Controllers\TaskController::ociousTime($map->id) }}<a></span>
                                    </td>
                                    <td class="project-people hidden-xs">
                                        <a href="{{route('user', ['id' => $map->user->id])}}" title="{{ $map->user->name }}">
                                        <img alt="image" class="img-circle" src="{{Gravatar::get($map->user->email)}}"></a>
                                    </td>
                                    <!--<td class="project-actions hidden-xs">
                                        <a href="{{route('mapping_edit', ['id' => $map->id])}}" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Editar </a>
                                    </td>-->
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @else
                                <div class="alert alert-warning">Nenhuma ordem de entrega foi registrada até o momento.</div>
                            @endif
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>

@endsection
