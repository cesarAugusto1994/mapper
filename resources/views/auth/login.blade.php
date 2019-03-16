@extends('auth.layout')

@section('content')

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">GP+</h1>

            </div>
            <h3>Bem vindo ao Gestão Provider</h3>
            <form class="m-t" method="POST" role="form" action="{{ route('login') }}">
            {{ csrf_field() }}

            @foreach ($errors->all() as $error)

                <div class="alert alert-danger">{{ $error }}</div>

            @endforeach

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="text" name="email" class="form-control" placeholder="E-mail ou Nickname" required="" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <!--<span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>-->
                        @endif

                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" name="password" class="form-control" placeholder="Senha" required="">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <p class="text-muted text-center">Provider &copy;, Direitos Reservados 2018.  <a class="text-navy"><small>Desenvolvido por César Augusto</small></a></p>
            </form>
        </div>
    </div>

@endsection
