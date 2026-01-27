<!--------------Partner Expectation----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="partnerExpectation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsePartnerExpectation"
            aria-expanded="false"
            aria-controls="collapsePartnerExpectation"
        >
            <i class="fas fa-handshake"></i>
            <?php echo app('translator')->get('Partner Expectation'); ?>
        </button>
    </h5>

    <div
        id="collapsePartnerExpectation"
        class="accordion-collapse collapse <?php if($errors->has('partnerExpectation') || session()->get('name') == 'partnerExpectation'): ?> show <?php endif; ?>"
        aria-labelledby="partnerExpectation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="<?php echo e(route('user.partnerExpectation')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="partner_general_requirement"><?php echo app('translator')->get('General Requirement'); ?></label> <span
                            class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="partner_general_requirement"
                            value="<?php echo e(old('partner_general_requirement') ?? $user->partner_general_requirement); ?>"
                            placeholder="<?php echo app('translator')->get('General Requirement'); ?>"
                        />
                        <?php if($errors->has('partner_general_requirement')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('partner_general_requirement')); ?> </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_residence_country"><?php echo app('translator')->get('Residence Country'); ?></label> <span
                            class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="partner_residence_country"
                            aria-label="partner_residence_country"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select Residence Country'); ?></option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($data->id); ?>" <?php echo e($user->partner_residence_country == $data->id ? 'selected' : ''); ?>><?php echo e($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['partner_residence_country'];
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
                        <label for="partner_min_height"><?php echo app('translator')->get('Min Height (In Feet)'); ?></label> <span class="text-danger">*</span>
                        <!--<input
                            type="text"
                            class="form-control"
                            name="partner_min_height"
                            value="<?php echo e(old('partner_min_height') ?? $user->partner_min_height); ?>"
                            placeholder="<?php echo app('translator')->get('Min Height (In Feet)'); ?>"
                        /> -->

                        <select class="form-select" name="partner_min_height" aria-label="partner_min_height">
							<option value="" disabled selected><?php echo app('translator')->get('Select Height'); ?></option>
							<?php for($ft = 4; $ft <= 7; $ft++): ?>
								<?php for($in = 0; $in < 12; $in++): ?>
									<?php if($ft == 4 && $in < 5): ?> <?php continue; ?> <?php endif; ?>
									<?php if($ft == 7 && $in > 0): ?> <?php break; ?> <?php endif; ?>
									<?php
										$heightInCm = round(($ft * 30.48) + ($in * 2.54));
										$heightString = $ft . 'ft ' . $in . 'in (' . $heightInCm . ' cm)';
									?>
									<option value="<?php echo e($ft . 'ft ' . $in . 'in'); ?>" <?php echo e($user->partner_min_height == ($ft . 'ft ' . $in . 'in') ? 'selected' : ''); ?>>
										<?php echo e($heightString); ?>

									</option>
								<?php endfor; ?>
							<?php endfor; ?>
						</select>
                        <?php if($errors->has('partner_min_height')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('partner_min_height')); ?> </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_max_weight"><?php echo app('translator')->get('Max Height (In Feet)'); ?></label> <span
                            class="text-danger">*</span>
                        <!-- <input
                            type="text"
                            class="form-control"
                            name="partner_max_weight"
                            value="<?php echo e(old('partner_max_weight') ?? $user->partner_max_weight); ?>"
                            placeholder="<?php echo app('translator')->get('Max Weight (In Kg)'); ?>"
                        /> -->
						<select class="form-select" name="partner_max_weight" aria-label="partner_max_weight">
							<option value="" disabled selected><?php echo app('translator')->get('Select Height'); ?></option>
							<?php for($ft = 4; $ft <= 7; $ft++): ?>
								<?php for($in = 0; $in < 12; $in++): ?>
									<?php if($ft == 4 && $in < 5): ?> <?php continue; ?> <?php endif; ?>
									<?php if($ft == 7 && $in > 0): ?> <?php break; ?> <?php endif; ?>
									<?php
										$heightInCm = round(($ft * 30.48) + ($in * 2.54));
										$heightString = $ft . 'ft ' . $in . 'in (' . $heightInCm . ' cm)';
									?>
									<option value="<?php echo e($ft . 'ft ' . $in . 'in'); ?>" <?php echo e($user->partner_max_weight == ($ft . 'ft ' . $in . 'in') ? 'selected' : ''); ?>>
										<?php echo e($heightString); ?>

									</option>
								<?php endfor; ?>
							<?php endfor; ?>
						</select>
                       <!-- <select class="form-select" name="partner_max_weight" aria-label="partner_max_weight">
                            <option value="" disabled selected><?php echo app('translator')->get('Select Weight'); ?></option>
                            <?php for($ft = 40; $ft <= 100; $ft++): ?>
									
                                    <option value="<?php echo e($ft . ' kg'); ?>" <?php echo e($user->partner_max_weight == ($ft . ' kg' ) ? 'selected' : ''); ?> >
                                        <?php echo e($ft . ' kg'); ?>

                                    </option>
                            <?php endfor; ?>
                        </select> -->
                        <?php if($errors->has('partner_max_weight')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('partner_max_weight')); ?> </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group" style="display:none;">
                        <label for="partner_gender"><?php echo app('translator')->get('gender'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="partner_gender[]"
                            multiple
                            data-live-search="true"
                            aria-label="partner_gender"
                        >
                            <?php
                                $array_of_partnerGender = json_decode($user->partner_gender);
                            ?>

                            <option value="Male"
                                <?php if(is_array($array_of_partnerGender)): ?>
                                    <?php if((in_array('Male',$array_of_partnerGender))): ?>
                                        selected
                                    <?php endif; ?>
                                <?php endif; ?>
                            >
                                <?php echo app('translator')->get('Male'); ?>
                            </option>
                            <option value="Female"
                                <?php if(is_array($array_of_partnerGender)): ?>
                                    <?php if((in_array('Female',$array_of_partnerGender))): ?>
                                        selected
                                    <?php endif; ?>
                                <?php endif; ?>
                            >
                                <?php echo app('translator')->get('Female'); ?>
                            </option>
                        </select>
                        <?php $__errorArgs = ['partner_gender'];
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
                        <label for="partner_marital_status"><?php echo app('translator')->get('Marital Status'); ?></label> <span
                            class="text-danger">*</span>
                        <select
							id="partner_marital_status"
                            name="partner_marital_status"
                            class="form-select"
                            aria-label="Maritial status"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $maritalStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($data->marital_status_id); ?>" <?php echo e($user->partner_marital_status == $data->marital_status_id ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['partner_marital_status'];
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
					
                            
                      <?php if($user->partner_marital_status != '5'): ?>  
                    <div class="col-md-6 form-group" id="partner_children_container">
                        <label for="partner_children_acceptancy"><?php echo app('translator')->get('Children Acceptancy'); ?></label> <span
                            class="text-danger"></span>
                        <select
                            class="form-select"
                            name="partner_children_acceptancy"
							id = "partner_children_acceptancy"
                            aria-label="partner_children_acceptancy"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option
                                value="Yes" <?php echo e(old('partner_children_acceptancy', $user->partner_children_acceptancy == 'Yes') ? 'selected' : ''); ?>><?php echo app('translator')->get('Yes'); ?></option>
                            <option
                                value="No" <?php echo e(old('partner_children_acceptancy', $user->partner_children_acceptancy == 'No') ? 'selected' : ''); ?>><?php echo app('translator')->get('No'); ?></option>
                            <option
                                value="Does Not Matter" <?php echo e(old('partner_children_acceptancy', $user->partner_children_acceptancy == 'Does Not Matter') ? 'selected' : ''); ?>><?php echo app('translator')->get('Does Not Matter'); ?></option>
                        </select>
                        <?php $__errorArgs = ['partner_children_acceptancy'];
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
                    <div class="col-md-6 form-group">
                        <label for="partner_religion"><?php echo app('translator')->get('religion'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            id="partner_religion"
                            name="partner_religion"
                            aria-label="partner_religion"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select Religion'); ?></option>
                            <?php $__currentLoopData = $religion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($data->id); ?>" <?php echo e($user->partner_religion == $data->id ? 'selected' : ''); ?>><?php echo e($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['partner_religion'];
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
                        <label for="partner_caste"><?php echo app('translator')->get('Caste'); ?></label> <span class="text-danger">*</span>
                        <select id="partner_caste" class="form-control" name='partner_caste'></select>
                        <?php $__errorArgs = ['partner_caste'];
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
                        <label for="partner_sub_caste"><?php echo app('translator')->get('Sub Caste'); ?></label>
                        <select id="partner_sub_caste" class="form-control" name="partner_sub_caste" ></select>
                        <?php $__errorArgs = ['partner_sub_caste'];
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
                        <label for="partner_language"><?php echo app('translator')->get('Language'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="partner_language"
                            aria-label="partner_language"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = config('languages')['langCodeWithoutFlagSindhi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item); ?>"
                                        <?php if($item == old('partner_language',$user->partner_language )): ?> selected <?php endif; ?>><?php echo e($item); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['partner_language'];
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
                        <label for="partner_education"><?php echo app('translator')->get('Education'); ?></label> <span class="text-danger">*</span>
                        <select class="form-control" name="partner_education" aria-label="partner_education" data-container="body">  
                            <option value="" disabled selected><?php echo app('translator')->get('Select Education'); ?></option>
							<option value="Below 10th" <?php echo e((old('degree') ?? $user->degree) == 'Below 10th' ? 'selected' : ''); ?>>Below 10th</option>
                            <option value="High School (10th)" <?php echo e($user->partner_education == 'High School (10th)' ? 'selected' : ''); ?>>High School (10th)</option>
                            <option value="Intermediate (12th)" <?php echo e($user->partner_education == 'Intermediate (12th)' ? 'selected' : ''); ?>>Intermediate (12th)</option>
                            <option value="Diploma" <?php echo e($user->partner_education == 'Diploma' ? 'selected' : ''); ?>>Diploma</option>
                            <option value="Bachelor's Degree" <?php echo e($user->partner_education == "Bachelor's Degree" ? 'selected' : ''); ?>>Bachelor's Degree</option>
                            <option value="Master's Degree" <?php echo e($user->partner_education == "Master's Degree" ? 'selected' : ''); ?>>Master's Degree</option>
                            <option value="Doctorate (PhD)" <?php echo e($user->partner_education == "Doctorate (PhD)" ? 'selected' : ''); ?>>Doctorate (PhD)</option>
                            <option value="Post-Doctorate" <?php echo e($user->partner_education == "Post-Doctorate" ? 'selected' : ''); ?>>Post-Doctorate</option>
                        </select>
                        <?php if($errors->has('partner_education')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('degree')); ?> </div>
                        <?php endif; ?>
                        </div>
					<!--
                    <div class="col-md-6 form-group">
                        <label for="partner_education"><?php echo app('translator')->get('Education'); ?></label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="partner_education"
                            value="<?php echo e(old('partner_education') ?? $user->partner_education); ?>"
                            placeholder="<?php echo app('translator')->get('Education'); ?>"
                        />
                        <?php if($errors->has('partner_education')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('partner_education')); ?> </div>
                        <?php endif; ?>
                    </div>
					-->
                    <div class="col-md-6 form-group d-none">
                        <label for="partner_profession"><?php echo app('translator')->get('Profession'); ?></label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="partner_profession"
                            value="<?php echo e(old('partner_profession') ?? $user->partner_profession); ?>"
                            placeholder="<?php echo app('translator')->get('Profession'); ?>"
                        />
                        <?php if($errors->has('partner_profession')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('partner_profession')); ?> </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_smoking_acceptancy"><?php echo app('translator')->get('Smoking Acceptancy'); ?></label> <span
                            class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="partner_smoking_acceptancy"
                            aria-label="partner_smoking_acceptancy"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option
                                value="Yes" <?php echo e(old('partner_smoking_acceptancy', $user->partner_smoking_acceptancy == 'Yes') ? 'selected' : ''); ?>><?php echo app('translator')->get('Yes'); ?></option>
                            <option
                                value="No" <?php echo e(old('partner_smoking_acceptancy', $user->partner_smoking_acceptancy == 'No') ? 'selected' : ''); ?>><?php echo app('translator')->get('No'); ?></option>
								 <option
                                value="Occasionally" <?php echo e(old('partner_smoking_acceptancy', $user->partner_smoking_acceptancy == 'Occasionally') ? 'selected' : ''); ?>><?php echo app('translator')->get('Occasionally'); ?></option>
                            <option
                                value="Does Not Matter" <?php echo e(old('partner_smoking_acceptancy', $user->partner_smoking_acceptancy == 'Does Not Matter') ? 'selected' : ''); ?>><?php echo app('translator')->get('Does Not Matter'); ?></option>
                        </select>
                        <?php $__errorArgs = ['partner_smoking_acceptancy'];
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
                        <label for="partner_drinking_acceptancy"><?php echo app('translator')->get('Drinking Acceptancy'); ?></label> <span
                            class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="partner_drinking_acceptancy"
                            aria-label="partner_drinking_acceptancy"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option
                                value="Yes" <?php echo e(old('partner_drinking_acceptancy', $user->partner_drinking_acceptancy == 'Yes') ? 'selected' : ''); ?>><?php echo app('translator')->get('Yes'); ?></option>
                            <option
                                value="No" <?php echo e(old('partner_drinking_acceptancy', $user->partner_drinking_acceptancy == 'No') ? 'selected' : ''); ?>><?php echo app('translator')->get('No'); ?></option>
								<option
                                value="Occasionally" <?php echo e(old('partner_drinking_acceptancy', $user->partner_drinking_acceptancy == 'Occasionally') ? 'selected' : ''); ?>><?php echo app('translator')->get('Occasionally'); ?></option>
                            <option
                                value="Does Not Matter" <?php echo e(old('partner_drinking_acceptancy', $user->partner_drinking_acceptancy == 'Does Not Matter') ? 'selected' : ''); ?>><?php echo app('translator')->get('Does Not Matter'); ?></option>
                        </select>
                        <?php $__errorArgs = ['partner_drinking_acceptancy'];
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
                        <label for="partner_dieting_acceptancy"><?php echo app('translator')->get('Dieting Acceptancy'); ?></label> <span
                            class="text-danger">*</span>
                        <!-- <select
                            class="form-select"
                            name="partner_dieting_acceptancy"
                            aria-label="partner_dieting_acceptancy"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option
                                value="Yes" <?php echo e(old('partner_dieting_acceptancy', $user->partner_dieting_acceptancy == 'Yes') ? 'selected' : ''); ?>><?php echo app('translator')->get('Yes'); ?></option>
                            <option
                                value="No" <?php echo e(old('partner_dieting_acceptancy', $user->partner_dieting_acceptancy == 'No') ? 'selected' : ''); ?>><?php echo app('translator')->get('No'); ?></option>
                            <option
                                value="Does Not Matter" <?php echo e(old('partner_dieting_acceptancy', $user->partner_dieting_acceptancy == 'Does Not Matter') ? 'selected' : ''); ?>><?php echo app('translator')->get('Does Not Matter'); ?></option>
                        </select> -->


                        <select
                            class="form-select"
                            name="partner_dieting_acceptancy"
                            aria-label="partner_dieting_acceptancy"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option value="Veg" <?php echo e(old('partner_dieting_acceptancy', $user->partner_dieting_acceptancy == 'Veg') ? 'selected' : ''); ?>><?php echo app('translator')->get('Veg'); ?></option>
                            <option value="Non-Veg" <?php echo e(old('partner_dieting_acceptancy', $user->partner_dieting_acceptancy == 'Non-Veg') ? 'selected' : ''); ?>><?php echo app('translator')->get('Non-Veg'); ?></option>
                            <option value="Eggitarian" <?php echo e(old('partner_dieting_acceptancy', $user->partner_dieting_acceptancy == 'Eggitarian') ? 'selected' : ''); ?>><?php echo app('translator')->get('Eggitarian'); ?></option>
                            <option value="Occasionally non-veg" <?php echo e(old('partner_dieting_acceptancy', $user->partner_dieting_acceptancy == 'Occasionally non-veg') ? 'selected' : ''); ?>><?php echo app('translator')->get('Occasionally non-veg'); ?></option>
                        </select>

                        <?php $__errorArgs = ['partner_dieting_acceptancy'];
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
                        <label for="partner_body_type"><?php echo app('translator')->get('Body Type'); ?></label> <span class="text-danger">*</span>
                        <!-- <input
                            type="text"
                            class="form-control"
                            name="partner_body_type"
                            value="<?php echo e(old('partner_body_type') ?? $user->partner_body_type); ?>"
                            placeholder="<?php echo app('translator')->get('Body Type'); ?>"
                        /> -->

                        <select
                            name="partner_body_type"
                            class="form-select"
                            aria-label="partner_body_type"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $bodyType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->body_types_id); ?>" <?php echo e(($user->partner_body_type == $data->body_types_id) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('partner_body_type')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('partner_body_type')); ?> </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group" style="display:none;">
                        <label for="partner_personal_value"><?php echo app('translator')->get('Personal Value'); ?></label> <span
                            class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="partner_personal_value"
                            value="<?php echo e(old('partner_personal_value') ?? $user->partner_personal_value); ?>"
                            placeholder="<?php echo app('translator')->get('Personal Value'); ?>"
                        />
                        <?php if($errors->has('partner_personal_value')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('partner_personal_value')); ?> </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="partner_manglik"><?php echo app('translator')->get('Manglik'); ?></label>
                        <select
                            class="form-select"
                            name="partner_manglik"
                            aria-label="partner_manglik"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <option
                                value="Yes" <?php echo e(old('partner_manglik', $user->partner_manglik == 'Yes') ? 'selected' : ''); ?>><?php echo app('translator')->get('Yes'); ?></option>
                            <option
                                value="No" <?php echo e(old('partner_manglik', $user->partner_manglik == 'No') ? 'selected' : ''); ?>><?php echo app('translator')->get('No'); ?></option>
                            <option
                                value="Does Not Matter" <?php echo e(old('partner_manglik', $user->partner_manglik == 'Does Not Matter') ? 'selected' : ''); ?>><?php echo app('translator')->get('Does Not Matter'); ?></option>
                        </select>
                        <?php $__errorArgs = ['partner_manglik'];
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
                        <label for="partner_preferred_country"><?php echo app('translator')->get('Permanent Country'); ?></label> <span
                            class="text-danger">*</span>
                        <select
                            class="form-select"
                            id="partner-country"
                            name="partner_preferred_country"
                            aria-label="partner_preferred_country"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select Country'); ?></option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($data->id); ?>" <?php echo e(old('partner_preferred_country',$user->partner_preferred_country == $data->id) ? 'selected' : ''); ?>><?php echo e($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['partner_preferred_country'];
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

                    <div class="col-md-6 form-group d-none">
                        <label for="partner_preferred_state"><?php echo app('translator')->get('state'); ?></label> <span class="text-danger">*</span>
                        <select id="partner-state" class="form-control" name='partner_preferred_state'></select>
                        <?php $__errorArgs = ['partner_preferred_state'];
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

                    <div class="col-md-6 form-group d-none">
                        <label for="partner_preferred_city"><?php echo app('translator')->get('city'); ?></label> <span class="text-danger">*</span>
                        <select id="partner-city" class="form-control" name="partner_preferred_city"></select>
                        <?php $__errorArgs = ['partner_preferred_city'];
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
                        <label for="partner_family_value"><?php echo app('translator')->get('Family Value'); ?></label> <span
                            class="text-danger">*</span>
                        <select
                            name="partner_family_value"
                            class="form-select"
                            aria-label="partner_family_value"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $familyValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($data->family_values_id); ?>" <?php echo e(($user->partner_family_value == $data->family_values_id) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['partner_family_value'];
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
                        <label for="partner_complexion"><?php echo app('translator')->get('Complexion'); ?></label> <span class="text-danger">*</span>
						
						 <select
                            name="partner_complexion"
                            class="form-select"
                            aria-label="partner_complexion"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $complexion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->complexion_id); ?>" <?php echo e(($user->partner_complexion == $data->complexion_id) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
						
                        <!-- <input
                            type="text"
                            class="form-control"
                            name="partner_complexion"
                            value="<?php echo e(old('partner_complexion') ?? $user->partner_complexion); ?>"
                            placeholder="<?php echo app('translator')->get('Ex: Fair skin, always burns, sometimes tans'); ?>"
                        /> -->
                        <?php if($errors->has('partner_complexion')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('partner_complexion')); ?> </div>
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


<?php $__env->startPush('script'); ?>
    <script defer>

        //---- for religion-caste-subcaste dependency dropdown -----
        var idGetReligion = $("#partner_religion").val();
        var getSelectedCaste = "<?php echo e($user->partner_caste??null); ?>"
        var getSelectedSubCaste = "<?php echo e($user->partner_sub_caste ?? null); ?>";
        //---- for country-state-city dependency dropdown -----
        var idPartnerCountry = $("#partner-country").val();
        var selectedPartnerState = "<?php echo e($user->partner_preferred_state??null); ?>"
        var selectedPartnerCity = "<?php echo e($user->partner_preferred_city??null); ?>"

        getAllPartnerCaste(idGetReligion, getSelectedCaste);
        getAllPartnerSubCaste(getSelectedCaste, getSelectedSubCaste);


        getPartnerStates(idPartnerCountry, selectedPartnerState);
        getPartnerCities(selectedPartnerState, selectedPartnerCity);
		
		$(document).on('change', '#partner_marital_status', function () {
            var idChildAcc = this.value;
			if(idChildAcc == '5')
				$('#partner_children_container').css('visibility', 'hidden');
			else
				$('#partner_children_container').css('visibility', 'visible');
        });

        $(document).on('change', '#partner_religion', function () {
            var idGetReligion = this.value;
            $("#partner_caste").html('');
            getAllPartnerCaste(idGetReligion);
        });

        $(document).on('change', '#partner_caste', function () {
            var idGetCaste = this.value;
            $("#partner_sub_caste").html('');
            getAllPartnerSubCaste(idGetCaste,getSelectedSubCaste)
        });


        $(document).on('change', '#partner-country', function () {
            var idPartnerCountry = this.value;
            $("#partner-state").html('');
            getPartnerStates(idPartnerCountry);
        });

        $(document).on('change', '#partner-state', function () {
            var idPartnerState = this.value;
            $("#partner-city").html('');
            getPartnerCities(idPartnerState)
        });


        function getAllPartnerCaste(idGetReligion = null, getSelectedCaste = null) {
            $.ajax({
                url: "<?php echo e(route('user.getCaste')); ?>",
                type: "POST",
                data: {
                    religion_id: idGetReligion,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                dataType: 'json',
                success: function (result) {
                    $('#partner_caste').html('<option value="" disabled><?php echo app('translator')->get("Select Caste"); ?></option>');
                    $.each(result.caste, function (key, value) {
						//alert(value.name);
                        $("#partner_caste").append(`<option value="${value.id}" ${(value.id == getSelectedCaste) ? 'selected' : ''}> ${value.name} </option>`);
                    });
                    $('#partner_sub_caste').html('<option value=""><?php echo app('translator')->get("Select Sub-Caste"); ?></option>');
                }
            });
        }

        function getAllPartnerSubCaste(idGetCaste = null, getSelectedSubCaste = null) {
			
            $.ajax({
                url: "<?php echo e(route('user.getSubCaste')); ?>",
                type: "POST",
                data: {
                    caste_id: idGetCaste,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                dataType: 'json',
                success: function (res) {
					
					
					// Decoding the HTML entities
					//const decodedStr = getSelectedSubCaste.replace(/&quot;/g, '"');
					//if(decodedStr){
					//	var array = JSON.parse(decodedStr);
					//}else{
					//var array = JSON.parse("[]"); }
					//console.log(array);
                    $.each(res.subCaste, function (key, value) {
						console.log(value.id+"-"+array.includes(value.id));
                        $("#partner_sub_caste").append(`<option value="${value.id}" ${(value.id == getSelectedSubCaste) ? 'selected' : ''}> ${value.name} </option>`);
                    });
                }
            });
        }

        function getPartnerStates(idPartnerCountry = null, selectedPartnerState = null) {
            $.ajax({
                url: "<?php echo e(route('user.states')); ?>",
                type: "POST",
                data: {
                    country_id: idPartnerCountry,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                dataType: 'json',
                success: function (result) {
                    $('#partner-state').html('<option value=""><?php echo app('translator')->get("Select State"); ?></option>');
                    $.each(result.states, function (key, value) {
                        $("#partner-state").append(`<option value="${value.id}" ${(value.id == selectedPartnerState) ? 'selected' : ''}>${value.name}</option>`);
                    });
                    $('#partner-city').html('<option value=""><?php echo app('translator')->get("Select City"); ?></option>');
                }
            });
        }

        function getPartnerCities(idPartnerState = null, selectedPartnerCity = null) {
            $.ajax({
                url: "<?php echo e(route('user.cities')); ?>",
                type: "POST",
                data: {
                    state_id: idPartnerState,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                dataType: 'json',
                success: function (res) {
                    $('#partner-city').html('<option value=""><?php echo app('translator')->get("Select City"); ?></option>');
                    $.each(res.cities, function (key, value) {
                        $("#partner-city").append(`<option value="${value.id}" ${(value.id == selectedPartnerCity) ? 'selected' : ''}>${value.name}</option>`);
                    });
                }
            });
        }

    </script>
<?php $__env->stopPush(); ?>

<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/partner-expectation.blade.php ENDPATH**/ ?>