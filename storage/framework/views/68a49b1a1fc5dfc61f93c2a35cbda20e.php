
<!--begin::Search-->
<div id="kt_header_search" class="header-search d-flex align-items-stretch" data-kt-search-keypress="true"
	data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto"
	data-kt-menu-overflow="false" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
	<!--begin::Search toggle-->
	<div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
		<div
			class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px">
			<?php echo getIcon('magnifier', 'fs-2'); ?>

		</div>
	</div>
	<!--end::Search toggle-->
	<!--begin::Menu-->
	<div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
		<!--begin::Wrapper-->
		<div data-kt-search-element="wrapper">
			<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/search/partials/_form-dropdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/search/partials/_results', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/search/partials/_main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/search/partials/_empty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		<!--end::Wrapper-->
		<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/search/partials/_advanced-options', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<?php echo $__env->make(config('settings.KT_THEME_LAYOUT_DIR').'/partials/sidebar-layout/search/partials/_preferences', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>
	<!--end::Menu-->
</div>
<!--end::Search-->
<?php /**PATH C:\Users\JITU\swim\resources\views/layout/partials/sidebar-layout/search/_dropdown.blade.php ENDPATH**/ ?>