<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Responsable extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'telefono',
        'email',
        'user_id',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    public function novedades(): HasMany
    {
        return $this->hasMany(Novedad::class);
    }

    public function designaciones(): HasMany
    {
        return $this->hasMany(Designacion::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
