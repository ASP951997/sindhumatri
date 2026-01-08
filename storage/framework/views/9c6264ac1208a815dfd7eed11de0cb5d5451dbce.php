<?php if(isset($templates['story'][0]) && $story = $templates['story'][0]): ?>
    <?php if(0<count($stories)): ?>

        <!-- happy stories -->
        <section class="happy-stories">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="header-text">
                            <h2><?php echo app('translator')->get(@$story->description->title); ?></h2>
                            <p><?php echo app('translator')->get(@$story->description->sub_title); ?></p>
                        </div>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3"
                    data-masonry='{"percentPosition": true }'>

                    <?php if(request()->routeIs('home')): ?>
                        <?php $__currentLoopData = $stories->take(9)->shuffle(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col">
                                <div class="img-box">
                                <img src="<?php echo e(getFile(config('location.story.path').'thumb_'.@$data->image)); ?>" alt="" class="img-fluid" />
                                <a href="<?php echo e(route('storyDetails',[slug($data->title), $data->id])); ?>" class="hover-content">
                                    <div class="text-box">
                                        <h4><?php echo app('translator')->get($data->name); ?></h4>
                                        <h5><?php echo app('translator')->get($data->place); ?> - <?php echo e(dateTime(@$data->date,'d M, Y')); ?></h5>
                                    </div>
                                </a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <?php $__currentLoopData = $stories->shuffle(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col">
                                <div class="img-box">
                                    <img src="<?php echo e(getFile(config('location.story.path').'thumb_'.@$data->image)); ?>" alt="<?php echo app('translator')->get('story img'); ?>" class="img-fluid" />
                                    <a href="<?php echo e(route('storyDetails',[slug($data->title), $data->id])); ?>" class="hover-content">
                                        <div class="text-box">
                                            <h4><?php echo app('translator')->get($data->name); ?></h4>
                                            <h5><?php echo app('translator')->get($data->place); ?> - <?php echo e(dateTime(@$data->date,'d M, Y')); ?></h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                </div>

                <?php if(!request()->routeIs('home')): ?>
                    <div class="row py-5 mt-5">
                        <?php echo e($stories->links()); ?>

                    </div>
                <?php endif; ?>

                <?php if(request()->routeIs('home') && 9<count($stories)): ?>
                    <div class="mt-5 text-center">
                        <a href="<?php echo e(route('story')); ?>">
                            <button class="btn-flower"><?php echo app('translator')->get('show more'); ?></button>
                        </a>
                    </div>
                <?php endif; ?>

            </div>

            <img
                src="<?php echo e(getFile(config('location.content.path').@$story->templateMedia()->right_image)); ?>"
                alt="<?php echo app('translator')->get('story image'); ?>"
                class="flower"
                data-aos="fade-up"
                data-aos-duration="800"
                data-aos-anchor-placement="center-bottom"
            />
        </section>

    <?php else: ?>
        <?php if(!request()->routeIs('home')): ?>
            <div class="row py-5 mt-5">
                <h2 class="py-5 text-center"><?php echo app('translator')->get('No Story Available.'); ?></h2>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/sections/story.blade.php ENDPATH**/ ?>