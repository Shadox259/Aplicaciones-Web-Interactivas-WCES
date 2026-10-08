@extends('layouts.app')

@section('titulo', 'Registrarse')

@section('contenido')
<div class="tarjeta" style="max-width:400px;margin:0 auto;">
    <h1>Crear cuenta</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label>Nombre</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
        @error('name') <div class="error">{{ $message }}</div> @enderror

        <label>Correo</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <div class="error">{{ $message }}</div> @enderror

        <label>Contraseña</label>
        <input type="password" name="password" required>
        @error('password') <div class="error">{{ $message }}</div> @enderror

        <label>Confirmar contraseña</label>
        <input type="password" name="password_confirmation" required>

        <div class="acciones">
            <button type="submit" class="btn">Registrarme</button>
            <a href="{{ route('login') }}" class="btn btn-sec">Ya tengo cuenta</a>
        </div>
    </form>
</div>
@endsection