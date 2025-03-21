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
        Permission::create(['name' => 'usuario crear']);
        Permission::create(['name' => 'usuario editar']); // Permiso para editar todos los datos del usuario
        Permission::create(['name' => 'usuario editar clave']); // Un empleado puede cambiar su propia contraseña
        Permission::create(['name' => 'usuario editar estado']);
        Permission::create(['name' => 'usuario editar datos']); // Datos que no son de ingreso a la cuenta
        Permission::create(['name' => 'usuario editar departamento']);
        Permission::create(['name' => 'usuario eliminar']);
        Permission::create(['name' => 'usuario ver']);
        Permission::create(['name' => 'usuario asignar rol']);


        // PERMISOS ROL
        Permission::create(['name' => 'rol crear']); // Crear rol implica asignarle el permiso
        Permission::create(['name' => 'rol editar']);
        Permission::create(['name' => 'rol eliminar']);
        Permission::create(['name' => 'rol ver']);


        // PERMISOS LIQUIDACION
        Permission::create(['name' => 'liquidacion crear']);
        Permission::create(['name' => 'liquidacion editar']);
        Permission::create(['name' => 'liquidacion eliminar']);
        Permission::create(['name' => 'liquidacion ver']);
        Permission::create(['name' => 'liquidacion liquidar']); //Liquidar incluye rechazar la liquidacion



        // PERMISOS EMPLEADO
        Permission::create(['name' => 'empleado crear']);
        Permission::create(['name' => 'empleado editar']);
        Permission::create(['name' => 'empleado eliminar']);
        Permission::create(['name' => 'empleado ver']);

        // PERMISOS MOVIMIENTO
        Permission::create(['name' => 'movimiento crear']);
        Permission::create(['name' => 'movimiento editar']);
        Permission::create(['name' => 'movimiento eliminar']);
        Permission::create(['name' => 'movimiento ver']);

        // PERMISOS CARGO
        Permission::create(['name' => 'cargo crear']);
        Permission::create(['name' => 'cargo editar']);
        Permission::create(['name' => 'cargo eliminar']);
        Permission::create(['name' => 'cargo ver']);

        // PERMISOS DEPARTAMENTO
        Permission::create(['name' => 'departamento crear']);
        Permission::create(['name' => 'departamento editar']);
        Permission::create(['name' => 'departamento eliminar']);
        Permission::create(['name' => 'departamento ver']);

        // PERMISOS PAGO
        Permission::create(['name' => 'pago crear']);
        Permission::create(['name' => 'pago editar']);
        Permission::create(['name' => 'pago eliminar']);
        Permission::create(['name' => 'pago ver']);

        // PERMISOS SALARIO
        Permission::create(['name' => 'salario crear']);
        Permission::create(['name' => 'salario editar']);
        Permission::create(['name' => 'salario eliminar']);
        Permission::create(['name' => 'salario ver']);

        // PERMISOS CONCEPTOS
        Permission::create(['name' => 'concepto crear']);
        Permission::create(['name' => 'concepto editar']);
        Permission::create(['name' => 'concepto eliminar']);
        Permission::create(['name' => 'concepto ver']);
    }
}
