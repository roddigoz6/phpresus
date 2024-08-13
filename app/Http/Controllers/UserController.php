<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //
    public function index(){
        $user = Auth::user();

        return view("pages.user.index", ['user'=>$user]);
    }

    public function update(Request $request, User $user)
    {
        try {
            // Validación de los datos de entrada
            $data = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'sometimes|string|min:8|confirmed',
            ]);

            // Actualización de los datos del usuario solo si están presentes en la solicitud
            if ($request->has('name')) {
                $user->name = $request->name;
            }
            if ($request->has('email')) {
                $user->email = $request->email;
            }
            if ($request->has('password')) {
                $user->password = bcrypt($request->password);
            }

            // Guardar los cambios en el usuario
            $user->save();

            // Redirigir con un mensaje de éxito
            return redirect()->back()->with('update_user', 'Cuenta actualizada.');

        } catch (ValidationException $e) {
            // Redirigir con un mensaje de error si la validación falla
            return redirect()->back()->with('update_user_fail', 'La validación falló. Inténtalo de nuevo.');
        }
    }
}
