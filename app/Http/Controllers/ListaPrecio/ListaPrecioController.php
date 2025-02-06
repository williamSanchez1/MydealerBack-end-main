<?php

namespace App\Http\Controllers\ListaPrecio;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\ListaPrecio\ListaPrecio;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ListePrecioController extends Controller {
    use HttpResponses;
  
    /**
     *
     * @OA\Get(
     * path="/api/cliente",
     * tags={"Web - Vista Lista Precios"},
     * summary="Buscar info del Lista Precios",
     * description="Devuelve una lista con los datos de Lista Precios",
     * @OA\Parameter(
     *      description="Necesita el código de lista precios",
     *      in="query",
     *      name="codlista precio",
     *      required=false,
     * ),
     * @OA\Parameter(
     *      description="Necesita nombre de lista precio",
     *      in="query",
     *      name="nombre",
     *      required=false,
     * ),
     * @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     * @OA\Response(
     *     response=500,
     *     description="Database error"
     * ),
     * )
     */
    public function index(Request $resquest) {
      /*try {
        $limit = 3000;
        $nombre = $resquest->nombre;
        $codlistaprecio = $resquest->codlistaprecio;
  
        if (!$nombre) $nombre = '';
  
        if (!$codlistaprecio) $codcliente = '';
  
        $nombre = strtoupper($nombre);
        $codlistaprecio = strtoupper($codlistaprecio);
  
        $listaprecio = ListaPrecio::where('nombre', 'like', "%$nombre%")
          ->where('codlistaprecio', 'like', "%$codlistaprecio%")
          ->limit($limit)
          ->get();
  
        return $this->success($listaprecio, 'Lista Precios obtenidos correctamente.', 200);
      } catch (\Exception $e) {
        return $this->error('Error al obtener la lista precios.', $e->getMessage(), 500);
      }*/

      $listaprecio = ListaPrecio::all();
        return response()->json($listaprecio);
    }
  
  }
  