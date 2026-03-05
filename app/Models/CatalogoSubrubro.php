<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoSubrubro extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catalogo_subrubro';

    protected $fillable = [
        'descripcion',
        'id_rubro',
        'subcuenta',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function rubro()
    {
        return $this->belongsTo(CatalogoRubro::class, 'id_rubro');
    }

    public function activos()
    {
        return $this->hasMany(Activo::class, 'subrubro_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('status', true);
    }
}