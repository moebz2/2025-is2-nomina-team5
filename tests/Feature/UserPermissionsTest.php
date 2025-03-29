<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class UserPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function testIntegUsuarioNoPuedeRealizarAccionNoAutorizada()
    {
        // Create a role without the required permission
        $role = Role::create(['name' => 'test-role']);
        Permission::create(['name' => 'usuario ver']);
        $role->givePermissionTo('usuario ver');

        // Create a user with specified parameters and assign the role
        $user = User::create([
            'nombre' => 'Test User', // Explicitly set 'nombre'
            'cedula' => '12345678',
            'sexo' => 'M',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // Ensure the password is hashed
            'nacimiento_fecha' => '2000-01-01',
            'domicilio' => 'Test Address',
        ]);
        $user->assignRole($role);

        // Act as the user and attempt to access a restricted route
        $response = $this->actingAs($user)->post(route('users.store'), [
            'nombre' => 'Test User',
            'cedula' => '12345678',
            'sexo' => 'M',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'nacimiento_fecha' => '2000-01-01',
            'ingreso_fecha' => '2023-01-01',
            'departamento_id' => 1,
        ]);

        // Assert that the user is forbidden from performing the action
        $response->assertForbidden();
    }

    public function testIntegUsuarioConPermisoPuedeRealizarAccion()
    {
        // Create a role with the required permission
        $role = Role::create(['name' => 'admin-role']);
        Permission::create(['name' => 'usuario crear']);
        $role->givePermissionTo('usuario crear');

        // Create a user with specified parameters and assign the role
        $user = User::create([
            'nombre' => 'Admin User', // Explicitly set 'nombre'
            'cedula' => '87654321',
            'sexo' => 'F',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Ensure the password is hashed
            'nacimiento_fecha' => '1990-01-01',
            'domicilio' => 'Admin Address',
        ]);
        $user->assignRole($role);

        // Act as the user and attempt to access the route to create a new user
        $response = $this->actingAs($user)->post(route('users.store'), [
            'nombre' => 'New User',
            'cedula' => '12345678',
            'sexo' => 'M',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'nacimiento_fecha' => '2000-01-01',
            'ingreso_fecha' => '2023-01-01',
            'departamento_id' => 1,
        ]);

        // Assert that the user is allowed to perform the action
        $response->assertRedirect();
    }
}
