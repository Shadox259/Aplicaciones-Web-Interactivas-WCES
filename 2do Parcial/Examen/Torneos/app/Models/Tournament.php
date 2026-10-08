<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    protected $fillable = [
        'user_id', 'nombre', 'juego', 'fecha',
        'cupo', 'descripcion', 'abierto',
    ];

    protected $casts = [
        'fecha'   => 'date',
        'abierto' => 'boolean',
        'cupo'    => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'registrations')->withTimestamps();
    }

    public function inscritos(): int
    {
        return $this->registrations()->count();
    }

    public function cupoLibre(): int
    {
        return max(0, $this->cupo - $this->inscritos());
    }

    public function yaPaso(): bool
    {
        return $this->fecha->isPast();
    }

    public function lleno(): bool
    {
        return $this->inscritos() >= $this->cupo;
    }

    public function cerrado(): bool
    {
        return !$this->abierto || $this->yaPaso() || $this->lleno();
    }

    public function aceptaInscripciones(): bool
    {
        return !$this->cerrado();
    }

    public function estadoLegible(): string
    {
        if (!$this->abierto) return 'Cerrado';
        if ($this->yaPaso()) return 'Finalizado';
        if ($this->lleno())  return 'Lleno';
        return 'Abierto';
    }

    public function estadoColor(): string
    {
        return match ($this->estadoLegible()) {
            'Abierto'     => 'abierto',
            'Lleno'       => 'lleno',
            'Cerrado'     => 'cerrado',
            'Finalizado'  => 'finalizado',
            default       => 'cerrado',
        };
    }
}