<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'empleado_id',
        'monto',
        'cuotas',
        'estado',
        'generacion_fecha',
    ];

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'prestamo_id');
    }

    public function liquidacionEmpleadoDetalle()
    {
        return $this->hasOne(LiquidacionEmpleadoDetalle::class, 'movimiento_id');
    }
}
