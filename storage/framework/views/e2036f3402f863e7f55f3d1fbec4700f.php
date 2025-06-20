<!--begin::Header-->
<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
	<!--begin::Header container-->
	<div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
		<!--begin::Sidebar mobile toggle-->
		<div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
			<div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle"><?php echo getIcon('abstract-14', 'fs-2 fs-md-1'); ?></div>
		</div>
		<!--end::Sidebar mobile toggle-->
		<!--begin::Mobile logo-->
		<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
			<a href="<?php echo e(route('dashboard')); ?>" class="d-lg-none">
				<img alt="Logo" src="<?php echo e(image('logos/ayoberenang.png')); ?>" class="h-30px" />
			</a>
		</div>
		<!--end::Mobile logo-->
		<!--begin::Header wrapper-->
		<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
			<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/header/_menu/_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/header/_navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		<!--end::Header wrapper-->
	</div>
	<!--end::Header container-->
</div>
<!--end::Header-->
<?php /**PATH C:\Users\JITU\swim\resources\views/layout/partials/sidebar-layout/_header.blade.php ENDPATH**/ ?>