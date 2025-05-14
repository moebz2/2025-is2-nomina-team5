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
        'estado',
        'generacion_fecha',
    ];

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }
}
