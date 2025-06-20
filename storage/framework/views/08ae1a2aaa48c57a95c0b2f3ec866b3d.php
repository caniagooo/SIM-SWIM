<!--begin::Header-->
<div id="kt_app_header" class="app-header">
	<!--begin::Header container-->
	<div class="app-container container-xxl d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
		<!--begin::Logo-->
		<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
			<a href="<?php echo e(route('dashboard')); ?>">
				<img alt="Logo" src="<?php echo e(image('logos/default-dark.svg')); ?>" class="h-20px h-lg-30px app-sidebar-logo-default" />
			</a>
		</div>
		<!--end::Logo-->
		<!--begin::Header wrapper-->
		<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
			<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/header-layout/header/_menu/_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/header-layout/header/_navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		<!--end::Header wrapper-->
	</div>
	<!--end::Header container-->
</div>
<!--end::Header-->
<?php /**PATH C:\Users\JITU\swim\resources\views\layout\partials\header-layout\_header.blade.php ENDPATH**/ ?>