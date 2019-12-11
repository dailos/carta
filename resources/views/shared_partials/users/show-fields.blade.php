<div class="row">
    <div class="col-lg-6 col-md-6">
        <label>Nombre</label>
        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
    </div>
    <div class="col-lg-6 col-md-6">
        <label>Apellidos</label>
        <input type="text" class="form-control" value="{{ $user->surname }}" readonly>
    </div>
</div>
<br><br>
<div class="row">
    <div class="col-lg-6 col-md-6">
        <label>Nombre de Usuario</label>
        <input type="text" class="form-control" value="{{ $user->username }}" readonly>
    </div>
    <div class="col-lg-6 col-md-6">
        <label>Correo electronico</label>
        <input type="email" class="form-control" value="{{ $user->email }}" readonly>
    </div>
</div>  
