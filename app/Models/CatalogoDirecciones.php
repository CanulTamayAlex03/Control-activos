<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoDirecciones extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catalogo_direcciones';

    protected $fillable = [
        'descripcion',
    ];


    public function activos()
    {
        return $this->hasMany(Activo::class, 'direccion_id');
    }
}