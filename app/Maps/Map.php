<?php

namespace App\Maps;

use Mapper;
use GeoCoord;
use App\Ficha;

/**
 * 
 */
class Map
{
	/**
	 * Crea un mapa centrado en las coordenadas de la ficha
	 *
     * @param  \App\Ficha  $ficha
     * @param  array  $options
     * @return boolean
	 */
	public static function create(Ficha $ficha, $options = [])
	{
		// Comprobar si hay cooordenadas
		if ($coords = self::getCoords($ficha)) {
		    Mapper::map($coords['lat'], $coords['lon'], $options);
		    return true;
		} else {
			return false;
		}
	}

	/**
	 * Crea un mapa con las localizaciones de las fichas y una ventana informativa
	 *
     * @param  \Illuminate\Database\Eloquent\Collection|array  $fichas
     * @param  array  $options
	 */
	public static function createWithInfo($fichas, $options = [])
	{
		$found = false;

		// Crear mapa
		foreach ($fichas as $ficha) {
			if ($coords = self::getCoords($ficha)) {
				Mapper::map($coords['lat'], $coords['lon'], $options);
				$found = true;
				break;
			}
		}

		// Crear mapa por defecto
		if (!$found) {
			self::createDefault();
		}

		// Crear infoWindows
		foreach ($fichas as $ficha) {
			self::createInfoWindow($ficha);
		}
	}

	/**
	 * Crea un mapa centrado en una localizacion por defecto
	 *
     * @param  array  $options
	 */
	public static function createDefault($options = ['zoom' => 10, 'center' => true, 'marker' => false])
	{
		//  centramos en el Pico de las Nieves
	    Mapper::map(config('carta.coords_pico_nieves.latitud'), config('carta.coords_pico_nieves.longitud'), $options);
	}

	/**
	 * Crea un ventana informativa en el mapa para una ficha
	 *
     * @param  \App\Ficha  $ficha
     * @return boolean
	 */
	public static function createInfoWindow(Ficha $ficha)
	{
		if ($coords = self::getCoords($ficha)) {
			$descripcion = strlen($ficha->descripcion) < 100 ? $ficha->descripcion : substr($ficha->descripcion, 0, 100);

			$tipologias_arr = array();

			if($ficha->actividad) {
			    array_push($tipologias_arr, $ficha->actividad->nombre);
			}
			if($ficha->grupo) {
			    array_push($tipologias_arr, $ficha->grupo->nombre);
			}
			if($ficha->tipo) {
			    array_push($tipologias_arr, $ficha->tipo->nombre);
			}

			$tipologias = implode(', ', $tipologias_arr);

			// Inserta marca y ventana informativa
		    Mapper::informationWindow($coords['lat'], $coords['lon'],
		        view('fichas.partials.infowindow', compact('ficha', 'tipologias', 'descripcion'))->render(),
		            ['title' => $ficha->denominacion, 'maxWidth'=> 250]);

		   	return true;
		} else {
			return false;
		}
	}

	/**
	 * Renderiza el mapa
	 *
     * @return Map render
	 */
	public static function render() {
		return Mapper::render();
	}

	/**
	 * Devuelve las coordenadas de la ficha latitud-longitud. Si estas no existen pero hay
	 * coordenas UTM las convierte a lat-lon y las devuelve.
	 *
     * @param  \App\Ficha  $ficha
     * @return array|boolean=false
	 */
	public static function getCoords(Ficha $ficha) {
		if ($ficha->latitud && $ficha->longitud ) {
			return ['lat' => $ficha->latitud, 'lon' => $ficha->longitud];
		} elseif ($ficha->X && $ficha->Y && $ficha->zona_UTM) {
            return GeoCoord::toLatLon($ficha->Y, $ficha->X, $ficha->zona_UTM);
		} else {
			return false;
		}
	}

}