

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


<form action="<?php echo e(route('seller.branch.update', [ 'id' =>$branch->id ])); ?>" method="post" class="ajaxForm">
    <?php echo csrf_field(); ?>
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">شعبه</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                        <li><a data-action=""><i class="feather icon-rotate-cw categories-data-filter"></i></a></li>
                        <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="categories-list-filter">
                        <div class="row ">
                        
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان نمایشی</label>
                                    <input type="text" placeholder="عنوان نمایشی" class="form-control" id="title" name="title" value="<?php echo e($branch->title); ?>">
                                    <small class="help-block text-danger error-title"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="manager">نام مدیریت شعبه</label>
                                    <input type="text" placeholder="نام مدیریت شعبه" class="form-control" id="manager" name="manager" value="<?php echo e($branch->manager); ?>">
                                    <small class="help-block text-danger error-manager"></small>
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="actived_at" <?php echo e(($branch->actived_at) ? 'checked' : ''); ?> value="1">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                    <span class="">فعال </span>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password-icon">آدرس</label>
                                    <?php echo $__env->make('components.sections.location', ['countries' => $countries, 'country' => $branch->country ?? null, 'state' => $branch->state ?? null, 'city' => $branch->city ?? null], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <small class="help-block text-danger error-country_id"></small>
                                    <small class="help-block text-danger error-state_id"></small>
                                    <small class="help-block text-danger error-city_id"></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">آدرس کامل شعبه :</label>
                                    <textarea placeholder="آدرس کامل شعبه" id="address" name="address" rows="5" class="form-control"><?php echo e($branch->address); ?></textarea>
                                    <small class="help-block text-danger error-address"></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phones">شماره های تماس :</label>
                                    <input type="text" placeholder="شماره های تماس" data-role="tagsinput" class="form-control" id="phones" name="phones" value="<?php echo e($branch->phones); ?>">
                                    <small class="help-block text-danger error-phones"></small>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="row">
                                    <?php echo $__env->make('components.sections.location-pin', ['latitude' => $branch->latitude, 'longitude' => $branch->longitude], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1 mb-1"><i></i> ذخیره اطلاعات</button> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\shixeh\resources\views/seller/branches/update-or-insert-branch.blade.php ENDPATH**/ ?>