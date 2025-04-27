<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiquidacionCabecera extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'liquidaciones_cabecera';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'aprobacion_usuario_id',
        'generacion_fecha',
        'estado', // pendiente, rechazado
        'aprobacion_fecha',
        'periodo',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'generacion_fecha' => 'datetime',
        'aprobacion_fecha' => 'datetime',
        'periodo' => 'date',
    ];

    public $timestamps = false;

    /**
     * Get the user who approved the liquidation.
     */
    public function aprobacionUsuario()
    {
        return $this->belongsTo(User::class, 'aprobacion_usuario_id');
    }
}