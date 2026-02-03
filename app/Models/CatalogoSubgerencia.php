<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoSubgerencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catalogo_subgerencia';

    protected $fillable = [
        'descripcion',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function activos()
    {
        return $this->hasMany(Activo::class, 'subgerencia_id');
    }
}