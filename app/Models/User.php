<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'nacimiento_fecha' => 'date',
        ];
    }

    public function cargos()
    {
        return $this->belongsToMany(Cargo::class, 'cargos_empleado', 'empleado_id', 'cargo_id')
            ->withPivot('fecha_inicio', 'fecha_fin')
            ->wherePivot('fecha_fin', null); // Only active cargos
    }

    public function addCargoActualAttribute()
    {
        if ($this->cargos) {
            return $this->cargos()->where('es_actual', true)->first();
        }


        return null;
    }

    /**
     * Assign a cargo to the user.
     *
     * @param int $cargoId
     * @return void
     */
    public function asignarCargo(int $cargoId, $fecha_inicio): void
    {

        // TODO: poner fecha de baja al cargo anterior

        $this->cargos()->attach($cargoId, ['fecha_inicio' => $fecha_inicio]);
    }

    /**
     * Remove a cargo from the user.
     *
     * @param int $cargoId
     * @return void
     */
    public function removerCargo(int $cargoId): void
    {
        $this->cargos()->detach($cargoId);
    }

    /**
     * Sync cargos for the user.
     *
     * @param array $cargoIds
     * @return void
     */
    public function sincronizarCargos(array $cargoIds): void
    {
        $this->cargos()->sync($cargoIds);
    }


    /**
     * Check if the user has a specific cargo.
     *
     * @param int $cargoId
     * @return bool
     */
    public function tieneCargo(int $cargoId): bool
    {
        return $this->cargos()->where('cargo_id', $cargoId)->exists();
    }

    public function currentCargo()
    {
        return $this->cargos()->first(); // Get the first active cargo
    }
    public function hijos()
    {
        return $this->hasMany(Hijo::class, 'empleado_id');
    }
    

}
