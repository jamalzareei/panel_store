<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Page;
use App\Models\Seo;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    //
    public function pages(Request $request)
    {
        # code...
        $pages = Page::whereNull('deleted_at')->with('user')->get();

        return view('admin.pages.list-pages', [
            'title' => 'صفحات ایستا',
            'pages' => $pages,
        ]);
    }
    
    public function page(Request $request, $slug)
    {
        # code...
        $page = Page::where('slug', $slug)->with(['seo', 'image'])->first();

        if(!$page){
            return back()->with('noty', [
                'title' => '',
                'message' => 'صفحه مورد نظر وجود ندارد.',
                'status' => 'error',
                'data' => '',
            ]);
        }

        
        // return config('shixeh.path_upload_files').$page->path;
        return view('admin.pages.edit-page', [
            'title' => 'ویرایش صفحه ',
            'page' => $page,
        ]);
    }

    public function addePage(Request $request)
    {
        # code...
        $request->validate([
            'name'=> 'required'
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

        $page = Page::create([
            'name'          => $request->name,
            'user_id'       => $user->id,
            'order_by'      => $request->order_by ?? 1
        ]);
        

        return [
            
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ثبت گردید.',
            'data' => $page,
            'autoRedirect' => ($page) ? route('admin.page.get', ['slug' => $page->slug]) : null
        ];
    }
    
    public function pageUpdate(Request $request, $id)
    {
        # code...
        // return $request->all();
        $request->validate([
            'name' => 'required|string',
            'details' => 'required|string',
            'image_file' => 'nullable|string',
        ]);
        $user = Auth::user();

        // return UploadService::contectToHtml(config('shixeh.path_upload_files') . 'jamal.html', $request->details);

        $page = Page::where('id', $id)->first();
        if(!$page){
            return back()->with('noty', [
                'title' => '',
                'message' => 'صفحه مورد نظر وجود ندارد.',
                'status' => 'error',
                'data' => '',
            ]);
        }
        $newpage = false;
        if(!$page){
            $newpage = true;
            $page = new Page();
        }
        
        $page->name = $request->name;
        $page->tags = $request->tags;
        $page->actived_at = ($request->active) ? Carbon::now() : null;
        $page->admin_actived_at = ($request->active) ? Carbon::now() : null;
        $page->admin_actived_id = $user->id;

        $path_image = null;
        if ($request->image_file) {
            $image = Image::where([
                'imageable_id' => $page->id,
                'imageable_type' => 'App\Models\Page',
                'user_id' => $user->id
            ])->first();
            if($image && $image->path){
                UploadService::destroyFile($image->path);
            }

            $path_image = UploadService::convertBase64toPng('uploads/pages', $request->image_file);
            Image::insert([ //,
                'path' => $path_image,
                'imageable_id' => $page->id,
                'imageable_type' => 'App\Models\Page',
                'user_id' => $user->id
            ]);
        }

        $page->image_path = $path_image;
        $page->save();

        
        $pathFile = ($page->path) ? $page->path : 'files/user-'.$user->id.'/pages/page-'. $page->id . '/' . time() .'.html';
        // return $page;
        // UploadService::contectToHtml(config('shixeh.path_upload_files') . $pathFile, $request->details);
        UploadService::contentToHtml(config('shixeh.path_upload_files') . $pathFile, $request->details);
        
        $page->path = $pathFile;
        
        $page->save();

        $seo = new Seo();
        if ($page->seo) {
            $seo = $page->seo;
        }
        // return $page->seo;
        $seo->head = $request->head;
        $seo->title = $request->title;
        $seo->meta_description = $request->meta_description;
        $seo->meta_keywords = $request->meta_keywords;
        $seo->save();

        $page->seo()->save($seo);
        
        return [
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ثبت گردید.',
            'data' => $page,
            'autoRedirect' => ($newpage) ? route('page.data.get') : null
        ];
    }

    public function pageUpdateStatus (Request $request, $id)
    {
        # code...
        // return $request->all();
        // $actived_at = $request->status ? Carbon::now() : null;
        $page = Page::where('id', $id)->update([
            'actived_at' => ($request->status == 'true') ? Carbon::now() : null,
            'admin_actived_at' => ($request->status == 'true') ? Carbon::now() : null
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اپدیت گردید.'
        ], 200);
    }

    public function pagesUpdate(Request $request)
    {
        # code...
        // return $request->all();
        
        if($request->type == 'active'){
            if(!$request->row){
                return response()->json([
                    'status' => 'warning',
                    'title' => '',
                    'message' => 'لطفا حداقل یک مورد را انتخاب نمایید.'
                ]);
            }
            Page::whereIn('id', $request->row)->update([ 
                'deleted_at'=> null,
                'actived_at'=> Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }else if($request->type == 'delete'){
            if(!$request->row){
                return response()->json([
                    'status' => 'warning',
                    'title' => '',
                    'message' => 'لطفا حداقل یک مورد را انتخاب نمایید.'
                ]);
            }
            Page::whereIn('id', $request->row)->update([ 'deleted_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
        }else if($request->type == 'deactive'){
            if(!$request->row){
                return response()->json([
                    'status' => 'warning',
                    'title' => '',
                    'message' => 'لطفا حداقل یک مورد را انتخاب نمایید.'
                ]);
            }
            Page::whereIn('id', $request->row)->update([ 'actived_at'=> null ]);
        }else if($request->type == 'update'){
            foreach ($request->ids as $key => $value) {
                # code...
                Page::where('id', $value)->update([
                    // 'actived_at' => ($request->actived_at && isset($request->actived_at[$value])) ? Carbon::now() : null,
                    'order_by' => $request->order_by[$value],
                ]);
            }
        }
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اعمال گردید.'
        ]);
    }
}
