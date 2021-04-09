<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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

        $client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        // $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

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
            return redirect('https://sandbox.zarinpal.com/pg/StartPay/' . $result->Authority);
            // return redirect('https://www.zarinpal.com/pg/StartPay/' . $result->Authority);
            header('Location: https://www.zarinpal.com/pg/StartPay/' . $result->Authority);
//             echo '
// <script type="text/javascript" src="https://cdn.zarinpal.com/zarinak/v1/checkout.js"></script>
// <script>
// Zarinak.setAuthority( ' . $result->Authority . ');
// Zarinak.open();
// </script>';
        } else {
            echo 'ERR: ' . $result->Status;
        }
/////////////////////////////////////////////////////////
        // $data = array(
        //     "merchant_id" => $this->merchant_id,
        //     "amount" => $planUser->total_pay,
        //     "callback_url" => route("user.callback.pay.planuser.online", ['planuser_id'=> $planuser_id]),
        //     "description" => $planUser->plan->name ?? 'خرید پلان',
        //     "metadata" => ["email" => "jzcs89@gmail.com", "mobile" => $planUser->user->phone ?? "09135368845"],
        // );
        // $jsonData = json_encode($data);
        // //https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentRequest.json
        // $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
        // curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // //////
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // //////////
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json',
        //     'Content-Length: ' . strlen($jsonData)
        // ));

        // $result = curl_exec($ch);
        // $err = curl_error($ch);
        // $result = json_decode($result, true, JSON_PRETTY_PRINT);
        // curl_close($ch);



        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     if (empty($result['errors'])) {
        //         if ($result['data']['code'] == 100) {
        //             header('Location: https://www.zarinpal.com/pg/StartPay/' . $result['data']["authority"]);
        //         }
        //     } else {
        //         echo 'Error Code: ' . $result['errors']['code'];
        //         echo 'message: ' .  $result['errors']['message'];
        //     }
        // }
    }

    public function callback(Request $request, $planuser_id)
    {
        # code...
        $planUser = PlanUser::where('id', $planuser_id)->with(['plan', 'user'])->first();


        $MerchantID = $this->merchant_id;
        $Amount = $planUser->total_pay; //Amount will be based on Toman
        $Authority = $_GET['Authority'];

        if ($_GET['Status'] == 'OK') {
            
            $client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
            // $client = new SoapClient('https://w+ww.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $result = $client->PaymentVerification(
                [
                    'MerchantID' => $MerchantID,
                    'Authority' => $Authority,
                    'Amount' => $Amount,
                ]
            );

            if ($result->Status == 100) {
                $planUser->pay_type_id = 3;
                $planUser->actived_at = Carbon::now();
                $planUser->payed_at = Carbon::now();
                $planUser->save();

                return redirect()->route('user.plans.user.all', ['type' => 'pay']);
                echo 'Transation success. RefID:' . $result->RefID;
            } else {
                echo 'Transation failed. Status:' . $result->Status;
            }
        } else {
            echo 'Transaction canceled by user';
        }
        //////////////////////////////////////////////////////
        // $Authority = $_GET['Authority'];
        // $data = array("merchant_id" => $this->merchant_id, "authority" => $Authority, "amount" => $planUser->total_pay);
        // $jsonData = json_encode($data);
        // $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        // curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json',
        //     'Content-Length: ' . strlen($jsonData)
        // ));

        // $result = curl_exec($ch);
        // curl_close($ch);
        // $result = json_decode($result, true);
        // return $result;
        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     if ($result['data']['code'] == 100) {
        //         echo 'Transation success. RefID:' . $result['data']['ref_id'];
        //     } else {
        //         echo 'code: ' . $result['errors']['code'];
        //         echo 'message: ' .  $result['errors']['message'];
        //     }
        // }
    }
}
