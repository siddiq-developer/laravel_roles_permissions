<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use Illuminate\Http\Request;

class UserController extends Controller implements HasMiddleware
{
    
     public static function middleware(): array{
        return[
            new Middleware('permission:view users', only: ['index']),
            new Middleware('permission:edit users', only: ['edit']),
            // new Middleware('permission:create users', only: ['create']),
            // new Middleware('permission:destroy users', only: ['destroy']),  
        ];
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
        $users = User::paginate(5);
        return view('users.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    $roles = Role::all(); 
    $userRole = []; // <- Add this line
    return view('users.create', compact('roles', 'userRole'));
}


    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|array',
        'role.*' => 'exists:roles,id', // Validate each selected role ID exists
    ]);

    // Create user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // Convert role IDs to names
    $roleNames = Role::whereIn('id', $request->role)->pluck('name')->toArray();

    // Assign roles by name
    $user->assignRole($roleNames);

    return redirect()->route('users.index')->with('success', 'User created successfully.');
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    
    public function edit($id)
{
    $user = User::findOrFail($id);
 
    $roles = Role::all();
    $userRole = $user->roles->pluck('id')->toArray();


    return view('users.edit', compact('user', 'roles', 'userRole'));
}

 public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        $user->roles()->sync($request->role);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
   
public function destroy(string $id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('users.index')->with('success', 'User deleted successfully.');
}

}
