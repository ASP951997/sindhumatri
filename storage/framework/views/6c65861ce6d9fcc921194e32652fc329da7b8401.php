<!-- BLOG -->
<?php if(isset($templates['blog'][0]) && $blog = $templates['blog'][0]): ?>
    <section class="blog-section">
        <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text">
                    <h2><?php echo app('translator')->get(@$blog->description->title); ?></h2>
                    <p><?php echo app('translator')->get(@$blog->description->sub_title); ?></p>
                </div>
            </div>
        </div>
        <div class="row gy-5 g-md-5">
            <?php $__currentLoopData = $blogs->take(3)->sortDesc()->shuffle(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="box">
                        <div class="img-box text-center">
                            <img
                                class="img-fluid"
                                src="<?php echo e(asset('assets/uploads/blog/thumb_couple_anjali_karan.jpg')); ?>"
                                alt="<?php echo app('translator')->get('blog image'); ?>"
                                style="max-width: 100%; height: auto; margin: 0 auto; display: block;"
                            />
                        </div>
                        <div class="text-box">
                            <h4><?php echo app('translator')->get(\Illuminate\Support\Str::limit(optional($blog->details)->title,28)); ?></h4>
                            <p><?php echo app('translator')->get(\Illuminate\Support\Str::limit(optional($blog->details)->details,100)); ?></p>
                            <a href="<?php echo e(route('blogDetails',[slug(optional($blog->details)->title), $blog->id])); ?>" class="read-more"><?php echo app('translator')->get('Read more...'); ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/sections/blog.blade.php ENDPATH**/ ?>