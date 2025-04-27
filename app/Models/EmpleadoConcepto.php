<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoConcepto extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'empleado_conceptos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'empleado_id',
        'concepto_id',
        'valor',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'valor' => 'decimal:2',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'estado' => 'boolean',
    ];

    /**
     * Get the employee (user) associated with this concept.
     */
    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    /**
     * Get the concept associated with this employee concept.
     */
    public function concepto()
    {
        return $this->belongsTo(Concepto::class, 'concepto_id');
    }
}