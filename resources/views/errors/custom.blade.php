@extends('layouts.layout-blank')

@section('content')

<div class="middle-box text-center animated fadeInDown">
    <h1>{{ $code }}</h1>
    <h3 class="font-bold">{{ $message }}</h3>

    <div class="error-desc">
        Você pode voltar à página principal: <br><a href="{{ route('home') }}" class="btn btn-primary m-t">Painel</a>
    </div>
</div>

@stop
