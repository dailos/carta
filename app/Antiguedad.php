<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antiguedad extends Model
{
    public $timestamps = false;

    /**
     * Obtener la fichas para la antigüedad.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
