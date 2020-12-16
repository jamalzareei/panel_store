<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Seo;
use App\Models\Website;
use App\Models\Websiteable;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //
    public function categories(Request $request, $parent_id = null)
    {
        if (!$parent_id) $parent_id = 0;

        $title = 'لیست دسته بندی ها';
        $category = Category::where('id', $parent_id)->first();
        if($category){
            $title = 'لیست دسته بندی های '. $category->name;
        }

        $categories = Category::whereNull('deleted_at')
            ->when($parent_id, function ($query) use ($parent_id) {
                $query->where('parent_id', $parent_id);
            })
            ->when($parent_id == 0, function ($query) {
                $query->where('parent_id', 0)->orWhere('parent_id', null);
            })
            ->withCount('properties')
            ->orderBy('id', 'desc')
            ->get();
        // return $categories;

        $websites = Website::whereNull('deleted_at')->whereIn('url', config('shixeh.listWebsites'))->get();
        
        return view('admin.categories.list-categories', [
            'parent_id' => $parent_id,
            'categories' => $categories,
            'websites' => $websites,
            'title' => $title,
        ]);
    }

    public function categoryUpdateStatus (Request $request, $id)
    {
        # code...
        // return $request->all();
        // $actived_at = $request->status ? Carbon::now() : null;
        $category = Category::where('id', $id)->update([
            'actived_at' => ($request->status == 'true') ? Carbon::now() : null
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اپدیت گردید.'
        ], 200);
    }

    public function categoryEdit(Request $request, $slug = null)
    {
        # code...
        $category = Category::where('slug', $slug)->first();

        // return $category;
        if(!$category){ abort(404); }
        // admin.categories.update-or-insert-category.blade.php
        return view('admin.categories.update-or-insert-category', [
            'title' => $category ? 'ویرایش دسته بندی '.$category->name.'' : 'اضافه کردن دسته بندی',
            'category' => $category
        ]);
    }

    public function categoryUpdate(Request $request, $id)
    {
        # code...
        // return $request->all();
        $category = Category::where('id', $id)->first();
        
        if(!$category){
            return [
                'status' => 'error',
                'title' => '',
                'message' => 'دسته بندی فوق وجود ندارد یا حذف شده است.'
            ];
        }

        $photos = null;
        if($request->imageUrl != 'undefined'){
            $request->validate([
                'imageUrl' => 'image|max:300|mimes:jpeg,jpg,png',
            ]);
            $date = date('Y-m-d');
            $path = "images/uploads/categories/$id/$date";
            $photos = [$request->imageUrl];
            $photos = UploadService::saveFile($path, $photos);

            if($category->image){
                UploadService::destroyFile($category->image);
            }

            $category->image = $photos;
        }
        
        if($request->active){ $category->actived_at  = Carbon::now(); }else{ $category->actived_at  = null; }
        
        // if($request->head)              $category->head  = $request->head;
        if($request->link)              $category->link  = $request->link;
        // if($request->meta_description)  $category->meta_description  = $request->meta_description;
        // if($request->meta_keywords)     $category->meta_keywords  = $request->meta_keywords;
        if($request->name)              $category->name  = $request->name;
        if($request->description_short) $category->description_short  = $request->description_short;
        if($request->description_full)  $category->description_full  = $request->description_full;

        if($request->show_menu){ $category->show_menu  = 1; }else{ $category->show_menu  = 0; } 
        if($request->properties_active){ $category->properties_active  = 1; }else{ $category->properties_active  = 0; } 

        if($request->slug) {
            $catSlug = Category::where('slug', $request->slug)->where('id', '!=', $id)->first();
            if($catSlug){
                return response()->json([
                    'status' => 'error',
                    'errors' => ['slug' => 'این اسلاگ قبلا تعریف شده است.'],
                ], 422);
            }else{
                $category->slug  = $request->slug;
            }
        }       

        // if($request->title)             $category->title  = $request->title;
        
        $category->save();

        $seo = new Seo();
        if ($category->seo) {
            $seo = $category->seo;
        }
        // return $property->seo;
        if($request->head)              $seo->head = $request->head;
        if($request->title)             $seo->title = $request->title;
        if($request->meta_description)  $seo->meta_description = $request->meta_description;
        if($request->meta_keywords)     $seo->meta_keywords = $request->meta_keywords;
        $seo->save();
        $category->seo()->save($seo);

        return [
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ویرایش پیدا کرد.'
        ];
    }

    public function categoryInsert(Request $request)
    {
        # code...
        // return $request->all();
        $request->validate([
            // 'order_by' =>  'required|numeric',
            'name' =>  'required|string',
            'websites' =>  'required|exists:websites,id',
            // 'description_full' => 'required',
        ]);

        $category = Category::create([
            'order_by' =>  ($request->order_by) ?? 1,
            'name' =>  $request->name,
            'parent_id' =>  $request->parent_id ?? 0 ,
            'description_full' =>  $request->description_full,
            'actived_at' => ($request->actived_at) ? Carbon::now() : null,
            'show_menu' => ($request->show_menu) ? 1 : 0,
            'properties_active' => 1,// ($request->properties_active) ? 1 : 0,
        ]);

        $category = Category::where('id', $category->id)->first();// ;


        if($request->websites){
            // $category->websites()->async($request->websites);
            foreach ($request->websites as $key => $value) {
                # code...
                $websiteable = new Websiteable();
                $websiteable->user_id = auth()->id();
                $websiteable->website_id = $value;
                $websiteable->active_at = Carbon::now();
    
                $category->websites()->save($websiteable);
            }
        }

        session()->put('noty', [
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.',
            'data' => '',
        ]);
        // return $category;
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.',
            'autoRedirect' => route('admin.category.edit', ['slug' => $category->slug])
        ], 200);
    }

    public function categoriesUpdate(Request $request)
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
            Category::whereIn('id', $request->row)->update([ 
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
            Category::whereIn('id', $request->row)->update([ 'deleted_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
        }else if($request->type == 'deactive'){
            if(!$request->row){
                return response()->json([
                    'status' => 'warning',
                    'title' => '',
                    'message' => 'لطفا حداقل یک مورد را انتخاب نمایید.'
                ]);
            }
            Category::whereIn('id', $request->row)->update([ 'actived_at'=> null ]);
        }else if($request->type == 'update'){
            foreach ($request->ids as $key => $value) {
                # code...
                Category::where('id', $value)->update([
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

    public function categoryDelete (Request $request, $id)
    {
        # code...
        $categoryDelete = Category::where('id',$id)->first();
        if ($categoryDelete) {
            $categoryDelete->deleted_at = Carbon::now()->format('Y-m-d H:i:s');
            $categoryDelete->save();
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
