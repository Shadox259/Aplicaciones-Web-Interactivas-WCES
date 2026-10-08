@extends('layouts.app')

@section('titulo', $torneo->nombre)

@section('contenido')

<div class="tarjeta" style="max-width:800px;margin:0 auto;">

    <div style="display:flex;justify-content:space-between;align-items:start;gap:1rem;flex-wrap:wrap;">
        <div>
            <h1 style="margin:0 0 .5rem;">{{ $torneo->nombre }}</h1>
            <p style="margin:0;color:#4b5563;">
                <strong>{{ $torneo->juego }}</strong>
            </p>
        </div>
        <span class="etiqueta {{ $torneo->estadoColor() }}" style="font-size:.85rem;padding:.4rem .9rem;">
            {{ $torneo->estadoLegible() }}
        </span>
    </div>

    <hr style="margin:1.5rem 0;border:none;border-top:1px solid #e5e7eb;">

    {{-- Datos del torneo --}}
    <dl style="margin:0;">
        <dt style="font-size:.8rem;text-transform:uppercase;color:#6b7280;font-weight:600;margin-top:1rem;">Fecha</dt>
        <dd style="margin:.25rem 0 0;">{{ $torneo->fecha->format('d/m/Y') }}</dd>

        <dt style="font-size:.8rem;text-transform:uppercase;color:#6b7280;font-weight:600;margin-top:1rem;">Cupo</dt>
        <dd style="margin:.25rem 0 0;">
            {{ $torneo->inscritos() }} / {{ $torneo->cupo }}
            @if ($torneo->cupoLibre() > 0)
                · <span style="color:#059669;">{{ $torneo->cupoLibre() }} plazas libres</span>
            @else
                · <span style="color:#b91c1c;">Sin plazas</span>
            @endif
        </dd>

        @if ($torneo->descripcion)
            <dt style="font-size:.8rem;text-transform:uppercase;color:#6b7280;font-weight:600;margin-top:1rem;">Descripción</dt>
            <dd style="margin:.25rem 0 0;white-space:pre-line;">{{ $torneo->descripcion }}</dd>
        @endif

        <dt style="font-size:.8rem;text-transform:uppercase;color:#6b7280;font-weight:600;margin-top:1rem;">Creado por</dt>
        <dd style="margin:.25rem 0 0;">{{ $torneo->creator->name ?? 'Admin' }}</dd>
    </dl>

    {{-- Acciones según rol --}}
    <div class="acciones" style="margin-top:2rem;">
        <a href="{{ route('tournaments.index') }}" class="btn btn-sec">← Volver al listado</a>

        @auth
            @if (auth()->user()->esJugador())
                @if ($inscrito)
                    <form method="POST" action="{{ route('registrations.destroy', $torneo) }}"
                          onsubmit="return confirm('¿Cancelar tu inscripción? Se liberará tu plaza.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Cancelar inscripción</button>
                    </form>
                @elseif ($torneo->aceptaInscripciones())
                    <form method="POST" action="{{ route('registrations.store', $torneo) }}">
                        @csrf
                        <button type="submit" class="btn">Inscribirme</button>
                    </form>
                @else
                    <span class="btn btn-sec" style="cursor:not-allowed;opacity:.7;">
                        Inscripciones cerradas
                    </span>
                @endif
            @endif
        @else
            <a href="{{ route('login') }}" class="btn">Iniciar sesión para inscribirme</a>
        @endauth
    </div>

    {{-- Participantes --}}
    <h2 style="margin-top:2rem;">Participantes ({{ $torneo->players->count() }})</h2>

    @if ($torneo->players->isEmpty())
        <p style="color:#9ca3af;font-size:.9rem;font-style:italic;">
            Aún no hay jugadores inscritos.
        </p>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width:3rem;">#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Inscrito el</th>
                    @if (auth()->check() && auth()->user()->esAdmin())
                        <th style="width:8rem;">Acción</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($torneo->registrations as $i => $inscripcion)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $inscripcion->user->name }}</td>
                        <td>{{ $inscripcion->user->email }}</td>
                        <td>{{ $inscripcion->created_at->format('d/m/Y H:i') }}</td>
                        @if (auth()->check() && auth()->user()->esAdmin())
                            <td>
                                <form method="POST"
                                      action="{{ route('admin.registrations.destroy', $inscripcion) }}"
                                      onsubmit="return confirm('¿Dar de baja a este jugador?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Dar de baja</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>

@endsection