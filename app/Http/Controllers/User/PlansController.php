<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanUser;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    //
    function pricing(Request $request)
    {
        # code...
        return view('seller.plans.pricing');
    }

    public function planSelective(Request $request, $paln_id = 1)
    {
        # code...
        $plan = Plan::find($paln_id);
        $user = auth()->user();

        $discount = (object) null;
        $discount->amount = 0;
        $discount->id = null;

        $total = $plan->old_price;
        $total_pay = $plan->price - $discount->amount;

        PlanUser::updateOrCreate([
            'user_id' => $user->id,
            'actived_at' => null,
            'pay_type_id' => 0,
        ], [
            'plan_id' => $plan->id,
            'actived_days' => $plan->days_use,
            'total_pay' => $plan->price - $discount->amount,
            'total' => $total,
            'total_off' => ($total - $plan->price) + $discount->amount ?? null,
            'discount_id' => $discount->id ?? null,
        ]);

        return redirect()->route('user.plans.user.all');
    }

    public function planAwaitPay(Request $request, $type = 'notpay')
    {
        # code...
        $user = auth()->user();

        $plans = Plan::all();

        $plansUser = PlanUser::where('user_id', $user->id)
            ->when($type == 'notpay', function ($query) {
                $query->whereNull('actived_at')->whereNull('payed_at');
            })
            ->when($type == 'pay', function ($query) {
                $query->whereNotNull('actived_at')->whereNotNull('payed_at');
            })
            ->with('plan')
            ->get();

        if ($type == 'pay') {
            // return $plansUser;

            return view('user.plans.payed', [
                'title' => 'پلان های خریداری شده',
                'plansUser' => $plansUser,
                'plans' => $plans,
            ]);
        }

        return view('user.plans.await-pay', [
            'title' => 'فعال سازی پلان جدید',
            'plansUser' => $plansUser,
            'plans' => $plans,
        ]);
    }

    public function calculatePay($plan_id, $day)
    {
        # code...
        $plan = Plan::find($plan_id);

        $total = $plan->price;
        switch ($day) {
            case 30:
                $total = $plan->price;
                break;
            case 90:
                $total = $plan->price * 3 * 0.9;
                break;
            case 180:
                $total = $plan->price * 6 * 0.8;
                break;
            case 360:
                $total = $plan->price * 12 * 0.7;
                break;

            default:
                $total = $plan->price;
        }

        return $total;
    }

    public function planSendToPay(Request $request, $id)
    {
        # code...
        $request->validate([
            'days_use' => "required",
            'plan_id' => "required|exists:plans,id",
        ]);
        $plan_id = $request->plan_id;
        $planUser = PlanUser::find($id);
        $plan = Plan::find($plan_id);
        if (!($planUser && $plan)) {
            return response()->json([
                'status' => 'error',
                'message' => 'هیچ موردی انتخاب نشده است.'
            ], 200);
        }

        $planUser->actived_days = (int)($request->days_use);
        $planUser->total = $plan->old_price * ((int)($request->days_use) / 30);
        $planUser->total_pay = $this->calculatePay($plan_id, (int)($request->days_use));
        $planUser->total_off = ($plan->old_price * ((int)($request->days_use) / 30)) - $this->calculatePay($plan_id, (int)($request->days_use));

        $planUser->save();

        // return $planUser;//$request->days_use;

        session()->put('noty', [
            'status' => 'success',
            'title' => '',
            'message' => 'با موفقیت اضافه گردید.',
            'data' => '',
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'شما به مرحله پرداخت ارجاع داده میشوید.',
            'autoRedirect' => route('user.pay.planuser.online', ['planuser_id' => $planUser->id])
            // 'autoRedirect' => route('user.plans.user.all')
        ], 200);
    }
}
