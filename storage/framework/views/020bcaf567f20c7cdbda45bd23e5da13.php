<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
	<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/sidebar/_logo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/sidebar/_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/sidebar/_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	
</div>
<!--end::Sidebar-->
<?php /**PATH C:\Users\JITU\swim\resources\views/layout/partials/sidebar-layout/_sidebar.blade.php ENDPATH**/ ?>