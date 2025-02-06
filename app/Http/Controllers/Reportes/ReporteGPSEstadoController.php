<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use App\Http\Resources\Reportes\ReporteGPSEstadoResource;
use App\Models\Reportes\ReporteGPSEstado\ReporteGPS;
use App\Models\Reportes\ReporteGPSEstado\Vendedor;
use App\Models\Reportes\ReporteGPSEstado\Supervisor;
use App\Http\Requests\Reportes\ReporteGPSEstadoRequest;
use Illuminate\Http\Request;

class ReporteGPSEstadoController extends Controller {
    use HttpResponses;

    /**
     * @OA\Get(
     * path="/api/reporte/gps/estado",
     * tags={"Web - Reporte GPS Estado"},
     * summary="Buscar el reporte de GPS",
     * description="Devuelve una lista con los reportes de GPS aplicando filtros y paginación.",
     * @OA\Parameter(
     *      name="codsupervisor",
     *      in="query",
     *      description="Código del supervisor",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="codvendedor",
     *      in="query",
     *      description="Código del vendedor",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="fecha_inicio",
     *      in="query",
     *      description="Fecha de inicio",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          format="date"
     *      )
     * ),
     * @OA\Parameter(
     *      name="fecha_fin",
     *      in="query",
     *      description="Fecha de fin",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *          format="date"
     *      )
     * ),
     * @OA\Parameter(
     *      name="page",
     *      in="query",
     *      description="Número de página para la paginación",
     *      required=false,
     *      @OA\Schema(
     *          type="integer",
     *          default=1
     *      )
     * ),
     * @OA\Response(
     *      response=200,
     *      description="successful operation"
     * ),
     * @OA\Response(
     *      response=500,
     *      description="Database error"
     * )
     * )
     */

    public function index(ReporteGPSEstadoRequest $request) {
        try {
            $query = ReporteGps::query();

            if ($request->has('codsupervisor') && $request->codsupervisor !== 'Todos') {
                $query->where('codsupervisor', $request->codsupervisor);
            }

            if ($request->has('codvendedor') && $request->codvendedor !== 'Todos') {
                $query->where('codvendedor', $request->codvendedor);
            }

            if ($request->has('fecha_inicio')) {
                $query->whereDate('fechamovil', '>=', $request->fecha_inicio);
            }

            if ($request->has('fecha_fin')) {
                $query->whereDate('fechamovil', '<=', $request->fecha_fin);
            }

            $page = $request->query('page', 1);
            $perPage = 20;

            $reportes = $query->paginate($perPage, ['*'], 'page', $page);

            return ReporteGPSEstadoResource::collection($reportes);
        } catch (\Exception $e) {
            return $this->error('Error al obtener los reportes de GPS.', $e->getMessage(), 500);
        }
    }
    public function store(ReporteGPSEstadoRequest $request) {
        try {
            $reporte = new ReporteGps();
            $reporte->fill($request->all());
            $reporte->save();

            return $this->success('Reporte de GPS creado correctamente.', new ReporteGPSEstadoResource($reporte), 201);
        } catch (\Exception $e) {
            return $this->error('Error al crear el reporte de GPS.', $e->getMessage(), 500);
        }
    }
    public function update(ReporteGPSEstadoRequest $request, $id) {
        try {
            $reporte = ReporteGps::find($id);

            if (!$reporte) {
                return $this->error('Reporte de GPS no encontrado.', 'El reporte de GPS con el id ' . $id . ' no existe.', 404);
            }

            $reporte->fill($request->all());
            $reporte->save();

            return $this->success('Reporte de GPS actualizado correctamente.', new ReporteGPSEstadoResource($reporte));
        } catch (\Exception $e) {
            return $this->error('Error al actualizar el reporte de GPS.', $e->getMessage(), 500);
        }
    }
    public function mostrarDatos()
    {
        // Llama al método del modelo personalizado
        $datos = ReporteGPS::obtenerDatosReporteGpsEstado();

        // Retorna los datos a una vista
        return response()->json($datos);
        //return view('storage.framework.views.ReGpsEstado', compact('datos'));
    }


    public function mostrarDatosVFinal(Request $request)
    {
        // Validar los parámetros de entrada
        $request->validate([
            'codsupervisor' => 'nullable|string',
            'codvendedor' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Obtener los parámetros del request
        $codsupervisor = $request->input('codsupervisor');
        $codvendedor = $request->input('codvendedor');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        // Llama al método del modelo con los parámetros
        $datos = ReporteGPS::obtenerDatosReporteGpsEstadoFiltro($codsupervisor, $codvendedor, $fecha_inicio, $fecha_fin);

        // Retorna los datos en formato JSON
        return response()->json($datos);

        // Si prefieres retornar una vista con los datos:
        // return view('storage.framework.views.ReGpsEstado', compact('datos'));
    }

    public function obtenerSupervisores()
    {
    $supervisores = Supervisor::select('codsupervisor', 'nombre')->get();
    return response()->json($supervisores);
    }

    public function obtenerVendedoresPorSupervisor($codsupervisor)
    {
        $vendedores = Vendedor::where('codsupervisor', $codsupervisor)->get();

        if ($vendedores->isEmpty()) {
            return response()->json(['message' => 'No se encontraron vendedores para este supervisor.'], 404);
        }

        return response()->json($vendedores);
    }
}


