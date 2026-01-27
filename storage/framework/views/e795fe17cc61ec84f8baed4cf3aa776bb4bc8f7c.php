
<!--------------Family Information----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="familyInformation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseFamilyInformation"
            aria-expanded="false"
            aria-controls="collapseFamilyInformation"
        >
            <i class="fas fa-house-day"></i>
            <?php echo app('translator')->get('Family Information'); ?>
        </button>
    </h5>

    <div
        id="collapseFamilyInformation"
        class="accordion-collapse collapse <?php if($errors->has('familyInformation') || session()->get('name') == 'familyInformation'): ?> show <?php endif; ?>"
        aria-labelledby="familyInformation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="<?php echo e(route('user.familyInformation')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="father"><?php echo app('translator')->get('father'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="father"
                            aria-label="father"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="Businessman/Entrepreneur" <?php echo e(old('father', $user->father == 'Businessman/Entrepreneur') ? 'selected' : ''); ?>><?php echo app('translator')->get('Businessman/Entrepreneur'); ?></option>
                            <option value="Private Employee" <?php echo e(old('father', $user->father == 'Private Employee"') ? 'selected' : ''); ?>><?php echo app('translator')->get('Private Employee"'); ?></option>
                            <option value="Govt./ PSU Employee" <?php echo e(old('father', $user->father == 'Govt./ PSU Employee') ? 'selected' : ''); ?>><?php echo app('translator')->get('Govt./ PSU Employee'); ?></option>
                            <option value="Armed Forces Employee" <?php echo e(old('father', $user->father == 'Armed Forces Employee') ? 'selected' : ''); ?>><?php echo app('translator')->get('Armed Forces Employee'); ?></option>
                            <option value="Civil Servant" <?php echo e(old('father', $user->father == 'Civil Servant') ? 'selected' : ''); ?>><?php echo app('translator')->get('Civil Servant'); ?></option>
                            <option value="Retired" <?php echo e(old('father', $user->father == 'Retired') ? 'selected' : ''); ?>><?php echo app('translator')->get('Retired'); ?></option>
                            <option value="Not Employed" <?php echo e(old('father', $user->father == 'Not Employed') ? 'selected' : ''); ?>><?php echo app('translator')->get('Not Employed'); ?></option>
                            <option value="Passed Away" <?php echo e(old('father', $user->father == 'Passed Away') ? 'selected' : ''); ?>><?php echo app('translator')->get('Passed Away'); ?></option>
                        </select>
                        <?php $__errorArgs = ['father'];
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
                        <label for="mother"><?php echo app('translator')->get('mother'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="mother"
                            aria-label="mother"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="Homemaker" <?php echo e(old('mother', $user->mother == 'Homemaker') ? 'selected' : ''); ?>><?php echo app('translator')->get('Homemaker'); ?></option>
                            <option value="Businesswoman/Entrepreneur" <?php echo e(old('mother', $user->mother == 'Businesswoman/Entrepreneur') ? 'selected' : ''); ?>><?php echo app('translator')->get('Businesswoman/Entrepreneur'); ?></option>
                            <option value="Private Employee" <?php echo e(old('mother', $user->mother == 'Private Employee') ? 'selected' : ''); ?>><?php echo app('translator')->get('Private Employee'); ?></option>
                            <option value="Govt./ PSU Employee" <?php echo e(old('mother', $user->mother == 'Govt./ PSU Employee') ? 'selected' : ''); ?>><?php echo app('translator')->get('Govt./ PSU Employee'); ?></option>
                            <option value="Armed Forces Employee" <?php echo e(old('mother', $user->mother == 'Armed Forces Employee') ? 'selected' : ''); ?>><?php echo app('translator')->get('Armed Forces Employee'); ?></option>
                            <option value="Civil Servant" <?php echo e(old('mother', $user->mother == 'Civil Servant') ? 'selected' : ''); ?>><?php echo app('translator')->get('Civil Servant'); ?></option>
                            <option value="Teacher" <?php echo e(old('mother', $user->mother == 'Teacher') ? 'selected' : ''); ?>><?php echo app('translator')->get('Teacher'); ?></option>
                            <option value="Retired" <?php echo e(old('mother', $user->mother == 'Retired') ? 'selected' : ''); ?>><?php echo app('translator')->get('Retired'); ?></option>
                            <option value="Passed Away" <?php echo e(old('mother', $user->mother == 'Passed Away') ? 'selected' : ''); ?>><?php echo app('translator')->get('Passed Away'); ?></option>
                        </select>
                        <?php $__errorArgs = ['mother'];
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
                        <label for="brother_no"><?php echo app('translator')->get('No. of brothers'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="brother_no"
                            id="brother_no"
                            aria-label="brother_no"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="1" <?php echo e(old('brother_no', $user->brother_no == '1') ? 'selected' : ''); ?>>1</option>
                            <option value="2" <?php echo e(old('brother_no', $user->brother_no == '2') ? 'selected' : ''); ?>>2</option>
                            <option value="3" <?php echo e(old('brother_no', $user->brother_no == '3') ? 'selected' : ''); ?>>3</option>
                            <option value="4" <?php echo e(old('brother_no', $user->brother_no == '4') ? 'selected' : ''); ?>>4</option>
                            <option value="5" <?php echo e(old('brother_no', $user->brother_no == '5') ? 'selected' : ''); ?>>5</option>
                            <option value="6" <?php echo e(old('brother_no', $user->brother_no == '6') ? 'selected' : ''); ?>>6</option>
                            <option value="7" <?php echo e(old('brother_no', $user->brother_no == '7') ? 'selected' : ''); ?>>7</option>
                            <option value="8" <?php echo e(old('brother_no', $user->brother_no == '8') ? 'selected' : ''); ?>>8</option>
                            <option value="None" <?php echo e(old('brother_no', $user->brother_no == 'None') ? 'selected' : ''); ?>><?php echo app('translator')->get('None'); ?></option>
                        </select>
                        <?php $__errorArgs = ['brother_no'];
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
                        <label for="sister_no"><?php echo app('translator')->get('No. of sisters'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="sister_no"
                            id="sister_no"
                            aria-label="sister_no"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="1" <?php echo e(old('sister_no', $user->sister_no == '1') ? 'selected' : ''); ?>>1</option>
                            <option value="2" <?php echo e(old('sister_no', $user->sister_no == '2') ? 'selected' : ''); ?>>2</option>
                            <option value="3" <?php echo e(old('sister_no', $user->sister_no == '3') ? 'selected' : ''); ?>>3</option>
                            <option value="4" <?php echo e(old('sister_no', $user->sister_no == '4') ? 'selected' : ''); ?>>4</option>
                            <option value="5" <?php echo e(old('sister_no', $user->sister_no == '5') ? 'selected' : ''); ?>>5</option>
                            <option value="6" <?php echo e(old('sister_no', $user->sister_no == '6') ? 'selected' : ''); ?>>6</option>
                            <option value="7" <?php echo e(old('sister_no', $user->sister_no == '7') ? 'selected' : ''); ?>>7</option>
                            <option value="8" <?php echo e(old('sister_no', $user->sister_no == '8') ? 'selected' : ''); ?>>8</option>
                            <option value="None" <?php echo e(old('sister_no', $user->sister_no == 'None') ? 'selected' : ''); ?>><?php echo app('translator')->get('None'); ?></option>
                        </select>
                        <?php $__errorArgs = ['sister_no'];
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

                    <div class="col-md-6 form-group" id="brother_married">
                        <label for="brother_married"><?php echo app('translator')->get('Married brothers'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="brother_married"
                            
                            aria-label="brother_married"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="1" <?php echo e(old('brother_married', $user->brother_married == '1') ? 'selected' : ''); ?>>1</option>
                            <option value="2" <?php echo e(old('brother_married', $user->brother_married == '2') ? 'selected' : ''); ?>>2</option>
                            <option value="3" <?php echo e(old('brother_married', $user->brother_married == '3') ? 'selected' : ''); ?>>3</option>
                            <option value="4" <?php echo e(old('brother_married', $user->brother_married == '4') ? 'selected' : ''); ?>>4</option>
                            <option value="5" <?php echo e(old('brother_married', $user->brother_married == '5') ? 'selected' : ''); ?>>5</option>
                            <option value="6" <?php echo e(old('brother_married', $user->brother_married == '6') ? 'selected' : ''); ?>>6</option>
                            <option value="7" <?php echo e(old('brother_married', $user->brother_married == '7') ? 'selected' : ''); ?>>7</option>
                            <option value="8" <?php echo e(old('brother_married', $user->brother_married == '8') ? 'selected' : ''); ?>>8</option>
                            <option value="None" <?php echo e(old('brother_married', $user->brother_married == 'None') ? 'selected' : ''); ?>><?php echo app('translator')->get('None'); ?></option>
                        </select>
                        <?php $__errorArgs = ['brother_married'];
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

                    <div class="col-md-6 form-group" id="sister_married">
                        <label for="sister_married"><?php echo app('translator')->get('Married sisters'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="sister_married"
                            
                            aria-label="sister_married"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="1" <?php echo e(old('sister_married', $user->sister_married == '1') ? 'selected' : ''); ?>>1</option>
                            <option value="2" <?php echo e(old('sister_married', $user->sister_married == '2') ? 'selected' : ''); ?>>2</option>
                            <option value="3" <?php echo e(old('sister_married', $user->sister_married == '3') ? 'selected' : ''); ?>>3</option>
                            <option value="4" <?php echo e(old('sister_married', $user->sister_married == '4') ? 'selected' : ''); ?>>4</option>
                            <option value="5" <?php echo e(old('sister_married', $user->sister_married == '5') ? 'selected' : ''); ?>>5</option>
                            <option value="6" <?php echo e(old('sister_married', $user->sister_married == '6') ? 'selected' : ''); ?>>6</option>
                            <option value="7" <?php echo e(old('sister_married', $user->sister_married == '7') ? 'selected' : ''); ?>>7</option>
                            <option value="8" <?php echo e(old('sister_married', $user->sister_married == '8') ? 'selected' : ''); ?>>8</option>
                            <option value="None" <?php echo e(old('sister_married', $user->sister_married == 'None') ? 'selected' : ''); ?>><?php echo app('translator')->get('None'); ?></option>
                        </select>
                        <?php $__errorArgs = ['sister_married'];
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
                        <label for="sibling_position"><?php echo app('translator')->get('No. Of Position In Siblings'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="sibling_position"
                            aria-label="sibling_position"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="1st" <?php echo e(old('sibling_position', $user->sibling_position == '1st') ? 'selected' : ''); ?>><?php echo app('translator')->get('1st'); ?></option>
                            <option value="2nd" <?php echo e(old('sibling_position', $user->sibling_position == '2nd') ? 'selected' : ''); ?>><?php echo app('translator')->get('2nd'); ?></option>
                            <option value="3rd" <?php echo e(old('sibling_position', $user->sibling_position == '3rd') ? 'selected' : ''); ?>><?php echo app('translator')->get('3rd'); ?></option>
                            <option value="4th" <?php echo e(old('sibling_position', $user->sibling_position == '4th') ? 'selected' : ''); ?>><?php echo app('translator')->get('4th'); ?></option>
                            <option value="5th" <?php echo e(old('sibling_position', $user->sibling_position == '5th') ? 'selected' : ''); ?>><?php echo app('translator')->get('5th'); ?></option>
                            <option value="6th" <?php echo e(old('sibling_position', $user->sibling_position == '6th') ? 'selected' : ''); ?>><?php echo app('translator')->get('6th'); ?></option>
                            <option value="7th" <?php echo e(old('sibling_position', $user->sibling_position == '7th') ? 'selected' : ''); ?>><?php echo app('translator')->get('7th'); ?></option>
                            <option value="8th" <?php echo e(old('sibling_position', $user->sibling_position == '8th') ? 'selected' : ''); ?>><?php echo app('translator')->get('8th'); ?></option>
                        </select>
                        <?php $__errorArgs = ['sibling_position'];
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
                        <label for="family_income"><?php echo app('translator')->get('Family Income'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="family_income"
                            aria-label="family_income"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="Below 1 lakh" <?php echo e(old('family_income', $user->family_income == 'Below 1 lakh') ? 'selected' : ''); ?>><?php echo app('translator')->get('Below 1 lakh'); ?></option>
                            <option value="1-2 lakhs" <?php echo e(old('family_income', $user->family_income == '1-2 lakhs') ? 'selected' : ''); ?>><?php echo app('translator')->get('1-2 lakhs'); ?></option>
                            <option value="3-5 lakhs" <?php echo e(old('family_income', $user->family_income == '3-5 lakhs') ? 'selected' : ''); ?>><?php echo app('translator')->get('3-5 lakhs'); ?></option>
                            <option value="5-7 lakhs" <?php echo e(old('family_income', $user->family_income == '5-7 lakhs') ? 'selected' : ''); ?>><?php echo app('translator')->get('5-7 lakhs'); ?></option>
                            <option value="7-10 lakhs" <?php echo e(old('family_income', $user->family_income == '7-10 lakhs') ? 'selected' : ''); ?>><?php echo app('translator')->get('7-10 lakhs'); ?></option>
                            <option value="10-15 lakhs" <?php echo e(old('family_income', $user->family_income == '10-15 lakhs') ? 'selected' : ''); ?>><?php echo app('translator')->get('10-15 lakhs'); ?></option>
                            <option value="15-20 lakhs" <?php echo e(old('family_income', $user->family_income == '15-20 lakhs') ? 'selected' : ''); ?>><?php echo app('translator')->get('15-20 lakhs'); ?></option>
                            <option value="20-30 lakhs" <?php echo e(old('family_income', $user->family_income == '20-30 lakhs') ? 'selected' : ''); ?>><?php echo app('translator')->get('20-30 lakhs'); ?></option>
							<option value="30-50 lakhs" <?php echo e(old('family_income', $user->family_income == '30-50 lakhs') ? 'selected' : ''); ?>><?php echo app('translator')->get('30-50 lakhs'); ?></option>
							<option value="50-70 lakhs" <?php echo e(old('family_income', $user->family_income == '50-70 lakhs') ? 'selected' : ''); ?>><?php echo app('translator')->get('50-70 lakhs'); ?></option>
							<option value="70 lakhs - 1 Cr" <?php echo e(old('family_income', $user->family_income == '70 lakhs - 1 Cr') ? 'selected' : ''); ?>><?php echo app('translator')->get('70 lakhs - 1 Cr'); ?></option>
							<option value="Above 1 Cr" <?php echo e(old('family_income', $user->family_income == 'Above 1 Cr') ? 'selected' : ''); ?>><?php echo app('translator')->get('Above 1 Cr'); ?></option>
							
							
                        </select>
                        <?php $__errorArgs = ['family_income'];
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
    $(document).ready(function () {
       
        function validateDateOfBirth() {
            
        }

       

        // Check when dropdown value changes
        $(document).on('change', '#brother_no', function () {
            var idx = this.selectedIndex;
            //alert(idx);
            if(idx == 9){
                $('#brother_married').hide();
            } else {
                $('#brother_married').show();
            }
            
           
        });

         // Validate date of birth on change
        $(document).on('change', '#sister_no', function () {
            var idx = this.selectedIndex;
            //alert(idx);
            if(idx == 9){
                $('#sister_married').hide();
            } else {
                $('#sister_married').show();
            }
        });
    });
</script>

<?php $__env->stopPush(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/family-information.blade.php ENDPATH**/ ?>