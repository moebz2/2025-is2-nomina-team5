<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiquidacionEmpleadoCabecera extends Model
{
    use HasFactory;

    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_VERIFICADO = 'aprobado';
    const ESTADO_RECHAZADO = 'rechazado';

    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'liquidaciones_empleado_cabecera';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'empleado_id',
        'liquidacion_cabecera_id',
        'estado',
        'periodo',
        'verificacion_fecha',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'periodo' => 'datetime:Y-m-d H:i:s',
        'verificacion_fecha' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get the employee (user) associated with this liquidation.
     */
    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    /**
     * Get the liquidation header associated with this employee liquidation.
     */
    public function liquidacionCabecera()
    {
        return $this->belongsTo(LiquidacionCabecera::class, 'liquidacion_cabecera_id');
    }
}
