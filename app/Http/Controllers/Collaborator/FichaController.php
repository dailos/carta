<?php

namespace App\Http\Controllers\Collaborator;

use App\Ficha;
use App\TipoContacto;
use App\Http\Requests\StoreFicha;
use App\Repositories\Fichas;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Maps\Map;
use Illuminate\Support\Facades\Mail;
use App\Mail\ModerationRequested;

class FichaController extends Controller
{

    /**
     * Procesa la petición ajax de datatables. Devuelve todas las fichas asociadas a los municipios del colaborador.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fichas()
    {
        $fichas = Ficha::with('actividad', 'grupo', 'tipo', 'municipio', 'localidad')
            ->wherein('fichas.municipio_id', auth()->user()->municipios->pluck('id')->toArray())
            ->select('fichas.*');

        return Datatables::of($fichas)
            ->addColumn('foto', function ($ficha) {
                return '<img src="' . url('fotos/' . $ficha->fotos['fotos'][0]) . '" class="img-fluid" width="65" height="65" alt="">';
            })
            ->rawColumns(['foto'])
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

        return view('collaborator.fichas.index', array_merge($models, [
            'datatable_ajax' => route('collaborator.fichas.datatable'),
            'datatable_view' => url('user/fichas')])
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

        return view('collaborator.fichas.create', $models);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFicha  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFicha $request)
    {
        // The incoming request is valid...

        // Retrieve the validated input data...
        $validated = $request->process();

        $validated = array_filter($validated);

        // Moderar la creación de un modelo
        $ficha = Ficha::make($validated);
        $ficha->moderate()->save();

        session()->flash('message', 'La petición de creación de ficha ha sido enviada con éxito');

        $moderableRecord = auth()->user()->moderable_records()->pending()->where('action', 'create')->orderBy('created_at', 'desc')->first();

        // Enviar notificación via email
        Mail::to(config('mail.from.address'))->send(new ModerationRequested($moderableRecord));


        return redirect()->route('collaborator.fichas.index');
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

        $pending = $ficha->moderableRecords()->pending()->first();

        $map = null;

        if(Map::create($ficha)) {
            $map = Map::render();
        }

        return view('collaborator.fichas.show', compact('ficha', 'tipos_contacto', 'map', 'pending'));
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

        $pending = $ficha->moderableRecords()->pending()->first();

        return view('collaborator.fichas.edit', array_merge($models, compact('ficha', 'pending')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreFicha  $request
     * @param  \App\Ficha  $ficha
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFicha $request, Ficha $ficha)
    {
        // The incoming request is valid...

        // Retrieve the validated input data...

        $validated = $request->process($ficha);

        $updated = $ficha->moderate()->update($validated);

        if ($updated) {
            session()->flash('message', 'No se han realizado cambios en la ficha.');
        } else {
            session()->flash('message', 'La petición de actualización de ficha ha sido enviada con éxito');
            // Enviar notificación via email
            Mail::to(config('mail.from.address'))->send(new ModerationRequested($ficha->moderableRecords()->pending()->first()));
        }

        return redirect()->route('collaborator.fichas.index');
    }

    /**
     * Exports all the fichas to cvs
     *
     * @return void
     */
    public function csvExport()
    {

    }

}
