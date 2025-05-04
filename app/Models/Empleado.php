<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    const ESTADO_CONTRATADO = 'CONTRATADO';
    const ESTADO_DESPEDIDO = 'DESPEDIDO';
    const ESTADO_INACTIVO = 'INACTIVO';


    protected $table = 'empleados';

    public $timestamps = false;

    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_ingreso' => 'date',
            'fecha_egreso' => 'date',
        ];
    }


    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
    public function hijos() 
    {
        return $this->hasMany(Hijo::class);
    }

}
