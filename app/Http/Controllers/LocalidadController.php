<?php

namespace App\Http\Controllers;

use App\Isla;
use App\Municipio;
use App\Localidad;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    public function getLocalidades($municipio)
    {
        $localidades = Localidad::where('municipio_id', $municipio)->select('id', 'nombre as text')->get();

        if ($localidades) {
            return $localidades->toJson();
        } else {
            return "";
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->query('search');
        $isla = request()->query('isla_id');
        $islas = Isla::select('id', 'nombre as text')->get();
        $municipio = request()->query('municipio_id');
        $municipios = null;
        $localidades = null;

        if ($isla) {
            $municipios = Municipio::select('id', 'nombre as text')->where('isla_id', '=', $isla)->get();
        }

        $query = (new Localidad)->newQuery();
 
        if ($municipio) {
            $query->where('municipio_id', $municipio);
        } elseif ($isla) {
            $query = (new Isla)::find($isla)->localidades();
        }

        if ($search) {
            $query->where('localidads.nombre', 'like', '%' . $search . '%');
        }

        $query->orderBy('localidads.nombre');

        $localidades = $query->paginate(10);

        return view('admin.config.localidades', compact('localidades', 'search', 'islas', 'isla', 'municipio', 'municipios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'nombre' => 'required|string|max:255',
            'isla_id' => 'required|exists:islas,id',
            'municipio_id' => 'required|exists:municipios,id',
        );

        $validatedData = $request->validate($rules);

        $nombre = $validatedData['nombre'];
        $municipio_id = $validatedData['municipio_id'];
        $isla_id = $validatedData['isla_id'];

        $search = $request->input('search');

        $localidad = new Localidad;

        $localidad->nombre = $nombre;

        $isla = Isla::findOrFail($isla_id);
        $municipio = Municipio::findOrFail($municipio_id);
        //$municipio->isla()->associate($isla);
        $localidad->municipio()->associate($municipio);
        //$municipio->save();

        $localidad->save();

        session()->flash('message', 'La localidad ha sido creada con éxito.');

        return redirect()->route('admin.configuracion.index', compact('localidades', 'search', 'isla_id', 'municipio_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Localidad  $localidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Localidad $localidad)
    {
        $rules = array(
            'nombre' => 'required|string|max:255',
        );

        $validatedData = $request->validate($rules);

        $isla_id = $request->input('isla_id');
        $municipio_id = $request->input('municipio_id');
        $search = $request->input('search');

        $localidad->nombre = $validatedData['nombre'];

        $localidad->save();

        session()->flash('message', 'La localidad ha sido actualizada con éxito.');

        return redirect()->route('admin.municipios.index', compact('search', 'isla_id', 'municipio_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Localidad  $localidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Localidad $localidad)
    {
        $isla_id = $request->input('isla_id');
        $municipio_id = $request->input('municipio_id');
        $search = $request->input('search');

        // Comprobar que no hay fichas asociadas
        if ($localidad->fichas->isNotEmpty()) {
            session()->flash('alert', 'La localidad ' . $localidad->nombre . ' no se puede eliminar porque tiene fichas asociadas.');
            return redirect()->route('admin.localidades.index', compact('search', 'isla_id', 'municipio_id'));
        } else {
            $localidad->delete();
            
            session()->flash('message', 'La localidad ' . $localidad->nombre . ' ha sido eliminada con éxito.');
            return redirect()->route('admin.localidades.index', compact('search', 'isla_id', 'municipio_id'));
        }
    }
}
