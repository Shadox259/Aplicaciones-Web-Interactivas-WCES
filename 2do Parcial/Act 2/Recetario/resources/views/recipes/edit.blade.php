@extends('layouts.app')

@section('titulo', 'Editar receta')

@section('contenido')
<div class="tarjeta" style="max-width:700px;margin:0 auto;">
    <h1>Editar receta</h1>

    <form method="POST" action="{{ route('recipes.update', $receta) }}">
        @csrf
        @method('PUT')

        <label>Título *</label>
        <input type="text" name="titulo" value="{{ old('titulo', $receta->titulo) }}" required>
        @error('titulo') <div class="error">{{ $message }}</div> @enderror

        <label>Categoría *</label>
        <select name="categoria" required>
            @foreach ($categorias as $clave => $etiqueta)
                <option value="{{ $clave }}" @selected(old('categoria', $receta->categoria) === $clave)>{{ $etiqueta }}</option>
            @endforeach
        </select>
        @error('categoria') <div class="error">{{ $message }}</div> @enderror

        <label>Tiempo en minutos *</label>
        <input type="number" name="tiempo_minutos" min="1" value="{{ old('tiempo_minutos', $receta->tiempo_minutos) }}" required>
        @error('tiempo_minutos') <div class="error">{{ $message }}</div> @enderror

        <label>Dificultad *</label>
        <select name="dificultad" required>
            @foreach ($dificultades as $clave => $etiqueta)
                <option value="{{ $clave }}" @selected(old('dificultad', $receta->dificultad) === $clave)>{{ $etiqueta }}</option>
            @endforeach
        </select>
        @error('dificultad') <div class="error">{{ $message }}</div> @enderror

        <label>Ingredientes * (uno por línea)</label>
        <textarea name="ingredientes" required>{{ old('ingredientes', $receta->ingredientes) }}</textarea>
        @error('ingredientes') <div class="error">{{ $message }}</div> @enderror

        <label>Pasos * (uno por línea)</label>
        <textarea name="pasos" required>{{ old('pasos', $receta->pasos) }}</textarea>
        @error('pasos') <div class="error">{{ $message }}</div> @enderror

        <div class="acciones">
            <button type="submit" class="btn">Actualizar</button>
            <a href="{{ route('recipes.index') }}" class="btn btn-sec">Cancelar</a>
        </div>
    </form>
</div>
@endsection