<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parametro extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'parametros';

    protected $fillable = [
        'descripcion',
        'nombre_completo',
        'valor_uma',
        'formato'
    ];

    protected $casts = [
        'valor_uma'   => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}