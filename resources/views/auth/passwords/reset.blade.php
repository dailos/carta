@extends('layouts.login')

@section('content')
<div class="login">
    <form action="{{ route('password.request') }}" method="POST" accept-charset="utf-8" aria-label="Reiniciar contraseña">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label>Dirección de e-mail</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>  
        <div class="form-group">
            <label>Contraseña</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>  
        <div class="form-group">
            <label>Confirmar contraseña</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
        </div>                                              
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Confimar cambio</button>    
        </div>  
    </form>
</div>

@endsection
