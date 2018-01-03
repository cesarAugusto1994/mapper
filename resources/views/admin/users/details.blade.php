@extends('layouts.layout')

@push('stylesheets')
        <link href="{{asset('admin/css/custom.css')}}" rel="stylesheet">
@endpush

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
            <div class="col-md-2">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Perfil Detalhes</h5>
                    </div>
                    <div>
                        <div class="ibox-content no-padding border-left-right">

                            <div class="avatar">
                                <img class="img" src="{{Gravatar::get($user->email)}}" alt="Avatar">
                                <div class="overlay"></div>
                                <!--<div class="button"><a href="{{route('user_avatar', ['id' => $user->id])}}"> Editar Foto </a></div>-->
                            </div>

                        </div>
                        <div class="ibox-content profile-content">
                            <h4><strong>{{$user->name}}</strong></h4>
                                <p><i class="fa fa-map-marker"></i> {{$user->department->name ?? ''}} </p>
                                <button class="btn btn-primary btn-xs full-width" data-toggle="modal" data-target="#editar">Editar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Atividades</h5>
                    </div>
                    <div class="ibox-content">

                      <div>
                          <div class="feed-activity-list">

                              @foreach($logs as $log)
                                  <div class="feed-element">
                                      <a href="{{ route('user', ['id' => $log->user->id]) }}" class="pull-left">
                                          <img alt="image" class="img-circle" src="{{Gravatar::get($log->user->email)}}">
                                      </a>
                                      <div class="media-body ">
                                          <small class="pull-right"></small>
                                          <strong>{{$log->user->name == Auth::user()->name ? 'Você' : $log->user->name}}</strong> {{ $log->message }} <br>
                                          <small class="text-muted">{{ $log->created_at->format('H:i - d.m.Y') }}</small>

                                      </div>
                                  </div>
                              @endforeach

                          <!--<button class="btn btn-primary btn-block m-t"><i class="fa fa-arrow-down"></i> Show More</button>-->

                      </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal inmodal" id="editar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <img alt="image" style="max-width:64px;max-height:64px" class="img-circle" src="{{Gravatar::get($user->email)}}" />
                    <br/>
                    <h4 class="modal-title">{{$user->name}}</h4>
                </div>
                <form action="{{route('user_update', ['id' => $user->id])}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group"><label>Seu Nome</label> <input type="text" name="name" placeholder="Informe seu Nome" value="{{$user->name}}" class="form-control"></div>
                        <div class="form-group"><label>E-mail</label> <input type="email" name="email" placeholder="Informe seu E-mail" value="{{$user->email}}" class="form-control"></div>
                        <div class="form-group"><label>Nova Senha</label> <input type="password" name="password" placeholder="Informe a sua nova senha" class="form-control"></div>

                        <div class="form-group"><label>Departamento</label>
                            <select class="form-control" name="department_id">

                                @foreach($departments as $department)
                                    <option value="{{$department->id}}" {{ $user->department_id == $department->id ? 'selected' : '' }}>{{$department->name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
