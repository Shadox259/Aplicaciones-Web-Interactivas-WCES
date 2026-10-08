@extends('layouts.app')

@section('titulo', 'Torneos disponibles')

@section('contenido')

<h1>Torneos disponibles</h1>

{{-- Filtro / buscador --}}
<form method="GET" action="{{ route('tournaments.index') }}" class="filtros">
    <input type="text" name="q" placeholder="Buscar por nombre o juego..."
           value="{{ $filtros['q'] ?? '' }}">
    <button type="submit" class="btn">Buscar</button>
    @if (!empty($filtros['q']))
        <a href="{{ route('tournaments.index') }}" class="btn btn-sec">Limpiar</a>
    @endif
</form>

@if ($torneos->isEmpty())
    <div class="tarjeta" style="text-align:center;padding:2.5rem;">
        <p style="font-size:1.15rem;color:#6b7280;margin:0 0 .5rem;">
            No hay torneos disponibles por el momento.
        </p>
        <p style="color:#9ca3af;font-size:.9rem;margin:0;">
            @if (!empty($filtros['q']))
                No se encontraron resultados para "<strong>{{ $filtros['q'] }}</strong>".
                Prueba con otro término o <a href="{{ route('tournaments.index') }}">limpia la búsqueda</a>.
            @else
                Vuelve más tarde o consulta con el administrador.
            @endif
        </p>
    </div>
@else
    <div class="grid">
        @foreach ($torneos as $torneo)
            <div class="tarjeta">
                <div style="display:flex;justify-content:space-between;align-items:start;gap:.5rem;margin-bottom:.5rem;">
                    <h3 style="margin:0;font-size:1.15rem;">{{ $torneo->nombre }}</h3>
                    <span class="etiqueta {{ $torneo->estadoColor() }}">{{ $torneo->estadoLegible() }}</span>
                </div>

                <p style="margin:.25rem 0;color:#4b5563;font-size:.9rem;">
                    <strong>{{ $torneo->juego }}</strong>
                </p>
                <p style="margin:.25rem 0;color:#4b5563;font-size:.9rem;">
                    {{ $torneo->fecha->format('d/m/Y') }}
                </p>
                <p style="margin:.25rem 0;color:#4b5563;font-size:.9rem;">
                    {{ $torneo->inscritos() }} / {{ $torneo->cupo }} inscritos
                    · <span style="color:#059669;">{{ $torneo->cupoLibre() }} libres</span>
                </p>

                @if ($torneo->descripcion)
                    <p style="margin:.75rem 0 0;color:#6b7280;font-size:.85rem;">
                        {{ \Illuminate\Support\Str::limit($torneo->descripcion, 100) }}
                    </p>
                @endif

                <div class="acciones">
                    <a href="{{ route('tournaments.show', $torneo) }}" class="btn btn-sm">Ver detalle</a>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection