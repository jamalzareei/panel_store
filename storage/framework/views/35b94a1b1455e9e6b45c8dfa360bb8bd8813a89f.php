

<?php $__env->startSection('head'); ?>
    
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/forms/select/select2.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    
<script src="<?php echo e(asset('app-assets/vendors/js/forms/select/select2.full.min.js')); ?>"></script>
    <script>
        
        $(".select2").select2({
            dir: "rtl",
            dropdownAutoWidth: true,
            width: '100%'
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
<form action="<?php echo e(route('user.data.post')); ?>" method="post" class="ajaxForm">
    <?php echo csrf_field(); ?>
    
    <div class="content-body">
        <!-- Basic Horizontal form layout section start -->
        <section id="basic-horizontal-layouts">
            <div class="row match-height">
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">ویرایش اطلاعات کاربری</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12 text-center mb-3">
                                            
                                            <input type="hidden" name="image_file" class="image_file">
                                            <p class="text-info">برای تغییر عکس پروفایل از باکس سمت چپ عکس خود را انتخاب نمایید.</p>
                                            <small class="help-block text-danger error-image_file w-100 m-1 row text-center"></small>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="firstname">نام</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="firstname" class="form-control" name="firstname" placeholder="نام" value="<?php echo e($user->firstname); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                    <small class="help-block text-danger error-firstname"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="lastname">نام خانوادگی</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="lastname" class="form-control" name="lastname" placeholder="نام خانوادگی" value="<?php echo e($user->lastname); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                    <small class="help-block text-danger error-lastname"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="contact-info-icon">تاریخ تولد</label>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <select name="day" id="" class="select2">
                                                            <option value="">روز</option>
                                                            <?php $__currentLoopData = range(1, 31); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($i); ?>" <?php echo e(($user->birthday && verta($user->birthday)->day == $i) ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <select name="month" id="" class="select2">
                                                            <option value="">ماه</option>
                                                            <option  <?php echo e($user->birthday && verta($user->birthday)->month == '1' ? 'selected' : ''); ?> value="1">فروردین</option>
                                                            <option  <?php echo e($user->birthday && verta($user->birthday)->month == '2' ? 'selected' : ''); ?> value="2">اردیبهشت</option>
                                                            <option  <?php echo e($user->birthday && verta($user->birthday)->month == '3' ? 'selected' : ''); ?> value="3">خرداد</option>
                                                            <option  <?php echo e($user->birthday && verta($user->birthday)->month == '4' ? 'selected' : ''); ?> value="4">تیر</option>
                                                            <option  <?php echo e($user->birthday && verta($user->birthday)->month == '5' ? 'selected' : ''); ?> value="5">مرداد</option>
                                                            <option  <?php echo e($user->birthday && verta($user->birthday)->month == '6' ? 'selected' : ''); ?> value="6">شهریور</option>
                                                            <option  <?php echo e($user->birthday && verta($user->birthday)->month == '7' ? 'selected' : ''); ?> value="7">مهر</option>
                                                            <option  <?php echo e($user->birthday && verta($user->birthday)->month == '8' ? 'selected' : ''); ?> value="8">آبان</option>
                                                            <option  <?php echo e($user->birthday && verta($user->birthday)->month == '9' ? 'selected' : ''); ?> value="9">آذر</option>
                                                            <option  <?php echo e($user->birthday && verta($user->birthday)->month == '10' ? 'selected' : ''); ?> value="10">دی</option>
                                                            <option  <?php echo e($user->birthday && verta($user->birthday)->month == '11' ? 'selected' : ''); ?> value="11">بهمن</option>
                                                            <option  <?php echo e($user->birthday && verta($user->birthday)->month == '12' ? 'selected' : ''); ?> value="12">اسفند</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="number" id="contact-info-icon" class="form-control" name="year" placeholder="سال" value="<?php echo e($user->birthday ? verta($user->birthday)->year : ''); ?>">
                                                    </div>
                                                </div>
                                                <small class="help-block text-danger error-day"></small>
                                                <small class="help-block text-danger error-month"></small>
                                                <small class="help-block text-danger error-year"></small>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password-icon">آدرس</label>
                                                <?php echo $__env->make('components.sections.location', ['countries' => $countries, 'country' => $user->country, 'state' => $user->state, 'city' => $user->city], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <small class="help-block text-danger error-country_id"></small>
                                                <small class="help-block text-danger error-state_id"></small>
                                                <small class="help-block text-danger error-city_id"></small>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">ذخیره اطلاعات</button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">انتخاب عکس کاربری</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="text-center">
                                    <?php if($user->image && isset($user->image[0]) && $user->image[0]->path): ?>
                                        <img src="<?php echo e(config('shixeh.cdn_domain')); ?>/<?php echo e($user->image[0]->path); ?>" alt="" id="preview_image_crop" class="img-thumbnail user-circle m-auto">
                                    <?php else: ?>
                                        <img src="<?php echo e(config('shixeh.cdn_domain')); ?>/assets/images/logo.png" alt="" id="preview_image_crop" class="img-thumbnail user-circle m-auto">
                                    <?php endif; ?>
                                </div>
                                <?php echo $__env->make('components.sections.crop', ['head'=> '', 'type' => 'circle'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
        <!-- // Basic Horizontal form layout section end -->

    </div>

</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\shixeh\resources\views/user/edit-user.blade.php ENDPATH**/ ?>