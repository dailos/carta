<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValorCientifico extends Model
{
    public $timestamps = false;

    /**
     * Obtener las fichas para este Valor científico.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
