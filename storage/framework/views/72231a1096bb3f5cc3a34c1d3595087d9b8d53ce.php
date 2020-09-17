<style>
    #DataTables_Table_0_paginate{display: none;}
</style>
<div class="dataTables_wrapper">
<div class="dataTables_paginate paging_simple_numbers">
<?php if($paginator->hasPages()): ?>
    <nav>
        
        <ul class="pagination">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="paginate_button page-item  disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                    <span class="page-link" aria-hidden="true">&lsaquo;قبلی</span>
                </li>
            <?php else: ?>
                <li class="paginate_button page-item ">
                    <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">&lsaquo;قبلی</a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <li class="paginate_button page-item  disabled" aria-disabled="true"><span class="page-link"><?php echo e($element); ?></span></li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="paginate_button page-item  active" aria-current="page"><span class="page-link font-small-2"><?php echo e($page); ?></span></li>
                        <?php else: ?>
                            <li class="paginate_button page-item "><a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="paginate_button page-item ">
                    <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">بعدی&rsaquo;</a>
                </li>
            <?php else: ?>
                <li class="paginate_button page-item  disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                    <span class="page-link" aria-hidden="true">بعدی&rsaquo;</span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
</div>
</div><?php /**PATH C:\wamp64\www\shixeh\resources\views/vendor/pagination/vuexy.blade.php ENDPATH**/ ?>