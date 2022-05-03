<?php

namespace App;

use App\Traits\Moderable;
use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{

    use Moderable;

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'saqueos' => 'boolean',
        'dest_obras' => 'boolean',
        'alte_naturales' => 'boolean',
        'otras' => 'boolean',
        'declaracion_BIC' => 'boolean',
        'fotos' => 'array',
        'enlaces' => 'array',
        'multimedia' => 'array',
        'contactos' => 'array',
        // 'fecha_incoacion' => 'date:Y-m-d',
        // 'fecha_declaracion' => 'date:Y-m-d',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'fecha_incoacion',
        'fecha_declaracion',
    ];

    protected $searchableModels = [
        'municipio',
        'localidad',
        'antiguedad',
        'uso_actual',
        'actividad',
        'grupo',
        'tipo',
        'clasificacion_suelo',
        'calificacion_suelo',
    ];

    protected $searchableFields = [
        'denominacion',
        'lugar',
        'numero_dgph',
        'toponimias',
        'cartografia',
        'obs_localizacion',
        'descripcion',
        'obs_estado',
    ];

    protected $searchableModelFilters = [
        'municipio',
        'uso_actual',
        'actividad',
        'grupo',
        'tipo',
        'clasificacion_suelo',
    ];

    /**
     * Obtener los campos buscables.
     *
     * @return array
     */
    public function getSearchableFields()
    {
        return $this->searchableFields;
    }

    /**
     * Obtener los modelos para los filtros de búsqueda.
     *
     * @return array
     */
    public function getSearchableModelFilters()
    {
        return $this->searchableModelFilters;
    }

    /**
     * Obtener los modelos asociados buscables.
     *
     * @return array
     */
    public function getSearchableModels()
    {
        return $this->searchableModels;

        // $record = $this->toArray();

        // // Añade atributos buscables en modelos relacionados
        // foreach ($this->searchableModels as $model) {
        //     if ($this->$model) {
        //         $record[$model] = $this->$model->nombre;
        //     }
        // }

        // return $record;
    }

    // public function scopeModels($query, $name)
    // {

    //     foreach ($this->searchableModels as $model) {
    //         ->orWhere($model . '_id', 'like', '%' . $key . '%');
    //     }
    // }

    // public function setFechaIncoacionFromFormatAttribute( $value ) {
    //     if ($value) {
    //         $this->attributes['fecha_incoacion'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    //     } else {
    //         $this->attributes['fecha_incoacion'] = null;
    //     }
    // }

    public function getFechaIncoacionFormatedAttribute() {
        if ($this->fecha_incoacion) {
            return $this->fecha_incoacion->format('d/m/Y');
        } else {
            return null;
        }
    }

    // public function setFechaDeclaracionFromFormatAttribute( $value ) {
    //     if ($value) {
    //         $this->attributes['fecha_declaracion'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    //     } else {
    //         $this->attributes['fecha_declaracion'] = null;
    //     }
    // }

    public function getFechaDeclaracionFormatedAttribute() {
        if ($this->fecha_declaracion) {
            return $this->fecha_declaracion->format('d/m/Y');
        } else {
            return null;
        }
    }

    /**
     *
     *
     *
     */
    public function getGrupoTipoAttribute()
    {

       // isset($this->grupo) ? $this->grupo->nombre : 'SIN GRUPO' . ' / ' . isset($this->tipo) ? $this->tipo->nombre : 'SIN TIPO';

        if (isset($this->tipo)) {
            if (isset($this->grupo)) {
                return $this->grupo->nombre . " / " . $this->tipo->nombre;
            } else {
                return "SIN GRUPO / " . $this->tipo->nombre;
            }
        } else {
            if (isset($this->grupo)) {
                $this->grupo->nombre . " / SIN TIPO";
            }
        }

        return null;
    }

    public function getSaqueosTextAttribute()
    {
        if(isset($this->saqueos)) {
            return $this->saqueos ? 'SI' : 'NO';
        } else {
            return null;
        }
    }

    public function getDestObrasTextAttribute()
    {
        if(isset($this->dest_obras)) {
            return $this->dest_obras ? 'SI' : 'NO';
        } else {
            return null;
        }
    }

    public function getAlteNaturalesTextAttribute()
    {
        if(isset($this->alte_naturales)) {
            return $this->alte_naturales ? 'SI' : 'NO';
        } else {
            return null;
        }
    }

    public function getOtrasTextAttribute()
    {
        if(isset($this->otras)) {
            return $this->otras ? 'SI' : 'NO';
        } else {
            return null;
        }
    }

    public function getDeclaracionBICTextAttribute()
    {
        if(isset($this->declaracion_BIC)) {
            return $this->declaracion_BIC ? 'SI' : 'NO';
        } else {
            return null;
        }
    }

    public function setSaqueosAttribute($value)
    {
        $this->attributes['saqueos'] = $value ? 1 : 0;
    }

    public function setDestObrasAttribute($value)
    {
        $this->attributes['dest_obras'] = $value ? 1 : 0;
    }

    public function setAlteNaturalesAttribute($value)
    {
        $this->attributes['alte_naturales'] = $value ? 1 : 0;
    }

    public function setOtrasAttribute($value)
    {
        $this->attributes['otras'] = $value ? 1 : 0;
    }

    public function setNewCodFicha($codFicha)
    {
        $this->cod_ficha = $codFicha;
        $this->save();
    }


    /**
     * Obtener la antiguedad a la que pertenece la ficha.
     */
    public function antiguedad()
    {
        return $this->belongsTo('App\Antiguedad');
    }

    /**
     * Obtener el uso actual al que pertenece la ficha.
     */
    public function uso_actual()
    {
        return $this->belongsTo('App\UsoActual');
    }

    /**
     * Obtener el estodo al que pertenece la ficha.
     */
    public function estado()
    {
        return $this->belongsTo('App\Estado');
    }

    /**
     * Obtener la fragilidad a la que pertenece la ficha.
     */
    public function fragilidad()
    {
        return $this->belongsTo('App\Fragilidad');
    }

    /**
     * Obtener la clasificacion suelo a la que pertenece la ficha.
     */
    public function clasificacion_suelo()
    {
        return $this->belongsTo('App\ClasificacionSuelo');
    }

    /**
     * Obtener la calificacion suelo a la que pertenece la ficha.
     */
    public function calificacion_suelo()
    {
        return $this->belongsTo('App\CalificacionSuelo');
    }

    /**
     * Obtener el valor cientifico al que pertenece la ficha.
     */
    public function valor_cientifico()
    {
        return $this->belongsTo('App\ValorCientifico');
    }

    /**
     * Obtener el grado_proteccion al que pertenece la ficha.
     */
    public function grado_proteccion()
    {
        return $this->belongsTo('App\GradoProteccion');
    }

    /**
     * Obtener la propiedad a la que pertenece la ficha.
     */
    public function propiedad()
    {
        return $this->belongsTo('App\Propiedad');
    }

    /**
     * Obtener la isla a la que pertenece la ficha.
     */
    public function isla()
    {
    	return $this->belongsTo('App\Isla');
    }

    /**
     * Obtener el municipio al que pertenece la ficha.
     */
    public function municipio()
    {
        return $this->belongsTo('App\Municipio');
    }

    /**
     * Obtener la localidad a la que pertenece la ficha.
     */
    public function localidad()
    {
        return $this->belongsTo('App\Localidad');
    }

    /**
     * Obtener la actividad a la que pertenece la ficha.
     */
    public function actividad()
    {
        return $this->belongsTo('App\Actividad');
    }

    /**
     * Obtener el grupo al que pertenece la ficha.
     */
    public function grupo()
    {
        return $this->belongsTo('App\Grupo');
    }

    /**
     * Obtener el tipo al que pertenece la ficha.
     */
    public function tipo()
    {
        return $this->belongsTo('App\Tipo');
    }

}
