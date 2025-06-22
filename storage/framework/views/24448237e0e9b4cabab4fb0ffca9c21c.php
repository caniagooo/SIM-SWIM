<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!--begin::Col-->
        <div class="col-md-4">
            <!--begin::Card-->
            <div class="card card-flush h-md-100">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2><?php echo e(ucwords($role->name)); ?></h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-1">
                    <!--begin::Users-->
                    <div class="fw-bold text-gray-600 mb-5">Total users with this role: <?php echo e($role->users->count()); ?></div>
                    <!--end::Users-->
                    <!--begin::Permissions-->
                    <div class="d-flex flex-column text-gray-600">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $role->permissions->shuffle()->take(5) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span><?php echo e(ucfirst($permission->name)); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($role->permissions->count() > 5): ?>
                            <div class='d-flex align-items-center py-2'>
                                <span class='bullet bg-primary me-3'></span>
                                <em>and <?php echo e($role->permissions->count()-5); ?> more...</em>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php if($role->permissions->count() ===0): ?>
                            <div class="d-flex align-items-center py-2">
                                <span class='bullet bg-primary me-3'></span>
                                <em>No permissions given...</em>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <!--end::Permissions-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer flex-wrap pt-0">
                    <a href="<?php echo e(route('user-management.roles.show', $role)); ?>" class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
                    <button type="button" class="btn btn-light btn-active-light-primary my-1" data-role-id="<?php echo e($role->name); ?>" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Edit Role</button>
                </div>
                <!--end::Card footer-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

    <!--begin::Add new card-->
    <div class="ol-md-4">
        <!--begin::Card-->
        <div class="card h-md-100">
            <!--begin::Card body-->
            <div class="card-body d-flex flex-center">
                <!--begin::Button-->
                <button type="button" class="btn btn-clear d-flex flex-column flex-center" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                    <!--begin::Illustration-->
                    <img src="<?php echo e(image('illustrations/sketchy-1/4.png')); ?>" alt="" class="mw-100 mh-150px mb-7"/>
                    <!--end::Illustration-->
                    <!--begin::Label-->
                    <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                    <!--end::Label-->
                </button>
                <!--begin::Button-->
            </div>
            <!--begin::Card body-->
        </div>
        <!--begin::Card-->
    </div>
    <!--begin::Add new card-->
</div>
<?php /**PATH C:\Users\JITU\swim\resources\views/livewire/permission/role-list.blade.php ENDPATH**/ ?>