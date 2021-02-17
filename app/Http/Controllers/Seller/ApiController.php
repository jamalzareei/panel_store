<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Price;
use App\Models\Product;
use App\Models\Seller;
use App\Models\SellerSocial;
use App\Models\Seo;
use App\Services\UploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    //

    public function readInstagram(Request $request, $username_ = null)
    {
        # code...
        $user = Auth::user();
        $seller = Seller::where('user_id', $user->id)->first();

        if (!$seller) {
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
        $social = SellerSocial::whereNull('deleted_at')
            ->where('seller_id', $seller->id)
            ->whereHas('social', function ($query) {
                $query->where('name', 'اینستاگرام');
            })
            ->first();


        $username = null;

        if ($social) {
            $username = $social->username;
        }

        if ($username_) {
            $username = $username_;
        }

        if (!$username) {
            return response()->view('components.not-perrmission', [
                'title' => 'تکمیل اطلاعات فروشنده',
                'message' => '<br>
                شما اجازه دسترسی به این بخش را ندارید.
                <br>
                <br>
                لطفا ابتدا نسبت به تکمیل اطلاعات شبکه های اجتماعی (اینستاگرام) فروشگاه خود اقدام نمایید.
                <br>
                در صورتی که اطلاعات خود را ثبت کرده اید جهت تسریع در روند ثبت اطلاعات با پشتیبانی تماس حاصل فرمایید.',
                'linkRedirect' => route('seller.socials.get'),
                'textRedirect' => 'تکمیل اطلاعات فروشنده',
            ]);
        }
        $first = 50;
        $after = $request->after ?? '';

        $userIdInstagram = null;
        $infoUserInstagram = null;

        if($social->details && !$username_){

            $infoUserInstagram = json_decode($social->details, true);
            $userIdInstagram = $infoUserInstagram["users"][0]["user"]["pk"] ?? null;
        }
        // return $userIdInstagram;

        if( !$userIdInstagram ){

            $infoUserInstagram = $this->getInfoUserInstagram($username);
    
            $social->details = $infoUserInstagram;
            $social->save();


            $userIdInstagram = $infoUserInstagram["users"][0]["user"]["pk"] ?? null;
        }
        if (!$userIdInstagram) {
            return response()->view('components.not-perrmission', [
                'title' => 'شما اجازه دسترسی به این بخش را ندارید.',
                'message' => '<br>
                شما اجازه دسترسی به این بخش را ندارید.
                <br>
                در صورتی که اطلاعات خود را ثبت کرده اید جهت تسریع در روند ثبت اطلاعات با پشتیبانی تماس حاصل فرمایید.',
                'linkRedirect' => route('user.messages'),
                'textRedirect' => 'ارسال پیام به پشتیبانی',
            ]);
        }

        $response = $this->getPostsUserInstagram($userIdInstagram, $first, $after);
        if (!$response || count($response) == 0) {
            return response()->view('components.not-perrmission', [
                'title' => 'شما اجازه دسترسی به این بخش را ندارید.',
                'message' => '<br>
                شما اجازه دسترسی به این بخش را ندارید.
                <br>
                در صورتی که اطلاعات خود را ثبت کرده اید جهت تسریع در روند ثبت اطلاعات با پشتیبانی تماس حاصل فرمایید.',
                'linkRedirect' => route('user.messages'),
                'textRedirect' => 'ارسال پیام به پشتیبانی',
            ]);
        }
        $data = $this->jsonInstagramTOJSON($response);

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

        $productArrayShortCodes = Product::where('user_id', $user->id)->where('seller_id', $seller->id)->whereNotNull('shorcode_external')->pluck('shorcode_external')->toArray();

        return view('seller.instagram.update-contect', [
            'posts' => $data,
            'categories' => $categories,
            'infoUserInstagram' => $infoUserInstagram,
            'productArrayShortCodes' => $productArrayShortCodes
        ]);

        $data = Http::get(config('shixeh.cdn_domain_files') . "instagram/pages/jamal.json");

        return view('seller.instagram.update-contect', [
            'posts' => $data->json()['posts'],
            'categories' => $categories,
            'infoUserInstagram' => $data->json()['infoUserInstagram'],
            'productArrayShortCodes' => $productArrayShortCodes
        ]);

        return $data->json();
    }

    public function postInstagramSave(Request $request)
    {
        # code...

        // return UploadService::saveImageFromURL('uploads/product/gallery/', $request['image'][0]);
        // return $request;
        // $request->validate([
        //     'category' => 'required',
        //     'name' => 'required',
        // ]);
        if (!$request->category) {
            return response()->json([
                'status' => 'error',
                'title' => '',
                'message' => 'دسته بندی محصول را انتخاب نمایید',
            ], 202);
        }

        if (!$request->name || strlen($request->name) < 5) {
            return response()->json([
                'status' => 'error',
                'title' => '',
                'message' => 'نام انتخاب شده باید بزرگتر از 5 کاراکتر باشد',
            ], 202);
        }

        $user = Auth::user();

        $seller = $user->seller;

        $productOld = Product::whereNull('deleted_at')
            ->where('shorcode_external', $request->shortcode)
            ->where('user_id', $user->id)
            ->where('seller_id', $seller->id)
            ->first();

        if ($productOld) {
            return response()->json([
                'status' => 'error',
                'title' => '',
                'message' => 'شما قبلا این محصول را ثبت کرده اید.',
            ], 202);
        }

        $product = Product::updateOrCreate([
            'shorcode_external' => $request->shortcode,
            "user_id" => $user->id,
            "seller_id" => $seller->id,
        ], [
            "name" => $request->name,
            "code" => $seller->code . time(),
            "description_full" => str_replace('\n', '<br>', $request->description),
            "actived_at" => Carbon::now(),
            "admin_actived_at" => null
        ]);

        $seo = new Seo();
        if ($product->seo) {
            $seo = $product->seo;
        }
        // return $product->seo;
        $seo->head = $request->name;
        $seo->title = $request->name;
        $seo->meta_description = $request->description;
        $seo->meta_keywords = '';
        $seo->save();

        $product->seo()->save($seo);

        $categories = [];
        if ($request->category) {
            array_push($categories, (int)($request->category));
            $cat1 = Category::where('id', $request->category)->first();
            if ($cat1 && $cat1->parent_id) {
                array_push($categories, $cat1->parent_id);
                $cat2 = Category::where('id', $cat1->parent_id)->first();
                if ($cat2 && $cat2->parent_id) {
                    array_push($categories, $cat2->parent_id);
                    $cat3 = Category::where('id', $cat2->parent_id)->first();
                    if ($cat3 && $cat3->parent_id) {
                        array_push($categories, $cat3->parent_id);
                        $cat4 = Category::where('id', $cat3->parent_id)->first();
                        if ($cat4 && $cat4->parent_id) {
                            array_push($categories, $cat4->parent_id);
                        }
                    }
                }
            }
            sort($categories);

            // return  ($categories); 

            if ($categories) {
                # code...
                $product->categories()->sync($categories);
            }
        }

        if ($request->price) {
            $price = Price::create([
                'user_id' => $user->id,
                'seller_id' => $seller->id,
                'product_id' => $product->id,
                'amount' => 10,
                'old_price' => $request->price,
                'price' => $request->price,
                'discount' => 0,
                'currency_id' => 1,
                'start_discount_at' => null,
                'end_discount_at' => null,
                'actived_at' => Carbon::now(),
            ]);
        }

        if ($request->image && !$productOld) {
            foreach ($request->image as $key => $image) {
                // return $image;
                if ($image) {
                    $path_image = UploadService::saveImageFromURL('uploads/product/gallery/', $image);

                    if ($path_image) {
                        $image = new Image();
                        $image->path = $path_image;
                        $image->user_id = $user->id;
                        $image->default_use = 'GALLERY';

                        $image->save();

                        $product->images()->save($image);
                    }
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت ذخیره گردید.',
        ], 200);
    }

    public function getInfoUserInstagram($username)
    {
        $url = "https://instagram40.p.rapidapi.com/proxy?url=https://www.instagram.com/web/search/topsearch/?query=$username";
        return $json = $this->requestCurl($url);
        $userIdInstagram = $json["users"][0]["user"]["pk"] ?? null;
        return $userIdInstagram;
    }

    public function getPostsUserInstagram($userInstagram_id, $first, $after)
    {
        $url = "https://instagram40.p.rapidapi.com/proxy?url=https%3A%2F%2Fwww.instagram.com%2Fgraphql%2Fquery%2F%3Fquery_hash%3De769aa130647d2354c40ea6a439bfc08%26variables%3D%257B%2522id%2522%253A%2522$userInstagram_id%2522%252C%2522first%2522%253A%2522$first%2522%252C%2522after%2522%253A%2522$after%2522%257D";

        // $url = 'https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables={"id":"'.$userInstagram_id.'","first":'.$first.',"after":'.$after.'}';
        return $this->requestCurl($url);
    }

    public function requestCurl($url)
    {
        $rapidAPI = config('shixeh.rapidapi');
        $response = Http::withHeaders([
            "x-rapidapi-host: instagram40.p.rapidapi.com",
            "x-rapidapi-key: $rapidAPI"
        ])
            ->timeout(30)
            ->get("$url&rapidapi-key=$rapidAPI");
        return $response->json();

        // # code...        
        // $curl = curl_init();
        // curl_setopt_array($curl, [
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => [
        //         "x-rapidapi-host: instagram40.p.rapidapi.com",
        //         "x-rapidapi-key: $rapidAPI"
        //     ],
        // ]);

        // $response = curl_exec($curl);
        // $err = curl_error($curl);

        // curl_close($curl);

        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     return json_decode($response, true);
        // }
        // return;
    }

    public function jsonInstagramTOJSON($response)
    {
        # code...
        $jsonData = $response['data']['user']['edge_owner_to_timeline_media']['edges'] ?? null;
        $data = [];
        $data['end_cursor'] = $response['data']['user']['edge_owner_to_timeline_media']['page_info']['end_cursor'] ?? null;
        $data['count_post'] = $response['data']['user']['edge_owner_to_timeline_media']['count'] ?? null;
        foreach ($jsonData as $key => $edge) {
            # code...
            if (!$edge['node']['is_video']) {

                $data[$key]['image'] = $edge['node']['display_url']; //['thumbnail_src'];//['display_url'];

                // sleep(0.1);
                // UploadService::saveImageFromURL('instagram/'.$edge['node']['shortcode'].'/', $data[$key]['image']);

                $data[$key]['caption'] = $edge['node']['edge_media_to_caption']['edges'][0]['node']['text'];
                $data[$key]['shortcode'] = $edge['node']['shortcode'];
                $data[$key]['is_video'] = $edge['node']['is_video'];

                if ($edge['node'] && isset($edge['node']['edge_sidecar_to_children']) && $edge['node']['edge_sidecar_to_children']['edges']) {

                    foreach ($edge['node']['edge_sidecar_to_children']['edges'] as $index => $edgeNew) {
                        # code...
                        $data[$key]['edge_sidecar_to_children'][] = $edgeNew['node']['display_url'];

                        // sleep(0.1);
                        // UploadService::saveImageFromURL('instagram/'.$edge['node']['shortcode'].'/', $edgeNew['node']['display_url']);
                    }
                }
            }
        }

        return $data;
    }

    public function connectToInstagram(Request $request)
    {
        # code...
        $user = Auth::user();
        $seller = Seller::where('user_id', $user->id)->first();

        $social = SellerSocial::whereNull('deleted_at')
            ->where('seller_id', $seller->id)
            ->whereHas('social', function ($query) {
                $query->where('name', 'اینستاگرام');
            })
            ->first();


        $username = $social->username;

        return view('seller.instagram.read-contect', [
            'username' => $username
        ]);
    }

    public function readInstagram_1399_11_25(Request $request)
    {


        $page = $request->page ?? 1;
        $user = Auth::user();

        $seller = Seller::where('user_id', $user->id)->first();

        if (!$seller) {
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
        $social = SellerSocial::whereNull('deleted_at')
            ->where('seller_id', $seller->id)
            ->whereHas('social', function ($query) {
                $query->where('name', 'اینستاگرام');
            })
            ->first();




        if (!$social) {
            return response()->view('components.not-perrmission', [
                'title' => 'تکمیل اطلاعات فروشنده',
                'message' => '<br>
                شما اجازه دسترسی به این بخش را ندارید.
                <br>
                <br>
                لطفا ابتدا نسبت به تکمیل اطلاعات شبکه های اجتماعی (اینستاگرام) فروشگاه خود اقدام نمایید.
                <br>
                در صورتی که اطلاعات خود را ثبت کرده اید جهت تسریع در روند ثبت اطلاعات با پشتیبانی تماس حاصل فرمایید.',
                'linkRedirect' => route('seller.socials.get'),
                'textRedirect' => 'تکمیل اطلاعات فروشنده',
            ]);
        }

        // return $social;
        $instaUsername = $social->username;

        $dir = config('shixeh.path_upload_files') . "instagram/pages/$instaUsername";
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if (strpos($file, $instaUsername) !== false) {
                        echo "filename: ." . $file . "<br />";
                    }
                }
                closedir($dh);
            }
        }
        // return ;

        $response = Http::get(config('shixeh.cdn_domain_files') . "instagram/pages/$instaUsername/$instaUsername-$page.json");

        // return $response->json();
        $jsonData = $response->json()['data']['user']['edge_owner_to_timeline_media']['edges'] ?? null;
        if (!$jsonData || count($jsonData) == 0) {
            return response()->view('components.not-perrmission', [
                'title' => 'اطلاعات شما تکمیل نشده است',
                'message' => '<br>
                شما اجازه دسترسی به این بخش را ندارید.
                <br>
                در صورتی که اطلاعات خود را ثبت کرده اید جهت تسریع در روند ثبت اطلاعات با پشتیبانی تماس حاصل فرمایید.',
                'linkRedirect' => route('user.messages'),
                'textRedirect' => 'ارسال پیام به پشتیبانی',
            ]);
        }
        $data = [];
        foreach ($jsonData as $key => $edge) {
            # code...
            $data[$key]['image'] = $edge['node']['display_url']; //['thumbnail_src'];//['display_url'];

            // sleep(0.1);
            // UploadService::saveImageFromURL('instagram/'.$edge['node']['shortcode'].'/', $data[$key]['image']);

            $data[$key]['caption'] = $edge['node']['edge_media_to_caption']['edges'][0]['node']['text'];
            $data[$key]['shortcode'] = $edge['node']['shortcode'];
            $data[$key]['is_video'] = $edge['node']['is_video'];

            if ($edge['node'] && isset($edge['node']['edge_sidecar_to_children']) && $edge['node']['edge_sidecar_to_children']['edges']) {

                foreach ($edge['node']['edge_sidecar_to_children']['edges'] as $key => $edgeNew) {
                    # code...
                    $data[$key]['edge_sidecar_to_children'][] = $edgeNew['node']['display_url'];

                    // sleep(0.1);
                    // UploadService::saveImageFromURL('instagram/'.$edge['node']['shortcode'].'/', $edgeNew['node']['display_url']);
                }
            }
        }

        return view('seller.instagram.update-contect', [
            'posts' => $data
        ]);
        return $data; // $json = $response->json()['data']['user']['edge_owner_to_timeline_media']['edges'] ?? null;
        return view('seller.instagram.read-contect');
    }
    public function readInstagramUsername(Request $requerst)
    {
        # code...
        $requerst->validate([
            'username' => 'required'
        ]);

        return redirect()->route('seller.read.instragram', ['username' => $requerst->username]);


        $username = $requerst->username;
        // return UploadService::saveImageFromURL('instagram/images/', 'https://scontent-lhr8-1.cdninstagram.com/v/t51.2885-15/sh0.08/e35/c0.66.1024.1024a/s640x640/135025680_111190014206133_635544462823196958_n.jpg?_nc_ht=scontent-lhr8-1.cdninstagram.com&_nc_cat=109&_nc_ohc=duUpuCI09LAAX-Aaz5E&tp=1&oh=04eec58c6c1ede387ba60fedffa279ac&oe=603B93A5');

        $response = Http::get(config('shixeh.cdn_domain_files') . "instagram/pages/$username.json");

        if (!$response->successful()) {
            // Do something ...            
            $res = UploadService::saveJsonFromURL('instagram/pages/', "https://www.instagram.com/$username/?__a=1", $username);
            if ($res === 'error') {
                return;
            }
            sleep(0.1);
            $response = Http::get(config('shixeh.cdn_domain_files') . "instagram/pages/$username.json");
        }

        // $response = Http::get('https://www.instagram.com/shixehcom/?__a=1');
        // $response = Http::get('https://www.instagram.com/%s/media', 'shixehcom');
        // return $response->json();//->json();//['graphql']['user'];//['edge_owner_to_timeline_media'];

        if (!$response->json()) {
            return 'بعدا تلاش نمایید.';
        }
        $data = [];
        foreach ($response->json()['graphql']['user']['edge_owner_to_timeline_media']['edges'] as $key => $edge) {
            # code...
            $data[$key]['image'] = $edge['node']['display_url']; //['thumbnail_src'];//['display_url'];

            // sleep(0.1);
            // UploadService::saveImageFromURL('instagram/'.$edge['node']['shortcode'].'/', $data[$key]['image']);

            $data[$key]['caption'] = $edge['node']['edge_media_to_caption']['edges'][0]['node']['text'];
            $data[$key]['shortcode'] = $edge['node']['shortcode'];
            $data[$key]['is_video'] = $edge['node']['is_video'];

            if ($edge['node'] && isset($edge['node']['edge_sidecar_to_children']) && $edge['node']['edge_sidecar_to_children']['edges']) {

                foreach ($edge['node']['edge_sidecar_to_children']['edges'] as $key => $edgeNew) {
                    # code...
                    $data[$key]['edge_sidecar_to_children'][] = $edgeNew['node']['display_url'];

                    // sleep(0.1);
                    // UploadService::saveImageFromURL('instagram/'.$edge['node']['shortcode'].'/', $edgeNew['node']['display_url']);
                }
            }
        }


        return view('seller.instagram.update-contect', [
            'posts' => $data
        ]);

        return $data;
    }

    public function readInstagramUsernameV2(Request $requerst, $username_ = null)
    {
        $user = Auth::user();
        $seller = Seller::where('user_id', $user->id)->first();

        if (!$seller) {
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
        $social = SellerSocial::whereNull('deleted_at')
            ->where('seller_id', $seller->id)
            ->whereHas('social', function ($query) {
                $query->where('name', 'اینستاگرام');
            })
            ->first();


        $username = null;

        if ($social) {
            $username = $social->username;
        }

        if ($username_) {
            $username = $username_;
        }

        if (!$username) {
            return response()->view('components.not-perrmission', [
                'title' => 'تکمیل اطلاعات فروشنده',
                'message' => '<br>
                شما اجازه دسترسی به این بخش را ندارید.
                <br>
                <br>
                لطفا ابتدا نسبت به تکمیل اطلاعات شبکه های اجتماعی (اینستاگرام) فروشگاه خود اقدام نمایید.
                <br>
                در صورتی که اطلاعات خود را ثبت کرده اید جهت تسریع در روند ثبت اطلاعات با پشتیبانی تماس حاصل فرمایید.',
                'linkRedirect' => route('seller.socials.get'),
                'textRedirect' => 'تکمیل اطلاعات فروشنده',
            ]);
        }

        $dir = config('shixeh.path_upload_files')."instagram/pages/$username/";
        $arrayFiels = [];
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file == '.' || $file == '..') {
                        continue;
                    }
                    $arrayFiels[] ="instagram/pages/$username/$file";
                }
                closedir($dh);
            }
        }

        $page = $requerst->page ?? 1;
        $dataUserContent = file_get_contents(config('shixeh.cdn_domain_files').$arrayFiels[$page - 1]);

        
        
        $json = json_decode($dataUserContent, true);//$arrayFiels;
        $data = $this->jsonInstagramTOJSON($json);
        // return $data;
        
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

        $productArrayShortCodes = Product::where('user_id', $user->id)->where('seller_id', $seller->id)->whereNotNull('shorcode_external')->pluck('shorcode_external')->toArray();

        return view('seller.instagram.update-contect', [
            'posts' => $data,
            'categories' => $categories,
            // 'infoUserInstagram' => $infoUserInstagram,
            'productArrayShortCodes' => $productArrayShortCodes
        ]);
        // $response = Http::get("https://www.instagram.com/web/search/topsearch/?query=$username");
        $dataUserContent = file_get_contents("https://www.instagram.com/web/search/topsearch/?query=$username");
        $dataUserJson = json_decode($dataUserContent, true);
        return $dataUserJson; //->json();
    }

    public function package(Request $request)
    {
        # code...
        // $instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client(['proxy' => 'tcp://localhost:8125']));
        // // Request with proxy
        // $account = $instagram->getAccount('kevin');
        // \InstagramScraper\Instagram::setHttpClient(new \GuzzleHttp\Client());
        // // Request without proxy
        // $account = $instagram->getAccount('kevin');
        // return;

        // $instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client());

        // // If account is private and you subscribed to it, first login
        // $instagram = \InstagramScraper\Instagram::withCredentials(new \GuzzleHttp\Client(), 'shixehcom', '1430548@jamal', new Psr16Adapter('Files'));
        // $instagram->login();

        // return $media = $instagram->getMediaByUrl('https://www.instagram.com/p/BHaRdodBouH');

        // $instagram = new \InstagramScraper\Instagram();

        // // For getting information about account you don't need to auth:

        // $account = $instagram->getAccount('neymarjr'); 
        // return;

        // $instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client());
        // $nonPrivateAccountMedias = $instagram->getMedias('shixehcom');
        // echo $nonPrivateAccountMedias[0]->getLink();
        // return config('shixeh.rapidapi');

        // $content = Http::get('https://www.instagram.com/shixehcom/?__a=1');

        $url     = sprintf("https://www.instagram.com/shixehcom?page=2");
        $content = file_get_contents($url);
        $content = explode("window._sharedData = ", $content)[1];
        $content = explode(";</script>", $content)[0];
        $data    = json_decode($content, true);
        return $data['entry_data']; //['ProfilePage'][0];

        // $instagram = new \InstagramScraper\Instagram();
        // $instagram->setRapidApiKey('$rapidAPI');
        // $nonPrivateAccountMedias = $instagram->getMedias('shixehcom');
        // echo $nonPrivateAccountMedias[0]->getLink();

        // return;


        $account = (new \InstagramScraper\Instagram(new \GuzzleHttp\Client()))->getAccountById('3');

        // Available fields
        echo "Account info:\n";
        echo "Id: {$account->getId()}\n";
        echo "Username: {$account->getUsername()}\n";
        echo "Full name: {$account->getFullName()}\n";
        echo "Biography: {$account->getBiography()}\n";
        echo "Profile picture url: {$account->getProfilePicUrl()}\n";
        echo "External link: {$account->getExternalUrl()}\n";
        echo "Number of published posts: {$account->getMediaCount()}\n";
        echo "Number of followers: {$account->getFollowedByCount()}\n";
        echo "Number of follows: {$account->getFollowsCount()}\n";
        echo "Is private: {$account->isPrivate()}\n";
        echo "Is verified: {$account->isVerified()}\n";
    }
}


/*
page 1:
https://www.instagram.com/cerampakhsh/?__a=1

page 2:
https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables=%7B%22id%22%3A%228666935289%22%2C%22first%22%3A12%2C%22after%22%3A%22QVFBeFBVaUlkVHNyTzNDNTIxV0NGN0VrZkJ0Y09ZM2xVZHM2YjNpU2otSnBrN2p1Umh4b3FXUjJPOHV0R1ZPNF9zYjJPSm5hdE1teURTQjhPcEZQTi05OA%3D%3D%22%7D
{
    "id":"8666935289",
    "first":12,
    "after":"QVFBeFBVaUlkVHNyTzNDNTIxV0NGN0VrZkJ0Y09ZM2xVZHM2YjNpU2otSnBrN2p1Umh4b3FXUjJPOHV0R1ZPNF9zYjJPSm5hdE1teURTQjhPcEZQTi05OA=="
}
"end_cursor": "QVFCTkg4UkpYY0VYVlU2Z2FKS3FCYXZLRmhjMF9TcUFNd2RTSUpDVUFJQU1feFhSMGFEaWVLakRzd1BuX3lVVTlIR2ZzTVl6Njk4VkptellCQzlLTjFDTQ=="
https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables={"id":"8666935289","first":1000,"after":"QVFBeFBVaUlkVHNyTzNDNTIxV0NGN0VrZkJ0Y09ZM2xVZHM2YjNpU2otSnBrN2p1Umh4b3FXUjJPOHV0R1ZPNF9zYjJPSm5hdE1teURTQjhPcEZQTi05OA=="}

page 3
https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables=%7B%22id%22%3A%228666935289%22%2C%22first%22%3A12%2C%22after%22%3A%22QVFDRGYyMmxfYV9reGtreXU2NzFMZ0dyT1VzaFpLWlhsZGFncllVVVRTOEt2UEo1R2o2RUFvX2hTWWl3QWRRM0tpUEQ3bzFNM3BKTGhWRXRKRkEyb0l1dA%3D%3D%22%7D
{
    "id":"8666935289",
    "first":12,
    "after":"QVFDRGYyMmxfYV9reGtreXU2NzFMZ0dyT1VzaFpLWlhsZGFncllVVVRTOEt2UEo1R2o2RUFvX2hTWWl3QWRRM0tpUEQ3bzFNM3BKTGhWRXRKRkEyb0l1dA=="
}
"end_cursor": "QVFBSEcyRUwtNmFnVHdDT1BaNXRyZHlOSGN5MGNVUWxZakt1SWR3V202RERZVGVnRmVlTm9kcG50UV80Z1Etd2U2Ni1iMkJ6Q2hxak5FYnJKTXlxNmlsWg=="

page 4:
https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables=%7B%22id%22%3A%228666935289%22%2C%22first%22%3A12%2C%22after%22%3A%22QVFCWkQ5OVhEWEgzb3M0Tng3UGk2NC04UEc5NTdEUVFGWVp1ZGRmVFpYYjdDSGs1UHJmNmhaMmVjc1MtY0thMWNMZy1neUN0WlhvUWJ3a25kRXRmU3NJaQ%3D%3D%22%7D
{
    "id":"8666935289",
    "first":12,
    "after":"QVFCWkQ5OVhEWEgzb3M0Tng3UGk2NC04UEc5NTdEUVFGWVp1ZGRmVFpYYjdDSGs1UHJmNmhaMmVjc1MtY0thMWNMZy1neUN0WlhvUWJ3a25kRXRmU3NJaQ=="
}
"end_cursor": "QVFBTVZmdmRUaDY5TmtpRVZaVGNyMHVLdjY0QkloNEJFcmVDeFFRR1dfSkE3Wk0xR09RblpGZk9aampLMXhvWWFwUG55NXlUVnlWRDJ2eWYtbVVsV0l0NA=="

page 5:
https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables=%7B%22id%22%3A%228666935289%22%2C%22first%22%3A12%2C%22after%22%3A%22QVFBVHVtWnkxNlUwV1NpLWxKX2stMzk3UDEydmpNeTFTRlZMTXUtVmFKUjhzWVd4eU9nZ2Zyem5IOGc0c1F3NGZfdHZocDQzd0xKeU9KVE9rU19vNDBHeQ%3D%3D%22%7D
{
    "id":"8666935289",
    "first":12,
    "after":"QVFBVHVtWnkxNlUwV1NpLWxKX2stMzk3UDEydmpNeTFTRlZMTXUtVmFKUjhzWVd4eU9nZ2Zyem5IOGc0c1F3NGZfdHZocDQzd0xKeU9KVE9rU19vNDBHeQ=="
}
"end_cursor": "QVFCNHdsdFZJaGwzQ2czeDFVM1lucWg3M1Y2Q2xsaS1ZdEdpTUE0SHJ5QmNhZm1hTUQzM0c3dnRTZHJkcWRKazRqODR4MmdiYmdGSkl3dkdzankxUjlKSw=="

shixeh .... :
https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables=%7B%22id%22%3A%223066057183%22%2C%22first%22%3A12%2C%22after%22%3A%22QVFDbzdtcUxFUmFGYUxvZ283dU1CN0RxLU8yZEptcHBkeXBiaGpnNUhIRWpwSV9HVWNUOEVwVlNBVUZoOUNkR2w1M1MtamR3WWlXZWM1eHNsSllTODFhag%3D%3D%22%7D

https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables={"id":"3066057183","first":12,"after":"QVFDbzdtcUxFUmFGYUxvZ283dU1CN0RxLU8yZEptcHBkeXBiaGpnNUhIRWpwSV9HVWNUOEVwVlNBVUZoOUNkR2w1M1MtamR3WWlXZWM1eHNsSllTODFhag=="}

////////////////////////////
https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables={"id":"3066057183","first":12}

https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables={"id":"3066057183","first":12,"after":"QVFDUUFJLUhvNTFXNGpTa181NnVZT2xxRVF3VHBHQjlPclpPR0RZTm9iRkVza3JRb1o1UVpfWWx1a0FuS0VXcnIybnpBMGFiakRGUjg3RDQ0aXp1WTlmbg=="}

https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables={"id":"3066057183","first":12,"after":"QVFCdzgyQ0huNkswVzFScVNkZDVvTHNNY0dXUlZZbHdJV05Oejl5MEVKSjdGbU1rOEZCV0gwb1BoU1ZjZmNfNDU1ekRkQmdqOGpuSC1UVk9MTE5UTnJjMA=="}

https://www.instagram.com/graphql/query/?query_hash=003056d32c2554def87228bc3fd9668a&variables={"id":"3066057183","first":12,"after":"QVFERF9HVkM0Nkd0RnFlSjZIWWN4akhpU0gwSDBKRTZpVTNHeXk4UUlIYjMzUGtmNWZVQ1RKcjVIRXFqMlVGdGxmTVBJMlhwWU9YT1dDd0ZYV0ZTQzB6eQ=="}

https://www.instagram.com/web/search/topsearch/?query=shixehcom  /// search username and get user_id // 31551222751