<?php if(isset($templates['counter'][0]) && $counter = $templates['counter'][0]): ?>
    <?php if(isset($contentDetails['testimonial'])): ?>
    <?php if(0 < count($contentDetails['testimonial'])): ?>
        <section class="counter-section">
            <div class="container">
                <div class="row gy-5 g-md-5">
                    <?php $__currentLoopData = $contentDetails['counter']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="box">
                                <h2><span class="counter"><?php echo app('translator')->get(@$data->description->number); ?></span></h2>
                                <h4><?php echo app('translator')->get(@$data->description->title); ?></h4>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <img
            src="<?php echo e(getFile(config('location.content.path').@$counter->templateMedia()->right_image)); ?>"
            alt="<?php echo app('translator')->get('Counter image'); ?>"
            class="flower"
            class="flower"
            data-aos="fade-left"
            data-aos-duration="800"
            data-aos-anchor-placement="center-bottom"
            />
        </section>
    <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/sections/counter.blade.php ENDPATH**/ ?>