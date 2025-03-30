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

    protected $attributes = [
        'cargo_actual'
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

    public function cargos() : BelongsToMany
    {
        return $this->belongsToMany(Cargo::class, 'cargos_empleado', 'empleado_id', 'cargo_id');
    }

    public function addCargoActualAttribute(){
        if($this->cargos){
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

}
