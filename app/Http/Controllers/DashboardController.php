<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activo;

class DashboardController extends Controller
{
    public function index()
    {
        $estadisticas = [
            'total_activos' => Activo::count(),
            'activos_activos' => Activo::where('status', true)->count(),
            'activos_inactivos' => Activo::where('status', false)->count(),
        ];

        return view('dashboard', compact('estadisticas'));
    }
}