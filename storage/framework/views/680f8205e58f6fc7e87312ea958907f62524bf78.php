
<?php if(isset($contentDetails['feature'])): ?>
    <?php if(0 < count($contentDetails['feature'])): ?>
    <!-- FEATURE -->
    <section class="feature-section">
        <div class="container">
            <div class="row gy-5 g-md-5">
                <?php $__currentLoopData = $contentDetails['feature']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="box">
                            <div class="icon-box">
                                <i class="<?php echo e(@$feature->content->contentMedia->description->icon); ?>"></i>
                            </div>
                            <div class="text-box">
                                <h4><?php echo app('translator')->get(@$feature->description->title); ?></h4>
                                <p><?php echo app('translator')->get(@$feature->description->information); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <?php if(isset($templates['feature'][0]) && $feature = $templates['feature'][0]): ?>
            <img
            src="<?php echo e(getFile(config('location.content.path').@$feature->templateMedia()->left_image)); ?>"
            alt="<?php echo app('translator')->get('feature image'); ?>"
            class="flower"
            data-aos="fade-right"
            data-aos-duration="800"
            data-aos-anchor-placement="center-bottom"
            />
        <?php endif; ?>
    </section>
    <!-- /FEATURE -->
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/sections/feature.blade.php ENDPATH**/ ?>