
<x-default-layout>
    <div class="container-xxl mt-6">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-header bg-gradient-primary text-white rounded-top-4 py-4 px-4 d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0 fw-bold"><i class="bi bi-cash-stack me-2"></i>Manajemen Pembayaran</h3>
                        
                    </div>
                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fs-8">#</th>
                                        <th class="fs-8">Kursus</th>
                                        <th class="fs-8">Peserta</th>
                                        <th class="fs-8">Jumlah</th>
                                        <th class="fs-8">Jenis</th>
                                        <th class="fs-8">Tanggal</th>
                                        <th class="fs-8">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payments as $payment)
                                        <tr>
                                            <td class="fs-8 text-muted">{{ $loop->iteration }}</td>
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
                                                                $sAvatar = $student->user && $student->user->avatar
                                                                    ? asset('storage/'.$student->user->avatar)
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
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">Belum ada pembayaran.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if(method_exists($payments, 'links'))
                            <div class="mt-4 d-flex justify-content-center">
                                {{ $payments->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .card {
            border-radius: 1.25rem !important;
        }
        .card-header {
            border-radius: 1.25rem 1.25rem 0 0 !important;
        }
        .card-footer {
            border-radius: 0 0 1.25rem 1.25rem !important;
        }
        .btn-light-primary {
            background: linear-gradient(90deg, #e3f0ff 0%, #f6fafd 100%);
            color: #009ef7;
            border: none;
        }
        .btn-light-primary:hover {
            background: #009ef7;
            color: #fff;
        }
        .fs-8 { font-size: 0.85rem !important; }
        .me-n2 { margin-right: -0.5rem !important; }
    </style>
</x-default-layout>