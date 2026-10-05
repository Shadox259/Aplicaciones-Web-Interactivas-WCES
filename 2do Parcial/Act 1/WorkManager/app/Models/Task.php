<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'prioridad',
        'vencimiento',
    ];

    protected $casts = [
        'vencimiento' => 'date',
    ];

    public const ESTADOS = [
        'por_hacer' => 'Por hacer',
        'en_curso' => 'En curso',
        'terminado' => 'Terminado',
    ];

    public const PRIORIDADES = [
        'baja' => 'Baja',
        'media' => 'Media',
        'alta' => 'Alta',
    ];
}