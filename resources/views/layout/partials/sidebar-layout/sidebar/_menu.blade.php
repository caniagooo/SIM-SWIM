<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
	<!--begin::Menu wrapper-->
	<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
		<!--begin::Menu-->
		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
			<!--begin:Menu item-->
			<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('dashboard') ? 'here show' : '' }}">
				<!--begin:Menu link-->
				<span class="menu-link">
					<span class="menu-icon">{!! getIcon('element-11', 'fs-2') !!}</span>
					<span class="menu-title">Dashboard</span>
				</span>
				<!--end:Menu link-->
				<div class="menu-sub menu-sub-accordion">
					<div class="menu-item">
						<a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">Default</span>
						</a>
					</div>
				</div>
			</div>
			<!--end:Menu item-->

			<!--begin:Menu item-->
			<div class="menu-item pt-5">
				<div class="menu-content">
					<span class="menu-heading fw-bold text-uppercase fs-7">Manajemen</span>
				</div>
			</div>
			<!--end:Menu item-->

			<!--begin:Menu item-->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('venues.*') ? 'active' : '' }}" href="{{ route('venues.index') }}">
					<span class="menu-icon">{!! getIcon('map', 'fs-2') !!}</span>
					<span class="menu-title">Venue</span>
				</a>
			</div>
			<!--end:Menu item-->

			<!--begin:Menu item-->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">
					<span class="menu-icon">{!! getIcon('book', 'fs-2') !!}</span>
					<span class="menu-title">Courses</span>
				</a>
			</div>
			<!--end:Menu item-->

			<!--begin:Menu item-->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('trainers.*') ? 'active' : '' }}" href="{{ route('trainers.index') }}">
					<span class="menu-icon">{!! getIcon('user', 'fs-2') !!}</span>
					<span class="menu-title">Trainers</span>
				</a>
			</div>
			<!--end:Menu item-->

			<!--begin:Menu item-->
			<div class="menu-item menu-accordion {{ request()->routeIs('students.*', 'payments.*') ? 'here show' : '' }}">
				<span class="menu-link">
					<span class="menu-icon">{!! getIcon('users', 'fs-2') !!}</span>
					<span class="menu-title">Manajemen Murid</span>
					<span class="menu-arrow"></span>
				</span>
				<div class="menu-sub menu-sub-accordion">
					<div class="menu-item">
						<a class="menu-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">Students</span>
						</a>
					</div>
					<div class="menu-item">
						<a class="menu-link {{ request()->routeIs('payments.*') ? 'active' : '' }}" href="{{ route('payments.index') }}">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">Payments</span>
						</a>
					</div>
				</div>
			</div>
			<!--end:Menu item-->

			<!--begin:Menu item-->
			<div class="menu-item pt-5">
				<div class="menu-content">
					<span class="menu-heading fw-bold text-uppercase fs-7">User Management</span>
				</div>
			</div>
			<!--end:Menu item-->

			<!--begin:Menu item-->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('user-management.users.*') ? 'active' : '' }}" href="{{ route('user-management.users.index') }}">
					<span class="menu-icon">{!! getIcon('abstract-28', 'fs-2') !!}</span>
					<span class="menu-title">Users</span>
				</a>
			</div>
			<!--end:Menu item-->

			<!--begin:Menu item-->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('user-management.roles.*') ? 'active' : '' }}" href="{{ route('user-management.roles.index') }}">
					<span class="menu-icon">{!! getIcon('shield', 'fs-2') !!}</span>
					<span class="menu-title">Roles</span>
				</a>
			</div>
			<!--end:Menu item-->

			<!--begin:Menu item-->
			<div class="menu-item">
				<a class="menu-link {{ request()->routeIs('user-management.permissions.*') ? 'active' : '' }}" href="{{ route('user-management.permissions.index') }}">
					<span class="menu-icon">{!! getIcon('key', 'fs-2') !!}</span>
					<span class="menu-title">Permissions</span>
				</a>
			</div>
			<!--end:Menu item-->

		</div>
		<!--end::Menu-->
	</div>
	<!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
