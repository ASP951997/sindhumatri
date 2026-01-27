<!--------------Career Info----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="careerInfo">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseCareerInfo"
            aria-expanded="false"
            aria-controls="collapseCareerInfo"
        >
            <i class="far fa-user-graduate"></i>
            <?php echo app('translator')->get('Career Info'); ?>
        </button>
    </h5>
    <div
        id="collapseCareerInfo"
        class="accordion-collapse collapse <?php if($errors->has('careerInfo') || session()->get('name') == 'careerInfo'): ?> show <?php endif; ?>"
        aria-labelledby="careerInfo"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end pe-3">
                    <button
                        class="add-new btn-flower2"
                        data-bs-toggle="modal"
                        data-bs-target="#careerInfoModal"
                    >
                        <?php echo app('translator')->get('Add new'); ?>
                    </button>
                </div>

                <div class="col-md-12">
                    <div class="table-wrapper table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col"><?php echo app('translator')->get('Profession Area'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Designation'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('Company'); ?></th>
                                <!-- <th scope="col"><?php echo app('translator')->get('Start'); ?></th>
                                <th scope="col"><?php echo app('translator')->get('End'); ?></th> -->
                                <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $careerInfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e(html_entity_decode($data->area)); ?></td>
                                    <td><?php echo e(html_entity_decode($data->designation)); ?></td>
                                    <td><?php echo e(html_entity_decode($data->company)); ?></td>
                                   <!-- <td><?php if(isset($data->start)): ?>
                                            <?php echo e(dateTime(@$data->start,'d M, Y')); ?>

                                        <?php else: ?>
                                            <?php echo app('translator')->get('N/A'); ?>
                                        <?php endif; ?></td>
                                    <td>
                                        <?php if(isset($data->end)): ?>
                                            <?php echo e(dateTime(@$data->end,'d M, Y')); ?>

                                        <?php else: ?>
                                            <?php echo app('translator')->get('N/A'); ?>
                                        <?php endif; ?>
                                    </td> -->
                                    <td>
                                        <button class="action-btn success edit-button" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#careerInfoEditModal"
                                                data-designation="<?php echo e($data->designation); ?>"
                                                data-company="<?php echo e($data->company); ?>"
                                                data-start="<?php echo e($data->start); ?>"
                                                data-end="<?php echo e($data->end); ?>"
                                                data-route="<?php echo e(route('user.careerInfoUpdate',['id'=>$data->id])); ?>"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="action-btn danger notiflix-confirm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete-modal"
                                                data-route="<?php echo e(route('user.careerInfoDelete',['id'=>$data->id])); ?>"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="100%" class="text-center"><?php echo app('translator')->get('No Career Info Found'); ?></td>
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
    <!--------------Career Info Create Modal----------------->
    <div
        class="modal fade modal-with-form"
        id="careerInfoModal"
        tabindex="-1"
        aria-labelledby="careerInfoLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="careerInfoLabel">
                        <?php echo app('translator')->get('Add New Career Info'); ?>
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form action="<?php echo e(route('user.careerInfoCreate')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
					<div class="form-group">
                        <label for="area"><?php echo app('translator')->get('Profession Area'); ?></label> <span class="text-danger">*</span>
                        <select class="form-select" name="area" aria-label="area" required>  
                            <option value="" disabled selected><?php echo app('translator')->get('Select Area'); ?></option>
							<option value="Accounting, Banking & Finance" >Accounting, Banking & Finance</option>
                            <option value="Administration & HR" >Administration & HR</option>
                            <option value="Adevertising, Media & Entertainment" >Adevertising, Media & Entertainment</option>
                            <option value="Agriculture">Agriculture</option>
                            <option value="Ailine& Aviation">Ailine& Aviation</option>
                            <option value="Architecture & Design">Architecture & Design</option>
                            <option value="Artists, Animators & Web Designers">Artists, Animators & Web Designers</option>
                            <option value="BPO, KPO & Customer Support">BPO, KPO & Customer Support</option>
                            <option value="Defence">Defence</option>
                            <option value="Education & Training">Education & Training</option>
                            <option value="Engineering" >High School and below</option>
                            <option value="Legal" >Legal</option>
                            <option value="Medical & Healthcare" >Medical & Healthcare</option>
                            <option value="Merchant Navy" >Merchant Navy</option>
                            <option value="Non Working">Non Working</option>
                            <option value="Others">Others</option>
                            
                        </select>
                        <?php if($errors->has('area')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('area')); ?> </div>
                        <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="designation"><?php echo app('translator')->get('Designation'); ?></label> <span class="text-danger">*</span>
                            <input type="text" name="designation" class="form-control" placeholder="<?php echo app('translator')->get('Your Designation'); ?>"
                                   value="<?php echo e(old('designation')); ?>" required/>
                            <?php if($errors->has('designation')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('designation')); ?> </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="company"><?php echo app('translator')->get('Company'); ?></label> <span class="text-danger"></span>
                            <input type="text" name="company" class="form-control"
                                   placeholder="<?php echo app('translator')->get('Company Name'); ?>" required value="<?php echo e(old('company')); ?>"/>
                            <?php if($errors->has('company')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('company')); ?> </div>
                            <?php endif; ?>
                        </div>
						<!--
                        <div class="form-group">
                            <label for="start"><?php echo app('translator')->get('Start Date'); ?></label> <span class="text-danger"></span>
                            <input type="date" name="start" class="form-control" value="<?php echo e(old('start')); ?>"/>
                            <?php if($errors->has('start')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('start')); ?> </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="end"><?php echo app('translator')->get('End Date'); ?></label>
                            <input type="date" name="end" class="form-control" value="<?php echo e(old('end')); ?>"/>
                            <?php if($errors->has('end')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('end')); ?> </div>
                            <?php endif; ?>
                        </div> -->
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


    <!--------------Career Info Edit Modal----------------->
    <div
        class="modal fade modal-with-form"
        id="careerInfoEditModal"
        tabindex="-1"
        aria-labelledby="careerInfoLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="careerInfoLabel">
                        <?php echo app('translator')->get('Edit Career Info'); ?>
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form action="" method="post" class="editForm">
                    <?php echo method_field('put'); ?>
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
						<div class="form-group">
                        <label for="area"><?php echo app('translator')->get('Profession Area'); ?></label> <span class="text-danger">*</span>
                        <select class="form-select" name="area" aria-label="area">  
                            <option value="" disabled selected><?php echo app('translator')->get('Select Area'); ?></option>
							<option value="Accounting, Banking & Finance" >Accounting, Banking & Finance</option>
                            <option value="Administration & HR" >Administration & HR</option>
                            <option value="Adevertising, Media & Entertainment" >Adevertising, Media & Entertainment</option>
                            <option value="Agriculture">Agriculture</option>
                            <option value="Ailine& Aviation">Ailine& Aviation</option>
                            <option value="Architecture & Design">Architecture & Design</option>
                            <option value="Artists, Animators & Web Designers">Artists, Animators & Web Designers</option>
                            <option value="BPO, KPO & Customer Support">BPO, KPO & Customer Support</option>
                            <option value="Defence">Defence</option>
                            <option value="Education & Training">Education & Training</option>
                            <option value="Engineering" >High School and below</option>
                            <option value="Legal" >Legal</option>
                            <option value="Medical & Healthcare" >Medical & Healthcare</option>
                            <option value="Merchant Navy" >Merchant Navy</option>
                            <option value="Non Working">Non Working</option>
                            <option value="Others">Others</option>
                            
                        </select>
                        <?php if($errors->has('area')): ?>
                            <div class="error text-danger"><?php echo app('translator')->get($errors->first('area')); ?> </div>
                        <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="designation"><?php echo app('translator')->get('Designation'); ?></label> <span class="text-danger">*</span>
                            <input type="text" name="designation" class="form-control designation"
                                   placeholder="<?php echo app('translator')->get('Your Designation'); ?>" value="<?php echo e(old('designation')); ?>" required/>
                            <?php if($errors->has('designation')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('designation')); ?> </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="company"><?php echo app('translator')->get('Company'); ?></label> <span class="text-danger">*</span>
                            <input type="text" name="company" class="form-control company"
                                   placeholder="<?php echo app('translator')->get('Company Name'); ?>" required value="<?php echo e(old('company')); ?>"/>
                            <?php if($errors->has('company')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('company')); ?> </div>
                            <?php endif; ?>
                        </div>
						<!--
                        <div class="form-group">
                            <label for="start"><?php echo app('translator')->get('Start Date'); ?></label> <span class="text-danger"></span>
                            <input type="date" name="start" class="form-control start" value="<?php echo e(old('start')); ?>"
                                   />
                            <?php if($errors->has('start')): ?>
                                <div class="error text-danger"><?php echo app('translator')->get($errors->first('start')); ?> </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="end"><?php echo app('translator')->get('End Date'); ?></label>
                            <input type="date" name="end" class="form-control end" value="<?php echo e(old('end')); ?>"/>
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


    <!----------- Career Info Delete Modal ----------------->
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
                $('.editForm').attr('action', $(this).data('route'))
                $('.designation').val($(this).data('designation'))
                $('.company').val($(this).data('company'))
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
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/profile/content/career-info.blade.php ENDPATH**/ ?>