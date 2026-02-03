<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoDepartamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catalogo_departamento';

    protected $fillable = [
        'descripcion',
        'id_edif',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function edificio()
    {
        return $this->belongsTo(CatalogoEdificio::class, 'id_edif');
    }

    public function activos()
    {
        return $this->hasMany(Activo::class, 'departamento_id');
    }

    public function empleados()
    {
        return $this->hasMany(CatalogoEmpleado::class, 'id_depto');
    }
}