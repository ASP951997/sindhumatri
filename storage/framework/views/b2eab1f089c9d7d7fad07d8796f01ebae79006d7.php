<?php $__env->startSection('title',__('Matched Profile')); ?>

<?php $__env->startSection('content'); ?>

    <section class="dashboard-section members-section">
        <div class="container">
            <div class="row gy-5 g-lg-4">
                <?php echo $__env->make($theme.'user.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="dashboard-title">
                                    <h5><?php echo app('translator')->get('Matched Profile'); ?></h5>
                                    <?php if($allUser->count() > 0 && $allUser->count() <= 6): ?>
                                        <small class="text-muted d-block mt-2">
                                            <?php echo app('translator')->get('Showing compatible profiles based on your preferences. Consider updating your partner expectations for more matches.'); ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <?php $__empty_1 = true; $__currentLoopData = $allUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            $premium = $data->purchasedPlanItems;
                                            $currentUserPlanItems = \App\Models\PurchasedPlanItem::where('user_id',auth()->user()->id)->first();
                                            $countProfileView = \App\Models\ProfileView::where(['user_id' => auth()->user()->id,'member_id' => $data->id])->count();
                                        ?>

                                        <div class="member-box d-md-flex">
                                            <div class="img-box">
											
                                                <img src="<?php echo e(getFile(config('location.user.path').$data->image)); ?>" class=""
                                                     alt="<?php echo app('translator')->get('member post image'); ?>"/>
													 <div class="hover-content cursorDefault">
                                                    
													<div class="text-box position-absolute top-50 start-20">
									<a href="<?php echo e(getFile(config('location.user.path').$data->image)); ?>" data-fancybox="single" class="mx-2 iconHoverBg">
										<i class="fas fa-expand"></i>
									</a>
								</div>
                                                </div>
                                            </div>

                                            <div>
                                                <h5 class="name"><?php echo app('translator')->get($data->firstname); ?> <?php echo app('translator')->get($data->lastname); ?></h5>
                                                <span class="member-id"
                                                ><?php echo app('translator')->get('Member ID'); ?> : <span><?php echo app('translator')->get($data->member_id); ?></span></span>
                                                <div class="row g-2 mt-3 member-info">
                                                    <div class="col-6">
                                                        <span><?php echo app('translator')->get('age'); ?> : <?php echo app('translator')->get($data->age); ?> <?php echo app('translator')->get('years'); ?></span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span><?php echo app('translator')->get('height'); ?> : <?php echo app('translator')->get($data->height); ?> <?php echo app('translator')->get('Feet'); ?></span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span><?php echo app('translator')->get('religion'); ?> : <?php echo app('translator')->get(optional($data->getReligion)->name); ?></span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span><?php echo app('translator')->get('caste'); ?> : <?php echo app('translator')->get(optional($data->getCaste)->name); ?></span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span><?php echo app('translator')->get('location'); ?> : <?php echo app('translator')->get(optional($data->getPresentCountry)->name); ?></span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span><?php echo app('translator')->get('maritial status'); ?> : <?php echo app('translator')->get(optional($data->maritalStatus)->name); ?></span>
                                                    </div>
                                                </div>


                                                <div class="button-group">
                                                    <?php if(isset($currentUserPlanItems) && $currentUserPlanItems->contact_view_info > 0 && $countProfileView == 0 || isset($currentUserPlanItems) && $currentUserPlanItems->contact_view_info >= 0 && $countProfileView != 0 || auth()->user()->id == $data->id): ?>
                                                        <a href="<?php echo e(route('user.member.profile.show', $data->id)); ?>">
                                                            <i class="fal fa-user"></i>
                                                            <span><?php echo app('translator')->get('Show Profile'); ?></span>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="javascript:void(0)"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#gotoPlanModal"
                                                        >
                                                            <i class="fal fa-user"></i>
                                                            <span><?php echo app('translator')->get('Show Profile'); ?></span>
                                                        </a>
                                                    <?php endif; ?>


                                                    <a href="javascript:void(0)"
                                                       id="<?php echo e($key); ?>"
                                                       class="update_interest"
                                                       data-memberid="<?php echo e($data->id); ?>"
                                                    >
                                                        <i class="fal fa-heart"></i>
                                                        <?php if($data->interest): ?>
                                                            <span class="<?php echo e($key); ?>interest"><?php echo app('translator')->get('Interest Expressed'); ?></span>
                                                        <?php else: ?>
                                                            <span class="<?php echo e($key); ?>interest"><?php echo app('translator')->get('Make Interest'); ?></span>
                                                        <?php endif; ?>
                                                    </a>


                                                    <a href="javascript:void(0)"
                                                       id="<?php echo e($key); ?>"
                                                       class="update_shortlist"
                                                       data-memberid="<?php echo e($data->id); ?>"
                                                    >
                                                        <i class="fal fa-list"></i>
                                                        <?php if($data->shortlist): ?>
                                                            <span class="<?php echo e($key); ?>"><?php echo app('translator')->get('Shortlisted'); ?></span>
                                                        <?php else: ?>
                                                            <span class="<?php echo e($key); ?>"><?php echo app('translator')->get('Shortlist'); ?></span>
                                                        <?php endif; ?>
                                                    </a>

                                                    <a href="javascript:void(0)"
                                                       id="<?php echo e($key); ?>"
                                                       class="ignore"
                                                       data-memberid="<?php echo e($data->id); ?>"
                                                    >
                                                        <span class="<?php echo e($key); ?>ignore"><i class="fal fa-ban"></i> <?php echo app('translator')->get('Ignore'); ?></span>
                                                    </a>


                                                    <?php if(auth()->user()->id != $data->id): ?>
                                                        <a href="javascript:void(0)"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#reportModal"
                                                           data-route="<?php echo e(route('user.report.submit',$data->id)); ?>"
                                                           class="reportButton"
                                                        >
                                                            <i class="fal fa-exclamation-circle"></i>
                                                            <span><?php echo app('translator')->get('Report'); ?></span>
                                                        </a>
                                                    <?php endif; ?>


                                                </div>
                                            </div>

                                            <?php if($premium): ?>
                                                <?php if($premium->express_interest > 0 || $premium->gallery_photo_upload > 0 || $premium->contact_view_info > 0): ?>
                                                    <span class="tag"><?php echo app('translator')->get('Premium'); ?></span>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="d-flex flex-column justify-content-center py-5">
                                            <h3 class="text-center mt-5 mb-3"><?php echo app('translator')->get('No Perfect Matches Found'); ?></h3>
                                            <p class="text-center text-muted mb-4"><?php echo app('translator')->get('We couldn\'t find profiles that match all your partner expectations. However, you can still explore other compatible profiles or adjust your preferences to see more options.'); ?></p>
                                            <div class="text-center">
                                                <a href="<?php echo e(route('user.matched.profile')); ?>" class="btn btn-primary me-2">
                                                    <i class="fas fa-refresh"></i> <?php echo app('translator')->get('Refresh Results'); ?>
                                                </a>
                                                <a href="<?php echo e(route('user.partnerExpectation')); ?>" class="btn btn-outline-primary">
                                                    <i class="fas fa-cog"></i> <?php echo app('translator')->get('Adjust Preferences'); ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="row">
                                        <?php echo e($allUser->links()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Goto Purchase Plan Modal -->
    <div id="gotoPlanModal" class="modal fade modal-with-form" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content form-block">
                <div class="modal-body">
                    <div class="form-group">
                        <h4 class="text-green text-center py-3"><?php echo app('translator')->get('Please Upgrade Your Package'); ?></h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-flower2 btn1" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <a href="<?php echo e(route('plan')); ?>">
                        <button type="submit" class="btn-flower2 btn2 planPurchaseButton"><?php echo app('translator')->get('Purchase Package'); ?></button>
                    </a>
                </div>
            </div>

        </div>
    </div>


    <!-- Report modal -->
    <div class="modal fade modal-with-form" id="reportModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel"><?php echo app('translator')->get('Report Member!'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="reportSubmit">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reportReason"><?php echo app('translator')->get('Report Reason'); ?></label>
                            <textarea name="reason" id="reportReason" cols="30" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-flower btn1" data-bs-dismiss="modal"><?php echo app('translator')->get('Cancel'); ?></button>
                        <button type="submit" class="btn-flower btn2"><?php echo app('translator')->get('Submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        var user_id = "<?php echo e(auth()->id()); ?>"

        // for update shortlist
        $(document).on('click', '.update_shortlist', function () {
            var member_id = $(this).data('memberid');
            var _this = this;

            if (member_id == user_id) {
                Notiflix.Notify.Failure("<?php echo app('translator')->get('You can\'t shortlist yourself'); ?>");
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: "<?php echo e(url('/add/shortlist/')); ?>/" + member_id,
                    dataType: "json",
                    data: {
                        member_id: member_id
                    },
                    success: function (response) {
                        if (response.action == 'add') {
                            $(`.${_this.id}`).text('Shortlisted')
                            Notiflix.Notify.Success(response.message);
                        } else if (response.action == 'remove') {
                            $(`.${_this.id}`).text('Shortlist');
                            Notiflix.Notify.Success(response.message);
                        }
                    }
                })
            }

        });


        // for make interest
        $(document).on('click', '.update_interest', function () {
            var member_id = $(this).data('memberid');
            var _this = this;

            if (member_id == user_id) {
                Notiflix.Notify.Failure("<?php echo app('translator')->get('You can\'t express interest yourself'); ?>");
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: "<?php echo e(url('/add/interest/')); ?>/" + member_id,
                    dataType: "json",
                    data: {
                        member_id: member_id
                    },
                    success: function (response) {
                        if (response.action == 'add') {
                            $(`.${_this.id}interest`).text('Interest Expressed')
                            Notiflix.Notify.Success(response.message);
                        } else if (response.action == 'alreadyExist') {
                            // $(`.${_this.id}`).text('interest');
                            Notiflix.Notify.Failure(response.message);
                        } else if (response.action == 'purchasePackage') {
                            $('#gotoPlanModal').modal('show');
                            
                            // Notiflix.Notify.Failure(response.message);
                        }
                    }
                })
            }

        });


        // for ignore member
        $(document).on('click', '.ignore', function () {
            var member_id = $(this).data('memberid');
            var _this = this;

            if (member_id == user_id) {
                Notiflix.Notify.Failure("<?php echo app('translator')->get('You can\'t ignore yourself'); ?>");
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: "<?php echo e(url('/add/ignore/')); ?>/" + member_id,
                    dataType: "json",
                    data: {
                        member_id: member_id
                    },
                    success: function (response) {
                        if (response.action == 'add') {
                            $(`.${_this.id}ignore`).text('')
                            Notiflix.Notify.Success(response.message);
                        }
                    }
                })
            }

        });


        // report member
        $(document).on('click', '.reportButton', function (){
            var route = $(this).data('route');
            $('.reportSubmit').attr('action', route)
        })
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/matched_profile/matched_profile.blade.php ENDPATH**/ ?>