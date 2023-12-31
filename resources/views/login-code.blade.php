<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>پنل مدیریت شیکسه</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors-rtl.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->    
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/core/colors/palette-gradient.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/dashboard-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/card-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/tour/tour.css') }}"> --}}
    
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/authentication.css') }}">
    <!-- END: Page CSS-->

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/extensions/toastr.css') }}">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/custom-rtl.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style-rtl.css') }}">
    <!-- END: Custom CSS-->

    <style>
        #code {
            padding-left: 15px;
            letter-spacing: 43px;
            border: 0;
            background-image: linear-gradient(to left, black 70%, rgba(255, 255, 255, 0) 0%);
            background-position: bottom;
            background-size: 50px 1px;
            background-repeat: repeat-x;
            background-position-x: 35px;
            width: 60%;
            margin: auto;
        }
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-11 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                                    <img src="{{ asset('app-assets/images/pages/login.png') }}" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 px-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">فراموشی / ثبت نام فروشنده جدید</h4>
                                            </div>
                                        </div>
                                        <p class="text-danger">
                                            @if(session()->has('noty'))
                                                <div class="alert alert-{{ (session()->get('noty')['status']) }}">
                                                    {{ (session()->get('noty')['message']) }}
                                                </div>
                                            @endif
                                        </p>
                                        <div class="card-content">
                                            <div class="card-body pt-1">
                                                @if ($username)
                                                    <form action="{{ route('confirm.auth.code.post') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="role" value={{ $role }}>
                                                        <input type="hidden" name="username" value="{{ $username }}">
                                                            
                                                        <fieldset class="form-label-group form-group position-relative has-icon-right">
                                                            <input type="text" class="form-control" id="code"  maxlength="4"name="code" dir="ltr" required>
                                                            {{-- <div class="form-control-position">
                                                                <i class="feather icon-user"></i>
                                                            </div> --}}
                                                            <label for="code"> کد دریافتی</label>
                                                        </fieldset>
                                                        <button type="submit" class="btn btn-primary float-right btn-inline">تایید کد دریافتی</button>



                                                    </form>
                                                @else

                                                    <form action="{{ route('login.code.post') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="role" value="{{ $role }}">
                                                            
                                                        <fieldset class="form-label-group form-group position-relative has-icon-right">
                                                            <input type="text" class="form-control" id="username" name="username" dir="ltr" placeholder="شماره تماس" required>
                                                            <div class="form-control-position">
                                                                <i class="feather icon-user"></i>
                                                            </div>
                                                            <label for="username">شماره تماس</label>
                                                        </fieldset>
                                                        {{-- <div class="text-right"><a href={{ route('login.get') }} class="card-link">ورود با رمز عبور </a></div> --}}
                                                        <button type="submit" class="btn btn-primary float-right btn-inline">دریافت کد تاییدیه</button>
    
    
                                                    </form>

                                                @endif
                                            </div>
                                        </div>
                                        <div class="login-footer">
                                            <div class="divider">
                                                <div class="divider-text">ما را در شبکه های اجتماعی دنبال نمایید</div>
                                            </div>
                                            <div class="footer-btn d-inline">
                                                
                                                <a  class="btn m-0 p-0" href="https://www.facebook.com/shixehcom/"><i class="fa fa-facebook-f "></i></a>
                                                <a  class="btn m-0 p-0" href="https://twitter.com/shixehcom"><i class="fa fa-twitter "></i></a>
                                                <a  class="btn m-0 p-0" href="https://instagram.com/shixehcom"><i class="fa fa-instagram "></i></a>
                                                <a  class="btn m-0 p-0" href="https://t.me/shixehcom"><i class="fa fa-telegram "></i></a>
                                                <a  class="btn m-0 p-0" href="https://www.pinterest.com/shixehcom"><i class="fa fa-pinterest "></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/components.js') }}"></script>
    <!-- END: Theme JS-->

    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->

    <script src="{{ asset('js/scripts.js') }}"></script>
    <script>
        @if(session('noty'))
            messageToast("{!! session('noty')['title'] !!}", "{!! session('noty')['message'] !!}", "{!! session('noty')['status'] !!}", 5000)
            <?php session()->forget('noty') ?>
        @endif
    </script>
</body>
<!-- END: Body-->

</html>