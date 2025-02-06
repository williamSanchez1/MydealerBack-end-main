<?php

namespace App\Models\Reportes\ReporteGPSEstado;

use App\Models\Reportes\ReporteGPSEstado\Vendedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoordenadasVendedor extends Model
{
    use HasFactory;

    protected $table = 'coordenadasvendedor'; // Nombre de la tabla
    public $timestamps = false; // Si no usas created_at y updated_at
    protected $fillable = [
     'codvendedor',
     'mac',
     'latitud',
     'longitud',
     'fecha',
     'bateria',
     'version'];

    // Relación con el modelo Vendedor

    public function Vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'codvendedor', 'codvendedor');
    }
}


