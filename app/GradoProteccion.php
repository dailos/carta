<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradoProteccion extends Model
{
    public $timestamps = false;

    /**
     * Obtener las fichas para este Grado de protección.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
