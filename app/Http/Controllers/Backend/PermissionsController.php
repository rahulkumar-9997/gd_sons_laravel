<?php
namespace App\Http\Controllers\Backend;

use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function index()
    {   
        $permissions = Permission::orderBy('id','DESC')->get();
        return view('backend.permissions.index', ['permissions' => $permissions]);
    }

    public function create() 
    {   
        return view('backend.permissions.create');
    }

    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|unique:users,name'
        ]);

        Permission::create($request->only('name'));
        
        return redirect()->route('permissions.index')->with('success','Permissions saved successfully');
    }

    public function edit(Permission $permission)
    {
        return view('backend.permissions.edit', [
            'permission' => $permission
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id
        ]);

        $permission->update($request->only('name'));
        return redirect()->route('permissions.index')->with('success','Permission updated successfully');
      
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success','Permission deleted successfully');
        
    }
}
