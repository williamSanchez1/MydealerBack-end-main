<?php

namespace App\Models\ListaPrecio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ListaPrecioDetalle extends Model
{
    protected $table = 'listapreciosdet';
    protected $primaryKey = 'codproducto';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'codproducto',
        'codlistaprecio',
        'precio',
    ];

    public function direccionListaPrecio()
    {
        return $this->hasMany(Producto::class, 'codlistaprecio', 'codlistaprecio');
    }

}