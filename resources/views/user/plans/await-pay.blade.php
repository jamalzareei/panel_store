@extends('layouts/master')

@section('head')

@endsection

@section('footer')

    <script>
        function checkDiscount() {
            let code = $('#doscountCode').val();
            if (code) {
                messageToast('', 'کد تخفیف وجود ندارد.', 'error', 5000)
            } else {
                messageToast('', 'کد تخفیف را وارد نمایید.', 'info', 5000)
            }
        }

    </script>
@endsection

@section('content')
    <div class="row mt-5">
        <div class="col-md-8 offset-md-2 mt-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">پلان انتخابی شما: {{ $plansUser[0]->plan->name }} </h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                            <li><a data-action=""><i class="feather icon-rotate-cw categories-data-filter"></i></a></li>
                            {{-- <li><a data-action="close"><i class="feather icon-x"></i></a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <section id="basic-horizontal-layouts">
                            @forelse ($plansUser as $planUser)

                                <form action="{{ route('user.plan.send.to.pay', ['planuser_id' => $planUser->id]) }}"
                                    class="ajaxForm" method="post">
                                    @csrf
                                    <div class="row match-height">
                                        <div class="col-md-4 mb-2">
                                            <select class="form-control" name="plan_id">
                                                <option>--- انتخاب پلان ---</option>
                                                @forelse ($plans as $plan)
                                                    <option value="{{ $plan->id }}"
                                                        {{ $planUser && $plan->id == $planUser->plan_id ? 'selected' : '' }}>
                                                        {{ $plan->name }}</option>
                                                @empty

                                                @endforelse
                                            </select>
                                            <small class="help-block text-danger error-plan_id"></small>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <select class="form-control" name="days_use">
                                                <option>--- انتخاب زمان ---</option>
                                                <option value="30" {{ ($planUser->actived_days) == 30 ? 'selected' : '' }}>1 ماهه ({{ number_format($planUser->plan->price / 10) }}
                                                    تومان)</option>
                                                <option value="90" {{ ($planUser->actived_days) == 90 ? 'selected' : '' }}>3 ماهه
                                                    ({{ number_format(($planUser->plan->price * 3 * 0.9) / 10) }} تومان)(10
                                                    درصد تخفیف)</option>
                                                <option value="180" {{ ($planUser->actived_days = 180) ? 'selected' : '' }}>6 ماهه
                                                    ({{ number_format(($planUser->plan->price * 6 * 0.8) / 10) }} تومان)(20
                                                    درصد تخفیف)</option>
                                                <option value="360" {{ ($planUser->actived_days == 360) ? 'selected' : '' }}>1 ساله
                                                    ({{ number_format(($planUser->plan->price * 12 * 0.7) / 10) }} تومان)(30
                                                    درصد تخفیف)</option>
                                            </select>
                                            <small class="help-block text-danger error-days_use"></small>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            @if ($planUser->total * $planUser->actived_days > $planUser->total_pay * $planUser->actived_days)
                                                <div class="text-center font-weight-bold"><del
                                                        class="text-danger">{{ number_format($planUser->total / 10) }}
                                                        تومان</del>
                                                </div>
                                            @endif
                                            <div class="text-center text-success font-weight-bold font-large-1">
                                                {{ number_format($planUser->total_pay / 10) }} تومان</div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <fieldset>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                    name="code" placeholder="کد تخفیف"
                                                        aria-describedby="button-addon2" id="doscountCode">
                                                    <div class="input-group-append" id="button-addon2">
                                                        <button class="btn btn-success waves-effect waves-light"
                                                            onclick="checkDiscount()" type="button">ثبت</button>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <small class="help-block text-danger error-code"></small>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <button type="submit"
                                                class="btn bg-primary mr-1 mb-1 waves-effect waves-light btn-block text-white">پرداخت</button>
                                        </div>
                                    </div>

                                </form>
                            @empty
                                <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
                                    شما سفارشی انتخاب نکرده اید
                                </div>
                            @endforelse
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
