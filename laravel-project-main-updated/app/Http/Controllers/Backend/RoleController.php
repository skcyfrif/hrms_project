<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PermissionExport;
use App\Http\Controllers\Controller;
use App\Imports\PermissionImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function AllPermission()
    {
        $permissions = Permission::all();

        return view('backend.pages.permission.all_permission', compact('permissions'));
    } // End method


    public function AddPermission()
    {
        return view('backend.pages.permission.add_permission');
    } //End Method

    public function storePermission(Request $request)
    {
        //validation
        $request->validate([
            'permission_name' => 'string|max:200',
        ]);

        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name

        ]);

        $notification = [
            'message'       => 'Permission created successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.permission')->with($notification);
    } //End  method

    public function EditPermission($id)
    {
        $permission = Permission::findOrFail($id);

        return view('backend.pages.permission.edit_permission', compact('permission'));
    } //End Permission

    public function UpdatePermission(Request $request)
    {
        //validation
        $request->validate([
            'permission_name' => 'string|max:200',
        ]);

        Permission::find($request->id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name

        ]);

        $notification = [
            'message'       => 'Permission updated successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.permission')->with($notification);
    } //End mehtod

    public function deletePermission($id)
    {
        Permission::findOrFail($id)->delete();

        $notification = [
            'message'       => 'Permission deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.permission')->with($notification);
    }

    public function ImportPermission()
    {
        return view('backend.pages.permission.import_permission');
    } // End method

    public function Export()
    {
        return Excel::download(new PermissionExport,  'Permision.xlsx');
    } //End method

    public function Import(Request $request)
    {
        Excel::import(new PermissionImport, $request->file('import_file'));

        $notification = [
            'message'       => 'Permission imported successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->back()->with($notification);
    }



    ///////////Role All method ///////////////


    public function AllRole()
    {
        $roles = Role::all();

        return view('backend.pages.roles.all_roles', compact('roles'));
    } // End method


    public function AddRole()
    {
        return view('backend.pages.roles.add_role');
    } //End Method

    public function storeRole(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'string|max:200',
        ]);

        Role::create([
            'name' => $request->name,

        ]);

        $notification = [
            'message'       => 'Role created successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.role')->with($notification);
    } //End  method

    public function EditRole($id)
    {
        $role = Role::findOrFail($id);

        return view('backend.pages.roles.edit_role', compact('role'));
    } //End Role

    public function UpdateRole(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'string|max:200',
        ]);

        Role::find($request->id)->update([
            'name' => $request->name,

        ]);

        $notification = [
            'message'       => 'Role updated successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.role')->with($notification);
    } //End mehtod

    public function deleteRole($id)
    {
        Role::findOrFail($id)->delete();

        $notification = [
            'message'       => 'Role deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.role')->with($notification);
    } //End method

    public function ImportRole()
    {
        return view('backend.pages.Role.import_Role');
    } // End method



    ////////////////////Add Role Permission All Method /////////////

    public function AddRolesPermission()
    {
        $roles = Role::all();
        $permission = Permission::all();
        $permission_groups = User::getPermissionGroups();

        return view('backend.pages.rolesetup.add_roles_permission', compact('roles', 'permission', 'permission_groups'));
    } //End Method

    public function StoreRolesPermission(Request $request)
    {
        $data = array();

        $permissions = $request->permission;

        foreach ($permissions as $key => $item) {
            $data['role_id']        = $request->role_id;
            $data['permission_id']  = $item;

            DB::table('role_has_permissions')->insert($data);
        } //end foreach

        $notification = [
            'message'       => 'Role permission added successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.roles.permission')->with($notification);
    } //End method

    public function AllRolesPermission()
    {
        $roles = Role::all();

        return view('backend.pages.rolesetup.all_roles_permission', compact('roles'));
    } //End Method

    public function AdminEditRoles($id)
    {
        $role = Role::findOrFail($id);

        $permission = Permission::all();
        $permission_groups = User::getPermissionGroups();

        return view('backend.pages.rolesetup.edit_roles_permission', compact('role', 'permission', 'permission_groups'));
    } //End method



    public function AdminRolesUpdate(Request $request)
    {
        $role = Role::findOrFail($request->id);
        $permissions = $request->permission;

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        $notification = [
            'message'       => 'Role permission updated successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.roles.permission')->with($notification);
    } //End method

    public function AdminDeleteRoles($id)
    {
        $role = Role::findOrFail($id);

        if (!is_null($role)) {
            $role->delete();
        }

        $notification = [
            'message'       => 'Role permission deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->back()->with($notification);
    } //End method





}
