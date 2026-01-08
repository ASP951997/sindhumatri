<div class="col-lg-3">
    <div class="sidebar">
        <div class="profile">
			<div class="img-box">
            <?php if(auth()->user()->image != NULL): ?>
                <img src="<?php echo e(getFile(config('location.user.path').auth()->user()->image)); ?>" class="img-fluid" alt="<?php echo app('translator')->get('user profile'); ?>"/>
			<div class="hover-content cursorDefault">
                                                    
													<div class="text-box position-absolute top-50 start-20">
									<a href="<?php echo e(getFile(config('location.user.path').auth()->user()->image)); ?>" data-fancybox="single" class="mx-2 iconHoverBg">
										<i class="fas fa-expand"></i>
									</a>
								</div>
                                                </div>
            <?php else: ?>
                <img src="<?php echo e(getFile(config('location.default'))); ?>" class="img-fluid" alt="<?php echo app('translator')->get('default image'); ?>">
			<div class="hover-content cursorDefault">
                                                    
													<div class="text-box position-absolute top-50 start-20">
									<a href="<?php echo e(getFile(config('location.default'))); ?>" data-fancybox="single" class="mx-2 iconHoverBg">
										<i class="fas fa-expand"></i>
									</a>
								</div>
                                                </div>
            <?php endif; ?>
			
                                </div>
            <h5><?php echo app('translator')->get(auth()->user()->username); ?></h5>
			<h5><?php echo app('translator')->get(auth()->user()->member_id); ?></h5>
        </div>

        <ul>
            <li class="<?php echo e(menuActive('user.home')); ?>">
                <a href="<?php echo e(route('user.home')); ?>">
                    <i class="fal fa-home-alt"></i><?php echo app('translator')->get('dashboard'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive('user.gallery')); ?>">
                <a href="<?php echo e(route('user.gallery')); ?>">
                    <i class="fal fa-image"></i><?php echo app('translator')->get('gallery'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive(['user.story', 'user.story.create', 'user.story.edit*'])); ?>">
                <a href="<?php echo e(route('user.story')); ?>">
                    <i class="fal fa-calendar-star"></i><?php echo app('translator')->get('Manage story'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive(['user.myPlans', 'user.purchased.plan.search'])); ?>">
                <a href="<?php echo e(route('user.myPlans')); ?>">
                    <i class="far fa-cart-plus"></i><?php echo app('translator')->get('Purchased Packages'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive(['user.fund-history', 'user.fund-history.search'])); ?>">
                <a href="<?php echo e(route('user.fund-history')); ?>">
                    <i class="fas fa-money-check-alt"></i><?php echo app('translator')->get('Payment History'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive(['user.shortlist.show','user.shortlist.search'])); ?>">
                <a href="<?php echo e(route('user.shortlist.show')); ?>">
                    <i class="fal fa-list-ul"></i><?php echo app('translator')->get('shortlist'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive(['user.interest.show', 'user.interest.search'])); ?>">
                <a href="<?php echo e(route('user.interest.show')); ?>">
                    <i class="fal fa-heart"></i><?php echo app('translator')->get('My Interest'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive(['user.ignore.show', 'user.ignore.search'])); ?>">
                <a href="<?php echo e(route('user.ignore.show')); ?>">
                    <i class="fal fa-ban"></i><?php echo app('translator')->get('Ignored List'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive('user.matched.profile')); ?>">
                <a href="<?php echo e(route('user.matched.profile')); ?>">
                    <i class="fas fa-handshake"></i><?php echo app('translator')->get('Matched Profile'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive('user.profile')); ?>">
                <a href="<?php echo e(route('user.profile')); ?>">
                    <i class="far fa-user-cog"></i><?php echo app('translator')->get('Manage Profile'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive('user.messenger')); ?>">
                <a href="<?php echo e(route('user.messenger')); ?>">
                    <i class="fal fa-envelope"></i><?php echo app('translator')->get('Messages'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive(['user.ticket.list', 'user.ticket.create', 'user.ticket.view*'])); ?>">
                <a href="<?php echo e(route('user.ticket.list')); ?>">
                    <i class="fas fa-user-headset"></i><?php echo app('translator')->get('Support Ticket'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive('user.change.password')); ?>">
                <a href="<?php echo e(route('user.change.password')); ?>">
                    <i class="fas fa-lock-alt"></i><?php echo app('translator')->get('Change password'); ?>
                </a>
            </li>

            <li class="<?php echo e(menuActive(['user.twostep.security'])); ?>">
                <a href="<?php echo e(route('user.twostep.security')); ?>">
                    <i class="fas fa-user-lock"></i><?php echo app('translator')->get('2FA Security'); ?>
                </a>
            </li>

            <li class="">
                <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                document.getElementById('userLogout-form').submit();">
                    <i class="far fa-power-off"></i><?php echo app('translator')->get('Logout'); ?>
                </a>
            </li>
            <form id="userLogout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                <?php echo csrf_field(); ?>
            </form>

        </ul>
    </div>
</div>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/user/sidebar.blade.php ENDPATH**/ ?>