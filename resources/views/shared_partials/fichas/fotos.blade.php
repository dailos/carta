<h4>Modificar Imagenes</h4>
<p>Seleccione las imágenes que quiere subir o modificar de la ficha</p>

<div id="tabs">

  <div class="tabs">
    <a v-on:click="activetab=1" v-bind:class="[ activetab === 1 ? 'active' : '' ]">Fotos</a>
    <a v-on:click="activetab=2" v-bind:class="[ activetab === 2 ? 'active' : '' ]">Croquis</a>
  </div>

  <div class="content">
    <div v-show="activetab === 1" class="tabcontent">
      <div class="container">
        <div class="row">
          <foto
          v-for="(foto, index) in foto_items"
          v-bind:foto="foto"
          v-bind:index="index"
          v-bind:key="foto.key"
          v-on:remove="removeFoto(index)"
          >
        </foto>
      </div>
    </div>
  </div>
  <div v-show="activetab === 2" class="tabcontent">
    <div class="container">
      <div class="row">
        <foto
        v-for="(foto, index) in croquis_items"
        v-bind:foto="foto"
        v-bind:index="index"
        v-bind:key="foto.key"
        v-on:remove="removeCroquis(index)">
      </foto>
    </div>
  </div>
</div>

</div>

</div>
<br>

<div>
  <button class="btn btn-outline-primary" v-if="(foto_items.length < maxFotoItems) && activetab === 1" v-on:click.prevent="addNewFoto">Añadir foto</button>

  <button class="btn btn-outline-primary" v-if="(croquis_items.length < maxCroquisItems) && activetab === 2" v-on:click.prevent="addNewCroquis">Añadir croquis</button>

</div>

<br>

@if ($errors->has('fotos'))
<div class="alert alert-danger" role="alert">
  <strong>{{ $errors->first('fotos') }}</strong>
</div>
</span>
@endif

@if ($errors->has('croquis'))
<div class="alert alert-danger" role="alert">
  <strong>{{ $errors->first('croquis') }}</strong>
</div>
</span>
@endif
