<?php $__env->startSection('title',__('Story List')); ?>

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
                                <h5><?php echo app('translator')->get('Story List'); ?></h5>
                                <a href="<?php echo e(route('user.story.create')); ?>" class="add-new btn-flower2 text-center"><?php echo app('translator')->get('Add new'); ?></a>
                             </div>

                             <div class="row">
                                <div class="col">
                                    <div class="table-wrapper table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                                                    <th scope="col"><?php echo app('translator')->get('Name'); ?></th>
                                                    <th scope="col"><?php echo app('translator')->get('Image'); ?></th>
                                                    <th scope="col"><?php echo app('translator')->get('Privacy'); ?></th>
                                                    <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                                                    <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__empty_1 = true; $__currentLoopData = $storyList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td><?php echo e($key + 1); ?></td>
                                                        <td><?php echo app('translator')->get(\Illuminate\Support\Str::limit($value->name,20)); ?></td>
                                                        <td>
                                                            <img src="<?php echo e(getFile(config('location.story.path').'thumb_'.$value->image)); ?>" alt="<?php echo app('translator')->get('story img'); ?>"/>
                                                        </td>
                                                        <td>
                                                            <?php if($value->privacy == 1): ?>
                                                                <span class="status success"><?php echo app('translator')->get('Public'); ?></span>
                                                            <?php elseif($value->privacy == 2): ?>
                                                                <span class="status primary"><?php echo app('translator')->get('Follower'); ?></span>
                                                            <?php elseif($value->privacy == 3): ?>
                                                                <span class="status danger"><?php echo app('translator')->get('Only Me'); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if($value->status == 0): ?>
                                                                <span class="status danger"><?php echo app('translator')->get('Pending'); ?></span>
                                                            <?php elseif($value->status == 1): ?>
                                                                <span class="status success"><?php echo app('translator')->get('Approved'); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo e(route('user.story.edit',$value->id)); ?>">
                                                                <button class="action-btn success"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        title="<?php echo app('translator')->get('Edit'); ?>">
                                                                    <i class="fas fa-edit fw-900"></i>
                                                                </button>
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                                data-route="<?php echo e(route('user.story.delete',$value->id)); ?>"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete-modal"
                                                                class="action-btn danger notiflix-confirm btnDelete" >
                                                                <button class="action-btn danger"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        title="<?php echo app('translator')->get('Delete'); ?>">
                                                                    <i class="fas fa-trash fw-900"></i>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="100%" class="text-center"><?php echo app('translator')->get('No Story Found'); ?></td>
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



    <!-- Delete Modal -->
    <div id="delete-modal" class="modal fade modal-with-form" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content form-block">
                <div class="modal-header">
                        <h5 class="modal-title"><?php echo app('translator')->get('Delete Confirmation'); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you sure to delete this?'); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-flower2 btn1" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <form action="" method="post" class="deleteRoute">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('delete'); ?>
                        <button type="submit" class="btn-flower2 btn2"><?php echo app('translator')->get('Yes'); ?></button>
                    </form>
                </div>
           </div><!-- /.modal-content -->
       </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        'use strict'
        $(document).ready(function () {
            $('.notiflix-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/story/index.blade.php ENDPATH**/ ?>