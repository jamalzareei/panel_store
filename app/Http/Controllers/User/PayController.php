<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PlanPay;
use App\Models\PlanUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SoapClient;

class PayController extends Controller
{
    //
    private $merchant_id = 'b88a4eea-d4c8-459f-8e6d-8be074903486';

    public function __construct()
    {
        # code...
        $this->merchant_id = 'b88a4eea-d4c8-459f-8e6d-8be074903486';
    }

    public function Pay(Request $request, $planuser_id)
    {
        # code...
        $planUser = PlanUser::where('id', $planuser_id)->with(['plan', 'user'])->first();

        ini_set("soap.wsdl_cache_enabled", "0");

        // require_once '../../../../../Services/nusoap.php';
        include_once app_path() . '/Services/nusoap.php';

        $MerchantID = $this->merchant_id; //Required
        $Amount = $planUser->total_pay; //Amount will be based on Toman - Required
        $Description = $planUser->plan->name ?? 'خرید پلان'; // Required
        $Email = "jzcs89@gmail.com"; // Optional
        $Mobile = $planUser->user->phone ?? "09135368845"; // Optional
        $CallbackURL = route("user.callback.pay.planuser.online", ['planuser_id' => $planuser_id]); // Required

        // $client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

        $result = $client->PaymentRequest(
            [
                'MerchantID' => $MerchantID,
                'Amount' => $Amount,
                'Description' => $Description,
                'Email' => $Email,
                'Mobile' => $Mobile,
                'CallbackURL' => $CallbackURL,
            ]
        );
// var_dump($result);
        //Redirect to URL You can do it also by creating a form
        if ($result->Status == 100) {
            // return redirect('https://sandbox.zarinpal.com/pg/StartPay/' . $result->Authority);
            return redirect('https://www.zarinpal.com/pg/StartPay/' . $result->Authority);
            header('Location: https://www.zarinpal.com/pg/StartPay/' . $result->Authority);
        } else {
            echo 'ERR: ' . $result->Status;
        }
    }

    public function callback(Request $request, $planuser_id)
    {
        # code...
        $planUser = PlanUser::where('id', $planuser_id)->with(['plan', 'user'])->first();


        $MerchantID = $this->merchant_id;
        $Amount = $planUser->total_pay; //Amount will be based on Toman
        $Authority = $_GET['Authority'];

        if ($_GET['Status'] == 'OK') {
            
            // $client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
            $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $result = $client->PaymentVerification(
                [
                    'MerchantID' => $MerchantID,
                    'Authority' => $Authority,
                    'Amount' => $Amount,
                ]
            );

            if ($result->Status == 100) {
                PlanPay::create([
                    'user_id' => $planUser->user_id,
                    'plan_id' => $planUser->plan_id,
                    'plan_user_id' => $planUser->id,
                    'tracking_code' => $result->RefID,
                    'details' => json_encode($result),
                ]);
                $planUser->pay_type_id = 3;
                $planUser->actived_at = Carbon::now();
                $planUser->payed_at = Carbon::now();
                $planUser->save();

                return redirect()->route('user.plans.user.all', ['type' => 'pay']);
                echo 'Transation success. RefID:' . $result->RefID;
            } else {
                    
                session()->put('noty', [
                    'status' => 'warning',
                    'title' => '',
                    'message' => 'پرداخت شما ناموفق بوده است، در صورتی که مبلغ از حساب شما کسر گردید طی 72 ساعت به حساب شما بازگردانده خواهد شد.',
                    'data' => '',
                ]);
                return redirect()->route('user.plans.user.all');
                // echo 'Transation failed. Status:' . $result->Status;
            }
        } else {
            
            session()->put('noty', [
                'status' => 'warning',
                'title' => '',
                'message' => 'پرداخت توسط کاربر کنسل گردید.',
                'data' => '',
            ]);
            return redirect()->route('user.plans.user.all');
            // echo 'Transaction canceled by user';
        }
    }
}
