
<!--------------Physical Attributes----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="physicalAttributes">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsePhysicalAttributes"
            aria-expanded="false"
            aria-controls="collapsePhysicalAttributes"
        >
            <i class="fas fa-child"></i>
            <?php echo app('translator')->get('Physical Attributes'); ?>
        </button>
    </h5>
    <div
        id="collapsePhysicalAttributes"
        class="accordion-collapse collapse <?php if($errors->has('physicalAttributes') || session()->get('name') == 'physicalAttributes'): ?> show <?php endif; ?>"
        aria-labelledby="physicalAttributes"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="<?php echo e(route('user.physicalAttributes')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row g-3 g-md-4">

                <div class="col-md-6 form-group">
                        <label for="height"><?php echo app('translator')->get('Height (Feet and Inches)'); ?></label> <span class="text-danger">*</span>
                        <select class="form-select" name="height" aria-label="height">
                            <option value="" disabled selected><?php echo app('translator')->get('Select Height'); ?></option>
							<?php for($ft = 4; $ft <= 7; $ft++): ?>
								<?php for($in = 0; $in < 12; $in++): ?>
									<?php if($ft == 4 && $in < 5): ?> <?php continue; ?> <?php endif; ?>
									<?php if($ft == 7 && $in > 0): ?> <?php break; ?> <?php endif; ?>
									<?php
										$heightInCm = round(($ft * 30.48) + ($in * 2.54));
										$heightString = $ft . 'ft ' . $in . 'in (' . $heightInCm . ' cm)';
									?>
									<option value="<?php echo e($ft . 'ft ' . $in . 'in'); ?>" <?php echo e($user->height == ($ft . 'ft ' . $in . 'in') ? 'selected' : ''); ?>>
										<?php echo e($heightString); ?>

									</option>
								<?php endfor; ?>
							<?php endfor; ?>
                        </select>
                        <?php if($errors->has('height')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('height')); ?> </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group" style="display:none;">
                        <label for="weight"><?php echo app('translator')->get('Weight (In Kg)'); ?></label> <span class="text-danger">*</span>
                        <input
                            type="number"
                            class="form-control"
                            step=".1"
                            name="weight"
                            value="<?php echo e(old('weight') ?? $user->weight); ?>"
                            placeholder="<?php echo app('translator')->get('Enter Weight (In Kg)'); ?>"
                        />
                        <?php if($errors->has('weight')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('weight')); ?> </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group" style="display:none;">
                        <label for="eyeColor"><?php echo app('translator')->get('Eye Color'); ?></label>
                        <select
                            class="form-select"
                            name="eyeColor"
                            aria-label="eyeColor"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select Eye Color'); ?></option>
                            <option value="Brown" <?php echo e($user->eyeColor == 'Brown' ? 'selected' : ''); ?>><?php echo app('translator')->get('Brown'); ?></option>
                            <option value="Hazel" <?php echo e($user->eyeColor == 'Hazel' ? 'selected' : ''); ?>><?php echo app('translator')->get('Hazel'); ?></option>
                            <option value="Blue" <?php echo e($user->eyeColor == 'Blue' ? 'selected' : ''); ?>><?php echo app('translator')->get('Blue'); ?></option>
                            <option value="Green" <?php echo e($user->eyeColor == 'Green' ? 'selected' : ''); ?>><?php echo app('translator')->get('Green'); ?></option>
                            <option value="Gray" <?php echo e($user->eyeColor == 'Gray' ? 'selected' : ''); ?>><?php echo app('translator')->get('Gray'); ?></option>
                            <option value="Amber" <?php echo e($user->eyeColor == 'Amber' ? 'selected' : ''); ?>><?php echo app('translator')->get('Amber'); ?></option>
                        </select>
                        <?php if($errors->has('eyeColor')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('eyeColor')); ?> </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group" style="display:none;">
                        <label for="hairColor"><?php echo app('translator')->get('Hair Color'); ?></label> <span class="text-danger">*</span>
                        <select
                            name="hairColor"
                            class="form-select"
                            aria-label="hair Color"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $hairColor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->hair_color_id); ?>" <?php echo e(($user->hairColor == $data->hair_color_id) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['hairColor'];
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

                    <div class="col-md-6 form-group" >
                        <label for="complexion"><?php echo app('translator')->get('Complexion'); ?></label> <span class="text-danger">*</span>
                        <select
                            name="complexion"
                            class="form-select"
                            aria-label="complexion"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $complexion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->complexion_id); ?>" <?php echo e(($user->complexion == $data->complexion_id) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['complexion'];
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
                        <label for="bloodGroup"><?php echo app('translator')->get('Blood Group'); ?></label>
                        <select
                            class="form-select"
                            name="bloodGroup"
                            aria-label="bloodGroup"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = config('bloodgroup'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php if($key == old('bloodGroup',$user->bloodGroup )): ?> selected <?php endif; ?>><?php echo e($item); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['bloodGroup'];
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


                    <div class="col-md-6 form-group" >
                        <label for="body_type"><?php echo app('translator')->get('Body Type'); ?></label> <span class="text-danger">*</span>
                        <select
                            name="body_type"
                            class="form-select"
                            aria-label="body_type"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $bodyType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->body_types_id); ?>" <?php echo e(($user->body_type == $data->body_types_id) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['body_type'];
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

                    <div class="col-md-6 form-group" style="display:none;">
                        <label for="body_art"><?php echo app('translator')->get('Body Art'); ?></label> <span class="text-danger">*</span>
                        <select
                            name="body_art"
                            class="form-select"
                            aria-label="body_art"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $bodyArt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->body_art_id); ?>" <?php echo e(($user->body_art == $data->body_art_id) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['body_art'];
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
                        <label for="disability"><?php echo app('translator')->get('Disability'); ?></label> <span class="text-danger">*</span>
						<select
                            name="disability"
                            class="form-select"
                            aria-label="body_art"
                        >
						<option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
						<option value="Nothing" <?php echo e(( $user->disability == "Nothing") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Nothing'); ?></option>
						<option value="Visual Impairment" <?php echo e(( $user->disability == "Visual Impairment") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Visual Impairment'); ?></option>
						<option value="Deaf-Blindness" <?php echo e(( $user->disability == "Deaf-Blindness") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Deaf-Blindness'); ?></option>
						<option value="Hearing Impairment" <?php echo e(( $user->disability == "Hearing Impairment") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Hearing Impairment'); ?></option>
						<option value="Speech and Language Disability" <?php echo e(($user->disability == "Speech and Language Disability") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Speech and Language Disability'); ?></option>
						<option value="Locomotor Disability" <?php echo e(( $user->disability == "Locomotor Disability") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Locomotor Disability'); ?></option>
						<option value="Leprosy-Cured Persons" <?php echo e(( $user->disability == "Leprosy-Cured Persons") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Leprosy-Cured Persons'); ?></option>
						<option value="Cerebral Palsy" <?php echo e(( $user->disability == "Cerebral Palsy") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Cerebral Palsy'); ?></option>
						<option value="Dwarfism" <?php echo e(( $user->disability == "Dwarfism") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Dwarfism'); ?></option>
						<option value="Muscular Dystrophy" <?php echo e(( $user->disability == "Muscular Dystrophy") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Muscular Dystrophy'); ?></option>
						<option value="Acid Attack Victims" <?php echo e(( $user->disability == "Acid Attack Victims") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Acid Attack Victims'); ?></option>
						<option value="Specific Learning Disabilities" <?php echo e(( $user->disability == "Specific Learning Disabilities") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Specific Learning Disabilities'); ?></option>
						<option value="Intellectual Disability" <?php echo e(( $user->disability == "Intellectual Disability") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Intellectual Disability'); ?></option>
						<option value="Autism Spectrum Disorder" <?php echo e(( $user->disability == "Autism Spectrum Disorder") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Autism Spectrum Disorder'); ?></option>
						<option value="Mental Illness" <?php echo e(( $user->disability == "Mental Illness") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Mental Illness'); ?></option>
						<option value="Multiple Sclerosis" <?php echo e(( $user->disability == "Multiple Sclerosis") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Multiple Sclerosis'); ?></option>
						<option value="Parkinson’s Disease" <?php echo e(( $user->disability == "Parkinson’s Disease") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Parkinson’s Disease'); ?></option>
						<option value="Hemophilia" <?php echo e(( $user->disability == "Hemophilia") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Hemophilia'); ?></option>
						<option value="Thalassemia" <?php echo e(( $user->disability == "Thalassemia") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Thalassemia'); ?></option>
						<option value="Sickle Cell Disease" <?php echo e(( $user->disability == "Sickle Cell Disease") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Sickle Cell Disease'); ?></option>
						<option value="Multiple Disabilities" <?php echo e(( $user->disability == "Multiple Disabilities") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Multiple Disabilities'); ?></option>
						<option value="Chronic Kidney Disease" <?php echo e(( $user->disability == "Chronic Kidney Disease") ? 'selected' : ''); ?> ><?php echo app('translator')->get('Chronic Kidney Disease'); ?></option>
						
						</select>
                       
                        <?php if($errors->has('disability')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('disability')); ?> </div>
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

<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/physical-attributes.blade.php ENDPATH**/ ?>