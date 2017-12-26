@extends('layouts.layout')

@section('css')
        <link href="{{asset('admin/css/custom.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Perfil</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li class="active">
                    <strong>Perfil</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row animated fadeInRight">
            <div class="col-md-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Perfil Detalhes</h5>
                    </div>
                    <div>
                        <div class="ibox-content no-padding border-left-right">

                            <div class="avatar">
                                <img class="img" src="@if ($user->avatar) {{asset('admin/avatars/'.$user->avatar)}} @else {{asset('admin/avatars/profile.png')}} @endif" alt="Avatar">                                <!--<p class="image-title">card title</p>-->
                                <div class="overlay"></div>
                                <div class="button"><a href="{{route('user_avatar', ['id' => $user->id])}}"> Editar Foto </a></div>
                            </div>

                        </div>
                        <div class="ibox-content profile-content">
                            <h4><strong>{{$user->name}}</strong><button class="btn btn-default btn-xs pull-right">Editar</button></h4>
                            @if($user->departments->first())
                                <p><i class="fa fa-map-marker"></i> {{$user->departments->first()->name}} </p>
                            @else

                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Atividades</h5>
                    </div>
                    <div class="ibox-content">
                        Nenhuma Atividade Até o momento
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection



