<?php if(isset($templates['testimonial'][0]) && $testimonial = $templates['testimonial'][0]): ?>

    <!-- TESTIMONIAL -->
    <section class="testimonial-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-text">
                        <h2><?php echo app('translator')->get($testimonial->description->title); ?></h2>
                        <p><?php echo app('translator')->get($testimonial->description->sub_title); ?></p>
                    </div>
                </div>
            </div>
            <?php if(isset($contentDetails['testimonial'])): ?>
            <?php if(0 < count($contentDetails['testimonial'])): ?>
                <div class="row">
                    <div class="col">
                        <div class="testimonials owl-carousel">
                                <?php $__currentLoopData = $contentDetails['testimonial']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="box">
                                    <div class="img-box">
                                        <img src="<?php echo e(getFile(config('location.content.path').@$data->content->contentMedia->description->image)); ?>" alt="<?php echo app('translator')->get('testimonial img'); ?>" />
                                        <i class="fal fa-quote-right"></i>
                                    </div>
                                    <div class="text-box">
                                        <h4><?php echo app('translator')->get(@$data->description->name); ?></h4>
                                        <h5><?php echo app('translator')->get(@$data->description->relation); ?></h5>
                                        <p><?php echo app('translator')->get(@$data->description->description); ?></p>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>

        <img
           src="<?php echo e(getFile(config('location.content.path').@$testimonial->templateMedia()->left_image)); ?>"
           alt="<?php echo app('translator')->get('Testimonial image'); ?>"
           class="flower"
           data-aos="fade-up"
           data-aos-duration="800"
           data-aos-anchor-placement="center-bottom"
        />
     </section>
    <!-- /TESTIMONIAL -->

<?php endif; ?>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/sections/testimonial.blade.php ENDPATH**/ ?>