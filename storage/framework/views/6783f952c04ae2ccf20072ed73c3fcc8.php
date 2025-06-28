<!--begin::User account menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <!--begin::Avatar-->
            <div class="symbol symbol-50px me-5">
                <?php if(Auth::user()->profile_photo_url): ?>
                    <img alt="Logo" src="<?php echo e(Auth::user()->profile_photo_url); ?>"/>
                <?php else: ?>
                    <div class="symbol-label fs-3 <?php echo e(app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::user()->name)); ?>">
                        <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                    </div>
                <?php endif; ?>
            </div>
            <!--end::Avatar-->
            <!--begin::Username-->
            <div class="d-flex flex-column">
                <div class="fw-bold d-flex align-items-center fs-5"><?php echo e(Auth::user()->name); ?>

                    <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">
                        <?php echo e(ucfirst(Auth::user()->type)); ?>

                    </span>
                </div>
                <?php echo e(Auth::user()->email); ?>

            </div>
            <!--end::Username-->
        </div>
    </div>
    <!--end::Menu item-->
    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->
    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a href="<?php echo e(route('profile.show')); ?>" class="menu-link px-5">My Profile</a>
    </div>
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a class="button-ajax menu-link px-5" href="#" data-action="<?php echo e(route('logout')); ?>" data-method="post" data-csrf="<?php echo e(csrf_token()); ?>" data-reload="true">
            Sign Out
        </a>
    </div>
    <!--end::Menu item-->
</div>
<!--end::User account menu-->
<?php /**PATH C:\Users\JITU\swim\resources\views/partials/menus/_user-account-menu.blade.php ENDPATH**/ ?>