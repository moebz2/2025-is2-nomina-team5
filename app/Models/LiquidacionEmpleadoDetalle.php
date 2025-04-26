<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiquidacionEmpleadoDetalle extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'liquidacion_empleado_detalles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cabecera_id',
        'movimiento_id',
    ];

    /**
     * Get the employee liquidation header associated with this detail.
     */
    public function cabecera()
    {
        return $this->belongsTo(LiquidacionEmpleadoCabecera::class, 'cabecera_id');
    }

    /**
     * Get the movement associated with this detail.
     */
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id');
    }
}