<?php if(isset($templates['about-us'][0]) && $aboutUs = $templates['about-us'][0]): ?>

    <!-- ABOUT-US -->
    <section class="about-section">
        <div class="container">
            <div
                class="row align-items-center justify-content-between gy-5 g-lg-5"
            >
                <div class="col-lg-6">
                    <div class="img-box">
                    <img class="about-img" src="<?php echo e(getFile(config('location.content.path').@$aboutUs->templateMedia()->left_image)); ?>" alt="<?php echo app('translator')->get('about img'); ?>" />
                    <img class="" src="<?php echo e(getFile(config('location.content.path').@$aboutUs->templateMedia()->right_image)); ?>" alt="<?php echo app('translator')->get('about frame img'); ?>" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-box">
                    <h2><?php echo app('translator')->get(@$aboutUs->description->title); ?></h2>
                    <p><?php echo trans($aboutUs->description->short_description); ?></p>

                    <a href="<?php echo e(route('about')); ?>">
                        <button class="btn-flower"><?php echo app('translator')->get('know more'); ?></button>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /ABOUT-US -->
<?php endif; ?>


<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/sections/about-us.blade.php ENDPATH**/ ?>