

<?php $__env->startSection('head'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('app-assets/vendors/css/forms/select/select2.min.css')); ?>">
<style>
    .action-add, .action-filters{display: none;}
    .div-action-btns{transform: translate(0, 64px);}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
<script src="<?php echo e(asset('app-assets/vendors/js/forms/select/select2.full.min.js')); ?>"></script>
<script>
    
    $(".select2").select2({
        dir: "rtl",
        dropdownAutoWidth: true,
        width: '100%'
    });
    
    // On Edit
    $(document).ready(function() {


        $(document).on('click' , '.action-add', function(){
            var this_ = $(this)
            $('.ajaxForm').attr('action', "<?php echo e(route('admin.tag.add')); ?>")
            $('.ajaxForm #data-phone, .ajaxForm #data-email').attr('disabled', false)
            $('.ajaxForm').reset();
            $(".add-new-data").addClass("show");
            $(".overlay-bg").addClass("show");
        });

        var table = $('.data-list-view').DataTable();
        
        // Event listener to the two range filtering inputs to redraw on input
        $('select.filter').change( function() {
            table.draw();
        } );
        $('.filter').keyup( function() {
            table.draw();
        } );

        $(document).on('click' , '.action-edit', function(e){
            var this_ = $(this)
            e.stopPropagation();
            var key = this_.attr('key');

            $('#data-firstname').val(this_.attr('firstname'));
            $('#data-lastname').val(this_.attr('lastname'));
            $('#data-phone').val(this_.attr('phone'));
            $('#data-email').val(this_.attr('email'));
            $('#data-verify').prop('checked',this_.attr('active'));

            $('.ajaxForm').attr('action', this_.attr('action'))
            $('.ajaxForm #data-phone, .ajaxForm #data-email').attr('disabled', true)
            $('#item_id').val(this_.attr('item_id'))
            
            $(".add-new-data").addClass("show");
            $(".overlay-bg").addClass("show");
        });
        

    } );

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {

            var status = $( 'select[name="status"] option:checked' ).val();
            var title = $( 'input[name="title"]' ).val();
            var slug = $( 'input[name="slug"]' ).val();

            if( !data[4].includes(status) ){
                return false;
            }

            if(title && !data[2].includes(title) ){
                return false;
            }

            if(slug && !data[3].includes(slug) ){
                return false;
            }

            return true
        }
    );
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">فیلتر </h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                    <li><a data-action=""><i class="feather icon-rotate-cw tags-data-filter"></i></a></li>
                    <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
                <div class="tags-list-filter">
                    <form>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-5">
                                <label for="tags-list-department">عنوان</label>
                                <fieldset class="form-group">
                                    <input type="text" name="title" value="" class="form-control filter" placeholder="عنوان">
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-5">
                                <label for="tags-list-department">اسلاگ</label>
                                <fieldset class="form-group">
                                    <input type="text" name="slug" value="" class="form-control filter" dir="ltr" placeholder="اسلاگ">
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-2">
                                <label for="tags-list-status">وضعیت</label>
                                <fieldset class="form-group">
                                    <select class="form-control filter" name="status" id="tags-list-status">
                                        <option value="">همه</option>
                                        <option value="ac-tive">فعال شده</option>
                                        <option value="deactive">غیر فعال شده</option>
                                        <option value="deleted">حذف شده</option>
                                    </select>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Data list view starts -->
    <section id="data-list-view" class="data-list-view-header">
        <div class="row d-flex div-action-btns" dir="ltr">
            
            <button type="button" class="btn bg-gradient-primary mr-1 waves-effect waves-light action-add-new" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="feather icon-plus"></i> افزودن تگ جدید
            </button>
                        
        </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
                    <div class="modal-content">
                        <section class="todo-form">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenter">افزودن تگ جدید</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form id="add-tag" class="todo-input ajaxForm" method="POST" action="<?php echo e(route('admin.tag.add')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="modal-body">
                                    <fieldset class="form-group">
                                        <input type="text" class="new-todo-item-title form-control" name="name" placeholder="عنوان">
                                    </fieldset>
                                    <fieldset>
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox" name="actived_at" checked value="1">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">فعال</span>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                        <button type="submit" class="btn btn-primary add-todo-item waves-effect waves-light" form="add-tag">
                                            <i class="feather icon-check d-block "></i>
                                            <span class="">افزودن </span>
                                        </button>
                                    </fieldset>
                                    <fieldset class="form-group position-relative has-icon-left mb-0 d-none d-lg-block">
                                        <button type="button" class="btn btn-outline-light waves-effect waves-light" data-dismiss="modal">
                                            <i class="feather icon-x d-block d-lg-none"></i>
                                            <span class="d-none d-lg-block">بستن</span></button>
                                    </fieldset>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        <form action="<?php echo e(route('admin.tags.update')); ?>" method="POST" id="form-datatable">
            <?php echo csrf_field(); ?>
            <div class="action-btns d-none">
                <div class="btn-dropdown mr-1 mb-1">
                    <div class="btn-group dropdown actions-dropodown">
                        <button type="button" class="btn btn-white px-1 py-1 dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            عملیات
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item" name="type" value="active"><i class="feather icon-trash"></i>فعال سازی</button>
                            <button class="dropdown-item" name="type" value="deactive"><i class="feather icon-archive"></i>غیر فعال</button>
                            <button class="dropdown-item" name="type" value="delete"><i class="feather icon-trash"></i>حذف</button>
                            <button class="dropdown-item" name="type" value="print"><i class="feather icon-file"></i>پرینت</button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- DataTable starts -->
            <div class="table-responsive">
                <table class="table data-list-view">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ای دی</th>
                            <th>نام</th>
                            <th>اسلاگ</th>
                            <th>وضعیت</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr row="<?php echo e($tag->id); ?>">
                                <td col="id"><?php echo e($tag->id); ?></td>
                                <td col="order_by" class="" style="width: 10px">
                                    <div class=""><?php echo e($tag->id); ?></div>
                                    <input type="hidden" name="ids[]" value="<?php echo e($tag->id); ?>">
                                </td>
                                <td col="name" class=""><a href="<?php echo e(route('admin.tag.edit', ['slug'=>$tag->slug])); ?>"><?php echo e($tag->name); ?></a></td>
                                <td col="slug" class=""><a href="<?php echo e(route('admin.tag.edit', ['slug'=>$tag->slug])); ?>"><?php echo e($tag->slug); ?></a></td>
                                
                                <td col="verify">
                                    <?php if($tag->deleted_at): ?>
                                    <div class="chip chip-warning">
                                        <div class="chip-body">
                                            <div class="chip-text">حذف شده</div>
                                            <div class="hidden">deleted</div>
                                        </div>
                                    </div>
                                    <?php elseif($tag->actived_at): ?>
                                        <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                                        <input type="checkbox" class="custom-control-input" name="actived_at[<?php echo e($tag->id); ?>]" id="customSwitch<?php echo e($tag->id); ?>" checked onclick="changeStatus('<?php echo e(route('admin.tag.update.status', ['id'=> $tag->id])); ?>',this)">
                                            <label class="custom-control-label" for="customSwitch<?php echo e($tag->id); ?>">
                                                <span class="switch-text-left">فعال</span>
                                                <span class="switch-text-right">غیر فعال</span>
                                            </label>
                                        </div>
                                        <div class="hidden">ac-tive</div>
                                    <?php else: ?>
                                        <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                                            <input type="checkbox" class="custom-control-input" name="actived_at[<?php echo e($tag->id); ?>]" id="customSwitch<?php echo e($tag->id); ?>" onclick="changeStatus('<?php echo e(route('admin.tag.update.status', ['id'=> $tag->id])); ?>',this)">
                                            <label class="custom-control-label" for="customSwitch<?php echo e($tag->id); ?>">
                                                <span class="switch-text-left">فعال</span>
                                                <span class="switch-text-right">غیر فعال</span>
                                            </label>
                                        </div>
                                        <div class="hidden">deactive</div>
                                    <?php endif; ?>
                                    
                                </td>
                                <td col="action" class="td-action">
                                    <a href="<?php echo e(route('admin.tag.edit', ['slug'=>$tag->slug])); ?>">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                    <span class="action-delete" onclick="deleteRow('<?php echo e(route('admin.tag.delete', ['id'=>$tag->id])); ?>', '<?php echo e($tag->id); ?>')"><i class="feather icon-trash"></i></span>
                                
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            
                        <?php endif; ?>
                        
                    </tbody>
                </table>
            </div>
            <?php if($tags instanceof \Illuminate\Pagination\LengthAwarePaginator ): ?>
                <?php echo e($tags->appends(request()->query())->links('vendor/pagination/vuexy')); ?>

            <?php endif; ?>
            <!-- DataTable ends -->
        </form>

    </section>
    <!-- Data list view end -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\shixeh\resources\views/admin/tags/list-tags.blade.php ENDPATH**/ ?>