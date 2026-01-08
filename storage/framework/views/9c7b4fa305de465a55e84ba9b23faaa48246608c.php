<?php $__env->startSection('title',trans('Register')); ?>

<?php $__env->startSection('content'); ?>
    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="<?php echo e(route('register')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="row g-3 g-md-4">

                            <div class="col-md-6 form-group">
                                <input class="form-control" pattern="[A-Za-z]+" type="text" name="firstname" title="Only letters are allowed" value="<?php echo e(old('firstname')); ?>" placeholder="<?php echo app('translator')->get('First Name'); ?>" required>
                                <?php $__errorArgs = ['firstname'];
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

                            <div class="col-md-6 form-group">
                                <input class="form-control" pattern="[A-Za-z]+" type="text" name="lastname" title="Only letters are allowed" value="<?php echo e(old('lastname')); ?>"  placeholder="<?php echo app('translator')->get('Last Name'); ?>" required>
                                <?php $__errorArgs = ['lastname'];
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

                            <div class="col-md-6 form-group">
                                <input class="form-control" type="text" name="username" value="<?php echo e(old('username')); ?>"  placeholder="<?php echo app('translator')->get('Username'); ?>" required>
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
                            </div>

                            <div class="col-md-6 form-group">
                                <input class="form-control" type="text" name="email" value="<?php echo e(old('email')); ?>"  placeholder="<?php echo app('translator')->get('Email Address'); ?>" required>
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

                            <div class="col-md-12 form-group">
                                    <?php
                                        $country_code = (string) @getIpInfo()['code'] ?: null;
                                        $myCollection = collect(config('country'))->map(function($row) {
                                            return collect($row);
                                        });
                                        $countries = $myCollection->sortBy('code');
                                    ?>

                                    <div class="input-group">
                                        <div class="input-group-prepend w-50">
                                            <select name="phone_code" class="form-control country_code dialCode-change" required>
                                                <?php $__currentLoopData = config('country'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($value['phone_code']); ?>"
                                                            data-name="<?php echo e($value['name']); ?>"
                                                            data-code="<?php echo e($value['code']); ?>"
                                                        <?php echo e($country_code == $value['code'] ? 'selected' : ''); ?>

                                                    > <?php echo e($value['name']); ?> (<?php echo e($value['phone_code']); ?>)

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <input type="tel" name="phone" class="form-control dialcode-set"
                                            value="<?php echo e(old('phone')); ?>"
                                            placeholder="<?php echo app('translator')->get('Your Phone Number'); ?>" onkeyup="this.value = this.value.replace(/[^0-9-]/g, '');" pattern="[0-9]{10}" maxlength="10" title="Please enter a 10-digit phone number" required>
                                    </div>


                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger mt-1"><?php echo app('translator')->get($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                    <input type="hidden" name="country_code" value="<?php echo e(old('country_code')); ?>" class="text-dark" >
                            </div>


                            <!-- Password Field -->
<div class="form-group">
    <label for="password">Password</label>
    <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" required>
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="fas fa-eye-slash toggle-password" data-toggle="#password"></i>
            </span>
        </div>
    </div>
</div>

<!-- Confirm Password Field -->
<div class="form-group">
    <label for="password_confirmation">Confirm Password</label>
    <div class="input-group">
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="fas fa-eye-slash toggle-password" data-toggle="#password_confirmation"></i>
            </span>
        </div>
    </div>
</div>


                            <?php if(basicControl()->reCaptcha_status_registration): ?>
                                <div class="col-md-12 form-group">
                                    <?php echo NoCaptcha::renderJs(session()->get('trans')); ?>

                                    <?php echo NoCaptcha::display(); ?>

                                    <?php $__errorArgs = ['g-recaptcha-response'];
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
                            <?php endif; ?>


                            <div class="col-12">
                                <div class="links">
                                    <div class="form-check">
                                       <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"/>
                                       <label class="form-check-label" for="flexCheckDefault">
                                          <?php echo app('translator')->get('By signing up you agree to our '); ?>
                                          <a href=""><?php echo app('translator')->get('T&C.'); ?></a>
                                       </label>
                                    </div>
                                 </div>
                            </div>

                        </div>

                        <button class="btn-flower"><?php echo app('translator')->get('sign up'); ?></button>

                        <div class="bottom"><?php echo app('translator')->get('Already have an account?'); ?><br />
                            <a href="<?php echo e(route('login')); ?>"><?php echo app('translator')->get('Sign In'); ?></a>
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
        $(document).ready(function () {
            setDialCode();
            $(document).on('change', '.dialCode-change', function () {
                setDialCode();
            });
            function setDialCode() {
                let currency = $('.dialCode-change').val();
                //$('.dialcode-set').val(currency);
            }
        });
		
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

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/auth/register.blade.php ENDPATH**/ ?>