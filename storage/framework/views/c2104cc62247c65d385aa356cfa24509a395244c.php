
<!--------------Introduction----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="introduction">
        <button
            class="accordion-button"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseIntroduction"
            aria-expanded="true"
            aria-controls="collapseIntroduction"
        >
            <i class="fas fa-user-tag"></i>
            <?php echo app('translator')->get('Introduction'); ?>
        </button>
    </h5>

    <div
        id="collapseIntroduction"
        class="accordion-collapse collapse <?php if($errors->has('intro') || 0 == count($errors)): ?> show <?php endif; ?>"
        aria-labelledby="introduction"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form method="post" action="<?php echo e(route('user.update.introduction')); ?>">
                <?php echo csrf_field(); ?>

                

                <div class="row g-3 g-md-4">
                    <div class="col-md-12 form-group">
                        <label for="introduction"><?php echo app('translator')->get('Introduction'); ?></label> <span class="text-danger">*</span>
                        <br>
                        <select id="intro_template" class="form-control" name="intro_template" aria-label="intro_template" data-container="body">  
                            <option value="" disabled selected><?php echo app('translator')->get('Select template'); ?></option>
                            <?php $__currentLoopData = $communityValue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($data->template); ?>" <?php echo e(($user->community_value == $data->community_template) ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                        </select>
                        <textarea name="introduction1" value="Template 1" id="introduction1" cols="30" rows="10" class="form-control" placeholder="<?php echo app('translator')->get('Enter Introduction'); ?>"><?php echo e(old('introduction') ?? $user->introduction); ?></textarea>
                        <?php $__errorArgs = ['introduction'];
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
                        <button class="btn-flower2 btn-full"><?php echo app('translator')->get('update'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php $__env->startPush('script'); ?>
<script>
    $(document).ready(function () {
        // Define the templates
        var templates = {
            1: "Hello! I’m [Your Name], a [Your Profession] based in [Your City]. I have a degree in [Your Degree] from [Your University]. In my free time, I enjoy [list your hobbies, e.g., reading, traveling, cooking]. Friends describe me as [three positive adjectives, e.g., kind-hearted, ambitious, and cheerful]. I’m looking for a partner who shares my values and interests, someone who is kind, understanding, and has a positive outlook on life. Family is very important to me, and I cherish the time spent with loved ones. I hope to build a family based on love, trust, and mutual respect. If you think we might be a good match, I’d love to hear from you. Let’s connect and see where this journey takes us! Best regards, [Your Name]",
            2: "Hi there! I’m [Your Name], a [Your Profession] from [Your City]. With a degree in [Your Degree], I enjoy spending my free time [mention hobbies, e.g., hiking, reading, and cooking]. I’m known for being [positive adjectives, e.g., warm, driven, and humorous]. I’m looking for a partner who is kind, supportive, and shares similar values. If you think we could be a great match, I’d love to connect! Best, [Your Name]",
            3: "Hello! I’m [Your Name], a [Your Profession] living in [Your City]. I have a degree in [Your Degree] and enjoy [list a couple of hobbies, e.g., traveling and cooking]. Friends describe me as [positive adjectives, e.g., caring, ambitious, and fun-loving]. I’m seeking a kind and understanding partner who values family and enjoys exploring new experiences. If you think we could be a good match, let’s connect and get to know each other better! Best, [Your Name]"
        };

        // Check when dropdown value changes
        $('#intro_template').on('change', function () {
            var templateValue = $(this).val();
           // alert(templateValue);
            //var introText = templates[templateValue] || '';
            //alert(introText);   
            // Set the template text in the textarea
            $('#introduction1').val(templateValue);
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/intro.blade.php ENDPATH**/ ?>