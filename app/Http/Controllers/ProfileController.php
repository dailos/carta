<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Validator;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    	$user = auth()->user();
        return view('profiles.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = auth()->user();
        return view('profiles.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = array(
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,id,' . $user->id,
            'username' => 'required|string|min:4|unique:users,id,' . $user->id,
        );
        
        $validatedData = $request->validate($rules);

        $user->fill($validatedData);

        $user->save();

        session()->flash('message', 'Se han actualizado sus datos con éxito');

        return redirect()->route('profile.show');
    }

    /**
     * Muestra la vista de formulario para cambiar la contraseña
     *
     * @return \Illuminate\Http\Response
     */
    public function showChangePasswordForm() {
        return view('profiles.changepassword');
    }

    /**
     * Cambia la contraseña actual
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request) {

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $validator->after(function ($validator)  {

            if (!(Hash::check(request()->input('current_password'), auth()->user()->password))) {
                // Comprobación de contraseña actual
                $validator->errors()->add('current_password', __('passwords.invalid'));
            }

            if (strcmp(request()->input('current_password'), request()->input('new_password')) == 0) {
                // La nueva contraseña y la actual coinciden
                $validator->errors()->add('new_password', __('passwords.same'));
            }
        });

        if ($validator->fails()) {
            // Redirige en caso de error
            return redirect()->route('profile.show.changepassword')
                ->withErrors($validator)
                ->withInput();
        } else {
            // Cambiar la contraseña
            $user = auth()->user();
            $user->password = bcrypt($request->input('new_password'));
            $user->save();

            session()->flash('message', 'Se han actualizado la contraseña con éxito');
            return redirect()->route('profile.show');
        }
    }
}
