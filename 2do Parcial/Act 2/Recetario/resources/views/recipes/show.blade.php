@extends('layouts.app')

@section('titulo', $receta->titulo)

@section('contenido')
<div class="tarjeta" style="max-width:800px;margin:0 auto;">
    <h1>{{ $receta->titulo }}</h1>

    <div style="margin-bottom:1rem;">
        <span class="etiqueta cat">{{ $categorias[$receta->categoria] }}</span>
        <span class="etiqueta tiempo">⏱ {{ $receta->tiempo_minutos }} min</span>
        <span class="etiqueta dif">{{ $dificultades[$receta->dificultad] }}</span>
    </div>

    <h2>Ingredientes</h2>
    <ul>
        @foreach ($receta->ingredientesArray() as $ingrediente)
            <li>{{ $ingrediente }}</li>
        @endforeach
    </ul>

    <h2>Pasos</h2>
    <ol>
        @foreach ($receta->pasosArray() as $paso)
            <li>{{ $paso }}</li>
        @endforeach
    </ol>

    <div class="acciones">
        <a href="{{ route('recipes.edit', $receta) }}" class="btn">Editar</a>
        <a href="{{ route('recipes.index') }}" class="btn btn-sec">Volver</a>

        <form method="POST" action="{{ route('recipes.destroy', $receta) }}"
              onsubmit="return confirm('¿Eliminar esta receta? Esta acción no se puede deshacer.')" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</div>
@endsection