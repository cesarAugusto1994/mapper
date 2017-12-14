@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Usuarios <a href="{{route('user_create')}}" class="btn btn-lg bottom-right btn-primary pull-right">Novo</a></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('home')}}">Painel</a>
                </li>
                <li class="active">
                    <strong>Usuarios</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            @foreach($users as $user)
                <div class="col-lg-4">
                    <div class="contact-box">
                        <a href="{{route('user', ['id' => $user->id])}}">
                            <div class="col-sm-12">
                                <h3><strong>{{$user->name}}</strong></h3>
                                <p><i class="fa fa-at"></i> {{$user->email}}</p>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection