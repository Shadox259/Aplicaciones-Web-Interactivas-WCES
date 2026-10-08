@extends('layouts.app')

@section('titulo', 'Mis torneos')

@section('contenido')

<h1>Mis torneos</h1>

@if ($inscripciones->isEmpty())
    <div class="tarjeta" style="text-align:center;padding:2.5rem;">
        <p style="font-size:1.1rem;color:#6b7280;margin:0 0 .5rem;">
            Aún no estás inscrito en ningún torneo.
        </p>
        <p style="color:#9ca3af;font-size:.9rem;margin:0 0 1rem;">
            Explora los torneos disponibles y únete a uno.
        </p>
        <a href="{{ route('tournaments.index') }}" class="btn">Ver torneos disponibles</a>
    </div>
@else
    <div class="grid">
        @foreach ($inscripciones as $inscripcion)
            @php $torneo = $inscripcion->tournament; @endphp
            <div class="tarjeta">
                <div style="display:flex;justify-content:space-between;align-items:start;gap:.5rem;margin-bottom:.5rem;">
                    <h3 style="margin:0;font-size:1.1rem;">{{ $torneo->nombre }}</h3>
                    <span class="etiqueta {{ $torneo->estadoColor() }}">{{ $torneo->estadoLegible() }}</span>
                </div>

                <p style="margin:.25rem 0;color:#4b5563;font-size:.9rem;">
                    <strong>{{ $torneo->juego }}</strong>
                </p>
                <p style="margin:.25rem 0;color:#4b5563;font-size:.9rem;">
                    {{ $torneo->fecha->format('d/m/Y') }}
                </p>
                <p style="margin:.25rem 0;color:#6b7280;font-size:.85rem;">
                    Inscrito el {{ $inscripcion->created_at->format('d/m/Y H:i') }}
                </p>

                <div class="acciones">
                    <a href="{{ route('tournaments.show', $torneo) }}" class="btn btn-sm btn-sec">Ver</a>

                    @if (!$torneo->yaPaso())
                        <form method="POST"
                              action="{{ route('registrations.destroy', $torneo) }}"
                              onsubmit="return confirm('¿Cancelar tu inscripción? Se liberará tu plaza.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Cancelar inscripción</button>
                        </form>
                    @else
                        <span style="font-size:.8rem;color:#9ca3af;align-self:center;">
                            (El torneo ya comenzó, no puedes cancelar)
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection