<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistorialBaja extends Model
{
    use SoftDeletes;

    protected $table = 'historial_bajas';

    protected $fillable = [
        'activo_id',
        'empleado_id',
        'departamento_id',
        'edificio_id',
        'fecha_baja',
        'motivo_baja',
        'grupo_baja_id',
        'usuario_email',
    ];

    protected $casts = [
        'fecha_baja' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'activo_id', 'folio');
    }

    public function empleado()
    {
        return $this->belongsTo(CatalogoEmpleado::class, 'empleado_id');
    }

    public function departamento()
    {
        return $this->belongsTo(CatalogoDepartamento::class, 'departamento_id');
    }

    public function edificio()
    {
        return $this->belongsTo(CatalogoEdificio::class, 'edificio_id');
    }

    public function bajasDelGrupo()
    {
        return $this->hasMany(HistorialBaja::class, 'grupo_baja_id', 'grupo_baja_id');
    }
}