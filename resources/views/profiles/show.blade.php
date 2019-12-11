@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <div class="container">
        <div class="row mb-2">
            <div class="col-lg-4 col-md-4 col-12 mb-4">
                <h3>DATOS DE USUARIO</h3>
            </div>
            <div class="col-lg-4 col-md-4 col-12 mb-4">
                <a href="{{ route('profile.show.changepassword') }}" class="btn btn-outline-secondary btn-block">Cambiar contraseña</a>
            </div>
            <div class="col-lg-4 col-md-4 col-12 mb-4">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-block">Editar</a>
            </div>
        </div>

        @include('shared_partials.users.show-fields')
    </div>
</div>

@endsection
