<?php

namespace App\Http\Controllers;

use App\Municipio;
use App\Isla;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{

    /**
     * Devuelve los municipios de la isla pasada por parametros en formato json.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMunicipios($isla)
    {
        if (auth()->user()->municipios->isNotEmpty()) {
            $municipios = Municipio::where('isla_id', $isla)
                ->select('id', 'nombre as text')
                ->wherein('id', auth()->user()->municipios->pluck('id')->toArray())
                ->get();
        } else {
            $municipios = Municipio::where('isla_id', $isla)->select('id', 'nombre as text')->get();
        }

        if ($municipios) {
            return $municipios->toJson();
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
        $municipios = null;
        $search = request()->query('search');
        $isla = request()->query('isla_id');
        $islas = Isla::select('id', 'nombre as text')->get();

        $query = (new Municipio)->newQuery();

        if ($isla) {
            $query->where('isla_id', $isla);
        }
    
        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        }

        $query->orderBy('nombre');

        $municipios = $query->paginate(10);

        return view('admin.config.municipios', compact('municipios', 'search', 'islas', 'isla'));
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
        );

        $validatedData = $request->validate($rules);

        $nombre = $validatedData['nombre'];
        $isla_id = $validatedData['isla_id'];

        $search = $request->input('search');

        $municipio = new Municipio;

        $municipio->nombre = $nombre;

        $isla = Isla::findOrFail($isla_id);
        $municipio->isla()->associate($isla);

        $municipio->save();

        session()->flash('message', 'El municipio ha sido creado con éxito.');

        return redirect()->route('admin.municipios.index', ['isla_id' => $isla_id, 'search' => $search]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Municipio $municipio)
    {
        $rules = array(
            'nombre' => 'required|string|max:255',
        );

        $validatedData = $request->validate($rules);

        $isla_id = $request->input('isla_id');
        $search = $request->input('search');

        $municipio->nombre = $validatedData['nombre'];

        $municipio->save();

        session()->flash('message', 'El municipio ha sido actualizado con éxito.');

        return redirect()->route('admin.municipios.index', ['isla_id' => $isla_id, 'search' => $search]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Municipio  $municipio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Municipio $municipio)
    {
        $isla_id = $request->input('isla_id');
        $search = $request->input('search');

        // Comprobar que no hay fichas asociadas
        if ($municipio->fichas->isNotEmpty()) {
            session()->flash('alert', 'El municipio ' . $municipio->nombre . ' no se puede eliminar porque tiene fichas asociadas.');
            return redirect()->route('admin.municipios.index', ['isla_id' => $isla_id, 'search' => $search]);
        } else {
            if ($municipio->localidades->isNotEmpty()) {
                session()->flash('alert', 'El municipio ' . $municipio->nombre . ' no se puede eliminar porque tiene localidades asociadas.');
                return redirect()->route('admin.municipios.index', ['isla_id' => $isla_id, 'search' => $search]);
            }

            $municipio->delete();
            
            session()->flash('message', 'El elemento ' . $municipio->nombre . ' ha sido eliminado con éxito.');
            return redirect()->route('admin.municipios.index', ['isla_id' => $isla_id, 'search' => $search]);
        }
    }
}
