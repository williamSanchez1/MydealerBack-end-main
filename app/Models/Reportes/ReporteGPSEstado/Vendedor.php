<?php

namespace App\Models\Reportes\ReporteGPSEstado;

use App\Models\Reportes\ReporteGPSEstado\CoordenadasVendedor;
use App\Models\Reportes\ReporteGPSEstado\Ruta;
use App\Models\Clientes\Cliente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    use HasFactory;

    protected $table = 'vendedor';
    protected $primaryKey = 'codvendedor';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'codvendedor',
        'nombre',
        'email',
        'login',
        'password',
        'estado',
        'mac_pend_asignacion',
        'Fecha_requerimiento',
        'Estado_Autorizacion',
        'Fecha_Autorizacion',
        'codruta',
        'codsupervisor',
    ];

    public function rutasGestion()
    {
        return $this->hasMany(ReporteGps::class, 'codvendedor', 'codvendedor');
    }

    // Relación con el modelo CoordenadasVendedor
    public function Vent_Coordenadas()
    {
        return $this->hasMany(CoordenadasVendedor::class, 'codvendedor', 'codvendedor');
    }

    // Relación con el modelo Rutas
    public function Ven_Rutas()
    {
        return $this->hasMany(Ruta::class, 'codvendedor', 'codvendedor');
    }
    public function Ven_Supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'codsupervisor', 'codsupervisor');
    }

  // Relación con el modelo Cliente
    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'codvendedor', 'codvendedor');
    }


    public function getClientesAsignados()
    {
        return $this->clientes()
            ->select('codcliente', 'nombrecomercial', 'provincia', 'ciudad')
            ->get();
    }
}
