<x-default-layout>
<div class="container py-3">
    <!-- Header Card -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center p-4">
            <a href="{{ route('students.index') }}" class="btn btn-sm btn-light btn-active-light-primary" title="Kembali ke daftar murid">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editStudentModal">
                <i class="bi bi-pencil"></i> Edit Profil
            </button>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="row g-3 mb-4">
        <!-- Kolom Kiri: Foto & Nama -->
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card h-100 text-center">
                <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                    <img src="{{ $student->user->profile_photo_path ? asset('storage/' . $student->user->profile_photo_path) : asset('assets/media/avatars/default-avatar.png') }}"
                         alt="Avatar" class="symbol symbol-80px symbol-circle border mb-3" width="80" height="80">
                    <h5 class="fw-bold mb-1">{{ $student->user->name }}</h5>
                    <div class="mt-2">
                        <span class="text-muted small">Terdaftar Sejak</span>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($student->user->created_at)->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kolom Tengah: Informasi Pribadi -->
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card h-100">
                <div class="card-body py-4 px-4">
                    <div class="mb-2">
                        <span class="text-muted small">Email</span>
                        <div class="fw-semibold">{{ $student->user->email }}</div>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">No. HP</span>
                        <div class="fw-semibold d-flex align-items-center gap-2">
                            {{ $student->user->phone_number ?? '-' }}
                            @if(!empty($student->user->phone_number))
                                @php
                                    $waNumber = preg_replace('/[^0-9]/', '', $student->user->phone_number);
                                    if (substr($waNumber, 0, 1) === '0') {
                                        $waNumber = '62' . substr($waNumber, 1);
                                    }
                                @endphp
                                <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="btn btn-sm btn-icon btn-success" title="Chat WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">Tanggal Lahir</span>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($student->user->birth_date)->format('d M Y') }}</div>
                    </div>
                    <div>
                        <span class="text-muted small">Usia</span>
                        <div class="fw-semibold">
                            {{ $student->age }} Tahun
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Kolom Kanan: Informasi Kursus -->
        <div class="col-12 col-lg-4">
            <div class="card h-100">
                <div class="card-body py-4 px-4">
                    <div class="mb-2">
                        <span class="text-muted small">Total Kursus</span>
                        <div class="fw-bold">{{ $student->courses_count }}</div>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">Total Sesi</span>
                        <div class="fw-bold">{{ $student->sessions_count }}</div>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">Nilai Kumulatif</span>
                        <div class="fw-bold">{{ $student->cumulative_score !== null ? number_format($student->cumulative_score, 2) : '-' }}</div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">Total Materi</span>
                            <div class="fw-bold">{{ $student->gradeScores()->distinct('material_id')->count('material_id') }}</div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Tabs -->
    <ul class="nav nav-pills nav-pills-custom mb-3" id="studentTabs" role="tablist">
        <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link w-100 py-2 px-1 small active"
                id="courses-tab"
                data-bs-toggle="pill"
                data-bs-target="#courses"
                type="button"
                role="tab"
                aria-controls="courses"
                aria-selected="true">
                <i class="bi bi-journal-bookmark me-1"></i> Kursus
            </button>
        </li>
        <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link w-100 py-2 px-1 small"
                id="materials-tab"
                data-bs-toggle="pill"
                data-bs-target="#material-grades"
                type="button"
                role="tab"
                aria-controls="material-grades"
                aria-selected="false">
                <i class="bi bi-book me-1"></i> Materi & Nilai
            </button>
        </li>
        <li class="nav-item flex-fill text-center" role="presentation">
            <button class="nav-link w-100 py-2 px-1 small"
                id="analytics-tab"
                data-bs-toggle="pill"
                data-bs-target="#analytics"
                type="button"
                role="tab"
                aria-controls="analytics"
                aria-selected="false">
                <i class="bi bi-bar-chart-line me-1"></i> Analitik
            </button>
        </li>
    </ul>

    <div class="tab-content" id="studentTabsContent">
        <div class="tab-pane fade show active" id="courses" role="tabpanel" aria-labelledby="courses-tab">
            @include('students.partials.courses', ['student' => $student])
        </div>
        <div class="tab-pane fade" id="material-grades" role="tabpanel" aria-labelledby="materials-tab">
            @include('students.partials.material-grades', ['student' => $student])
        </div>
        <div class="tab-pane fade" id="analytics" role="tabpanel" aria-labelledby="analytics-tab">
            @include('students.partials.analytics', ['student' => $student])
        </div>
    </div>
</div>
@include('students.partials.modal-edit-profile', ['student' => $student])
</x-default-layout>