<x-default-layout>
<div class="container py-3">
    <!-- Header Card -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 p-4">
            <div>
                <h4 class="mb-1 fw-bold text-gray-900">
                    Manajemen Murid
                </h4>
                <div class="d-flex flex-wrap gap-2 small mb-1">
                    <span class="badge badge-light-info fw-semibold">
                        <i class="bi bi-people me-1"></i> Total: {{ $students->count() }} Murid
                    </span>
                </div>
            </div>
            <div>
                <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Murid
                </a>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="row g-2 mb-4">
        <div class="col-12 col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Cari murid...">
            </div>
        </div>
        <div class="col-8 col-md-4">
            <select id="filter-age-group" class="form-select form-select-sm">
                <option value="">Semua Kelompok Usia</option>
                @foreach ($students->pluck('age_group')->unique() as $ageGroup)
                    <option value="{{ $ageGroup }}">{{ ucfirst($ageGroup) }}</option>
                @endforeach
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
                <div class="table-responsive text-center">
                    <table id="students_table" class="table table-row-dashed table-row-gray-200 gy-2 mb-0 align-middle">
                        <thead>
                            <tr class="fw-bold text-gray-700 fs-7 text-center align-middle">
                                <th class="text-center align-middle" style="width: 180px;">Profile</th>
                                <th class="text-center align-middle" style="width: 140px;">Tanggal Lahir</th>
                                <th class="text-center align-middle" style="width: 120px;">Kelompok Usia</th>
                                <th class="text-center align-middle" style="width: 80px;">Kursus</th>
                                <th class="text-center align-middle" style="width: 80px;">Sesi</th>
                                <th class="text-center align-middle" style="width: 110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr>
                                <!-- Profile Picture & Nama -->
                                <td class="text-start align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}" alt="Avatar" class="symbol symbol-30px symbol-circle">
                                        <div>
                                            <div class="fw-semibold text-gray-800">{{ $student->user->name }}</div>
                                            <div class="text-gray-500 fs-8">{{ $student->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <!-- Tanggal Lahir & Usia -->
                                <td class="text-center align-middle">
                                    <div class="fw-semibold text-gray-800 fs-8">{{ \Carbon\Carbon::parse($student->user->birth_date)->translatedFormat('d F Y') }}</div>
                                    <div class="text-gray-500 fs-8">{{ \Carbon\Carbon::parse($student->user->birth_date)->age }} tahun</div>
                                </td>
                                <!-- Kelompok Usia -->
                                <td class="text-center align-middle">
                                    <span class="badge badge-light-info fw-semibold">{{ ucfirst($student->age_group) }}</span>
                                </td>
                                <!-- Kursus -->
                                <td class="text-center align-middle">
                                    <span class="badge badge-light-success fw-semibold">{{ $student->courses_count }}</span>
                                </td>
                                <!-- Sesi -->
                                <td class="text-center align-middle">
                                    <span class="badge badge-light-primary fw-semibold">{{ $student->sessions_count }}</span>
                                </td>
                                <!-- Aksi -->
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-icon btn-sm btn-light-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-sm btn-light-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus murid ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Compact Footer -->
                <div id="students_table_footer" class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2 px-2 py-1 small">
                    <div id="students_table_info" class="text-gray-600"></div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0">Tampil
                            <select id="students_table_length" class="form-select form-select-sm d-inline-block w-auto mx-1" style="min-width: 50px;">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            data
                        </label>
                        <div id="students_table_paginate"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-default-layout>
<style>
    .symbol-30px { width: 30px; height: 30px; }
    .fs-8 { font-size: 0.88rem !important; }
    #students_table th, #students_table td { vertical-align: middle !important; }
    #students_table th { text-align: center !important; }
    #students_table td { padding-top: 0.65rem !important; padding-bottom: 0.65rem !important; }
    #students_table_footer select { min-width: 50px; }
    #students_table_footer { font-size: 0.93rem; }
    @media (max-width: 576px) {
        .card-body, .card-header { padding: 1rem !important; }
        .table { font-size: 0.92rem; }
        .symbol-30px { width: 28px !important; height: 28px !important; }
        #students_table_footer { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
    }
</style>
@push('scripts')
    <script src="{{ asset('assets/js/students-index.js') }}"></script>
@endpush
