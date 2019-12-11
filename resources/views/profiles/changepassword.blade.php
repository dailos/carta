@extends('layouts.admin')

@section('content')

<div id="edit-profile" class="container-fluid">
    <div class="container">
        <form method="POST" action="{{ route('profile.changepassword') }}" aria-label="Editar perfil">
            @csrf

            <div class="row mb-4">
                <div class="col-lg-4 col-md-4 col-12 mb-2">
                    <h3>CAMBIAR CONTRASEÑA</h3>
                </div>
                <div class="col-lg-4 col-md-4 col-12 mb-4">
                    <button type="submit" class="btn btn-outline-secondary btn-block">Confirmar</button>
                </div>
                <div class="col-lg-4 col-md-4 col-12 mb-4">
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-danger btn-block">Cancelar</a>
                </div>  
            </div>

            <div class="form-group">
                <label>Contraseña actual</label>
                <input id="current_password" type="password" class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}" name="current_password" required>

                @if ($errors->has('current_password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('current_password') }}</strong>
                    </span>
                @endif
            </div> 

            <div class="form-group">
                <label>Nueva contraseña</label>
                <input id="new_password" type="password" class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" name="new_password" required>

                @if ($errors->has('new_password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('new_password') }}</strong>
                    </span>
                @endif
            </div>  
            <div class="form-group">
                <label>Confirmar contraseña</label>
                <input id="new_password-confirm" type="password" class="form-control" name="new_password_confirmation" required>
            </div>                                              

        </form>

        @include('shared_partials.errors')

    </div>
</div>

@endsection
