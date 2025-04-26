<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

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
        'validez_inicio',
        'validez_fin',
        'generacion_fecha',
        'eliminacion_fecha',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'validez_inicio' => 'datetime',
        'validez_fin' => 'datetime',
        'generacion_fecha' => 'datetime',
        'eliminacion_fecha' => 'datetime',
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
}