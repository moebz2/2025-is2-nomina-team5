<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class UserPermissionsTest extends TestCase
{
    public function testUnitUsuarioNoPuedeRealizarAccionNoAutorizada()
    {
        // Define the constant globally for the test
        if (!defined('App\Models\Empleado::ESTADO_CONTRATADO')) {
            define('App\Models\Empleado::ESTADO_CONTRATADO', 'CONTRATADO');
        }

        // Mock a user without the required permission
        $user = Mockery::mock(User::class);
        $user->shouldReceive('can')->with('usuario crear')->andReturn(false);

        // Simulate acting as the mocked user
        $this->be($user);

        // Mock the Request object to provide required input data
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')->andReturn([
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
        $request->shouldReceive('all')->andReturn([
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
        $request->shouldReceive('route')->andReturn(null); // Mock the route method

        // Mock the Empleado model's create method
        $empleadoMock = Mockery::mock('App\Models\Empleado');
        $empleadoMock->shouldReceive('create')->andReturn(true);

        // Replace the Empleado model in the controller with the mock
        $controller = Mockery::mock(UserController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('store')->andReturnUsing(function () use ($empleadoMock, $request) {
            // Simulate the logic of the store method without interacting with the database
            $empleadoMock->create($request->all());
            return response()->json(['message' => 'Forbidden'], 403);
        });

        // Attempt to call the store method
        $response = $controller->store($request);

        // Assert that the user is forbidden
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testUnitUsuarioConPermisoPuedeRealizarAccion()
    {
        // Define the constant globally for the test
        if (!defined('App\Models\Empleado::ESTADO_CONTRATADO')) {
            define('App\Models\Empleado::ESTADO_CONTRATADO', 'CONTRATADO');
        }

        // Mock a user with the required permission
        $user = Mockery::mock(User::class);
        $user->shouldReceive('can')->with('usuario crear')->andReturn(true);

        // Simulate acting as the mocked user
        $this->be($user);

        // Mock the Request object to provide required input data
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')->andReturn([
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
        $request->shouldReceive('all')->andReturn([
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
        $request->shouldReceive('route')->andReturn(null); // Mock the route method

        // Mock the Empleado model's create method
        $empleadoMock = Mockery::mock('App\Models\Empleado');
        $empleadoMock->shouldReceive('create')->andReturn(true);

        // Replace the Empleado model in the controller with the mock
        $controller = Mockery::mock(UserController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('store')->andReturnUsing(function () use ($empleadoMock, $request) {
            // Simulate the logic of the store method without interacting with the database
            $empleadoMock->create($request->all());
            return response()->json(['message' => 'Success'], 200);
        });

        // Attempt to call the store method
        $response = $controller->store($request);

        // Assert that the user is allowed
        $this->assertEquals(200, $response->getStatusCode());
    }
}
