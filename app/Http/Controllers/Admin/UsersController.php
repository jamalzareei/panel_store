<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\Role;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    //
    
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    // }


    public function users(Request $request)
    {
        $users = User::with(['roles' => function($query){ $query->select('name'); } ])->get();
        // $users = User::with('permissions')->get();
        $roles = Role::whereNull('deleted_at')->where('active', 1)->get();
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
            'deactived_at'=> ($request->deactive) ? Carbon::now()->format('Y-m-d H:i:s') : null, 
        ]);
        // return $user;
        
        // $roles = Role::whereIn('slug', $request->roles)->pluck('id')->toArray();
        // $user->roles()->sync($roles);
        $roles = $request['roles']; //Retrieving the roles field
    //Checking if a role was selected
        if (isset($roles)) {

            foreach ($roles as $role) {
                $role_r = Role::where('slug', '=', $role)->firstOrFail();            
                $user->assignRole($role_r); //Assigning role to user
            }
        }  

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
            'deactived_at'=> ($request->deactive) ? Carbon::now()->format('Y-m-d H:i:s') : null, 
        ]);

        // test::where('id' ,'>' ,0)->lists('id')->toArray();
        $user = User::where('id',$request->id)->first();
        $roles = null;
        if($request->roles)
            $roles = Role::whereIn('slug', $request->roles)->pluck('id')->toArray();
        // $user->roles()->sync($roles);

        // return $roles;// = $request['roles']; //Retreive all roles
        // $user->fill($input)->save();

        if (isset($roles)) {        
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles          
        }        
        else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
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

    public function usersUpdate(Request $request)
    {
        # code...
        // return $request->row;//all();
        if($request->type == 'active'){
            User::whereIn('id', $request->row)->update([ 
                'deleted_at'=> null, 
                'deactived_at'=> null, 
                'blocked_at'=> null, 
                'phone_verified_at'=> Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }else if($request->type == 'delete'){
            User::whereIn('id', $request->row)->update([ 'deleted_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
        }else if($request->type == 'deactive'){
            User::whereIn('id', $request->row)->update([ 'deactived_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
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
