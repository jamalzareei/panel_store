

<?php $__env->startSection('head'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <script>
        $(() => {
            $('#show-codes').click(function(){
                var phone = $('[name="phone"]').val();
                if(phone){
                    $('.codes-box').show();
                    $(this).hide();

                }
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    
    <div class="content-body">
        <!-- Basic Horizontal form layout section start -->
        <section id="basic-horizontal-layouts">
            <div class="row match-height">
                
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo e($title); ?></h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <form action="<?php echo e(route('user.data.change.password.post')); ?>" method="post" class="ajaxForm w-100">
                                            <?php echo csrf_field(); ?>
                                            <div class="col-12">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="password_old">کلمه عبور فعلی</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="password" dir="ltr" id="password_old" class="form-control" name="password_old" placeholder="کلمه عبور فعلی در صورتی که قبلا ست کرده باشید" value="">
                                                            <div class="form-control-position">
                                                                <i class="feather icon-lock"></i>
                                                            </div>
                                                            <small class="help-block text-info">در صورتی که قبلا کلمه عبوری تعریف نکرده اید این قسمت را خالی بگذارید.</small>
                                                            <small class="help-block text-danger error-password_old"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="password">کلمه عبور جدید</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="password" dir="ltr" id="password" class="form-control" name="password" placeholder="کلمه عبور جدید" value="">
                                                            <div class="form-control-position">
                                                                <i class="feather icon-lock"></i>
                                                            </div>
                                                            <small class="help-block text-danger error-password"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="password_confirmation">تکرار کلمه عبور</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="password" dir="ltr" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="تکرار کلمه عبور" value="">
                                                            <div class="form-control-position">
                                                                <i class="feather icon-lock"></i>
                                                            </div>
                                                            <small class="help-block text-danger error-password_confirmation"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12">
                                                    <button type="submit" id="show-codes" class="btn btn-primary mr-1 mb-1"><i></i> تغییر کلمه عبور </button>
                                                </div>
                                            
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

            </div>
        </section>
        <!-- // Basic Horizontal form layout section end -->

    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\shixeh\resources\views/user/edit-change-password.blade.php ENDPATH**/ ?>