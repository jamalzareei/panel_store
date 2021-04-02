@extends('layouts/master')

@section('head')
    <style>
        
/* This css file is to over write bootstarp css
---------------------------------------------------------------------- */
/*
Theme Name: Modern - Bootstrap Pricing Tables
Theme URI: http://adamthemes.com/
Author: AdamThemes
Author URI: http://adamthemes.com/
Description: Modern - Bootstrap Pricing Tables by AdamThemes
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: pricing, table, css3, modern, adamthemes, bootstrap
*---------------------------------------------------------------------- */


/*---------------------------------------------------------------------- /
Table of Contents 
------------------------------------------------------------------------ /
// . Sections
// . Block Pricing  
// . Block Table Color
// . Pricing Buttons
// . Bootstrap col-md-12 class
// . FontAwesome fa class
// . Bootstrap tab-space class

------------------------------------------------------------------------ /
Table of Contents End
------------------------------------------------------------------------*/


/* ======= SECTIONS  ======= */
.section-pricing {
    z-index: 3;
    position: relative;
}

.section-gray {
    background: #E5E5E5;
}

/* ======= BLOCK PRICING ======= */

.block {
    display: inline-block;
    position: relative;
    width: 100%;
    margin-bottom: 30px;
    border-radius: 6px;
    color: rgba(0, 0, 0, 0.87);
    background: #fff;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
}

.block-caption {
    font-weight: 700;
    font-family: "Lato", "Times New Roman", serif;
    color: #3C4857;
}

.block-plain {
    background: transparent;
    box-shadow: none;
}

.block .category:not([class*="text-"]) {
    color: #3C4857;
}

.block-background {
    background-position: center center;
    background-size: cover;
    text-align: center;
}

.block-raised {
    box-shadow: 0 16px 38px -12px rgba(0, 0, 0, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);
}

.block-background .table {
    position: relative;
    z-index: 2;
    min-height: 280px;
    padding-top: 40px;
    padding-bottom: 40px;
    max-width: 440px;
    margin: 0 auto;
}

.block-background .block-caption {
    color: #FFFFFF;
    margin-top: 10px;
}

.block-pricing.block-background:after {
    background-color: rgba(0, 0, 0, 0.7);
}

.block-background:after {
    position: absolute;
    z-index: 1;
    width: 100%;
    height: 100%;
    display: block;
    left: 0;
    top: 0;
    content: "";
    background-color: rgba(0, 0, 0, 0.56);
    border-radius: 6px;
}

[class*="pricing-"] {
    padding: 90px 0 60px 0;
}



.block-pricing {
    text-align: center;
}

.block-pricing .block-caption {
    margin-top: 30px;
}

.block-pricing .table {
    padding: 15px !important;
    margin-bottom: 0px;
}

.block-pricing .icon {
    padding: 10px 0 0px;
    color: #3C4857;
}

.block-pricing .icon i {
    font-size: 55px;
    border: 1px solid #ececec;
    border-radius: 50%;
    width: 130px;
    line-height: 130px;
    height: 130px;
}

.block-pricing h1 small {
    font-size: 18px;
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

.block-pricing ul li:last-child {
    border: 0;
}

.block-pricing ul li b {
    color: #3C4857;
}

.block-pricing ul li i {
    top: 6px;
    position: relative;
}

.block-pricing.block-background ul li,
.block-pricing [class*="table-"] ul li {
    color: #FFFFFF;
    border-color: rgba(255, 255, 255, 0.3);
}

.block-pricing.block-background ul li b,
.block-pricing [class*="table-"] ul li b {
    color: #FFFFFF;
}

.block-pricing.block-background [class*="text-"],
.block-pricing [class*="table-"] [class*="text-"] {
    color: #FFFFFF;
}

.block-pricing.block-background:after {
    background-color: rgba(0, 0, 0, 0.7);
}

.block-background:not(.block-pricing) .btn {
    margin-bottom: 0;
}

.block .table-primary {
    background: linear-gradient(60deg, #ab47bc, #7b1fa2);
}


.block [class*="table-"] .block-caption a,
.block [class*="table-"] .block-caption,
.block [class*="table-"] .icon i {
    color: #FFFFFF;
}

.block-pricing .block-caption {
    margin-top: 30px;
}

.block-selectable{
    transition: transform 0.2s ease;
    box-shadow: 0 4px 6px 0 rgba(22, 22, 26, 0.18);
    border-radius: 0;
    border: 0;
}
.block-selectable:hover{
    transform: scale(1.1);
}

.block [class*="table-"] h1 small,
.block [class*="table-"] h2 small,
.block [class*="table-"] h3 small {
    color: rgba(255, 255, 255, 0.8);
}

/* ======= BLOCK TABLE COLOR ======= */

.block .table-primary {
    background: linear-gradient(60deg, #de396b, #9767bb);
    border-radius: 6px;
    box-shadow: 0 16px 26px -10px rgba(156, 39, 176, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(156, 39, 176, 0.2);
}

.block .table-info {
    background: linear-gradient(60deg, #26c6da, #0097a7);
    border-radius: 6px;
    box-shadow: 0 2px 2px 0 rgba(0, 188, 212, 0.14), 0 3px 1px -2px rgba(0, 188, 212, 0.2), 0 1px 5px 0 rgba(0, 188, 212, 0.12);
}

.block .table-success {
    background: linear-gradient(60deg, #66bb6a, #388e3c);
    border-radius: 6px;
    box-shadow: 0 14px 26px -12px rgba(76, 175, 80, 0.42), 0 4px 23px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(76, 175, 80, 0.2);
}

.block .table-warning {
    background: linear-gradient(60deg, #ffa726, #f57c00);
    border-radius: 6px;
}

.block .table-danger {
    background: linear-gradient(60deg, #ef5350, #d32f2f);
    border-radius: 6px;
    box-shadow: 0 2px 2px 0 rgba(221, 75, 57, 0.14), 0 3px 1px -2px rgba(221, 75, 57, 0.2), 0 1px 5px 0 rgba(221, 75, 57, 0.12);
}

.block .table-rose {
    background: linear-gradient(60deg, #ec407a, #c2185b);
    border-radius: 6px;
    box-shadow: 0 14px 26px -12px rgba(233, 30, 99, 0.42), 0 4px 23px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(233, 30, 99, 0.2);
}

.block [class*="table-"] .category,
.block [class*="table-"] .block-description {
    color: rgba(255, 255, 255, 0.8);
}


/* ======= PRICING BUTTONS  ======= */

.btn,
.navbar > li > a.btn {
    border: none;
    border-radius: 3px;
    position: relative;
    padding: 12px 30px;
    margin: 10px 1px;
    font-size: 12px;
    font-weight: 400;
    text-transform: uppercase;
    letter-spacing: 0;
    will-change: box-shadow, transform;
    transition: box-shadow 0.2s cubic-bezier(0.4, 0, 1, 1), background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn.btn-round {
    border-radius: 30px;
}

.nav-tabs {
    margin-bottom: 30px;
}

.nav-pills:not(.nav-pills-icons) > li > a {
    border-radius: 30px;
    font-weight: 400;
}

.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    background-color: #9c27b0;
    color: #FFFFFF;
    box-shadow: 0 16px 26px -10px rgba(156, 39, 176, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(156, 39, 176, 0.2);
    border-color: transparent;
    border-radius: 30px;
}

/* btn-rose */
.btn.btn-rose {
    color: #FFFFFF;
    background-color: #e91e63;
    border-color: #e91e63;
    box-shadow: 0 2px 2px 0 rgba(233, 30, 99, 0.14), 0 3px 1px -2px rgba(233, 30, 99, 0.2), 0 1px 5px 0 rgba(233, 30, 99, 0.12);
}

.btn.btn-rose:focus,
.btn.btn-rose:active,
.btn.btn-rose:hover {
    box-shadow: 0 14px 26px -12px rgba(233, 30, 99, 0.42), 0 4px 23px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(233, 30, 99, 0.2);
}


/* btn-primary */
.btn.btn-primary {
    color: #FFFFFF;
    background-color: #9c27b0;
    border-color: #9c27b0;
    box-shadow: 0 2px 2px 0 rgba(156, 39, 176, 0.14), 0 3px 1px -2px rgba(156, 39, 176, 0.2), 0 1px 5px 0 rgba(156, 39, 176, 0.12);
}

.btn.btn-primary:focus,
.btn.btn-primary:active,
.btn.btn-primary:hover {
    box-shadow: 0 14px 26px -12px rgba(156, 39, 176, 0.42), 0 4px 23px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(156, 39, 176, 0.2);
}


/* btn-danger */
.btn.btn-danger {
    color: #FFFFFF;
    background-color: #f44336;
    border-color: #f44336;
    box-shadow: 0 2px 2px 0 rgba(244, 67, 54, 0.14), 0 3px 1px -2px rgba(244, 67, 54, 0.2), 0 1px 5px 0 rgba(244, 67, 54, 0.12);
}

.btn.btn-danger:focus,
.btn.btn-danger:active,
.btn.btn-danger:hover {
    box-shadow: 0 14px 26px -12px rgba(244, 67, 54, 0.42), 0 4px 23px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(244, 67, 54, 0.2);
}


/* btn-success */
.btn.btn-success {
    color: #FFFFFF;
    background-color: #4caf50;
    border-color: #4caf50;
    box-shadow: 0 2px 2px 0 rgba(76, 175, 80, 0.14), 0 3px 1px -2px rgba(76, 175, 80, 0.2), 0 1px 5px 0 rgba(76, 175, 80, 0.12);
}

.btn.btn-success:focus,
.btn.btn-success:active,
.btn.btn-success:hover {
    box-shadow: 0 14px 26px -12px rgba(76, 175, 80, 0.42), 0 4px 23px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(76, 175, 80, 0.2);
}


/* btn-info */
.btn-info {
    color: #fff;
    background-color: #5bc0de;
    border-color: #5bc0de;
    box-shadow: 0 2px 2px 0 rgba(0, 188, 212, 0.14), 0 3px 1px -2px rgba(0, 188, 212, 0.2), 0 1px 5px 0 rgba(0, 188, 212, 0.12);
}

.btn.btn-info:focus,
.btn.btn-info:active,
.btn.btn-info:hover {
    box-shadow: 0 14px 26px -12px rgba(0, 188, 212, 0.42), 0 4px 23px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 188, 212, 0.2);
}


/* btn-warning */
.btn-warning {
    color: #fff;
    background-color: #ff9800;
    border-color: #ff9800;
    box-shadow: 0 2px 2px 0 rgba(255, 152, 0, 0.14), 0 3px 1px -2px rgba(255, 152, 0, 0.2), 0 1px 5px 0 rgba(255, 152, 0, 0.12);
}

.btn.btn-warning:focus,
.btn.btn-warning:active,
.btn.btn-warning:hover {
    box-shadow: 0 14px 26px -12px rgba(255, 152, 0, 0.42), 0 4px 23px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(255, 152, 0, 0.2);
}


/* btn-white */
.btn.btn-white {
    color: #3C4857;
    background-color: #fff;
    border-color: #fff;
    box-shadow: 0 2px 2px 0 rgba(153, 153, 153, 0.14), 0 3px 1px -2px rgba(153, 153, 153, 0.2), 0 1px 5px 0 rgba(153, 153, 153, 0.12);
}

.btn.btn-white:focus,
.btn.btn-white:active,
.btn.btn-white:hover {
    box-shadow: 0 4px 4px 0 rgba(153, 153, 153, 0.24), 0 3px 1px -2px rgba(153, 153, 153, 0.3), 0 1px 5px 0 rgba(153, 153, 153, 0.32);
}


/* Bootstrap col-md-12 class */
.col-md-12 {
    padding-right: 0px;
    padding-left: 0px;
}

/* FontAwesome fa class */
.fa {
    font-size: 12px;
}

/* Bootstrap tab-space class */
.tab-space {
    padding: 20px 0 50px 0px;
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
                            <li><span class="font-medium-2"> افزودن اطلاعات نمایشی</span></li>
                            <li><span class="font-medium-2"> افزودن شعبه</span></li>
                            <li><span class="font-medium-2">  اطلاعات تماس</span></li>
                            <li><span class="font-medium-2"> تنظیمات فروشگاه</span></li>
                            <li><span class="font-medium-2"> پرداخت امن</span></li>
                            <li><span class="font-medium-2"> افزودن محصول</span></li>
                            <li><span class="font-medium-2"> تسویه حساب</span></li>
                            <li><span class="font-medium-2"> ورود محصول از اینستاگرام</span></li>
                            <li><span class="font-medium-2"> ورود محصول از سایت</span></li>
                            <li><span class="font-medium-2"> امکان سفارش گیری در شیک3</span></li>
                            <li><span class="font-medium-2"> نمایش مکان فیزیکی روی نقشه</span></li>
                            <li><span class="font-medium-2"> نردبان محصولات</span></li>
                            <li><span class="font-medium-2"> اضافه کردن کد تخفیف</span></li>
                            <li><span class="font-medium-2"> نمایش محصولات تخفیف دار صفحه اول</span></li>
                            <li><span class="font-medium-2"> مدیریت نظرات کاربران</span></li>
                            <li><span class="font-medium-2"> درخواست تبلیغات ویژه</span></li>
                            <li><span class="font-medium-2"> دریافت درخواست کاربران جنس جدید</span></li>
                            <li><span class="font-medium-2"> گزارش بازدید محصولات</span></li>
                            <li><span class="font-medium-2"> گزارش علاقه مندی کاربران</span></li>
                            <li><span class="font-medium-2"> گزارش فروش استانی</span></li>
                            <li><span class="font-medium-2"> گزارش فروش بازه زمانی</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="block block-pricing block-raised block-selectable">
                    <div class="table">
                        <h3 class="category">پایه</h3>
                        <h1 class="block-caption"><small>ماهیانه</small><NumberFormat price="49000" /></h1>
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
                        </ul> <a onClick={loginToken(ApiRouetes.loginToken)} class="btn btn-primary btn-round text-white">فعال سازی پلان ساده</a> </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="block block-pricing block-plain block-selectable">
                    <div class="table table-primary">
                        <h3 class="category">نقره ای</h3>
                        <h1 class="block-caption"><small>ماهیانه</small> <NumberFormat price="199000" /></h1>
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
                        </ul> <a onClick={loginToken(ApiRouetes.loginToken)} class="btn btn-white btn-round">فعال سازی پلان نقره ای</a> </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="block block-pricing block-plain block-selectable">
                    <div class="table">
                        <h3 class="category">طلایی</h3>
                        <h1 class="block-caption"><small>ماهیانه</small><NumberFormat price="499000" /></h1>
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
                        </ul> <a onClick={loginToken(ApiRouetes.loginToken)} class="btn btn-primary btn-round text-white">فعال سازی پلان طلایی</a> </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection