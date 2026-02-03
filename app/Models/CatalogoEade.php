<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoEade extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catalogo_eade';

    protected $fillable = [
        'descripcion',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function activos()
    {
        return $this->hasMany(Activo::class, 'eade_id');
    }
}