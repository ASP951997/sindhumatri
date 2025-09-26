<style>
    .banner {
        background: url(<?php echo e(getFile(config('location.logo.path').'banner.jpg')); ?>);
        background-size: cover;
    }
</style>

<?php if(!request()->routeIs('home')): ?>
    <!-- PAGE-BANNER -->
    <div class="banner">
    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col">
                <div class="header-text">
                    <h2><?php echo $__env->yieldContent('title'); ?></h2>
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /PAGE-BANNER -->
<?php endif; ?>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/partials/banner.blade.php ENDPATH**/ ?>