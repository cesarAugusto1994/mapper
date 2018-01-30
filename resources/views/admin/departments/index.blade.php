@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Departamentos <a href="{{route('department_create')}}" class="btn btn-lg bottom-right btn-primary pull-right">Novo</a></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('home')}}">Painel</a>
                </li>
                <li class="active">
                    <strong>Departamentos</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            @foreach($departments as $department)
                <div class="col-lg-2">
                    <div class="contact-box">
                        <a href="{{route('department', ['id' => $department->id])}}">
                            <div class="col-sm-12">
                                <h3><strong>{{$department->name}}</strong></h3>
                                <p><i class="fa fa-map-marker"></i> {{$department->user->name}}</p>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
