<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Ficha;
use App\Foto;
use App\Municipio;
use App\Localidad;
use App\Actividad;
use App\TipoContacto;
use Carbon\Carbon;
use App\Maps\GeoCoord;

class FichaCSVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//disable foreign key check for this connection before running seeder
		Schema::disableForeignKeyConstraints();
    	// Truncate tables
        DB::table('fotos')->truncate();
        DB::table('moderable_records')->truncate();
    	DB::table('fichas')->truncate();
    	//enable foreign key check
    	Schema::enableForeignKeyConstraints();

        // Elimina todas las fotos actuales
        // Storage::deleteDirectory(config('carta.fotoStoragePath'));

        $filename = storage_path(config('carta.ImportFilePath'));
        // $filename = storage_path('app/fichas_multimedia.csv');
    	// $filename = storage_path('app/fichas_enlaces.csv');
      	if (file_exists($filename)) {
      		$fichasArr = $this->csvToArray($filename);
      	} else {
      		echo("File " . $filename . " does not exist.\n");
      		return ;
      	}

  	    for ($i = 0; $i < count($fichasArr); $i ++) 
        {
  	    	// Saltarse fichas 0 o la ficha repetida
  	    	if (($fichasArr[$i]['Cod_ficha'] == 0) ||
  	    		(($fichasArr[$i]['Cod_ficha'] == 9300) && ($fichasArr[$i]['Isla'] != 'GRAN CANARIA')))
  	    		continue;

            $this->convertirCoordenadas($fichasArr[$i]);

  	    	$municipio_id = $this->getMunicipioId($fichasArr[$i]['Municipio']);

  	    	$lugar = $documentacion = null;
  	    	
	  	    $localidad_id = $this->getLocalidadId($fichasArr[$i]['Localidad'], $municipio_id, $lugar);

            $this->correcionModelos($fichasArr[$i]);

            $multimedia = $this->crearMultimedia($fichasArr[$i]);

            $enlaces = $this->crearEnlaces($fichasArr[$i], $documentacion);

            if ($documentacion) {
                $documentacion = ($fichasArr[$i]['Documentacion']) ? $fichasArr[$i]['Documentacion'] . "\r\n" . $documentacion : $documentacion;
            } else {
                $documentacion = ($fichasArr[$i]['Documentacion']) ? $fichasArr[$i]['Documentacion'] : null;
            }

            // Datos de contactos: propietario, representante, ....
            $contactos = $this->crearContactos($fichasArr[$i]);
			
			try {

	  	        $ficha = Ficha::FirstOrCreate([
	  	        	'cod_ficha' => $fichasArr[$i]['Cod_ficha'],
	  	        	'X' => ($fichasArr[$i]['X'])?$fichasArr[$i]['X']:null,
	  	        	'Y' => ($fichasArr[$i]['Y'])?$fichasArr[$i]['Y']:null,
                    'zona_UTM' => ($fichasArr[$i]['UTM_cuadrante'])?$fichasArr[$i]['UTM_cuadrante']:null,
	  	        	'Xpiconieves' => ($fichasArr[$i]['Xpiconieves'])?$fichasArr[$i]['Xpiconieves']:null,
	  	        	'Ypiconieves' => ($fichasArr[$i]['Ypiconieves'])?$fichasArr[$i]['Ypiconieves']:null,
	  	        	'latitud' => ($fichasArr[$i]['LAT_GOOGLE']) ? $fichasArr[$i]['LAT_GOOGLE'] : null,
	  	        	'longitud' => ($fichasArr[$i]['LON_GOOGLE']) ? $fichasArr[$i]['LON_GOOGLE'] : null,
	  	        	'denominacion' => ($fichasArr[$i]['Denominacion'])?$fichasArr[$i]['Denominacion']:null,
	  	        	'isla_id' => $this->getIslaId($fichasArr[$i]['Isla']),
	  	        	'municipio_id' => $municipio_id,
	  	        	'localidad_id' => $localidad_id,
	  	        	'lugar' => $lugar,
	  	        	'numero_dgph' => ($fichasArr[$i]['Numero'] != '')?$fichasArr[$i]['Numero']:null,
	  	        	'actividad_id' => $this->getModeloId($fichasArr[$i]['Actividad'], 'App\Actividad'),
	  	        	'grupo_id' => $this->getModeloId($fichasArr[$i]['Grupo'], 'App\Grupo'),
	  	        	'tipo_id' => $this->getModeloId($fichasArr[$i]['Tipo'], 'App\Tipo'),
	  	        	'direccion' => $this->getDireccion($fichasArr[$i]['Calle'], $fichasArr[$i]['Numero_calle']),
	  	        	'cod_postal' => ($fichasArr[$i]['Cod_postal'])?$fichasArr[$i]['Cod_postal']:null,
	  	        	'telefono' => ($fichasArr[$i]['Telefono'])?$fichasArr[$i]['Telefono']:null,
	  	        	'altitud' => ($fichasArr[$i]['Altitud'])?$fichasArr[$i]['Altitud']:null,
	  	        	'toponimias' => ($fichasArr[$i]['Toponimias'])?$fichasArr[$i]['Toponimias']:null,
	  	        	'cartografia' => ($fichasArr[$i]['Cartografia'])?$fichasArr[$i]['Cartografia']:null,
	  	        	'obs_localizacion' => ($fichasArr[$i]['Obs_localizacion'])?$fichasArr[$i]['Obs_localizacion']:null,
	  	        	'fecha_construccion' => ($fichasArr[$i]['Fecha_construccion'])?$fichasArr[$i]['Fecha_construccion']:null,
	  	        	'antiguedad_id' => $this->getModeloId($fichasArr[$i]['Antiguedad'], 'App\Antiguedad'),
	  	        	'historia' => ($fichasArr[$i]['Historia'])?$fichasArr[$i]['Historia']:null,
	  	        	'superficie' => ($fichasArr[$i]['Superficie'])?$fichasArr[$i]['Superficie']:null,
	  	        	'uso_actual_id' => $this->getModeloId($fichasArr[$i]['Uso_actual'], 'App\UsoActual'),
	  	        	'descripcion' => ($fichasArr[$i]['Descripcion'])?$fichasArr[$i]['Descripcion']:null,
	  	        	'dest_obras' => ($fichasArr[$i]['Dest_obras'])?$fichasArr[$i]['Dest_obras']:0,
	  	        	'saqueos' => ($fichasArr[$i]['Saqueos'])?$fichasArr[$i]['Saqueos']:0,
	  	        	'otras' => ($fichasArr[$i]['Otras'])?$fichasArr[$i]['Otras']:0,
	  	        	'alte_naturales' => ($fichasArr[$i]['Alte_naturales'])?$fichasArr[$i]['Alte_naturales']:0,
	  	        	'estado_id' => $this->getModeloId($fichasArr[$i]['Estado'], 'App\Estado'),
	  	        	'fragilidad_id' => $this->getModeloId($fichasArr[$i]['Fragilidad'], 'App\Fragilidad'),
	  	        	'valor_cientifico_id' => $this->getModeloId($fichasArr[$i]['Valor_cientifico'], 'App\ValorCientifico'),
	  	        	'obs_estado' => ($fichasArr[$i]['Obs_estado'])?$fichasArr[$i]['Obs_estado']:null,
	  	        	'documentacion' => $documentacion,
	  	        	'propiedad_id' => $this->getModeloId($fichasArr[$i]['Propiedad'], 'App\Propiedad'),
	  	        	'declaracion_BIC' => ($fichasArr[$i]['Declaracion_BIC'])?$fichasArr[$i]['Declaracion_BIC']:0,
	  	        	'fecha_incoacion' => $this->getDate($fichasArr[$i]['Fecha_incoacion']),
	  	        	'fecha_declaracion' => $this->getDate($fichasArr[$i]['Fecha_declaracion']),
	  	        	'clasificacion_suelo_id' => $this->getModeloId($fichasArr[$i]['Clasificacion_suelo'], 'App\ClasificacionSuelo'),
	  	        	'calificacion_suelo_id' => $this->getModeloId($fichasArr[$i]['Calificacion_suelo'], 'App\CalificacionSuelo'),
	  	        	'catalogo' => ($fichasArr[$i]['Catalogo'])?$fichasArr[$i]['Catalogo']:null,
	  	        	'nivel_proteccion' => ($fichasArr[$i]['Nivel_proteccion'])?$fichasArr[$i]['Nivel_proteccion']:null,
	  	        	'grado_proteccion_id' => $this->getModeloId($fichasArr[$i]['Propiedad'], 'App\Propiedad'),
	  	        	'intervenciones' => ($fichasArr[$i]['Intervenciones'])?$fichasArr[$i]['Intervenciones']:null,
	  	        	'sugerencias' => ($fichasArr[$i]['Sugerencias'])?$fichasArr[$i]['Sugerencias']:null,
	  	        	'obs_generales' => ($fichasArr[$i]['Obs_generales'])?$fichasArr[$i]['Obs_generales']:null,
	  	        	'enlaces' => $enlaces,
	  	        	'multimedia' => $multimedia,
                    'contactos' => $contactos,
                    // 'fotos' => null,
	  	        ]);

                $ficha->fotos = $this->crearFotos($fichasArr[$i], $ficha);
                $ficha->save();

            } catch (\Exception $e) {
                Log::error('Error al procesar la ficha ' . $fichasArr[$i]['Cod_ficha']);
                // Log::debug($e->getMessage());
                throw $e;
            }
        }
    }

    private function convertirCoordenadas(&$ficha)
    {
        if ($ficha['LAT_GOOGLE'] && $ficha['LON_GOOGLE']) {
            return;
        } else {
            if ($ficha['UTM_cuadrante'] && $ficha['X'] && $ficha['Y']) {

                $coords = GeoCoord::toLatLon($ficha['Y'], $ficha['X'], $ficha['UTM_cuadrante']);
                $ficha['LAT_GOOGLE'] = $coords['lat'];
                $ficha['LON_GOOGLE'] = $coords['lon'];
            }
        }
    }

    private function crearMultimedia(&$array)
    {
        $multimedia = null;

        // Casos especiales
        if ($array['Cod_ficha'] == 9650) {
            return null;
        }

        if ($array['Cod_ficha'] == 9645) {
            $array['Enlaces'] = $array['Incrustar_multimedia'];
            return null;
        }

        if ($array['Incrustar_multimedia']) {

            // Log::debug('antes: ' . $array['Incrustar_multimedia']);

            // Dividir la cadena por separador ; o salto de linea (\R)
            $multimedia_arr = array_filter( // Elimina elementos vacios
                array_map('trim', // Elimina espacios en blanco al principio y final
                    preg_split('/(\R)+|\;/', $array['Incrustar_multimedia'], -1, PREG_SPLIT_NO_EMPTY)
                )
            );

            if (!empty($multimedia_arr)) {
                $multimedia = array();
                foreach ($multimedia_arr as $key => $value) {
                    // Quitar del principio
                    if (!is_bool(strpos($value, 'v=')))
                        $value = 'https://www.youtube.com/watch?' . substr($value, strpos($value, 'v='));
                    elseif (!is_bool(strpos($value, 'ID_')))
                        $value = 'https://www.youtube.com/watch?v=' . substr($value, strpos($value, 'ID_')+strlen('ID_'));
                    elseif (!is_bool(strpos($value, 'youtube::[')))
                        $value = 'https://www.youtube.com/watch?v=' . substr($value, strpos($value, 'youtube::[')+strlen('youtube::['));
                    elseif (!is_bool(strpos($value, 'youtube::')))
                        $value = 'https://www.youtube.com/watch?v=' . substr($value, strpos($value, 'youtube::')+strlen('youtube::'));

                    // Quitar del final
                    if (!is_bool(strpos($value, '&')))
                        $value = substr($value, 0, strpos($value, '&'));
                    elseif (!is_bool(strpos($value, '_YOUTUBE')))
                        $value = substr($value, 0, strpos($value, '_YOUTUBE'));
                    elseif (!is_bool(strpos($value, ']')))
                        $value = substr($value, 0, strpos($value, ']'));

                    // Log::debug('despues: ' . $value);
                    $multimedia[] = array('url' => $value, 'descripcion' => '');
                }
                // Reindexa índices
                $multimedia = index_sort($multimedia, true);
            }
        }

        return $multimedia;
    }

    private function crearFotos($array, $ficha)
    {
        $ruta = "";
        $fotos = ['fotos' => null, 'croquis' => null];
    	
        if ($array['Nombre_foto']) {

            $url = config('carta.oldFotosUrl') . $array['Nombre_foto'];
            try {
                //$contents = file_get_contents($url);

                //Storage::put(config('carta.fotoStoragePath') . '/' . $array['Nombre_foto'] , $contents);

                $foto = new Foto;
                $foto->src = config('carta.fotoStoragePath') . '/' . $array['Nombre_foto'];
                $foto->nombre = $array['Nombre_foto'];
                $foto->save();

                $fotos['fotos'] = [];
                array_push($fotos['fotos'], $foto->id);

            } catch (Exception $e) {
                Log::error('Error al procesar la ficha ' . $array['Cod_ficha']);
                Log::error($e->getMessage());
            }
            
        }

        if ($array['Nombre_croquis']) {
            // $rand = rand(0, 1);

            // TODO Añadir croquis

            // if ($rand) {
            //     $fotofake = 'photos/croquis01.jpeg';

            //     $foto = new Foto;
            //     $foto->src = $fotofake;
            //     $foto->nombre = $array['Nombre_foto'];
            //     $foto->save();
                
            //     $fotos['croquis'] = [];
            //     array_push($fotos['croquis'], $foto->id);
            // } else {
            //     $fotos['croquis'] = null;
            // }
            // $foto = new Foto;
            // $foto->src = $ruta . $array['Nombre_croquis'];
            // $foto->nombre = $array['Nombre_foto'];
            // $foto->save();

            // $ficha->fotos()->save($foto);
            
            // $fotos['croquis'] = [];
            // array_push($fotos['croquis'], $foto->id);
        }

        return $fotos;

    }

    private function addHttp($url) {
        if  ( $ret = parse_url($url) ) {
            if ( !isset($ret["scheme"]) )
            {
               $url = "http://{$url}";
            }
        }

        return $url;
    }

    private function crearEnlaces($ficha_array, &$documentacion) {

    	$enlaces = null;
    	$cod_ficha = $ficha_array['Cod_ficha'];
    	$cadena = $ficha_array['Enlaces'];

    	if ($cadena) {

	    	// Dividir la cadena por separador ; o salto de linea (\R)

	    	switch ($cod_ficha) {
	    		case 9775:
	    		case 9776: // En estos dos casos el separador es ;+espacio
	    			$enlaces = array_filter( // Elimina elementos vacios
	    					array_map('trim', // Elimina espacios en blanco al principio y final
	    						preg_split('/\R$|\; /', $cadena, -1, PREG_SPLIT_NO_EMPTY)
	    					)
	    			);
	    			break;
	    		case 9677:
	    		case 9675:
	    		case 9678:
	    			$documentacion = ltrim($cadena);
	    			break;
	    		case 9816: // eliminar el texto ENLACE 1: antes de procesar
	    		case 9710: // eliminar el texto -  antes de procesar
	    			if (!is_bool(strpos($cadena, 'ENLACE 1: ')))
	    				$cadena = substr($cadena, strpos($cadena, 'ENLACE 1: ')+strlen('ENLACE 1: '));
	    			if (!is_bool(strpos($cadena, '- ')))
	    				$cadena = substr($cadena, strpos($cadena, '- ')+strlen('- '));
	    	
	    		default:
	    			$enlaces = array_filter( // Elimina elementos vacios
	    					array_map('trim', // Elimina espacios en blanco al principio y final
	    						preg_split('/(\R)+|\;/', $cadena, -1, PREG_SPLIT_NO_EMPTY)
	    					)
	    			);
	    			break;
	    	}
	       
	        if (!empty($enlaces)) {
	        	foreach ($enlaces as $key => $value) {
	        		$enlaces[$key] = array('texto' => '', 'url' => $this->addHttp($value));
	        	}
	        	// Log::debug('Cod ficha: ' . $cod_ficha);
	        	// Log::debug('enlaces: ' . print_r($enlaces, true));

	        	// Reindexa índices
	        	$enlaces = index_sort($enlaces, true);
	        	// Log::debug('enlaces: ' . print_r($enlaces, true));
	        } else {
	        	$enlaces = null;
	        }
    	}
    	return $enlaces;
    }

    private function crearContactos($array)
    {
        $contactos = array();

    	foreach ($tipos = array('propietario', 'representante', 'guardian', 'usuario') as $tipo)
    	{
    		if ($array['Nombre_' . $tipo] || $array['DNI_' . $tipo] || $array['Telefono_' . $tipo] || $array['Direccion_' . $tipo]) {
                $contactos[TipoContacto::where('nombre', strtoupper($tipo))->first()->id] = array_filter([
    				'nombre' => $array['Nombre_' . $tipo] ? trim($array['Nombre_' . $tipo]) : null,
    				'id_documento' => $array['DNI_' . $tipo] ? trim($array['DNI_' . $tipo]) : null,
    				'telefono' => $array['Telefono_' . $tipo] ? trim($array['Telefono_' . $tipo]) : null,
    				'direccion' => $array['Direccion_' . $tipo] ? trim($array['Direccion_' . $tipo]) : null,
    			]);
    		}
    	}

    	return $contactos ? index_sort($contactos) : null;
    }

    private function correcionModelos(&$ficha)
    {
    	if ($ficha['Antiguedad'] === 'MAS DE 500 AÑOS DE ANTIGUEDAD')
    	    $ficha['Antiguedad'] = 'SIGLO XV O ANTERIOR'; // TODO
    	
    	if ($ficha['Tipo'] === 'CASAS-CUEVAS')
    	    $ficha['Tipo'] = 'CASA-CUEVAS';

		if ($ficha['Tipo'] === 'CUERVA-REFUGIO')
    	    $ficha['Tipo'] = 'CUEVA-REFUGIO';

    	if ($ficha['Tipo'] === 'ESTANQUE DE TIERRA')
    	    $ficha['Tipo'] = 'ESTANQUES DE TIERRA';

		if ($ficha['Tipo'] === 'ALJIBES CUEVA')
    	    $ficha['Tipo'] = 'ALJIBES CUEVAS';
		
		if ($ficha['Tipo'] === 'EBANISTERÍA')
    	    $ficha['Tipo'] = 'EBANISTERÍA/CARPINTERÍA';

    	if ($ficha['Tipo'] === 'SOCDAD RECREATIVA/CASINO/SOCDAD DEPORTIVA')
    	    $ficha['Tipo'] = 'SOCIEDAD RECREATIVA/CASINO/SOCIEDAD DEPORTIVA';

    	if ($ficha['Grupo'] === 'VENTA PRODUCTOS')
    	    $ficha['Grupo'] = 'VENTA DE PRODUCTOS';

    	if ($ficha['Tipo'] === 'ALMACENES CURACION DE QUESO')
    	    $ficha['Tipo'] = 'ALMACENES DE CURACION DE QUESO';

    	if ($ficha['Calificacion_suelo'] === 'SUELO RÚSTICO DE PROTECCIÓN NATURAL')
    	    $ficha['Calificacion_suelo'] = 'RÚSTICO DE PROTECCIÓN NATURAL';

    	if ($ficha['Calificacion_suelo'] === 'SUELO RÚSTICO DE PROTECCIÓN AGRARIA')
    	    $ficha['Calificacion_suelo'] = 'RÚSTICO DE PROTECCIÓN AGRARIA';

    	if ($ficha['Calificacion_suelo'] === 'SUELO RÚSTICO DE ASENTAMIENTO RURAL')
    	    $ficha['Calificacion_suelo'] = 'RÚSTICO DE ASENTAMIENTO RURAL';

    	if ($ficha['Calificacion_suelo'] === 'SUELO RÚSTICO DE ASENTAMIENTO AGRÍCOLA')
    	    $ficha['Calificacion_suelo'] = 'RÚSTICO DE ASENTAMIENTO AGRÍCOLA';
    	
    	if ($ficha['Calificacion_suelo'] === 'SUELO RÚSTICO DE PROTECCIÓN PAISAJÍSTICA')
    	    $ficha['Calificacion_suelo'] = 'RÚSTICO DE PROTECCIÓN PAISAJÍSTICA';
    	
    	if ($ficha['Calificacion_suelo'] === 'RÚSTICO PROTECCIÓN INTEGRAL')
            $ficha['Calificacion_suelo'] = 'RÚSTICO DE PROTECCIÓN INTEGRAL';
        
    	

    	if ($ficha['Calificacion_suelo'] === 'URBANIZABLE') {
    	    $ficha['Calificacion_suelo'] = '';
    	    $ficha['Clasificacion_suelo'] = 'URBANIZABLE';
    	}

    	if ($ficha['Calificacion_suelo'] === 'URBANO NO CONSOLIDADO DE REHABILITACIÓN URBANA') {
    	    $ficha['Calificacion_suelo'] = '';
    	    $ficha['Calificacion_suelo'] = 'URBANO NO CONSOLIDADO DE REHABILITACIÓN';
    	}
    	
    }

    private function getDate($date)
    {
    	if ($date)
	    	return Carbon::createFromFormat('Y-m-d H:i:s', $date);
	    else
	    	return null;
    }

    private function getDireccion($calle, $numero)
    {
    	if ($calle) {
    		if ($numero)
    			return $calle . ' ' . $numero;
    		else
    			return $calle;
    	} else {
    		return null;
    	}
    }

    private function getModeloId($nombre, $modelo)
    {
    	if ($nombre) {
    		$m = $modelo::where('nombre', $nombre)->first();
    		if ($m){
    			return $m->id;
    		} else {
    			Log::error('No se ecuentra la propiedad  "' . $nombre . '" en el modelo "' . $modelo . '"');
    			return null;
    		}
    	} else {
    		return null;
    	}

    }

    private function getIslaId($nombre)
    {
    	$id = null;
    	switch ($nombre) {
    		case 'EL HIERRO':
    			$id = 1;
    			break;
    		case 'FUERTEVENTURA':
    			$id = 2;
    			break;
			case 'GRAN CANARIA':
    			$id = 3;
    			break;
			case 'LA GOMERA':
    			$id = 4;
    			break;
			case 'LA PALMA':
    			$id = 5;
    			break;
			case 'LANZAROTE':
    			$id = 6;
    			break;
			case 'TENERIFE':
    			$id = 7;
    			break;

    		default:
    			# code...
    			break;
    	}
    	return $id;
    }

    private function getMunicipioId($nombre)
    {
    	$id = null;

    	if ($nombre) {
    		switch ($nombre) {
    			case 'LA ALDEA DE SAN NICOLÁS':
    				$id = 12;
    				break;
    			case 'FUENCALIENTE':
    				$id = 40;
    				break;
    			case 'LA GUANCHA':
    				$id = 67;
    				break;
    			case 'LOS LLANOS DE ARIDANE':
    				$id = 42;
    				break;
    			case 'LA MATANZA DE ACENTEJO':
    				$id = 71;
    				break;
    			case 'LA OLIVA':
    				$id = 	6;
    				break;
    			case 'LA OROTAVA':
    				$id = 72;
    				break;
    			case 'LAS PALMAS DE GRAN CANARIA':
    				$id = 20;
    				break;
    			case 'EL PASO':
    				$id = 43;
    				break;
    			case 'EL PINAR':
    				$id = 	2;
    				break;
    			case 'LOS REALEJOS':
    				$id = 74;
    				break;
    			case 'EL ROSARIO':
    				$id = 75;
    				break;
    			case 'LA LAGUNA':
    				$id = 76;
    				break;
    			case 'SAN MIGUEL':
    				$id = 78;
    				break;
    			case 'SAN SEBASTIÁN':
    				$id = 34;
    				break;
    			case 'SANTA LUCÍA':
    				$id = 23;
    				break;
    			case 'SANTA MARíA DE GUíA':
    				$id = 24;
    				break;
    			case 'EL SAUZAL':
    				$id = 82;
    				break;
    			case 'LOS SILOS':
    				$id = 83;
    				break;
    			case 'VALSEQUILLO':
    				$id = 29;
    				break;
    			case 'LA VICTORIA DE ACENTEJO':
    				$id = 87;
    				break;
    			case 'MAZO':
    				$id = 50;
    				break;
    			
    			default:
    				$municipio = Municipio::where('nombre', $nombre)->first();
    				if ($municipio) {
    					$id = $municipio->id;
    				} 

    				break;
    		}
    	}

    	return $id;
    }

    private function getLocalidadId($nombre, $municipio_id, &$lugar)
    {
    	if ($nombre == '')
    		return null;

    	// Si el municipio es nulo
		if (!$municipio_id) {
			$lugar = $nombre;
			return null;
		}

    	// $localidad = Localidad::where('nombre', $nombre)->first();
    	// if ($localidad)
    	// 	Log::debug('municipio_id_if: ' . (string) $localidad);

    	// Log::debug('municipio_id: ' . (string) $localidad);
    	$id = null;
    	$nombre_corregido = null; // nombre de la localidad corregido

    	// Comparamos el nombre de la localidad y la corregimos si en necesario
		switch ($nombre) {
			case 'ANZOFÉ':
				$nombre_corregido = 'ANZOFE Y EL SALÓN';
				break;
			case 'ARENALES':
				$nombre_corregido = 'PALMAS DE GRAN CANARIA (LAS)';
				$lugar = $nombre;
				break;
			case 'ARTEDARA':
				$nombre_corregido = 'ARTEARA';
				break;
			case 'ARTEJEVEZ':
				$nombre_corregido = 'ARTEJÉVEZ';
				break;
			case 'BANDA DE AGÜIMES':
				$nombre_corregido = 'BANDA (LA)';
				break;
			case 'BARRANQUILLO ANDRÉS (EL)':
				$nombre_corregido = 'BARRANQUILLO ANDRÉS';
				break;
			case 'CAIDEROS DE SAN JOSÉ':
				$nombre_corregido = 'CAIDEROS';
				break;
			case 'CANTERA, LA':
				$nombre_corregido = 'CANTERA (LA)';
				break;
			case 'CARRIZAL':
				// Si el municipio es Ingenio
				if ($municipio_id = 17)
					$nombre_corregido = 'CARRIZAL';
				// Si el municipio es Tejeda
				elseif ($municipio_id = 25)
					$nombre_corregido = 'CARRIZAL (EL)';
				else
					$lugar = $nombre;
				break;
			case 'CARRIZAL DE TEJEDA':
				$nombre_corregido = 'CARRIZAL (EL)';
				break;
			case 'CASAS DE VENEGUERA (LAS)':
				$nombre_corregido = 'CASAS DE VENEGUERA';
				break;
			case 'CIUDAD JARDÍN':
				$nombre_corregido = 'PALMAS DE GRAN CANARIA (LAS)';
				$lugar = $nombre;
				break;
			case 'CORRALETE':
				$nombre_corregido = 'CORRALETE (EL)';
				break;
			case 'COSTA':
				$nombre_corregido = 'COSTA (LA)';
				break;
			case 'EL LANCE': 
				$nombre_corregido = 'LANCE';
				break;
			case 'EL MONDRAGÓN':
				$nombre_corregido = 'MONDRAGÓN';
				break;
			case 'EL SABINAL':
				$nombre_corregido = 'LOMO EL SABINAL';
				break;
			case 'FAGAGESTO': 
				$nombre_corregido = 'FAGAJESTO';
				break;
			case 'LA CUMBRECILLA': 
				$nombre_corregido = 'CUMBRECILLAS (LAS)';
				break;
			case 'LAS ARVEJAS':
				$nombre_corregido = 'ARBEJAS (LAS)';
				break;
			case 'LLANOS DE MARÍA RIVERO': 
				$nombre_corregido = 'LLANOS DE MARÍA RIVERA';
				break;
			case 'LOMO DE MAGULLO': 
				$nombre_corregido = 'LOMO MAGULLO';
				break;
			case 'MARMOLEJO': 
				$nombre_corregido = 'MARMOLEJOS';
				break;
			case 'MONTAÑA DE LADATA': 
				$nombre_corregido = 'MONTAÑA LA DATA';
				break;
			case 'PIÉ DE LA CUESTA (EL)': 
				$nombre_corregido = 'PIE DE LA CUESTA';
				break;
			case 'PINO SANTO (BAJO)': 
				$nombre_corregido = 'PINO SANTO';
				$lugar = $nombre;
				break;
			case 'PLAYA DE MOGÁN (LA)': 
				$nombre_corregido = 'MONDRAGÓN';
				break;
			case 'TILOS (LOS)': // TILES (LOS)
				$nombre_corregido = 'TILES (LOS)';
				$lugar = $nombre;
				break;
			case 'TINOCA': // TINOCAS
				$nombre_corregido = 'TINOCAS';
				break;
			case 'TRES PALMAS (LAS)': // TRES PALMAS
				$nombre_corregido = 'TRES PALMAS';
				break;
			case 'URBANIZACIÓN ZURBARÁN': // ZURBARÁN
				$nombre_corregido = 'ZURBARÁN';
				break;
			case 'VALLE DE SAN ROQUE ': // VALLE DE SAN ROQUE DE VALSEQUILLO
				$nombre_corregido = 'VALLE DE SAN ROQUE DE VALSEQUILLO';
				break;
			case 'VEGA (LAS)':
				$nombre_corregido = 'VEGAS (LAS)';
				break;

			default:
				// Si no es ninguna de las anteriores buscamos en la tabla de localidades
				$localidad = Localidad::where('nombre', $nombre)->where('municipio_id', $municipio_id)->first();
				if ($localidad) {
					$id = $localidad->id;
				} else {
					// Comprobamos si es una localidad con EL, LA, LOS y la convertimos
					$localidad = Localidad::where('nombre', $this->convertirLocalidad($nombre))->where('municipio_id', $municipio_id)->first();
					if ($localidad) {
						$id = $localidad->id;
					} else {
						// Si no existe la localidad guardamos el dato como lugar
						$lugar = $nombre;
					}
				}
				break;
		}

		// Buscar el nombre corregido en el municipio actual
		if ($nombre_corregido) {
			$localidad = Localidad::where('nombre', $nombre_corregido)->where('municipio_id', $municipio_id)->first();
			if ($localidad) {
				$id = $localidad->id;
			} else {
				$lugar = $nombre;
			}
		}


    	return $id;
    }

    private function convertirLocalidad($nombre)
    {
    	if ((strlen($nombre) > 4) && (strpos($nombre, "EL ") === 0))
    		return substr($nombre, -strlen($nombre)+3) . ' (EL)';
    	if ((strlen($nombre) > 4) && (strpos($nombre, "LA ") === 0))
    		return substr($nombre, -strlen($nombre)+3) . ' (LA)';
    	if ((strlen($nombre) > 5) && (strpos($nombre, "LAS ") === 0))
    		return substr($nombre, -strlen($nombre)+4) . ' (LAS)';
    	if ((strlen($nombre) > 5) && (strpos($nombre, "LOS ") === 0))
    		return substr($nombre, -strlen($nombre)+4) . ' (LOS)';
    }

    private function csvToArray($filename = '', $delimiter = ',')
    {
    	if (!file_exists($filename) || !is_readable($filename))
    		return false;

    	$header = null;
    	$data = array();

    	if (($handle = fopen($filename, 'r')) !== false)
    	{
    		$count = 1;
    	    while ((($row = fgetcsv($handle, 0, $delimiter)) !== false) && $count < config('carta.maxCSVFichasImport') )
    	    // while (($row = fgetcsv($handle, 0, $delimiter)) !== false)
    	    {
                if (!$header) {
                    $header = $row;
                }
                else {
    	            $data[] = array_combine($header, $row);
                }
    	        // Log::debug('data: ' . implode($data); 
    	        $count++;
    	    }
    	    fclose($handle);
    	}

    	return $data;
    }
}
