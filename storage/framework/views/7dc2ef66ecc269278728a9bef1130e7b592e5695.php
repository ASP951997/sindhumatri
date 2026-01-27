
<!--------------Language----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="language">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseLanguage"
            aria-expanded="false"
            aria-controls="collapseLanguage"
        >
            <i class="fas fa-language"></i>
            <?php echo app('translator')->get('Language'); ?>
        </button>
    </h5>
    <div
        id="collapseLanguage"
        class="accordion-collapse collapse <?php if($errors->has('language') || session()->get('name') == 'setlanguages'): ?> show <?php endif; ?>"
        aria-labelledby="language"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="<?php echo e(route('user.setLanguage')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="mother_tongue"><?php echo app('translator')->get('Mother Tongue'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="mother_tongue"
                            aria-label="mother_tongue"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = config('languages')['langCodeWithoutFlagSindhi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item); ?>" <?php if($item == old('mother_tongue',$user->mother_tongue )): ?> selected <?php endif; ?>><?php echo e($item); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['mother_tongue'];
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
                        <label for="known_languages"><?php echo app('translator')->get('Known Languages'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-control"
                            name="known_languages[]"
                            multiple
                            data-live-search="true"
                        >
                            <?php
                                $array_of_knownLanguage = json_decode($user->known_languages);
                            ?>

                            <?php $__currentLoopData = config('languages')['langCodeWithoutFlagSindhi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item); ?>"
                                        <?php if(is_array($array_of_knownLanguage)): ?>
                                            <?php if((in_array($item,$array_of_knownLanguage))): ?>
                                                selected
                                            <?php endif; ?>
                                        <?php endif; ?>
                                     >
                                    <?php echo e($item); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['known_languages'];
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

<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/language.blade.php ENDPATH**/ ?>