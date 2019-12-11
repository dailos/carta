<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    public $timestamps = false;

    /**
     * Obtener las fichas para este Tipo.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
