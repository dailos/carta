<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalificacionSuelo extends Model
{
	public $timestamps = false;

    /**
     * Obtener las fichas para esta Calificación de Suelo.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
