<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use App\Foto;
use App\Ficha;

/**
 * 
 */
class Fotos
{

	/**
	 * Guarda las fotos creado modelos y almacena el fichero en storage
	 *
     * @param  array  $fotos
     * @return array
	 */
	function save($fotos)
	{
		$ids = null;

		if ($fotos) {
			foreach ($fotos as $value) {
				$foto_id = $value['id'];
                
                // Procesar nueva foto subida
                if ($foto_id == null) {
                    // Alamacenar fichero                    
                    $file = $value['fichero'];                   
                    $path = $file->store(config('carta.fotoStoragePath'));
                    
                    $foto = new Foto();

                    // Crear foto
                    $foto->src = $path;
                    $foto->nombre = $file->getClientOriginalName();

                    $foto->save();

                    $foto_id = $foto->id;
                }

                // Guardar el identificador de la foto
               	$ids[] = intval($foto_id);
			}
		}

		return $ids;
	}

	/**
	 * Elimina todas las fotos del parámetro de entrada (array de ids)
	 *
	 * @param  array  $fotos
	 */
	protected function delete($fotos) {
		if ($fotos && !empty($fotos)) {
			$fotosColl = Foto::find($fotos);

			foreach ($fotosColl as $foto) {
				Storage::delete($foto->src);
				$foto->delete();
			}
		}
	}

 	/**
 	 * Elimina las fotos de $fotos1 que no estén en $fotos2
 	 *
 	 * @param  array  $fotos1 Array con fotos y croquis
 	 * @param  array  $fotos2 Array con fotos y croquis
 	 */
	public function deleteDiff($fotos1, $fotos2) {
		// Borrar fotos
		if ($fotos1 && $fotos1['fotos']) {
			if ($fotos2['fotos']) {
				$diff = array_diff($fotos1['fotos'], $fotos2['fotos']);
			    $this->delete($diff);
			} else {
				$this->delete($fotos1['fotos']); // Este caso no debería darse porque al menos una foto es requerida
			}
		}

		// Borrar croquis
		if ($fotos1 && $fotos1['croquis']) {
			if ($fotos2['croquis']) {
				$diff = array_diff($fotos1['croquis'], $fotos2['croquis']);
			   	$this->delete($diff);
			} else {
				$this->delete($fotos1['croquis']);
			}
		}
	}

	/**
 	 * Elimina todas las fotos y croquis pasados en el parámetro
 	 *
 	 * @param  array  $fotos Array con fotos y croquis
 	 */
	public function deleteAll($fotos) {

	    if (isset($fotos['fotos'])) {
		    $this->delete($fotos['fotos']);
	    }

	    if (isset($fotos['croquis'])) {
        	$this->delete($fotos['croquis']);
	    }

	}

}