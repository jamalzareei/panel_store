<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    //
    public function users(Request $request)
    {
        $users = User::with(['roles' => function($query){ $query->select('name'); } ])->get();
        $roles = Role::all();
        // return $users;
        return view('admin.users.list-users',[
            'users' => $users,
            'roles' => $roles,
            'title' => 'لیست کاربران',
        ]);
    }

    public function userAdd(Request $request)
    {
        # code...
        // return $request->all();
        $request->validate([
            'email'=> "required|email|unique:users,email",
            'phone'=> "required|string|unique:users,phone",
            'firstname'=> "sometimes|string",
            'lastname'=> "sometimes|string",
            'roles.*'=> "required|string|exists:roles,slug",
        ]);

        $username = '0098' . ltrim($request->phone, '0');
        if(User::where('username', $username)->first()){
            return response()->json([
                'status' => 'error',
                'title' => 'شماره تلفن کاربر تکراری است.'
            ]);
        }
        
        $user = User::create([
            'firstname'         => $request->firstname, 
            'lastname'          => $request->lastname, 
            'email'             => $request->email, 
            'phone'             => $request->phone, 
            'username'          => $username, 
            'code_country'      => '0098', 
            'uuid'              => (string) Str::uuid(), 
            'password'          => bcrypt($request->phone), 
            'email_verified_at' => ($request->verify) ? Carbon::now()->format('Y-m-d H:i:s') : null, 
            'phone_verified_at' => ($request->verify) ? Carbon::now()->format('Y-m-d H:i:s') : null, 
            'blocked_at'        => ($request->block) ? Carbon::now()->format('Y-m-d H:i:s') : null, 
            'deleted_at'        => ($request->delete) ? Carbon::now()->format('Y-m-d H:i:s') : null, 
            'deactive_at'=> ($request->deactive) ? Carbon::now()->format('Y-m-d H:i:s') : null, 
        ]);
        // return $user;
        
        $roles = Role::whereIn('slug', $request->roles)->pluck('id')->toArray();
        $user->roles()->sync($roles);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.'
        ]);
    }

    public function userUpdate(Request $request, $id)
    {
        # code...
        // return $request->all();
        $request->validate([
            'id' => 'required|exists:users,id',
            'firstname'=> "sometimes|string",
            'lastname'=> "sometimes|string",
            'roles.*'=> "required|string|exists:roles,slug",
        ]);
        $user = User::where('id', $request->id)->update([ 
            'firstname'         => $request->firstname, 
            'lastname'          => $request->lastname, 
            'email_verified_at' => ($request->verify) ? Carbon::now()->format('Y-m-d H:i:s') : null, 
            'phone_verified_at' => ($request->verify) ? Carbon::now()->format('Y-m-d H:i:s') : null, 
            'blocked_at'        => ($request->block) ? Carbon::now()->format('Y-m-d H:i:s') : null, 
            'deleted_at'        => ($request->delete) ? Carbon::now()->format('Y-m-d H:i:s') : null, 
            'deactive_at'=> ($request->deactive) ? Carbon::now()->format('Y-m-d H:i:s') : null, 
        ]);

        // test::where('id' ,'>' ,0)->lists('id')->toArray();
        $roles = Role::whereIn('slug', $request->roles)->pluck('id')->toArray();
        $user = User::where('id',$request->id)->first();
        $user->roles()->sync($roles);

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

    public function usersUpdate(Request $request)
    {
        # code...
        // return $request->row;//all();
        if($request->type == 'active'){
            User::whereIn('id', $request->row)->update([ 
                'deleted_at'=> null, 
                'deactive_at'=> null, 
                'blocked_at'=> null, 
                'phone_verified_at'=> Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }else if($request->type == 'delete'){
            User::whereIn('id', $request->row)->update([ 'deleted_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
        }else if($request->type == 'deactive'){
            User::whereIn('id', $request->row)->update([ 'deactive_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
        }else if($request->type == 'block'){
            User::whereIn('id', $request->row)->update([ 'blocked_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
        }
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اعمال گردید.'
        ]);
    }

    public function userDelete(Request $request, $id)
    {
        # code...
        $userDelete = User::where('id',$id)->first();
        if ($userDelete) {
            $userDelete->deleted_at = Carbon::now()->format('Y-m-d H:i:s');
            $userDelete->save();
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
