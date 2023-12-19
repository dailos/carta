<?php

namespace App\Http\Controllers\Admin;

use App\Exporters\FichasCSVExporter;
use App\Ficha;
use App\TipoContacto;
use App\Repositories\Fichas;
use App\Repositories\Fotos;
use App\Http\Requests\StoreFicha;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Maps\Map;
use League\Csv\Writer;

class FichaController extends Controller
{

    /**
     * Procesa la petición ajax de datatables. Devuelve todas las fichas.
     *
     * @return \Yajra\DataTables\DataTables
     */
    public function fichas()
    {

        $fichas = Ficha::with('actividad', 'grupo', 'tipo', 'municipio', 'localidad')->select('fichas.*');

        return Datatables::of($fichas)
            ->addColumn('foto', function ($ficha) {
                return '<img src="' . url('fotos/' . $ficha->fotos['fotos'][0]) . '" class="img-fluid" width="65" height="65" alt="">';
            })
            ->rawColumns(['foto', 'action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Fichas::getRelatedModels();

        return view('admin.fichas.index', array_merge($models, [
            'datatable_ajax' => route('admin.fichas.datatable'),
            'datatable_view' => url('admin/fichas')])
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $models = Fichas::getRelatedModels();

        return view('admin.fichas.create', $models);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\StoreFicha  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFicha $request)
    {
        // The incoming request is valid...

        // Retrieve the validated input data...
        $validated = $request->process();
        $validated['cod_ficha'] = Ficha::max('cod_ficha') + 1;

        $ficha = Ficha::create($validated);

        // Convertir UTM a Lat-Long
        // $utm = new UTMRef(459454, 3100593, 0, 'R', 28); // x y cuadrante
        // $latlng = $utm->toLatLng();
        // dd($latlng->getLat(), $latlng->getLng());
        session()->flash('message', 'Se ha creado la ficha con éxito');

        return redirect()->route('admin.fichas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ficha  $ficha
     * @return \Illuminate\Http\Response
     */
    public function show(Ficha $ficha)
    {
        $tipos_contacto = TipoContacto::all();

        $map = null;

        if(Map::create($ficha)) {
            $map = Map::render();
        }

        return view('admin.fichas.show', compact('ficha', 'tipos_contacto', 'map'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ficha  $ficha
     * @return \Illuminate\Http\Response
     */
    public function edit(Ficha $ficha)
    {
        $models = Fichas::getRelatedModels($ficha);

        return view('admin.fichas.edit', array_merge($models, compact('ficha')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Requests\StoreFicha  $request
     * @param  \App\Ficha  $ficha
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFicha $request, Ficha $ficha, Fotos $fotos)
    {
        // Procesa datos de la request
        $validated = $request->process($ficha);

        // Borrar las fotos y/o croquis que se hayan eliminado
        $fotos->deleteDiff($ficha->foto, $validated['fotos']);

        $ficha->fill($validated);

        $ficha->save();

        session()->flash('message', 'La ficha ha sido actualizada con éxito');

        return redirect()->route('admin.fichas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ficha  $ficha
     * @param  \App\Repositories\Fotos  $fotos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ficha $ficha, Fotos $fotos)
    {
        // Comprobar si tiene moderaciones pendientes y se eliminan
        $pending = $ficha->moderableRecords()->pending()->get();

        if ($pending->isNotEmpty()) {
            foreach ($pending as $moderation) {
                $moderation->delete();
            }
        }

        // Eliminar las fotos de la ficha
        $fotos->deleteAll($ficha->fotos);

        // Eliminar la ficha
        $ficha->delete();

        session()->flash('message', 'La ficha ha sido eliminada con éxito');

        return redirect()->route('admin.fichas.index');
    }

    /**
     * Exports all the fichas to cvs
     *
     * @return void
     */
    public function csvExport(FichasCSVExporter $exporter)
    {
        echo $exporter->export(Ficha::all());
    }

}
