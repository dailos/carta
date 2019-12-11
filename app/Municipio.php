<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    public $timestamps = false;

    /**
     * Obtener las fichas para este Municipio.
     */
    public function fichas()
    {
        return $this->hasMany('App\Ficha');
    }

    /**
     * Obtener las localidades para este Municipio.
     */
    public function localidades()
    {
        return $this->hasMany('App\Localidad');
    }

	/**
     * The users that belong to the municipio.
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    /**
     * The isla that belong to the municipio.
     */
    public function isla()
    {
        return $this->belongsTo('App\Isla');
    }

}
