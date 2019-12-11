<p><h3>Información adicional</h3></p>

<label for="">Enlaces</label>

<enlace-url
    v-for="(item, index) in enlace_items"
    v-bind:item="item"
    v-bind:index="index"
    v-bind:key="item.key"
    v-on:remove="removeEnlace(index)">
</enlace-url>


<div class="form-row">
    <div class="form-group">
        <button class="btn btn-outline-primary" v-on:click.prevent="addNewEnlace">Añadir Enlace</button>
    </div>
</div>

<label for="">Multimedia</label>

<enlace-url
    v-for="(item, index) in video_items"
    v-bind:item="item"
    v-bind:index="index"
    v-bind:key="item.key"
    v-on:remove="removeVideo(index)">
</enlace-url>

<br>

<div class="form-row">
    <div class="form-group">
        <button class="btn btn-outline-primary" v-on:click.prevent="addNewVideo">Añadir video</button>
    </div>
</div>

