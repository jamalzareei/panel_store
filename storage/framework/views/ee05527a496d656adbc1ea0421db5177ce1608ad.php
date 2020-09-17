

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
    
    // On Edit
    $(document).ready(function() {

        $(document).on('click' , '.action-add', function(){
            var this_ = $(this)
            $('.ajaxForm').attr('action', "<?php echo e(route('admin.user.add')); ?>")
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

            var role = $( 'select[name="role"] option:checked' ).val();
            var blocked = $( 'select[name="blocked"] option:checked' ).val();
            var verify = $( 'select[name="verify"] option:checked' ).val();
            var phone = $( 'input[name="phone"]' ).val();
            var email = $( 'input[name="email"]' ).val();

            if( !data[6].includes(blocked) ){
                return false;
            }

            if( !data[4].includes(role) ){
                return false;
            }

            if(phone && !data[2].includes(phone) ){
                return false;
            }

            if(email && !data[3].includes(email) ){
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
            <h4 class="card-title">فیلتر کاربران</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                    <li><a data-action=""><i class="feather icon-rotate-cw users-data-filter"></i></a></li>
                    <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
                <div class="users-list-filter">
                    <form>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="users-list-department">شماره همراه بدون صفر</label>
                                <fieldset class="form-group">
                                    <input type="text" name="phone" value="" class="form-control filter" dir="ltr" placeholder="912*******">
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="users-list-department">ایمیل</label>
                                <fieldset class="form-group">
                                    <input type="text" name="email" value="" class="form-control filter" dir="ltr" placeholder="info@shixeh.com">
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="users-list-role">نقش</label>
                                <fieldset class="form-group">
                                    <select class="form-control filter" name="role" id="users-list-role">
                                        <option value="">همه</option>
                                        <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($role->name); ?>"><?php echo e($role->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            
                                        <?php endif; ?>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="users-list-status">وضعیت</label>
                                <fieldset class="form-group">
                                    <select class="form-control filter" name="blocked" id="users-list-status">
                                        <option value="">همه</option>
                                        <option value="تایید شده">فعال</option>
                                        <option value="تایید نشده">تایید نشده</option>
                                        <option value="مسدود">مسدود</option>
                                        <option value="غیر فعال">غیر فعال</option>
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
        <form action="<?php echo e(route('admin.users.update')); ?>" method="POST" id="form-datatable">
            <?php echo csrf_field(); ?>
            <div class="action-btns d-none">
                <div class="btn-dropdown mr-1 mb-1">
                    <div class="btn-group dropdown actions-dropodown">
                        <button type="button" class="btn btn-white px-1 py-1 dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            عملیات
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item" name="type" value="active"><i class="feather icon-trash"></i>فعال سازی</button>
                            <button class="dropdown-item" name="type" value="delete"><i class="feather icon-trash"></i>حذف</button>
                            <button class="dropdown-item" name="type" value="deactive"><i class="feather icon-archive"></i>غیر فعال</button>
                            <button class="dropdown-item" name="type" value="print"><i class="feather icon-file"></i>پرینت</button>
                            <button class="dropdown-item" name="type" value="block"><i class="feather icon-save"></i>مسدود کردن کاربر</button>
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
                            <th>نام</th>
                            <th>شماره</th>
                            <th>ایمیل</th>
                            <th>نقش</th>
                            <th>تاریخ ثبت نام</th>
                            <th>وضعیت</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr row="<?php echo e($user->id); ?>">
                                <td col="id"><?php echo e($user->id); ?></td>
                                <td col="name" class=""><?php echo e($user->full_name); ?></td>
                                <td col="phone" class=""><?php echo e($user->phone); ?></td>
                                <td col="email">
                                    <?php echo e($user->email); ?>

                                </td>
                                <td col="role" class="">
                                    <?php $__empty_2 = true; $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <div class="chip chip-default">
                                            <div class="chip-body">
                                                <div class="chip-text"><?php echo e($role->name); ?></div>
                                            </div>
                                        </div>
                                        
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        
                                    <?php endif; ?>
                                </td>
                                <td col="created_at">
                                    <?php echo e(Verta($user->created_at)->format('Y-m-d')); ?>

                                </td>
                                <td col="verify">
                                    <?php if($user->blocked_at): ?>
                                        <div class="chip chip-danger">
                                            <div class="chip-body">
                                                <div class="chip-text">مسدود</div>
                                            </div>
                                        </div>                                  
                                    <?php elseif($user->deactived_at || $user->deleted_at): ?>
                                        <div class="chip chip-warning">
                                            <div class="chip-body">
                                                <div class="chip-text">غیر فعال</div>
                                            </div>
                                        </div>
                                    <?php elseif($user->phone_verified_at || $user->email_verified_at): ?>
                                        <div class="chip chip-success">
                                            <div class="chip-body">
                                                <div class="chip-text">تایید شده</div>
                                            </div>
                                        </div>  
                                    <?php else: ?>
                                        <div class="chip chip-info">
                                            <div class="chip-body">
                                                <div class="chip-text">تایید نشده</div>
                                            </div>
                                        </div>  
                                    <?php endif; ?>
                                    
                                </td>
                                <td col="action" class="td-action">
                                    <span class="action-edit" key=<?php echo e($key); ?> item_id="<?php echo e($user->id); ?>" firstname="<?php echo e($user->firstname); ?>" lastname="<?php echo e($user->lastname); ?>" phone="<?php echo e($user->phone); ?>" email="<?php echo e($user->email); ?>" role="" active="<?php echo e(($user->phone_verified_at || $user->email_verified_at) ? true : false); ?>" action="<?php echo e(route('admin.user.update', ['id'=> $user->id])); ?>"><i class="feather icon-edit"></i></span>
                                    <span class="action-delete" onclick="deleteRow('<?php echo e(route('admin.user.delete', ['id'=>$user->id])); ?>', '<?php echo e($user->id); ?>')"><i class="feather icon-trash"></i></span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            
                        <?php endif; ?>
                        
                    </tbody>
                </table>
            </div>
            <!-- DataTable ends -->
        </form>

        <!-- add new sidebar starts -->
        <form action="" method="post" class="ajaxForm">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" id="item_id" value="">
            <div class="add-new-data-sidebar">
                <div class="overlay-bg"></div>
                <div class="add-new-data">
                    <div class="div mt-2 px-2 d-flex new-data-title justify-content-between">
                        <div>
                            <h4 class="text-uppercase">اضافه / ویرایش کاربر</h4>
                        </div>
                        <div class="hide-data-sidebar">
                            <i class="feather icon-x"></i>
                        </div>
                    </div>
                    <div class="data-items pb-3">
                        <div class="data-fields px-2 mt-1">
                            <div class="row">
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-name">نام</label>
                                    <input type="text" class="form-control" name="firstname" id="data-firstname">
                                    <small class="help-block text-danger error-firstname"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-name">نام خانوادگی</label>
                                    <input type="text" class="form-control" name="lastname" id="data-lastname">
                                    <small class="help-block text-danger error-lastname"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-name">شمار تلفن</label>
                                    <input type="text" class="form-control" name="phone" id="data-phone">
                                    <small class="help-block text-danger error-phone"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-name">ایمیل</label>
                                    <input type="text" class="form-control" name="email" id="data-email">
                                    <small class="help-block text-danger error-email"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-category"> نقش کاربر </label>
                                    <select class="form-control select2" multiple name="roles[]" id="data-category">
                                        <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($role->slug); ?>"><?php echo e($role->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            
                                        <?php endif; ?>
                                    </select>
                                    <small class="help-block text-danger error-roles"></small>
                                </div>
                                <div class="col-sm-12 data-field-col">
                                    <label for="data-status">وضعیت کاربر</label>
                                    <fieldset>
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox"  name="verify" value="1" id="data-verify">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">فعال</span>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox"  name="deactive" value="1" id="data-deactive">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">غیر فعال سازی حساب کاربری</span>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox"  name="block" value="1" id="data-block">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">مسدود سازی</span>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox"  name="delete" value="1" id="data-delete">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">حذف کاربر</span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="add-data-footer d-flex justify-content-around px-3 mt-2">
                        <div class="add-data-btn">
                            <button class="btn btn-primary" type="submit"> <i class=""></i> اضافه / ویرایش</button>
                        </div>
                        <div class="cancel-data-btn">
                            <span class="btn btn-outline-danger">کنسل</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- add new sidebar ends -->
    </section>
    <!-- Data list view end -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\shixeh\resources\views/admin/users/list-users.blade.php ENDPATH**/ ?>