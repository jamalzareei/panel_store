

<?php $__env->startSection('head'); ?>
    
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/forms/select/select2.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
<script src="<?php echo e(asset('app-assets/vendors/js/forms/select/select2.full.min.js')); ?>"></script>
<script>
    
    $(".select2").select2({
        dir: "rtl",
        
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        templateResult: iconFormat,
        templateSelection: iconFormat,
        escapeMarkup: function(es) { return es; }
    });

    function iconFormat(icon) {
        var originalOption = icon.element;
        if (!icon.id) { return icon.text; }
        // var $icon = "<i class='" + $(icon.element).data('icon') + "'></i>" + icon.text;
        var $icon = $(icon.element).data('icon') + icon.text;


        return $icon;
    }
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
<section id="basic-vertical-layouts">
    <div class="row match-height">

        <div class="col-md-12">
            <section id="number-tabs">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo e($title); ?></h4>
                            </div>
                            <div class="card-content">
                                <div class="col-12 mt-3">
                                    <h5>اضافه کردن</h5>
                                    <form class="ajaxForm" action="<?php echo e(route('seller.social.add.post')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">
                                            <div class="col-md-3">
                                                
                                                <label for="">انتخاب شبکه اجتماعی</label>
                                                <select name="social_id" data-placeholder="انتخاب نمایید" class="select2-icons form-control select2" id="select2-icons">
                                                    <?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($social->id); ?>" data-icon="<?php echo e($social->icon); ?>"> <?php echo e($social->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <small class="help-block text-danger error-social_id"></small>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">نام کاربری </label>
                                                <div class="input-group">
                                                    <input type="text" dir="ltr" class="form-control" name="username" placeholder="نام کاربری">
                                                </div>
                                                <small class="help-block text-danger error-username"></small>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="">لینک </label>
                                                <div class="input-group">
                                                    <input type="text" dir="ltr" class="form-control" name="url" placeholder="لینک">
                                                </div>
                                                <small class="help-block text-danger error-url"></small>
                                            </div>
                                            <div class="col-md-1">
                                                <label for=""></label>
                                                <div class="input-group">
                                                    <button type="submit" class="btn btn-icon btn-icon rounded-circle btn-warning mr-1 mb-1 waves-effect waves-light">
                                                        <i class="vs-icon feather icon-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <h5> لیست </h5>
                                    <div id="load-data-ajax">
                                        <?php echo $listSocials; ?>

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
<?php echo $__env->make('layouts/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\shixeh\resources\views/seller/socials/add-social.blade.php ENDPATH**/ ?>