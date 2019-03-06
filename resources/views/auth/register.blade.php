@extends('auth.layout')

@section('content')

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">MP+</h1>

            </div>
            <h3>Registrar-se no Process Mapper</h3>
            <form class="m-t" method="POST" role="form" action="{{ route('register') }}">
            {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input type="text" name="name" class="form-control" placeholder="Nome" required="">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif

                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" class="form-control" placeholder="E-mail" required="">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif


                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password"  name="password" class="form-control" placeholder="Senha" required="">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                </div>

                <div class="form-group">
                        <input id="password-confirm" type="password" placeholder="Confirmar Senha" class="form-control" name="password_confirmation" required>
                </div>

                <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" required><i></i> Eu aceito os termos e politicas </label></div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Registrar</button>

                <p class="text-muted text-center"><small>Já tem uma conta?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{route('login')}}">Login</a>
            </form>

        </div>
    </div>

@endsection
