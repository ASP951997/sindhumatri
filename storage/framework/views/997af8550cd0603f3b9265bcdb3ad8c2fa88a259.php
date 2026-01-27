
<!-------------- Hobbies & Interest ----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="hobbyInterest">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseHobbyInterest"
            aria-expanded="false"
            aria-controls="collapseHobbyInterest"
        >
            <i class="fal fa-gem"></i>
            <?php echo app('translator')->get('Hobbies & Interest'); ?>
        </button>
    </h5>
    <div
        id="collapseHobbyInterest"
        class="accordion-collapse collapse <?php if($errors->has('hobbyInterest') || session()->get('name') == 'hobbyInterest'): ?> show <?php endif; ?>"
        aria-labelledby="hobbyInterest"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="<?php echo e(route('user.hobbyInterest')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="hobbies"><?php echo app('translator')->get('Hobbies'); ?></label> <span class="text-danger">*</span>
                        <!--<input
                            type="text"
                            class="form-control"
                            name="hobbies"
                            value="<?php echo e(old('hobbies') ?? $user->hobbies); ?>"
                            data-role="tagsinput"
                        /> -->
                        <select
                            class="form-select"
                            name="hobbies[]"
							multiple
                            data-live-search="true"
                            aria-label="hobbies"
                        >
						
						 <?php
                                $array_of_hobbies = json_decode($user->hobbies);
                            ?>
                             <?php $__currentLoopData = config('languages')['hobbies']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item); ?>"
                                        <?php if(is_array($array_of_hobbies)): ?>
                                            <?php if((in_array($item,$array_of_hobbies))): ?>
                                                selected
                                            <?php endif; ?>
                                        <?php endif; ?>
                                     >
                                    <?php echo e($item); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('hobbies')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('hobbies')); ?> </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="interests"><?php echo app('translator')->get('Interests'); ?></label> <span class="text-danger">*</span>
                        <!--<input
                            type="text"
                            class="form-control"
                            name="interests"
                            value="<?php echo e(old('interests') ?? $user->interests); ?>"
                            data-role="tagsinput"
                        /> -->
                        <select
                            class="form-select"
                            name="interests[]"
                            aria-label="interests"
							multiple
                            data-live-search="true"
                        >
                           <?php
                                $array_of_interests = json_decode($user->interests);
                            ?>
                             <?php $__currentLoopData = config('languages')['interests']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item); ?>"
                                        <?php if(is_array($array_of_interests)): ?>
                                            <?php if((in_array($item,$array_of_interests))): ?>
                                                selected
                                            <?php endif; ?>
                                        <?php endif; ?>
                                     >
                                    <?php echo e($item); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('interests')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('interests')); ?> </div>
                        <?php endif; ?>
                    </div>

                    


                    <div class="col-12 text-end">
                        <button type="submit" class="btn-flower2 btn-full mt-2"><?php echo app('translator')->get('update'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/hobby-interest.blade.php ENDPATH**/ ?>