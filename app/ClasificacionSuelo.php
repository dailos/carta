<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClasificacionSuelo extends Model
{
    public $timestamps = false;

    /**
     * Obtener las fichas para esta Clasificación de suelo.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
