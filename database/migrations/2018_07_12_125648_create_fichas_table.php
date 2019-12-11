<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFichasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cod_ficha')->unique()->nullable();
            $table->unsignedInteger('X')->nullable();
            $table->unsignedInteger('Y')->nullable();
            $table->tinyInteger('zona_UTM')->nullable();
            $table->unsignedInteger('Xpiconieves')->nullable();
            $table->unsignedInteger('Ypiconieves')->nullable();
            $table->float('latitud', 18,15)->nullable();
            $table->float('longitud', 18,15)->nullable();
            $table->string('denominacion')->nullable();
            $table->unsignedInteger('isla_id')->nullable();
            $table->foreign('isla_id')
                ->references('id')
                ->on('islas');
            $table->unsignedInteger('municipio_id')->nullable();
            $table->foreign('municipio_id')
                ->references('id')
                ->on('municipios');
            $table->unsignedInteger('localidad_id')->nullable();
            $table->foreign('localidad_id')
                ->references('id')
                ->on('localidads');
            $table->string('lugar')->nullable(); // Nuevo campo con información extra sobre el lugar
            $table->string('numero_dgph')->nullable();
            $table->unsignedInteger('actividad_id')->nullable();
            $table->foreign('actividad_id')
                ->references('id')
                ->on('actividads');
            $table->unsignedInteger('grupo_id')->nullable();
            $table->foreign('grupo_id')
                ->references('id')
                ->on('grupos');
            $table->unsignedInteger('tipo_id')->nullable();
            $table->foreign('tipo_id')
                ->references('id')
                ->on('tipos');
            $table->string('direccion', 100)->nullable(); // Une calle y número del modelo original
            $table->string('cod_postal', 20)->nullable(); // Cambiado a texto
            $table->string('telefono', 50)->nullable();
            $table->unsignedInteger('altitud')->nullable();
            $table->string('toponimias', 100)->nullable();
            $table->string('cartografia', 100)->nullable();
            $table->text('obs_localizacion')->nullable();
            $table->string('fecha_construccion', 50)->nullable();
            $table->unsignedInteger('antiguedad_id')->nullable();
            $table->foreign('antiguedad_id')
                ->references('id')
                ->on('antiguedads');
            $table->text('historia')->nullable();
            $table->unsignedInteger('superficie')->nullable();
            $table->unsignedInteger('uso_actual_id')->nullable();
            $table->foreign('uso_actual_id')
                ->references('id')
                ->on('uso_actuals');
            $table->text('descripcion')->nullable();
            $table->boolean('dest_obras')->nullable();
            $table->boolean('saqueos')->nullable();
            $table->boolean('otras')->nullable();
            $table->boolean('alte_naturales')->nullable();
            $table->unsignedInteger('estado_id')->nullable();
            $table->foreign('estado_id')
                ->references('id')
                ->on('estados');
            $table->unsignedInteger('fragilidad_id')->nullable();
            $table->foreign('fragilidad_id')
                ->references('id')
                ->on('fragilidads');
            $table->unsignedInteger('valor_cientifico_id')->nullable();
            $table->foreign('valor_cientifico_id')
                ->references('id')
                ->on('valor_cientificos');
            $table->text('obs_estado')->nullable();
            $table->text('documentacion')->nullable();
            $table->unsignedInteger('propiedad_id')->nullable();
            $table->foreign('propiedad_id')
                ->references('id')
                ->on('propiedads');
            $table->boolean('declaracion_BIC')->nullable();
            $table->dateTime('fecha_incoacion')->nullable();
            $table->dateTime('fecha_declaracion')->nullable();
            $table->unsignedInteger('clasificacion_suelo_id')->nullable();
            $table->foreign('clasificacion_suelo_id')
                ->references('id')
                ->on('clasificacion_suelos');
            $table->unsignedInteger('calificacion_suelo_id')->nullable();
            $table->foreign('calificacion_suelo_id')
                ->references('id')
                ->on('calificacion_suelos');
            $table->string('catalogo', 50)->nullable();
            $table->tinyInteger('nivel_proteccion')->nullable();
            $table->unsignedInteger('grado_proteccion_id')->nullable();
            $table->foreign('grado_proteccion_id')
                ->references('id')
                ->on('grado_proteccions');
            $table->text('intervenciones')->nullable();
            $table->text('sugerencias')->nullable();
            $table->text('obs_generales')->nullable();
            $table->json('fotos')->nullable();
            $table->json('enlaces')->nullable();
            $table->json('multimedia')->nullable();
            $table->json('contactos')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fichas');
    }
}
