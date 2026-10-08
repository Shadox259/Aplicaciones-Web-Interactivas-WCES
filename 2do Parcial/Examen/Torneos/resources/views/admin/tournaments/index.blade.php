@extends('layouts.app')

@section('titulo', 'Panel de torneos')

@section('contenido')

<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
    <h1 style="margin:0;">Panel de torneos</h1>
    <a href="{{ route('admin.tournaments.create') }}" class="btn">+ Nuevo torneo</a>
</div>

@if ($torneos->isEmpty())
    <div class="tarjeta" style="text-align:center;padding:2.5rem;margin-top:1.5rem;">
        <p style="color:#6b7280;">Aún no has creado torneos.</p>
        <a href="{{ route('admin.tournaments.create') }}" class="btn" style="margin-top:1rem;">
            Crear el primero
        </a>
    </div>
@else
    <div class="tarjeta" style="margin-top:1.5rem;padding:0;overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Juego</th>
                    <th>Fecha</th>
                    <th>Cupo</th>
                    <th>Estado</th>
                    <th style="width:18rem;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($torneos as $torneo)
                    <tr>
                        <td><strong>{{ $torneo->nombre }}</strong></td>
                        <td>{{ $torneo->juego }}</td>
                        <td>{{ $torneo->fecha->format('d/m/Y') }}</td>
                        <td>
                            {{ $torneo->inscritos() }} / {{ $torneo->cupo }}
                            @if ($torneo->cupoLibre() > 0)
                                <small style="color:#059669;">({{ $torneo->cupoLibre() }} libres)</small>
                            @else
                                <small style="color:#b91c1c;">(lleno)</small>
                            @endif
                        </td>
                        <td>
                            <span class="etiqueta {{ $torneo->estadoColor() }}">
                                {{ $torneo->estadoLegible() }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:.4rem;flex-wrap:wrap;">
                                <a href="{{ route('tournaments.show', $torneo) }}"
                                   class="btn btn-sm btn-sec">Ver</a>
                                <a href="{{ route('admin.tournaments.edit', $torneo) }}"
                                   class="btn btn-sm">Editar</a>
                                <form method="POST"
                                      action="{{ route('admin.tournaments.destroy', $torneo) }}"
                                      onsubmit="return confirm('¿Eliminar el torneo? Se borrarán también sus inscripciones.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@endsection