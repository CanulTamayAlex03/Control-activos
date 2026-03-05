<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoMunicipio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catalogo_municipios';

    protected $fillable = [
        'descripcion',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function ubrs()
    {
        return $this->hasMany(CatalogoUbr::class, 'mun_id', 'id');
    }
}