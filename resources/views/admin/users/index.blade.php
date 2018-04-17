@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Usuarios <a data-toggle="modal" data-target="#add-user-modal" class="btn bottom-right btn-primary pull-right">Novo</a></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">Painel Principal</a>
                </li>
                <li class="active">
                    <strong>Usuarios</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

            <div class="col-lg-12">

                @include('flash::message')

                @foreach ($errors->all() as $error)

                    <div class="alert alert-danger">{{ $error }}</div>

                @endforeach

            </div>

            @foreach($users as $user)
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                    <div class="contact-box">
                        <a href="{{route('user', ['id' => $user->id])}}">
                            <div class="col-sm-5 hidden-xs">
                                <div class="text-center">
                                    <img alt="" style="max-width:96px;max-height:96px" class="img-circle m-t-xs img-responsive" src="{{Gravatar::get($user->email)}}">
                                    <div class="m-t-xs font-bold">{{$user->occupation}}</div>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <h3><strong>{{substr($user->name, 0, 20)}}</strong>   @if(!$user->active)<span class="text-center pull-right label label-{{ $user->active ? 'primary' : 'danger' }}">{{ $user->active ? 'Ativo' : 'Inativo' }}</span>@endif</h3>
                                @if($user->department)<p><i class="fa fa-map-marker"></i> {{$user->department->name}}</p>@endif
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
