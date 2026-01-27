<!--------------Basic Information----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="basicInformation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseBasicInformation"
            aria-expanded="false"
            aria-controls="collapseBasicInformation"
        >
            <i class="fas fa-info-circle"></i>
            <?php echo app('translator')->get('Basic Information'); ?>
        </button>
    </h5>

    <div
        id="collapseBasicInformation"
        class="accordion-collapse collapse <?php if($errors->has('basicInfo') || session()->get('name') == 'basicInfo'): ?> show <?php endif; ?>"
        aria-labelledby="basicInformation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="<?php echo e(route('user.updateInformation')); ?>" method="post" enctype="multipart/form-data">
                <?php echo method_field('put'); ?>
                <?php echo csrf_field(); ?>
                <div class="row g-3 g-md-4">
                    <div class="col-md-6 form-group">
                        <label for="firstname"><?php echo app('translator')->get('First name'); ?></label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="firstname"
                            value="<?php echo e(old('firstname') ?? $user->firstname); ?>" readonly
                            placeholder="<?php echo app('translator')->get('Enter First Name'); ?>"
                        />
                        <?php if($errors->has('firstname')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('firstname')); ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="lastname"><?php echo app('translator')->get('last name'); ?></label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="lastname"
                            value="<?php echo e(old('lastname') ?? $user->lastname); ?>" readonly
                            placeholder="<?php echo app('translator')->get('Enter Last Name'); ?>"
                        />
                        <?php if($errors->has('lastname')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('lastname')); ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="username"><?php echo app('translator')->get('Username'); ?></label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="username"
                            value="<?php echo e(old('username') ?? $user->username); ?>" readonly
                            placeholder="<?php echo app('translator')->get('Username'); ?>"
                        />
                        <?php if($errors->has('username')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('username')); ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="email"><?php echo app('translator')->get('Email Address'); ?></label> <span class="text-danger">*</span>
                        <input
                            type="email"
                            class="form-control"
                            value="<?php echo e($user->email); ?>" readonly
                            placeholder="Ryan"
                        />
                        <?php if($errors->has('email')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('email')); ?> </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="phone"><?php echo app('translator')->get('Phone Number'); ?></label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            readonly
                            value="<?php echo e($user->phone); ?>"
                            class="form-control"
                            placeholder="<?php echo app('translator')->get('Enter Phone Number'); ?>"
                        />
                        <?php if($errors->has('phone')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('phone')); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="gender"><?php echo app('translator')->get('gender'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="gender"
                            aria-label="gender"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select Gender'); ?></option>
                            <option value="Male" <?php echo e($user->gender == 'Male' ? 'selected' : ''); ?>><?php echo app('translator')->get('Male'); ?></option>
                            <option value="Female" <?php echo e($user->gender == 'Female' ? 'selected' : ''); ?>><?php echo app('translator')->get('Female'); ?></option>
                        </select>
                        <?php $__errorArgs = ['gender'];
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
                        <label for="date_of_birth"><?php echo app('translator')->get('Date of birth'); ?></label> <span class="text-danger">*</span>
                        <input type="date" class="form-control" name="date_of_birth" id="date_of_birth"
                               value="<?php echo e(old('date_of_birth') ?? $user->date_of_birth); ?>"/>
                        <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo app('translator')->get($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div id="dob_error" class="text-danger" style="display: none;">You must be at least 18 years old.</div>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="on_behalf"><?php echo app('translator')->get('On Behalf'); ?></label> <span class="text-danger">*</span>
                        <select
                            name="on_behalf"
                            class="form-select"
                            aria-label="on behalf"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $onBehalf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->on_behalf_id); ?>" <?php echo e(($user->on_behalf == $data->on_behalf_id) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['on_behalf'];
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
                        <label for="marital_status"><?php echo app('translator')->get('Marital Status'); ?></label> <span class="text-danger">*</span>
                        <select
                            id="marital_status"
                            name="marital_status"
                            class="form-select"
                            aria-label="Maritial Status"
                        >
                            <option value="" disabled selected><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $maritalStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->marital_status_id); ?>" <?php echo e($user->marital_status == $data->marital_status_id ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['marital_status'];
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
					
					<?php if($user->marital_status != '5'): ?> 
                    <div class="col-md-6 form-group"  id="children_container">
                        <label for="no_of_children"><?php echo app('translator')->get('Number Of Children'); ?></label>
                        <input
                            type="number"
                            name="no_of_children"
                            value="<?php echo e(old('no_of_children') ?? $user->no_of_children); ?>"
                            class="form-control"
                            placeholder="<?php echo app('translator')->get('Enter no of children'); ?>"
                        />
                        <?php $__errorArgs = ['no_of_children'];
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

                    
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label><?php echo app('translator')->get('Preferred language for discussion'); ?></label>

                            <select name="language_id" id="language_id" class="form-control">
                                <option value="" disabled><?php echo app('translator')->get('Select Language'); ?></option>
                                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $la): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($la->id); ?>"
                                        <?php echo e(old('language_id', $user->language_id) == $la->id ? 'selected' : ''); ?>><?php echo app('translator')->get($la->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <?php if($errors->has('language_id')): ?>
                                <div
                                    class="error text-danger"><?php echo app('translator')->get($errors->first('language_id')); ?> </div>
                            <?php endif; ?>
                        </div>
                    </div>
					
					<div class="col-md-6 form-group">
                        <label for="image"><?php echo app('translator')->get('Profile Image'); ?></label> <span class="text-danger">*</span>
                        <div class="image-input ">
                            <label for="image-upload" id="image-label"><i
                                    class="fas fa-upload"></i></label>
                            <input type="file" name="image" placeholder="<?php echo app('translator')->get('Choose image'); ?>" id="image">
                            <img class="w-100 preview-image" id="image_preview_container" style="max-width: 200px"
                                 src="<?php echo e(getFile(config('location.user.path').$user->image)); ?>"
                                 alt="<?php echo app('translator')->get('user image'); ?>">
                        </div>
                        <?php $__errorArgs = ['image'];
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
                        <label for="aadhar"><?php echo app('translator')->get('Aadhar Image'); ?></label> <span class="text-danger">*</span>
                        <div class="image-input ">
                            <label for="aadhar-upload" id="aadhar-label"><i
                                    class="fas fa-upload"></i></label>
                            <input type="file" name="aadhar" placeholder="<?php echo app('translator')->get('Choose aadhar'); ?>" id="aadhar">
                            <img class="w-100 preview-image" id="aadhar_preview_container" style="max-width: 200px"
                                 src="<?php echo e(getFile(config('location.kyc.path').$user->aadhar)); ?>"
                                 alt="<?php echo app('translator')->get('user aadhar'); ?>">
                        </div>
                        <?php $__errorArgs = ['aadhar'];
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
                        <label for="pan"><?php echo app('translator')->get('PAN Image'); ?></label> <span class="text-danger">*</span>
                        <div class="image-input ">
                            <label for="pan-upload" id="pan-label"><i
                                    class="fas fa-upload"></i></label>
                            <input type="file" name="pan" placeholder="<?php echo app('translator')->get('Choose pan'); ?>" id="pan">
                            <img class="w-100 preview-image" id="pan_preview_container" style="max-width: 200px"
                                 src="<?php echo e(getFile(config('location.kyc.path').$user->pan)); ?>"
                                 alt="<?php echo app('translator')->get('user pan'); ?>">
                        </div>
                        <?php $__errorArgs = ['pan'];
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
        function toggleChildrenInput(index) {

            var e = document.getElementById("marital_status");
            var selectedMaritalStatus = e.options[index].text;
           // alert(selectedMaritalStatus);
           
            //var selectedMaritalStatus = $('#marital_status').find('option:selected').text().trim();
            if (selectedMaritalStatus === 'Never Married') {
                $('#children_container').css('visibility', 'hidden');
            } else {
                $('#children_container').css('visibility', 'visible');
            }
        }

        function validateDateOfBirth() {
            var dob = new Date($('#date_of_birth').val());
            var today = new Date();
            var age = today.getFullYear() - dob.getFullYear();
            var m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            if (age < 18) {
                $('#dob_error').show();
                return false;
            } else {
                $('#dob_error').hide();
                return true;
            }
        }

        function setMaxDateOfBirth() {
            var today = new Date();
            var maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
            var maxDateString = maxDate.toISOString().split('T')[0];
            $('#date_of_birth').attr('max', maxDateString);
        }

        // Initial check on page load
        validateDateOfBirth();
        // Initial check on page load
        toggleChildrenInput(0);
        setMaxDateOfBirth();

        // Check when dropdown value changes
        $(document).on('change', '#marital_status', function () {
            var idx = this.selectedIndex;
            
            $("select#selected").prop('selectedIndex', idx); 
            //alert(e.options[idx].text);
            toggleChildrenInput(idx);
        });

         // Validate date of birth on change
        $(document).on('change', '#date_of_birth', function () {
            validateDateOfBirth();
        });

        $(document).on('click', '#image-label', function () {
            $('#image').trigger('click');
        });

        $(document).on('change', '#image', function () {
            var _this = $(this);
            var newimage = new FileReader();
            newimage.readAsDataURL(this.files[0]);
            newimage.onload = function (e) {
                $('#image_preview_container').attr('src', e.target.result);
            }
        });
    });
</script>

<?php $__env->stopPush(); ?>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/basic-info.blade.php ENDPATH**/ ?>