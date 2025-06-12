<?php if (isset($component)) { $__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e = $attributes; } ?>
<?php $component = App\View\Components\DefaultLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('default-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\DefaultLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Courses</h1>
            <a href="<?php echo e(route('courses.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Course
            </a>
        </div>

        <!-- Success Message -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Course Cards -->
        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $payment = $course->payment; // Relasi pembayaran kursus
                    $sessionsCompleted = $course->sessions->where('status', 'completed')->count();
                    $totalSessions = $course->sessions->count();
                    $isExpired = now()->greaterThan($course->valid_until);
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><?php echo e($course->name); ?></h5>
                        </div>
                        <div class="card-body">
                            <!-- Tipe Kursus -->
                            <p>
                                <strong>Type:</strong> 
                                <span class="badge bg-info" data-bs-toggle="tooltip" title="<?php echo e($course->students->pluck('name')->join(', ')); ?>">
                                    <?php echo e(ucfirst($course->type)); ?>

                                </span>
                            </p>

                            <!-- Tanggal Mulai dan Selesai -->
                            <p>
                                <strong>Start Date:</strong> <?php echo e($course->start_date->format('d M Y')); ?> <br>
                                <strong>End Date:</strong> 
                                <span class="badge bg-<?php echo e($isExpired ? 'danger' : 'success'); ?>">
                                    <?php echo e($course->valid_until->format('d M Y')); ?> (<?php echo e($isExpired ? 'Expired' : 'Active'); ?>)
                                </span>
                            </p>

                            <!-- Sesi -->
                            <p>
                                <strong>Sessions:</strong> <?php echo e($sessionsCompleted); ?> / <?php echo e($totalSessions); ?>

                            </p>

                            <!-- Pelatih -->
                            <p>
                                <strong>Trainer:</strong> <?php echo e($course->trainers->pluck('name')->join(', ')); ?>

                            </p>

                            <!-- Venue -->
                            <p>
                                <strong>Venue:</strong> <?php echo e($course->venue->name ?? 'N/A'); ?>

                            </p>

                            <!-- Biaya Kursus -->
                            <p>
                                <strong>Price:</strong> Rp. <?php echo e(number_format($course->price)); ?> <br>
                                <span class="badge bg-<?php echo e($payment->status === 'paid' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger')); ?>">
                                    <?php echo e(ucfirst($payment->status ?? 'Not Paid')); ?>

                                </span>
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="<?php echo e(route('courses.show', $course->id)); ?>" class="btn btn-sm btn-primary">View</a>
                            <a href="<?php echo e(route('courses.edit', $course->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
                            <?php if($payment && $payment->status === 'pending'): ?>
                                <button type="button" class="btn btn-sm btn-success btnPayNow" data-course-id="<?php echo e($course->id); ?>">Pay Now</button>
                            <?php endif; ?>
                            <form action="<?php echo e(route('courses.destroy', $course->id)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center text-muted">
                    <p>No courses available.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal untuk Konfirmasi Pembayaran -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please select the actual payment method:</p>
                    <div class="mb-3">
                        <label for="actualPaymentMethod" class="form-label">Payment Method</label>
                        <select id="actualPaymentMethod" class="form-select">
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="credit_card">Credit Card</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmPaymentButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let courseId = null;

    // Event listener untuk tombol Pay Now
    document.querySelectorAll('.btnPayNow').forEach(button => {
        button.addEventListener('click', function () {
            courseId = this.getAttribute('data-course-id');
            const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            modal.show();
        });
    });

    // Event listener untuk tombol Confirm Payment
    document.getElementById('confirmPaymentButton').addEventListener('click', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const actualPaymentMethod = document.getElementById('actualPaymentMethod').value;

        fetch(`/course-payments/process/${courseId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ payment_method: actualPaymentMethod }),
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload(); // Reload halaman untuk memuat status pembayaran terbaru
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing the payment.');
        });

        const modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
        modal.hide();
    });
});
</script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $attributes = $__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $component = $__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/courses/index.blade.php ENDPATH**/ ?>