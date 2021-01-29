<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\Role;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    //
    public function roles(Request $request)
    {
        # code...
        $roles = Role::withCount('users')->withCount('permissions')->get();

        $permissions = Permission::whereNull('deleted_at')->get();
        // return $roles;

        return view('admin.roles.list-roles',[
            'roles' => $roles,
            'permissions' => $permissions,
            'title' => 'لیست نقش کاربران',
        ]);
    }

    public function roleAdd(Request $request)
    {
        # code...
        // return $request->all();
        $request->validate([
            'slug' => 'required|unique:roles,slug',
            'code' => 'required',
            'details' => 'sometimes|string',
            'name' => 'required',
        ]);

        $role = Role::create([
            'actived_at' => ($request->active) ? Carbon::now() : null,
            'slug' => $request->slug,
            'code' => $request->code,
            'details' => $request->details,
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ویرایش گردید.',
            'rowInsert' => [
                '',
                $request->name,
                $request->slug,
                $request->code,
                ($request->active) ? '<span class="badge badge-success">فعال</span>' : '<span class="badge badge-danger">غیرفعال</span>',
                '0',
                '0',

            ]
        ]);
    }

    public function roleUpdate(Request $request, $id)
    {
        # code...
        // return $request->all();
        $request->validate([
            'id' => 'required|exists:roles,id',
            'code' => 'required',
            'details' => 'sometimes|string',
            'name' => 'required',
        ]);

        $role = Role::where('id', $request->id)->update([
            'actived_at' => ($request->active) ? Carbon::now() : null,
            'code' => $request->code,
            'details' => $request->details,
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ویرایش گردید.'
        ]);
    }

    public function rolesUpdate(Request $request)
    {
        # code...
        // return $request->all();
        if($request->type == 'active'){
            Role::whereIn('id', $request->row)->update([
                'deleted_at'=> null,
                'actived_at'=> Carbon::now()
            ]);
        }else if($request->type == 'delete'){
            Role::whereIn('id', $request->row)->update([ 'deleted_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
        }else if($request->type == 'deactive'){
            Role::whereIn('id', $request->row)->update([ 'active'=> 0 ]);
        }
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اعمال گردید.'
        ]);
    }

    public function roleDelete(Request $request, $id)
    {
        # code...
        $roleDelete = Role::where('id',$id)->first();
        if ($roleDelete) {
            $roleDelete->deleted_at = Carbon::now()->format('Y-m-d H:i:s');
            $roleDelete->save();
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
