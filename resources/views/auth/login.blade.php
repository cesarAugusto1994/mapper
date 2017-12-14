@extends('auth.layout')

@section('content')

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">MP+</h1>

            </div>
            <h3>Bem vindo ao Process Mapper</h3>
            <form class="m-t" method="POST" role="form" action="{{ route('login') }}">
            {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" class="form-control" placeholder="Username" required="">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif

                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>Esqueceu a sua Senha?</small></a>
                <p class="text-muted text-center"><small>Ainda não tem uma conta?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{route('register')}}">Criar Conta</a>
            </form>
        </div>
    </div>

@endsection
