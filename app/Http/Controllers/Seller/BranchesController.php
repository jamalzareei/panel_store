<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Seller;
use App\Models\SellerBranch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchesController extends Controller
{
    //
    public function branches(Request $request)
    {
        # code...
        $user = Auth::user();
        $seller = $user->seller;

        // $branches = SellerBranch::where('', )->first();
        
        $seller = Seller::where('user_id', $user->id)
            ->with(['branches' => function ($query) {
                $query->with(['country', 'state', 'city'])->whereNull('deleted_at');
            }])
            ->first();
                    
        $countries = Country::all();
        if(!$seller){
            return view('seller.seller-not-exists', [
                'title' => 'تکمیل اطلاعات فروشنده',
            ]);
        }
        // return $seller;

        return view('seller.branches.list-branches', [
            'title' => 'ویرایش اطلاعات فروشگاه',
            'seller' => $seller,
            'countries' => $countries,
        ]);
    }

    public function addeBranceh(Request $request)
    {
        # code...
        $request->validate([
            'title'=> 'required'
        ]);

        
        $user = Auth::user();
        $seller = $user->seller;

        if(!$seller){
            
            return [
                'status' => 'error',
                'title' => '',
                'message' => 'لطفا ابتدا اطلاعات فروشگاه خود را ثبت نمایید.
                <br>
                <a href="'.route('seller.data.get').'" class="btn btn-primary">ویرایش اطلاعات فروشگاه</a>',
            ];
        }

        $branch = SellerBranch::create([
            'title'         => $request->title,
            'user_id'       => $user->id,
            'seller_id'     => $seller->id,
        ]);
        

        return [
            
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ثبت گردید.',
            'data' => $branch,
            'autoRedirect' => ($branch) ? route('seller.branch.edit', ['id' => $branch->id]) : null
        ];
    }

    public function editBranch($id)
    {
        # code...
        $branch = SellerBranch::where('id', $id)->with(['country', 'state', 'city'])->first();

        // return $branch;
        
        $countries = Country::all();
        return view('seller.branches.update-or-insert-branch', [
            'title' => 'ویرایش شعبه ',
            'branch' => $branch,
            'countries' => $countries,
        ]);
    }

    public function updateBranceh(Request $request, $id)
    {
        # code...

        $request->validate([
            'address'       => 'required|string',
            'city_id'       => 'required|exists:cities,id',
            'country_id'    => 'required|exists:countries,id',
            'state_id'      => 'required|exists:states,id',
            'latitude'      => 'required|string',
            'longitude'     => 'required|string',
            'manager'       => 'required|string',
            'phones'        => 'required|string',
            'title'         => 'required|string',
        ]);

        $branch = SellerBranch::where('id', $id)->first();
        if(!$branch){
            
            return [
                'status' => 'error',
                'title' => '',
                'message' => 'شعبه ای انتخاب نشده است.
                <br>
                <a href="'.route('seller.brancehs.get').'" class="btn btn-primary">لیست شعبه ها</a>',
            ];
        }

        $branch->address = $request->address;
        $branch->city_id =  $request->city_id;
        $branch->country_id =  $request->country_id;
        $branch->latitude =  $request->latitude;
        $branch->longitude =  $request->longitude;
        $branch->manager =  $request->manager;
        $branch->phones =  $request->phones;
        $branch->state_id =  $request->state_id;
        $branch->title =  $request->title;
        $branch->actived_at = ($request->actived_at) ? Carbon::now() : null;

        $branch->save();

        return [
            'status' => 'success',
            'title' => '',
            'message' => 'شعبه با موفقیت ویرایش گردید.
            <br>
            <a href="'.route('seller.brancehs.get').'" class="btn btn-primary">لیست شعبه ها</a>',
        ];
    }

    public function branchUpdateStatus (Request $request, $id)
    {
        # code...
        // return $request->all();
        // $actived_at = $request->status ? Carbon::now() : null;
        $branch = SellerBranch::where('id', $id)->update([
            'actived_at' => ($request->status == 'true') ? Carbon::now() : null
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اپدیت گردید.'
        ], 200);
    }
    
    public function branchesUpdate (Request $request)
    {
        # code...
        // return $request->all();
        if(!$request->row){
            return response()->json([
                'status' => 'warning',
                'title' => '',
                'message' => 'لطفا حداقل یک مورد را انتخاب نمایید.'
            ]);
        }
        if($request->type == 'active'){
            
            SellerBranch::whereIn('id', $request->row)->update([ 
                'deleted_at'=> null,
                'actived_at'=> Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }else if($request->type == 'delete'){
            SellerBranch::whereIn('id', $request->row)->update([ 'deleted_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
        }else if($request->type == 'deactive'){
            SellerBranch::whereIn('id', $request->row)->update([ 'actived_at'=> null ]);
        }
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اعمال گردید.'
        ]);
    }
    
    public function branchesDelete (Request $request, $id)
    {
        # code...
        $branchDelete = SellerBranch::where('id',$id)->first();
        if ($branchDelete) {
            $branchDelete->deleted_at = Carbon::now()->format('Y-m-d H:i:s');
            $branchDelete->save();
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
