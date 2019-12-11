@extends('layouts.admin')

@section('content')

<div id="edit-profile" class="container-fluid">
    <div class="container">
        <form method="POST" action="{{ route('profile.update') }}" aria-label="Editar perfil">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <h3>EDICIÓN DATOS USUARIO</h3>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <button type="submit" class="btn btn-outline-secondary btn-block">Guardar</button>
                    <br>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-danger btn-block">Cancelar</a>
                    <br>
                </div>  
            </div>
            <br>

            @include('shared_partials.users.edit-fields')
        </form>

        <br>
        @include('shared_partials.errors')

    </div>
</div>

@endsection
