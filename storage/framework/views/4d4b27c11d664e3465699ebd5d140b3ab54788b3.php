<?php $__env->startSection('title',trans('Dashboard')); ?>

<?php $__env->startSection('content'); ?>

    <section class="dashboard-section">
        <div class="container">
            <div class="row gy-5 g-lg-4">

                <?php echo $__env->make($theme.'user.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-heart" aria-hidden="true"></i>
                                    </div>
                                    <h4><?php echo app('translator')->get($purchasedPlanItems->express_interest ?? 0); ?></h4>
                                    <span class="d-block"><?php echo app('translator')->get('Remaining'); ?></span>
                                    <span><?php echo app('translator')->get('Interest'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-users"></i>
                                    </div>
                                    <h4><?php echo app('translator')->get($purchasedPlanItems->contact_view_info ?? 0); ?></h4>
                                    <span class="d-block"><?php echo app('translator')->get('Remaining'); ?></span>
                                    <span><?php echo app('translator')->get('Profile View'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-image" aria-hidden="true"></i>
                                    </div>
                                    <h4><?php echo app('translator')->get($purchasedPlanItems->gallery_photo_upload ?? 0); ?></h4>
                                    <span class="d-block"><?php echo app('translator')->get('Remaining'); ?></span>
                                    <span><?php echo app('translator')->get('Gallery Image Upload'); ?></span>
                                </div>
                            </div>
                        </div>


                        <div class="row g-md-4 gy-3 my-3">

                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-list-ul"></i>
                                    </div>
                                    <h4><?php echo app('translator')->get($shortlistCount); ?></h4>
                                    <span class="d-block"><?php echo app('translator')->get('Shortlisted'); ?></span>
                                    <span><?php echo app('translator')->get('Member'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-heart" aria-hidden="true"></i>
                                    </div>
                                    <h4><?php echo app('translator')->get($interestlistCount); ?></h4>
                                    <span class="d-block"><?php echo app('translator')->get('Interested'); ?></span>
                                    <span><?php echo app('translator')->get('Member'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-ban" aria-hidden="true"></i>
                                    </div>
                                    <h4><?php echo app('translator')->get($ignorelistCount); ?></h4>
                                    <span class="d-block"><?php echo app('translator')->get('Ignored'); ?></span>
                                    <span><?php echo app('translator')->get('Member'); ?></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon-box">
                                        <i class="fal fa-image" aria-hidden="true"></i>
                                    </div>
                                    <h4><?php echo app('translator')->get($uploadedStoryCount); ?></h4>
                                    <span class="d-block"><?php echo app('translator')->get('Uploaded'); ?></span>
                                    <span><?php echo app('translator')->get('Story'); ?></span>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="progress-wrapper">
                                    <div
                                        id="container"
                                        class="apexcharts-canvas theme-color"
                                    ></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset($themeTrue.'js/apexcharts.js')); ?>"></script>

    <script>
        "use strict";

        var options = {
            theme: {
                mode: 'light',
            },

            series: [
                {
                    name: "<?php echo e(trans('Payment')); ?>",
                    color: '#fb846f',
                    data: <?php echo $monthly['payment']->flatten(); ?>

                }
            ],
            chart: {
                type: 'bar',
                // height: ini,
                background: '#fff',
                toolbar: {
                    show: false
                }

            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo $monthly['payment']->keys(); ?>,

            },
            yaxis: {
                title: {
                    text: ""
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                colors: ['#000'],
                y: {
                    formatter: function (val) {
                        return "<?php echo e(trans($basic->currency_symbol)); ?>" + val + ""
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#container"), options);
        chart.render();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/dashboard.blade.php ENDPATH**/ ?>