<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Designacion extends Model
{
    protected $table = 'designaciones';
    
    protected $fillable = [
        'area_id',
        'responsable_id',
        'fecha_inicio',
        'fecha_fin',
        'periodicidad',
        'observaciones',
        'activo'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean'
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(Responsable::class);
    }

    public function scopeActivas($query)
    {
        return $query->where('activo', true)
                    ->where(function ($q) {
                        $q->whereNull('fecha_fin')
                          ->orWhere('fecha_fin', '>=', now());
                    });
    }

    public function scopeParaFecha($query, $fecha)
    {
        return $query->where('fecha_inicio', '<=', $fecha)
                    ->where(function ($q) use ($fecha) {
                        $q->whereNull('fecha_fin')
                          ->orWhere('fecha_fin', '>=', $fecha);
                    });
    }
    
    public function activa(): bool
    {
        if (!$this->activo) {
            return false;
        }
        
        if ($this->fecha_fin) {
            return $this->fecha_fin->isFuture() || $this->fecha_fin->isToday();
        }
        
        return true;
    }
}
