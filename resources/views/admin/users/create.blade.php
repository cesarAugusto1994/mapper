@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Departamento</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li class="active">
                    <strong>Novo Departamento</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Novo Usuario</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" action="{{route('user_store')}}">
                            {{csrf_field()}}
                            <div class="form-group"><label class="col-sm-2 control-label">Nome</label>
                                <div class="col-sm-10"><input type="text" required name="name" placeholder="Emanuel Batista" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">E-mail</label>
                                <div class="col-sm-10"><input type="text" required name="email" placeholder="exemplo@exemplo.com.br" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Senha</label>
                                <div class="col-sm-10"><input type="text" required name="password" placeholder="123456" class="form-control"> <span class="help-block m-b-none">Informe a Senha que voce adicionou ao usuario.</span>
                                </div>
                            </div>
                            <button class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
