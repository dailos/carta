<?php

namespace App\Http\Controllers\Admin;

use App\ModerableRecord;
use App\Ficha;
use App\TipoContacto;
use App\Http\Controllers\Controller;

class FichaHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener las fichas modedaras
        $fichas_history = ModerableRecord::notPending(Ficha::class)->get();

        return view('admin.fichas.history.index', compact('fichas_history'));  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ModerableRecord  $moderableRecord
     * @return \Illuminate\Http\Response
     */
    public function show(ModerableRecord $moderableRecord)
    {
        if ($moderableRecord->status == ModerableRecord::PENDING)
            abort(404);

        $tipos_contacto = TipoContacto::all();

        $ficha = Ficha::make($moderableRecord->fields);

        if ($moderableRecord->model) {
            $ficha->cod_ficha = $moderableRecord->model->cod_ficha;
        }

        return view('admin.fichas.history.show', compact('ficha', 'tipos_contacto', 'moderableRecord'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ModerableRecord  $moderableRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModerableRecord $moderableRecord)
    {
        $moderableRecord->delete();

        session()->flash('message', 'El registro de historial se ha eliminado con éxito');

        return redirect()->route('admin.historial.index');
    }
}
