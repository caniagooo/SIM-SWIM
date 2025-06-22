<x-default-layout>
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7 col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-gray-900 mb-3">
                            Ubah Status Pembayaran
                        </h4>
                        <form action="{{ route('payments.update', $payment->id) }}" method="POST" id="form-update-payment-status">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status Pembayaran</label>
                                <select name="status" class="form-select form-select-sm" required>
                                    <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Canceled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan (opsional)</label>
                                <input type="text" name="notes" class="form-control form-control-sm" value="{{ $payment->notes ?? '' }}">
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('payments.index') }}" class="btn btn-light btn-sm">
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
</x-default-layout>