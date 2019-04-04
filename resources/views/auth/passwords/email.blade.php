@extends('auth.layout')

@section('content')

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
              <h1 class="logo-name">GP+</h1>
            </div>
            <h3>Recuperar Senha</h3>
            <form class="m-t" method="POST" role="form" action="{{ route('password.email') }}">
            {{ csrf_field() }}

                @foreach ($errors->all() as $error)

                    <div class="alert alert-danger">{{ $error }}</div>

                @endforeach

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" class="form-control" placeholder="E-mail" autofocus required="" value="{{ old('email') }}">
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">Enviar</button>

                <a href="{{ route('login') }}" class="btn btn-link block full-width m-b">voltar ao login</a>

                <p class="text-muted text-center">Provider &copy;, Direitos Reservados 2018.  <a class="text-navy"><small>Desenvolvido por César Augusto</small></a></p>
            </form>
        </div>
    </div>

@endsection
