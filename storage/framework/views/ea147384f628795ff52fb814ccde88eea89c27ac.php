<?php $__env->startSection('title',trans('Login')); ?>


<?php $__env->startSection('content'); ?>
    <!-- login section -->
    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="<?php echo e(route('login')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="row g-3 g-md-4">
                            <div class="col-12">
                                <input class="form-control" type="text" name="username" value="<?php echo e(old('username')); ?>" placeholder="<?php echo app('translator')->get('Email Or Username'); ?>">
                                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger mt-1"><?php echo app('translator')->get($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger mt-1"><?php echo app('translator')->get($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                 <div class="input-group">
									<input type="password" name="password" id="password" class="form-control" placeholder="<?php echo app('translator')->get('Password'); ?>" required>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="fas fa-eye toggle-password" data-toggle="#password" ></i>
										</span>
									</div>
								</div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger mt-1"><?php echo app('translator')->get($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <?php if(basicControl()->reCaptcha_status_login): ?>
                                <div class="col-12">
                                    <?php echo NoCaptcha::renderJs(session()->get('trans')); ?>

                                    <?php echo NoCaptcha::display(); ?>

                                    <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger"><?php echo app('translator')->get($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            <?php endif; ?>

                            <div class="col-12">
                                <div class="links">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?> value="" id="flexCheckDefault"/>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo app('translator')->get('Remember me'); ?>
                                        </label>
                                    </div>
                                    <a href="<?php echo e(route('password.request')); ?>"><?php echo app('translator')->get('Forgot password?'); ?></a>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-flower"><?php echo app('translator')->get('sign in'); ?></button>
                        <div class="bottom"><?php echo app('translator')->get("Don't have an account?"); ?> <br />
                            <a href="<?php echo e(route('register')); ?>"><?php echo app('translator')->get('Create account'); ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
		
		document.querySelectorAll('.toggle-password').forEach(item => {
        item.addEventListener('click', function() {
            const input = document.querySelector(this.getAttribute('data-toggle'));
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });

    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/auth/login.blade.php ENDPATH**/ ?>