<?php
$user = \App\User::where('id', Auth::id())
    ->with([
        'image' => function ($query) {
            $query->select('path', 'id', 'imageable_id')->where('default_use', 'MAIN')->orderBy('id', 'desc')->first();
        },
        'seller' => function($qSeller){
            $qSeller->with(['image']);
        },
        'roles'
    ])
    ->first();
    
    // dd($user->seller);
?>
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
                        <!-- li.nav-item.mobile-menu.d-xl-none.mr-auto-->
                        <!--   a.nav-link.nav-menu-main.menu-toggle.hidden-xs(href='#')-->
                        <!--     i.ficon.feather.icon-menu-->
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-todo.html" data-toggle="tooltip" data-placement="top" title="Todo"><i class="ficon feather icon-check-square"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat.html" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon feather icon-message-square"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email.html" data-toggle="tooltip" data-placement="top" title="Email"><i class="ficon feather icon-mail"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calender.html" data-toggle="tooltip" data-placement="top" title="Calendar"><i class="ficon feather icon-calendar"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon feather icon-star warning"></i></a>
                            <div class="bookmark-input search-input">
                                <div class="bookmark-input-icon"><i class="feather icon-search primary"></i></div>
                                <input class="form-control input" type="text" placeholder="Explore Vuexy..." tabindex="0" data-search="template-list">
                                <ul class="search-list search-list-bookmark"></ul>
                            </div>
                            <!-- select.bookmark-select-->
                            <!--   option Chat-->
                            <!--   option email-->
                            <!--   option todo-->
                            <!--   option Calendar-->
                        </li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <?php if($user && $user->roles && $user->roles->where('slug', 'SELLER')->first() && !$user->roles->where('slug', 'ADMIN')->first()): ?>
                        
                        <li class="nav-item d-none d-lg-block">
                            <?php if($user && $user->seller && $user->seller->admin_actived_id): ?>
                                <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                    <div class="user-nav d-sm-flex d-none">
                                        <span class="user-name text-bold-600 py-1 text-success">فروشگاه شما تایید شده است.</span>
                                    </div>
                                </a>
                            <?php elseif($user && $user->seller && $user->seller->actived_at): ?>
                                <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                    <div class="user-nav d-sm-flex d-none">
                                        <span class="user-name text-bold-600 py-1 text-info">فروشگاه جهت بررسی مدیریت ارسال گردیده است.</span>
                                    </div>
                                </a>
                            <?php elseif($user && $user->seller && ( !$user->seller->image || !isset($user->seller->image) || !isset($user->seller->image->path ))): ?>
                                <a class="btn btn-danger text-white my-1" href="<?php echo e(route('seller.data.get')); ?>" >
                                    آپلود لوگو
                                </a>
                            <?php elseif($user && $user->seller && (!$user->seller->sell_type_id || !$user->seller->pay_type_id)): ?>
                                <a class="btn btn-danger text-white my-1" href="<?php echo e(route('seller.setting.get')); ?>" >
                                    تنظیمات فروشگاه
                                </a>
                            <?php elseif($user && $user->seller && !$user->seller->actived_at): ?>
                                <a class="btn btn-danger text-white my-1" href="<?php echo e(route('seller.send.admin')); ?>">
                                    ارسال به مدیریت جهت بررسی
                                </a>
                            <?php endif; ?>
                        </li>
                        <?php if($user && $user->seller && $user->seller->admin_actived_id && request()->route()->getName() != 'seller.product.updateorcreate'): ?>
                            <li class="nav-item d-none d-lg-block">
                                <a class="btn bg-gradient-success text-white my-1 font-weight-bold" href="<?php echo e(route('seller.product.updateorcreate')); ?>">
                                    اضافه کردن محصول
                                </a>
                            </li>
                        <?php endif; ?>
                    
                    <?php endif; ?>
                    
                    
                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon feather icon-maximize"></i></a></li>
                    
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-shopping-cart"></i><span class="badge badge-pill badge-primary badge-up cart-item-count">6</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-cart dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header m-0 p-2">
                                    <h3 class="white"><span class="cart-item-count">6</span><span class="mx-50">Items</span></h3><span class="notification-title">In Your Cart</span>
                                </div>
                            </li>
                            <li class="scrollable-container media-list">
                                <a class="cart-item" href="app-ecommerce-details.html">
                                    <div class="media">
                                        <div class="media-left d-flex justify-content-center align-items-center"><img src="<?php echo e(asset('app-assets/images/pages/eCommerce/4.png')); ?>" width="75" alt="Cart Item"></div>
                                        <div class="media-body"><span class="item-title text-truncate text-bold-500 d-block mb-50">Apple - Apple Watch Series 1 42mm Space Gray Aluminum Case Black Sport Band - Space Gray Aluminum</span><span class="item-desc font-small-2 text-truncate d-block"> Durable, lightweight aluminum cases in silver, space gray,gold, and rose gold. Sport Band in a variety of colors. All the features of the original Apple Watch, plus a new dual-core processor for faster performance. All models run watchOS 3. Requires an iPhone 5 or later to run this device.</span>
                                            <div class="d-flex justify-content-between align-items-center mt-1"><span class="align-middle d-block">1 x $299</span><i class="remove-cart-item feather icon-x danger font-medium-1"></i></div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center text-primary" href="app-ecommerce-checkout.html"><i class="feather icon-shopping-cart align-middle"></i><span class="align-middle text-bold-600">Checkout</span></a></li>
                            <li class="empty-cart d-none p-2">Your Cart Is Empty.</li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item" id="notifictations-user-noty">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                            <i class="ficon feather icon-bell"></i><span class="badge badge-pill badge-primary badge-up">5</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header m-0 p-2">
                                    <h3 class="white">5 New</h3><span class="notification-title">App Notifications</span>
                                </div>
                            </li>
                            <li class="scrollable-container media-list"><a class="d-flex justify-content-between" href="javascript:void(0)">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-plus-square font-medium-5 primary"></i></div>
                                        <div class="media-body">
                                            <h6 class="primary media-heading">You have new order!</h6><small class="notification-text"> Are your going to meet me tonight?</small>
                                        </div><small>
                                            <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">9 hours ago</time></small>
                                    </div>
                                </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-download-cloud font-medium-5 success"></i></div>
                                        <div class="media-body">
                                            <h6 class="success media-heading red darken-1">99% Server load</h6><small class="notification-text">You got new order of goods.</small>
                                        </div><small>
                                            <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">5 hour ago</time></small>
                                    </div>
                                </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-alert-triangle font-medium-5 danger"></i></div>
                                        <div class="media-body">
                                            <h6 class="danger media-heading yellow darken-3">Warning notifixation</h6><small class="notification-text">Server have 99% CPU usage.</small>
                                        </div><small>
                                            <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
                                    </div>
                                </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-check-circle font-medium-5 info"></i></div>
                                        <div class="media-body">
                                            <h6 class="info media-heading">Complete the task</h6><small class="notification-text">Cake sesame snaps cupcake</small>
                                        </div><small>
                                            <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">Last week</time></small>
                                    </div>
                                </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-file font-medium-5 warning"></i></div>
                                        <div class="media-body">
                                            <h6 class="warning media-heading">Generate monthly report</h6><small class="notification-text">Chocolate cake oat cake tiramisu marzipan</small>
                                        </div><small>
                                            <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">Last month</time></small>
                                    </div>
                                </a></li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center" href="javascript:void(0)">View all notifications</a></li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                    <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600 load-fullname"><?php echo e(auth()->user()->full_name ?? ''); ?></span><span class="user-status">آنلاین</span></div><span><img class="round load-avatar" src="<?php echo e(($user && $user->image && $user->image->path) ? config('shixeh.cdn_domain_files').$user->image->path : config('shixeh.path_logo')); ?>" alt="avatar" height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="page-user-profile.html"><i class="feather icon-user"></i> ویرایش اطلاعات</a><a class="dropdown-item" href="app-email.html"><i class="feather icon-mail"></i> پیام های دریافتی</a><a class="dropdown-item" href="app-todo.html"><i class="feather icon-check-square"></i> موارد پیش رو</a><a class="dropdown-item" href="app-chat.html"><i class="feather icon-message-square"></i> گفتگو و تیکت</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo e(route('logout.user')); ?>"><i class="feather icon-power"></i> خروج</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav><?php /**PATH C:\wamp64\www\shixeh\resources\views/components/navbar.blade.php ENDPATH**/ ?>