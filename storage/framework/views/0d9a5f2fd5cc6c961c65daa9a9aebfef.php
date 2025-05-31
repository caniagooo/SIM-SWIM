<link href="<?php echo e(asset('css/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />
<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <!--begin:Menu item-->
            <div class="menu-item">
                <a class="menu-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                    <span class="menu-icon"><?php echo getIcon('element-11', 'fs-2'); ?></span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item menu-accordion <?php echo e(request()->routeIs('students.*', 'payments.*') ? 'here show' : ''); ?>" data-kt-menu-trigger="click">
                <span class="menu-link">
                    <span class="menu-icon"><?php echo getIcon('user', 'fs-2'); ?></span>
                    <span class="menu-title">Manajemen Murid</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <!-- Menu Students -->
                    <div class="menu-item">
                        <a class="menu-link <?php echo e(request()->routeIs('students.index') ? 'active' : ''); ?>" href="<?php echo e(route('students.index')); ?>">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Students</span>
                        </a>
                    </div>
                    <!-- Menu Payments -->
                    <div class="menu-item">
                        <a class="menu-link <?php echo e(request()->routeIs('payments.index') ? 'active' : ''); ?>" href="<?php echo e(route('payments.index')); ?>">
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
            <div class="menu-item">
                <a class="menu-link <?php echo e(request()->routeIs('venues.*') ? 'active' : ''); ?>" href="<?php echo e(route('venues.index')); ?>">
                    <span class="menu-icon"><?php echo getIcon('map', 'fs-2'); ?></span>
                    <span class="menu-title">Venue</span>
                </a>
            </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <a class="menu-link <?php echo e(request()->routeIs('courses.*') ? 'active' : ''); ?>" href="<?php echo e(route('courses.index')); ?>">
                    <span class="menu-icon"><?php echo getIcon('book', 'fs-2'); ?></span>
                    <span class="menu-title">Courses</span>
                </a>
            </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <a class="menu-link <?php echo e(request()->routeIs('trainers.*') ? 'active' : ''); ?>" href="<?php echo e(route('trainers.index')); ?>">
                    <span class="menu-icon"><?php echo getIcon('user', 'fs-2'); ?></span>
                    <span class="menu-title">Trainers</span>
                </a>
            </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item menu-accordion <?php echo e(request()->routeIs('user-management.*') ? 'here show' : ''); ?>" data-kt-menu-trigger="click">
                <span class="menu-link">
                    <span class="menu-icon"><?php echo getIcon('abstract-28', 'fs-2'); ?></span>
                    <span class="menu-title">User Management</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <!-- Menu Users -->
                    <div class="menu-item">
                        <a class="menu-link <?php echo e(request()->routeIs('user-management.users.*') ? 'active' : ''); ?>" href="<?php echo e(route('user-management.users.index')); ?>">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Users</span>
                        </a>
                    </div>
                    <!-- Menu Roles -->
                    <div class="menu-item">
                        <a class="menu-link <?php echo e(request()->routeIs('user-management.roles.*') ? 'active' : ''); ?>" href="<?php echo e(route('user-management.roles.index')); ?>">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Roles</span>
                        </a>
                    </div>
                    <!-- Menu Permissions -->
                    <div class="menu-item">
                        <a class="menu-link <?php echo e(request()->routeIs('user-management.permissions.*') ? 'active' : ''); ?>" href="<?php echo e(route('user-management.permissions.index')); ?>">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Permissions</span>
                        </a>
                    </div>
                </div>
            </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <a class="menu-link <?php echo e(request()->routeIs('general-schedule.index') ? 'active' : ''); ?>" href="<?php echo e(route('general-schedule.index')); ?>">
                    <span class="menu-icon"><?php echo getIcon('calendar', 'fs-2'); ?></span>
                    <span class="menu-title">General Schedule</span>
                </a>
            </div>
            <!--end:Menu item-->
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
<?php /**PATH C:\Users\JITU\swim\resources\views/layout/partials/sidebar-layout/sidebar/_menu.blade.php ENDPATH**/ ?>