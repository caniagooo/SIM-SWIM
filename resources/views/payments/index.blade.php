<x-default-layout>

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-xxl" id="kt_content_container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Pembayaran</h3>
                    <div class="card-toolbar">
                        <a href="{{ route('payments.create') }}" class="btn btn-primary">Tambah Pembayaran</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Murid</th>
                                <th>Kursus</th>
                                <th>Jumlah</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->student->user->name }}</td>
                                <td>{{ $payment->course->name ?? '-' }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst($payment->type) }}</td>
                                <td>{{ $payment->payment_date }}</td>
                                <td>
                                    <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</x-default-layout>