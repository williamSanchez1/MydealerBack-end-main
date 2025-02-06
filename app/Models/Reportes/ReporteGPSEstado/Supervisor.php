<?php

namespace App\Models\Reportes\ReporteGPSEstado;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;

    protected $table = 'supervisor';
    protected $primaryKey = 'codsupervisor';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'codsupervisor',
        'nombre',
        'email',
        'login',
        'password',
        'srperfil',
        'foto',
        'coddivision',
        'notificacion',
        'verkilos',
        'codjeferegional',
        'codsucursal',
        'latitud',
        'longitud',
        'codcanal',
    ];

    public function supervisor_Vendedor()
    {
        return $this->hasMany(Vendedor::class, 'codsupervisor', 'codsupervisor');
    }
}
