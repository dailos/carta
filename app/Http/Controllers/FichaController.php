<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ficha;
use App\Repositories\Fichas;
use App\Search\FichaSearch;
use App\Maps\Map;
use PDF;

class FichaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener los datos para los filtros de búsqueda
        $models = Fichas::getRelatedModelsForSearch();

        return view('index', $models);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id - Cod. ficha
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ficha = Ficha::where('cod_ficha', $id)->first();

        if (!$ficha) {
            abort(404);
        }

        $map = null;
        
        if (Map::create($ficha)) {
            $map = Map::render();
        }

        // dd(session()->all());
        
        // $query = session()->pull('query', null);
        // $page = session()->pull('page', null);

        // if ($query || $page) {
        //     session()->flash('query', $query);
        //     session()->flash('page', $page);
        // }

        return view('fichas.show', compact('ficha', 'map'));
    }

    /**
     * Busca la ficha por su código.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchByCode(Request $request)
    {
        // Validar
        $rules = array(
            'cod_ficha' => 'required|numeric|digits_between:1,10|exists:fichas,cod_ficha',
        );

        $validatedData = $request->validate($rules);

        return redirect()->route('fichas.show', $validatedData['cod_ficha']);
    }

    /**
    * Búsqueda.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function search(Request $request)
    {
        // Validar
        $rules = array(
            'query' => 'nullable|string',
            'search_key' =>'nullable'
        );

        
        foreach ((new Ficha)->getSearchableModelFilters() as $model) {
            $rules[$model] = 'nullable|numeric|exists:'. $model . 's,id';
        }

        $validatedData = $request->validate($rules);
        // Mapa de localización
        $map = null;

        // Realiza la búsqueda los datos de la request
        $fichas = FichaSearch::apply($validatedData, 6);

        // Crea mapa con las localizaciones
        if ($fichas && $fichas->isNotEmpty()) {
            Map::createWithInfo($fichas, ['center' => false, 'marker' => false]);

            $map = Map::render();
        }

        // FichaSearch::storeSessionFilters($request);

        // if($query) {
        //     $request->session()->put('query', $query);
        // }
        // if ($page) {
        //     $request->session()->put('page', $page);
        // }
        // $request->session()->put('query', $query);

        $params = $request->query();

        return view('fichas.results', compact('fichas', 'map', 'params'));
    }

    /**
    * Búsqueda por proximidad geográfica
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function geoProxSearch(Request $request)
    {
        // Validar
        $rules = array(
            'latitud' => 'required|between:-90,90',
            'longitud' => 'required|between:-180,180',
            'radio' => 'required|integer'
        );

        $validatedData = $request->validate($rules);
        
        // Realiza la búsqueda
        $fichas = FichaSearch::applyCircleArea($validatedData['latitud'], $validatedData['longitud'], intval($validatedData['radio']), 6);

        // Crea mapa con las localizaciones
        if ($fichas && $fichas->isNotEmpty()) {
            Map::createWithInfo($fichas, ['center' => false, 'marker' => false]);

            $map = Map::render();
        }

        $params = $request->query();

        return view('fichas.results', compact('fichas', 'map', 'params'));
    }

    /**
    * Lee un fichero KML y redirige a la búsqueda con los datos obtenidos
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function readKmlFile(Request $request)
    {
        $validatedData = $request->validate([
            'kml' => 'required|mimetypes:application/vnd.google-earth.kml+xml,text/xml'
        ]);

        $path = $validatedData['kml']->path();

        try{
            $kml = simplexml_load_file($path);
            $coordinates = $kml->Document->Placemark->Polygon->outerBoundaryIs->LinearRing->coordinates;
        }catch (\Exception $e){
            return redirect()->route('home')->with('alert', 'Formato de fichero no válido, proporciona un .kml con un polígono cerrado');
        }

        $cordsData = trim(((string) $coordinates));

        // check if coordinate data is available
        if (isset($cordsData) && !empty($cordsData)) {
            $explodedData = explode("\n", $cordsData);
            $explodedData = preg_split("@[\s+　]@u", $explodedData[0]);
            // next for each of the points build the polygon data
            $points = array();
            // $polygon = "";
            // $point = "-15.40475451177656 27.927409113700147"; //inside
            // $point = "-15.477453104916208 27.92411276855569"; //outside

            foreach ($explodedData as $index => $coordinateString) {
                $coordinateSet = array_map('trim', explode(',', $coordinateString));
                
                if (count($coordinateSet) == 3) {
                    // lon,lat[,alt] | Index 0 = lon, index 1 = lat, index 2 = alt [optional]
                    // $points .= " Latitud: " . $coordinateSet[1] . " Longitud: " .$coordinateSet[0] . ",";
                    array_push($points, $coordinateSet[0] . " " . $coordinateSet[1]);
                // $polygon .= $coordinateSet[0] . ',' . $coordinateSet[1] . ";";
                } else {
                    return redirect()->route('home')->with('alert', 'Formato de fichero no válido');
                }
            }

            // Redirije a la búsqueda
            return redirect()->route('fichas.search.geo', compact('points'));
        } else {
            session()->flash('alert', 'No se han podido leer las cooordenadas del fichero.');
            return redirect()->route('home');
        }
    }

    /**
    * Búsqueda geográfica
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function geoSearch(Request $request)
    {
        if ($request->query('points')) {
            // Realiza la búsqueda en area del polígono
            $fichas = FichaSearch::applyPolygonArea($request->query('points'), 6);

            $map = null;

            // Crea mapa con las localizaciones
            if ($fichas && $fichas->isNotEmpty()) {
                Map::createWithInfo($fichas, ['center' => false, 'marker' => false]);

                $map = Map::render();
            }

            $params = $request->query();

            return view('fichas.results', compact('fichas', 'map', 'params'));
        } else {
            session()->flash('alert', 'No hay coordenadas disonibles.');
            return redirect()->route('home');
        }
    }


    /**
    * Descarga en formato pdf la ficha
    *
    * @param  int  $cod_ficha
    * @return \Illuminate\Http\Response
    */
    public function download($cod_ficha)
    {
        $ficha = Ficha::where('cod_ficha', $cod_ficha)->first();

        if ($ficha) {
            //return view('pdf.ficha', ['ficha' => $ficha]);
            $pdf = PDF::loadView('pdf.ficha', ['ficha' => $ficha])->setPaper('a3', 'landscape');
            return $pdf->download('ficha_' . $ficha->cod_ficha . '.pdf');
        } else {
            abort(404);
        }
    }

    /**
     * @param Request $request
     * @return FichaSearch[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    private function getFichas(Request $request)
    {
        if ($request->query('points')) {
            // Realiza la búsqueda en area del polígono
            $fichas = FichaSearch::applyPolygonArea($request->query('points'));
        } elseif ($request->query('radio')) {
            $fichas = FichaSearch::applyCircleArea($request->query('latitud'), $request->query('longitud'), intval($request->query('radio')));
        } else {
            $fichas = FichaSearch::apply($request->query());
        }
        return $fichas;
    }

    /**
    * Descarga
    *
    * @param  string  $params
    * @return \Illuminate\Http\Response
    */
    public function downloadResults(Request $request)
    {
        $fichas = $this->getFichas($request);
        $params = $request->query();
        if ($fichas && $fichas->isNotEmpty()) {
            $pdf = PDF::loadView('pdf.results', compact('fichas', 'params'));
            return $pdf->download('listado.pdf');
        } else {
            abort(404);
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Throwable
     */
    public function downloadKml(Request $request)
    {
        $fichas = $this->getFichas($request);
        if ($fichas && $fichas->isNotEmpty()) {
            $headers = [
                'Content-type'        => 'application/vnd.google-earth.kml+xml',
                'Content-Disposition' => 'attachment; filename="listado.kml"',
            ];
            return response()->streamDownload(function () use ($fichas, $headers) {
                echo view('kml.fichas', ['kmlInfo' => Map::getKmlInfo($fichas)])->render();;
            }, 'listado.kml', $headers);
        } else {
            abort(404);
        }
    }
}
