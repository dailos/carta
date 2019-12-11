@extends('layouts.admin')

@section('content')

<div id="edit-user" class="container-fluid">
    <div class="container">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" aria-label="Editar usuario">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <h3>EDICIÓN DE USUARIOS</h3>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <button type="submit" class="btn btn-outline-secondary btn-block">Guardar</button>
                    <br>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-danger btn-block">Cancelar</a>
                    <br>
                </div>  
            </div>
            <br>

            @include('shared_partials.users.edit-fields')

            <br><br>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label>Rol</label>
                    <input type="text" class="form-control" value="{{ ucfirst(__('carta.' . $user->roles->first()->name)) }}" readonly>
                </div>

                @if ($user->roles->first()->name == 'collaborator')
                <div class="col-lg-6 col-md-6">
                    <label>Municipio(s)</label>
                    <select class="js-basic-multiple form-control{{ $errors->has('municipios') ? ' is-invalid' : '' }}" name="municipios[]" multiple="multiple" autofocus>
                        @foreach($municipios as $municipio)
                        <option value="{{ $municipio->id }}" 
                            @if(old('municipios'))
                            @if (in_array($municipio->id, old('municipios')))
                            selected
                            @endif
                            @elseif(!$errors->any() && in_array($municipio->id, $municipios_user))
                            selected
                            @endif>
                            {{ $municipio->nombre }}
                        </option>
                        @endforeach
                    </select>

                    @if ($errors->has('municipios'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('municipios') }}</strong>
                    </span>
                    @endif
                </div>
                @endif

            </div>
        </form>

        <br>
        @include('shared_partials.errors')

    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.js-basic-multiple').select2();
    });
</script>
@endpush
