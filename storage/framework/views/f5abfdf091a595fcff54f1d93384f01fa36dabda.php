
<!-------------- Spiritual & Social Background ----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="spiritualSocialBg">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseSpiritualSocialBg"
            aria-expanded="false"
            aria-controls="collapseSpiritualSocialBg"
        >
            <i class="fas fa-place-of-worship"></i>
            <?php echo app('translator')->get('Spiritual & Social Background'); ?>
        </button>
    </h5>
    <div
        id="collapseSpiritualSocialBg"
        class="accordion-collapse collapse <?php if($errors->has('spiritualSocialBg') || session()->get('name') == 'spiritualSocialBg'): ?> show <?php endif; ?>"
        aria-labelledby="spiritualSocialBg"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="<?php echo e(route('user.spiritualSocialBg')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="religion"><?php echo app('translator')->get('religion'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            id="religion-dd"
                            name="religion"
                            aria-label="religion"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select Religion'); ?></option>
                            <?php $__currentLoopData = $religion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($data->id); ?>" <?php echo e($user->religion == $data->id ? 'selected' : ''); ?>><?php echo e($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['religion'];
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
                        <label for="caste"><?php echo app('translator')->get('Caste'); ?></label> <span class="text-danger">*</span>
                        <select id="caste-dd" class="form-control" name='caste'></select>
                        <?php $__errorArgs = ['caste'];
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

                    <div class="col-md-6 form-group"  >
                        <label for="sub_caste"><?php echo app('translator')->get('Sub Caste'); ?></label>
                        <select id="sub-caste-dd" class="form-control" name="sub_caste"></select>
                       
                        <?php $__errorArgs = ['sub_caste'];
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
                        <label for="family_value"><?php echo app('translator')->get('ethnicity'); ?></label> <span class="text-danger">*</span>
                        <select
                            name="ethnicity"
                            class="form-select"
                            aria-label="family_value"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $ethnicity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->ethnicity_id); ?>" <?php echo e(($user->ethnicity == $data->ethnicity_id) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['ethnicity'];
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
                        <label for="personal_value"><?php echo app('translator')->get('Personal Value'); ?></label> <span class="text-danger">*</span>
                        <select
                            name="personal_value"
                            class="form-select"
                            aria-label="personal_value"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $personalValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->personal_value_id); ?>" <?php echo e(($user->personal_value == $data->personal_value_id) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['personal_value'];
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
                        <label for="family_value"><?php echo app('translator')->get('Family Value'); ?></label> <span class="text-danger">*</span>
                        <select
                            name="family_value"
                            class="form-select"
                            aria-label="family_value"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $familyValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->family_values_id); ?>" <?php echo e(($user->family_value == $data->family_values_id) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['family_value'];
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
                        <label for="community_value"><?php echo app('translator')->get('Community Value'); ?></label> <span class="text-danger">*</span>
                        <select
                            name="community_value"
                            class="form-select"
                            aria-label="community_value"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select One'); ?></option>
                            <?php $__currentLoopData = $communityValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->community_value_id); ?>" <?php echo e(($user->community_value == $data->community_value_id) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['community_value'];
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

        var idReligion = $("#religion-dd").val();
        var selectedCaste = "<?php echo e($user->caste??null); ?>"
        var selectedSubCaste = "<?php echo e($user->sub_caste??null); ?>"


        getCaste(idReligion, selectedCaste);
        getSubCaste(selectedCaste, selectedSubCaste);

        $(document).on('change', '#religion-dd', function () {
            var idReligion = this.value;
            $("#caste-dd").html('');
            getCaste(idReligion);
        });

        $(document).on('change', '#caste-dd', function () {
            var idCaste = this.value;
            $("#sub-caste-dd").html('');
            getSubCaste(idCaste)
        });


        function getCaste(idReligion, selectedCaste = null) {
            $.ajax({
                url: "<?php echo e(route('user.getCaste')); ?>",
                type: "POST",
                data: {
                    religion_id: idReligion,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                dataType: 'json',
                success: function (result) {
                    $('#caste-dd').html('<option value=""><?php echo app('translator')->get("Select Caste"); ?></option>');
                    $.each(result.caste, function (key, value) {
                        $("#caste-dd").append(`<option value="${value.id}" ${(value.id == selectedCaste) ? 'selected' : ''} > ${value.name} </option>`);
                    });
                    $('#sub-caste-dd').html(`<option value=""><?php echo app('translator')->get("Select Sub-Caste"); ?></option>`);
                }
            });
        }

        function getSubCaste(idCaste = null, selectedSubCaste = null) {
            $.ajax({
                url: "<?php echo e(route('user.getSubCaste')); ?>",
                type: "POST",
                data: {
                    caste_id: idCaste,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                dataType: 'json',
                success: function (res) {
                    $('#sub-caste-dd').html(`<option value=""><?php echo app('translator')->get("Select Sub-Caste"); ?></option>`);
                    $.each(res.subCaste, function (key, value) {
                        $("#sub-caste-dd").append(`<option value="${value.id}" ${(value.id == selectedSubCaste) ? 'selected' : ''} > ${value.name} </option>`);
                    });
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/spiritual-social-background.blade.php ENDPATH**/ ?>