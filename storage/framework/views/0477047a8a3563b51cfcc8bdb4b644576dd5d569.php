<div class="row">
    <div class="col-4">
        <select name="country_id" id="" class="select2 form-control">
            <option value="">کشور</option>
            <?php if($country): ?>
                <option selected value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
            <?php endif; ?>
            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="col-4">
        <select name="state_id" id="" class="select2 form-control">
            <option value="">استان</option>
            <?php if($state): ?>
                <option selected value="<?php echo e($state->id); ?>"><?php echo e($state->name); ?></option>
            <?php endif; ?>
        </select>
    </div>
    <div class="col-4">
        <select name="city_id" id="" class="select2 form-control">
            <option value="">شهر</option>
            <?php if($city): ?>
                <option selected value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
            <?php endif; ?>
        </select>
    </div>
</div>

<script>
    $(() => {
        $('[name="country_id"]').change(function() {
            var country_id = $(this).find('option:selected').val();
            $.ajax({
                url: "<?php echo e(route('get.states.location')); ?>?country_id="+country_id,
                method: 'get',
                data: { ajax: 'true' },
                success: function(response) {
                    console.log(response)
                    $('[name="state_id"]').html(response)
                },
                error: function(request, status, error) {
                    console.log(request);
                }
            })
        })
        $('[name="state_id"]').change(function() {
            var state_id = $(this).find('option:selected').val();
            $.ajax({
                url: "<?php echo e(route('get.cities.location')); ?>?state_id="+state_id,
                method: 'get',
                data: { ajax: 'true' },
                success: function(response) {
                    console.log(response)
                    $('[name="city_id"]').html(response)
                },
                error: function(request, status, error) {
                    console.log(request);
                }
            })
        })
    })
</script><?php /**PATH C:\wamp64\www\shixeh\resources\views/components/sections/location.blade.php ENDPATH**/ ?>