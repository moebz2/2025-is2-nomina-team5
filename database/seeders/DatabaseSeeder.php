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
        // 1. Crear todos los permisos primero
        $permisos = [
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
            'concepto crear',
            'concepto editar',
            'concepto eliminar',
            'concepto ver',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web',
            ]);
        }

        // 2. Crear roles y asignar permisos
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($permisos);

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
                'aplica_bonificacion_familiar' => false,
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
