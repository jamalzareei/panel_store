<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Price;
use App\Models\PriceProperty;
use App\Models\Product;
use App\Models\PropertyValue;
use App\Models\Seo;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    //
    public function products(Request $request)
    {
        # code...
        // title=&code=&status=
        $title = $request->title ?? null;
        $code = $request->code ?? null;
        $status = $request->status ?? null;

        $user = Auth::user();

        $seller = $user->seller;
        $products = Product::whereNull('deleted_at')
            ->where('user_id', $user->id)

            ->with('price')
            ->when($title, function ($qTitle) use ($title){
                $qTitle->where('name', 'like', "%$title%");
            })
            ->when($code, function ($qCode) use ($code){
                $qCode->where('code', 'like', "%$code%");
            })
            ->when(($status && $status == 'active'), function ($qStatus) use ($status){
                $qStatus->whereNotNull('actived_at');
            })
            ->when(($status && $status == 'deactive'), function ($qStatus) use ($status){
                $qStatus->whereNull('actived_at');
            })
            ->when(($status && $status == 'publish'), function ($qStatus) use ($status){
                $qStatus->whereNotNull('actived_at')->whereNotNull('admin_actived_at');
            })
            ->latest()
            // ->get();
            ->paginate(10);



        return view('seller.products.list-products', [
            'products' =>  $products
        ]);
        return $products;
    }

    public function product(Request $request, $slug = null)
    {
        # code...
        // $categories = $this->getSubCategories(1);
        $user = Auth::user();

        $seller = $user->seller;
        $productExists = Product::where('slug', $slug)->first();
        $product = Product::where('slug', $slug)
            ->with(['categories' => function ($qCategory) use ($productExists) {
                $qCategory
                    ->whereNull('deleted_at')
                    ->whereNotNull('actived_at')
                    ->select('id', 'name')
                    ->with(['properties' => function ($qProperty) use ($productExists) {
                        $qProperty
                            ->whereNull('deleted_at')
                            ->whereNotNull('actived_at')
                            ->with(['propertyvalue' => function ($qPropertyValue) use ($productExists) {
                                $qPropertyValue->where('product_id', $productExists->id);
                            }])
                            ->select('id', 'category_id', 'name', 'is_price', 'default_list');
                    }]);
            }])
            ->first();

        if ($slug && !$product) {
            return back();
        }


        // return $product;

        return view('seller.products.product', [
            'title' => ($product) ? 'ویرایش محصول ' . $product->name : 'اضافه کردن محصول جدید',
            'slug' => $slug,
            'product' => $product,
            'listPrices' => ($product) ? $this->getPrice($product->id) : null,
            'listImages' => ($product) ? $this->getImages($product->id) : null,
            'code' => $seller->code . time(),
            'categories' => $this->getSubCategories(1), // $categories,
        ]);
    }

    public function productsAddPost(Request $request)
    {
        # code...
        $request->validate([
            'categories.*' => 'required|exists:categories,id',
            'code' => 'required',
            'name' => 'required',
        ]);
        // return $request->all();

        $user = Auth::user();

        $seller = $user->seller;

        $websites_id = $seller->websites->pluck('id')->toArray();

        $product = Product::create([
            "name" => $request->name,
            "code" => $request->code,
            "user_id" => $user->id,
            "seller_id" => $seller->id,
        ]);

        if($websites_id){
            $product->websites()->sync($websites_id);
        }else{
            $product->websites()->sync([]);
        }

        if ($request->categories) {
            # code...
            $product->categories()->sync($request->categories);
        }
        // return $request->categories;
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.',
            'autoRedirect' => route('seller.product.updateorcreate', ['slug' => $product->slug])
        ], 200);
    }

    public function productUpdate(Request $request, $id, $type)
    {
        # code...

        $user = Auth::user();

        $seller = $user->seller;

        $product = Product::where('id', $id)->where('user_id', $user->id)->first();

        if (!$product) {
            # code...
            return response()->json([
                'status' => 'error',
                'title' => '',
                'message' => 'محصول مورد نظر وجود ندارد.',
            ], 200);
        }

        $product->actived_at = null;
        $product->admin_actived_at = null;
        $product->save();

        switch ($type) {
            case 'info':
                # code...
                $request->validate([
                    'categories.*' => 'required|exists:categories,id',
                    // 'id' => 'required|exists:products,id',
                    'code' => 'required',
                    'name' => 'required',
                ]);

                $product->name = $request->name;
                $product->code = $request->code;
                $product->save();

                if ($request->categories) {
                    # code...
                    $product->categories()->sync($request->categories);
                }
                return response()->json([
                    'status' => 'success',
                    'title' => '',
                    'message' => 'با موفقیت اپدیت گردید.',
                    'autoRedirect' => route('seller.product.updateorcreate', ['slug' => $product->slug])
                ], 200);
                break;

            case 'properties':
                # code...
                // return $request->all();
                $request->validate([]);
                if($request->properties){

                    foreach ($request->properties as $key => $property) {
                        # code...
                        if (is_array($property)) {
                            $property = implode(',', $property);
                        }
                        PropertyValue::updateOrCreate([
                            'property_id' => $key,
                            'product_id' => $id,
                        ], [
                            'value' => $property,
                        ]);
                    }
                }
                return response()->json([
                    'status' => 'success',
                    'title' => '',
                    'message' => 'با موفقیت اپدیت گردید.',
                ], 200);
                break;

            case 'gallery':
                # code...
                // return $request->all();
                if ($request->image_file) {
                    $image = new Image();

                    $path_image = UploadService::convertBase64toPng('uploads/product/gallery', $request->image_file);

                    $image->path = $path_image;
                    $image->user_id = $user->id;
                    $image->default_use = 'GALLERY';

                    $image->save();

                    $product->images()->save($image);
                    return response()->json([
                        'status' => 'success',
                        'title' => '',
                        'message' => 'با موفقیت اپدیت گردید.',

                        'dataLoad2' => $this->getImages($id),
                        'gallery' => true
                    ], 200);
                }
                break;

            case 'video':
                # code...
                break;

            case 'price':
                # code...
                $request->validate([
                    'propertyprices.*' => 'required',
                    'amount' => 'required|numeric',
                    'discount' => "required|numeric",
                    'price' => 'required|numeric',
                ]);
                // return $request->all();
                // Price::where(['user_id' => $user->id, 'product_id' => $id])->update(['actived_at' => null]);
                $price = Price::create([
                    'user_id' => $user->id,
                    'seller_id' => $seller->id,
                    'product_id' => $id,
                    'amount' => $request->amount,
                    'old_price' => $request->price,
                    'price' => ($request->price * (100 - $request->discount)) / 100,
                    'discount' => $request->discount,
                    'currency_id' => $seller->country_id,
                    'start_discount_at' => null,
                    'end_discount_at' => null,
                    'actived_at' => Carbon::now(),
                ]);


                if ($request->propertyprices) {
                    foreach ($request->propertyprices as $keyProp => $propertyprice) {
                        # code...
                        PriceProperty::updateOrCreate([
                            'price_id' => $price->id,
                            'product_id' => $id,
                            'property_id' => $keyProp,
                        ], [
                            'value' => $propertyprice,
                        ]);
                    }
                }

                return response()->json([
                    'status' => 'success',
                    'title' => '',
                    'message' => 'با موفقیت اضافه گردید.',
                    'dataLoad' => $this->getPrice($id)
                ], 200);
                break;

            case 'details':
                # code...
                $product->description_small = $request->description_small;
                $product->description_full = $request->description_full;
                $product->save();
                return response()->json([
                    'status' => 'success',
                    'title' => '',
                    'message' => 'با موفقیت اپدیت گردید.',
                ], 200);
                break;

            case 'tags':
                # code...
                $product->tags = $request->tags;
                $product->save();
                return response()->json([
                    'status' => 'success',
                    'title' => '',
                    'message' => 'با موفقیت اپدیت گردید.',
                ], 200);
                break;

            case 'seo':
                # code...
                $seo = new Seo();
                if ($product->seo) {
                    $seo = $product->seo;
                }
                // return $product->seo;
                $seo->head = $request->head;
                $seo->title = $request->title;
                $seo->meta_description = $request->meta_description;
                $seo->meta_keywords = $request->meta_keywords;
                $seo->save();

                $product->seo()->save($seo);
                // $product->seo()->associate($seo);
                // $product->seo()->associate($seo);
                return response()->json([
                    'status' => 'success',
                    'title' => '',
                    'message' => 'با موفقیت اپدیت گردید.',
                ], 200);
                break;

            default:
                # code...
                return response()->json([
                    'status' => 'info',
                    'title' => '',
                    'message' => 'گزینه ای وجود ندارد.',
                ], 200);
                break;
        }
    }

    public function productUpdateStatus (Request $request, $id)
    {
        # code...
        // return $request->all();
        // $actived_at = $request->status ? Carbon::now() : null;
        $product = Product::where('id', $id)->update([
            'actived_at' => ($request->status == 'true') ? Carbon::now() : null
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اپدیت گردید.'
        ], 200);
    }

    public function productsUpdate (Request $request)
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
            Product::whereIn('id', $request->row)->update([
                'deleted_at'=> null,
                'actived_at'=> Carbon::now()
            ]);
        }else if($request->type == 'delete'){
            Product::whereIn('id', $request->row)->update([ 'deleted_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
        }else if($request->type == 'deactive'){
            Product::whereIn('id', $request->row)->update([ 'actived_at'=> null ]);
        }
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اعمال گردید.'
        ]);
    }

    public function getPrice($product_id)
    {
        $user = Auth::user();

        $seller = $user->seller;
        # code...
        $prices = Price::where([
            'user_id' => $user->id,
            'seller_id' => $seller->id,
            'product_id' => $product_id,
        ])
            ->with(['priceproperties' => function ($qPeroperty) {
                $qPeroperty->select('id', 'price_id', 'value', 'property_id')
                    ->with(['property' => function ($perops) {
                        $perops->select('id', 'name');
                    }]);
            }])
            ->get();


        return view('components.products.prices', [
            'prices' => $prices
        ])->render();
        return $prices;
    }

    public function priceUpdateStatus(Request $request, $id)
    {
        # code...
        $price = Price::where('id', $id)->update([
            'actived_at' => ($request->status == 'true') ? Carbon::now() : null
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اپدیت گردید.'
        ], 200);
    }

    public function getImages($product_id)
    {
        $user = Auth::user();

        $seller = $user->seller;

        $product = Product::find($product_id);

        $images = $product->images;

        return view('components.products.images', [
            'images' => $images
        ])->render();
        return $images;
    }

    public function imageUpdateStatus(Request $request, $id)
    {
        # code...
        $image = Image::where('id', $id)->update([
            'default_use' => ($request->status == 'true') ? 'MAIN' : 'GALLERY'
        ]);

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اپدیت گردید.'
        ], 200);
    }

    public function imageProductDelete(Request $request, $id)
    {
        # code...
        $image = Image::where('id', $id)->first();
        if ($image) {
            $image->deleted_at = Carbon::now()->format('Y-m-d H:i:s');
            $image->save();
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

    public function getSubCategories($col, $parent_id = 0)
    {
        # code...

        $user = Auth::user();

        $seller = $user->seller;
        $websites_id = $seller->websites->pluck('id')->toArray();

        $col++;
        $categories = Category::select('id', 'name')
            ->when($parent_id, function ($query) use ($parent_id) {
                $query->where('parent_id', $parent_id);
            })
            ->when(($parent_id == 0 || $parent_id == null), function ($query) use ($parent_id) {
                $query->where('parent_id', $parent_id);
            })
            ->with('websites')
            ->whereHas('websites', function($query) use($websites_id){
                $query->whereIn('website_id', $websites_id);
            })
            ->whereNull('deleted_at')
            ->whereNotNull('actived_at')
            ->withCount('children')
            ->get();

        return view('components.products.load-categories', [
            'categories' => $categories,
            'col' => $col,
        ])->render();
        return $categories;
    }

    public function productSendAdmin(Request $request, $id)
    {
        # code...
        $user = Auth::user();

        $seller = $user->seller;

        $product = Product::where(['id' => $id, 'user_id' => $user->id])->first();
        if (!$user || !$seller || !$product) {
            if (!$seller) {
                return view('components.not-perrmission', [
                    'title' => 'محصول یافت نشد',
                    'message' => 'شما میتوانید محصول جدید اضافه نمایید.',
                    'linkRedirect' => route('seller.product.updateorcreate'),
                    'textRedirect' => 'اضافه کردن محصول',
                ]);
            }
        }

        $product->actived_at = Carbon::now();
        $product->admin_actived_at = null;
        $product->save();

        session()->put('noty', [
            'title' => '',
            'message' => 'با موفقیت ارسال گردید. لطفا دقت نمایید پس از ویرایش اطلاعات محصول برای تایید مجدد مدیریت ارسال میگردد.',
            'status' => 'success',
            'data' => '',
        ]);

        return back();
    }
}
