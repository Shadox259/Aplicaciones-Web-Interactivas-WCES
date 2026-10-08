<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

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

            $destino = Auth::user()->esAdmin()
                ? route('admin.tournaments.index')
                : route('tournaments.index');

            return redirect($destino)->with('exito', 'Bienvenido, ' . Auth::user()->name . '.');
        }

        return back()
            ->withErrors(['email' => 'Las credenciales no coinciden.'])
            ->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

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
        $datos['role']     = 'jugador';

        $usuario = User::create($datos);
        Auth::login($usuario);

        return redirect()->route('tournaments.index')
            ->with('exito', 'Cuenta creada. ¡Bienvenido!');
    }

    public function logout(Request $peticion)
    {
        Auth::logout();
        $peticion->session()->invalidate();
        $peticion->session()->regenerateToken();

        return redirect()->route('tournaments.index')
            ->with('exito', 'Sesión cerrada correctamente.');
    }
}