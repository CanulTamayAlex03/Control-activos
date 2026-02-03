<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activos';
    protected $primaryKey = 'folio';
    public $incrementing = true;


    protected $fillable = [
        'numero_inventario',
        'descripcion_corta',
        'descripcion_larga',
        'marca',
        'modelo',
        'numero_serie',
        'fecha_adquisicion',
        'clasificacion_id',
        'estado_bien_id',
        'rubro_id',
        'es_donacion',
        'donante',
        'proveedor_id',
        'costo',
        'numero_factura',
        'numero_pedido',
        'entrada_almacen',
        'salida_almacen',
        'observaciones',
        'empleado_id',
        'edificio_id',
        'departamento_id',
        'subgerencia_id',
        'ubr_id',
        'eade_id',
        'fecha_asignacion',
        'status',
    ];

    protected $casts = [
        'fecha_adquisicion' => 'date',
        'es_donacion' => 'boolean',
        'costo' => 'decimal:2',
        'entrada_almacen' => 'date',
        'salida_almacen' => 'date',
        'fecha_asignacion' => 'date',
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    public function clasificacion()
    {
        return $this->belongsTo(CatalogoClasificacion::class, 'clasificacion_id');
    }


    public function estadoBien()
    {
        return $this->belongsTo(CatalogoEstadoBien::class, 'estado_bien_id');
    }


    public function rubro()
    {
        return $this->belongsTo(CatalogoRubro::class, 'rubro_id');
    }


    public function proveedor()
    {
        return $this->belongsTo(CatalogoProveedor::class, 'proveedor_id');
    }


    public function empleado()
    {
        return $this->belongsTo(CatalogoEmpleado::class, 'empleado_id');
    }


    public function edificio()
    {
        return $this->belongsTo(CatalogoEdificio::class, 'edificio_id');
    }


    public function departamento()
    {
        return $this->belongsTo(CatalogoDepartamento::class, 'departamento_id');
    }


    public function subgerencia()
    {
        return $this->belongsTo(CatalogoSubgerencia::class, 'subgerencia_id');
    }


    public function ubr()
    {
        return $this->belongsTo(CatalogoUbr::class, 'ubr_id');
    }

    public function eade()
    {
        return $this->belongsTo(CatalogoEade::class, 'eade_id');
    }


    public function estaAsignado()
    {
        return !is_null($this->fecha_asignacion);
    }


    public function estaEnAlmacen()
    {
        return is_null($this->salida_almacen);
    }


    public function esDonacion()
    {
        return (bool) $this->es_donacion;
    }

    public function estaActivo()
    {
        return (bool) $this->status;
    }


    public function getCostoFormateadoAttribute()
    {
        return '$' . number_format($this->costo, 2);
    }


    public function scopeActivos($query)
    {
        return $query->where('status', true);
    }

 
    public function scopeInactivos($query)
    {
        return $query->where('status', false);
    }


    public function scopeDonaciones($query)
    {
        return $query->where('es_donacion', true);
    }


    public function scopeEnAlmacen($query)
    {
        return $query->whereNotNull('entrada_almacen')
                    ->whereNull('salida_almacen');
    }


    public function scopeAsignados($query)
    {
        return $query->whereNotNull('fecha_asignacion');
    }


    public function scopePorInventario($query, $numeroInventario)
    {
        return $query->where('numero_inventario', 'LIKE', "%{$numeroInventario}%");
    }


    public function scopePorNumeroSerie($query, $numeroSerie)
    {
        return $query->where('numero_serie', 'LIKE', "%{$numeroSerie}%");
    }


    public function scopePorDescripcion($query, $descripcion)
    {
        return $query->where(function($q) use ($descripcion) {
            $q->where('descripcion_corta', 'LIKE', "%{$descripcion}%")
              ->orWhere('descripcion_larga', 'LIKE', "%{$descripcion}%");
        });
    }
}