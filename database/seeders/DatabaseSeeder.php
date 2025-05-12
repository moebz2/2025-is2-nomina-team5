<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Concepto;
use App\Models\Departamento;
use App\Models\Parametro;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Los permisos se crean en PermissionSeeder.
        // Ejecutar ese archivo primero.

        $permisosAAsignar = [
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
            'liquidacion crear',
            'liquidacion editar',
            'liquidacion eliminar',
            'liquidacion ver',
        ];

        // 2. Crear roles y asignar permisos

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(array_merge($permisosAAsignar, [
            'concepto crear',
            'concepto editar',
            'concepto eliminar',
            'concepto ver',
        ]));

        $asistRole = Role::firstOrCreate(['name' => 'asistenteRRHH']);
        $asistRole->syncPermissions($permisosAAsignar);

        // 3. Crear usuario administrador

        $admin = User::firstOrCreate(
            ['email' => 'admin@nomina.com'],
            [
                'nombre' => 'Administrador',
                'email' => 'admin@nomina.com',
                'cedula' => '1234567',
                'sexo' => 'M',
                'nacimiento_fecha' => date_create('1990-01-01'),
                'password' => Hash::make('12345'),
                'estado' => 'contratado',
                'remember_token' => Str::random(10),
                'domicilio' => 'Asuncion, Paraguay',
            ]
        );

        $admin->assignRole('admin');

        // 4. Crear datos de referencia

        Departamento::firstOrCreate(
            ['nombre' => 'Gerencia'],
            ['descripcion' => 'Departamento de gerencia de la empresa']
        );

        Cargo::firstOrCreate(
            ['nombre' => 'Gerente'],
            ['departamento_id' => 1, 'descripcion' => 'Gerencia de la empresa']
        );

        Parametro::firstOrCreate(
            ['nombre' => Parametro::SALARIO_MINIMO],
            ['valor' => 2798309]
        );
    }
}
