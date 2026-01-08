<?php $__env->startSection('title', __('WhatsApp Settings')); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="row mt-sm-4 justify-content-center">
            <div class="col-12 col-md-8 col-lg-8">
                <div class="container-fluid" id="container-wrapper">
                    <div class="card mb-4 card-primary shadow">
                        <div class="card-header py-3 d-flex flex-row align-items-center bg-dark justify-content-between">
                            <h5 class="m-0 text-white">
                                <i class="fab fa-whatsapp"></i> <?php echo app('translator')->get('WhatsApp API Settings'); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    
                                    <!-- Information Alert -->
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <h6 class="alert-heading"><i class="fas fa-info-circle"></i> <?php echo app('translator')->get('Configuration Information'); ?></h6>
                                        <p class="mb-0">
                                            <?php echo app('translator')->get('Enter your Message API credentials below. You can get these from your'); ?>
                                            <a href="https://messagesapi.co.in" target="_blank" class="alert-link">messagesapi.co.in</a>
                                            <?php echo app('translator')->get('dashboard.'); ?>
                                        </p>
                                        <hr>
                                        <p class="mb-0 small">
                                            <strong><?php echo app('translator')->get('Current API URL:'); ?></strong> 
                                            <code>https://messagesapi.co.in/chat</code>
                                        </p>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <!-- Settings Form -->
                                    <form action="<?php echo e(route('admin.whatsapp.settings')); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        
                                        <div class="row">
                                            <!-- API ID -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="whatsapp_api_id">
                                                        <?php echo app('translator')->get('WhatsApp API ID'); ?> <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           name="whatsapp_api_id"
                                                           id="whatsapp_api_id"
                                                           value="<?php echo e(old('whatsapp_api_id', $basicControl->whatsapp_api_id)); ?>"
                                                           placeholder="<?php echo app('translator')->get('Enter your API ID (e.g., 7e78b0f48d5c4428b3d0cdf70406db2f)'); ?>"
                                                           class="form-control <?php $__errorArgs = ['whatsapp_api_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                           required>
                                                    <small class="form-text text-muted">
                                                        <?php echo app('translator')->get('Your unique API ID from messagesapi.co.in dashboard'); ?>
                                                    </small>
                                                    <?php $__errorArgs = ['whatsapp_api_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>

                                            <!-- Device Name -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="whatsapp_device_name">
                                                        <?php echo app('translator')->get('Device Name'); ?> <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           name="whatsapp_device_name"
                                                           id="whatsapp_device_name"
                                                           value="<?php echo e(old('whatsapp_device_name', $basicControl->whatsapp_device_name)); ?>"
                                                           placeholder="<?php echo app('translator')->get('Enter your device name (e.g., Motorola)'); ?>"
                                                           class="form-control <?php $__errorArgs = ['whatsapp_device_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                           required>
                                                    <small class="form-text text-muted">
                                                        <?php echo app('translator')->get('Your registered device name from messagesapi.co.in'); ?>
                                                    </small>
                                                    <?php $__errorArgs = ['whatsapp_device_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Current Configuration Display -->
                                        <?php if($basicControl->whatsapp_api_id && $basicControl->whatsapp_device_name): ?>
                                        <div class="alert alert-success mt-3">
                                            <h6><i class="fas fa-check-circle"></i> <?php echo app('translator')->get('Current Configuration'); ?></h6>
                                            <ul class="mb-0 pl-3">
                                                <li><strong><?php echo app('translator')->get('API ID'); ?>:</strong> <?php echo e(substr($basicControl->whatsapp_api_id, 0, 10)); ?>...<?php echo e(substr($basicControl->whatsapp_api_id, -5)); ?></li>
                                                <li><strong><?php echo app('translator')->get('Device'); ?>:</strong> <?php echo e($basicControl->whatsapp_device_name); ?></li>
                                                <li>
                                                    <strong><?php echo app('translator')->get('Device Status'); ?>:</strong> 
                                                    <span id="device-status-badge" class="badge badge-secondary pulse-animation">
                                                        <i class="fas fa-spinner fa-spin"></i> <?php echo app('translator')->get('Checking...'); ?>
                                                    </span>
                                                    <small class="text-muted ml-2" id="status-note">(<?php echo app('translator')->get('Verifying connection...'); ?>)</small>
                                                </li>
                                                <li><strong><?php echo app('translator')->get('Configuration'); ?>:</strong> <span class="badge badge-success"><?php echo app('translator')->get('Active'); ?></span></li>
                                            </ul>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="check-status-btn">
                                                <i class="fas fa-sync-alt"></i> <?php echo app('translator')->get('Verify Connection'); ?>
                                            </button>
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle"></i> 
                                                    <?php echo app('translator')->get('Status shows "Connected" when credentials are configured. To verify your device is actually online, try sending a test message from'); ?> 
                                                    <a href="<?php echo e(route('admin.whatsapp-send')); ?>"><?php echo app('translator')->get('Send WhatsApp'); ?></a> <?php echo app('translator')->get('page.'); ?>
                                                </small>
                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <div class="alert alert-warning mt-3">
                                            <i class="fas fa-exclamation-triangle"></i> 
                                            <?php echo app('translator')->get('WhatsApp API is not configured yet. Please enter your credentials above.'); ?>
                                        </div>
                                        <?php endif; ?>

                                        <!-- Save Button -->
                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-primary btn-rounded btn-block">
                                                <i class="fas fa-save"></i> <?php echo app('translator')->get('Save WhatsApp Settings'); ?>
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Additional Information -->
                                    <div class="card bg-light mt-4">
                                        <div class="card-body">
                                            <h6 class="card-title"><i class="fas fa-question-circle"></i> <?php echo app('translator')->get('How to Use'); ?></h6>
                                            <ol class="mb-0">
                                                <li><?php echo app('translator')->get('Get your API credentials from'); ?> <a href="https://messagesapi.co.in/dashboard" target="_blank">messagesapi.co.in/dashboard</a></li>
                                                <li><?php echo app('translator')->get('Enter the API ID and Device Name above'); ?></li>
                                                <li><?php echo app('translator')->get('Click "Save WhatsApp Settings"'); ?></li>
                                                <li><?php echo app('translator')->get('Go to Users → Send WhatsApp to start sending messages'); ?></li>
                                            </ol>
                                            <hr>
                                            <h6 class="card-title mt-3"><i class="fas fa-shield-alt"></i> <?php echo app('translator')->get('Security Note'); ?></h6>
                                            <p class="mb-0 small text-muted">
                                                <?php echo app('translator')->get('Your API credentials are stored securely in the database and are only visible to administrators. Other configuration details like API URL and endpoints are hidden and managed automatically by the system.'); ?>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
<style>
    .alert-link {
        font-weight: 600;
        text-decoration: underline;
    }
    .card-title {
        font-weight: 600;
        margin-bottom: 15px;
    }
    code {
        background-color: #f4f4f4;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 90%;
    }
    #device-status-badge {
        font-size: 95%;
        padding: 4px 10px;
    }
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    @keyframes  pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
<script>
    "use strict";
    
    $(document).ready(function() {
        // Automatically check device status on page load
        checkDeviceStatus();
        
        // Refresh status button click
        $('#check-status-btn').on('click', function() {
            checkDeviceStatus();
        });
        
        function checkDeviceStatus() {
            var $badge = $('#device-status-badge');
            var $btn = $('#check-status-btn');
            var $note = $('#status-note');
            
            // Show loading state
            $badge.removeClass('badge-success badge-danger badge-warning')
                  .addClass('badge-secondary pulse-animation')
                  .html('<i class="fas fa-spinner fa-spin"></i> <?php echo app('translator')->get("Verifying..."); ?>');
            
            $note.html('(<?php echo app('translator')->get("Please wait..."); ?>)');
            
            $btn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i> <?php echo app('translator')->get("Verifying..."); ?>');
            
            // Make AJAX request to check status
            $.ajax({
                url: '<?php echo e(route("admin.whatsapp.checkStatus")); ?>',
                method: 'GET',
                dataType: 'json',
                timeout: 10000, // 10 second timeout
                success: function(response) {
                    updateStatusDisplay(response);
                },
                error: function(xhr, status, error) {
                    // On error, keep as Disconnected (do not assume connected)
                    updateStatusDisplay({
                        connected: false,
                        message: '<?php echo app('translator')->get("Unable to verify device status"); ?>',
                        note: '<?php echo app('translator')->get("Status check failed"); ?>'
                    });
                },
                complete: function() {
                    // Re-enable button
                    $btn.prop('disabled', false)
                        .html('<i class="fas fa-sync-alt"></i> <?php echo app('translator')->get("Verify Connection"); ?>');
                }
            });
        }
        
        function updateStatusDisplay(response) {
            var $badge = $('#device-status-badge');
            var $note = $('#status-note');
            $badge.removeClass('pulse-animation');
            
            if (response.connected) {
                // Device is connected
                $badge.removeClass('badge-secondary badge-danger badge-warning')
                      .addClass('badge-success')
                      .html('<i class="fas fa-check-circle"></i> <?php echo app('translator')->get("Connected"); ?>');
                
                // Show note about verification
                if (response.message) {
                    $note.html('(' + response.message + ')');
                } else if (response.note) {
                    $note.html('(' + response.note + ')');
                } else {
                    $note.html('(<?php echo app('translator')->get("Device is online"); ?>)');
                }
            } else {
                // Device is disconnected
                $badge.removeClass('badge-secondary badge-success badge-warning')
                      .addClass('badge-danger')
                      .html('<i class="fas fa-times-circle"></i> <?php echo app('translator')->get("Disconnected"); ?>');
                
                if (response.message) {
                    $note.html('(' + response.message + ')');
                } else {
                    $note.html('(<?php echo app('translator')->get("Device not connected"); ?>)');
                }
            }
            
            // Show tooltip with message if available
            if (response.message) {
                $badge.attr('title', response.message)
                      .tooltip('dispose')
                      .tooltip();
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/admin/controls/whatsapp-settings.blade.php ENDPATH**/ ?>