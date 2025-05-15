<x-default-layout>

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-xxl" id="kt_content_container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Detail Murid</h3>
                    <div class="card-toolbar">
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('students.show') ? 'active' : '' }}" href="{{ route('students.show', $student->id) }}">Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('students.payments') ? 'active' : '' }}" href="{{ route('students.payments', $student->id) }}">Payments</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @yield('tab-content')
                    </div>
                    <h4>Informasi Murid</h4>
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $student->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $student->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{ $student->birth_date }}</td>
                        </tr>
                        <tr>
                            <th>Kelompok Usia</th>
                            <td>{{ ucfirst($student->age_group) }}</td>
                        </tr>
                    </table>

                    <h4 class="mt-5">Riwayat Pembayaran</h4>
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