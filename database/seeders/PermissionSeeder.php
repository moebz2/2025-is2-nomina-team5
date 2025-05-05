<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // PERMISOS USUARIO
        Permission::firstOrCreate(['name' => 'usuario crear']);
        Permission::firstOrCreate(['name' => 'usuario editar']); // Permiso para editar todos los datos del usuario
        Permission::firstOrCreate(['name' => 'usuario editar clave']); // Un empleado puede cambiar su propia contraseña
        Permission::firstOrCreate(['name' => 'usuario editar estado']);
        Permission::firstOrCreate(['name' => 'usuario editar datos']); // Datos que no son de ingreso a la cuenta
        Permission::firstOrCreate(['name' => 'usuario editar departamento']);
        Permission::firstOrCreate(['name' => 'usuario eliminar']);
        Permission::firstOrCreate(['name' => 'usuario ver']);
        Permission::firstOrCreate(['name' => 'usuario asignar rol']);


        // PERMISOS ROL
        Permission::firstOrCreate(['name' => 'rol crear']); // Crear rol implica asignarle el permiso
        Permission::firstOrCreate(['name' => 'rol editar']);
        Permission::firstOrCreate(['name' => 'rol eliminar']);
        Permission::firstOrCreate(['name' => 'rol ver']);


        // PERMISOS LIQUIDACION
        Permission::firstOrCreate(['name' => 'liquidacion crear']);
        Permission::firstOrCreate(['name' => 'liquidacion editar']);
        Permission::firstOrCreate(['name' => 'liquidacion eliminar']);
        Permission::firstOrCreate(['name' => 'liquidacion ver']);
        Permission::firstOrCreate(['name' => 'liquidacion liquidar']); //Liquidar incluye rechazar la liquidacion



        // PERMISOS EMPLEADO
        Permission::firstOrCreate(['name' => 'empleado crear']);
        Permission::firstOrCreate(['name' => 'empleado editar']);
        Permission::firstOrCreate(['name' => 'empleado eliminar']);
        Permission::firstOrCreate(['name' => 'empleado ver']);

        // PERMISOS MOVIMIENTO
        Permission::firstOrCreate(['name' => 'movimiento crear']);
        Permission::firstOrCreate(['name' => 'movimiento editar']);
        Permission::firstOrCreate(['name' => 'movimiento eliminar']);
        Permission::firstOrCreate(['name' => 'movimiento ver']);

        // PERMISOS CARGO
        Permission::firstOrCreate(['name' => 'cargo crear']);
        Permission::firstOrCreate(['name' => 'cargo editar']);
        Permission::firstOrCreate(['name' => 'cargo eliminar']);
        Permission::firstOrCreate(['name' => 'cargo ver']);

        // PERMISOS DEPARTAMENTO
        Permission::firstOrCreate(['name' => 'departamento crear']);
        Permission::firstOrCreate(['name' => 'departamento editar']);
        Permission::firstOrCreate(['name' => 'departamento eliminar']);
        Permission::firstOrCreate(['name' => 'departamento ver']);

        // PERMISOS PAGO
        Permission::firstOrCreate(['name' => 'pago crear']);
        Permission::firstOrCreate(['name' => 'pago editar']);
        Permission::firstOrCreate(['name' => 'pago eliminar']);
        Permission::firstOrCreate(['name' => 'pago ver']);

        // PERMISOS SALARIO
        Permission::firstOrCreate(['name' => 'salario crear']);
        Permission::firstOrCreate(['name' => 'salario editar']);
        Permission::firstOrCreate(['name' => 'salario eliminar']);
        Permission::firstOrCreate(['name' => 'salario ver']);

        // PERMISOS CONCEPTOS
        Permission::firstOrCreate(['name' => 'concepto crear']);
        Permission::firstOrCreate(['name' => 'concepto editar']);
        Permission::firstOrCreate(['name' => 'concepto eliminar']);
        Permission::firstOrCreate(['name' => 'concepto ver']);

        // Hijos
        Permission::firstOrCreate(['name' => 'hijos crear']);
        Permission::firstOrCreate(['name' => 'hijos editar']);
        Permission::firstOrCreate(['name' => 'hijos eliminar']);
        Permission::firstOrCreate(['name' => 'hijos ver']);

        // Parametros
        Permission::firstOrCreate(['name' => 'parametros crear']);
        Permission::firstOrCreate(['name' => 'parametros editar']);
        Permission::firstOrCreate(['name' => 'parametros eliminar']);
        Permission::firstOrCreate(['name' => 'parametros ver']);


    }
}
