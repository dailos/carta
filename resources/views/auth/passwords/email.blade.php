@extends('layouts.login')

@section('content')
<div class="login">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST" accept-charset="utf-8" aria-label="Reiniciar contraseña">
        @csrf

        <div class="form-group">
            <label>Dirección de e-mail</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>  
                
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Enviar un enlace para reiniciar contraseña</button>  
        </div>  
    </form>
</div>

@endsection
