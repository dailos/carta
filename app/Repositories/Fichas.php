<?php

namespace App\Repositories;

use App\Ficha;
use App\User;
use App\Isla;
use App\Municipio;
use App\Localidad;
use App\Actividad;
use App\Grupo;
use App\Tipo;
use App\Antiguedad;
use App\UsoActual;
use App\Estado;
use App\Fragilidad;
use App\ValorCientifico;
use App\Propiedad;
use App\ClasificacionSuelo;
use App\CalificacionSuelo;
use App\GradoProteccion;
use App\TipoContacto;

/**
 * 
 */
class Fichas
{
	
	function __construct()
	{
		
	}

	public static function getRelatedModelsForSearch()
	{
		$islas = null;

		$municipios = Municipio::select('id', 'nombre as text')->where('isla_id', '=', config('carta.isla'))->get();

		$localidades = null;

		$actividades = Actividad::select('id', 'nombre as text')->get();
        $grupos = Grupo::select('id', 'nombre as text')->get();
        $tipos = Tipo::select('id', 'nombre as text')->get();
 
        return compact('islas', 'municipios', 'localidades', 'actividades', 'grupos', 'tipos');
	}

	public static function getRelatedModels(Ficha $ficha = null, User $user = null)
	{
		$islas = null;

		$municipios = null;

		if ($user == null) {
			$user = auth()->user();
		}

		// Isla y municipios colaborador
		if ($user->roles->first()->name == 'collaborator') {
			if ($ficha) {
				if ($ficha->isla_id) {
					$islas = Isla::select('id', 'nombre as text')->where('id', '=', config('carta.isla'))->get();
					$municipios = Municipio::select('id', 'nombre as text')->where('isla_id', '=', $ficha->isla_id)
					->wherein('id', $user->municipios->pluck('id')->toArray())
					->get();
				} else {
					// No debería llegar aquí
					abort(404);
				}
			} else {
				$islas = Isla::select('id', 'nombre as text')->where('id', '=', config('carta.isla'))->get();
				$municipios = Municipio::select('id', 'nombre as text')->where('isla_id', '=', config('carta.isla'))
				->wherein('id', $user->municipios->pluck('id')->toArray())
				->get();
			}
		// Administrador
		} else {
			$islas = Isla::select('id', 'nombre as text')->get();
			if ($ficha && $ficha->isla_id) {
				$municipios = Municipio::select('id', 'nombre as text')->where('isla_id', '=', $ficha->isla_id)
				->get();
			}
		}

		$localidades = null;

		if ($ficha) {
			if ($ficha->municipio_id) {
			    $localidades = Localidad::select('id', 'nombre as text')->where('municipio_id', '=', $ficha->municipio_id)
			    ->get();
			}
		}
		$actividades = Actividad::select('id', 'nombre as text')->get();
        $grupos = Grupo::select('id', 'nombre as text')->get();
        $tipos = Tipo::select('id', 'nombre as text')->get();
        $antiguedades = Antiguedad::select('id', 'nombre as text')->get();
        $usos_actuales = UsoActual::select('id', 'nombre as text')->get();
        $estados = Estado::select('id', 'nombre as text')->get();
        $fragilidades = Fragilidad::select('id', 'nombre as text')->get();
        $valores_cientificos = ValorCientifico::select('id', 'nombre as text')->get();
        $propiedades = Propiedad::select('id', 'nombre as text')->get();
        $clasificaciones_suelo = ClasificacionSuelo::select('id', 'nombre as text')->get();
        $calificaciones_suelo = CalificacionSuelo::select('id', 'nombre as text')->get();
        $grados_proteccion = GradoProteccion::select('id', 'nombre as text')->get();
        $tipos_contacto = TipoContacto::all();

        return compact('islas', 'municipios', 'localidades', 'actividades', 'grupos', 'tipos', 'antiguedades', 'usos_actuales', 'estados', 'fragilidades', 'valores_cientificos', 'propiedades', 'clasificaciones_suelo', 'calificaciones_suelo', 'grados_proteccion', 'tipos_contacto');
	}
}