
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('WhatsApp Message History'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0"><?php echo app('translator')->get("WhatsApp Message History"); ?></h3>
                <div>
                    <a href="<?php echo e(route('admin.whatsapp-send')); ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> <?php echo app('translator')->get('Send New Message'); ?>
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Date'); ?></th>
                            <th><?php echo app('translator')->get('Recipient'); ?></th>
                            <th><?php echo app('translator')->get('Phone'); ?></th>
                            <th><?php echo app('translator')->get('Message'); ?></th>
                            <th><?php echo app('translator')->get('Status'); ?></th>
                            <th><?php echo app('translator')->get('Response'); ?></th>
                            <th><?php echo app('translator')->get('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <small><?php echo e($message->formatted_date); ?></small>
                                </td>
                                <td>
                                    <?php if($message->user): ?>
                                        <a href="<?php echo e(route('admin.user-edit', $message->user_id)); ?>">
                                            <?php echo e($message->recipient_name ?? $message->user->firstname . ' ' . $message->user->lastname); ?>

                                        </a>
                                    <?php else: ?>
                                        <?php echo e($message->recipient_name ?? 'N/A'); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <code><?php echo e($message->phone); ?></code>
                                </td>
                                <td>
                                    <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo e($message->message); ?>">
                                        <?php echo e(Str::limit($message->message, 50)); ?>

                                    </div>
                                    <?php if($message->attachment_path): ?>
                                        <br><small class="text-muted">
                                            <i class="fas fa-paperclip"></i> <?php echo e($message->attachment_path); ?>

                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($message->status_badge_class); ?>">
                                        <?php echo e(ucfirst($message->status)); ?>

                                    </span>
                                    <?php if($message->http_code): ?>
                                        <br><small class="text-muted">HTTP <?php echo e($message->http_code); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($message->error_message): ?>
                                        <small class="text-danger"><?php echo e(Str::limit($message->error_message, 30)); ?></small>
                                    <?php elseif($message->api_response): ?>
                                        <small class="text-success"><?php echo app('translator')->get('Success'); ?></small>
                                    <?php else: ?>
                                        <small class="text-muted">-</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#messageModal<?php echo e($message->id); ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Message Detail Modal -->
                            <div class="modal fade" id="messageModal<?php echo e($message->id); ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><?php echo app('translator')->get('Message Details'); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong><?php echo app('translator')->get('Date:'); ?></strong><br>
                                                    <?php echo e($message->formatted_date); ?>

                                                </div>
                                                <div class="col-md-6">
                                                    <strong><?php echo app('translator')->get('Status:'); ?></strong><br>
                                                    <span class="badge <?php echo e($message->status_badge_class); ?>">
                                                        <?php echo e(ucfirst($message->status)); ?>

                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong><?php echo app('translator')->get('Recipient:'); ?></strong><br>
                                                    <?php echo e($message->recipient_name ?? 'N/A'); ?>

                                                </div>
                                                <div class="col-md-6">
                                                    <strong><?php echo app('translator')->get('Phone:'); ?></strong><br>
                                                    <code><?php echo e($message->phone); ?></code>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <strong><?php echo app('translator')->get('Message:'); ?></strong><br>
                                                <div class="alert alert-light border">
                                                    <?php echo e($message->message); ?>

                                                </div>
                                            </div>
                                            <?php if($message->attachment_path): ?>
                                                <div class="mb-3">
                                                    <strong><?php echo app('translator')->get('Attachment:'); ?></strong><br>
                                                    <i class="fas fa-paperclip"></i> <?php echo e($message->attachment_path); ?>

                                                </div>
                                            <?php endif; ?>
                                            <?php if($message->api_response): ?>
                                                <div class="mb-3">
                                                    <strong><?php echo app('translator')->get('API Response:'); ?></strong><br>
                                                    <pre class="bg-light p-2 rounded" style="max-height: 200px; overflow-y: auto;"><code><?php echo e($message->api_response); ?></code></pre>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($message->error_message): ?>
                                                <div class="mb-3">
                                                    <strong><?php echo app('translator')->get('Error:'); ?></strong><br>
                                                    <div class="alert alert-danger">
                                                        <?php echo e($message->error_message); ?>

                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($message->http_code): ?>
                                                <div class="mb-3">
                                                    <strong><?php echo app('translator')->get('HTTP Code:'); ?></strong> <?php echo e($message->http_code); ?>

                                                </div>
                                            <?php endif; ?>
                                            <?php if($message->api_id): ?>
                                                <div class="mb-3">
                                                    <strong><?php echo app('translator')->get('API ID:'); ?></strong> <?php echo e($message->api_id); ?><br>
                                                    <strong><?php echo app('translator')->get('Device:'); ?></strong> <?php echo e($message->device_name ?? 'N/A'); ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="py-4">
                                        <i class="fab fa-whatsapp fa-3x text-muted mb-3"></i>
                                        <p class="text-muted"><?php echo app('translator')->get('No WhatsApp messages sent yet.'); ?></p>
                                        <a href="<?php echo e(route('admin.whatsapp-send')); ?>" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> <?php echo app('translator')->get('Send Your First Message'); ?>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($messages->hasPages()): ?>
                <div class="mt-3">
                    <?php echo e($messages->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/admin/users/whatsapp-history.blade.php ENDPATH**/ ?>