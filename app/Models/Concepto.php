<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{

    const TIPO_SALARIO = 'salario';
    const TIPO_BONIFICACION = 'bonificacion';
    const TIPO_IPS = 'ips';
    const TIPO_GENERAL = 'general';
    const TIPO_PRESTAMO = 'prestamo';

    // TODO: Configurable en tabla parámetro
    const IPS_PORCENTAJE = 0.09;

    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'conceptos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'ips_incluye',
        'aguinaldo_incluye',
        'tipo_concepto',
        'es_debito',
        'estado',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ips_incluye' => 'boolean',
        'estado' => 'boolean',
        'aguinaldo_incluye' => 'boolean',
        'es_debito' => 'boolean',
    ];
}
