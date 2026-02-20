<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoEdificio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catalogo_edificio';

    protected $fillable = [
        'descripcion',
    ];

    public function activos()
    {
        return $this->hasMany(Activo::class, 'edificio_id');
    }

    public function departamentos()
    {
        return $this->hasMany(CatalogoDepartamento::class, 'id_edif');
    }

    public function empleados()
    {
        return $this->hasMany(CatalogoEmpleado::class, 'id_edif');
    }
}