<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function store(Tournament $tournament)
    {
        if ($tournament->cerrado()) {
            return back()->with('error', 'Este torneo ya no acepta inscripciones.');
        }

        $yaInscrito = Registration::where('tournament_id', $tournament->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($yaInscrito) {
            return back()->with('error', 'Ya estás inscrito en este torneo.');
        }

        Registration::create([
            'tournament_id' => $tournament->id,
            'user_id'       => Auth::id(),
        ]);

        return redirect()->route('tournaments.show', $tournament)
            ->with('exito', '¡Inscripción exitosa!');
    }

    public function destroy(Tournament $tournament)
    {
        if ($tournament->yaPaso()) {
            return back()->with('error', 'No puedes cancelar: el torneo ya comenzó.');
        }

        $borradas = Registration::where('tournament_id', $tournament->id)
            ->where('user_id', Auth::id())
            ->delete();

        if (!$borradas) {
            return back()->with('error', 'No estabas inscrito en este torneo.');
        }

        return redirect()->route('registrations.mine')
            ->with('exito', 'Inscripción cancelada. Se liberó tu plaza.');
    }

    public function mine()
    {
        $inscripciones = Registration::with('tournament')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('registrations.mine', compact('inscripciones'));
    }

    public function adminDestroy(Registration $registration)
    {
        $registration->delete();

        return back()->with('exito', 'Inscripción eliminada por el administrador.');
    }
}