<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    protected $fillable = [
        'user_id',
        'titulo',
        'categoria',
        'tiempo_minutos',
        'dificultad',
        'ingredientes',
        'pasos',
    ];

    protected $casts = [
        'tiempo_minutos' => 'integer',
    ];

    public const CATEGORIAS = [
        'desayuno' => 'Desayuno',
        'almuerzo' => 'Almuerzo',
        'cena'     => 'Cena',
        'postre'   => 'Postre',
        'bebida'   => 'Bebida',
    ];

    public const DIFICULTADES = [
        'facil'   => 'Fácil',
        'media'   => 'Media',
        'dificil' => 'Difícil',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ingredientesArray(): array
    {
        return array_values(array_filter(array_map('trim', explode("\n", $this->ingredientes))));
    }

    public function pasosArray(): array
    {
        return array_values(array_filter(array_map('trim', explode("\n", $this->pasos))));
    }
}