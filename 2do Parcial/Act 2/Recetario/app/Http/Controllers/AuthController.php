<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulario de login.
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesar login.
    public function login(Request $peticion)
    {
        $credenciales = $peticion->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'El correo es obligatorio.',
            'email.email'       => 'El correo no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (Auth::attempt($credenciales)) {
            $peticion->session()->regenerate();
            return redirect()->route('recipes.index')->with('exito', 'Bienvenido de nuevo.');
        }

        return back()
            ->withErrors(['email' => 'Las credenciales no coinciden.'])
            ->onlyInput('email');
    }

    // Mostrar formulario de registro.
    public function showRegister()
    {
        return view('auth.register');
    }

    // Procesar registro.
    public function register(Request $peticion)
    {
        $datos = $peticion->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'email.required'     => 'El correo es obligatorio.',
            'email.email'        => 'El correo no es válido.',
            'email.unique'       => 'Ese correo ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $datos['password'] = Hash::make($datos['password']);

        $usuario = User::create($datos);

        Auth::login($usuario);

        return redirect()->route('recipes.index')->with('exito', 'Cuenta creada correctamente.');
    }

    // Cerrar sesión.
    public function logout(Request $peticion)
    {
        Auth::logout();
        $peticion->session()->invalidate();
        $peticion->session()->regenerateToken();

        return redirect()->route('login')->with('exito', 'Sesión cerrada.');
    }
}