<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->surname}";
    }

    /**
     * The municipios that belong to the user.
     */
    public function municipios()
    {
        return $this->belongsToMany('App\Municipio')->withTimestamps();
    }

    /**
     * Array con los municipios a los que pertenece el usario
     */
    public function getMunicipiosListAttribute()
    {
        return $this->municipios->pluck('nombre')->toArray();
    }

    public function moderable_records()
    {
        return $this->hasMany('App\ModerableRecord');
    }
}
