<?php

namespace Database\Seeders;

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

        $admin = User::create([
            'nombre' => 'Administrador',
            'email' => 'admin@example.com',
            'cedula' => '1234567',
            'sexo' => 'M',
            'ingreso_fecha' => date_create(Carbon::now()),
            'nacimiento_fecha' => date_create('1990-01-01'),
            'password' => Hash::make('12345'),
            'estado' => 'contratado',
            'remember_token' => Str::random(10),
            'domicilio' => 'Asuncion, Paraguay'
        ]);

        $role = Role::where('name', 'admin')->first();


        if($role == null){


            $role = Role::create(['name'=> 'admin']);

        }


        $role->syncPermissions([
            'usuario crear',
            'usuario editar',
            'usuario eliminar',
            'usuario ver',
            'usuario asignar rol',
            'rol crear',
            'rol editar',
            'rol eliminar',
            'rol ver'
        ]);

        $admin->assignRole('admin');


    }
}
