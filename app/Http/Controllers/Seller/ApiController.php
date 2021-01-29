<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\UploadService;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    //
    /*
    $response->body() : string;
    $response->json() : array|mixed;
    $response->status() : int;
    $response->ok() : bool;
    $response->successful() : bool;
    $response->failed() : bool;
    $response->serverError() : bool;
    $response->clientError() : bool;
    $response->header($header) : string;
    $response->headers() : array;
    */
    public function readInstagram(Request $requerst)
    {
        # code...
        // return UploadService::saveImageFromURL('instagram/images/', 'https://scontent-lhr8-1.cdninstagram.com/v/t51.2885-15/sh0.08/e35/c0.66.1024.1024a/s640x640/135025680_111190014206133_635544462823196958_n.jpg?_nc_ht=scontent-lhr8-1.cdninstagram.com&_nc_cat=109&_nc_ohc=duUpuCI09LAAX-Aaz5E&tp=1&oh=04eec58c6c1ede387ba60fedffa279ac&oe=603B93A5');


        $response = Http::get('https://www.instagram.com/shixehcom/?__a=1');
        // $response = Http::get('https://www.instagram.com/%s/media', 'shixehcom');
        $response = Http::get(config('shixeh.cdn_domain_files') . 'instagram/09135368845.json');
        // return $response->json();//->json();//['graphql']['user'];//['edge_owner_to_timeline_media'];

        if (!$response->json()) {
            return 'بعدا تلاش نمایید.';
        }
        $data = [];
        foreach ($response->json()['graphql']['user']['edge_owner_to_timeline_media']['edges'] as $key => $edge) {
            # code...
            $data[$key]['image'] = $edge['node']['display_url']; //['thumbnail_src'];//['display_url'];

            sleep(0.1);
            UploadService::saveImageFromURL('instagram/'.$edge['node']['shortcode'].'/', $data[$key]['image']);

            $data[$key]['cation'] = $edge['node']['edge_media_to_caption']['edges'][0]['node']['text'];
            $data[$key]['shortcode'] = $edge['node']['shortcode'];
            $data[$key]['is_video'] = $edge['node']['is_video'];

            if ($edge['node'] && isset($edge['node']['edge_sidecar_to_children']) && $edge['node']['edge_sidecar_to_children']['edges']) {

                foreach ($edge['node']['edge_sidecar_to_children']['edges'] as $key => $edgeNew) {
                    # code...
                    $data[$key]['edge_sidecar_to_children'][] = $edgeNew['node']['display_url'];

                    sleep(0.1);
                    UploadService::saveImageFromURL('instagram/'.$edge['node']['shortcode'].'/', $edgeNew['node']['display_url']);
                }
            }
        }

        return $data;
    }

}
