<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <!--begin:Menu item-->
            <div class="menu-item">
                <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <span class="menu-icon">{!! getIcon('graph', 'fs-2') !!}</span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item menu-accordion {{ request()->routeIs('students.*', 'payments.*') ? 'here show' : '' }}" data-kt-menu-trigger="click">
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('badge', 'fs-2') !!}</span>
                    <span class="menu-title">Murid</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <!-- Menu Students -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('students.index') ? 'active' : '' }}" href="{{ route('students.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Daftar Murid</span>
                        </a>
                    </div>
                    <!-- Menu Payments -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('payments.index') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pembayaran</span>
                        </a>
                    </div>
                </div>
            </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item menu-accordion {{ request()->routeIs('courses.*', 'materials.*') ? 'here show' : '' }}" data-kt-menu-trigger="click">
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('questionnaire-tablet', 'fs-2') !!}</span>
                    <span class="menu-title">Kursus</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <!-- Menu Daftar Kursus -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Daftar Kursus</span>
                        </a>
                    </div>

                    <!-- Menu Materi Kursus -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('materials.*') ? 'active' : '' }}" href="{{ route('materials.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Materi Kursus</span>
                        </a>
                    </div>

                </div>
            </div>
            <!--end:Menu item-->


            <!--begin:Menu item-->
            <div class="menu-item menu-accordion {{ request()->routeIs('trainers.*', 'venues.*') ? 'here show' : '' }}" data-kt-menu-trigger="click">
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('teacher', 'fs-2',) !!}</span>
                    <span class="menu-title">Club</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <!-- Menu Trainer -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('trainers.*') ? 'active' : '' }}" href="{{ route('trainers.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pelatih</span>
                        </a>
                    </div>

                    <!-- Menu Materi Venue -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('venues.*') ? 'active' : '' }}" href="{{ route('venues.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Venue</span>
                        </a>
                    </div>

                </div>
            </div>
            <!--end:Menu item-->


            <!--begin:Menu item-->
            <div class="menu-item menu-accordion {{ request()->routeIs('user-management.*') ? 'here show' : '' }}" data-kt-menu-trigger="click">
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('user-tick', 'fs-2') !!}</span>
                    <span class="menu-title">Admin Menu</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <!-- Menu Users -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('user-management.users.*') ? 'active' : '' }}" href="{{ route('user-management.users.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Users</span>
                        </a>
                    </div>
                    <!-- Menu Roles -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('user-management.roles.*') ? 'active' : '' }}" href="{{ route('user-management.roles.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Roles</span>
                        </a>
                    </div>
                    <!-- Menu Permissions -->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('user-management.permissions.*') ? 'active' : '' }}" href="{{ route('user-management.permissions.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Permissions</span>
                        </a>
                    </div>
                </div>
            </div>
            <!--end:Menu item-->
        
            
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
