<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancesControler extends Controller
{
    //
    public function finances(Request $request)
    {
        # code...
        
        $seller = Seller::whereNull('deleted_at')
            ->where('user_id', Auth::id())
            ->with(['finances' =>  function($query){
                $query->whereNull('deleted_at');
            }])
            ->first();

        if(!$seller){
            return view('components.not-perrmission', [
                'title' => 'تکمیل اطلاعات فروشنده',
                'message' => '<br>
                شما اجازه دسترسی به این بخش را ندارید.
                <br>
                <br>
                لطفا ابتدا نسبت به تکمیل اطلاعات فروشگاه خود اقدام نمایید.',
                'linkRedirect' => route('seller.data.get'),
                'textRedirect' => 'تکمیل اطلاعات فروشنده',
            ]);
        }
        // return $seller;

        return view('seller.finances.list-finances', [
            'title' => 'لیست حساب ها',
            'seller' => $seller,
            'finances' => $seller->finances,
        ]);
    }

    public function financesAddPost(Request $request)
    {
        # code...
        // return $request->all();
        $request->validate([
            // 'actived_at' => 'required',
            'bank' => 'required',
            'bank_account_number' => 'required',
            'bank_cart_number' => 'required',
            'bank_sheba_number' => 'required',
            'name' => 'required',
        ]);

        $seller = Seller::whereNull('deleted_at')->where('user_id', Auth::id())->first();

        Finance::create([
            'user_id' => Auth::id(),
            'seller_id' => $seller->id,
            'actived_at' => ($request->actived_at) ? Carbon::now() : null,
            'bank' => $request->bank,
            'bank_account_number' => $request->bank_account_number,
            'bank_cart_number' => $request->bank_cart_number,
            'bank_sheba_number' => $request->bank_sheba_number,
            // 'id' => $request->actived_at,
            'name' => $request->name,
        ]);
        $this->deactvieAdminSeller();

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.'
        ]);
    }

    public function financeUpdate(Request $request, $id)
    {
        # code...
        $this->deactvieAdminSeller();
        $request->validate([
            // 'actived_at' => 'required',
            'bank' => 'required',
            'bank_account_number' => 'required',
            'bank_cart_number' => 'required',
            'bank_sheba_number' => 'required',
            // 'id' => 'required',
            'name' => 'required',
        ]);

        $seller = Seller::whereNull('deleted_at')->where('user_id', Auth::id())->first();

        Finance::where('id', $id)->update([
            'user_id' => Auth::id(),
            'seller_id' => $seller->id,
            'actived_at' => ($request->actived_at) ? Carbon::now() : null,
            'bank' => $request->bank,
            'bank_account_number' => $request->bank_account_number,
            'bank_cart_number' => $request->bank_cart_number,
            'bank_sheba_number' => $request->bank_sheba_number,
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ویرایش گردید.'
        ]);
    }

    public function financesUpdate (Request $request)
    {
        # code...
        // return $request->all();
        $this->deactvieAdminSeller();
        if(!$request->row){
            return response()->json([
                'status' => 'warning',
                'title' => '',
                'message' => 'لطفا حداقل یک مورد را انتخاب نمایید.'
            ]);
        }
        if($request->type == 'active'){
            Finance::whereIn('id', $request->row)->update([ 
                'deleted_at'=> null,
                'actived_at'=> Carbon::now()
            ]);
        }else if($request->type == 'delete'){
            Finance::whereIn('id', $request->row)->update([ 'deleted_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
        }else if($request->type == 'deactive'){
            Finance::whereIn('id', $request->row)->update([ 'actived_at'=> null ]);
        }
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اعمال گردید.'
        ]);
    }

    public function financeDelete(Request $request, $id)
    {
        # code...
        $financeDelete = Finance::where('id',$id)->first();
        $this->deactvieAdminSeller();
        if ($financeDelete) {
            $financeDelete->deleted_at = Carbon::now()->format('Y-m-d H:i:s');
            $financeDelete->save();
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
    
    public function deactvieAdminSeller()
    {
        # code...
        
        $user = Auth::user();
        $seller = $user->seller;

        $seller = Seller::where('id', $seller->id)->first();
        $seller->admin_active_id = null;
        $seller->save();
    }
}
