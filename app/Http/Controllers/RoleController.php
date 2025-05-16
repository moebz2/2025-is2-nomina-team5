<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:rol ver')->only('index');
        $this->middleware('can:rol crear')->only('create', 'store');
        $this->middleware('can:rol editar')->only('edit', 'update');
        $this->middleware('can:rol eliminar')->only('destroy');
    }

    public function index()
    {

        $roles = Role::with('permissions')->get();

        $view = view('roles.roles-index', compact('roles'));

        return view('configuracion.index2', ['content' => $view]);
    }

    public function create(Request $request)
    {
        $availableActions = ['ver', 'crear', 'editar', 'eliminar'];

        $permissions = Permission::all()->pluck('name');
        $groupedPermissions = [];

        // $userPermissions = $request->user()->getAllpermissions()->pluck('name');



        foreach ($permissions as $permission) {
            $parts = explode(' ', $permission);
            if (count($parts) === 2) {
                $module = $parts[0];
                $action = $parts[1];

                if (!isset($groupedPermissions[$module])) {
                    $groupedPermissions[$module] = [];
                }

                $groupedPermissions[$module][] = $action;
            }
        }

        $view = view('roles.create', compact('groupedPermissions', 'availableActions',));
        return view('configuracion.index2', ['content' => $view]);
    }

    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required|unique:roles',
            'permissions' => 'required|array'
        ]);

        try {

            DB::transaction(function () use ($request) {

                $role = Role::create(
                    ['name' => $request->input('name'),]
                );
                $role->syncPermissions($request->input('permissions'));
            });

            return redirect()->route('roles.index')->with('sucess', 'Rol creado con exito');
        } catch (Exception $e) {

            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function edit(Request $request, Role $role)
    {
        $availableActions = ['ver', 'crear', 'editar', 'eliminar'];

        $permissions = Permission::all()->pluck('name');
        $groupedPermissions = [];

        // $userPermissions = $request->user()->getAllpermissions()->pluck('name');

        $rolePermissions = $role->permissions->pluck('name');

        $userGroupedPermissions = [];


        foreach ($permissions as $permission) {
            $parts = explode(' ', $permission);
            if (count($parts) === 2) {
                $module = $parts[0];
                $action = $parts[1];

                if (!isset($groupedPermissions[$module])) {
                    $groupedPermissions[$module] = [];
                }

                $groupedPermissions[$module][] = $action;
            }
        }

        foreach ($rolePermissions as $permission) {
            $parts = explode(' ', $permission);
            if (count($parts) === 2) {
                $module = $parts[0];
                $action = $parts[1];

                if (!isset($userGroupedPermissions[$module])) {
                    $userGroupedPermissions[$module] = [];
                }

                $userGroupedPermissions[$module][] = $action;
            }
        }

        $view = view('roles.edit', compact('role', 'groupedPermissions', 'availableActions', 'userGroupedPermissions'));
        return view('configuracion.index2', ['content' => $view]);

    }

    public function update(Request $request, $id)
    {


        // dd($request->input('permissions'));

        $request->validate([
            'permissions' => 'required|array'
        ]);

        try {




            $role = Role::findOrFail($id);

            $role->syncPermissions($request->input('permissions'));


            return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente');
        } catch (Exception $e) {

            DB::rollBack();


            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
