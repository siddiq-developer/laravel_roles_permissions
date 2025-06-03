<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array{
        return[
            new Middleware('permission:view permissions', only: ['index']),
            new Middleware('permission:edit permissions', only: ['edit']),
            new Middleware('permission:create permissions', only: ['create']),
            new Middleware('permission:destroy permissions', only: ['destroy']),
            
        ];
    }
    public function index()
    { 
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(10);
        // dd($permissions);
        return view('permissions.list',[
        'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
        'name' => 'required|unique:permissions,name|min:3'
     ]);

        if($validator->passes()){
        Permission::create(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permission added successfully');

        }else{
            return redirect()->route('permissions.create')->withInput()->withInput()->withErrors($validator);
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
    //     $permission = Permission::findOrFail($id);
    //     return view('permissions.edit',[
    //      'permission' => $permission
    //     ]);
        
    // }
    public function edit($id)
{
    $permission = Permission::find($id);
    
    if (!$permission) {
        return redirect()->route('permissions.index')->with('error', 'Permission not found.');
    }

    return view('permissions.edit', compact('permission'));
}


    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    $permission = Permission::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'name' => 'required|min:3|unique:permissions,name,' . $id,
    ]);

    if ($validator->passes()) {
        // $permission->update([
        //     'name' => $request->name
        // ]);
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
    } else {
        return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
    }
}




public function destroy($id)
{
    $permission = Permission::find($id);

    if (!$permission) {
        return redirect()->route('permissions.index')->with('error', 'Permission not found');
    }

    $permission->delete();

    return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully');
}



}
