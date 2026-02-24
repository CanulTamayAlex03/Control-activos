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
        'direccion_id',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function edificio()
    {
        return $this->belongsTo(CatalogoEdificio::class, 'id_edif');
    }

    public function direccion()
    {
        return $this->belongsTo(CatalogoDirecciones::class, 'direccion_id');
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