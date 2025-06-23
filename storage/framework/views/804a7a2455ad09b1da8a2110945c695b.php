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
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7 col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-gray-900 mb-3">
                            Ubah Status Pembayaran
                        </h4>
                        <form action="<?php echo e(route('payments.update', $payment->id)); ?>" method="POST" id="form-update-payment-status">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status Pembayaran</label>
                                <select name="status" class="form-select form-select-sm" required>
                                    <option value="paid" <?php echo e($payment->status == 'paid' ? 'selected' : ''); ?>>Paid</option>
                                    <option value="pending" <?php echo e($payment->status == 'pending' ? 'selected' : ''); ?>>Unpaid</option>
                                    <option value="failed" <?php echo e($payment->status == 'failed' ? 'selected' : ''); ?>>Canceled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan (opsional)</label>
                                <input type="text" name="notes" class="form-control form-control-sm" value="<?php echo e($payment->notes ?? ''); ?>">
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="<?php echo e(route('payments.index')); ?>" class="btn btn-light btn-sm">
                                    <i class="bi bi-arrow-left"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary btn-sm" id="confirmUpdatePaymentButton">
                                    <i class="bi bi-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .form-label { font-size: 0.97rem; }
        .form-select-sm, .form-control-sm { font-size: 0.95rem; }
        .card { border-radius: 1.25rem !important; }
        .btn-sm { font-size: 0.93rem; }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $attributes = $__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $component = $__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views\payments\edit.blade.php ENDPATH**/ ?>