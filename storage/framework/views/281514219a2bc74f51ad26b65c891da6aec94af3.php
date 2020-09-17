

<?php $__env->startSection('head'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <script>
        $(() => {
            $('#show-codes').click(function(){
                var email = $('[name="email"]').val();
                if(email){
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
                                        <form action="<?php echo e(route('user.data.email.post')); ?>" method="post" class="ajaxForm w-100">
                                            <?php echo csrf_field(); ?>
                                            <div class="col-12">

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="email">ایمیل (<?php echo e($user->email); ?>)</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" dir="ltr" id="email" class="form-control" name="email" placeholder="ایمیل جدید خود را وارد نمایید..." value="">
                                                            <div class="form-control-position">
                                                                <i class="feather icon-email"></i>
                                                            </div>
                                                            <small class="help-block text-danger error-email"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12">
                                                    <button type="submit" id="show-codes" class="btn btn-primary mr-1 mb-1"> ارسال کد تایید </button>
                                                </div>
                                            
                                            </div>

                                            <div class="col-12 codes-box" style="display: none">
                                                <p class="text-info"> کد ارسال شده به ایمیل خود را وارد نمایید. </p>
                                                <div class="row">

                                                    
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="code_new">کد تاییدیه ایمیل جدید</label>
                                                            <div class="position-relative has-icon-left">
                                                                <input type="text" dir="ltr" id="code_new" class="form-control" name="code_new" placeholder="کد تاییدیه ایمیل جدید" value="">
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-code"></i>
                                                                </div>
                                                                <small class="help-block text-danger error-code_new"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1"> تایید ایمیل  </button>
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
<?php echo $__env->make('layouts/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\shixeh\resources\views/user/edit-email.blade.php ENDPATH**/ ?>