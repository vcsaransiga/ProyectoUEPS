<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PragmaRX\Google2FA\Google2FA;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        return view('modules.users.profile', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        Log::info('Datos de la solicitud para actualización de perfil:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => ['nullable', 'regex:/^09[0-9]{8}$/'],
            'about' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.max' => 'El nombre no puede tener más de 255 caracteres',
            'last_name.required' => 'El apellido es obligatorio',
            'last_name.string' => 'El apellido debe ser una cadena de caracteres',
            'last_name.max' => 'El apellido no puede tener más de 255 caracteres',
            'phone.regex' => 'El número de teléfono debe ser un número ecuatoriano válido y comenzar con 09',
            'about.string' => 'La descripción debe ser una cadena de caracteres',
            'about.max' => 'La descripción no puede tener más de 1000 caracteres',
            'profile_photo.image' => 'El archivo debe ser una imagen',
            'profile_photo.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg, gif o svg',
            'profile_photo.max' => 'La imagen no puede tener más de 2048 kilobytes',
        ]);

        $data = $request->only('name', 'last_name', 'phone', 'about');

        // Manejar la subida de la imagen de perfil
        if ($request->hasFile('profile_photo')) {
            // Eliminar la foto anterior si existe
            if ($user->profile_photo && Storage::exists('public/' . $user->profile_photo)) {
                Storage::delete('public/' . $user->profile_photo);
            }

            // Guardar la nueva foto
            $imagePath = $request->file('profile_photo')->store('profile_photos', 'public');
            $data['profile_photo'] = $imagePath;
        }

        // Actualizar la opción de autenticación de dos factores
        if ($request->has('two_factor_enabled')) {
            $user->two_factor_enabled = true;
            $user->token_login = (new Google2FA())->generateSecretKey();
        } else {
            $user->two_factor_enabled = false;
            $user->token_login = null;
        }

        $user->update($data);

        // Recargar los datos del usuario para asegurarse de que los cambios se reflejen
        $user->refresh();

        Log::info('Perfil actualizado para el usuario', ['user_id' => $user->id]);

        return redirect()->back()->with('success', 'Tu perfil ha sido actualizado.');
    }
}
