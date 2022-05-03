<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ModerableRecord;
use App\Http\Requests\StoreFicha;
use App\Ficha;
use App\TipoContacto;
use App\Repositories\Fichas;
use App\Repositories\Fotos;
use App\Maps\Map;

class FichaModerationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener las fichas pendientes de moderación
        $fichas_pending = ModerableRecord::pending(Ficha::class)->get();


        return view('admin.fichas.moderation.index', compact('fichas_pending'));
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

        $nuevo_cod_ficha = null;

        if ($moderableRecord->action === 'create') {
            $nuevo_cod_ficha = Ficha::max('cod_ficha') + 1;
        }

        $map = null;

        if(Map::create($ficha)) {
            $map = Map::render();
        }

        return view('admin.fichas.moderation.show', compact('ficha', 'tipos_contacto', 'moderableRecord', 'nuevo_cod_ficha', 'map'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModerableRecord  $moderableRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(ModerableRecord $moderableRecord)
    {
        if ($moderableRecord->status != ModerableRecord::PENDING)
            abort(404);

        if ($moderableRecord && $moderableRecord->status == ModerableRecord::PENDING) {
            if ($moderableRecord->model) {
                $ficha = $moderableRecord->model->replicate()->fill($moderableRecord->fields);
            } else {
                $ficha = Ficha::make($moderableRecord->fields);
            }

            $models = Fichas::getRelatedModels($ficha, $moderableRecord->user);

            $nuevo_cod_ficha = null;

            if ($moderableRecord->action === 'create') {
                $ficha->cod_ficha = Ficha::max('cod_ficha') + 1;
            }

            return view('admin.fichas.moderation.edit', array_merge($models, compact('ficha', 'moderableRecord')));
        } else {
            session()->flash('alert', 'La moderación no existe o no tiene estado "pendiente"');

            return redirect()->route('admin.moderacion.index');
        }
    }

    /**
     * Actualiza la petición de creación/edición de ficha, y aplica la moderación.
     *
     * @param  \App\Http\Requests\StoreFicha  $request
     * @param  \App\ModerableRecord  $moderableRecord
     * @param  \App\Repositories\Fotos  $fotos
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFicha $request, ModerableRecord $moderableRecord, Fotos $fotos)
    {
        // The incoming request is valid...

        // Retrieve the validated input data...

        $validated = $request->process($moderableRecord->model);

        $comment = $request->has('comment') ? $request->input('comment') : null;

        if ($moderableRecord->action === 'create') {
            // Si es una ficha nueva generar cod_ficha
            $moderableRecord->deferred_actions = [
                'setNewCodFicha' => [Ficha::max('cod_ficha') + 1],
            ];
            $moderableRecord->save();

            $validated = array_filter($validated);

            // Borrar fotos y/o croquis eliminados de la petición original
            $fotos->deleteDiff($moderableRecord->fields['fotos'], $validated['fotos']);
        } else {
            // Aplica solo los datos que han cambiado
            $get_dirty_array = [];
            $ficha = $moderableRecord->model->fill($validated);

            foreach($ficha->getDirty() as $key=>$dirty){
                $get_dirty_array[$key] = is_json($dirty, true) ?: $dirty;
            }

            $validated = $get_dirty_array;

            // Borrar fotos y/o croquis eliminados de la petición original
            if (isset($moderableRecord->fields['fotos'])) {
                $fotos->deleteDiff($moderableRecord->fields['fotos'], $validated['fotos']);
            }

            // Borrar las fotos y/o croquis que se hayan eliminado de la ficha original
            if (isset($validated['fotos'])) {
                $fotos->deleteDiff($moderableRecord->model->foto, $validated['fotos']);
            }
        }

        $moderableRecord->fields = $validated;

        if($moderableRecord->apply($comment)){
            session()->flash('message', 'La moderación de ficha ha sido aceptada con éxito');
        }else{
            session()->flash('message', 'La moderación de ficha ha fallado, posiblemente no tenga permiso de moderador');
        }

        return redirect()->route('admin.moderacion.index');
    }

    /**
     * Acepta la petición de moderación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repositories\Fotos  $fotos
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request, Fotos $fotos)
    {
        $moderableRecord = ModerableRecord::findOrFail($request->input('moderableId'));

        $comment = $request->has('comment') ? $request->input('comment') : null;

        if ($moderableRecord->action === 'create') {
            $moderableRecord->deferred_actions = [
                'setNewCodFicha' => [Ficha::max('cod_ficha') + 1],
            ];
        } else {
            // Borrar las fotos y/o croquis que se hayan eliminado de la ficha original
            if (isset($moderableRecord->fields['fotos'])) {
                $fotos->deleteDiff($moderableRecord->model->fotos, $moderableRecord->fields['fotos']);
            }
        }

        $moderableRecord->save();

        if($moderableRecord->apply($comment)){
            session()->flash('message', 'La moderación de ficha ha sido aceptada con éxito');
        }else{
            session()->flash('message', 'La moderación de ficha ha fallado, posiblemente no tenga permiso de moderador');
        }

        return redirect()->route('admin.moderacion.index');
    }

    /**
     * Rechaza la petición de moderación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repositories\Fotos  $fotos
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request, Fotos $fotos)
    {
        $validatedData = $request->validate([
           'comment' => 'required',
        ]);

        $moderableRecord = ModerableRecord::findOrFail($request->input('moderableId'));

        $moderableRecord->reject($validatedData['comment']);

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

        session()->flash('message', 'La moderación de ficha ha sido rechazada con éxito');

        return redirect()->route('admin.moderacion.index');
    }
}
