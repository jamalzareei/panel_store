 <?php $__env->startSection('head'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/forms/select/select2.min.css')); ?>"> <?php $__env->stopSection(); ?> <?php $__env->startSection('footer'); ?>

<script src="<?php echo e(asset('app-assets/vendors/js/forms/select/select2.full.min.js')); ?>"></script>
<script>
    $(".select2").select2({
        dir: "rtl",
        dropdownAutoWidth: true,
        width: '100%'
    });
</script>
<?php $__env->stopSection(); ?> <?php $__env->startSection('content'); ?>


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
                                                <a class="nav-link active" id="info-tab-fill" data-toggle="tab" href="#info-fill" role="tab" aria-controls="info-fill" aria-selected="true">اطلاعات کلی</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link <?php echo e(($seller) ? '' : 'disabled'); ?>" id="file-tab-fill" data-toggle="tab" href="#file-fill" role="tab" aria-controls="file-fill" aria-selected="true">لوگوی فروشگاه</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link <?php echo e(($seller) ? '' : 'disabled'); ?>"  id="seo-tab-fill" data-toggle="tab" href="#seo-fill" role="tab" aria-controls="seo-fill" aria-selected="false">اطلاعات سئو و صفحه</a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <form action="<?php echo e(route('seller.data.post')); ?>" method="post" class="ajaxForm">
                                            <?php echo csrf_field(); ?>
                                            <div class="tab-content">
                                                
                                                <div class="tab-pane active" id="info-fill" role="tabpanel" aria-labelledby="file-tab-fill">
                                                    <section id="basic-horizontal-layouts">
                                                        <div class="row match-height">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="name">نام فروشگاه</label>
                                                                    <div class="position-relative has-icon-left">
                                                                        <input type="text" id="name" class="form-control" name="name" placeholder="نام فروشگاه" value="<?php echo e($seller->name ?? ''); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="feather icon-user"></i>
                                                                        </div>
                                                                        <small class="help-block text-danger error-name"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="manager">نام مدیریت</label>
                                                                    <div class="position-relative has-icon-left">
                                                                        <input type="text" id="manager" class="form-control" name="manager" placeholder="نام مدیریت" value="<?php echo e($seller->manager ?? ''); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="feather icon-user"></i>
                                                                        </div>
                                                                        <small class="help-block text-danger error-manager"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="website">وبسایت</label>
                                                                    <div class="position-relative has-icon-left">
                                                                        <input type="text" dir="ltr" id="website" class="form-control" name="website" placeholder="وبسایت" value="<?php echo e($seller->website ?? ''); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="feather icon-link"></i>
                                                                        </div>
                                                                        <small class="help-block text-danger error-website"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="password-icon">آدرس</label> 
                                                                    <?php echo $__env->make('components.sections.location', ['countries' => $countries, 'country' => $seller->country ?? null, 'state' => $seller->state ?? null, 'city' => $seller->city ?? null], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                    <small class="help-block text-danger error-country_id"></small>
                                                                    <small class="help-block text-danger error-state_id"></small>
                                                                    <small class="help-block text-danger error-city_id"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="details">توضیحات :</label>
                                                                    <textarea placeholder="توضیحات" id="details" name="details" rows="5" class="form-control"><?php echo e($seller ? $seller->details : ''); ?></textarea>
                                                                    <small class="help-block text-danger error-details"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <button type="submit" class="btn btn-primary mr-1 mb-1"><i></i> ذخیره اطلاعات</button> 
                                                            </div>
                                                            

                                                        </div>
                                                    </section>
                                                </div>
                                                <div class="tab-pane " id="file-fill" role="tabpanel" aria-labelledby="file-tab-fill">
                                                    
                                                    <div class="col-md-12 col-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="card-title">انتخاب لوگوی فروشگاه</h4>
                                                            </div>
                                                            <div class="card-content">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <?php echo $__env->make('components.sections.crop', ['head'=> '', 'type' => 'circle'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                        </div>
                                                                        <div class="col-md-6 m-auto text-center">
                                                                            <?php if($seller && $seller->image && isset($seller->image[0]) && $seller->image[0]->path): ?>
                                                                                <img src="<?php echo e(config('shixeh.cdn_domain')); ?>/<?php echo e($seller->image[0]->path); ?>" alt="" id="preview_image_crop" class="img-thumbnail user-circle m-auto">
                                                                            <?php else: ?>
                                                                                <img src="<?php echo e(config('shixeh.cdn_domain')); ?>/assets/images/logo.png" alt="" id="preview_image_crop" class="img-thumbnail user-circle m-auto">
                                                                            <?php endif; ?>
                                                                            <input type="hidden" name="image_file" class="image_file">
                                                                            <small class="help-block text-danger error-image_file w-100 m-1 row text-center"></small>
                                                                        
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="tab-pane" id="seo-fill" role="tabpanel" aria-labelledby="seo-tab-fill">
                                                    <fieldset>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="title">عنوان صفحه</label>
                                                                    <input type="text" placeholder="عنوان صفحه" class="form-control" id="title" name="title" value="<?php echo e($seller ? $seller->title : ''); ?>">
                                                                    <small class="help-block text-danger error-title"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="head">هدر h1 برای صفحه</label>
                                                                    <input type="text" placeholder="هدر h1 برای صفحه" class="form-control" id="head" name="head" value="<?php echo e($seller ? $seller->head : ''); ?>">
                                                                    <small class="help-block text-danger error-head"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="meta_keywords">متا تگ ها :</label>
                                                                    <input type="text" placeholder="متا تگ ها" data-role="tagsinput" class="form-control" id="meta_keywords" name="meta_keywords" value="<?php echo e($seller ? $seller->meta_keywords : ''); ?>">
                                                                    <small class="help-block text-danger error-meta_keywords"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="meta_description">متا توضیحات :</label>
                                                                    <textarea placeholder="متا توضیحات" id="meta_description" name="meta_description" rows="5" class="form-control"><?php echo e($seller ? $seller->meta_description : ''); ?></textarea>
                                                                    <small class="help-block text-danger error-meta_description"></small>
                                                                </div>
                                                            </div>
                                                            
                                                            <button class="btn btn-primary btn-md my-2 " type="submit"> <i class=""></i> ویرایش اطلاعات </button>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                                

                                        </form>
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
<?php echo $__env->make('layouts/master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\shixeh\resources\views/seller/info/edit-seller.blade.php ENDPATH**/ ?>