<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    public $timestamps = false;

    /**
     * Obtener las fichas para este Grupo.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
