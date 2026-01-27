<?php $__env->startSection('title',trans('Manage Profile')); ?>

<?php $__env->startSection('content'); ?>

    <section class="dashboard-section faq-section faq-page noBoxShadowInForm">
        <div class="container">
            <div class="row gy-5 g-lg-4">
                <?php echo $__env->make($theme.'user.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="col-lg-9">
                    <div class="dashboard-content profile-setting">
                        <div class="row">
                            <div class="col-12">
                                <div class="dashboard-title">
                                    <h5><?php echo app('translator')->get('Manage Profile'); ?></h5>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="accordion" id="accordionExample">

                                            <div class="mb-4 mt-2">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: <?php echo e($profileComplete); ?>%;" aria-valuenow="<?php echo e($profileComplete); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo e($profileComplete); ?>%</div>
                                                </div>
                                                <?php if(isset($approvedProfile->status) && $approvedProfile->status == 1): ?>
                                                    <span class="text-danger">*<?php echo app('translator')->get('Congratulations! Your profile is live now.'); ?></span>
                                                <?php else: ?>
                                                    <?php if($profileComplete == 100): ?>
                                                        <span class="text-danger">*<?php echo app('translator')->get('Welldone! Your profile is ready to be approved soon.'); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-danger">*<?php echo app('translator')->get('Please update your profile 100% to get approved.'); ?></span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>

                                            <?php echo $__env->make($theme.'user.profile.content.intro', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php echo $__env->make($theme.'user.profile.content.basic-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php echo $__env->make($theme.'user.profile.content.present-address', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php echo $__env->make($theme.'user.profile.content.permanent-address', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php echo $__env->make($theme.'user.profile.content.physical-attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php echo $__env->make($theme.'user.profile.content.education-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php echo $__env->make($theme.'user.profile.content.career-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php echo $__env->make($theme.'user.profile.content.language', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php echo $__env->make($theme.'user.profile.content.hobby-interest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                           
                                            <?php echo $__env->make($theme.'user.profile.content.spiritual-social-background', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php echo $__env->make($theme.'user.profile.content.lifestyle', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php echo $__env->make($theme.'user.profile.content.astronomic-information', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php echo $__env->make($theme.'user.profile.content.family-information', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php echo $__env->make($theme.'user.profile.content.partner-expectation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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


    <?php echo $__env->yieldPushContent('modal-here'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('css-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'css/select2.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'css/bootstrap-select.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'css/tagsinput.css')); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startPush('extra-js'); ?>
    <script src="<?php echo e(asset($themeTrue.'js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset($themeTrue.'js/bootstrap-select.min.js')); ?>"></script>
    <script src="<?php echo e(asset($themeTrue.'js/tagsinput.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        $(document).ready(function () {
            $('select').select2({
                width:'100%',
            });
            $('select[name=known_languages]').selectpicker();
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/myprofile.blade.php ENDPATH**/ ?>