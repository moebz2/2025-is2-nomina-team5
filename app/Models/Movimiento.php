<?php

namespace App\Models;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movimientos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'empleado_id',
        'concepto_id',
        'monto',
        'validez_fecha',
        'generacion_fecha',
        'eliminacion_fecha',
        'prestamo_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'validez_fecha' => 'datetime:Y-m-d H:i:s',
        'generacion_fecha' => 'datetime:Y-m-d H:i:s',
        'eliminacion_fecha' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get the employee (user) associated with this movement.
     */
    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    /**
     * Get the concept associated with this movement.
     */
    public function concepto()
    {
        return $this->belongsTo(Concepto::class, 'concepto_id');
    }

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_id');
    }

    public function liquidacionEmpleadoDetalle()
    {
        return $this->hasOne(LiquidacionEmpleadoDetalle::class, 'movimiento_id');
    }
}
