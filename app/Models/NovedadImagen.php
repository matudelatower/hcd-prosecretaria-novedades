<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NovedadImagen extends Model
{
    protected $table = 'novedad_imagens';
    
    protected $fillable = [
        'novedad_id',
        'imagen',
        'descripcion',
    ];
    
    protected $casts = [
        'novedad_id' => 'integer',
    ];
    
    public function novedad()
    {
        return $this->belongsTo(Novedad::class);
    }
}
