<x-default-layout>
    <div class="container py-3">
        <!-- Header Card ala Metronic -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 p-4">
                <div>
                    <h4 class="mb-1 fw-bold text-gray-900">
                        Manajemen Trainer
                    </h4>
                    <div class="d-flex flex-wrap gap-2 small mb-1">
                        <span class="badge badge-light-info fw-semibold">
                            <i class="bi bi-person-badge me-1"></i> Total: {{ $trainers->count() }} Trainer
                        </span>
                    </div>
                </div>
                <div>
                    <a href="{{ route('trainers.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Trainer
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-flush border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                        <thead>
                            <tr class="text-center fw-semibold text-gray-600 fs-7">
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tipe</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainers as $trainer)
                            <tr>
                                <td class="text-center text-gray-500 fs-8">{{ $loop->iteration }}</td>
                                <td class="fs-8">{{ $trainer->user->name }}</td>
                                <td class="fs-8">{{ $trainer->user->email }}</td>
                                <td class="fs-8">{{ ucfirst($trainer->type) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('trainers.edit', $trainer->id) }}" class="btn btn-light-warning btn-sm rounded-pill px-3 me-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light-danger btn-sm rounded-pill px-3" onclick="return confirm('Yakin ingin menghapus trainer ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
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
    <style>
        .fs-8 { font-size: 0.88rem !important; }
        .rounded-pill { border-radius: 2rem !important; }
        .btn-light-warning { background: #fff8dd; color: #ffc700; border: none; }
        .btn-light-warning:hover { background: #ffe082; color: #7a5700; }
        .btn-light-danger { background: #fff5f8; color: #f1416c; border: none; }
        .btn-light-danger:hover { background: #ffe5ea; color: #a8072c; }
    </style>
</x-default-layout>