<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Message;
use App\Models\Price;
use App\Models\Product;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    //
    public function products(Request $request, $status = null)
    {
        # code...
        // title=&code=&status=
        $title = $request->title ?? null;
        $code = $request->code ?? null;
        $seller = $request->seller ?? null;
        // $status = $request->status ?? null;
        
        $products = Product::whereNull('deleted_at')
            
            ->with('price')
            ->when($title, function ($qTitle) use ($title){
                $qTitle->where('name', 'like', "%$title%");
            })
            ->when($code, function ($qCode) use ($code){
                $qCode->where('code', 'like', "%$code%");
            })
            ->when(($status && $status == 'active'), function ($qStatus) use ($status){
                $qStatus->whereNotNull('actived_at')->whereNull('admin_actived_at');
            })
            // ->when(($status && $status == 'deactive'), function ($qStatus) use ($status){
            //     $qStatus->whereNull('actived_at');
            // })
            ->when(($status && $status == 'publish'), function ($qStatus) use ($status){
                $qStatus->whereNotNull('actived_at')->whereNotNull('admin_actived_at');
            })
            ->with('seller')
            ->whereHas('seller', function($qSeller) use($seller) {
                $qSeller->where('name', 'like', "%$seller%")->whereNull('deleted_at');//->whereNotnull('admin_actived_at');
            })
            ->latest('updated_at')
            // ->get();
            ->paginate(30);



        return view('admin.products.list-products', [
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
            ->with(['seller' => function($qUser){ $qUser->with('user'); }])
            ->first();

        if ($slug && !$product) {
            return back();
        }


        $websites = Website::all();
        // return $product;

        return view('admin.products.product', [
            'title' => ($product) ? 'ویرایش محصول ' . $product->name : 'اضافه کردن محصول جدید',
            'slug' => $slug,
            'websites' => $websites,
            'product' => $product,
            'listPrices' => ($product) ? $this->getPrice($product->id) : null,
            'listImages' => ($product) ? $this->getImages($product->id) : null,
            'code' => $seller->code . time(),
            'categories' => $this->getSubCategories(1), // $categories,
        ]);
    }

    public function getSubCategories($col, $parent_id = 0)
    {
        # code...
        $col++;
        $categories = Category::select('id', 'name')
            ->when($parent_id, function ($query) use ($parent_id) {
                $query->where('parent_id', $parent_id);
            })
            ->when(($parent_id == 0 || $parent_id == null), function ($query) use ($parent_id) {
                $query->where('parent_id', $parent_id);
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

    public function getPrice($product_id)
    {
        # code...
        $prices = Price::where([
            // 'user_id' => $user->id,
            // 'seller_id' => $seller->id,
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

    public function ImageProductMain($product_id)
    {
        # code...
        $product = Product::find($product_id);
        
        $images = $product->images->where('default_use', 'MAIN');
        if($images){
            $image = $product->images->first();
            if($image){

                Image::where('id', $image->id)->update([
                    'default_use' => 'MAIN'
                ]);
            }
        }
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
                'admin_actived_at'=> Carbon::now()
            ]);
        }else if($request->type == 'delete'){
            Product::whereIn('id', $request->row)->update([ 'deleted_at'=> Carbon::now()->format('Y-m-d H:i:s') ]);
        }else if($request->type == 'deactive'){
            Product::whereIn('id', $request->row)->update([ 'admin_actived_at'=> null ]);
        }
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اعمال گردید.'
        ]);
    }

    public function productActive(Request $request, $id)
    {
        # code...
        // return $request->all();
        // active_admin: "on"
        // message-seller: ""
        // seller_id: "100"
        // tell_at: "on"

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'message_product' => 'required'
        ]);

        $product = Product::where('id', $request->product_id)->with('seller')->first();

        $product->admin_actived_id = $request->admin_actived_at ? Auth::id() : null;
        $product->admin_actived_at = $request->admin_actived_at ? Carbon::now() : null;
        // $product->call_admin_at = $request->call_admin_at ? Carbon::now() : null;
        
        if(!$request->admin_actived_at){
            $product->actived_at = null;
        }

        $product->save();

        $this->ImageProductMain($product->id);
        
        if($request->websites){
            
            $product->websites()->sync($request->websites);
        }

        if($request->message_product){

            Message::create([
                'user_sender_id'        => Auth::id(),
                'user_receiver_id'      => $product->seller->user_id,
                'user_receiver_type'    => 'seller',
                'status_id'             => '0',
                'title'                 => 'فعال سازی محصول '. $product->name,
                'message'               => $request->message_product,
            ]);
        }
        
        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ثبت گردید.',
        ], 200);

    }
}
