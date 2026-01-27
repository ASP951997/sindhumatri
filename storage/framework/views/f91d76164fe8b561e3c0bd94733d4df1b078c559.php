
<!--------------Permanent Address----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="permanentAddress">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsePermanentAddress"
            aria-expanded="false"
            aria-controls="collapsePermanentAddress"
        >
            <i class="fas fa-map-marker-alt"></i>
            <?php echo app('translator')->get('Permanent Address'); ?>
        </button>
    </h5>
    <div
        id="collapsePermanentAddress"
        class="accordion-collapse collapse <?php if($errors->has('permanentAddress') || session()->get('name') == 'permanentAddress'): ?> show <?php endif; ?>"
        aria-labelledby="permanentAddress"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="<?php echo e(route('user.permanentAddress')); ?>" method="post" id="permanentAddressForm">
                <?php echo csrf_field(); ?>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="sameAsPresent" name="sameAsPresent">
                    <label class="form-check-label" for="sameAsPresent"><?php echo app('translator')->get('Same as present address'); ?></label>
                </div>
                <div class="row g-3 g-md-4">
                    <div class="col-md-6 form-group">
                        <label for="permanent_country"><?php echo app('translator')->get('Country'); ?></label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            id="country-permanent"
                            name="permanent_country"
                            aria-label="permanent_country"
                        >
                            <option value="" disabled><?php echo app('translator')->get('Select Country'); ?></option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($data->id); ?>" <?php echo e($user->permanent_country == $data->id ? 'selected' : ''); ?>><?php echo e($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['permanent_country'];
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
                        <label for="permanent_state"><?php echo app('translator')->get('state'); ?></label> <span class="text-danger">*</span>
                        <select id="state-permanent" class="form-control" name='permanent_state'></select>
                        <?php $__errorArgs = ['permanent_state'];
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
                        <label for="permanent_city"><?php echo app('translator')->get('city'); ?></label> <span class="text-danger">*</span>
                        <select id="city-permanent" class="form-control" name="permanent_city"></select>
                        <?php $__errorArgs = ['permanent_city'];
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
                        <label for="permanent_postcode"><?php echo app('translator')->get('postal code'); ?></label> <span class="text-danger">*</span>
                        <input
                            type="number"
                            id="permanent_postcode"
                            name="permanent_postcode"
                            value="<?php echo e(old('permanent_postcode') ?? $user->permanent_postcode); ?>"
                            class="form-control"
                            placeholder="<?php echo app('translator')->get('Enter Postal Code'); ?>"
							maxlength="6"
							oninput="this.value=this.value.slice(0,6)"
                        />
                        <?php $__errorArgs = ['permanent_postcode'];
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
                        <label for="permanent_address"><?php echo app('translator')->get('Address'); ?></label> <span class="text-danger">*</span>
                        <textarea name="permanent_address" cols="30" rows="10" class="form-control"
                                  placeholder="<?php echo app('translator')->get('Enter Permanent Address'); ?>"><?php echo e(old('permanent_address') ?? $user->permanent_address); ?></textarea>
                        <?php $__errorArgs = ['permanent_address'];
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

        var idPermanentCountry = $("#country-permanent").val();
        var selectedPermanentState = "<?php echo e($user->permanent_state??null); ?>"
        var selectedPermanentCity = "<?php echo e($user->permanent_city??null); ?>"


        getPermanentStates(idPermanentCountry, selectedPermanentState);
        getPermanentCities(selectedPermanentState, selectedPermanentCity);

        $(document).on('change', '#country-permanent', function () {
            var idPermanentCountry = this.value;
            $("#state-permanent").html('');
            getPermanentStates(idPermanentCountry);
        });

        $(document).on('change', '#state-permanent', function () {
            var idPermanentState = this.value;
            $("#city-permanent").html('');
            getPermanentCities(idPermanentState)
        });

        $(document).on('change', '#sameAsPresent', function () {
            if (this.checked) {
                setCountryWithoutChange("<?php echo e($user->present_country); ?>");
                //$("#country-permanent").val("<?php echo e($user->present_country); ?>");
                //$("#state-permanent").val("<?php echo e($user->present_state); ?>");
                //$("#city-permanent").val("<?php echo e($user->present_city); ?>");

                getPermanentStates("<?php echo e($user->present_country); ?>", "<?php echo e($user->present_state); ?>");
                getPermanentCities("<?php echo e($user->present_state); ?>", "<?php echo e($user->present_city); ?>");
                $("#permanent_postcode").val("<?php echo e($user->present_postcode); ?>");
                $("textarea[name='permanent_address']").val("<?php echo e($user->present_address); ?>");
            } else {
                setCountryWithoutChange();
                $("#country-permanent").val('');
                $("#state-permanent").html('<option value=""><?php echo app('translator')->get("Select State"); ?></option>');
                $("#city-permanent").html('<option value=""><?php echo app('translator')->get("Select City"); ?></option>');
                $("#permanent_postcode").val('');
                $("textarea[name='permanent_address']").val('');
            }
        });

        function setCountryWithoutChange(value) {
            var $countrySelect = $('#country-permanent');
            $countrySelect.val(value);

            // Manually update the display text
            if (value) {
                var selectedText = $countrySelect.find("option:selected").text();
                $countrySelect.siblings('.dropdown-toggle').text(selectedText);
            } else {
                $countrySelect.siblings('.dropdown-toggle').text('<?php echo app('translator')->get("Select Country"); ?>');
            }
        }

        function updateDropdownDisplay($selectElement) {
            // This function updates the select element display to reflect the new value
            if ($selectElement[0].selectize) {
                $selectElement[0].selectize.setValue($selectElement.val());
            } else {
                $selectElement.trigger('chosen:updated'); // For Chosen library
                $selectElement.trigger('select2:select'); // For Select2 library
            }
        }


        function getPermanentStates(idPermanentCountry, selectedPermanentState = null) {
            $.ajax({
                url: "<?php echo e(route('user.states')); ?>",
                type: "POST",
                data: {
                    country_id: idPermanentCountry,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                dataType: 'json',
                success: function (result) {
                    $('#state-permanent').html('<option value=""><?php echo app('translator')->get("Select State"); ?></option>');
                    $.each(result.states, function (key, value) {
                        $("#state-permanent").append(`<option value="${value.id}" ${(value.id == selectedPermanentState) ? 'selected' : ''}>${value.name}</option>`);
                    });
                    $('#city-permanent').html(`<option value=""><?php echo app('translator')->get("Select City"); ?></option>`);
                }
            });
        }

        function getPermanentCities(idPermanentState = null, selectedPermanentCity = null) {
            $.ajax({
                url: "<?php echo e(route('user.cities')); ?>",
                type: "POST",
                data: {
                    state_id: idPermanentState,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                dataType: 'json',
                success: function (res) {
                    $('#city-permanent').html(`<option value=""><?php echo app('translator')->get("Select City"); ?></option>`);
                    $.each(res.cities, function (key, value) {
                        $("#city-permanent").append(`<option value="${value.id}" ${(value.id == selectedPermanentCity) ? 'selected' : ''}>${value.name}</option>`);
                    });
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/permanent-address.blade.php ENDPATH**/ ?>