@extends('layouts.app')

@section('titulo', 'Mis recetas')

@section('contenido')
<h1>Mis recetas</h1>

<form method="GET" action="{{ route('recipes.index') }}" class="filtros">
    <input type="text" name="q" placeholder="Buscar por título..." value="{{ $filtros['q'] ?? '' }}">

    <select name="categoria">
        <option value="">Todas las categorías</option>
        @foreach ($categorias as $clave => $etiqueta)
            <option value="{{ $clave }}" @selected(($filtros['categoria'] ?? '') === $clave)>{{ $etiqueta }}</option>
        @endforeach
    </select>

    <button type="submit" class="btn">Filtrar</button>
    <a href="{{ route('recipes.index') }}" class="btn btn-sec">Limpiar</a>
</form>

@if ($recetas->isEmpty())
    <div class="tarjeta" style="text-align:center;padding:2rem;">
        <p style="font-size:1.1rem;color:#6b7280;">No se encontraron recetas.</p>
        <p style="color:#9ca3af;font-size:.9rem;">
            @if (!empty($filtros['q']) || !empty($filtros['categoria']))
                Prueba con otros filtros o <a href="{{ route('recipes.index') }}">límpialos</a>.
            @else
                <a href="{{ route('recipes.create') }}">Crea tu primera receta</a>.
            @endif
        </p>
    </div>
@else
    <div class="grid">
        @foreach ($recetas as $receta)
            <div class="tarjeta">
                <h3 style="margin-top:0;">{{ $receta->titulo }}</h3>

                <div style="margin-bottom:.75rem;">
                    <span class="etiqueta cat">{{ $categorias[$receta->categoria] }}</span>
                    <span class="etiqueta tiempo">⏱ {{ $receta->tiempo_minutos }} min</span>
                    <span class="etiqueta dif">{{ \App\Models\Recipe::DIFICULTADES[$receta->dificultad] }}</span>
                </div>

                <p style="color:#4b5563;font-size:.9rem;">
                    {{ \Illuminate\Support\Str::limit($receta->ingredientes, 100) }}
                </p>

                <div class="acciones">
                    <a href="{{ route('recipes.show', $receta) }}" class="btn btn-sm btn-sec">Ver</a>
                    <a href="{{ route('recipes.edit', $receta) }}" class="btn btn-sm">Editar</a>

                    <form method="POST" action="{{ route('recipes.destroy', $receta) }}"
                          onsubmit="return confirm('¿Eliminar esta receta?')" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection