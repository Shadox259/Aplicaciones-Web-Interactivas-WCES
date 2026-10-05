@extends('layouts.app')

@section('titulo', 'Iniciar sesión')

@section('contenido')
<div class="tarjeta" style="max-width:400px;margin:0 auto;">
    <h1>Iniciar sesión</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label>Correo</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <div class="error">{{ $message }}</div> @enderror

        <label>Contraseña</label>
        <input type="password" name="password" required>
        @error('password') <div class="error">{{ $message }}</div> @enderror

        <div class="acciones">
            <button type="submit" class="btn">Entrar</button>
            <a href="{{ route('register') }}" class="btn btn-sec">Crear cuenta</a>
        </div>
    </form>
</div>
@endsection