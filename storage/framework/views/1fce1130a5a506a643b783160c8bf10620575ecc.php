
<?php $__env->startSection('title',trans('My Packages')); ?>

<?php $__env->startSection('content'); ?>

    <section class="dashboard-section">
        <div class="container">
            <div class="row gy-5 g-lg-4">
                <?php echo $__env->make($theme.'user.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="dashboard-title">
                                    <h5><?php echo app('translator')->get('My Packages'); ?></h5>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="search-area table-search">
                                            <form action="<?php echo e(route('user.purchased.plan.search')); ?>" method="get">
                                                <?php echo csrf_field(); ?>
                                                <div class="row g-3">
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <input type="text" name="name" value="<?php echo e(old('name',@request()->name)); ?>" class="form-control" placeholder="<?php echo app('translator')->get('Search by Name'); ?>">
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <input type="text" name="price" value="<?php echo e(old('name',@request()->price)); ?>" class="form-control" placeholder="<?php echo app('translator')->get('Search by Price'); ?>">
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <input type="date" class="form-control" name="date_time" value="<?php echo e(old('date_time',@request()->date_time)); ?>"/>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 form-group">
                                                        <button class="btn-flower2 w-100" type="submit"><?php echo app('translator')->get('Search'); ?></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="table-wrapper table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                                                    <th scope="col"><?php echo app('translator')->get('Name'); ?></th>
                                                    <th scope="col"><?php echo app('translator')->get('Price'); ?></th>
                                                    <th scope="col"><?php echo app('translator')->get('Purchased At'); ?></th>
                                                    <th scope="col"><?php echo app('translator')->get('End of Purchase'); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__empty_1 = true; $__currentLoopData = $myPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td><?php echo e(loopIndex($myPlans) + $loop->index); ?></td>
                                                        <td><?php echo app('translator')->get(optional($data->planDetails)->name); ?></td>
                                                        <td><?php echo e(getAmount($data->amount)); ?> <?php echo app('translator')->get($basic->currency); ?></td>
                                                        <td><?php echo e(dateTime($data->created_at, 'd M Y, h:i A')); ?></td>
                                                        <td><?php echo e(dateTime($data->created_at->addYear(), 'd M Y, h:i A')); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center"><?php echo app('translator')->get('No Data Found!'); ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>


<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/myPlans/myPlans.blade.php ENDPATH**/ ?>