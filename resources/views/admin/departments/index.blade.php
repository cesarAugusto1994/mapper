@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">

        <div class="col-lg-10">
            <h2>Departamentos </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">Painel Principal</a>
                </li>
                <li class="active">
                    <strong>Departamentos</strong>
                </li>
            </ol>
        </div>

        <div class="col-lg-2">

          @permission('create.departamentos')

            <a href="{{route('department_create')}}" class="btn btn-primary btn-block dim m-t-lg">Novo Departamento</a>

          @endpermission

        </div>

    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

          @include('flash::message')

            @foreach($departments as $department)
                <div class="col-lg-6 col-md-3 col-sm-6">
                    <div class="contact-box">
                        <a href="{{route('department', ['id' => $department->id])}}">
                            <div class="col-sm-12">
                                <h3><strong>{{$department->name}}</strong></h3>
                                <p><i class="fa fa-map-marker"></i> {{$department->user->person->name}}</p>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
