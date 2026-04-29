<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistorialTraspaso extends Model
{
    use SoftDeletes;

    protected $table = 'historial_traspasos';

    protected $fillable = [
        'activo_id',
        'empleado_origen_id',
        'empleado_destino_id',
        'departamento_origen_id',
        'departamento_id',
        'edificio_id',
        'fecha_traspaso',
        'motivo_traspaso',
        'grupo_traspaso_id',
        'usuario_email',
    ];

    protected $casts = [
        'fecha_traspaso' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'activo_id', 'folio');
    }

    public function empleadoOrigen()
    {
        return $this->belongsTo(CatalogoEmpleado::class, 'empleado_origen_id');
    }

    public function empleadoDestino()
    {
        return $this->belongsTo(CatalogoEmpleado::class, 'empleado_destino_id');
    }

    public function edificio()
    {
        return $this->belongsTo(CatalogoEdificio::class, 'edificio_id');
    }

    public function departamentoOrigen()
    {
        return $this->belongsTo(CatalogoDepartamento::class, 'departamento_origen_id');
    }

    public function departamentoDestino()
    {
        return $this->belongsTo(CatalogoDepartamento::class, 'departamento_id');
    }
}
