@extends('layouts.login')

@section('content')
<div class="login">
    <form action="{{ route('login') }}" method="post" accept-charset="utf-8">
        @csrf

        <div class="form-group">
            <label>Usuario / e-mail</label>
            <input type="text" class="form-control{{ $errors->has('login_field') ? ' is-invalid' : '' }}" id="login_field" name="login_field" value="{{ old('login_field') }}" autofocus>

            @if ($errors->has('login_field'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('login_field') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" autofocus>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group text-center">
            <a href="{{ route('password.request') }}">¿Has olvidado la contraseña?</a>
        </div>              
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Entrar</button> 
        </div>  
    </form>
</div>

@endsection

