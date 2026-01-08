<!-- FOOTER -->
<footer class="footer-section">
    <div class="container">
       <div class="row gy-5 g-md-5">
            <div class="col-lg-3 col-md-6">
                <div class="box box1">
                    <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                        <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>" alt="<?php echo e(config('basic.site_title')); ?>">
                    </a>
                    <?php if(isset($contactUs['contact-us'][0]) && $contact = $contactUs['contact-us'][0]): ?>
                        <p><?php echo app('translator')->get(@$contact->description->address); ?></p>
                        <p><?php echo app('translator')->get('Email: '); ?><?php echo app('translator')->get(@$contact->description->email_one); ?></p>
                        <p><?php echo app('translator')->get('Phone: '); ?><?php echo app('translator')->get(@$contact->description->phone_one); ?></p>
                    <?php endif; ?>
                    <?php if(isset($contentDetails['social'])): ?>
                        <div class="social-links">
                            <?php $__currentLoopData = $contentDetails['social']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(@$data->content->contentMedia->description->link); ?>">
                                    <i class="<?php echo e(@$data->content->contentMedia->description->icon); ?>"></i>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="box">
                    <h5><?php echo app('translator')->get('useful links'); ?></h5>
                    <ul class="links">
                    <li><a href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('Home'); ?></a></li>
                    <li><a href="<?php echo e(route('about')); ?>"><?php echo app('translator')->get('About'); ?></a></li>
                    <li><a href="<?php echo e(route('plan')); ?>"><?php echo app('translator')->get('Package'); ?></a></li>
                    <li><a href="<?php echo e(route('blog')); ?>"><?php echo app('translator')->get('Blog'); ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="box">
                    <h5><?php echo app('translator')->get('quick search'); ?></h5>
                    <ul class="links">
                        <li><a href="<?php echo e(route('faq')); ?>"><?php echo app('translator')->get('faq'); ?></a></li>
                        <li><a href="<?php echo e(route('contact')); ?>"><?php echo app('translator')->get('contact'); ?></a></li>
                        <?php if(isset($contentDetails['support'])): ?>
                            <?php $__currentLoopData = $contentDetails['support']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(route('getLink', [slug($data->description->title), $data->content_id])); ?>"><?php echo app('translator')->get($data->description->title); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <?php if(isset($newsLetter['news-letter'][0]) && $newsLetter = $newsLetter['news-letter'][0]): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="box">
                        <h5><?php echo app('translator')->get(@$newsLetter->description->title); ?></h5>
                        <p><?php echo app('translator')->get(@$newsLetter->description->sub_title); ?></p>
                        <form class="subscribe-form" action="<?php echo e(route('subscribe')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="input-group">
                                <input
                                    name="email" type="email" value="<?php echo e(old('email')); ?>" placeholder="<?php echo app('translator')->get('Enter email'); ?>"
                                    class="form-control"
                                />
                                <button type="submit"><i class="fal fa-paper-plane"></i></button>
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
       </div>

       <div class="footer-bottom">
          <div class="row">
             <div class="col-md-6">
                <p class="copyright">
                    <?php echo app('translator')->get('Copyright'); ?> &copy; <?php echo e(date('Y')); ?> <a href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get($basic->site_title); ?></a> <?php echo app('translator')->get('All Rights Reserved.'); ?>
                </p>
             </div>

             <div class="col-md-6 language">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('language',[$language->short_name])); ?>">
                        <span class="flag-icon flag-icon-<?php echo e(strtolower($language->short_name)); ?>"></span> <?php echo e($language->name); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             </div>
          </div>
       </div>
    </div>
    <span></span>
    <?php if(isset($footerImage['footer'][0]) && $footer = $footerImage['footer'][0]): ?>
        <img
        src="<?php echo e(getFile(config('location.content.path').@$footer->templateMedia()->left_image)); ?>"
        alt="<?php echo app('translator')->get('Footer image'); ?>"
        class="flower"
        
        />
    <?php endif; ?>

</footer>

<!-- /FOOTER -->


<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/partials/footer.blade.php ENDPATH**/ ?>