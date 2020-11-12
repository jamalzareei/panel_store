

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
            $('.ajaxForm').attr('action', "<?php echo e(route('admin.category.add')); ?>")
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

    
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!-- Data list view starts -->
    <section id="data-list-view" class="data-list-view-header">
        <div class="row d-flex div-action-btns" dir="ltr">
        
            <button type="button" class="btn bg-gradient-info mr-1 waves-effect waves-light action-add-new" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="feather icon-plus"></i> افزودن شعبه جدید
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
                <div class="modal-content">
                    <section class="todo-form">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenter">افزودن شعبه جدید</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="add-branch" class="todo-input ajaxForm" method="POST" action="<?php echo e(route('seller.branch.add')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="modal-body">
                                <fieldset class="form-group">
                                    <input type="text" class="new-todo-item-title form-control" name="title" placeholder="نام شعبه">
                                    <small class="help-block text-danger error-title"></small>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <button type="submit" class="btn btn-primary add-todo-item waves-effect waves-light" form="add-branch">
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
        <form action="<?php echo e(route('seller.branches.update')); ?>" method="POST" id="form-datatable">
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
                            <th>عنوان</th>
                            <th>مدیریت</th>
                            <th>وضعیت</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $seller->branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr row="<?php echo e($branch->id); ?>">
                                <td col="id"><?php echo e($branch->id); ?></td>
                                <td col="title" class=""><a href="<?php echo e(route('seller.branch.edit', ['id'=>$branch->id])); ?>"><?php echo e($branch->title); ?></a></td>
                                <td col="manager" class=""><a href="<?php echo e(route('seller.branch.edit', ['id'=>$branch->id])); ?>"><?php echo e($branch->manager); ?></a></td>
                                <td col="verify">
                                    <?php if($branch->deleted_at): ?>
                                    <div class="chip chip-warning">
                                        <div class="chip-body">
                                            <div class="chip-text">حذف شده</div>
                                        </div>
                                    </div>
                                    <?php elseif($branch->actived_at): ?>
                                        <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                                        <input type="checkbox" class="custom-control-input" name="actived_at[<?php echo e($branch->id); ?>]" id="customSwitch<?php echo e($branch->id); ?>" checked onclick="changeStatus('<?php echo e(route('seller.branch.update.status', ['id'=> $branch->id])); ?>',this)">
                                            <label class="custom-control-label" for="customSwitch<?php echo e($branch->id); ?>">
                                                <span class="switch-text-left">فعال</span>
                                                <span class="switch-text-right">غیر فعال</span>
                                            </label>
                                        </div>
                                        <div class="hidden">فعال شده</div>
                                    <?php else: ?>
                                        <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                                            <input type="checkbox" class="custom-control-input" name="actived_at[<?php echo e($branch->id); ?>]" id="customSwitch<?php echo e($branch->id); ?>" onclick="changeStatus('<?php echo e(route('seller.branch.update.status', ['id'=> $branch->id])); ?>',this)">
                                            <label class="custom-control-label" for="customSwitch<?php echo e($branch->id); ?>">
                                                <span class="switch-text-left">فعال</span>
                                                <span class="switch-text-right">غیر فعال</span>
                                            </label>
                                        </div>
                                        <div class="hidden">غیر فعال شده</div>
                                    <?php endif; ?>
                                    
                                </td>
                                <td col="action" class="td-action">
                                    <a href="<?php echo e(route('seller.branch.edit', ['id'=>$branch->id])); ?>">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                    <span class="action-delete" onclick="deleteRow('<?php echo e(route('seller.branches.delete', ['id'=>$branch->id])); ?>', '<?php echo e($branch->id); ?>')"><i class="feather icon-trash"></i></span>
                                
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            
                        <?php endif; ?>
                        
                    </tbody>
                </table>
            </div>
            <!-- DataTable ends -->
        </form>

    </section>
    <!-- Data list view end -->


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\shixeh\resources\views/seller/branches/list-branches.blade.php ENDPATH**/ ?>