<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\CatalogoClasificacion;
use App\Models\CatalogoEstadoBien;
use App\Models\CatalogoRubro;
use App\Models\CatalogoSubrubro;
use App\Models\CatalogoProveedor;
use App\Models\CatalogoEmpleado;
use App\Models\CatalogoEdificio;
use App\Models\CatalogoDepartamento;
use App\Models\CatalogoDirecciones;
use App\Models\CatalogoUbr;
use App\Models\CatalogoEade;
use App\Models\Parametro;
use App\Models\HistorialTraspaso;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ActivoController extends Controller
{

    public function index(Request $request)
    {
        try {
            $viewMode = $request->get('view_mode', session('view_mode', 'card'));
            session(['view_mode' => $viewMode]);

            $totalActivos = Activo::count();
            $parametrosFirmas = Parametro::all();
            $valorUma = Parametro::where('id', 4)->value('valor_uma');

            $activo = null;
            $searchTerm = $request->get('search');

            if ($viewMode === 'table') {
                $activos = Activo::with([
                    'empleado',
                    'edificio',
                    'departamento'
                ]);

                if (!empty($searchTerm)) {
                    $activos = $activos->where(function ($query) use ($searchTerm) {
                        if (is_numeric($searchTerm)) {
                            $query->where('folio', $searchTerm);
                        }
                        $query->orWhere('numero_inventario', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('descripcion_corta', 'LIKE', "%{$searchTerm}%");
                    });
                }

                $activos = $activos->orderBy('folio')->paginate(15);

                $activo = null;
                $activoAnterior = null;
                $activoSiguiente = null;
                $primerActivo = null;
                $ultimoActivo = null;
                $estadisticas = null;

                return view('activos.index', compact(
                    'activos',
                    'totalActivos',
                    'parametrosFirmas',
                    'valorUma',
                    'viewMode',
                    'activo',
                    'activoAnterior',
                    'activoSiguiente',
                    'primerActivo',
                    'ultimoActivo',
                    'estadisticas'
                ))->with('searchTerm', $searchTerm);
            }

            if (!empty($searchTerm)) {
                $activo = Activo::with([
                    'clasificacion',
                    'estadoBien',
                    'rubro',
                    'proveedor',
                    'empleado',
                    'edificio',
                    'departamento',
                    'direccion',
                    'ubr',
                    'eade'
                ])->where(function ($query) use ($searchTerm) {
                    if (is_numeric($searchTerm)) {
                        $query->where('folio', $searchTerm);
                    }
                    $query->orWhere('numero_inventario', 'LIKE', "%{$searchTerm}%");
                })->first();

                if (!$activo) {
                    $activo = Activo::with([
                        'clasificacion',
                        'estadoBien',
                        'rubro',
                        'proveedor',
                        'empleado',
                        'edificio',
                        'departamento',
                        'direccion',
                        'ubr',
                        'eade'
                    ])->first();
                }
            } else {
                $activoId = $request->get('id', Activo::min('folio'));

                $activo = Activo::with([
                    'clasificacion',
                    'estadoBien',
                    'rubro',
                    'proveedor',
                    'empleado',
                    'edificio',
                    'departamento',
                    'direccion',
                    'ubr',
                    'eade'
                ])->find($activoId);

                if (!$activo && $totalActivos > 0) {
                    $activo = Activo::with([
                        'clasificacion',
                        'estadoBien',
                        'rubro',
                        'proveedor',
                        'empleado',
                        'edificio',
                        'departamento',
                        'direccion',
                        'ubr',
                        'eade'
                    ])->first();
                }
            }

            $activoAnterior = null;
            $activoSiguiente = null;
            $primerActivo = null;
            $ultimoActivo = null;

            if ($activo) {
                $activoAnterior = Activo::where('folio', '<', $activo->folio)
                    ->orderBy('folio', 'desc')
                    ->first();

                $activoSiguiente = Activo::where('folio', '>', $activo->folio)
                    ->orderBy('folio', 'asc')
                    ->first();

                $primerActivo = Activo::orderBy('folio')->first();
                $ultimoActivo = Activo::orderBy('folio', 'desc')->first();
            }

            $estadisticas = [
                'total' => $totalActivos,
                'activos' => Activo::where('status', true)->count(),
                'inactivos' => Activo::where('status', false)->count(),
                'asignados' => Activo::whereNotNull('fecha_asignacion')->count(),
                'en_almacen' => Activo::whereNull('salida_almacen')->count(),
                'donaciones' => Activo::where('es_donacion', true)->count(),
            ];

            return view('activos.index', compact(
                'activo',
                'totalActivos',
                'activoAnterior',
                'activoSiguiente',
                'estadisticas',
                'primerActivo',
                'ultimoActivo',
                'parametrosFirmas',
                'valorUma',
                'viewMode'
            ))->with('searchTerm', $searchTerm);
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Error al cargar los activos: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $activo = Activo::with([
                'clasificacion',
                'estadoBien',
                'rubro',
                'proveedor',
                'empleado',
                'edificio',
                'departamento',
                'direccion',
                'ubr',
                'eade'
            ])->findOrFail($id);

            $activoAnterior = Activo::where('folio', '<', $id)
                ->orderBy('folio', 'desc')
                ->first();

            $activoSiguiente = Activo::where('folio', '>', $id)
                ->orderBy('folio', 'asc')
                ->first();

            $primerActivo = Activo::orderBy('folio')->first();
            $ultimoActivo = Activo::orderBy('folio', 'desc')->first();

            return view('activos.show', compact(
                'activo',
                'activoAnterior',
                'activoSiguiente',
                'primerActivo',
                'ultimoActivo'
            ));
        } catch (\Exception $e) {
            return redirect()->route('activos.index')
                ->with('error', 'Activo no encontrado');
        }
    }

    public function create($tipo = null)
    {
        try {
            if (!$tipo || !in_array($tipo, ['BM', 'BV', 'BVA'])) {
                return redirect()->route('activos.index')
                    ->with('error', 'Debe seleccionar un tipo de activo.');
            }

            if ($tipo === 'BM') {
                $maxNumero = Activo::where('numero_inventario', 'like', 'BM%')
                    ->whereRaw('CAST(SUBSTRING(numero_inventario, 3) AS UNSIGNED) < 900000')
                    ->get()
                    ->map(function ($activo) {
                        return (int)substr($activo->numero_inventario, 2);
                    })
                    ->max();

                $baseManual = 13365;
                $siguiente = max($maxNumero ?? 0, $baseManual) + 1;
            } else {
                $maxNumero = Activo::where('numero_inventario', 'like', $tipo . '%')
                    ->get()
                    ->map(function ($activo) use ($tipo) {
                        $parteNumerica = substr($activo->numero_inventario, strlen($tipo));
                        return (int)$parteNumerica;
                    })
                    ->max();

                $siguiente = ($maxNumero ?? 0) + 1;
            }

            $siguienteNumeroInventario = $tipo . str_pad($siguiente, 6, '0', STR_PAD_LEFT);

            $valorUma = Parametro::where('id', 4)->value('valor_uma');
            $clasificaciones = CatalogoClasificacion::orderBy('descripcion')->get();
            $estadosBien = CatalogoEstadoBien::orderBy('descripcion')->get();
            $rubros = CatalogoRubro::orderBy('descripcion')->get();
            $subrubros = CatalogoSubrubro::with('rubro')->orderBy('descripcion')->get();
            $proveedores = CatalogoProveedor::orderBy('nomcorto')->get();
            $empleados = CatalogoEmpleado::orderBy('nombre')->get();
            $edificios = CatalogoEdificio::orderBy('descripcion')->get();
            $departamentos = CatalogoDepartamento::orderBy('descripcion')->get();
            $direcciones = CatalogoDirecciones::orderBy('descripcion')->get();
            $ubrs = CatalogoUbr::orderBy('descripcion')->get();
            $eades = CatalogoEade::orderBy('descripcion')->get();

            return view('activos.create', compact(
                'clasificaciones',
                'estadosBien',
                'rubros',
                'subrubros',
                'proveedores',
                'empleados',
                'edificios',
                'departamentos',
                'direcciones',
                'ubrs',
                'eades',
                'tipo',
                'siguienteNumeroInventario',
                'valorUma'
            ));
        } catch (\Exception $e) {
            return redirect()->route('activos.index')
                ->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'tipo_activo' => 'required|in:BM,BV,BVA',
                'descripcion_corta' => 'required|string|max:255',
                'descripcion_larga' => 'nullable|string',
                'clasificacion_id' => 'nullable|exists:catalogo_clasificacion,id',
                'estado_bien_id'   => 'required|exists:catalogo_estado_bien,id',
                'rubro_id'         => 'required|exists:catalogo_rubro,id',
                'subrubro_id'      => 'nullable|exists:catalogo_subrubro,id',
                'marca' => 'nullable|string|max:100',
                'modelo' => 'nullable|string|max:100',
                'numero_serie' => 'nullable|string|max:100',
                'fecha_adquisicion' => 'nullable|date',
                'fecha_registro' => 'nullable|date',
                'proveedor_id'     => 'nullable|exists:catalogo_proveedor,id',
                'costo' => 'nullable|numeric|min:0',
                'numero_factura' => 'nullable|string|max:50',
                'numero_pedido' => 'nullable|string|max:50',
                'entrada_almacen' => 'nullable|date',
                'folio_entrada' => 'nullable|string|max:255',
                'folio_salida' => 'nullable|string|max:255',
                'salida_almacen' => 'nullable|date',
                'observaciones' => 'nullable|string',
                'es_donacion' => 'boolean',
                'donante' => 'nullable|string|max:255',
                'empleado_id'      => 'nullable|exists:catalogo_empleado,id',
                'fecha_asignacion' => 'nullable|date',
                'edificio_id'      => 'nullable|exists:catalogo_edificio,id',
                'departamento_id' => 'nullable|exists:catalogo_departamento,id',
                'direccion_id' => 'nullable|exists:catalogo_direcciones,id',
                'ubr_id' => 'nullable|exists:catalogo_ubr,id',
                'eade_id' => 'nullable|exists:catalogo_eade,id',
            ]);

            $valorUma = Parametro::where('id', 4)->value('valor_uma');
            $prefijo = $request->tipo_activo;

            if ($prefijo === 'BM') {
                $maxNumero = Activo::where('numero_inventario', 'like', 'BM%')
                    ->whereRaw('CAST(SUBSTRING(numero_inventario, 3) AS UNSIGNED) < 900000')
                    ->lockForUpdate()
                    ->get()
                    ->map(function ($activo) {
                        return (int)substr($activo->numero_inventario, 2);
                    })
                    ->max();

                $baseManual = 13365;
                $siguiente = max($maxNumero ?? 0, $baseManual) + 1;
            } else {
                $maxNumero = Activo::where('numero_inventario', 'like', $prefijo . '%')
                    ->lockForUpdate()
                    ->get()
                    ->map(function ($activo) use ($prefijo) {
                        $parteNumerica = substr($activo->numero_inventario, strlen($prefijo));
                        return (int)$parteNumerica;
                    })
                    ->max();

                $siguiente = ($maxNumero ?? 0) + 1;
            }

            $numeroInventario = $prefijo . str_pad($siguiente, 6, '0', STR_PAD_LEFT);

            $data = $request->except('tipo_activo');
            $data['numero_inventario'] = $numeroInventario;
            $data['status'] = 1;
            $data['base_costo'] = $valorUma;

            $activo = Activo::create($data);

            DB::commit();

            return redirect()->route('activos.index', ['id' => $activo->folio])
                ->with('success', 'Activo creado con número: ' . $numeroInventario);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error al crear el activo: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function search(Request $request)
    {
        try {
            $search = $request->get('search');

            if (empty($search)) {
                return redirect()->route('activos.index');
            }

            $activos = Activo::where('numero_inventario', 'LIKE', "%{$search}%")
                ->orWhere('descripcion_corta', 'LIKE', "%{$search}%")
                ->orWhere('descripcion_larga', 'LIKE', "%{$search}%")
                ->orWhere('numero_serie', 'LIKE', "%{$search}%")
                ->orWhere('marca', 'LIKE', "%{$search}%")
                ->orWhere('modelo', 'LIKE', "%{$search}%")
                ->orderBy('folio', 'asc')
                ->limit(50)
                ->get();

            return view('activos.search', compact('activos', 'search'));
        } catch (\Exception $e) {
            return redirect()->route('activos.index')
                ->with('error', 'Error en la búsqueda');
        }
    }

    public function getSubrubrosPorRubro($rubroId)
    {
        try {
            $subrubros = CatalogoSubrubro::where('id_rubro', $rubroId)
                ->where('status', 1)
                ->orderBy('descripcion')
                ->get(['id', 'descripcion']);

            return response()->json($subrubros);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar subrubros'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $activo = Activo::with([
                'clasificacion',
                'estadoBien',
                'rubro',
                'subrubro',
                'proveedor',
                'empleado',
                'edificio',
                'departamento',
                'direccion',
                'ubr',
                'eade'
            ])->findOrFail($id);

            $valorUma = Parametro::where('id', 4)->value('valor_uma');

            $clasificaciones = CatalogoClasificacion::orderBy('descripcion')->get();
            $estadosBien = CatalogoEstadoBien::orderBy('descripcion')->get();
            $rubros = CatalogoRubro::orderBy('descripcion')->get();

            $subrubros = CatalogoSubrubro::where('id_rubro', $activo->rubro_id)
                ->where('status', 1)
                ->orderBy('descripcion')
                ->get();

            $proveedores = CatalogoProveedor::orderBy('nomcorto')->get();
            $empleados = CatalogoEmpleado::orderBy('nombre')->get();
            $edificios = CatalogoEdificio::orderBy('descripcion')->get();
            $departamentos = CatalogoDepartamento::orderBy('descripcion')->get();
            $direcciones = CatalogoDirecciones::orderBy('descripcion')->get();
            $ubrs = CatalogoUbr::orderBy('descripcion')->get();
            $eades = CatalogoEade::orderBy('descripcion')->get();

            return view('activos.edit', compact(
                'activo',
                'clasificaciones',
                'estadosBien',
                'rubros',
                'subrubros',
                'proveedores',
                'empleados',
                'edificios',
                'departamentos',
                'direcciones',
                'ubrs',
                'eades',
                'valorUma'
            ));
        } catch (\Exception $e) {
            return redirect()->route('activos.index')
                ->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $activo = Activo::findOrFail($id);

            $validated = $request->validate([
                'numero_inventario' => 'required|unique:activos,numero_inventario,' . $id . ',folio',
                'descripcion_corta' => 'required|string|max:255',
                'descripcion_larga' => 'nullable|string',
                'clasificacion_id' => 'required_if:rubro_id,5|nullable|exists:catalogo_clasificacion,id',
                'estado_bien_id'   => 'required|exists:catalogo_estado_bien,id',
                'rubro_id'         => 'required|exists:catalogo_rubro,id',
                'subrubro_id'      => 'nullable|exists:catalogo_subrubro,id',
                'marca' => 'nullable|string|max:100',
                'modelo' => 'nullable|string|max:100',
                'numero_serie' => 'nullable|string|max:100',
                'fecha_adquisicion' => 'nullable|date',
                'fecha_registro' => 'nullable|date',
                'proveedor_id'     => 'nullable|exists:catalogo_proveedor,id',
                'costo' => 'nullable|numeric|min:0',
                'numero_factura' => 'nullable|string|max:50',
                'numero_pedido' => 'nullable|string|max:50',
                'entrada_almacen' => 'nullable|date',
                'folio_entrada' => 'nullable|string|max:255',
                'folio_salida' => 'nullable|string|max:255',
                'salida_almacen' => 'nullable|date',
                'observaciones' => 'nullable|string',
                'es_donacion' => 'boolean',
                'donante' => 'nullable|string|max:255',
                'empleado_id'      => 'nullable|exists:catalogo_empleado,id',
                'fecha_asignacion' => 'nullable|date',
                'edificio_id'      => 'nullable|exists:catalogo_edificio,id',
                'departamento_id' => 'nullable|exists:catalogo_departamento,id',
                'direccion_id' => 'nullable|exists:catalogo_direcciones,id',
                'ubr_id' => 'nullable|exists:catalogo_ubr,id',
                'eade_id' => 'nullable|exists:catalogo_eade,id',
                'status' => 'boolean',
            ]);

            $activo->update($validated);

            return redirect()->route('activos.index', ['id' => $activo->folio])
                ->with('success', 'Activo actualizado exitosamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el activo: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $activo = Activo::findOrFail($id);
            $activo->delete();

            return redirect()->route('activos.index')
                ->with('success', 'Activo eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('activos.index')
                ->with('error', 'Error al eliminar el activo: ' . $e->getMessage());
        }
    }

    public function resguardo(Request $request, $folio)
    {
        $request->validate([
            'autorizo' => 'required|string|max:255',
            'visto_bueno_id' => 'required|exists:parametros,id'
        ]);

        $activo = Activo::with([
            'proveedor',
            'empleado',
            'departamento',
            'edificio',
            'estadoBien'
        ])->findOrFail($folio);

        $vistoBueno = Parametro::findOrFail($request->visto_bueno_id);

        $data = [
            'activo' => $activo,
            'autorizo' => $request->autorizo,
            'visto_bueno_nombre' => $vistoBueno->nombre_completo
        ];

        $pdf = Pdf::loadView('activos.print.resguardo', $data)
            ->setPaper('letter', 'portrait');

        return $pdf->stream('resguardo_' . $activo->numero_inventario . '.pdf');
    }

    public function mostrarModalResguardo($folio)
    {
        $activo = Activo::findOrFail($folio);
        $parametrosFirmas = Parametro::all();

        return view('activos.modales.resguardo-modal', compact('activo', 'parametrosFirmas'));
    }

    public function printFrm23($folio)
    {
        $activo = Activo::with([
            'proveedor',
            'empleado',
            'departamento',
            'edificio'
        ])->findOrFail($folio);
        $elaboro = Parametro::find(2);
        $vobo    = Parametro::find(3);
        $pdf = Pdf::loadView('activos.print.frm23', compact(
            'activo',
            'elaboro',
            'vobo'
        ))->setPaper('letter', 'portrait');
        return $pdf->stream('FRM23_' . $activo->numero_inventario . '.pdf');
    }

    public function bajasIndex(Request $request)
    {
        $activo = null;

        if ($request->filled('search')) {
            $activo = Activo::where('numero_inventario', $request->search)->first();
        }
        $elaboro = Parametro::find(1);
        $vobo    = Parametro::find(3);

        return view('activos.activo-bajas', compact('activo', 'elaboro', 'vobo'));
    }

    public function darDeBaja(Request $request)
    {
        $request->validate([
            'numero_inventario' => 'required|exists:activos,numero_inventario',
            'fecha_baja' => 'required|date',
            'motivo_baja' => 'required|string|max:255',
            'recibido_por' => 'required|string|max:255',
        ]);

        $activo = Activo::where('numero_inventario', $request->numero_inventario)->firstOrFail();

        if ($activo->fecha_baja) {
            return back()->with('error', 'Este activo ya está dado de baja.');
        }

        $activo->update([
            'fecha_baja' => $request->fecha_baja,
            'motivo_baja' => $request->motivo_baja,
            'estado_bien_id' => 2
        ]);

        return response()->json([
            'success' => true,
            'pdf_url' => route('activos.print.formato_baja', [
                'folio' => $activo->folio,
                'recibido_por' => strtoupper($request->recibido_por)
            ])
        ]);
    }

    public function printFormatoBaja(Request $request, $folio)
    {
        $activo = Activo::with([
            'proveedor',
            'empleado',
            'departamento',
            'edificio',
            'estadoBien'
        ])->findOrFail($folio);

        if (!$activo->fecha_baja) {
            return redirect()->back()->with('error', 'Este activo no está dado de baja.');
        }

        $elaboro = Parametro::find(1);
        $vobo    = Parametro::find(3);

        $recibidoPor = $request->recibido_por ?? 'Nombre';

        $pdf = Pdf::loadView('activos.print.formato_baja', compact(
            'activo',
            'elaboro',
            'vobo',
            'recibidoPor'
        ))->setPaper('letter', 'portrait');

        return $pdf->stream('formato_bajaAF-' . $activo->numero_inventario . '.pdf');
    }

    public function traspasosIndex(Request $request)
    {
        $activo = null;

        if ($request->filled('search')) {
            $activo = Activo::with(['empleado', 'departamento', 'edificio'])
                ->where('numero_inventario', $request->search)
                ->first();
        }

        $empleados = \App\Models\CatalogoEmpleado::orderBy('nombre')->get();
        $departamentos = \App\Models\CatalogoDepartamento::orderBy('descripcion')->get();
        $edificios = \App\Models\CatalogoEdificio::orderBy('descripcion')->get();

        return view('activos.activo-traspasos', compact(
            'activo',
            'empleados',
            'departamentos',
            'edificios'
        ));
    }

    public function darTraspaso(Request $request)
    {
        $request->validate([
            'numero_inventario' => 'required|exists:activos,numero_inventario',
            'empleado_id' => 'required|exists:catalogo_empleado,id',
            'departamento_id' => 'required|exists:catalogo_departamento,id',
            'edificio_id' => 'required|exists:catalogo_edificio,id',
            'fecha_traspaso' => 'required|date',
            'motivo_traspaso' => 'required|string|max:600',
        ]);

        DB::beginTransaction();

        try {
            $activo = Activo::where('numero_inventario', $request->numero_inventario)->firstOrFail();

            if ($activo->fecha_baja) {
                throw new \Exception('No se puede traspasar un activo dado de baja.');
            }

            if ($activo->empleado_id && $activo->empleado_id == $request->empleado_id) {
                throw new \Exception('El activo ya está asignado a este empleado.');
            }

            $empleadoAnteriorId = $activo->empleado_id;
            $departamentoAnteriorId = $activo->departamento_id;
            $edificioAnteriorId = $activo->edificio_id;

            \App\Models\HistorialTraspaso::create([
                'activo_id' => $activo->folio,
                'empleado_origen_id' => $empleadoAnteriorId,
                'empleado_destino_id' => $request->empleado_id,
                'departamento_origen_id' => $departamentoAnteriorId,
                'departamento_id' => $request->departamento_id,
                'edificio_id' => $request->edificio_id,
                'fecha_traspaso' => $request->fecha_traspaso,
                'motivo_traspaso' => $request->motivo_traspaso,
            ]);

            $activo->update([
                'empleado_anterior_id' => $empleadoAnteriorId,
                'empleado_id' => $request->empleado_id,
                'departamento_id' => $request->departamento_id,
                'edificio_id' => $request->edificio_id,
                'fecha_traspaso' => $request->fecha_traspaso,
                'motivo_traspaso' => $request->motivo_traspaso,
                'fecha_asignacion' => is_null($empleadoAnteriorId) ? now() : $activo->fecha_asignacion,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Traspaso realizado correctamente',
                'pdf_url' => route('activos.print.formato_traspaso', ['folio' => $activo->folio])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function printFormatoTraspaso(Request $request, $folio)
    {
        $activo = Activo::with([
            'proveedor',
            'empleado',
            'departamento',
            'edificio',
            'estadoBien',
            'traspasos.empleadoOrigen',
            'traspasos.departamentoOrigen'
        ])->findOrFail($folio);

        if (!$activo->fecha_traspaso) {
            return redirect()->back()->with('error', 'Este activo no tiene registro de traspaso.');
        }

        $ultimoTraspaso = $activo->traspasos->last();

        $empleadoOrigen = $ultimoTraspaso?->empleadoOrigen;
        $departamentoOrigen = $ultimoTraspaso?->departamentoOrigen;

        $empleadoDestino = $activo->empleado;
        $departamentoDestino = $activo->departamento;
        $edificioDestino = $activo->edificio;

        $elaboro = Parametro::find(1);
        $vobo    = Parametro::find(3);
        $autorizo = Parametro::find(2);

        $pdf = Pdf::loadView('activos.print.formato_traspaso', compact(
            'activo',
            'elaboro',
            'vobo',
            'autorizo',
            'empleadoOrigen',
            'empleadoDestino',
            'departamentoOrigen',
            'departamentoDestino',
            'edificioDestino'
        ))->setPaper('letter', 'portrait');

        return $pdf->stream('formato_traspaso-' . $activo->numero_inventario . '.pdf');
    }

    public function traspasosMultiplesIndex()
    {
        $empleados = CatalogoEmpleado::with(['departamento', 'edificio'])
            ->withCount(['activos' => function ($query) {
                $query->whereNull('fecha_baja')->where('status', 1);
            }])
            ->orderBy('nombre')
            ->get();

        $departamentos = CatalogoDepartamento::withCount(['activos' => function ($query) {
            $query->whereNull('fecha_baja')->where('status', 1);
        }])
            ->orderBy('descripcion')
            ->get();

        $edificios = CatalogoEdificio::orderBy('descripcion')->get();

        return view('activos.activo-traspasos-multiples', compact(
            'empleados',
            'departamentos',
            'edificios'
        ));
    }

    public function getActivosPorOrigen(Request $request)
    {
        $tipo = $request->get('tipo');
        $id = $request->get('id');

        if ($tipo === 'empleado') {
            $activos = Activo::with(['empleado', 'departamento', 'edificio'])
                ->where('empleado_id', $id)
                ->whereNull('fecha_baja')
                ->where('status', true)
                ->get();
        } else {
            $activos = Activo::with(['empleado', 'departamento', 'edificio'])
                ->where('departamento_id', $id)
                ->whereNull('fecha_baja')
                ->where('status', true)
                ->get();
        }

        return response()->json($activos->map(function ($activo) {
            return [
                'folio' => $activo->folio,
                'numero_inventario' => $activo->numero_inventario,
                'descripcion_corta' => $activo->descripcion_corta,
                'empleado_nombre' => $activo->empleado?->nombre,
                'empleado_old' => $activo->empleado_old,
                'departamento_descripcion' => $activo->departamento?->descripcion,
                'edificio_descripcion' => $activo->edificio?->descripcion,
                'status' => $activo->status,
            ];
        }));
    }


    public function traspasosMultiplesStore(Request $request)
    {
        $request->validate([
            'activos_ids' => 'required|string',
            'origen_tipo' => 'required|in:empleado,departamento',
            'origen_id' => 'required|integer',
            'destino_tipo' => 'required|in:empleado,departamento',
            'destino_id' => 'required|integer',
            'fecha_traspaso' => 'required|date',
            'motivo_traspaso' => 'required|string|max:600',
        ]);

        $destinoId = $request->destino_id;

        if ($request->destino_tipo === 'empleado') {
            $empleadoDestino = CatalogoEmpleado::with('edificio')->findOrFail($destinoId);
            $departamentoId = $empleadoDestino->id_depto;
            $empleadoId = $destinoId;
            $edificioId = $empleadoDestino->id_edif;
        } else {
            $departamentoDestino = CatalogoDepartamento::with('edificio')->findOrFail($destinoId);
            $departamentoId = $destinoId;
            $empleadoId = null;
            $edificioId = $departamentoDestino->id_edif;
        }

        $activosIds = explode(',', $request->activos_ids);
        $activosIds = array_unique(array_filter($activosIds));

        if (empty($activosIds)) {
            return response()->json(['success' => false, 'message' => 'No hay activos seleccionados'], 400);
        }

        DB::beginTransaction();

        $procesados = 0;
        $fallidos = 0;
        $errores = [];

        try {
            foreach ($activosIds as $folio) {
                try {
                    $activo = Activo::findOrFail($folio);

                    if ($activo->fecha_baja) {
                        throw new \Exception("{$activo->numero_inventario}: Está dado de baja");
                    }

                    if ($request->origen_tipo === 'empleado' && $activo->empleado_id != $request->origen_id) {
                        throw new \Exception("{$activo->numero_inventario}: No pertenece al empleado origen");
                    }
                    if ($request->origen_tipo === 'departamento' && $activo->departamento_id != $request->origen_id) {
                        throw new \Exception("{$activo->numero_inventario}: No pertenece al departamento origen");
                    }

                    HistorialTraspaso::create([
                        'activo_id' => $activo->folio,
                        'empleado_origen_id' => $activo->empleado_id,
                        'empleado_destino_id' => $request->destino_tipo === 'empleado'
                            ? $destinoId
                            : $activo->empleado_id,
                        'departamento_origen_id' => $activo->departamento_id,
                        'departamento_id' => $departamentoId,
                        'edificio_id' => $edificioId,
                        'fecha_traspaso' => $request->fecha_traspaso,
                        'motivo_traspaso' => $request->motivo_traspaso,
                    ]);

                    $activo->update([
                        'empleado_anterior_id' => $activo->empleado_id,
                        'empleado_id' => $request->destino_tipo === 'empleado'
                            ? $destinoId
                            : $activo->empleado_id,
                        'departamento_id' => $departamentoId,
                        'edificio_id' => $edificioId,
                        'fecha_traspaso' => $request->fecha_traspaso,
                        'motivo_traspaso' => $request->motivo_traspaso,
                        'fecha_asignacion' => $request->fecha_traspaso,
                    ]);

                    $procesados++;
                } catch (\Exception $e) {
                    $fallidos++;
                    $errores[] = $e->getMessage();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'procesados' => $procesados,
                'fallidos' => $fallidos,
                'errores' => $errores,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getEmpleadoInfo($id)
    {
        $empleado = CatalogoEmpleado::with(['departamento', 'edificio'])
            ->withCount('activos')
            ->findOrFail($id);

        return response()->json([
            'departamento' => $empleado->departamento->descripcion ?? 'No asignado',
            'edificio' => $empleado->edificio->descripcion ?? 'Sin edificio',
            'activos_count' => $empleado->activos_count
        ]);
    }
}
