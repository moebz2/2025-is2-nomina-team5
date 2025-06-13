<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cargo extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'departamento_id',
        'nombre',
        'descripcion',
        'estado',
    ];

    public $timestamps = false;


     public function usuarios()
    {
        return $this->belongsToMany(User::class, 'cargos_empleado', 'cargo_id', 'empleado_id')
                    ->withPivot('fecha_inicio', 'fecha_fin', 'es_principal'); // Incluir los campos de la tabla pivot

    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
}
