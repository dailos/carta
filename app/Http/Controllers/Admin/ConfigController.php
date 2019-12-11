<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = null;
        $search = request()->query('search');
        $type = request()->query('type');

        $class = $this->getClass($type);

        if ($class) {
            $query = (new $class)->newQuery();
      
            if ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            }

            $query->orderBy('nombre');

            $models = $query->paginate(10);
        }

        return view('admin.config.index', compact('models', 'type', 'search'));
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
        );

        $validatedData = $request->validate($rules);
        $nombre = $validatedData['nombre'];

        $type = $request->input('type');
        $search = $request->input('search');

        $class = $this->getClass($type);
        
        if ($class) {
            $model = new $class;

            $model->nombre = $nombre;
            $model->save();

            session()->flash('message', 'El elemento ha sido creado con éxito.');

            return redirect()->route('admin.configuracion.index', compact('type', 'search'));
        } else {
            abort(500);
        }
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
        $rules = array(
            'nombre' => 'required|string|max:255',
        );

        $validatedData = $request->validate($rules);
        $nombre = $validatedData['nombre'];

        $type = $request->input('type');
        $search = $request->input('search');
        
        $class = $this->getClass($type);

        if ($class) {
            $model = $class::find($id);
            $model->nombre = $nombre;
            $model->save();

            session()->flash('message', 'El elemento ha sido actualizado con éxito.');

            return redirect()->route('admin.configuracion.index', compact('type', 'search'));
        } else {
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Obtiene el tipo de modelo a borrar
        $type = $request->input('type');
        $search = $request->input('search');
        
        $class = $this->getClass($type);
        
        if ($class) {
            $model = $class::findOrFail($id);

            // Comprobar que no hay fichas asociadas
            if ($model->fichas->isNotEmpty()) {
                session()->flash('alert', 'El elemento ' . $model->nombre . ' no se puede eliminar porque tiene fichas asociadas.');
                return redirect()->route('admin.configuracion.index', compact('type', 'search'));
            } else {
                $model->delete();
                
                session()->flash('message', 'El elemento ' . $model->nombre . ' ha sido eliminado con éxito.');
                return redirect()->route('admin.configuracion.index', compact('type', 'search'));
            }
        } else {
            abort(500);
        }
    }

    private function getClass($type)
    {
        // Comprueba si está definida como modelo configurable configurable
        if ($type && in_array($type, config('carta.configurable_models'), true)) {
            // Parsear nombre del tipo a classpath
            $class = 'App\\' . str_replace("_", "", ucwords($type, "_"));

            // Comprueba si la clase es válida
            if (class_exists($class)) {
                return $class;
            }
        }

        return false;
    }
}


