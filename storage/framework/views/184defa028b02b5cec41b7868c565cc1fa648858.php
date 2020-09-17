

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
    
<section id="basic-vertical-layouts">
    <div class="row match-height">

        <div class="col-md-12 col-12">
            <section id="number-tabs">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo e($title); ?></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    <div class="card-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="info-tab-fill" data-toggle="tab" href="#info-fill" role="tab" aria-controls="info-fill" aria-selected="true">پرداخت و فروش</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link "  id="transport-tab-fill" data-toggle="tab" href="#transport-fill" role="tab" aria-controls="transport-fill" aria-selected="false">زمان و هزینه هاس ارسال</a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            
                                            <div class="tab-pane active" id="info-fill" role="tabpanel" aria-labelledby="file-tab-fill">
                                                <form class="ajaxForm" action="<?php echo e(route('seller.setting.post')); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <section id="basic-horizontal-layouts">
                                                        <div class="row match-height">
                                                            <div class="col-12 my-3">
                                                                <h5 for="">پرداخت: </h5>
                                                                <ul class="list-unstyled mb-0">
                                                                    <?php $__empty_1 = true; $__currentLoopData = $payTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="pay[]" value="<?php echo e($pay->id); ?>" <?php echo e(($setting && in_array($pay->id, $setting['pay'])) ? 'checked' : ''); ?> id="data-block">
                                                                                <span class="vs-checkbox">
                                                                                    <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class=""><?php echo e($pay->name); ?></span>
                                                                                <small class="help-block text-danger error-pay"></small>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                    
                                                                    <?php endif; ?>
                                                                </ul>
                                                            </div>
                                                            <div class="col-12 my-3">
                                                                <h5  for="">فروش: </h5>
                                                                <ul class="list-unstyled mb-0">
                                                                    <?php $__empty_1 = true; $__currentLoopData = $sellTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sell): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="sell[]" value="<?php echo e($sell->id); ?>" <?php echo e(($setting && in_array($sell->id, $setting['sell'])) ? 'checked' : ''); ?> id="data-block">
                                                                                <span class="vs-checkbox">
                                                                                    <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class=""><?php echo e($sell->name); ?></span>
                                                                                <small class="help-block text-danger error-sell"></small>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                    
                                                                    <?php endif; ?>
                                                                </ul>
                                                            </div>

                                                            <button class="btn btn-primary btn-md my-2 " type="submit"> <i class=""></i> ویرایش اطلاعات </button>
                                                        
                                                        </div>
                                                    </section>
                                                </form>
                                            </div>
                                            
                                            <div class="tab-pane" id="transport-fill" role="tabpanel" aria-labelledby="transport-tab-fill">
                                                
                                                <form class="ajaxForm" action="<?php echo e(route('seller.setting.ship.post')); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <fieldset>

                                                        <button class="btn btn-primary btn-md my-2 " type="submit"> <i class=""></i> ثبت اطلاعات </button>
                                                        
                                                        <!-- DataTable starts -->
                                                        <div class="table-responsive">
                                                            <table class="table data-list-view1">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center"></th>
                                                                        <th class="text-center">استان</th>
                                                                        <th class="text-center">هزینه ارسال</th>
                                                                        <th class="text-center">زمان ارسال</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $__empty_1 = true; $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                        <tr row="<?php echo e($state->id); ?>">
                                                                            <td col="id"><?php echo e($state->id); ?></td>
                                                                            <td col="title" class="">
                                                                                <strong class="w-100 form-control border-0"><?php echo e($state->name); ?></strong>
                                                                                <input type="hidden" name="country_id[]" value="<?php echo e($state->country->id ?? null); ?>">
                                                                                <input type="hidden" name="state_id[]" value="<?php echo e($state->id); ?>">
                                                                                <input type="hidden" name="city_id[]" value="<?php echo e(null); ?>">
                                                                            </td>
                                                                            <td>
                                                                                <div class="input-group">
                                                                                <input type="number" name="shipping_cost[]" class="form-control" placeholder="هزینه ارسال"
                                                                                 value="<?php echo e((!empty($state->postsetting) && isset($state->postsetting->shipping_cost)) ? $state->postsetting->shipping_cost : ''); ?>">
                                                                                    <div class="input-group-prepend">
                                                                                        <select name="currency_id[]" id="" class="select2">
                                                                                            <option value="" selected>واحد پولی</option>
                                                                                            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                                <option <?php echo e((!empty($state->postsetting) && isset($state->postsetting->currency_id) && $state->postsetting->currency_id == $curr->id) ? 'selected' : ''); ?> value="<?php echo e($curr->id); ?>"><?php echo e($curr->name); ?></option>
                                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <input type="number" name="shipping_time[]" class="form-control" placeholder="زمان ارسال"
                                                                                    value="<?php echo e((!empty($state->postsetting) && isset($state->postsetting->shipping_time)) ? $state->postsetting->shipping_time : ''); ?>">
                                                                                    <div class="input-group-prepend">
                                                                                        <select name="unit_of_time[]" id="" class="select2">
                                                                                            
                                                                                            <option <?php echo e((!empty($state->postsetting) && isset($state->postsetting->unit_of_time) && $state->postsetting->unit_of_time == 'روز') ? 'selected' : ''); ?> value="روز">روز</option>
                                                                                            <option <?php echo e((!empty($state->postsetting) && isset($state->postsetting->unit_of_time) && $state->postsetting->unit_of_time == 'ساعت') ? 'selected' : ''); ?> value="ساعت">ساعت</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                        
                                                                    <?php endif; ?>
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- DataTable ends -->

                                                        

                                                        
                                                    </fieldset>
                                                </form>
                                            </div>
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
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\shixeh\resources\views/seller/info/setting.blade.php ENDPATH**/ ?>