

<?php $__env->startSection('head'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/css-rtl/plugins/forms/wizard.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/dropify/dist/css/dropify.min.css')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>

    <script src="<?php echo e(asset('app-assets/vendors/js/extensions/jquery.steps.min.js')); ?>"></script>
    <script src="<?php echo e(asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js')); ?>"></script>
    <!-- BEGIN: Page JS-->
    <script src="<?php echo e(asset('app-assets/js/scripts/forms/wizard-steps.js')); ?>"></script>
    <!-- END: Page JS-->
    <script src="<?php echo e(asset('assets/dropify/dist/js/dropify.min.js')); ?>"></script>

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
                                
                                <?php if($property && $property->category_id): ?>
                                    <a href="<?php echo e(route('admin.properties.list', ['category_id'=> $property->category_id])); ?>" class="btn bg-gradient-info mr-1 waves-effect waves-light action-add-new" >
                                        <i class="feather icon-list"></i> لیست دیگر پراپرتی های هم گروه
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p>در این قسمت اطلاعات دیگر پراپرتی را کامل نمایید.</p>


                                    <div class="card-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link " id="file-tab-fill" data-toggle="tab" href="#file-fill" role="tab" aria-controls="file-fill" aria-selected="true">فایل (عکس)</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" id="info-tab-fill" data-toggle="tab" href="#info-fill" role="tab" aria-controls="info-fill" aria-selected="false">اطلاعات اصلی</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="seo-tab-fill" data-toggle="tab" href="#seo-fill" role="tab" aria-controls="seo-fill" aria-selected="false">اطلاعات سئو و صفحه</a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        
                                        <form class="ajaxUpload" action="<?php echo e(route('admin.property.update.post', ['id'=> $property->id])); ?>" action="" method="post">
                                            <?php echo csrf_field(); ?>
                                            <div class="tab-content pt-1">
                                                <div class="tab-pane" id="file-fill" role="tabpanel" aria-labelledby="file-tab-fill">
                                                    <fieldset>
                                                        
                                                        <label for="">اپلود عکس دسته بنده (عکس در سایز 512*512 و فرمت jpg) </label>
                                                        <input type="file" name="image" class="dropify file-upload" data-default-file="<?php echo e(($property) ? config('shixeh.cdn_domain').$property->image : ''); ?>" />
                                                        <small class="help-block text-danger error-image"></small>
                                                        
                                                        <button class="btn btn-primary btn-md my-2 " type="submit"> <i class=""></i> اپلود و ذخیره عکس </button>
                                                    </fieldset>
                                                </div>
                                                <div class="tab-pane active" id="info-fill" role="tabpanel" aria-labelledby="info-tab-fill">
                                                    <fieldset>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <ul class="list-unstyled mb-0">
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="is_filter" value="1" id="data-block" <?php echo e(($property && $property->is_filter) ? 'checked' : ''); ?>>
                                                                                <span class="vs-checkbox">
                                                                                    <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="">نمایش در فیلتر ها</span>
                                                                                <small class="help-block text-danger error-is_filter"></small>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="actived_at" value="1" id="data-block" <?php echo e(($property && $property->actived_at) ? 'checked' : ''); ?>>
                                                                                <span class="vs-checkbox">
                                                                                    <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="">فعال</span>
                                                                                <small class="help-block text-danger error-actived_at"></small>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="is_show_less" value="1" id="data-block" <?php echo e(($property && $property->is_show_less == 1) ? 'checked' : ''); ?>>
                                                                                <span class="vs-checkbox">
                                                                                    <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="">نمایش در کنار محصول</span>
                                                                                <small class="help-block text-danger error-is_show_less"></small>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="is_price" value="1" id="data-block" <?php echo e(($property && $property->is_price == 1) ? 'checked' : ''); ?>>
                                                                                <span class="vs-checkbox">
                                                                                    <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="">تاثیر روی قیمت</span>
                                                                                <small class="help-block text-danger error-is_price"></small>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="name">نام</label>
                                                                    <input type="text" placeholder="نام" class="form-control" id="name" name="name" value="<?php echo e($property ? $property->name : ''); ?>">
                                                                    <small class="help-block text-danger error-name"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="slug">اسلاگ</label>
                                                                    <input type="text" placeholder="اسلاگ" class="form-control" id="slug" name="slug" value="<?php echo e($property ? $property->slug : ''); ?>">
                                                                    <small class="help-block text-danger error-slug"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="default_list">لیست گزینه های پیش فرض :</label>
                                                                    <input type="text" data-role="tagsinput" placeholder="لیست گزینه های پیش فرض" class="form-control w-100" id="default_list" name="default_list" value="<?php echo e($property ? $property->default_list : ''); ?>">
                                                                    <small class="help-block text-danger error-default_list"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="filter_list">لیست ایتم هایی که در فیلتر نمایش داده میشود :</label>
                                                                    <input type="text" data-role="tagsinput" placeholder="لیست ایتم هایی که در فیلتر نمایش داده میشود" class="form-control" id="filter_list" name="filter_list" value="<?php echo e($property ? $property->filter_list : ''); ?>">
                                                                    <small class="help-block text-danger error-filter_list"></small>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            
                                                        <button class="btn btn-primary btn-md my-2 " type="submit"> <i class=""></i> ویرایش اطلاعات </button>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="tab-pane" id="seo-fill" role="tabpanel" aria-labelledby="seo-tab-fill">
                                                    <fieldset>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="title">عنوان صفحه</label>
                                                                    <input type="text" placeholder="عنوان صفحه" class="form-control" id="title" name="title" value="<?php echo e($property ? $property->title : ''); ?>">
                                                                    <small class="help-block text-danger error-title"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="head">هدر h1 برای صفحه</label>
                                                                    <input type="text" placeholder="هدر h1 برای صفحه" class="form-control" id="head" name="head" value="<?php echo e($property ? $property->head : ''); ?>">
                                                                    <small class="help-block text-danger error-head"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="meta_keywords">متا تگ ها :</label>
                                                                    <input type="text" placeholder="متا تگ ها" data-role="tagsinput" class="form-control" id="meta_keywords" name="meta_keywords" value="<?php echo e($property ? $property->meta_keywords : ''); ?>">
                                                                    <small class="help-block text-danger error-meta_keywords"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="meta_description">متا توضیحات :</label>
                                                                    <textarea placeholder="متا توضیحات" id="meta_description" name="meta_description" rows="5" class="form-control"><?php echo e($property ? $property->meta_description : ''); ?></textarea>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\shixeh\resources\views/admin/properties/update-or-insert-property.blade.php ENDPATH**/ ?>