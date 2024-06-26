<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelProteccion extends Model
{
    public $timestamps = false;

    /**
     * Obtener las fichas para este Nivel de protección.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
