@extends('layouts.app')

@section('titulo', 'Nuevo torneo')

@section('contenido')

<div class="tarjeta" style="max-width:700px;margin:0 auto;">
    <h1>Nuevo torneo</h1>

    <form method="POST" action="{{ route('admin.tournaments.store') }}">
        @csrf

        <label>Nombre del torneo *</label>
        <input type="text" name="nombre" value="{{ old('nombre') }}" required maxlength="255">
        @error('nombre') <div class="error">{{ $message }}</div> @enderror

        <label>Juego o deporte *</label>
        <input type="text" name="juego" value="{{ old('juego') }}"
               placeholder="Fútbol, Básquetbol, Smash Bros..." required maxlength="255">
        @error('juego') <div class="error">{{ $message }}</div> @enderror

        <label>Fecha *</label>
        <input type="date" name="fecha"
               value="{{ old('fecha') }}"
               min="{{ now()->toDateString() }}" required>
        @error('fecha') <div class="error">{{ $message }}</div> @enderror

        <label>Cupo (entre 2 y 100) *</label>
        <input type="number" name="cupo"
               value="{{ old('cupo', 16) }}"
               min="2" max="100" required>
        @error('cupo') <div class="error">{{ $message }}</div> @enderror

        <label>Descripción (opcional)</label>
        <textarea name="descripcion" maxlength="1000"
                  placeholder="Reglas, formato, premios...">{{ old('descripcion') }}</textarea>
        @error('descripcion') <div class="error">{{ $message }}</div> @enderror

        <div class="checkbox">
            <input type="checkbox" name="abierto" id="abierto" value="1"
                   @checked(old('abierto', true))>
            <label for="abierto" style="margin:0;">Torneo abierto a inscripciones</label>
        </div>

        <div class="acciones">
            <button type="submit" class="btn">Guardar</button>
            <a href="{{ route('admin.tournaments.index') }}" class="btn btn-sec">Cancelar</a>
        </div>
    </form>
</div>

@endsection