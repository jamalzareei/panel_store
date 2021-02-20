<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerSocial;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SocialsController extends Controller
{
    //
    public function index()
    {
        # code...
        $socials = SellerSocial::whereNull('deleted_at')
            ->with(['social', 'seller'])
            ->paginate(20);


        return view('admin.socials.list-socials', [
            'title' => 'لیست شبکه های اجتماعی ثبت شده',
            'socials' => $socials,
        ]);
        return $socials;
    }

    public function update(Request $request)
    {
        # code...
        // return $request->all();
        $request->validate([
            'id' => 'required|exists:seller_social,id',
        ]);

        // return $data = json_decode($request->details, true);

        $social = SellerSocial::where('id', $request->id)->first();

        $social->details = $request->details;
        $social->save();

        if($request->files){
            $path = "instagram/pages/$social->username";
            UploadService::deleteDir($path);
            foreach ($request->files as $key => $file) {
                # code...
                UploadService::saveFileJson($path, $file, $social->username);
            }
        }


        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ویرایش گردید.'
        ]);
    }

    public function uploadPostsPage(Request $request)
    {
        # code...
        $request->validate([
            'name' => 'required',
            'files' => 'required',
        ]);

        if($request->files){
            $path = "instagram/pages/$request->name";
            UploadService::deleteDir($path);
            foreach ($request->files as $key => $file) {
                # code...
                UploadService::saveFileJson($path, $file, $request->name);
            }
        }

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ویرایش گردید.'
        ]);
    }
}
