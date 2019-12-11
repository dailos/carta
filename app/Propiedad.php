<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    public $timestamps = false;

    /**
     * Obtener las fichas para esta Propiedad.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
