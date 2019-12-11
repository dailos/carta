<div class="row">
    <div class="col-lg-6 col-md-6">
        <label>Nombre</label>
        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name')?:$user->name }}" required autofocus>

        @if ($errors->has('name'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
    </div>
    <div class="col-lg-6 col-md-6">
        <label>Apellidos</label>
        <input id="surname" type="text" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname')?:$user->surname }}" required autofocus>

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
        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username')?:$user->username }}" required autofocus>

        @if ($errors->has('username'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('username') }}</strong>
        </span>
        @endif
    </div>
    <div class="col-lg-6 col-md-6">
        <label>Correo electronico</label>
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email')?:$user->email }}" required>

        @if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
    </div>
</div>