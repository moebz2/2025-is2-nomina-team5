<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Hijo extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'nombre',
        'fecha_nacimiento',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function esMenorDe18()
    {
        return Carbon::parse($this->fecha_nacimiento)->diffInYears(now()) < 18;
    }
}
