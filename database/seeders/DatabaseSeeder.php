<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345')
        ]);

        $role = Role::create(['name'=> 'admin']);

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
