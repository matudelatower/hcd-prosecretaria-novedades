<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Area extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'padre_id',
        'tipo',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function hijos(): HasMany
    {
        return $this->hasMany(Area::class, 'padre_id');
    }

    public function padre(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'padre_id');
    }

    public function novedades(): HasMany
    {
        return $this->hasMany(Novedad::class);
    }

    public function designaciones(): HasMany
    {
        return $this->hasMany(Designacion::class);
    }

    public function getRutaCompletaAttribute(): string
    {
        $ruta = [$this->nombre];
        $padre = $this->padre;
        
        while ($padre) {
            array_unshift($ruta, $padre->nombre);
            $padre = $padre->padre;
        }
        
        return implode(' > ', $ruta);
    }
}
