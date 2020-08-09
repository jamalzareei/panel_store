<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\Permission;
// use App\Models\Role;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use ReflectionClass;
use ReflectionMethod;

class PermissionsController extends Controller
{
    //
    public function permissions(Request $request)
    {
        $permissions = Permission::with(['roles' => function ($query) {
            $query->select('name');
        }])->get();
        $roles = Role::whereNull('deleted_at')->where('active', 1)->get();

        $listControllersMethods = $this->Controllers();
        // return $listControllersMethods;
        return view('admin.permissions.list-permissions', [
            'permissions' => $permissions,
            'roles' => $roles,
            'listControllersMethods' => $listControllersMethods,
            'title' => 'لیست پرمیشن ها',
        ]);
    }

    public static function Controllers()
    {
        $controllers = [];

        foreach (Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getAction();

            if (array_key_exists('controller', $action) && (strpos($action['controller'], 'App\Http\Controllers') !== false) ) {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                $controllers[] = str_replace(['App\Http\Controllers\\', '\\', '@'], ['','-',' '], $action['controller']);
            }
        }
        return $controllers;
    }

    public function permissionAdd(Request $request)
    {
        # code...
        // return $request->all();
        $request->validate([
            'name' => "required|string",
            'roles.*' => "required|string|exists:roles,slug",
        ]);

        $permission = Permission::create(['name' => $request->name]);

        $roles = $request['roles'];
        
        if (isset($roles)) {

            foreach ($roles as $role) {
                $role_r = Role::where('slug', '=', $role)->firstOrFail();            
                $permission->assignRole($role_r);
            }
        } 

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.'
        ]);
    }

    public function permissionUpdate(Request $request, $id)
    {
        # code...
        // return $request->all();
        $request->validate([
            'id' => 'required|exists:permissions,id',
            'name' => "required|string",
            'roles.*' => "required|string|exists:roles,slug",
        ]);
        
        $permission = Permission::where('id', $request->id)->first();
        $permission->name = $request->name;
        $permission->save();

        $roles = $request['roles'];
        
        // $roles = Role::whereIn('slug', $request['roles'])->pluck('id'); 
        // return $roles;
        // $permission->assignRole($role);
        // $permission->syncRoles($roles);

        if (isset($roles)) {

            foreach ($roles as $role) {
                $role_r = Role::where('slug', '=', $role)->firstOrFail();            
                // $permission->assignRole($role_r);
                $role_r->givePermissionTo($permission);
            }
        } 

        session()->put('noty', [
            'title' => '',
            'message' => 'با موفقیت ویرایش گردید.',
            'status' => 'success',
            'data' => '',
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ویرایش گردید.'
        ]);
    }

    public function permissionsUpdate(Request $request)
    {
        # code...
        // return $request->row;//all();
        if ($request->type == 'active') {
            Permission::whereIn('id', $request->row)->update([
                'deleted_at' => null,
            ]);
        } else if ($request->type == 'delete') {
            Permission::whereIn('id', $request->row)->update(['deleted_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }
        
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اعمال گردید.'
        ]);
    }

    public function permissionDelete(Request $request, $id)
    {
        # code...
        $permissionDelete = Permission::where('id', $id)->first();
        if ($permissionDelete) {
            $permissionDelete->deleted_at = Carbon::now()->format('Y-m-d H:i:s');
            $permissionDelete->save();
            return response()->json([
                'status' => 'success',
                'title' => '',
                'message' => 'با موفقیت حذف گردید.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'title' => '',
                'message' => 'دوباره تلاش نمایید.'
            ]);
        }
    }
}
