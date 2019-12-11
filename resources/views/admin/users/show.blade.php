@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <h3>DATOS DE USUARIO</h3>
            </div>
            <div class="col-lg-4 col-md-4 offset-md-2 col-12">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-info btn-block">Volver</a>
            </div>
        </div>
        <br>

        @include('shared_partials.users.show-fields')

        <br><br>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <label>Rol</label>
                <input type="text" class="form-control" value="{{ ucfirst(__('carta.' . $user->roles->first()->name)) }}" readonly>
            </div>
            @if ($user->roles->first()->name == 'collaborator')
            <div class="col-lg-6 col-md-6">
                <label>Municipio(s)</label>
                <input type="text" class="form-control" value="{{ implode(', ', $user->municipios_list) }}" readonly>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

