
<!--------------Astronomic Information----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="astronomicInformation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseAstronomicInformation"
            aria-expanded="false"
            aria-controls="collapseAstronomicInformation"
        >
            <i class="fas fa-telescope"></i>
            <?php echo app('translator')->get('Astronomic Information'); ?>
        </button>
    </h5>

    <div
        id="collapseAstronomicInformation"
        class="accordion-collapse collapse <?php if($errors->has('astronomicInformation')|| session()->get('name') == 'astronomicInformation'): ?> show <?php endif; ?>"
        aria-labelledby="astronomicInformation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="<?php echo e(route('user.astronomicInformation')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="sun_sign"><?php echo app('translator')->get('Zodic sign'); ?></label>
                        <input
                            type="text"
                            class="form-control"
                            name="sun_sign"
							id="sun_sign"
                            value="<?php echo e(old('sun_sign') ?? $user->sun_sign); ?>"
                            placeholder="<?php echo app('translator')->get('Zodic sign'); ?>"
                        />
                        <?php if($errors->has('sun_sign')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('sun_sign')); ?> </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group" style="display:none;">
                        <label for="moon_sign"><?php echo app('translator')->get('moon sign'); ?></label>
                        <input
                            type="text"
                            class="form-control"
                            name="moon_sign"
                            value="<?php echo e(old('moon_sign') ?? $user->moon_sign); ?>"
                            placeholder="<?php echo app('translator')->get('moon sign'); ?>"
                        />
                        <?php if($errors->has('moon_sign')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('moon_sign')); ?> </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="time_of_birth"><?php echo app('translator')->get('Time of Birth'); ?></label>
                        <input type="time" class="form-control" name="time_of_birth"
                               value="<?php echo e(old('time_of_birth') ?? $user->time_of_birth); ?>"/>
                        <?php $__errorArgs = ['time_of_birth'];
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

                    <div class="col-md-6 form-group">
                        <label for="city_of_birth"><?php echo app('translator')->get('City of Birth'); ?></label>
                        <input type="text" class="form-control" name="city_of_birth"
                               value="<?php echo e(old('city_of_birth') ?? $user->city_of_birth); ?>"/>
                        <?php $__errorArgs = ['city_of_birth'];
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

                    <div class="col-12 text-end">
                        <button type="submit" class="btn-flower2 btn-full mt-2"><?php echo app('translator')->get('update'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        function calculateZodiac() {
            const birthdate = new Date(document.getElementById('date_of_birth').value);
			//alert(birthdate);
            const day = birthdate.getDate();
            const month = birthdate.getMonth() + 1; // JavaScript months are 0-11

            let zodiacSign = "";

            if ((month == 1 && day >= 20) || (month == 2 && day <= 18)) {
                zodiacSign = "Aquarius";
            } else if ((month == 2 && day >= 19) || (month == 3 && day <= 20)) {
                zodiacSign = "Pisces";
            } else if ((month == 3 && day >= 21) || (month == 4 && day <= 19)) {
                zodiacSign = "Aries";
            } else if ((month == 4 && day >= 20) || (month == 5 && day <= 20)) {
                zodiacSign = "Taurus";
            } else if ((month == 5 && day >= 21) || (month == 6 && day <= 20)) {
                zodiacSign = "Gemini";
            } else if ((month == 6 && day >= 21) || (month == 7 && day <= 22)) {
                zodiacSign = "Cancer";
            } else if ((month == 7 && day >= 23) || (month == 8 && day <= 22)) {
                zodiacSign = "Leo";
            } else if ((month == 8 && day >= 23) || (month == 9 && day <= 22)) {
                zodiacSign = "Virgo";
            } else if ((month == 9 && day >= 23) || (month == 10 && day <= 22)) {
                zodiacSign = "Libra";
            } else if ((month == 10 && day >= 23) || (month == 11 && day <= 21)) {
                zodiacSign = "Scorpio";
            } else if ((month == 11 && day >= 22) || (month == 12 && day <= 21)) {
                zodiacSign = "Sagittarius";
            } else if ((month == 12 && day >= 22) || (month == 1 && day <= 19)) {
                zodiacSign = "Capricorn";
            }

            document.getElementById('sun_sign').value = "" + zodiacSign;
        }
		$(document).ready(function () {
		calculateZodiac();
		});
    </script>
<?php $__env->stopPush(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/astronomic-information.blade.php ENDPATH**/ ?>