<!-- DataTable starts -->
<div class="table-responsive">
    <table class="table data-list-view1">
        <thead>
            <tr>
                <th class="text-center"></th>
                <th class="text-center">شبکه اجتماعی</th>
                <th class="text-center">نام کاربری</th>
                <th class="text-center">لینک</th>
                <th class="text-center">حذف</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr row="<?php echo e($social->id); ?>">
                    <td col="id"><?php echo e($social->id); ?></td>
                    <td col="social">
                        <?php if($social && $social->social): ?>
                            <?php echo $social->social->icon; ?> <?php echo e($social->social->name); ?>

                        <?php endif; ?>
                    </td>
                    <td col="username" class="text-left">
                        <?php echo e($social->username); ?>

                        
                    </td>
                    <td col="url" class="text-left">
                        <?php echo e($social->url); ?>            
                    </td>
                    <td col="action">
                        <a class="action-delete" onclick="deleteRow('<?php echo e(route('seller.social.delete', ['id'=>$social->id])); ?>', '<?php echo e($social->id); ?>')">
                            <i class="feather icon-trash"></i>
                        </a>
                    
                    </td>
                    
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td valign="top" colspan="5" class="dataTables_empty text-center">هیچ موردی برای نمایش وجود ندارد</td>
                </tr>
            <?php endif; ?>
            
        </tbody>
    </table>
</div>
<!-- DataTable ends --><?php /**PATH C:\wamp64\www\shixeh\resources\views/seller/socials/list-socials.blade.php ENDPATH**/ ?>