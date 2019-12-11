<?php

namespace App\Http\Controllers\Collaborator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ModerableRecord;
use App\Ficha;
use App\TipoContacto;
use App\Repositories\Fotos;
use App\Maps\Map;

/**
 * Gestiona las peticiones del colaborador sobre las fichas (mostrar, listar, borrar...)
 *
 **/
class FichaRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // Obtener las fichas pendientes de moderación
        $fichas_pending = ModerableRecord::pending(Ficha::class)->where('user_id', auth()->id())->get();

        // dd($fichas_pending);

        // Obtener las fichas rechazadas de moderación
        $fichas_reject = ModerableRecord::rejected(Ficha::class)->where('moderable_id', null)->where('user_id', auth()->id())->get();

        return view('collaborator.fichas.requests.index', compact('fichas_pending', 'fichas_reject'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ModerableRecord  $moderableRecord
     * @return \Illuminate\Http\Response
     */
    public function show(ModerableRecord $moderableRecord)
    {
        if ($moderableRecord->status != ModerableRecord::PENDING)
            abort(404);

        $tipos_contacto = TipoContacto::all();

        $ficha = Ficha::make($moderableRecord->fields);

        $map = null;
        
        if(Map::create($ficha)) {
            $map = Map::render();
        }
        
        return view('collaborator.fichas.requests.show', compact('ficha', 'tipos_contacto', 'moderableRecord', 'map'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModerableRecord  $moderableRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(ModerableRecord $moderableRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ModerableRecord  $moderableRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModerableRecord $moderableRecord, Fotos $fotos)
    {
        // Borrar fotos subidas
        if ($moderableRecord->action == 'create') {
            // Si es una petición de creación borramos todas las fotos y croquis
            if (isset($moderableRecord->fields['fotos'])) {
                $fotos->deleteAll($moderableRecord->fields['fotos']);
            }
        } else {
            // Si es petición de edición borramos las nuevas fotos subidas
            if (isset($moderableRecord->fields['fotos'])) {
                $fotos->deleteDiff($moderableRecord->fields['fotos'], $moderableRecord->model->fotos);
            }
        }

        // Eliminar petición de moderación
        $moderableRecord->delete();

        session()->flash('message', 'La petición de moderación ha sido eliminada con éxito');

        return redirect()->route('collaborator.peticiones.index');
    }

}
