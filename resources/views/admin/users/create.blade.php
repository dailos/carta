@extends('layouts.admin')

@section('content')

<div id="create-user" class="container-fluid">
    <div class="container">
        <form method="POST" action="{{ route('admin.users.store') }}" aria-label="Crear usuario">
            @csrf
        
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <h3>CREACIÓN DE USUARIOS</h3>
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

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label>Nombre</label>
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-lg-6 col-md-6">
                    <label>Apellidos</label>
                    <input id="surname" type="text" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname') }}" required autofocus>

                    @if ($errors->has('surname'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('surname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label>Nombre de Usuario</label>
                    <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-lg-6 col-md-6">
                    <label>Correo electronico</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>  
            <br><br>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label>Rol</label>
                    <select class="custom-select" name="userrole" v-model="role" v-on:change="userrole = role">
                        <option value="collaborator">Colaborador</option>
                        <option value="admin">Administrador</option>
                    </select>
                    @if ($errors->has('userrole'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('userrole') }}</strong>
                        </span>
                    @endif
                     
                </div>
                <div v-show="showMunicipios" class="col-lg-6 col-md-6">
                    <label>Municipio(s)</label>
                    <select class="js-basic-multiple form-control{{ $errors->has('municipios') ? ' is-invalid' : '' }}" name="municipios[]" multiple="multiple" autofocus>
                        @foreach($municipios as $municipio)
                            <option value="{{ $municipio->id }}" 
                                @if(old('municipios') && in_array($municipio->id, old('municipios')))
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
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    var vm = new Vue({
        el: "#create-user",
        data: {
            role: '',
        },
        created: function () {
            this.userrole = @if (old('userrole')) '{{ old('userrole') }}' @else 'collaborator' @endif;
        },
        computed: {
            userrole: {
                get: function () {
                    return this.role
                },
                set: function (role) {
                    this.role = role;
                    if (role == 'collaborator') {
                        this.showMunicipios = true;
                    } else {
                        this.showMunicipios = false;
                        $('.js-basic-multiple').val(null).trigger('change');
                    }
                }
            }
        }
    });

    $(document).ready(function() {
        $('.js-basic-multiple').select2();
    });
</script>
@endpush
