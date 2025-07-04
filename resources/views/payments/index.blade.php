<x-default-layout>
<div class="container py-3">
    <!-- Header Card -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 p-4">
            <div>
                <h4 class="mb-1 fw-bold text-gray-900">
                    Manajemen Pembayaran
                </h4>
                <div class="d-flex flex-wrap gap-2 small mb-1">
                    <span class="badge badge-light-info fw-semibold">
                        <i class="bi bi-cash-stack me-1"></i> Total: {{ $payments->count() }} Pembayaran
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="row g-2 mb-4">
        <div class="col-12 col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Cari pembayaran...">
            </div>
        </div>
        <div class="col-8 col-md-4">
            <select id="filter-status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="paid">Lunas</option>
                <option value="pending">Pending</option>
                <option value="failed">Gagal</option>
            </select>
        </div>
        <div class="col-4 col-md-2">
            <button id="clear-filter" class="btn btn-light-danger btn-sm w-100">
                <i class="bi bi-x"></i> Reset
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="col-12">
        <div class="px-5 py-5 card card-flush border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="payments_table" class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                        <thead>
                            <tr class="text-center fw-semibold text-gray-600 fs-7">
                                <th>#</th>
                                <th>Kursus</th>
                                <th>Peserta</th>
                                <th>Jumlah</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                            <tr>
                                <td class="text-center text-gray-500 fs-8">{{ $loop->iteration }}</td>
                                <td class="fs-8">
                                    @if($payment->course)
                                        <a href="{{ route('courses.show', $payment->course->id) }}">
                                            {{ $payment->course->name }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="fs-8">
                                    <div class="d-flex align-items-center">
                                        @if($payment->course && $payment->course->students)
                                            @foreach($payment->course->students->take(5) as $student)
                                                @php
                                                    $sAvatar = $student->user && $student->user->profile_photo_path
                                                        ? asset('storage/'.$student->user->profile_photo_path)
                                                        : asset('assets/media/avatars/default-avatar.png');
                                                @endphp
                                                <img src="{{ $sAvatar }}" alt="Peserta" class="rounded-circle border me-n2" width="24" height="24" title="{{ $student->user->name ?? '' }}">
                                            @endforeach
                                            @if($payment->course->students->count() > 5)
                                                <span class="badge bg-light text-muted ms-1">+{{ $payment->course->students->count() - 5 }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="fs-8 fw-bold text-success">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="fs-8">
                                    <span class="badge bg-{{ $payment->type == 'dp' ? 'info' : 'success' }} text-white">
                                        {{ strtoupper($payment->type) }}
                                    </span>
                                </td>
                                <td class="fs-8">{{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d M Y') }}</td>
                                <td class="fs-8">
                                    <span class="badge bg-{{ $payment->status == 'paid' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }} text-white">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-icon btn-sm btn-light-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Compact Footer -->
                <div id="payments_table_footer" class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2 px-2 py-1 small">
                    <div id="payments_table_info" class="text-gray-600"></div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0">Tampil
                            <select id="payments_table_length" class="form-select form-select-sm d-inline-block w-auto mx-1" style="min-width: 50px;">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            data
                        </label>
                        <div id="payments_table_paginate"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fs-8 { font-size: 0.88rem !important; }
    .me-n2 { margin-right: -0.5rem !important; }
    #payments_table_footer select { min-width: 50px; }
    #payments_table_footer { font-size: 0.93rem; }
    @media (max-width: 576px) {
        .card-body, .card-header { padding: 1rem !important; }
        .table { font-size: 0.92rem; }
        #payments_table_footer { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
    }
</style>
@push('scripts')
    <script src="{{ asset('assets/js/payments-index.js') }}"></script>
@endpush
</x-default-layout>