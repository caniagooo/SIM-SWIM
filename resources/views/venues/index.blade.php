<x-default-layout>
<div class="container py-3">
    <!-- Header Card ala Metronic -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 p-4">
            <div>
                <h4 class="mb-1 fw-bold text-gray-900">
                    Manajemen Venue
                </h4>
                <div class="d-flex flex-wrap gap-2 small mb-1">
                    <span class="badge badge-light-info fw-semibold">
                        <i class="bi bi-geo-alt me-1"></i> Total: {{ $venues->count() }} Venue
                    </span>
                </div>
            </div>
            <div>
                <a href="{{ route('venues.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Venue
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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                            <th>Kepemilikan</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($venues as $venue)
                        <tr>
                            <td class="text-center text-gray-500 fs-8">{{ $loop->iteration }}</td>
                            <td class="fs-8">{{ $venue->name }}</td>
                            <td class="fs-8">{{ ucfirst($venue->ownership) }}</td>
                            <td class="fs-8">{{ $venue->address }}</td>
                            <td class="text-center">
                                <a href="{{ route('venues.edit', $venue->id) }}" class="btn btn-light-warning btn-sm rounded-pill px-3 me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('venues.destroy', $venue->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light-danger btn-sm rounded-pill px-3" onclick="return confirm('Yakin ingin menghapus venue ini?')">
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