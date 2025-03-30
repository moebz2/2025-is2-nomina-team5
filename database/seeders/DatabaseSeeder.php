<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Departamento;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::firstOrCreate(
            ['email' => 'admin@nomina.com'],
            [
                'nombre' => 'Administrador',
                'email' => 'admin@nomina.com',
                'cedula' => '1234567',
                'sexo' => 'M',
                'nacimiento_fecha' => date_create('1990-01-01'),
                // 'fecha_ingreso' => date_create('2020-01-01'),
                'password' => Hash::make('12345'),
                'estado' => 'contratado',
                'remember_token' => Str::random(10),
                'domicilio' => 'Asuncion, Paraguay'
            ]
        );

        $role = Role::firstOrCreate(['name' => 'admin']);

        $role->syncPermissions([
            'usuario crear',
            'usuario editar',
            'usuario eliminar',
            'usuario ver',
            'usuario asignar rol',
            'rol crear',
            'rol editar',
            'rol eliminar',
            'rol ver',
            'departamento crear',
            'departamento editar',
            'departamento eliminar',
            'departamento ver',
        ]);

        $admin->assignRole('admin');

        $asistRole = Role::firstOrCreate(['name' => 'asistenteRRHH']);

        $asistRole->syncPermissions([
            'usuario crear',
            'usuario editar',
            'usuario eliminar',
            'usuario ver',
            'usuario asignar rol',
            'departamento crear',
            'departamento editar',
            'departamento eliminar',
            'departamento ver',
        ]);

        Departamento::firstOrCreate(['nombre'=>'Gerencia'],['nombre' => 'Gerencia', 'Departamento de gerencia de la empresa']);

        Cargo::firstOrCreate(['nombre' => 'Gerente'],['nombre' => 'Gerente', 'departamento_id' => 1, 'descripcion' => 'Gerencia de la empresa']);






    }
}
