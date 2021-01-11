<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Property;
use App\Models\Seo;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    //
    public function properties(Request $request, $category_id = null)
    {
        # code...
        $category = Category::where('id', $category_id)->first();

        $properties = Property::whereNull('deleted_at')
            ->when($category_id, function($query) use ($category_id){
                $query->whereHas('categories', function ($queryCat) use ($category_id) {
                    $queryCat->where('category_id', $category_id);
                });
            })
            // ->when($category_id, function ($query) use ($category_id) {
            //     $query->where('category_id', $category_id);
            // })
            // ->with('category')
            ->orderBy('id', 'desc');

        if ($category_id) {
            $properties = $properties->get();
        } else {
            $properties = $properties->paginate(10);
        }


        // $categories = Category::whereNull('deleted_at')->where('properties_active', 1)->get();
        $categories = Category::whereNull('deleted_at')
            ->with([
                'parent' => function ($query) {
                    $query->with([
                        'parent' => function ($query) {
                            $query->with([
                                'parent' => function ($query) {
                                    $query->with('parent');
                                }
                            ]);
                        }
                    ]);
                }
            ])->get();

        // return $properties;

        return view('admin.properties.list-properties', [
            'category_id' => $category_id,
            'properties' => $properties,
            'categories' => $categories,
            'title' => ($category) ? 'لیست پراپرتی های ' . $category->name : 'لیست همه پراپرتی ها',
        ]);
    }


    public function propertyInsert(Request $request)
    {
        # code...
        // return $request->all();
        $request->validate([
            'category_id' =>  'nullable|exists:categories,id',
            'order_by' =>  'required|numeric',
            'name' =>  'required|string',
        ]);

        $property = Property::create([
            // 'category_id'   =>  $request->category_id,
            'order_by'      =>  $request->order_by,
            'name'          =>  $request->name,
            'actived_at'     => ($request->actived_at) ? Carbon::now() : null,
            'is_filter'     => ($request->is_filter) ? 1 : 0,
        ]);

        $property = Property::where('id', $property->id)->first(); // ;

        if ($request->category_id) {
            $property->categories()->sync([$request->category_id]);
        }
        session()->put('noty', [
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.',
            'data' => '',
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.',
            'autoRedirect' => route('admin.property.edit', ['slug' => $property->slug])
        ], 200);
    }

    public function propertyEdit(Request $request, $slug = null)
    {
        # code...
        $property = Property::where('slug', $slug)->with('categories')->first();

        $categories = Category::whereNull('deleted_at')->where('properties_active', 1)
            ->with([
                'parent' => function ($query) {
                    $query->with([
                        'parent' => function ($query) {
                            $query->with([
                                'parent' => function ($query) {
                                    $query->with('parent');
                                }
                            ]);
                        }
                    ]);
                }
            ])->get();

        // return $categories; //->categories->where('id', 2)->count();
        if (!$property) {
            abort(404);
        }

        return view('admin.properties.update-or-insert-property', [
            'title' => $property ? 'ویرایش پراپرتی ' . $property->name . '' : 'اضافه کردن پراپرتی',
            'property' => $property,
            'categories' => $categories,
        ]);
    }

    public function propertyUpdate(Request $request, $id)
    {
        # code...
        // return $request->all();
        $property = Property::where('id', $id)->first();

        if (!$property) {
            return [
                'status' => 'error',
                'title' => '',
                'message' => 'دسته بندی فوق وجود ندارد یا حذف شده است.'
            ];
        }

        $photos = null;
        if ($request->imageUrl != 'undefined') {
            $request->validate([
                'imageUrl' => 'image|max:300|mimes:jpeg,jpg,png',
            ]);
            $date = date('Y-m-d');
            $path = "images/uploads/properties/$id/$date";
            $photos = [$request->imageUrl];
            $photos = UploadService::saveFile($path, $photos);

            if ($property->image) {
                UploadService::destroyFile($property->image);
            }

            $property->image = $photos;
        }

        if ($request->actived_at) {
            $property->actived_at  = Carbon::now();
        } else {
            $property->actived_at  = null;
        }

        // if($request->head)              $property->head  = $request->head;
        // if($request->link)              $property->link  = $request->link;
        // if($request->meta_description)  $property->meta_description  = $request->meta_description;
        // if($request->meta_keywords)     $property->meta_keywords  = $request->meta_keywords;
        if ($request->name)              $property->name  = $request->name;
        // if($request->description_short) $property->description_short  = $request->description_short;
        // if($request->description_full)  $property->description_full  = $request->description_full;

        if ($request->default_list) $property->default_list  = $request->default_list;
        if ($request->filter_list)  $property->filter_list  = $request->filter_list;

        if ($request->is_filter) {
            $property->is_filter  = 1;
        } else {
            $property->is_filter  = 0;
        }
        if ($request->is_show_less) {
            $property->is_show_less  = 1;
        } else {
            $property->is_show_less  = 0;
        }
        if ($request->is_price) {
            $property->is_price  = 1;
        } else {
            $property->is_price  = 0;
        }

        if ($request->slug) {
            $catSlug = property::where('slug', $request->slug)->where('id', '!=', $id)->first();
            if ($catSlug) {
                return response()->json([
                    'status' => 'error',
                    'errors' => ['slug' => 'این اسلاگ قبلا تعریف شده است.'],
                ], 422);
            } else {
                $property->slug  = $request->slug;
            }
        }

        // if($request->title)             $property->title  = $request->title;

        $property->save();

        // if($request->categories){
        $property->categories()->sync($request->categories);
        // }


        $seo = new Seo();
        if ($property->seo) {
            $seo = $property->seo;
        }
        // return $property->seo;
        if ($request->head)              $seo->head = $request->head;
        if ($request->title)             $seo->title = $request->title;
        if ($request->meta_description)  $seo->meta_description = $request->meta_description;
        if ($request->meta_keywords)     $seo->meta_keywords = $request->meta_keywords;
        $seo->save();
        $property->seo()->save($seo);


        return [
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ویرایش پیدا کرد.'
        ];
    }

    public function propertyUpdateStatus(Request $request, $id)
    {
        # code...
        // return $request->all();

        $property = Property::where('id', $id)->update([
            'actived_at' => ($request->status == 'true') ? Carbon::now() : null
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اپدیت گردید.'
        ], 200);
    }


    public function propertiesUpdate(Request $request)
    {
        # code...
        // return $request->all();

        if ($request->type == 'active') {
            if (!$request->row) {
                return response()->json([
                    'status' => 'warning',
                    'title' => '',
                    'message' => 'لطفا حداقل یک مورد را انتخاب نمایید.'
                ]);
            }
            Property::whereIn('id', $request->row)->update([
                'deleted_at' => null,
                'actived_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        } else if ($request->type == 'delete') {
            if (!$request->row) {
                return response()->json([
                    'status' => 'warning',
                    'title' => '',
                    'message' => 'لطفا حداقل یک مورد را انتخاب نمایید.'
                ]);
            }
            Property::whereIn('id', $request->row)->update(['deleted_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        } else if ($request->type == 'deactive') {
            if (!$request->row) {
                return response()->json([
                    'status' => 'warning',
                    'title' => '',
                    'message' => 'لطفا حداقل یک مورد را انتخاب نمایید.'
                ]);
            }
            Property::whereIn('id', $request->row)->update(['actived_at' => null]);
        } else if ($request->type == 'update') {
            foreach ($request->ids as $key => $value) {
                # code...
                Property::where('id', $value)->update([
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

    public function propertyDelete(Request $request, $id)
    {
        # code...
        $propertyDelete = Property::where('id', $id)->first();
        if ($propertyDelete) {
            $propertyDelete->deleted_at = Carbon::now()->format('Y-m-d H:i:s');
            $propertyDelete->save();
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
