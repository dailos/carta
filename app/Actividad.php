<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
	public $timestamps = false;

    /**
     * Obtener la fichas para la actividad.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
