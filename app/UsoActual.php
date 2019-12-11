<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsoActual extends Model
{
	public $timestamps = false;
	
    /**
     * Obtener las fichas para este Uso actual.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }
}
