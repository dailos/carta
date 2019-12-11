<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Isla extends Model
{
    public $timestamps = false;
    
    /**
     * Obtener las fichas para esta Isla.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }

    /**
     * Get the municipios for the isla.
     */
    public function municipios()
    {
        return $this->hasMany('App\Municipio');
    }

    /**
     * Get all of the localidades for the isla.
     */
    public function localidades()
    {
        return $this->hasManyThrough('App\Localidad', 'App\Municipio');
    }
}
