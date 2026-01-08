<?php if(isset($templates['premium-member'][0]) && $premiumMember = $templates['premium-member'][0]): ?>
    <section class="premium-members">
        <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text">
                    <h2><?php echo app('translator')->get(@$premiumMember->description->title); ?></h2>
                    <p><?php echo app('translator')->get(@$premiumMember->description->sub_title); ?></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="members owl-carousel">
                    <?php $__currentLoopData = $premiumMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="box">
                            <div class="img-box">
                                <img src="<?php echo e(getFile(config('location.user.path').optional($data->user)->image)); ?>" alt="<?php echo app('translator')->get('premium member image'); ?>" />
                            </div>
                            <div class="text-box">
                                <h4><?php echo app('translator')->get(optional($data->user)->firstname); ?> <?php echo app('translator')->get(optional($data->user)->lastname); ?></h4>
                                <h5><span>@</span><?php echo app('translator')->get(optional($data->user)->username); ?></h5>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        </div>
        <img
        src="<?php echo e(getFile(config('location.content.path').@$premiumMember->templateMedia()->left_image)); ?>"
        alt="<?php echo app('translator')->get('premium-member image'); ?>"
        class="flower"
        data-aos="fade-up"
        data-aos-duration="800"
        data-aos-anchor-placement="center-bottom"
        />
    </section>
<?php endif; ?>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/sections/premium-member.blade.php ENDPATH**/ ?>