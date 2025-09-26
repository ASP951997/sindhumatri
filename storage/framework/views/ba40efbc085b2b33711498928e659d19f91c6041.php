<?php if(session()->has('success')): ?>
    <script>
        Notiflix.Notify.Success("<?php echo app('translator')->get(session('success')); ?>");
    </script>
<?php endif; ?>

<?php if(session()->has('error')): ?>
    <script>
        Notiflix.Notify.Failure("<?php echo app('translator')->get(session('error')); ?>");
    </script>
<?php endif; ?>

<?php if(session()->has('warning')): ?>
    <script>
        Notiflix.Notify.Warning("<?php echo app('translator')->get(session('warning')); ?>");
    </script>
<?php endif; ?>


<?php /**PATH E:\RSL_Intern_T\Matrimony\resources\views/themes/deepblue/partials/notification.blade.php ENDPATH**/ ?>