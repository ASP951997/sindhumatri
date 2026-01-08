<!-- Plan -->
<?php if( 0 < count($plans)): ?>
    <?php if(isset($templates['package'][0]) && $package = $templates['package'][0]): ?>
        <section class="pricing-section">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="header-text">
                            <h2><?php echo app('translator')->get(@$package->description->title); ?></h2>
                            <p><?php echo app('translator')->get(@$package->description->sub_title); ?></p>
                        </div>
                    </div>
                </div>

                <div class="row gy-3 g-md-5">
                    <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="box">
                                <div class="icon-box"><i class="<?php echo e($data->icon); ?>"></i></div>
                                <div class="text-box">
                                <h4><?php echo app('translator')->get($data->details->name); ?></h4>
                                <?php if($data->price == 0): ?>
                                    <h2><?php echo app('translator')->get('Free'); ?></h2>
                                <?php else: ?>
                                    <h2><span><?php echo app('translator')->get($basic->currency_symbol ?? '$'); ?></span><?php echo e($data->price); ?></h2>
                                <?php endif; ?>
                                <ul>
                                    <li>
                                        <?php if($data->express_interest_status == 1): ?>
                                            <i class="fal fa-check"></i>
                                        <?php else: ?>
                                            <i class="far fa-times"></i>
                                        <?php endif; ?>
                                        <span><?php echo app('translator')->get($data->express_interest); ?> <?php echo app('translator')->get('Express Interests'); ?></span>
                                    </li>
                                    <li>
                                        <?php if($data->gallery_photo_upload_status == 1): ?>
                                            <i class="fal fa-check"></i>
                                        <?php else: ?>
                                            <i class="far fa-times"></i>
                                        <?php endif; ?>
                                        <span><?php echo app('translator')->get($data->gallery_photo_upload); ?> <?php echo app('translator')->get('Gallery Photo Upload'); ?></span>
                                    </li>
                                    <li>
                                        <?php if($data->contact_view_info_status == 1): ?>
                                            <i class="fal fa-check"></i>
                                        <?php else: ?>
                                            <i class="far fa-times"></i>
                                        <?php endif; ?>
                                        <span><?php echo app('translator')->get($data->contact_view_info); ?> <?php echo app('translator')->get('Profile Info View'); ?></span>
                                    </li>
                                    <li>
                                        <?php if($data->show_auto_profile_match == 1): ?>
                                            <i class="fal fa-check"></i>
                                        <?php else: ?>
                                            <i class="far fa-times"></i>
                                        <?php endif; ?>
                                        <span><?php echo app('translator')->get('Show Auto Profile Match'); ?></span>
                                    </li>

                                </ul>

                                <?php if(isset($freePlan->free_plan_purchased) && $freePlan->free_plan_purchased == 1 && $data->price == 0): ?>
                                    <button class="btn-flower disabled planPurchaseButton"
                                    >
                                        <del><?php echo app('translator')->get('Purchase Package'); ?></del>
                                    </button>
                                <?php else: ?>
                                    <button class="btn-flower purchaseNow planPurchaseButton"
                                            data-bs-toggle="modal"
                                            data-bs-target="#planModal"
                                            data-price="<?php echo e($data->price); ?>"
                                            data-resource="<?php echo e($data->details); ?>"
                                    >
                                        <?php echo app('translator')->get('Purchase Package'); ?>
                                    </button>
                                <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <img
            src="<?php echo e(getFile(config('location.content.path').@$package->templateMedia()->right_image)); ?>"
            alt="<?php echo app('translator')->get('package image'); ?>"
            class="flower"
            data-aos="fade-up"
            data-aos-duration="800"
            data-aos-anchor-placement="center-bottom"
            />
        </section>


        <!--Plan Modal -->
        <div id="planModal" class="modal fade modal-with-form" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">

                <!-- Modal content-->
                <div class="modal-content form-block">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo app('translator')->get('Purchase Package'); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="login-form" id="invest-form" action="<?php echo e(route('user.purchase-plan')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="form-group">
                                <h3 class="text-green text-center plan-name"></h3>

                                <h4 class="text-center plan-price"></h4>

                                <input type="hidden" name="checkout" value="checkout">

                                <input type="hidden" name="plan_id" class="plan-id">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-flower2 btn1" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                            <button type="submit" class="btn-flower2 btn2"><?php echo app('translator')->get('Purchase Now'); ?></button>
                        </div>

                    </form>
                </div>

            </div>
        </div>

    <?php endif; ?>

<?php endif; ?>

<?php if(request()->routeIs('plan') && 0 >= count($plans)): ?>
    <div class="d-flex flex-column justify-content-center py-5">
        <h3 class="text-center mt-5 mb-5"><?php echo app('translator')->get('No Plan Available.'); ?></h3>
        <a href="<?php echo e(route('home')); ?>" class="text-center">
            <button class="btn-flower">
                <?php echo app('translator')->get('Back to Home'); ?>
            </button>
        </a>
    </div>
<?php endif; ?>


<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function ($) {
            $(document).on('click', '.purchaseNow', function () {
                let data = $(this).data('resource');
                let price = $(this).data('price');

                let symbol = "<?php echo e(trans($basic->currency_symbol)); ?>";

                $('.plan-price').text(`<?php echo app('translator')->get('Price'); ?>: ${symbol}${price}`);

                $('.plan-name').text(data.name);
                $('.plan-id').val(data.plan_id);
            });
        })(jQuery);

        $(document).on('click', '.disabled', function (){
            Notiflix.Notify.Failure("<?php echo app('translator')->get('You can use this package only once. Please purchase new one.'); ?>");
        })

    </script>


    <?php if(count($errors) > 0 ): ?>
        <script>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            Notiflix.Notify.Failure("<?php echo app('translator')->get($error); ?>");
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </script>
    <?php endif; ?>

<?php $__env->stopPush(); ?>



<!-- /Plan -->
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/sections/plan.blade.php ENDPATH**/ ?>