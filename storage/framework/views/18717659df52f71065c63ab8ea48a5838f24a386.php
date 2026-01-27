<!--------------Present Address----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="presentAddress">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsePresentAddress"
            aria-expanded="false"
            aria-controls="collapsePresentAddress"
        >
            <i class="fas fa-map-marker-alt"></i>
            <?php echo app('translator')->get('Present Address'); ?>
        </button>
    </h5>
    <div
        id="collapsePresentAddress"
        class="accordion-collapse collapse <?php if($errors->has('presentAddress') || session()->get('name') == 'presentAddress'): ?> show <?php endif; ?>"
        aria-labelledby="presentAddress"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="<?php echo e(route('user.presentAddress')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row g-3 g-md-4">
                    <div class="col-md-6 form-group">
                        <label for="present_country"><?php echo app('translator')->get('Country'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            id="country-dd"
                            name="present_country"
                            aria-label="present_country"
                        >
                            <option value="" selected disabled><?php echo app('translator')->get('Select Country'); ?></option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($data->id); ?>" <?php echo e($user->present_country == $data->id ? 'selected' : ''); ?>><?php echo e($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['present_country'];
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
                        <label for="present_state"><?php echo app('translator')->get('state'); ?></label> <span class="text-danger">*</span>
                        <select id="state-dd" class="form-control" name='present_state'></select>
                        <?php $__errorArgs = ['present_state'];
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
                        <label for="present_city"><?php echo app('translator')->get('city'); ?></label> <span class="text-danger">*</span>
                        <select id="city-dd" class="form-control" name="present_city"></select>
                        <?php $__errorArgs = ['present_city'];
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
                        <label for="present_postcode"><?php echo app('translator')->get('postal code'); ?></label> <span class="text-danger">*</span>
                        <input
                            type="number"
                            name="present_postcode"
                            value="<?php echo e(old('present_postcode') ?? $user->present_postcode); ?>"
                            class="form-control"
                            placeholder="<?php echo app('translator')->get('Enter Postal Code'); ?>"
							maxlength="6"
							oninput="this.value=this.value.slice(0,6)"
                        />
                        <?php $__errorArgs = ['present_postcode'];
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

                    <div class="col-md-12 form-group" style="display: none;">
                        <label for="present_address"><?php echo app('translator')->get('Address'); ?></label> <span class="text-danger">*</span>
                        <textarea name="present_address" cols="30" rows="10" class="form-control"
                                  placeholder="<?php echo app('translator')->get('Enter Present Address'); ?>">-</textarea>
                        <?php $__errorArgs = ['present_address'];
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
         
        var idCountry = $("#country-dd").val();
        var selectedState = "<?php echo e($user->present_state??null); ?>"
        var selectedCity = "<?php echo e($user->present_city??null); ?>"


        getStates(idCountry, selectedState);
        getCities(selectedState, selectedCity);

        $(document).on('change', '#country-dd', function () {
            var idCountry = this.value;
            $("#state-dd").html('');
            getStates(idCountry,"");
        });

        $(document).on('change', '#state-dd', function () {
            var idState = this.value;
            $("#city-dd").html('');
            getCities(idState,"")
        });

        

        function getStates(idCountry, selectedState = null) {
            
            $.ajax({
                url: "<?php echo e(route('user.states')); ?>",
                type: "POST",
                data: {
                    country_id: idCountry,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                dataType: 'json',
                success: function (result) {
                    $('#state-dd').html('<option value=""><?php echo app('translator')->get("Select State"); ?></option>');
                    $.each(result.states, function (key, value) {
                        $("#state-dd").append(`<option value="${value.id}" ${(value.id == selectedState) ? 'selected' : ''}>${value.name}</option>`);
                    });
                    $('#city-dd').html(`<option value=""><?php echo app('translator')->get("Select City"); ?></option>`);
                }
            });
        }

        function getCities(idState = null, selectedCity = null) {
           
            $.ajax({
                url: "<?php echo e(route('user.cities')); ?>",
                type: "POST",
                data: {
                    state_id: idState,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                dataType: 'json',
                success: function (res) {
                    $('#city-dd').html(`<option value=""><?php echo app('translator')->get("Select City"); ?></option>`);
                    $.each(res.cities, function (key, value) {
                        $("#city-dd").append(`<option value="${value.id}" ${(value.id == selectedCity) ? 'selected' : ''}>${value.name}</option>`);
                    });
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/present-address.blade.php ENDPATH**/ ?>