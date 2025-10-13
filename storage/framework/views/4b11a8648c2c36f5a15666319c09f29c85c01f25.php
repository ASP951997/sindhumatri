<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Dashboard'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>


    <div class="container-fluid">
        <div class="row admin-fa_icon">

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($userRecord['totalUser'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Total Members'); ?>
                                </h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($userRecord['activeUser'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Total Active Members'); ?>
                                </h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($userRecord['todayJoin']); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Today Joined Members'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e($totalPlan); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Total Active Packages"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fas fa-2x fa-cubes"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($funding['todayPayment'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Today's Payment"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-hand-holding-usd"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($funding['thisMonthPayment'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("This Month's Payment"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-hand-holding-usd"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($funding['totalAmountReceived'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Total Payment"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-hand-holding-usd"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(trans($basic->currency_symbol)); ?><?php echo e(getAmount($funding['totalChargeReceived'],config('basic.fraction_number'))); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get("Payment Charge"); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-hand-holding-usd"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title"><?php echo app('translator')->get("This Month's Summary"); ?></h4>
                                <div>
                                    <canvas id="line-chart" height="150"></canvas>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <h4 class="card-title"><?php echo app('translator')->get('Package Sale Statistics'); ?></h4>
                                <div>
                                    <canvas id="pie-chart" height="280"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>



        <div class="row admin-fa_icon">
            <div class="col-md-12">
                <h4 class="card-title"><?php echo app('translator')->get('Tickets'); ?></h4>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($tickets['closed'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Closed Ticket'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-times-circle"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($tickets['replied'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Replied Ticket'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-inbox"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($tickets['answered'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Answered Ticket'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-check"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo e(number_format($tickets['pending'])); ?></h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate"><?php echo app('translator')->get('Pending Ticket'); ?></h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-2x fa-spinner"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(adminAccessRoute(config('role.user_management.access.view'))): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo app('translator')->get('Latest User'); ?></h4>
                            <div class="table-responsive">
                                <table class="categories-show-table table table-hover table-striped table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col"><?php echo app('translator')->get('User'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Email'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Profile Complete'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Profile Status'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                                        <?php if(adminAccessRoute(config('role.user_management.access.edit'))): ?>
                                            <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $latestUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td data-label="<?php echo app('translator')->get('User'); ?>">
                                                <a href="<?php echo e(route('admin.user-edit',[$user->id])); ?>" target="_blank">
                                                    <div class="d-flex no-block align-items-center">
                                                        <div class="mr-3"><img src="<?php echo e(getFile(config('location.user.path').$user->image)); ?>" alt="<?php echo app('translator')->get('user image'); ?>" class="rounded-circle" width="45" height="45"></div>
                                                        <div class="">
                                                            <h5 class="text-dark mb-0 font-16 font-weight-medium"><?php echo app('translator')->get($user->firstname); ?> <?php echo app('translator')->get($user->lastname); ?></h5>
                                                            <span class="text-muted font-14"><span>@</span><?php echo app('translator')->get($user->username); ?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td data-label="<?php echo app('translator')->get('Email'); ?>"><?php echo app('translator')->get($user->email); ?></td>
                                            <?php
                                                $sss = \App\Models\ProfileInfo::where('user_id',$user->id)->first();
                                                $getStep = collect($sss)->except(['residency_information','attitude_behavior','id','user_id','created_at','updated_at','status','astronomic_info']);
                                                $totalStep = count($getStep);
                                                $filtered = $getStep->values()->filter(function ($value, $key){
                                                    return $value > 0;
                                                });
                                                $complete = count($filtered->all());
                                                $profileComplete = $totalStep == 0 ? 0 : round(($complete*100/$totalStep), 2);
                                            ?>

                                            <td data-label="<?php echo app('translator')->get('Profile Complete'); ?>">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="<?php echo e($profileComplete); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($profileComplete); ?>%"><?php echo e($profileComplete); ?>%</div>
                                                </div>
                                            </td>
                                            <td data-label="<?php echo app('translator')->get('Profile Status'); ?>">
                                                <span
                                                    class="badge badge-pill <?php echo e(optional($user->profileInfo)->status == 0 ? 'badge-danger' : 'badge-success'); ?>"><?php echo e(optional($user->profileInfo)->status == 0 ? 'Pending' : 'Approved'); ?></span>
                                            </td>
                                            <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                            <span
                                                class="badge badge-pill <?php echo e($user->status == 0 ? 'badge-danger' : 'badge-success'); ?>"><?php echo e($user->status == 0 ? 'Inactive' : 'Active'); ?></span>
                                            </td>
                                            <?php if(adminAccessRoute(config('role.user_management.access.edit'))): ?>
                                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                                    <div class="dropdown show">
                                                        <a class="dropdown-toggle p-3" href="#" id="dropdownMenuLink"
                                                           data-toggle="dropdown"
                                                           aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item"
                                                               href="<?php echo e(route('admin.user-edit',$user->id)); ?>">
                                                                <i class="fa fa-edit text-warning pr-2"
                                                                   aria-hidden="true"></i> <?php echo app('translator')->get('Edit'); ?>
                                                            </a>

                                                            <a class="dropdown-item"
                                                               href="<?php echo e(route('admin.send-email',$user->id)); ?>">
                                                                <i class="fa fa-envelope text-success pr-2"
                                                                   aria-hidden="true"></i> <?php echo app('translator')->get('Send Email'); ?>
                                                            </a>

                                                            <?php if(optional($user->profileInfo)->status == 0): ?>
                                                                <a href="javascript:void(0)"
                                                                data-route="<?php echo e(route('admin.profile-approve',$user->id)); ?>"
                                                                data-toggle="modal"
                                                                data-target="#approve-modal"
                                                                class="dropdown-item btn btn-danger btn-sm approve-confirm">
                                                                    <i class="fa fa-user text-primary pr-2" aria-hidden="true"></i> <?php echo app('translator')->get('Approve Profile'); ?>
                                                                </a>
                                                            <?php else: ?>
                                                                <a href="javascript:void(0)"
                                                                data-route="<?php echo e(route('admin.profile-pending',$user->id)); ?>"
                                                                data-toggle="modal"
                                                                data-target="#pending-modal"
                                                                class="dropdown-item btn btn-danger btn-sm pending-confirm">
                                                                    <i class="fa fa-user text-danger pr-2" aria-hidden="true"></i> <?php echo app('translator')->get('Make Profile Pending'); ?>
                                                                </a>
                                                            <?php endif; ?>

                                                            <a class="dropdown-item loginAccount" href="javascript:void(0)"
                                                                data-toggle="modal"
                                                                data-target="#signIn"
                                                                data-route="<?php echo e(route('admin.login-as-user',$user->id)); ?>">
                                                                <i class="fas fa-sign-in-alt text-success pr-2"
                                                                aria-hidden="true"></i> <?php echo app('translator')->get('Login as User'); ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td class="text-center text-danger" colspan="7"><?php echo app('translator')->get('No User Data'); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>


    <?php if($basic->is_active_cron_notification): ?>
        <div class="modal fade" id="cron-info" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-primary">
                        <h5 class="modal-title">
                            <i class="fas fa-info-circle"></i>
                            <?php echo app('translator')->get('Cron Job Set Up Instruction'); ?>
                        </h5>
                        <button type="button" class="close cron-notification-close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="bg-orange text-white p-2">
                                    <i><?php echo app('translator')->get('**To sending emails and sms  automatically you need to setup cron job in your server. Make sure your job is running properly. We insist to set the cron job time as minimum as possible.**'); ?></i>
                                </p>
                            </div>
                            <div class="col-md-12 form-group">
                                <label><strong><?php echo app('translator')->get('Command for Email & SMS'); ?></strong></label>
                                <div class="input-group ">
                                    <input type="text" class="form-control copyText"
                                           value="curl -s <?php echo e(route('queue.work')); ?>" disabled>
                                    <div class="input-group-append">
                                        <button class="input-group-text bg-primary btn btn-primary text-white copy-btn">
                                            <i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center">
                                <p class="bg-dark text-white p-2">
                                    <?php echo app('translator')->get('*To turn off this pop up go to '); ?>
                                    <a href="<?php echo e(route('admin.basic-controls')); ?>"
                                       class="text-orange"><?php echo app('translator')->get('Basic control'); ?></a>
                                    <?php echo app('translator')->get(' and disable `Cron Set Up Pop Up`.*'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>



    <!-- User Profile Approve Modal -->
    <div id="approve-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel"><?php echo app('translator')->get('Approve User\'s Profile Confirmation'); ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you sure to approve this profile?'); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <form action="" method="post" class="approveRoute">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('put'); ?>
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Yes'); ?></button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- User Profile Pending Modal -->
    <div id="pending-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel"><?php echo app('translator')->get('Pending User\'s Profile Confirmation'); ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you sure to make this profile pending?'); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <form action="" method="post" class="pendingRoute">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('put'); ?>
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Yes'); ?></button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- Admin Login as a User Modal -->
    <div class="modal fade" id="signIn">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="" class="loginAccountAction" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <!-- Modal Header -->
                    <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title"><?php echo app('translator')->get('Sing In Confirmation'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p><?php echo app('translator')->get('Are you sure to sign in this account?'); ?></p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('Close'); ?></span>
                        </button>
                        <button type="submit" class=" btn btn-primary "><span><?php echo app('translator')->get('Yes'); ?></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('assets/admin/js/Chart.min.js')); ?>"></script>

    <script>
        "use strict";
        new Chart(document.getElementById("line-chart"), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($statistics['schedule']->keys(), 15, 512) ?>,
                datasets: [{
                    data: <?php echo json_encode($statistics['monthlyPayments']->values(), 15, 512) ?>,
                    label: "Payments",
                    borderColor: "#6fbbff",
                    fill: false
                }
                ]
            }
        });


        new Chart(document.getElementById("pie-chart"), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($pieLog->pluck('level'), 15, 512) ?>,
                datasets: [{
                    backgroundColor: ["#6fbbff", "#ff6f62", "#05ffe4", "#98df8a", "#8b6ef3", "#f9dd7e", "#f34da3"],
                    data:  <?php echo json_encode($pieLog->pluck('value'), 15, 512) ?>,
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function (tooltipItems, data) {
                            return data.labels[tooltipItems.index] + ': ' + data.datasets[0].data[tooltipItems.index] + '%';
                        }
                    }

                }
            }
        });


        $(document).on('click', '#details', function () {
            var title = $(this).data('servicetitle');
            var description = $(this).data('description');
            $('#title').text(title);
            $('#servicedescription').text(description);
        });

        $(document).ready(function () {
            let isActiveCronNotification = '<?php echo e($basic->is_active_cron_notification); ?>';
            if (isActiveCronNotification == 1)
                $('#cron-info').modal('show');
            $(document).on('click', '.copy-btn', function () {
                var _this = $(this)[0];
                var copyText = $(this).parents('.input-group-append').siblings('input');
                $(copyText).prop('disabled', false);
                copyText.select();
                document.execCommand("copy");
                $(copyText).prop('disabled', true);
                $(this).text('Coppied');
                setTimeout(function () {
                    $(_this).text('');
                    $(_this).html('<i class="fas fa-copy"></i>');
                }, 500)
            });
        })


        // for user profile active/pending
        $(document).ready(function () {
            $('.approve-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.approveRoute').attr('action', route)
            })
            $('.pending-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.pendingRoute').attr('action', route)
            })
        });

        // for login as user
        $(document).on('click', '.loginAccount', function () {
            var route = $(this).data('route');
            $('.loginAccountAction').attr('action', route)
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>