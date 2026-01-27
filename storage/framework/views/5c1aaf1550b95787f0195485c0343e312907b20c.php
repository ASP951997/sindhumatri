
<!--------------Lifestyle----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="lifestyle">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseLifestyle"
            aria-expanded="false"
            aria-controls="collapseLifestyle"
        >
            <i class="fas fa-glass-cheers"></i>
            <?php echo app('translator')->get('Lifestyle'); ?>
        </button>
    </h5>

    <div
        id="collapseLifestyle"
        class="accordion-collapse collapse <?php if($errors->has('lifestyle') || session()->get('name') == 'lifestyle'): ?> show <?php endif; ?>"
        aria-labelledby="lifestyle"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="<?php echo e(route('user.lifestyle')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="diet"><?php echo app('translator')->get('diet'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="diet"
                            aria-label="diet"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="Veg" <?php echo e(old('diet', $user->diet == 'Veg') ? 'selected' : ''); ?>><?php echo app('translator')->get('Veg'); ?></option>
                            <option value="Non-Veg" <?php echo e(old('diet', $user->diet == 'Non-Veg') ? 'selected' : ''); ?>><?php echo app('translator')->get('Non-Veg'); ?></option>
                            <option value="Eggitarian" <?php echo e(old('diet', $user->diet == 'Eggitarian') ? 'selected' : ''); ?>><?php echo app('translator')->get('Eggitarian'); ?></option>
                            <option value="Occasionally non-veg" <?php echo e(old('diet', $user->diet == 'Occasionally non-veg') ? 'selected' : ''); ?>><?php echo app('translator')->get('Occasionally non-veg'); ?></option>
                        </select>
                        <?php $__errorArgs = ['diet'];
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
                        <label for="drink"><?php echo app('translator')->get('drink'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="drink"
                            aria-label="drink"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="Yes" <?php echo e(old('drink', $user->drink == 'Yes') ? 'selected' : ''); ?>><?php echo app('translator')->get('Yes'); ?></option>
                            <option value="No" <?php echo e(old('drink', $user->drink == 'No') ? 'selected' : ''); ?>><?php echo app('translator')->get('No'); ?></option>
                            <option value="Occasionally" <?php echo e(old('drink', $user->drink == 'Occasionally') ? 'selected' : ''); ?>><?php echo app('translator')->get('Occasionally'); ?></option>
                        </select>
                        <?php $__errorArgs = ['drink'];
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
                        <label for="smoke"><?php echo app('translator')->get('smoke'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="smoke"
                            aria-label="smoke"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="Yes" <?php echo e(old('smoke', $user->smoke == 'Yes') ? 'selected' : ''); ?>><?php echo app('translator')->get('Yes'); ?></option>
                            <option value="No" <?php echo e(old('smoke', $user->smoke == 'No') ? 'selected' : ''); ?>><?php echo app('translator')->get('No'); ?></option>
                            <option value="Occasionally" <?php echo e(old('smoke', $user->smoke == 'Occasionally') ? 'selected' : ''); ?>><?php echo app('translator')->get('Occasionally'); ?></option>
                        </select>
                        <?php $__errorArgs = ['smoke'];
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
                        <label for="living_with"><?php echo app('translator')->get('Living With'); ?></label> <span class="text-danger">*</span>
                        <!--<input
                            type="text"
                            class="form-control"
                            name="living_with"
                            value="<?php echo e(old('living_with') ?? $user->living_with); ?>"
                            placeholder="<?php echo app('translator')->get('Living With'); ?>"
                        /> -->
                        <select
                            class="form-select"
                            name="living_with"
                            aria-label="living_with"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="Bachelor " <?php echo e(old('living_with', $user->living_with == 'Bachelor') ? 'selected' : ''); ?>><?php echo app('translator')->get('Bachelor'); ?></option>
                            <option value="With-Family" <?php echo e(old('living_with', $user->living_with == 'With-Family') ? 'selected' : ''); ?>><?php echo app('translator')->get('With-Family'); ?></option>
                            </select>
                        <?php $__errorArgs = ['living_with'];
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
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/lifestyle.blade.php ENDPATH**/ ?>