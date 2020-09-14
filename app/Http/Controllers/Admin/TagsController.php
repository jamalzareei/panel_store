<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    //
    public function tags(Request $request, $name = null)
    {
        $tags = Tag::whereNull('deleted_at')
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', "%$name%");
            })
            ->orderBy('id', 'desc')
            ->get();
        // return $tags;
        return view('admin.tags.list-tags', [
            'tags' => $tags,
            'title' => 'لیست تگ ها',
        ]);
    }
    
    public function tagInsert(Request $request)
    {
        # code...
        // return $request->all();
        $request->validate([
            'name' =>  'required|string',
        ]);

        $tag = Tag::create([
            'name' =>  $request->name,
            'actived_at' => ($request->active) ? Carbon::now() : null,
        ]);

        $tag = Tag::where('id', $tag->id)->first();// ;

        session()->put('noty', [
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.',
            'data' => '',
        ]);
        // return $tag;
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.',
            'autoRedirect' => route('admin.tag.edit', ['slug' => $tag->slug])
        ], 200);
    }

    public function tagUpdateStatus (Request $request, $id)
    {
        # code...
        // return $request->all();
        $tag = Tag::where('id', $id)->update([
            'actived_at' => ($request->status == 'true') ? Carbon::now() : null
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اپدیت گردید.'
        ], 200);
    }

    public function tagEdit(Request $request, $slug = null)
    {
        # code...
        $tag = Tag::where('slug', $slug)->first();

        // return $tag;
        if(!$tag){ abort(404); }
        // admin.tags.update-or-insert-tag.blade.php
        return view('admin.tags.update-or-insert-tag', [
            'title' => $tag ? 'ویرایش تگ '.$tag->name.'' : 'اضافه کردن تگ',
            'tag' => $tag
        ]);
    }

    public function tagUpdate(Request $request, $id)
    {
        # code...
        // return $request->all();
        $tag = Tag::where('id', $id)->first();
        
        if(!$tag){
            return [
                'status' => 'error',
                'title' => '',
                'message' => 'تگ فوق وجود ندارد یا حذف شده است.'
            ];
        }

        $photos = null;
        if($request->imageUrl != 'undefined'){
            $request->validate([
                'imageUrl' => 'image|max:300|mimes:jpeg,jpg,png',
            ]);
            $date = date('Y-m-d');
            $path = "images/uploads/tags/$id/$date";
            $photos = [$request->imageUrl];
            $photos = UploadService::saveFile($path, $photos);

            if($tag->image){
                UploadService::destroyFile($tag->image);
            }

            $tag->image = $photos;
        }
        
        if($request->actived_at){ $tag->actived_at  = Carbon::now(); }else{ $tag->actived_at  = null; }
        
        if($request->head)              $tag->head  = $request->head;
        if($request->link)              $tag->link  = $request->link;
        if($request->meta_description)  $tag->meta_description  = $request->meta_description;
        if($request->meta_keywords)     $tag->meta_keywords  = $request->meta_keywords;
        if($request->name)              $tag->name  = $request->name;
        if($request->title)             $tag->title  = $request->title;

        if($request->slug) {
            $catSlug = Tag::where('slug', $request->slug)->where('id', '!=', $id)->first();
            if($catSlug){
                return response()->json([
                    'status' => 'error',
                    'errors' => ['slug' => 'این اسلاگ قبلا تعریف شده است.'],
                ], 422);
            }else{
                $tag->slug  = $request->slug;
            }
        }       

        
        $tag->save();

        return [
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ویرایش پیدا کرد.'
        ];
    }

    public function tagsUpdate(Request $request)
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
            Tag::whereIn('id', $request->row)->update([ 
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
            Tag::whereIn('id', $request->row)->update([ 'deleted_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
        }else if($request->type == 'deactive'){
            if(!$request->row){
                return response()->json([
                    'status' => 'warning',
                    'title' => '',
                    'message' => 'لطفا حداقل یک مورد را انتخاب نمایید.'
                ]);
            }
            Tag::whereIn('id', $request->row)->update([ 'actived_at'=> null ]);
        }
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اعمال گردید.'
        ]);
    }

    public function tagDelete (Request $request, $id)
    {
        # code...
        $tagDelete = Tag::where('id',$id)->first();
        if ($tagDelete) {
            $tagDelete->deleted_at = Carbon::now()->format('Y-m-d H:i:s');
            $tagDelete->save();
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
