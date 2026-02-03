<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoEmpleado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catalogo_empleado';

    protected $fillable = [
        'nombre',
        'no_nomi',
        'id_depto',
        'id_edif',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function departamento()
    {
        return $this->belongsTo(CatalogoDepartamento::class, 'id_depto');
    }

    public function edificio()
    {
        return $this->belongsTo(CatalogoEdificio::class, 'id_edif');
    }

    public function activos()
    {
        return $this->hasMany(Activo::class, 'empleado_id');
    }
}