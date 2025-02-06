<?php

namespace App\Models\Reportes\ReporteGPSEstado;

use App\Models\Reportes\ReporteGPSEstado\Vendedor;
use App\Models\Reportes\ReporteGPSEstado\CoordenadasVendedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

class ReporteGps extends Model
{
      // Este modelo no está vinculado a una tabla
      protected $table = 'vendedor';
      public $timestamps = false;

      // Método para obtener los datos combinados
      public static function obtenerDatosReporteGpsEstado()
      {
          return Vendedor::with(['Vent_Coordenadas'])
              ->get()
              ->map(function ($vendedor) {
                  return [
                      'codvendedor' => $vendedor->codvendedor,
                      'nombre' => $vendedor->nombre,
                      'mac' =>$vendedor -> Vent_coordenadas ->last()->mac ?? null,
                      'fecha' => $vendedor->Vent_Coordenadas->last()->fecha ?? null,
                      'latitud'=> $vendedor->Vent_Coordenadas->last()->latitud ?? null,
                      'longitud'=> $vendedor->Vent_Coordenadas->last()->longitud ?? null,
                      'bateria' => $vendedor->Vent_Coordenadas->last()->bateria ?? null,
                      'version' => $vendedor->Vent_Coordenadas->last()->version ?? null,
                  ];
              });
      }

      public static function obtenerDatosReporteGpsEstadoFiltro($codsupervisor, $codvendedor, $fecha_inicio, $fecha_fin)
{
    return self::with(['supervisor', 'coordenadas' => function ($query) use ($fecha_inicio, $fecha_fin) {
        $query->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
              ->orderBy('fecha', 'asc');
    }])
    ->when($codsupervisor, function ($query, $codsupervisor) {
        return $query->where('codsupervisor', $codsupervisor);
    })
    ->when($codvendedor, function ($query, $codvendedor) {
        return $query->where('codvendedor', $codvendedor);
    })
    ->get()
    ->map(function ($vendedor) {
        return [
            'codsupervisor' => $vendedor->supervisor->codsupervisor ?? null,
            'codvendedor' => $vendedor->codvendedor,
            'nombre' => $vendedor->nombre,
            'coordenadas' => $vendedor->coordenadas->map(function ($coordenada) {
                return [
                    'mac' => $coordenada->mac,
                    'fecha' => $coordenada->fecha,
                    'latitud' => $coordenada->latitud,
                    'longitud' => $coordenada->longitud,
                    'bateria' => $coordenada->bateria,
                    'version' => $coordenada->version,
                ];
            })
        ];
    });
}

      public static function obtenerDatosReporteGpsEstadoFiltro2($codsupervisor, $codvendedor, $fecha_inicio, $fecha_fin)
      {
          return self::with(['supervisor', 'coordenadas' => function ($query) use ($fecha_inicio, $fecha_fin) {
              $query->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->orderBy('fecha', 'desc');
          }])
          ->when($codsupervisor, function ($query, $codsupervisor) {
              return $query->where('codsupervisor', $codsupervisor);
          })
          ->when($codvendedor, function ($query, $codvendedor) {
              return $query->where('codvendedor', $codvendedor);
          })
          ->get()
          ->map(function ($vendedor) {
              return [
                  'codsupervisor' => $vendedor->supervisor->codsupervisor ?? null,
                  'codvendedor' => $vendedor->codvendedor,
                  'nombre' => $vendedor->nombre,

                  'fecha' => $vendedor->coordenadas->fecha ?? null,
                  'latitud' => $vendedor->coordenadas->latitud ?? null,
                  'longitud' => $vendedor->coordenadas->longitud ?? null,
                  'bateria' => $vendedor->coordenadas->bateria ?? null,
                  'version' => $vendedor->coordenadas->version ?? null,
              ];
          });
      }








      public function supervisor()
    {
    return $this->belongsTo(Supervisor::class, 'codsupervisor','codsupervisor');
    }
    public function coordenadas()
    {
    return $this->hasMany(CoordenadasVendedor::class, 'codvendedor','codvendedor');
    }



}
