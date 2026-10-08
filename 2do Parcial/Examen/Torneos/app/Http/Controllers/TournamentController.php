<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    public function index(Request $peticion)
    {
        $consulta = Tournament::query()
            ->where('abierto', true)
            ->where('fecha', '>=', now()->toDateString())
            ->withCount('registrations')
            ->orderBy('fecha');

        if ($peticion->filled('q')) {
            $consulta->where(function ($q) use ($peticion) {
                $q->where('nombre', 'like', '%' . $peticion->query('q') . '%')
                  ->orWhere('juego', 'like', '%' . $peticion->query('q') . '%');
            });
        }

        $torneos = $consulta->get()->filter(fn ($t) => !$t->lleno());

        return view('tournaments.index', [
            'torneos' => $torneos,
            'filtros' => $peticion->only(['q']),
        ]);
    }

    public function show(Tournament $tournament)
    {
        $tournament->load(['players', 'registrations']);

        $inscrito = Auth::check()
            ? $tournament->registrations->where('user_id', Auth::id())->isNotEmpty()
            : false;

        return view('tournaments.show', [
            'torneo'  => $tournament,
            'inscrito'=> $inscrito,
        ]);
    }

    public function adminIndex()
    {
        $torneos = Tournament::withCount('registrations')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.tournaments.index', compact('torneos'));
    }

    public function create()
    {
        return view('admin.tournaments.create');
    }

    public function store(Request $peticion)
    {
        $datos = $this->validar($peticion);
        $datos['user_id'] = Auth::id();
        $datos['abierto'] = $peticion->boolean('abierto');

        Tournament::create($datos);

        return redirect()->route('admin.tournaments.index')
            ->with('exito', 'Torneo creado correctamente.');
    }

    public function edit(Tournament $tournament)
    {
        return view('admin.tournaments.edit', ['torneo' => $tournament]);
    }

    public function update(Request $peticion, Tournament $tournament)
    {
        $datos = $this->validar($peticion);

        $inscritos = $tournament->inscritos();
        if ($datos['cupo'] < $inscritos) {
            return back()
                ->withErrors(['cupo' => "El cupo no puede ser menor a los {$inscritos} inscritos actuales."])
                ->withInput();
        }

        $datos['abierto'] = $peticion->boolean('abierto');

        $tournament->update($datos);

        return redirect()->route('admin.tournaments.index')
            ->with('exito', 'Torneo actualizado correctamente.');
    }

    public function destroy(Tournament $tournament)
    {
        $tournament->delete();

        return redirect()->route('admin.tournaments.index')
            ->with('exito', 'Torneo eliminado (con sus inscripciones).');
    }

    protected function validar(Request $peticion, ?Tournament $tournament = null): array
    {
        $inscritos = $tournament ? $tournament->inscritos() : 0;

        return $peticion->validate(
            [
                'nombre'      => 'required|string|max:255',
                'juego'       => 'required|string|max:255',
                'fecha'       => 'required|date|after_or_equal:today',
                'cupo'        => 'required|integer|min:2|max:100',
                'descripcion' => 'nullable|string|max:1000',
                'abierto'     => 'nullable|boolean',
            ],
            [
                'nombre.required'      => 'El nombre es obligatorio.',
                'nombre.max'           => 'El nombre no puede tener más de 255 caracteres.',
                'juego.required'       => 'El juego o deporte es obligatorio.',
                'juego.max'            => 'El juego no puede tener más de 255 caracteres.',
                'fecha.required'       => 'La fecha es obligatoria.',
                'fecha.date'           => 'La fecha no es válida.',
                'fecha.after_or_equal' => 'La fecha debe ser hoy o en el futuro.',
                'cupo.required'        => 'El cupo es obligatorio.',
                'cupo.integer'         => 'El cupo debe ser un número entero.',
                'cupo.min'             => 'El cupo debe ser al menos 2.',
                'cupo.max'             => 'El cupo no puede superar 100.',
                'descripcion.max'      => 'La descripción no puede tener más de 1000 caracteres.',
            ]
        ) + ['__inscritos' => $inscritos];
    }
}