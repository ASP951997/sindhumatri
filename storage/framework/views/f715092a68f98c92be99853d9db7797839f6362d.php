<?php if(isset($templates['hero'][0]) && $hero = $templates['hero'][0]): ?>
    <?php $__env->startPush('style'); ?>
        <style>
            .home-section {
                height: 100vh;
                background: url(<?php echo e(getFile(config('location.content.path').@$hero->templateMedia()->left_image)); ?>);
                background-repeat: no-repeat;
                background-position: top left;
            }
            .home-section .overlay {
                background: url(<?php echo e(getFile(config('location.content.path').@$hero->templateMedia()->right_image)); ?>);
                background-repeat: no-repeat;
                background-position: bottom right;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <section class="home-section">
         <div class="overlay h-100">
            <div class="container h-100">
               <div class="row h-100 align-items-center justify-content-around">
                  <div class="col d-flex justify-content-center">
                     <div class="text-box w-75">
                        <h1><?php echo app('translator')->get(@$hero->description->title); ?></h1>
                        <p><?php echo app('translator')->get(@$hero->description->sub_title); ?></p>
                        <a href="<?php echo e(@$hero->templateMedia()->button_link); ?>">
                            <button class="btn-flower">
                            <?php echo app('translator')->get(@$hero['description']->button_name); ?>
                        </button></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
<?php endif; ?>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/partials/heroBanner.blade.php ENDPATH**/ ?>