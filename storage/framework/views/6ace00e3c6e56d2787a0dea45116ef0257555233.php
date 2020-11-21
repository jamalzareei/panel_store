
    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="../../../html/rtl/vertical-collapsed-menu-template/index.html">
                        <div class="brand-logo"></div>
                        <h2 class="brand-text mb-0">Vuexy</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                
                
                <?php if(auth()->check() && auth()->user()->hasAnyRole('admin')): ?>
                <li class=" navigation-header"><span>داشبورد</span></li>
                <li class=" nav-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">داشبورد</span></a>
                <?php else: ?>
                <li class=" navigation-header"><span>داشبورد</span></li>
                <li class=" nav-item"><a href="<?php echo e(route('seller.dashboard')); ?>">
                    <i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">داشبورد</span>
                </a></li>
                <?php endif; ?>
                
                
                <li class=" navigation-header"><span>کاربری</span></li>
                        <li class=" nav-item"><a href="<?php echo e(route('user.data')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">اطلاعات کاربری</span>
                        </a></li>
                        <li class=" nav-item"><a href="<?php echo e(route('user.data.email')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">تغییر ایمیل</span>
                        </a></li>
                        <li class=" nav-item"><a href="<?php echo e(route('user.data.phone')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">تغییر تلفن</span>
                        </a></li>
                        <li class=" nav-item"><a href="<?php echo e(route('user.messages')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">چت های کاربران</span>
                        </a></li>
                        <li class=" nav-item"><a href="<?php echo e(route('user.data.change.password')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">تغییر رمز عبور</span>
                        </a></li>
                    
                
                
                <?php if(auth()->check() && auth()->user()->hasAnyRole('admin')): ?>
                
                <li class=" navigation-header"><span>پنل مدیریت</span></li>
                <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="users">کاربران و سطح دسترسی</span></a>
                    <ul class="menu-content">
                        <li><a href="<?php echo e(route('admin.users.list')); ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">لیست کاربران</span></a>
                        </li>
                        <li><a href="<?php echo e(route('admin.roles.list')); ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">سطح دسترسی ها</span></a>
                        </li>
                        <li><a href="<?php echo e(route('admin.permissions.list')); ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">پرمیشن ها</span></a>
                        </li>
                    </ul>
                </li>
                
                <li class=" nav-item"><a href="#"><i class="feather icon-list"></i><span class="menu-title" data-i18n="users">لیست ها</span></a>
                    <ul class="menu-content">
                        <li><a href="<?php echo e(route('admin.categories.list')); ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">لیست دسته بندی ها</span></a></li>
                        <li><a href="<?php echo e(route('admin.properties.list')); ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">لیست پراپرتی ها</span></a></li>
                        <li><a href="<?php echo e(route('admin.tags.list')); ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="">لیست تگ ها</span></a></li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="users">فروشندگان</span></a>
                    <ul class="menu-content">
                        <li><a href="<?php echo e(route('admin.sellers.list', ['type' => 'wait-active-admin'])); ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> فروشندگان در انتظار تایید</span></a></li>
                        <li><a href="<?php echo e(route('admin.sellers.list', ['type' => 'not-complete-data'])); ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> فروشندگان در حال تکمیل</span></a></li>
                        <li><a href="<?php echo e(route('admin.sellers.list', ['type' => 'compete-and-active-admin'])); ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> فروشندگان تایید شده</span></a></li>
                    </ul>
                </li>
                
                <li class=" nav-item"><a href="#"><i class="feather icon-product"></i><span class="menu-title" data-i18n="users">محصولات</span></a>
                    <ul class="menu-content">
                        <li><a href="<?php echo e(route('admin.products.get', ['status' => 'active'])); ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> محصولات در انتظار تایید</span></a></li>
                        <li><a href="<?php echo e(route('admin.products.get', ['status' => 'publish'])); ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> محصولات تایید شده</span></a></li>
                    </ul>
                </li>
                
                <li class=" nav-item"><a href="#"><i class="feather icon-page"></i><span class="menu-title" data-i18n="users">صفحه ایستا</span></a>
                    <ul class="menu-content">
                        <li><a href="<?php echo e(route('admin.pages.get')); ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n=""> لیست صفحات </span></a></li>
                    </ul>
                </li>
                <?php endif; ?>
                
                <?php if(auth()->check() && auth()->user()->hasAnyRole('seller')): ?>
                <li class=" navigation-header"><span>پنل فروشنده</span></li>
            
                <li class=" nav-item"><a href="#"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="users">فروشنده</span></a>
                    <ul class="menu-content">
                        <li class=" nav-item"><a href="<?php echo e(route('seller.data.get')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">اطلاعات نمایشی</span>
                        </a></li>
                        <li class=" nav-item"><a href="<?php echo e(route('seller.brancehs.get')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">تعریف و لیست شعبه ها</span>
                        </a></li>
                        <li class=" nav-item"><a href="<?php echo e(route('seller.setting.get')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">تنظیمات فروشگاه</span>
                            </a><a href="<?php echo e(route('seller.setting.get')); ?>" class="pt-0">
                            <small class="small pl-3 font-small-1">(ارتباط با مشتری، هزینه و زمان ارسال)</small>
                        </a></li>
                        <li class=" nav-item"><a href="<?php echo e(route('seller.socials.get')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">شبکه های اجتماعی</span>
                        </a></li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="fa fa-money"></i><span class="menu-title" data-i18n="users">اطلاعات مالی</span></a>
                    <ul class="menu-content">
                        <li class=" nav-item"><a href="<?php echo e(route('seller.finances.get')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">اضافه / ویرایش حساب </span>
                        </a><a href="<?php echo e(route('seller.finances.get')); ?>" class="pt-0">
                            <small class="small pl-3 font-small-1">(لیست حساب ها، اضافه و ویرایش)</small>
                        </a></li>
                        <li class=" nav-item"><a href="<?php echo e(route('user.data.email')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">لیست تراکنش ها</span>
                        </a></li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="fa fa-money"></i><span class="menu-title" data-i18n="users">محصولات</span></a>
                    <ul class="menu-content">
                        <li class=" nav-item"><a href="<?php echo e(route('seller.product.updateorcreate')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">اضافه محصول </span>
                        </a><a href="<?php echo e(route('seller.product.updateorcreate')); ?>" class="pt-0">
                            <small class="small pl-3 font-small-1">(لیست حساب ها، اضافه و ویرایش)</small>
                        </a></li>
                        <li class=" nav-item"><a href="<?php echo e(route('seller.products.get')); ?>">
                            <i class="feather icon-circle"></i><span class="menu-title" data-i18n="Dashboard">لیست محصولات</span>
                        </a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <li class=" navigation-header"><span>Apps</span>
                </li>
                <li class=" nav-item"><a href="app-email.html"><i class="feather icon-mail"></i><span class="menu-title" data-i18n="Email">Email</span></a>
                </li>
                <li class=" nav-item"><a href="app-chat.html"><i class="feather icon-message-square"></i><span class="menu-title" data-i18n="Chat">Chat</span></a>
                </li>
                <li class=" nav-item"><a href="app-todo.html"><i class="feather icon-check-square"></i><span class="menu-title" data-i18n="Todo">Todo</span></a>
                </li>
                <li class=" nav-item"><a href="app-calender.html"><i class="feather icon-calendar"></i><span class="menu-title" data-i18n="Calender">Calender</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-shopping-cart"></i><span class="menu-title" data-i18n="Ecommerce">Ecommerce</span></a>
                    <ul class="menu-content">
                        <li><a href="app-ecommerce-shop.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Shop">Shop</span></a>
                        </li>
                        <li><a href="app-ecommerce-details.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Details">Details</span></a>
                        </li>
                        <li><a href="app-ecommerce-wishlist.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Wish List">Wish List</span></a>
                        </li>
                        <li><a href="app-ecommerce-checkout.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Checkout">Checkout</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="User">User</span></a>
                    <ul class="menu-content">
                        <li><a href="app-user-list.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List">List</span></a>
                        </li>
                        <li><a href="app-user-view.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="View">View</span></a>
                        </li>
                        <li><a href="app-user-edit.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Edit">Edit</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" navigation-header"><span>UI Elements</span>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-list"></i><span class="menu-title" data-i18n="Data List">Data List</span><span class="badge badge badge-primary badge-pill float-right mr-2">New</span></a>
                    <ul class="menu-content">
                        <li><a href="data-list-view.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List View">List View</span></a>
                        </li>
                        <li><a href="data-thumb-view.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Thumb View">Thumb View</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-layout"></i><span class="menu-title" data-i18n="Content">Content</span></a>
                    <ul class="menu-content">
                        <li><a href="content-grid.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Grid">Grid</span></a>
                        </li>
                        <li><a href="content-typography.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Typography">Typography</span></a>
                        </li>
                        <li><a href="content-text-utilities.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Text Utilities">Text Utilities</span></a>
                        </li>
                        <li><a href="content-syntax-highlighter.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Syntax Highlighter">Syntax Highlighter</span></a>
                        </li>
                        <li><a href="content-helper-classes.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Helper Classes">Helper Classes</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="colors.html"><i class="feather icon-droplet"></i><span class="menu-title" data-i18n="Colors">Colors</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-eye"></i><span class="menu-title" data-i18n="Icons">Icons</span></a>
                    <ul class="menu-content">
                        <li><a href="icons-feather.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Feather">Feather</span></a>
                        </li>
                        <li><a href="icons-font-awesome.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Font Awesome">Font Awesome</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-credit-card"></i><span class="menu-title" data-i18n="Card">Card</span></a>
                    <ul class="menu-content">
                        <li><a href="card-basic.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Basic">Basic</span></a>
                        </li>
                        <li><a href="card-advance.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Advance">Advance</span></a>
                        </li>
                        <li><a href="card-statistics.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Statistics">Statistics</span></a>
                        </li>
                        <li><a href="card-analytics.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Analytics">Analytics</span></a>
                        </li>
                        <li><a href="card-actions.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Card Actions">Card Actions</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-briefcase"></i><span class="menu-title" data-i18n="Components">Components</span></a>
                    <ul class="menu-content">
                        <li><a href="component-alerts.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Alerts">Alerts</span></a>
                        </li>
                        <li><a href="component-buttons-basic.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Buttons">Buttons</span></a>
                        </li>
                        <li><a href="component-breadcrumbs.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Breadcrumbs">Breadcrumbs</span></a>
                        </li>
                        <li><a href="component-carousel.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Carousel">Carousel</span></a>
                        </li>
                        <li><a href="component-collapse.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Collapse">Collapse</span></a>
                        </li>
                        <li><a href="component-dropdowns.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Dropdowns">Dropdowns</span></a>
                        </li>
                        <li><a href="component-list-group.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="List Group">List Group</span></a>
                        </li>
                        <li><a href="component-modals.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Modals">Modals</span></a>
                        </li>
                        <li><a href="component-pagination.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Pagination">Pagination</span></a>
                        </li>
                        <li><a href="component-navs-component.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Navs Component">Navs Component</span></a>
                        </li>
                        <li><a href="component-navbar.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Navbar">Navbar</span></a>
                        </li>
                        <li><a href="component-tabs-component.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Tabs Component">Tabs Component</span></a>
                        </li>
                        <li><a href="component-pills-component.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Pills Component">Pills Component</span></a>
                        </li>
                        <li><a href="component-tooltips.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Tooltips">Tooltips</span></a>
                        </li>
                        <li><a href="component-popovers.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Popovers">Popovers</span></a>
                        </li>
                        <li><a href="component-badges.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Badges">Badges</span></a>
                        </li>
                        <li><a href="component-pill-badges.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Pill Badges">Pill Badges</span></a>
                        </li>
                        <li><a href="component-progress.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Progress">Progress</span></a>
                        </li>
                        <li><a href="component-media-objects.html"><i class="feather icon-circle"></i><span class="menu-item">Media Objects</span></a>
                        </li>
                        <li><a href="component-spinner.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Spinner">Spinner</span></a>
                        </li>
                        <li><a href="component-bs-toast.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Toasts">Toasts</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-box"></i><span class="menu-title" data-i18n="Extra Components">Extra Components</span></a>
                    <ul class="menu-content">
                        <li><a href="ex-component-avatar.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Avatar">Avatar</span></a>
                        </li>
                        <li><a href="ex-component-chips.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Chips">Chips</span></a>
                        </li>
                        <li><a href="ex-component-divider.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Divider">Divider</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" navigation-header"><span>Forms &amp; Tables</span>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-copy"></i><span class="menu-title" data-i18n="Form Elements">Form Elements</span></a>
                    <ul class="menu-content">
                        <li><a href="form-select.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Select">Select</span></a>
                        </li>
                        <li><a href="form-switch.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Switch">Switch</span></a>
                        </li>
                        <li><a href="form-checkbox.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Checkbox">Checkbox</span></a>
                        </li>
                        <li><a href="form-radio.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Radio">Radio</span></a>
                        </li>
                        <li><a href="form-inputs.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Input">Input</span></a>
                        </li>
                        <li><a href="form-input-groups.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Input Groups">Input Groups</span></a>
                        </li>
                        <li><a href="form-number-input.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Number Input">Number Input</span></a>
                        </li>
                        <li><a href="form-textarea.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Textarea">Textarea</span></a>
                        </li>
                        <li><a href="form-date-time-picker.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Date &amp; Time Picker">Date &amp; Time Picker</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="form-layout.html"><i class="feather icon-box"></i><span class="menu-title" data-i18n="Form Layout">Form Layout</span></a>
                </li>
                <li class=" nav-item"><a href="form-wizard.html"><i class="feather icon-package"></i><span class="menu-title" data-i18n="Form Wizard">Form Wizard</span></a>
                </li>
                <li class=" nav-item"><a href="form-validation.html"><i class="feather icon-check-circle"></i><span class="menu-title" data-i18n="Form Validation">Form Validation</span></a>
                </li>
                <li class=" nav-item"><a href="table.html"><i class="feather icon-server"></i><span class="menu-title" data-i18n="Table">Table</span></a>
                </li>
                <li class=" nav-item"><a href="table-datatable.html"><i class="feather icon-grid"></i><span class="menu-title" data-i18n="Datatable">Datatable</span></a>
                </li>
                <li class=" nav-item"><a href="table-ag-grid.html"><i class="feather icon-grid"></i><span class="menu-title" data-i18n="ag-grid">agGrid Table</span><span class="badge badge badge-primary badge-pill float-right mr-2">New</span></a>
                </li>
                <li class=" navigation-header"><span>pages</span>
                </li>
                <li class=" nav-item"><a href="page-user-profile.html"><i class="feather icon-user"></i><span class="menu-title" data-i18n="Profile">Profile</span></a>
                </li>
                <li class=" nav-item"><a href="page-account-settings.html"><i class="feather icon-settings"></i><span class="menu-title" data-i18n="Account Settings">Account Settings</span></a>
                </li>
                <li class=" nav-item"><a href="page-faq.html"><i class="feather icon-help-circle"></i><span class="menu-title" data-i18n="FAQ">FAQ</span></a>
                </li>
                <li class=" nav-item"><a href="page-knowledge-base.html"><i class="feather icon-info"></i><span class="menu-title" data-i18n="Knowledge Base">Knowledge Base</span></a>
                </li>
                <li class=" nav-item"><a href="page-search.html"><i class="feather icon-search"></i><span class="menu-title" data-i18n="Search">Search</span></a>
                </li>
                <li class=" nav-item"><a href="page-invoice.html"><i class="feather icon-file"></i><span class="menu-title" data-i18n="Invoice">Invoice</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-zap"></i><span class="menu-title" data-i18n="Starter kit">Starter kit</span></a>
                    <ul class="menu-content">
                        <li><a href="../../../starter-kit/rtl/vertical-collapsed-menu-template/sk-layout-2-columns.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="2 columns">2 columns</span></a>
                        </li>
                        <li><a href="../../../starter-kit/rtl/vertical-collapsed-menu-template/sk-layout-fixed-navbar.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Fixed navbar">Fixed navbar</span></a>
                        </li>
                        <li><a href="../../../starter-kit/rtl/vertical-collapsed-menu-template/sk-layout-floating-navbar.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Floating navbar">Floating navbar</span></a>
                        </li>
                        <li><a href="../../../starter-kit/rtl/vertical-collapsed-menu-template/sk-layout-fixed.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Fixed layout">Fixed layout</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-unlock"></i><span class="menu-title" data-i18n="Authentication">Authentication</span></a>
                    <ul class="menu-content">
                        <li><a href="auth-login.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Login">Login</span></a>
                        </li>
                        <li><a href="auth-register.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Register">Register</span></a>
                        </li>
                        <li><a href="auth-forgot-password.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Forgot Password">Forgot Password</span></a>
                        </li>
                        <li><a href="auth-reset-password.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Reset Password">Reset Password</span></a>
                        </li>
                        <li><a href="auth-lock-screen.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Lock Screen">Lock Screen</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-file-text"></i><span class="menu-title" data-i18n="Miscellaneous">Miscellaneous</span></a>
                    <ul class="menu-content">
                        <li><a href="page-coming-soon.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Coming Soon">Coming Soon</span></a>
                        </li>
                        <li><a href="#"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Error">Error</span></a>
                            <ul class="menu-content">
                                <li><a href="error-404.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="404">404</span></a>
                                </li>
                                <li><a href="error-500.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="500">500</span></a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="page-not-authorized.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Not Authorized">Not Authorized</span></a>
                        </li>
                        <li><a href="page-maintenance.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Maintenance">Maintenance</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" navigation-header"><span>Charts &amp; Maps</span>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-pie-chart"></i><span class="menu-title" data-i18n="Charts">Charts</span><span class="badge badge badge-pill badge-success float-right mr-2">3</span></a>
                    <ul class="menu-content">
                        <li><a href="chart-apex.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Apex">Apex</span></a>
                        </li>
                        <li><a href="chart-chartjs.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Chartjs">Chartjs</span></a>
                        </li>
                        <li><a href="chart-echarts.html"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Echarts">Echarts</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="maps-google.html"><i class="feather icon-map"></i><span class="menu-title" data-i18n="Google Maps">Google Maps</span></a>
                </li>
                <li class=" navigation-header"><span>Extensions</span>
                </li>
                <li class=" nav-item"><a href="ext-component-sweet-alerts.html"><i class="feather icon-alert-circle"></i><span class="menu-title" data-i18n="Sweet Alert">Sweet Alert</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-toastr.html"><i class="feather icon-zap"></i><span class="menu-title" data-i18n="Toastr">Toastr</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-noui-slider.html"><i class="feather icon-sliders"></i><span class="menu-title" data-i18n="NoUi Slider">NoUi Slider</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-file-uploader.html"><i class="feather icon-upload-cloud"></i><span class="menu-title" data-i18n="File Uploader">File Uploader</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-quill-editor.html"><i class="feather icon-edit"></i><span class="menu-title" data-i18n="Quill Editor">Quill Editor</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-drag-drop.html"><i class="feather icon-droplet"></i><span class="menu-title" data-i18n="Drag &amp; Drop">Drag &amp; Drop</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-tour.html"><i class="feather icon-info"></i><span class="menu-title" data-i18n="Tour">Tour</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-clipboard.html"><i class="feather icon-copy"></i><span class="menu-title" data-i18n="Clipboard">Clipboard</span></a>
                </li>
                <li class=" nav-item"><a href=" ext-component-plyr.html"><i class="feather icon-film"></i><span class="menu-title" data-i18n="Media player">Media player</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-context-menu.html"><i class="feather icon-more-horizontal"></i><span class="menu-title" data-i18n="Context Menu">Context Menu</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-swiper.html"><i class="feather icon-smartphone"></i><span class="menu-title" data-i18n="swiper">swiper</span></a>
                </li>
                <li class=" nav-item"><a href="ext-component-i18n.html"><i class="feather icon-globe"></i><span class="menu-title" data-i18n="l18n">l18n</span></a>
                </li>
                <li class=" navigation-header"><span>Others</span>
                </li>
                <li class=" nav-item"><a href="#"><i class="feather icon-menu"></i><span class="menu-title" data-i18n="Menu Levels">Menu Levels</span></a>
                    <ul class="menu-content">
                        <li><a href="#"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Second Level">Second Level</span></a>
                        </li>
                        <li><a href="#"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Second Level">Second Level</span></a>
                            <ul class="menu-content">
                                <li><a href="#"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Third Level">Third Level</span></a>
                                </li>
                                <li><a href="#"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Third Level">Third Level</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="disabled nav-item"><a href="#"><i class="feather icon-eye-off"></i><span class="menu-title" data-i18n="Disabled Menu">Disabled Menu</span></a>
                </li>
                <li class=" navigation-header"><span>Support</span>
                </li>
                <li class=" nav-item"><a href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/documentation"><i class="feather icon-folder"></i><span class="menu-title" data-i18n="Documentation">Documentation</span></a>
                </li>
                <li class=" nav-item"><a href="https://pixinvent.ticksy.com/"><i class="feather icon-life-buoy"></i><span class="menu-title" data-i18n="Raise Support">Raise Support</span></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Main Menu--><?php /**PATH C:\wamp64\www\shixeh\resources\views/components/main-menu.blade.php ENDPATH**/ ?>