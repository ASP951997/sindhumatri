
<!--------------Education Info----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="educationInfo">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseEducationInfo"
            aria-expanded="false"
            aria-controls="collapseEducationInfo"
        >
            <i class="fas fa-graduation-cap"></i>
            <?php echo app('translator')->get('Education Info'); ?>
        </button>
    </h5>
    <div
        id="collapseEducationInfo"
        class="accordion-collapse collapse <?php if($errors->has('educationInfo') || session()->get('name') == 'educationInfo'): ?> show <?php endif; ?>"
        aria-labelledby="educationInfo"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end pe-3">
                    <button
                        class="add-new btn-flower2"
                        data-bs-toggle="modal"
                        data-bs-target="#educationInfoModal">
                        <?php echo app('translator')->get('Add new'); ?>
                    </button>
                </div>

                <div class="col-md-12">
                    <div class="table-wrapper table-responsive">
                        <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col"><?php echo app('translator')->get('Educational Area'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Degree'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Institution'); ?></th>
                                       <!-- <th scope="col"><?php echo app('translator')->get('Start'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('End'); ?></th>-->
                                        <th scope="col"><?php echo app('translator')->get('Action'); ?></th> 
                                    </tr>
                                </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $educationInfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e(html_entity_decode($data->area)); ?></td>
                                    <td><?php echo e($data->degree); ?></td>
                                    <td><?php echo e(html_entity_decode($data->institution)); ?></td>
                                   <!-- <td><?php echo e($data->start != "" ? dateTime(@$data->start,'d M, Y') : ""); ?></td>
                                    <td><?php echo e($data->end != "" ? dateTime(@$data->end,'d M, Y') : ""); ?></td>
									-->
                                    <td>
                                        <button class="action-btn success edit-button" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#educationInfoEditModal"
                                                data-degree="<?php echo e($data->degree); ?>"
                                                data-institution="<?php echo e($data->institution); ?>"
                                                data-start="<?php echo e($data->start); ?>"
                                                data-end="<?php echo e($data->end); ?>"
                                                data-route="<?php echo e(route('user.educationInfoUpdate',['id'=>$data->id])); ?>"
                                        >
                                                <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="action-btn danger notiflix-confirm"
s-                                              data-bs-toggle="modal"
                                                data-bs-target="#delete-modal"
                                                data-route="<?php echo e(route('user.educationInfoDelete',['id'=>$data->id])); ?>"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="100%" class="text-center"><?php echo app('translator')->get('No Education Info Found'); ?></td>
                                </tr>
                            <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('modal-here'); ?>
    <!--------------Education Info Create Modal----------------->
    <div
        class="modal fade modal-with-form"
        id="educationInfoModal"
        tabindex="-1"
        aria-labelledby="educationInfoLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="educationInfoLabel">
                        <?php echo app('translator')->get('Add New Education Info'); ?>
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form action="<?php echo e(route('user.educationInfoCreate')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                   

                    <div class="modal-body">

						<div class="form-group">
                        <label for="area"><?php echo app('translator')->get('Educational Area'); ?></label> <span class="text-danger">*</span>
                        <select class="form-select" name="area" aria-label="area" required>  
                            <option value="" disabled selected><?php echo app('translator')->get('Select Area'); ?></option>
							<option value="Engineering" <?php echo e((old('area') ?? $user->area) == 'Engineering' ? 'selected' : ''); ?>>Engineering</option>
                            <option value="Arts/Design" <?php echo e((old('area') ?? $user->area) == 'Arts/Design' ? 'selected' : ''); ?>>Arts/Design</option>
                            <option value="Finance/Commerce" <?php echo e((old('area') ?? $user->area) == 'Finance/Commerce' ? 'selected' : ''); ?>>Finance/Commerce</option>
                            <option value="Computers/IT" <?php echo e((old('area') ?? $user->area) == 'Computers/IT' ? 'selected' : ''); ?>>Computers/IT</option>
                            <option value="Science" <?php echo e((old('area') ?? $user->area) == "Science" ? 'selected' : ''); ?>>Science</option>
                            <option value="Medicine" <?php echo e((old('area') ?? $user->area) == "Medicine" ? 'selected' : ''); ?>>Medicine</option>
                            <option value="Management" <?php echo e((old('area') ?? $user->area) == "Management" ? 'selected' : ''); ?>>Management</option>
                            <option value="Law" <?php echo e((old('area') ?? $user->area) == "Law" ? 'selected' : ''); ?>>Law</option>
                            <option value="Other" <?php echo e((old('area') ?? $user->area) == "Other" ? 'selected' : ''); ?>>Other</option>
                        </select>
                        <?php if($errors->has('area')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('area')); ?> </div>
                        <?php endif; ?>
                        </div>

                     <div class="form-group">
                        <label for="degree"><?php echo app('translator')->get('Degree'); ?></label> <span class="text-danger">*</span>
                        <select class="form-select" name="degree" aria-label="degree" required>  
                            <option value="" disabled selected><?php echo app('translator')->get('Select Degree'); ?></option>
							<option value="Doctorate" <?php echo e((old('degree') ?? $user->degree) == 'Doctorate' ? 'selected' : ''); ?>>Doctorate</option>
                            <option value="Master" <?php echo e((old('degree') ?? $user->degree) == 'Master' ? 'selected' : ''); ?>>Master</option>
                            <option value="Bachelor/Undergraduate" <?php echo e((old('degree') ?? $user->degree) == 'Bachelor/Undergraduate' ? 'selected' : ''); ?>>Bachelor/Undergraduate</option>
                            <option value="Associate/Diploma" <?php echo e((old('degree') ?? $user->degree) == 'Associate/Diploma' ? 'selected' : ''); ?>>Associate/Diploma</option>
                            <option value="High School and below" <?php echo e((old('degree') ?? $user->degree) == "High School and below" ? 'selected' : ''); ?>>High School and below</option>
                            
                        </select>
                        <?php if($errors->has('degree')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('degree')); ?> </div>
                        <?php endif; ?>
                        </div>

                       <!-- 
                       <div class="form-group">
                            <label for="degree"><?php echo app('translator')->get('Degree'); ?></label> <span class="text-danger">*</span>
                            <input type="text" name="degree" class="form-control" placeholder="<?php echo app('translator')->get('Your Degree'); ?>" value="" required/>
                            <?php if($errors->has('degree')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('degree')); ?> </div>
                            <?php endif; ?>
                        </div> -->
                        <div class="form-group">
                            <label for="institution"><?php echo app('translator')->get('Institution'); ?></label>
                            <input type="text" name="institution" class="form-control" placeholder="<?php echo app('translator')->get('Your Institution'); ?>" value=""/>
                            <?php if($errors->has('institution')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('institution')); ?> </div>
                            <?php endif; ?>
                        </div>
						<!--
                        <div class="form-group">
                            <label for="start"><?php echo app('translator')->get('Start Date'); ?></label>
                            <input type="date" name="start" class="form-control" value=""/>
                            <?php if($errors->has('start')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('start')); ?> </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="end"><?php echo app('translator')->get('End Date'); ?></label>
                            <input type="date" name="end" class="form-control" value=""/>
                            <?php if($errors->has('end')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('end')); ?> </div>
                            <?php endif; ?>
                        </div>
						-->
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn-flower2 btn1"
                            data-bs-dismiss="modal"
                        >
                            <?php echo app('translator')->get('Cancel'); ?>
                        </button>
                        <button type="submit" class="btn-flower2 btn2">
                            <?php echo app('translator')->get('Submit'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--------------Education Info Edit Modal----------------->
    <div
        class="modal fade modal-with-form"
        id="educationInfoEditModal"
        tabindex="-1"
        aria-labelledby="educationInfoLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="educationInfoLabel">
                        <?php echo app('translator')->get('Edit Education Info'); ?>
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form action="" method="post" id="editForm">
                    <?php echo method_field('put'); ?>
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
					
					<div class="form-group">
                        <label for="area"><?php echo app('translator')->get('Educational Area'); ?></label> <span class="text-danger">*</span>
                        <select class="form-select" name="area" aria-label="area" required>  
                            <option value="" disabled selected><?php echo app('translator')->get('Select Area'); ?></option>
							<option value="Engineering" <?php echo e((old('area') ?? $user->area) == 'Engineering' ? 'selected' : ''); ?>>Engineering</option>
                            <option value="Arts/Design" <?php echo e((old('area') ?? $user->area) == 'Arts/Design' ? 'selected' : ''); ?>>Arts/Design</option>
                            <option value="Finance/Commerce" <?php echo e((old('area') ?? $user->area) == 'Finance/Commerce' ? 'selected' : ''); ?>>Finance/Commerce</option>
                            <option value="Computers/IT" <?php echo e((old('area') ?? $user->area) == 'Computers/IT' ? 'selected' : ''); ?>>Computers/IT</option>
                            <option value="Science" <?php echo e((old('area') ?? $user->area) == "Science" ? 'selected' : ''); ?>>Science</option>
                            <option value="Medicine" <?php echo e((old('area') ?? $user->area) == "Medicine" ? 'selected' : ''); ?>>Medicine</option>
                            <option value="Management" <?php echo e((old('area') ?? $user->area) == "Management" ? 'selected' : ''); ?>>Management</option>
                            <option value="Law" <?php echo e((old('area') ?? $user->area) == "Law" ? 'selected' : ''); ?>>Law</option>
                            <option value="Other" <?php echo e((old('area') ?? $user->area) == "Other" ? 'selected' : ''); ?>>Other</option>
                        </select>
                        <?php if($errors->has('area')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('area')); ?> </div>
                        <?php endif; ?>
                        </div>
                       <div class="form-group">
                        <label for="degree"><?php echo app('translator')->get('Degree'); ?></label> <span class="text-danger">*</span>
                        <select class="form-select" name="degree" aria-label="degree" required>  
                            <option value="" disabled selected><?php echo app('translator')->get('Select Degree'); ?></option>
							<option value="Doctorate" <?php echo e((old('degree') ?? $user->degree) == 'Doctorate' ? 'selected' : ''); ?>>Doctorate</option>
                            <option value="Master" <?php echo e((old('degree') ?? $user->degree) == 'Master' ? 'selected' : ''); ?>>Master</option>
                            <option value="Bachelor/Undergraduate" <?php echo e((old('degree') ?? $user->degree) == 'Bachelor/Undergraduate' ? 'selected' : ''); ?>>Bachelor/Undergraduate</option>
                            <option value="Associate/Diploma" <?php echo e((old('degree') ?? $user->degree) == 'Associate/Diploma' ? 'selected' : ''); ?>>Associate/Diploma</option>
                            <option value="High School and below" <?php echo e((old('degree') ?? $user->degree) == "High School and below" ? 'selected' : ''); ?>>High School and below</option>
                            
                        </select>
                        <?php if($errors->has('degree')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('degree')); ?> </div>
                        <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="institution"><?php echo app('translator')->get('Institution'); ?></label> <span class="text-danger">*</span>
                            <input type="text" name="institution" class="form-control institution" placeholder="<?php echo app('translator')->get('Your Institution'); ?>" required value="<?php echo e(old('institution')); ?>"/>
                            <?php if($errors->has('institution')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('institution')); ?> </div>
                            <?php endif; ?>
                        </div>
						<!--
                        <div class="form-group">
                            <label for="start"><?php echo app('translator')->get('Start Date'); ?></label>
                            <input type="date" name="start" class="form-control start" value="<?php echo e(old('start')); ?>" />
                            <?php if($errors->has('start')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('start')); ?> </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="end"><?php echo app('translator')->get('End Date'); ?></label> 
                            <input type="date" name="end" class="form-control end" value="<?php echo e(old('end')); ?>" />
                            <?php if($errors->has('end')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('end')); ?> </div>
                            <?php endif; ?>
                        </div>
						-->
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn-flower2 btn1"
                            data-bs-dismiss="modal"
                        >
                            <?php echo app('translator')->get('Cancel'); ?>
                        </button>
                        <button type="submit" class="btn-flower2 btn2">
                            <?php echo app('translator')->get('Update'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!----------- Education Info Delete Modal ----------------->
    <div id="delete-modal" class="modal fade modal-with-form" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content form-block">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Delete Confirmation'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you sure to delete this?'); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-flower2 btn1" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <form action="" method="post" class="deleteRoute">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('delete'); ?>
                        <button type="submit" class="btn-flower2 btn2"><?php echo app('translator')->get('Yes'); ?></button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $(document).on('click', '.edit-button', function () {
                $('#editForm').attr('action', $(this).data('route'))
                $('.degree').val($(this).data('degree'))
                $('.institution').val($(this).data('institution'))
                $('.start').val($(this).data('start'))
                $('.end').val($(this).data('end'))
            })


            $('.notiflix-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })

        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/education-info.blade.php ENDPATH**/ ?>