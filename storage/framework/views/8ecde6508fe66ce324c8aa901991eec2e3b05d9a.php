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
    <link rel="apple-touch-icon" href="<?php echo e(asset('app-assets/images/ico/apple-icon-120.png')); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('app-assets/images/ico/favicon.ico')); ?>">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/vendors-rtl.min.css')); ?>">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css-rtl/bootstrap.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css-rtl/bootstrap-extended.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css-rtl/colors.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css-rtl/components.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css-rtl/themes/dark-layout.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css-rtl/themes/semi-dark-layout.css')); ?>">

    <!-- BEGIN: Page CSS-->
    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css-rtl/core/menu/menu-types/vertical-menu.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css-rtl/core/colors/palette-gradient.css')); ?>">
    
    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css-rtl/pages/authentication.css')); ?>">
    <!-- END: Page CSS-->

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/extensions/toastr.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css-rtl/plugins/extensions/toastr.css')); ?>">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css-rtl/custom-rtl.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
    <!-- END: Custom CSS-->

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
                                    <img src="<?php echo e(asset('app-assets/images/pages/login.png')); ?>" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 px-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">ورود به پنل کاربری</h4>
                                            </div>
                                        </div>
                                        <p class="px-2">لطفا در صورتی که قبلا به عنوان فروشنده ثبت  نام نکرده اید، از لینک ثبت نام نسبت به ثبت نام اقدام نمایید.</p>
                                        <p class="text-danger">
                                            <?php if(session()->has('noty')): ?>
                                                <div class="alert alert-<?php echo e((session()->get('noty')['status'])); ?>">
                                                    <?php echo e((session()->get('noty')['message'])); ?>

                                                </div>
                                            <?php endif; ?>
                                        </p>
                                        <div class="card-content">
                                            <div class="card-body pt-1">
                                                <form action="<?php echo e(route('auth.login.post')); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="username" name="username" placeholder="شماره تماس" required>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>
                                                        <label for="username">شماره تماس</label>
                                                    </fieldset>

                                                    <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input type="password" class="form-control" id="password" name="password" placeholder="کلمه عبور" required>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-lock"></i>
                                                        </div>
                                                        <label for="password">کلمه عبور</label>
                                                    </fieldset>
                                                    <div class="form-group d-flex justify-content-between align-items-center">
                                                        <div class="text-left">
                                                            <fieldset class="checkbox">
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <input type="checkbox" name="remember">
                                                                    <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span class="">ذخیره رمز عبور</span>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="text-right"><a href="auth-forgot-password.html" class="card-link">رمز خود را فراموش کرده اید؟</a></div>
                                                    </div>
                                                    <a href="auth-register.html" class="btn btn-outline-primary float-left btn-inline">ثبت نام</a>
                                                    <button type="submit" class="btn btn-primary float-right btn-inline">ورود به حساب کاربری</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="login-footer">
                                            <div class="divider">
                                                <div class="divider-text">ما را در شبکه های اجتماعی دنبال نمایید</div>
                                            </div>
                                            <div class="footer-btn d-inline">
                                                <a href="#" class="btn btn-facebook"><span class="fa fa-facebook"></span></a>
                                                <a href="#" class="btn btn-twitter white"><span class="fa fa-twitter"></span></a>
                                                
                                                <a href="#" class="btn btn-linkedin"><span class="fa fa-linkedin"></span></a>
                                                <a href="#" class="btn btn-instagram"><span class="fa fa-instagram"></span></a>
                                                <a href="#" class="btn btn-telegram"><span class="fa fa-telegram"></span></a>
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
    <script src="<?php echo e(asset('app-assets/vendors/js/vendors.min.js')); ?>"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?php echo e(asset('app-assets/js/core/app-menu.js')); ?>"></script>
    <script src="<?php echo e(asset('app-assets/js/core/app.js')); ?>"></script>
    <script src="<?php echo e(asset('app-assets/js/scripts/components.js')); ?>"></script>
    <!-- END: Theme JS-->

    <script src="<?php echo e(asset('app-assets/vendors/js/extensions/toastr.min.js')); ?>"></script>
    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->

    <script src="<?php echo e(asset('js/scripts.js')); ?>"></script>
    <script>
        <?php if(session('noty')): ?>
            messageToast("<?php echo session('noty')['title']; ?>", "<?php echo session('noty')['message']; ?>", "<?php echo session('noty')['status']; ?>", 5000)
            <?php session()->forget('noty') ?>
        <?php endif; ?>
    </script>
</body>
<!-- END: Body-->

</html><?php /**PATH C:\wamp64\www\shixeh\resources\views/login.blade.php ENDPATH**/ ?>