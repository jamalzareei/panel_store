@extends('layouts/master')

@section('head')
    <style>
        .block-pricing {
            text-align: center;
        }

        .block .table {
            border-radius: 6px;
        }

        .block-pricing .block-caption {
            margin-top: 30px;
        }

        .block-pricing .table {
            padding: 15px !important;
            margin-bottom: 0px;
        }

        .block-pricing h1 small:first-child {
            position: relative;
            top: -17px;
        }

        .block-pricing ul {
            list-style: none;
            padding: 0;
            max-width: 240px;
            margin: 10px auto;
        }

        .block-pricing ul li {
            color: #3C4857;
            text-align: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(153, 153, 153, 0.3);
            height: 50px !important;
        }

        .block-pricing ul li b {
            color: #3C4857;
        }

        .block .table {
            background: #fff
        }

        .block .table-primary {
            background: linear-gradient(60deg, #e7305b, #7b1fa2);
            border-radius: 6px;
            box-shadow: 0 16px 26px -10px rgb(156 39 176 / 56%), 0 4px 25px 0px rgb(0 0 0 / 12%), 0 8px 10px -5px rgb(156 39 176 / 20%);
        }

        .block .table .block-caption a,
        .block .table .block-caption,
        .block .table .category,
        .block .table li,
        .block .table .icon i {
            color: #848484;
        }

        .block [class*="table-"] .block-caption a,
        .block [class*="table-"] .block-caption,
        .block [class*="table-"] .category,
        .block [class*="table-"] li,
        .block [class*="table-"] .icon i {
            color: #ddd;
        }

        .block-selectable {
            transition: transform 0.2s ease;
            box-shadow: 0 4px 6px 0 rgba(22, 22, 26, 0.18);
            border-radius: 6px;
            border: 0;
        }

        .block-selectable:hover {
            transform: scale(1.1);
        }

    </style>
@endsection

@section('footer')

@endsection

@section('content')

    <div class="row p-4">

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="block block-pricing block-plain">
                        <div class="table">
                            <h3 class="category">&nbsp;</h3>
                            <h1 class="block-caption">&nbsp;</h1>
                            <ul>
                                <li><span class=""> افزودن اطلاعات نمایشی</span></li>
                                <li><span class=""> افزودن شعبه</span></li>
                                <li><span class="">  اطلاعات تماس</span></li>
                                <li><span class=""> تنظیمات فروشگاه</span></li>
                                <li><span class=""> پرداخت امن</span></li>
                                <li><span class=""> افزودن محصول</span></li>
                                <li><span class=""> تسویه حساب</span></li>
                                <li><span class=""> ورود محصول از اینستاگرام</span></li>
                                <li><span class=""> ورود محصول از سایت</span></li>
                                <li><span class=""> امکان سفارش گیری در شیک3</span></li>
                                <li><span class=""> نمایش مکان فیزیکی روی نقشه</span></li>
                                <li><span class=""> نردبان محصولات</span></li>
                                <li><span class=""> اضافه کردن کد تخفیف</span></li>
                                <li><span class=""> نمایش محصولات تخفیف دار صفحه اول</span></li>
                                <li><span class=""> مدیریت نظرات کاربران</span></li>
                                <li><span class=""> درخواست تبلیغات ویژه</span></li>
                                <li><span class=""> دریافت درخواست کاربران جنس جدید</span></li>
                                <li><span class=""> گزارش بازدید محصولات</span></li>
                                <li><span class=""> گزارش علاقه مندی کاربران</span></li>
                                <li><span class=""> گزارش فروش استانی</span></li>
                                <li><span class=""> گزارش فروش بازه زمانی</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="block block-pricing block-raised block-selectable">
                        <div class="table">
                            <h3 class="category">پایه</h3>
                            <h1 class="block-caption"><small>ماهیانه</small><span class="font-weight-bold font-medium-1 my-50">49,000<!-- --> <!-- -->تومان</span></h1>
                            <ul>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li>250</li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                                <li><i class="fad fa-times text-danger font-medium-3"></i></li>
                            </ul> <a href="{{ route('user.plan.selective', ['plan_id'=>1]) }}" class="btn btn-primary btn-round text-white">فعال سازی پلان ساده</a> </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="block block-pricing block-plain block-selectable">
                        <div class="table table-primary">
                            <h3 class="category">نقره ای</h3>
                            <h1 class="block-caption"><small>ماهیانه</small> <span class="font-weight-bold font-medium-1 my-50">199,000<!-- --> <!-- -->تومان</span></h1>
                            <ul>

                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li>1,500</li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-white font-medium-3"></i></li>
                                <li><i class="fad fa-times text-light font-medium-3"></i></li>
                                <li><i class="fad fa-times text-light font-medium-3"></i></li>
                                <li><i class="fad fa-times text-light font-medium-3"></i></li>
                                <li><i class="fad fa-times text-light font-medium-3"></i></li>
                                <li><i class="fad fa-times text-light font-medium-3"></i></li>
                                <li><i class="fad fa-times text-light font-medium-3"></i></li>
                            </ul> <a href="{{ route('user.plan.selective', ['plan_id'=>2]) }}" class="btn btn-white btn-round">فعال سازی پلان نقره ای</a> </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="block block-pricing block-plain block-selectable">
                        <div class="table">
                            <h3 class="category">طلایی</h3>
                            <h1 class="block-caption"><small>ماهیانه</small><span class="font-weight-bold font-medium-1 my-50">499,000<!-- --> <!-- -->تومان</span></h1>
                            <ul>

                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li>10,000</li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                                <li><i class="fad fa-shield-check text-success font-medium-3"></i></li>
                            </ul> <a href="{{ route('user.plan.selective', ['plan_id'=>3]) }}" class="btn btn-primary btn-round text-white">فعال سازی پلان طلایی</a> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
