
<x-default-layout>
    
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-xxl" id="kt_content_container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Pembayaran - {{ $student->user->name }}</h3>
                    <div class="card-toolbar">
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kursus</th>
                                <th>Jumlah</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->course->name ?? '-' }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst($payment->type) }}</td>
                                <td>{{ $payment->payment_date }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada pembayaran</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</x-default-layout>