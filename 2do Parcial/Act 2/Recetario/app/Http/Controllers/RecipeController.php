<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index(Request $peticion)
    {
        $consulta = Auth::user()->recipes();

        if (array_key_exists($peticion->query('categoria'), Recipe::CATEGORIAS)) {
            $consulta->where('categoria', $peticion->query('categoria'));
        }

        if ($peticion->filled('q')) {
            $consulta->where('titulo', 'like', '%' . $peticion->query('q') . '%');
        }

        $recetas = $consulta->orderByDesc('created_at')->get();

        return view('recipes.index', [
            'recetas'    => $recetas,
            'categorias' => Recipe::CATEGORIAS,
            'filtros'    => $peticion->only(['q', 'categoria']),
        ]);
    }

    public function create()
    {
        return view('recipes.create', [
            'categorias'   => Recipe::CATEGORIAS,
            'dificultades' => Recipe::DIFICULTADES,
        ]);
    }

    public function store(Request $peticion)
    {
        $datos = $this->validar($peticion);
        $datos['user_id'] = Auth::id();

        Recipe::create($datos);

        return redirect()->route('recipes.index')->with('exito', 'Receta creada correctamente.');
    }

    public function show(Recipe $recipe)
    {
        $this->autorizar($recipe);

        return view('recipes.show', [
            'receta'      => $recipe,
            'categorias'  => Recipe::CATEGORIAS,
            'dificultades'=> Recipe::DIFICULTADES,
        ]);
    }

    public function edit(Recipe $recipe)
    {
        $this->autorizar($recipe);

        return view('recipes.edit', [
            'receta'      => $recipe,
            'categorias'  => Recipe::CATEGORIAS,
            'dificultades'=> Recipe::DIFICULTADES,
        ]);
    }

    public function update(Request $peticion, Recipe $recipe)
    {
        $this->autorizar($recipe);

        $recipe->update($this->validar($peticion));

        return redirect()->route('recipes.index')->with('exito', 'Receta actualizada correctamente.');
    }

    public function destroy(Recipe $recipe)
    {
        $this->autorizar($recipe);

        $recipe->delete();

        return redirect()->route('recipes.index')->with('exito', 'Receta eliminada correctamente.');
    }

    protected function validar(Request $peticion): array
    {
        return $peticion->validate(
            [
                'titulo'         => 'required|string|max:255',
                'categoria'      => 'required|in:desayuno,almuerzo,cena,postre,bebida',
                'tiempo_minutos' => 'required|integer|min:1',
                'dificultad'     => 'required|in:facil,media,dificil',
                'ingredientes'   => 'required|string',
                'pasos'          => 'required|string',
            ],
            [
                'titulo.required'         => 'El título es obligatorio.',
                'titulo.max'              => 'El título no puede tener más de 255 caracteres.',
                'categoria.required'      => 'La categoría es obligatoria.',
                'categoria.in'            => 'La categoría no es válida.',
                'tiempo_minutos.required' => 'El tiempo es obligatorio.',
                'tiempo_minutos.integer'  => 'El tiempo debe ser un número entero.',
                'tiempo_minutos.min'      => 'El tiempo debe ser mayor a 0 minutos.',
                'dificultad.required'     => 'La dificultad es obligatoria.',
                'dificultad.in'           => 'La dificultad no es válida.',
                'ingredientes.required'   => 'Los ingredientes son obligatorios.',
                'pasos.required'          => 'Los pasos son obligatorios.',
            ]
        );
    }

    protected function autorizar(Recipe $recipe): void
    {
        abort_if($recipe->user_id !== Auth::id(), 403);
    }
}