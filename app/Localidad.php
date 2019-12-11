<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    public $timestamps = false;

    /**
     * Obtener las fichas para esta Localidad.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }

    /**
     * The isla that belong to the localidad.
     */
    public function isla()
    {
        return $this->municipio->belongsTo('App\Isla');
    }

    /**
     * The municipio that belong to the localidad.
     */
    public function municipio()
    {
        return $this->belongsTo('App\Municipio');
    }
}
