<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fragilidad extends Model
{
    public $timestamps = false;

    /**
     * Obtener las fichas para esta Fragilidad.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
