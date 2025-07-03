<x-default-layout>
<div class="container py-3">
    <div class="card card-flush border-0 shadow-sm rounded-4">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 py-4">
            <h3 class="fw-bold mb-0">
                Riwayat Pembayaran - {{ $student->user->name }}
            </h3>
            <a href="{{ route('students.show', $student->id) }}" class="btn btn-light-primary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                    <thead>
                        <tr class="fw-bold text-gray-700 fs-7 text-center align-middle">
                            <th class="text-center align-middle" style="width: 40px;">#</th>
                            <th class="text-start align-middle">Kursus</th>
                            <th class="text-center align-middle" style="width: 120px;">Jumlah</th>
                            <th class="text-center align-middle" style="width: 100px;">Jenis</th>
                            <th class="text-center align-middle" style="width: 120px;">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-start">{{ $payment->course->name ?? '-' }}</td>
                            <td class="text-center">{{ number_format($payment->amount, 2) }}</td>
                            <td class="text-center">{{ ucfirst($payment->type) }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada pembayaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-default-layout>
<style>
    .card { border-radius: 1.25rem !important; }
    .fw-bold { font-weight: 600 !important; }
    .fw-semibold { font-weight: 500 !important; }
    .table th, .table td { vertical-align: middle !important; }
    .table th { text-align: center !important; }
    .table td { font-size: 0.97rem; }
    @media (max-width: 576px) {
        .card-body, .card-header { padding: 1rem !important; }
        .table { font-size: 0.875rem; }
    }
</style>