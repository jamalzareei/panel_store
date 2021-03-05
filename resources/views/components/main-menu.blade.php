
    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="/">
                        <div class="brand-logo"></div>
                        <h2 class="brand-text px-1">
                            <img src="{{ config('shixeh.path_logo') }}" alt="" height="40">
                        </h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                {{-- <li class=" nav-item"><a href="index.html"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span><span class="badge badge badge-warning badge-pill float-right mr-2">2</span></a>
                    <ul class="menu-content">
                        <li><a href="dashboard-analytics.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Analytics">Analytics</span></a>
                        </li>
                        <li><a href="dashboard-ecommerce.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="eCommerce">eCommerce</span></a>
                        </li>
                    </ul>
                </li> --}}

                @hasanyrole('admin')
                <li class=" navigation-header"><span>داشبورد</span></li>
                <li class=" nav-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">داشبورد</span></a>
                @else
                <li class=" navigation-header"><span>داشبورد</span></li>
                <li class=" nav-item"><a href="{{ route('seller.dashboard') }}">
                    <i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">داشبورد</span>
                </a></li>
                @endhasanyrole



                @hasanyrole('admin')

                <li class=" navigation-header"><span>پنل مدیریت</span></li>
                <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="users">کاربران و سطح دسترسی</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('admin.users.list') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">لیست کاربران</span></a>
                        </li>
                        <li><a href="{{ route('admin.roles.list') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">سطح دسترسی ها</span></a>
                        </li>
                        <li><a href="{{ route('admin.permissions.list') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">پرمیشن ها</span></a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-list"></i><span class="menu-title" data-i18n="users">لیست ها</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('admin.categories.list') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">لیست دسته بندی ها</span></a></li>
                        <li><a href="{{ route('admin.properties.list') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">لیست پراپرتی ها</span></a></li>
                        <li><a href="{{ route('admin.tags.list') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">لیست تگ ها</span></a></li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="users">فروشندگان</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('admin.sellers.list', ['type' => 'wait-active-admin']) }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> فروشندگان در انتظار تایید</span></a></li>
                        <li><a href="{{ route('admin.sellers.list', ['type' => 'not-complete-data']) }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> فروشندگان در حال تکمیل</span></a></li>
                        <li><a href="{{ route('admin.sellers.list', ['type' => 'comlpete-and-active-admin']) }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> فروشندگان تایید شده</span></a></li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-product"></i><span class="menu-title" data-i18n="users">محصولات</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('admin.products.get', ['status' => 'active']) }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> محصولات در انتظار تایید</span></a></li>
                        <li><a href="{{ route('admin.products.get', ['status' => 'publish']) }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> محصولات تایید شده</span></a></li>
                    </ul>
                </li>
                
                <li class=" nav-item"><a href="#"><i class="feather icon-page"></i><span class="menu-title" data-i18n="users">لیست شبکه های اجتماعی </span></a>
                    <ul class="menu-content">
                        
                        <li><a href="{{ route('admin.socials.seller') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> لیست شبکه های اجتماعی </span></a></li>
                        
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-page"></i><span class="menu-title" data-i18n="users">صفحه ایستا</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('admin.pages.get') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> لیست صفحات </span></a></li>
                    </ul>
                </li>

                
                <li><a href="{{ route('admin.tickets') }}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> تیکت های کاربران </span></a></li>
                
                @endhasanyrole

                @hasanyrole('seller')
                <li class=" navigation-header"><span>پنل فروشنده</span></li>

                <li class=" nav-item"><a href="#"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="users">فروشنده</span></a>
                    <ul class="menu-content">
                        <li class=" nav-item"><a href="{{ route('seller.data.get') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">اطلاعات نمایشی</span>
                        </a></li>
                        <li class=" nav-item"><a href="{{ route('seller.brancehs.get') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">تعریف و لیست شعبه ها</span>
                        </a></li>
                        <li class=" nav-item"><a href="{{ route('seller.setting.get') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">تنظیمات فروشگاه</span>
                            </a><a href="{{ route('seller.setting.get') }}" class="pt-0">
                            <small class="small pl-3 font-small-1">(ارتباط با مشتری، هزینه و زمان ارسال)</small>
                        </a></li>
                        <li class=" nav-item"><a href="{{ route('seller.socials.get') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">شبکه های اجتماعی</span>
                        </a></li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="fa fa-money"></i><span class="menu-title" data-i18n="users">اطلاعات مالی</span></a>
                    <ul class="menu-content">
                        <li class=" nav-item"><a href="{{ route('seller.finances.get') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">اضافه / ویرایش حساب </span>
                        </a><a href="{{ route('seller.finances.get') }}" class="pt-0">
                            <small class="small pl-3 font-small-1">(لیست حساب ها، اضافه و ویرایش)</small>
                        </a></li>
                        <li class=" nav-item"><a href="{{ route('seller.dashboard') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">لیست تراکنش ها</span>
                        </a></li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="fa fa-money"></i><span class="menu-title" data-i18n="users">محصولات</span></a>
                    <ul class="menu-content">
                        <li class=" nav-item"><a href="{{ route('seller.product.updateorcreate') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">اضافه محصول </span>
                        </a><a href="{{ route('seller.product.updateorcreate') }}" class="pt-0">
                            <small class="small pl-3 font-small-1">(لیست حساب ها، اضافه و ویرایش)</small>
                        </a></li>
                        <li class=" nav-item"><a href="{{ route('seller.products.get') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">لیست محصولات</span>
                        </a></li>

                        {{-- <li class=" nav-item"><a href="{{ route('seller.read.instragram') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard"> پست های اینستاگرام من </span>
                        </a></li>
                        <li class=" nav-item"><a href="{{ route('seller.read.instragram.username.v2') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">پست های اینستاگرام من 2</span>
                        </a></li> --}}

                        
                        <li class=" nav-item"><a href="{{ route('seller.connect.instragram') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">ورود محصولات با اینستاگرام</span>
                            </a><a href="{{ route('seller.connect.instragram') }}" class="pt-0">
                            <small class="small pl-3 font-small-1">(ورژن 1)</small>
                        </a></li>
                        <li class=" nav-item"><a href="{{ route('seller.connect.instragram.v2') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">ورود محصولات با اینستاگرام</span>
                            </a><a href="{{ route('seller.connect.instragram.v2') }}" class="pt-0">
                            <small class="small pl-3 font-small-1">(ورژن 2)</small>
                        </a></li>
                    </ul>
                </li>
                
                <li class=" nav-item"><a href="#"><i class="fa fa-money"></i><span class="menu-title" data-i18n="users">سفارشات</span></a>
                    <ul class="menu-content">
                        <li class=" nav-item"><a href="{{ route('seller.orders.await') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">سفارش های در انتظار</span>
                        </a></li>
                        <li class=" nav-item"><a href="{{ route('seller.orders') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard"> آرشیو سفارشات  </span>
                        </a></li>
                    </ul>
                </li>
                
                <li class=" nav-item"><a href="#"><i class="fa fa-money"></i><span class="menu-title" data-i18n="users">نظرات کاربران</span></a>
                    <ul class="menu-content">
                        <li class=" nav-item"><a href="{{ route('seller.reviews.products') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">نظرات روی محصولات</span>
                        </a></li>
                        <li class=" nav-item"><a href="{{ route('seller.reviews.seller') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard"> نظرات روی صفحه فروشندگی </span>
                        </a></li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="{{ route('seller.dashboard') }}">
                    <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">اضافه کردن کد تخفیف</span>
                </a></li>
                
                <li class=" nav-item"><a href="{{ route('seller.dashboard') }}">
                    <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">درخواست تبلیغات ویژه</span>
                </a><a href="{{ route('seller.connect.instragram.v2') }}" class="pt-0">
                    <small class="small pl-3 font-small-1">( در صفحه اصلی)</small>
                </a></li>

                <li class=" nav-item"><a href="{{ route('seller.dashboard') }}">
                    <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">تغییر پلان مورد نظر</span>
                </a></li>

                @endhasanyrole

                
                {{-- <li class=" nav-item"><a href="#"><i class="feather icon-user-check"></i><span class="menu-title" data-i18n="users">کاربری</span></a>
                    <ul class="menu-content"> --}}
                        <li class=" navigation-header"><span>کاربری</span></li>
                        <li class=" nav-item"><a href="{{ route('user.data') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">اطلاعات کاربری</span>
                        </a></li>
                        <li class=" nav-item"><a href="{{ route('user.data.email') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">تغییر ایمیل</span>
                        </a></li>
                        {{-- <li class=" nav-item"><a href="{{ route('user.data.phone') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">تغییر تلفن</span>
                        </a></li> --}}
                        <li class=" nav-item"><a href="{{ route('user.messages') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">اطلاعیه ها و چت های کاربران</span>
                        </a></li>
                        <li class=" nav-item"><a href="{{ route('user.tickets') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">پیام های پشتیبانی</span>
                        </a></li>
                        <li class=" nav-item"><a href="{{ route('user.data.change.password') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">تغییر رمز عبور</span>
                        </a></li>

                        <li class=" nav-item"><a href="{{ route('logout.user') }}">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">خروج از حساب کاربری</span>
                        </a></li>
                    {{-- </ul>
                </li> --}}

            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->
