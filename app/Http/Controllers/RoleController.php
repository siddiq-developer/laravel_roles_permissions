<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{

     public static function middleware(): array{
        return[
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:destroy roles', only: ['destroy']),  
        ];
    }

public function index()
{
    $roles = Role::with('permissions')->orderBy('name', 'ASC')->paginate(10);
    // $permissions = Permission::orderBy('name', 'ASC')->get();

    return view('roles.list', [
        'roles' => $roles,
        // 'permissions' => $permissions
    ]);
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = permission::orderBy('name', 'ASC')->get();

        return view('roles.create',[
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
//     public function store(Request $request)
//     {
        
//     $validator = Validator::make($request->all(),[
//     'name' => 'required|unique:roles,name|min:3'
// ]);

//         if($validator->passes()){
        
//         Role::create(['name' => $request->name]);
//         return redirect()->route('roles.index')->with('success', 'Permission added successfully');

//         }else{
//             return redirect()->route('roles.create')->withInput()->withInput()->withErrors($validator);
//         }
//     }

// public function store(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'name' => 'required|unique:roles,name|min:3',
//         'permissions' => 'array' // optional validation
//     ]);

//     if ($validator->passes()) {
//         $role = Role::create(['name' => $request->name]);

//         // Attach permissions if provided
//         if ($request->has('permissions')) {
//             $role->syncPermissions($request->permissions);
//         }

//         return redirect()->route('roles.index')->with('success', 'Role and permissions added successfully');
//     } else {
//         return redirect()->route('roles.create')->withInput()->withErrors($validator);
//     }
// }
public function store(Request $request)
{
    // Debug the input
    \Log::debug('Role creation input:', $request->all());
    
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:roles,name|min:3',
        'permissions' => 'nullable|array',
        'permissions.*' => 'exists:permissions,id'
    ]);

    if ($validator->passes()) {
        $role = Role::create(['name' => $request->name]);

        // Debug before syncing
        \Log::debug('Permissions to sync:', $request->permissions ?? []);
        
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        // Debug after creation
        \Log::debug('Created role with permissions:', [
            'role' => $role->toArray(),
            'permissions' => $role->permissions->pluck('name')->toArray()
        ]);

        return redirect()->route('roles.index')->with('success', 'Role and permissions added successfully');
    } else {
        return redirect()->route('roles.create')->withInput()->withErrors($validator);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
    //     $role = Role::findOrFail($id);
    //     $haspermissions = $role->permissions->pluck('name');
    //     $permissions = permission::orderBy('name', 'ASC')->get();

    //     return view('roles.edit',[
    //         'permissions' => $permissions,
    //         'hasPermissions' => $haspermissions
    //     ]);
    // }
//     public function edit($id)
// {
//     $role = Role::findOrFail($id);
//     $permissions = Permission::orderBy('name', 'ASC')->get();
    
//     // Get the IDs of permissions already assigned to this role
//     $rolePermissions = $role->permissions->pluck('id')->toArray();

//     return view('roles.edit', [
//         'role' => $role,
//         'permissions' => $permissions,
//         'rolePermissions' => $rolePermissions // Pass the permission IDs
//     ]);
// }

public function edit($id)
{
    $role = Role::findOrFail($id);
    $permissions = Permission::orderBy('name', 'ASC')->get();

    // Get the IDs of permissions assigned to the role
    $rolePermissions = $role->permissions->pluck('id')->toArray();

    return view('roles.edit', [
        'role' => $role,
        'permissions' => $permissions,
        'rolePermissions' => $rolePermissions
    ]);
}

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'permission' => 'array'
    ]);

    $role = Role::findOrFail($id);
    $role->name = $request->name;
    $role->save();

    // Sync permissions
    $role->permissions()->sync($request->permission ?? []);

    return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
  public function destroy(string $id)
{
    $role = Role::findOrFail($id);
    $role->delete();

    return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
}

}
