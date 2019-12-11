<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    public $timestamps = false;

    /**
     * Obtener las fichas para este Estado.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
