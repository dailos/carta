<script>
	var ComponentFoto = {
		props: ['foto'],
		data: function () {
		    return {
		      img_src: this.foto.src
		    }
		  },
		template: '<div class="col-lg-4 col-md-4 col-sm-6 col-12">\
      		<div class="img-wrapper">\
				<img :src="foto.src" class="img-responsive">\
				<div class="img-overlay">\
				  <i class="fas fa-times delete" title="Eliminar foto" v-on:click.prevent="$emit(\'remove\')"></i>\
				</div>\
				<input type="file" :id="foto.input_file_id" :name="foto.input_file_name" v-on:change="previewFoto" accept="image/*" class="inputfile" />\
				<label :for="foto.input_file_id">Selecciona fichero</label>\
				<input type="hidden" v-model="foto.id" :name="foto.id_name" >\
			</div>\
			</div>',
		methods: {
			previewFoto: function (e) {
				// console.log(e);
				var input = e.target;

				// console.log(input);
				// console.log(this.foto);

				if (input.files && input.files[0]) {
				    const reader = new FileReader();

				    reader.onload = (e) => {
				        this.foto.src = e.target.result;
				    }

				    reader.readAsDataURL(input.files[0]);
				}
				this.foto.id = null;
				return;
			}
		}
	}

	var ComponentEnlace = {
		props: ['item'],
		template: '<div class="form-row">\
		    <div class="form-group col-md-4">\
		        <input class="form-control" type="text" v-model="item.text_value" :name="item.text_name" placeholder="Introduce nombre">\
		    </div>\
		    <div class="form-group col-md-6">\
		        <input class="form-control" type="text" v-model="item.url_value" :name="item.url_name" placeholder="Introduce url">\
		    </div>\
		    <div class="form-group col-md-2">\
		        <button class="btn btn-outline-secondary" v-on:click.prevent="$emit(\'remove\')">Eliminar</button>\
		    </div>\
		</div>',
	}
</script>