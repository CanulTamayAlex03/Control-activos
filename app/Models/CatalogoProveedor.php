<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoProveedor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catalogo_proveedor';

    protected $fillable = [
        'nomcorto',
        'rz',
        'rfc',
        'domicilio',
        'ciudad',
        'estado',
        'telefono1',
        'telefono2',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function activos()
    {
        return $this->hasMany(Activo::class, 'proveedor_id');
    }
}