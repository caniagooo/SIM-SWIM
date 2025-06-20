
<!--begin::Footer-->
<div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
    <!-- User Profile -->
    <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-flex flex-center btn-custom btn-light overflow-hidden text-nowrap px-0 h-40px w-100 mb-2" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" title="View Profile">
        <span class="btn-label">Profile</span>
        <?php echo getIcon('user', 'btn-icon fs-2 m-0'); ?>

    </a>

    <!-- Logout -->
    <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-100">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-flex flex-center btn-custom btn-danger overflow-hidden text-nowrap px-0 h-40px w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" title="Logout">
            <span class="btn-label">Logout</span>
            <?php echo getIcon('logout', 'btn-icon fs-2 m-0'); ?>

        </button>
    </form>
</div>
<!--end::Footer-->
<?php /**PATH C:\Users\JITU\swim\resources\views\layout\partials\sidebar-layout\sidebar\_footer.blade.php ENDPATH**/ ?>