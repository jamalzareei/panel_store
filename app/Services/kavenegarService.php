<?php

namespace App\Services;
use Kavenegar;
use Kavenegar\KavenegarApi;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;

class kavenegarService {
    public static function send($receptor, $message){


        // return ;


        try{
            // $sender = "10004346";
            $sender = "10000100600666";// "1000596446";
            // $message = "خدمات پیام کوتاه کاوه نگار";
            // $receptor = array("09123456789","09367891011");
            $result = Kavenegar::Send($sender,$receptor,$message);
            // if($result){
            //     foreach($result as $r){
            //         echo "messageid = $r->messageid";
            //         echo "message = $r->message";
            //         echo "status = $r->status";
            //         echo "statustext = $r->statustext";
            //         echo "sender = $r->sender";
            //         echo "receptor = $r->receptor";
            //         echo "date = $r->date";
            //         echo "cost = $r->cost";
            //     }       
            // }
        }
        catch(\Kavenegar\Exceptions\ApiException $e){
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
        catch(\Kavenegar\Exceptions\HttpException $e){
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
    }

    public static function sendCode($receptor, $code, $template){
        try{
            $api = new KavenegarApi("416749576B667544737A2F59423976746B683143426231365537627A435247306E4E6639494C4E484D446F3D");
            // $receptor = "";
            $token = $code;
            $token2 = "";
            $token3 = "";
            $template = $template;//"verify";
            $type = "sms";//sms | call
            $result = $api->VerifyLookup($receptor,$token,$token2,$token3,$template,$type);
            // if($result){
            //     var_dump($result);
            // }
        }
        catch(ApiException $e){
            echo 'error1'. $e->errorMessage();
        }
        catch(HttpException $e){
            echo 'error2'.$e->errorMessage();
        }
    }
}