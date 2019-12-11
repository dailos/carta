<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use App\Municipio;
use App\Mail\UserCreated;
use App\Ficha;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todos los usuarios
        $users = User::where('id', '!=', auth()->id())->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $municipios = Municipio::where('isla_id', '=', config('carta.isla'))->get();
        return view('admin.users.create', compact('municipios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());
        $rules = array(
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|min:4|unique:users',
        );

        if ($request->userrole == 'collaborator') {
            $rules['municipios'] = 'required';
            $rules['municipios.*'] = 'integer|exists:municipios,id';
        }

        $validatedData = $request->validate($rules);

        $validatedData['password'] = Hash::make($password = str_random(8));

        $user = User::create($validatedData);

        if (($request->userrole == 'collaborator') && $request->has('municipios')) {
            $user->municipios()->attach($request->municipios);
        }

        $user->assignRole($request->userrole);

        session()->flash('message', 'Usuario registrado con éxito con contraseña ' . $password);

        // TODO enviar correo a los administradores incluyendo el nuevo claro
        \Mail::to($user)->send(new UserCreated($user, $password));

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $municipios = Municipio::where('isla_id', '=', config('carta.isla'))->get();
        $municipios_user = $user->municipios->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'municipios_user', 'municipios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // dd($request->all());
        $rules = array(
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,id,' . $user->id,
            'username' => 'required|string|min:4|unique:users,id,' . $user->id,
        );

        if ($user->roles->first()->name == 'collaborator') {
            $rules['municipios'] = 'required';
            $rules['municipios.*'] = 'integer|exists:municipios,id';
        }
        
        $validatedData = $request->validate($rules);

        $user->fill($validatedData);

        if ($user->roles->first()->name == 'collaborator') {
            $municipios_user = $user->municipios->pluck('id')->toArray();

            // Municipios eliminados
            if (!empty($eliminados = array_diff($municipios_user, $request->municipios))) {
                // dd($eliminados);
                $user->municipios()->detach($eliminados );
            }

            // Añadidos nuevos
            if (!empty($nuevos = array_diff($request->municipios, $municipios_user))) {
                // dd($nuevos);
                $user->municipios()->attach($nuevos);
            }
        }

        $user->save();

        session()->flash('message', 'El usuario \'' . $user->name . ' ' . $user->surname . '\' ha sido actualizado con éxito');

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Obtener las fichas pendientes de moderación

        $fichas_pending = $user->moderable_records()->pending(Ficha::class)->get();
        
        if ($fichas_pending->isNotEmpty())
        {
            session()->flash('alert', 'El usuario \'' . $user->name . ' ' . $user->surname . '\' no se ha podido eliminar porque tiene peticiones pendientes.');
            return redirect()->route('admin.users.index');
        }

        // Eliminar asociaciones con municipios
        $user->municipios()->detach();

        // Eliminar usuario
        $userStatus = $user->delete();

        if (!$userStatus) {
            session()->flash('alert', 'El usuario \'' . $user->name . ' ' . $user->surname . '\' no se ha podido eliminar.');
            return redirect()->route('admin.users.index');
        }

        session()->flash('message', 'El usuario \'' . $user->name . ' ' . $user->surname . '\' ha sido eliminado.');

        return redirect()->route('admin.users.index');
    }
}
