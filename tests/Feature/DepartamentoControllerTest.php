<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Departamento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DepartamentoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create(); // Create a test user
        $role = Role::create(['name' => 'test-role']);
        Permission::create(['name' => 'departamento ver']);
        Permission::create(['name' => 'departamento crear']);
        Permission::create(['name' => 'departamento editar']);
        Permission::create(['name' => 'departamento eliminar']);
        $role->givePermissionTo('departamento ver');
        $role->givePermissionTo('departamento crear');
        $role->givePermissionTo('departamento editar');
        $role->givePermissionTo('departamento eliminar');
        $user->assignRole($role);
        $this->actingAs($user); // Simulate authentication
    }

    public function testAlmacenaUnDepartamento()
    {
        $this->authenticate();

        $response = $this->post('/admin/departamentos', [
            'nombre' => 'Departamento Test',
            'descripcion' => 'Descripcion de prueba',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('departamentos.index'));
        $this->assertDatabaseHas('departamentos', [
            'nombre' => 'Departamento Test',
            'descripcion' => 'Descripcion de prueba',
        ]);
    }

    public function testAlmacenaUnDepartamentoConErroresDeValidacion()
    {
        $this->authenticate();

        $response = $this->post('/admin/departamentos', [
            'nombre' => '', // Nombre vacío
            'descripcion' => 'Descripcion de prueba',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nombre']);
        $this->assertDatabaseMissing('departamentos', [
            'descripcion' => 'Descripcion de prueba',
        ]);
    }

    public function testActualizaUnDepartamento()
    {
        $this->authenticate();

        $departamento = Departamento::factory()->create();

        $response = $this->put("/admin/departamentos/{$departamento->id}", [
            'nombre' => 'Departamento Actualizado',
            'descripcion' => 'Descripcion actualizada',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('departamentos.index'));
        $this->assertDatabaseHas('departamentos', [
            'id' => $departamento->id,
            'nombre' => 'Departamento Actualizado',
            'descripcion' => 'Descripcion actualizada',
        ]);
    }

    public function testActualizaUnDepartamentoInexistente()
    {
        $this->authenticate();

        $response = $this->put('/admin/departamentos/999', [
            'nombre' => 'Departamento Actualizado',
            'descripcion' => 'Descripcion actualizada',
        ]);

        $response->assertStatus(404);
    }

    public function testMarcaDepartamentoComoInactivo()
    {
        $this->authenticate();

        $departamento = Departamento::factory()->create(['estado' => true]);

        $response = $this->delete("/admin/departamentos/{$departamento->id}");

        $response->assertStatus(302);
        $response->assertRedirect(route('departamentos.index'));
        $this->assertDatabaseHas('departamentos', [
            'id' => $departamento->id,
            'estado' => false,
        ]);
    }

    public function testMarcaDepartamentoComoInactivoInexistente()
    {
        $this->authenticate();

        $response = $this->delete('/admin/departamentos/999');

        $response->assertStatus(404);
    }
}
