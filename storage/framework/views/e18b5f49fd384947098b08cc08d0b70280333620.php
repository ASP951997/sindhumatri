<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en" <?php if(session()->get('rtl') == 1): ?> dir="rtl" <?php endif; ?> >

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <?php echo $__env->make('partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'assets/bootstrap/bootstrap.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'assets/plugins/owlcarousel/animate.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'assets/plugins/owlcarousel/owl.carousel.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'assets/plugins/owlcarousel/owl.theme.default.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'assets/plugins/aos/aos.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'assets/plugins/fancybox/jquery.fancybox.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'css/jquery-ui.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'css/flag-icon.min.css')); ?>"/>
    <script src="<?php echo e(asset($themeTrue.'assets/fontawesome/fontawesomepro.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('css-lib'); ?>

    <link rel="stylesheet" href="<?php echo e(asset($themeTrue.'css/style.css')); ?>"/>

    <?php echo $__env->yieldPushContent('style'); ?>

</head>


<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo e(route('home')); ?>"><?php echo e(config('basic.site_title')); ?></a>
        <button class="navbar-toggler p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fal fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('Home'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('about')); ?>"><?php echo app('translator')->get('About'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('story')); ?>"><?php echo app('translator')->get('Story'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('plan')); ?>"><?php echo app('translator')->get('Package'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('members')); ?>"><?php echo app('translator')->get('Members'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('blog')); ?>"><?php echo app('translator')->get('Blog'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('contact')); ?>"><?php echo app('translator')->get('Contact'); ?></a>
                </li>
            </ul>
        </div>
        <span class="navbar-text">
            <?php if(auth()->guard()->guest()): ?>
                <div class="notification-panel pe-3">
                    <button class="dropdown-toggle">
                        <i class="fal fa-user-circle"></i>
                    </button>
                    <ul class="notification-dropdown userprofile">
                        <div class="dropdown-box">
                            <li>
                                <a class="dropdown-item align-items-center px-3" href="<?php echo e(route('login')); ?>">
                                    <i class="far fa-sign-in"></i>
                                    <p><?php echo app('translator')->get('Login'); ?></p>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item align-items-center px-3" href="<?php echo e(route('register')); ?>">
                                    <i class="far fa-user-plus"></i>
                                    <p><?php echo app('translator')->get('Register'); ?></p>
                                </a>
                            </li>
                        </div>
                    </ul>
                </div>
            <?php else: ?>
                <div class="notification-panel pe-3">
                    <button class="dropdown-toggle">
                        <i class="fal fa-user-circle"></i>
                    </button>
                    <ul class="notification-dropdown userprofile">
                        <div class="dropdown-box">
                            <li>
                                <a class="dropdown-item align-items-center px-3" href="<?php echo e(route('user.home')); ?>">
                                    <i class="far fa-tachometer-alt-fast"></i>
                                    <p><?php echo app('translator')->get('Dashboard'); ?></p>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item align-items-center px-3"
                                   href="<?php echo e(route('user.profile')); ?>">
                                    <i class="far fa-user-cog"></i>
                                    <p><?php echo app('translator')->get('My Profile'); ?></p>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item align-items-center px-3"
                                   href="<?php echo e(route('user.twostep.security')); ?>">
                                    <i class="fas fa-user-lock"></i>
                                    <p><?php echo app('translator')->get('2FA Security'); ?></p>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item align-items-center px-3" href="<?php echo e(route('logout')); ?>"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="far fa-power-off"></i>
                                    <p><?php echo app('translator')->get('Logout'); ?></p>
                                </a>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                      class="d-none">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </li>
                        </div>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- notification panel -->
            <?php if(auth()->guard()->check()): ?>
                <?php echo $__env->make($theme.'partials.pushNotify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            
            <?php if(!request()->routeIs('members') && !request()->routeIs('user.search.member')): ?>
                <button data-bs-toggle="modal" data-bs-target="#searchModal">
                    <i class="fal fa-search"></i>
                </button>
            <?php endif; ?>

        </span>
    </div>
</nav>


<!-- search modal -->
<div class="modal fade search-modal" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body p-0">
                <form action="<?php echo e(route('user.search.member')); ?>" method="GET">
                    <div class="row g-4">
                        <div class="col-lg-2">
                            <input type="number" name="age_from" id="age_from"
                                   value="<?php echo e(old('age_from',request()->age_from)); ?>" class="form-control" min="1" step="1"
                                   placeholder="<?php echo app('translator')->get('age from'); ?>"/>
                            <?php $__errorArgs = ['age_from'];
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
                        <div class="col-lg-2">
                            <input type="number" name="age_to" id="age_to" value="<?php echo e(old('age_to',request()->age_to)); ?>"
                                   class="form-control" min="1" step="1" placeholder="<?php echo app('translator')->get('age to'); ?>"/>
                            <?php $__errorArgs = ['age_to'];
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
                        <?php
                            $religion = \App\Models\Religion::latest()->get();
                            $maritalStatus = \App\Models\MaritalStatusDetails::latest()->get();
                        ?>
                        <div class="col-lg-2">
                            <select name="religion" class="form-select" aria-label="religion">
                                <option value="" selected><?php echo app('translator')->get('Select Religion'); ?></option>
                                <?php $__currentLoopData = $religion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($data->id); ?>" <?php echo e(old('religion',request()->religion) == $data->id ? 'selected' : ''); ?>><?php echo e($data->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['religion'];
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
                        <div class="col-lg-2">
                            <select name="marital_status" id="marital_status" class="form-select"
                                    aria-label="Maritial status">
                                <option value="" selected><?php echo app('translator')->get('Maritial Status'); ?></option>
                                <?php $__currentLoopData = $maritalStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($data->marital_status_id); ?>" <?php echo e(old('marital_status', request()->marital_status) == $data->marital_status_id ? 'selected' : ''); ?>><?php echo app('translator')->get($data->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['marital_status'];
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
                        <div class="col-lg-2">
                            <select class="form-select" name="gender" id="gender" aria-label="gender">
                                <option value="" selected><?php echo app('translator')->get('Select Gender'); ?></option>
                                <option
                                    value="Male" <?php echo e(old('gender', request()->gender) == 'Male' ? 'selected' : ''); ?>><?php echo app('translator')->get('Male'); ?></option>
                                <option
                                    value="Female" <?php echo e(old('gender', request()->gender) == 'Female' ? 'selected' : ''); ?>><?php echo app('translator')->get('Female'); ?></option>
                            </select>
                            <?php $__errorArgs = ['gender'];
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
                        <div class="col-lg-2">
                            <button type="submit" class="btn-flower"><?php echo app('translator')->get('Search'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- pre loader -->
<div id="preloader">
    <img src="<?php echo e(asset($themeTrue.'images/love.gif')); ?>" alt="<?php echo app('translator')->get('loader'); ?>" class="loader"/>
</div>

<!-- arrow up -->
<a href="#" class="scroll-up">
    <i class="fal fa-chevron-double-up"></i>
</a>


<?php echo $__env->make($theme.'partials.banner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make($theme.'partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo $__env->yieldPushContent('extra-content'); ?>


<script src="<?php echo e(asset($themeTrue.'assets/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'assets/bootstrap/masonry.pkgd.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'assets/jquery/jquery-3.6.0.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'assets/plugins/owlcarousel/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'assets/plugins/counterup/jquery.waypoints.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'assets/plugins/counterup/jquery.counterup.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'assets/plugins/aos/aos.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'assets/plugins/fancybox/jquery.fancybox.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue.'js/jquery-ui.min.js')); ?>"></script>

<?php echo $__env->yieldPushContent('extra-js'); ?>
<script src="<?php echo e(asset('assets/global/js/notiflix-aio-2.7.0.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/pusher.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/vue.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/axios.min.js')); ?>"></script>

<script src="<?php echo e(asset($themeTrue.'js/script.js')); ?>"></script>


<script>
    'use strict';
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>;
    var module = {};

    <?php if(auth()->guard()->check()): ?>
    let pushNotificationArea = new Vue({
        el: "#pushNotificationArea",
        data: {
            items: [],
        },
        mounted() {
            this.getNotifications();
            this.pushNewItem();
        },
        methods: {
            getNotifications() {
                let app = this;
                axios.get("<?php echo e(route('user.push.notification.show')); ?>")
                    .then(function (res) {
                        app.items = res.data;
                    })
            },
            readAt(id, link) {
                let app = this;
                let url = "<?php echo e(route('user.push.notification.readAt', 0)); ?>";
                url = url.replace(/.$/, id);
                axios.get(url)
                    .then(function (res) {
                        if (res.status) {
                            app.getNotifications();
                            if (link != '#') {
                                window.location.href = link
                            }
                        }
                    })
            },
            readAll() {
                let app = this;
                let url = "<?php echo e(route('user.push.notification.readAll')); ?>";
                axios.get(url)
                    .then(function (res) {
                        if (res.status) {
                            app.items = [];
                        }
                    })
            },
            pushNewItem() {
                let app = this;
                // Pusher.logToConsole = true;
                let pusher = new Pusher("<?php echo e(env('PUSHER_APP_KEY')); ?>", {
                    encrypted: true,
                    cluster: "<?php echo e(env('PUSHER_APP_CLUSTER')); ?>"
                });
                let channel = pusher.subscribe('user-notification.' + "<?php echo e(Auth::id()); ?>");
                channel.bind('App\\Events\\UserNotification', function (data) {
                    app.items.unshift(data.message);
                });
                channel.bind('App\\Events\\UpdateUserNotification', function (data) {
                    app.getNotifications();
                });
            }
        }
    });

    <?php endif; ?>
</script>

<?php echo $__env->yieldPushContent('script'); ?>


<?php echo $__env->make($theme.'partials.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('plugins', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<script>
    $(document).ready(function () {
        $(".language").find("select").change(function () {
            window.location.href = "<?php echo e(route('language')); ?>/" + $(this).val()
        })
    })
</script>

</body>

</html>
<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/layouts/user.blade.php ENDPATH**/ ?>