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
        'fecha_alta',
        'telefono1',
        'telefono2',
        'telefonos',
        'dcredito',
        'lcredito',
        'adeudo',
        'grupo',
        'status',
    ];

    protected $casts = [
        'fecha_alta' => 'date',
        'dcredito' => 'integer',
        'lcredito' => 'integer',
        'adeudo' => 'integer',
        'grupo' => 'integer',
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $dates = [
        'fecha_alta',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function activos()
    {
        return $this->hasMany(Activo::class, 'proveedor_id');
    }

    public function getTelefonoPrincipalAttribute()
    {
        return $this->telefono1 ?? $this->telefonos ?? 'No registrado';
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nomcorto ?? $this->rz ?? 'Sin nombre';
    }

    public function getSaldoAttribute()
    {
        return $this->adeudo ?? 0;
    }

    public function scopeActivos($query)
    {
        return $query->where('status', 1);
    }

    public function scopeConAdeudo($query)
    {
        return $query->where('adeudo', '>', 0);
    }

    public function scopePorGrupo($query, $grupoId)
    {
        return $query->where('grupo', $grupoId);
    }

    public function setTelefono1Attribute($value)
    {
        $this->attributes['telefono1'] = $value ? preg_replace('/[^0-9]/', '', $value) : null;
    }

    public function setTelefono2Attribute($value)
    {
        $this->attributes['telefono2'] = $value ? preg_replace('/[^0-9]/', '', $value) : null;
    }

    public function setRfcAttribute($value)
    {
        $this->attributes['rfc'] = $value ? strtoupper($value) : null;
    }
}