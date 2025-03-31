<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Departamento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsuarioControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function autenticar()
    {
        // Crear un usuario con permisos de administrador
        $usuario = User::factory()->create();
        $rol = Role::create(['name' => 'admin']);
        Permission::create(['name' => 'usuario ver']);
        Permission::create(['name' => 'usuario crear']);
        Permission::create(['name' => 'usuario editar']);
        Permission::create(['name' => 'usuario eliminar']);
        $rol->givePermissionTo(['usuario ver', 'usuario crear', 'usuario editar', 'usuario eliminar']);
        $usuario->assignRole($rol);
        $this->actingAs($usuario); // Simular autenticación
    }

    public function testListaUsuarios()
    {
        $this->autenticar();

        User::factory()->count(5)->create();

        $response = $this->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('users.index');
        $response->assertViewHas('users');
    }

    public function testCreaUnUsuario()
    {
        $this->autenticar();

        // Crear departamento y usar su id

        $departamento = Departamento::factory()->create(['nombre' => 'Desarrollo']);

        $cargo = Cargo::factory()->create(['nombre' => 'Desarrollador', 'departamento_id' => $departamento->id]);

        $rol = Role::create(['name' => 'empleado']);

        $response = $this->post(route('users.store'), [
            'nombre' => 'Juan Pérez',
            'cedula' => '12345678',
            'sexo' => 'M',
            'email' => 'juan.perez@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nacimiento_fecha' => '1990-01-01',
            'ingreso_fecha' => '2025-01-01',
            'cargo_id' => $cargo->id,
            'domicilio' => 'Calle Falsa 123',
            'role' => $rol->name,
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'nombre' => 'Juan Pérez',
            'cedula' => '12345678',
            'email' => 'juan.perez@example.com',
        ]);
    }


    public function testNoCreaUsuarioConCedulaInvalida()
    {
        $this->autenticar();

        $departamento = Departamento::factory()->create(['nombre' => 'Desarrollo']);
        $cargo = Cargo::factory()->create(['nombre' => 'Desarrollador', 'departamento_id' => $departamento->id]);
        $rol = Role::create(['name' => 'empleado']);

        $response = $this->post(route('users.store'), [
            'nombre' => 'Juan Pérez',
            'cedula' => 'ABC123', // Cedula con letras
            'sexo' => 'M',
            'email' => 'juan.perez@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nacimiento_fecha' => '1990-01-01',
            'ingreso_fecha' => '2025-01-01',
            'cargo_id' => $cargo->id,
            'domicilio' => 'Calle Falsa 123',
            'role' => $rol->name,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['cedula']);
        $this->assertDatabaseMissing('users', [
            'email' => 'juan.perez@example.com',
        ]);
    }


    public function testActualizaUnUsuario()
    {
        $this->autenticar();

        $usuario = User::factory()->create();

        // Crear departamento y usar su id

        $departamento = Departamento::factory()->create(['nombre' => 'Desarrollo']);

        $cargo = Cargo::factory()->create(['nombre' => 'Desarrollador', 'departamento_id' => $departamento->id]);

        $response = $this->put(route('users.update', $usuario->id), [
            'nombre' => 'María López',
            'cedula' => $usuario->cedula,
            'sexo' => 'F',
            'email' => $usuario->email,
            'password' => '',
            'nacimiento_fecha' => '1991-01-01',
            'ingreso_fecha' => '2025-02-01',
            'cargo_id' => $cargo->id, // Usar el ID del cargo creado
            'domicilio' => 'Avenida Siempre Viva 456',
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $usuario->id,
            'nombre' => 'María López',
            'sexo' => 'F',
            'domicilio' => 'Avenida Siempre Viva 456',
        ]);
    }


    public function testNoActualizaUsuarioConCedulaInvalida()
    {
        $this->autenticar();

        $usuario = User::factory()->create();
        $departamento = Departamento::factory()->create(['nombre' => 'Desarrollo']);
        $cargo = Cargo::factory()->create(['nombre' => 'Desarrollador', 'departamento_id' => $departamento->id]);

        $response = $this->put(route('users.update', $usuario->id), [
            'nombre' => 'María López',
            'cedula' => '123ABC', // Cedula con letras
            'sexo' => 'F',
            'email' => $usuario->email,
            'password' => '',
            'nacimiento_fecha' => '1991-01-01',
            'ingreso_fecha' => '2025-02-01',
            'cargo_id' => $cargo->id,
            'domicilio' => 'Avenida Siempre Viva 456',
            'role' => 'admin',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['cedula']);
        $this->assertDatabaseHas('users', [
            'id' => $usuario->id,
            'cedula' => $usuario->cedula, // Cedula original no debe cambiar
        ]);
    }

    public function testEliminaUnUsuario()
    {
        $this->autenticar();

        $usuario = User::factory()->create();

        $response = $this->delete(route('users.destroy', $usuario->id));

        $response->assertRedirect(route('users.index'));
    }

    public function testNoEliminaUsuarioInexistente()
    {
        $this->autenticar();

        // Attempt to delete a user with a non-existent ID
        $response = $this->delete(route('users.destroy', 9999)); // ID 9999 does not exist

        $response->assertStatus(404); // Ensure a 404 response is returned
    }
}
