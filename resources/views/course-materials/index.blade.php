<x-default-layout>
<div class="container mt-0">
    <!-- Header Card ala Metronic -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 p-4">
            <div>
                <h4 class="mb-1 fw-bold text-gray-900">
                    Daftar Materi Kursus
                </h4>
                <div class="d-flex flex-wrap gap-2 small mb-1">
                    <span class="badge badge-light-info fw-semibold">
                        <i class="bi bi-journal-bookmark me-1"></i> Total: {{ $materials->count() }} Materi
                    </span>
                </div>
            </div>
            <div>
                <a href="{{ route('course-materials.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Materi
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
                            <th>Level</th>
                            <th>Nama Materi</th>
                            <th>Estimasi Sesi</th>
                            <th>Nilai Minimum</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materials as $material)
                            <tr>
                                <td class="text-center text-gray-500 fs-8">{{ $loop->iteration }}</td>
                                <td class="text-center fs-8">{{ $material->level }}</td>
                                <td class="fs-8">{{ $material->name }}</td>
                                <td class="text-center fs-8">{{ $material->estimated_sessions }}</td>
                                <td class="text-center fs-8">{{ $material->minimum_score }}</td>
                                <td class="text-center">
                                    <a href="{{ route('course-materials.edit', $material->id) }}" class="btn btn-light-warning btn-sm rounded-pill px-3 me-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-light-danger btn-sm rounded-pill px-3 btnDeleteMaterial" data-id="{{ $material->id }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada materi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus materi ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Hapus</button>
            </div>
        </div>
    </div>
</div>


<meta name="csrf-token" content="{{ csrf_token() }}">

@push('styles')
<style>
    .fs-8 { font-size: 0.88rem !important; }
    .rounded-pill { border-radius: 2rem !important; }
    .btn-light-warning { background: #fff8dd; color: #ffc700; border: none; }
    .btn-light-warning:hover { background: #ffe082; color: #7a5700; }
    .btn-light-danger { background: #fff5f8; color: #f1416c; border: none; }
    .btn-light-danger:hover { background: #ffe5ea; color: #a8072c; }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/course-materials-index.js') }}"></script>
@endpush
</x-default-layout>