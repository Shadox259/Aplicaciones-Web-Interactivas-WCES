@extends('layouts.app')

@section('titulo', 'Editar torneo')

@section('contenido')

<div class="tarjeta" style="max-width:700px;margin:0 auto;">
    <h1>Editar torneo</h1>

    @if ($torneo->inscritos() > 0)
        <div class="alerta" style="background:#fef3c7;color:#92400e;border-left:4px solid #d97706;">
            Este torneo tiene <strong>{{ $torneo->inscritos() }}</strong>
            jugador(es) inscrito(s). El cupo no puede ser menor a esa cantidad.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.tournaments.update', $torneo) }}">
        @csrf
        @method('PUT')

        <label>Nombre del torneo *</label>
        <input type="text" name="nombre"
               value="{{ old('nombre', $torneo->nombre) }}" required maxlength="255">
        @error('nombre') <div class="error">{{ $message }}</div> @enderror

        <label>Juego o deporte *</label>
        <input type="text" name="juego"
               value="{{ old('juego', $torneo->juego) }}" required maxlength="255">
        @error('juego') <div class="error">{{ $message }}</div> @enderror

        <label>Fecha *</label>
        <input type="date" name="fecha"
               value="{{ old('fecha', $torneo->fecha->format('Y-m-d')) }}" required>
        @error('fecha') <div class="error">{{ $message }}</div> @enderror

        <label>Cupo (entre 2 y 100) *</label>
        <input type="number" name="cupo"
               value="{{ old('cupo', $torneo->cupo) }}"
               min="{{ max(2, $torneo->inscritos()) }}" max="100" required>
        @error('cupo') <div class="error">{{ $message }}</div> @enderror

        <label>Descripción (opcional)</label>
        <textarea name="descripcion" maxlength="1000">{{ old('descripcion', $torneo->descripcion) }}</textarea>
        @error('descripcion') <div class="error">{{ $message }}</div> @enderror

        <div class="checkbox">
            <input type="checkbox" name="abierto" id="abierto" value="1"
                @checked(old('abierto', true))>
            <label for="abierto">Torneo abierto a inscripciones</label>
        </div>

        <div class="acciones">
            <button type="submit" class="btn">Actualizar</button>
            <a href="{{ route('admin.tournaments.index') }}" class="btn btn-sec">Cancelar</a>
        </div>
    </form>
</div>

@endsection