<x-default-layout>
    <div class="container py-3">
        <!-- Header Card -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 p-4">
                <div>
                    <h5 class="mb-1 fw-bold text-gray-900">
                        {{ $course->name }}
                        <span class="badge badge-light-warning fw-semibold text-uppercase ms-2">
                            {{ ucfirst($course->type) }}
                        </span>
                    </h5>
                    <div class="d-flex flex-wrap gap-2 small mb-1">
                        
                        <span class="badge badge-light-secondary fw-semibold">
                            <i class="bi bi-geo-alt me-1"></i> {{ $course->venue->name ?? 'N/A' }}
                        </span>
                        <span class="badge badge-light-success fw-semibold">
                            <i class="bi bi-cash-stack me-1"></i> Rp {{ number_format($course->price) }}
                        </span>
                        <span class="badge {{ (isset($course->payment) && (strtolower($course->payment->status) === 'lunas' || strtolower($course->payment->status) === 'paid')) ? 'badge-light-success' : 'badge-light-danger' }} fw-semibold">
                            {{ $course->payment->status ?? 'unpaid' }}
                        </span>
                    </div>
                    @if($course->description)
                        <div class="text-muted fs-8 mt-1">{{ $course->description }}</div>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-light btn-active-light-primary" title="Kembali ke daftar kursus">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-light-primary" title="Edit kursus">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="row g-2 mb-4">
            <div class="col-6 col-md-3">
                <div class="card card-flush text-center border-0 shadow-sm h-100">
                    <div class="card-body py-3 px-2">
                        <div class="text-gray-500 fs-7 mb-1">Mulai</div>
                        <div class="fw-bold fs-6">{{ $course->start_date ? $course->start_date->translatedFormat('d M Y') : 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-flush text-center border-0 shadow-sm h-100">
                    <div class="card-body py-3 px-2">
                        <div class="text-gray-500 fs-7 mb-1">Selesai</div>
                        <div class="fw-bold fs-6">{{ $course->valid_until ? $course->valid_until->translatedFormat('d M Y') : 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-flush text-center border-0 shadow-sm h-100">
                    <div class="card-body py-3 px-2">
                        <div class="text-gray-500 fs-7 mb-1">Sesi</div>
                        <div class="fw-bold fs-6">
                            {{ $course->sessions->where('status', 'completed')->count() }} / {{ $course->max_sessions ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-flush text-center border-0 shadow-sm h-100">
                    <div class="card-body py-3 px-2">
                        <div class="text-gray-500 fs-7 mb-1">Pelatih</div>
                        <div class="d-flex justify-content-center flex-wrap gap-1">
                            @forelse ($course->trainers as $trainer)
                                <img 
                                    src="{{ optional($trainer->user)->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}"
                                    alt="Avatar" 
                                    class="symbol symbol-30px symbol-circle" 
                                    width="28" 
                                    height="28" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="{{ optional($trainer->user)->name ?? '-' }}">
                            @empty
                                <span class="text-muted fs-7">-</span>
                            @endforelse
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                                tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                                    new bootstrap.Tooltip(tooltipTriggerEl);
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-pills nav-pills-custom mb-3" id="courseTabs" role="tablist" style="background: #f5f8fa; border-radius: 0.2rem; overflow: hidden;">
            @php
                $activeTab = request()->get('tab', 'students');
                $tabList = [
                    'students' => ['icon' => 'bi-people', 'label' => 'Peserta'],
                    'sessions' => ['icon' => 'bi-calendar-check', 'label' => 'Sesi'],
                    'materials' => ['icon' => 'bi-journal-bookmark', 'label' => 'Materi'],
                ];
            @endphp
            @foreach($tabList as $tabKey => $tab)
                <li class="nav-item flex-fill text-center" role="presentation" style="min-width: 110px;">
                    <button
                        class="nav-link w-100 py-2 px-1 {{ $activeTab === $tabKey ? 'active' : '' }}"
                        id="{{ $tabKey }}-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#{{ $tabKey }}"
                        type="button"
                        role="tab"
                        aria-controls="{{ $tabKey }}"
                        aria-selected="{{ $activeTab === $tabKey ? 'true' : 'false' }}"
                        tabindex="{{ $activeTab === $tabKey ? '0' : '-1' }}"
                        style="font-size: 1rem; font-weight: 500; border: none; background: none;"
                    >
                        <i class="bi {{ $tab['icon'] }} me-1"></i> {{ $tab['label'] }}
                    </button>
                </li>
            @endforeach
        </ul>
        <style>
            .nav-pills-custom {
            background: #f5f8fa;
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid #e4e6ef;
            margin-bottom: 1rem;
            }
            .nav-pills-custom .nav-link {
            border-radius: 0;
            font-weight: 500;
            color: #5e6278;
            transition: background 0.2s, color 0.2s, border-bottom 0.2s;
            border: none;
            background: none;
            padding: 0.85rem 0.5rem;
            font-size: 1rem;
            position: relative;
            }
            .nav-pills-custom .nav-link.active,
            .nav-pills-custom .nav-link:focus,
            .nav-pills-custom .nav-link:hover {
            background: #fff !important;
            color: #009ef7 !important;
            border-bottom: 2.5px solid #009ef7;
            z-index: 2;
            }
            .nav-pills-custom .nav-link:not(.active):hover {
            background: #f1faff !important;
            color: #009ef7 !important;
            }
            .nav-pills-custom .nav-link i {
            font-size: 1.1em;
            vertical-align: middle;
            margin-right: 0.25em;
            }
            .nav-pills-custom .nav-link.active i {
            color: #009ef7;
            }
            .nav-pills-custom .nav-link:disabled {
            color: #b5b5c3 !important;
            background: none !important;
            cursor: not-allowed;
            }
            @media (max-width: 576px) {
            .nav-pills-custom .nav-link {
                font-size: 0.95rem;
                padding: .5rem .1rem;
            }
            }
        </style>
        
        <div class="tab-content" id="courseTabsContent">
            <!-- Siswa Tab -->
            <div class="tab-pane fade show active" id="students" role="tabpanel">
                <div class="card card-flush border-0 shadow-sm mb-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                                <thead>
                                    <tr class="text-center fw-semibold text-gray-600 fs-7">
                                        <th>#</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Kehadiran</th>
                                        <th>Nilai</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($course->students as $student)
                                        @php
                                            $attendanceCount = $student->sessions->where('course_id', $course->id)->count();
                                            $maxSessions = $course->max_sessions ?? 0;
                                            $materialIds = $course->materials->pluck('id');
                                            $totalScore = \DB::table('student_grades')
                                                ->where('student_id', $student->id)
                                                ->whereIn('material_id', $materialIds)
                                                ->avg('score');
                                            $averageScore = $totalScore ? number_format($totalScore, 1) : '-';
                                        @endphp
                                        <tr>
                                            <td class="text-center text-gray-500 fs-8">{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                <img src="{{ optional($student->user)->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}" alt="Avatar" class="symbol symbol-30px symbol-circle">
                                            </td>
                                            <td>
                                                <a href="{{ route('students.show', $student->id) }}" class="fw-semibold text-primary text-hover-dark fs-8 text-decoration-none">
                                                    {{ optional($student->user)->name ?? '-' }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-light-info fw-semibold">{{ $attendanceCount }}/{{ $maxSessions }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-light-success fw-semibold">{{ $averageScore }}</span>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-icon btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#gradeModal{{ $student->id }}">
                                                    <i class="</button></button>fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted fs-8">Belum ada siswa terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sesi Tab -->
            <div class="tab-pane fade" id="sessions" role="tabpanel">
                <div class="card card-flush border-0 shadow-sm mb-3">
                    <div class="card-body p-</div>0">
                        <div class="d-flex justify-content-between align-items-center mb-3 px-3 pt-3">
                            <span class="fw-semibold text-primary"><i class="bi bi-calendar-check"></i> Sesi</span>
                            <button 
                                class="btn btn-sm btn-light-primary" 
                                data-bs-toggle="{{ $course->sessions->count() >= $course->max_sessions ? '' : 'modal' }}" 
                                data-bs-target="{{ $course->sessions->count() >= $course->max_sessions ? '' : '#addScheduleModal' }}"
                                {{ $course->sessions->count() >= $course->max_sessions ? 'type=button' : '' }}
                                onclick="@if($course->sessions->count() >= $course->max_sessions) 
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Maksimal Sesi Tercapai',
                                        text: 'Kursus ini sudah mencapai jumlah sesi maksimal.'
                                    }); 
                                    @endif"
                                {{ $course->sessions->count() >= $course->max_sessions ? '' : '' }}
                            >
                                <i class="bi bi-plus-circle"></i> Tambah
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table id="sessionsTable" class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                                <thead>
                                    <tr class="text-center fw-semibold text-gray-600 fs-7">
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @php
                                    $filteredSessions = $course->sessions->whereIn('status', ['scheduled', 'completed','rescheduled','canceled']);
                                @endphp
                                <tbody>
                                    @forelse ($filteredSessions as $session)
                                        <tr>
                                            <td class="text-center text-gray-500 fs-8">{{ $loop->iteration }}</td>
                                            <td class="text-center fs-8">{{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }}</td>
                                            <td class="text-center fs-8">{{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}</td>
                                            <td class="text-center fs-8">{{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}</td>
                                            <td class="text-center">
                                                <span class="badge
                                                    @if($session->status === 'scheduled') badge-light-info
                                                    @elseif($session->status === 'rescheduled') badge-light-warning
                                                    @elseif($session->status === 'canceled') badge-light-danger
                                                    @else badge-light-success
                                                    @endif
                                                    fw-semibold">
                                                    {{ ucfirst($session->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end gap-1">
                                                    <button class="btn btn-icon btn-sm btn-light-success btnAttendance" data-session-id="{{ $session->id }}" title="Kehadiran">
                                                        <i class="fas fa-clipboard-check"></i>
                                                    </button>
                                                    @if($session->status === 'scheduled')
                                                        <button class="btn btn-icon btn-sm btn-light-warning btnEditSession" data-session-id="{{ $session->id }}" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-icon btn-sm btn-light-danger btnDeleteSession" data-session-id="{{ $session->id }}" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center text-muted fs-8">Belum ada sesi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>  
                        </div>
                    </div>
                </div>
            </div>
            <!-- Materi Tab -->
            <div class="tab-pane fade {{ $activeTab === 'materials' ? 'show active' : '' }}" id="materials" role="tabpanel" aria-labelledby="materials-tab">
                <div class="card card-flush border-0 shadow-sm mb-3">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-center mb-3 px-4 pt-3">
                            <span class="fw-semibold text-primary">
                                <i class="bi bi-journal-bookmark"></i> Materi
                            </span>
                        </div>
                        <div class="row g-0">
                            <!-- Kolom Kiri: Daftar Materi -->
                            <div class="col-md-7 border-end px-4 py-3">
                                
                                @if($course->materials->count() > 0)
                                    <ul>
                                        @foreach($course->materials as $material)
                                            <li class="list-group-item px-0 py-3"></li>
                                                <div class="fw-semibold mb-1">{{ $material->name }}</div>
                                                <div class="d-flex flex-wrap gap-2 mb-3" style="border-bottom: 1px dashed #e4e6ef; padding-bottom: 0.5rem;">
                                                    <span class="badge badge-light-info fw-semibold">
                                                        Estimasi Sesi: {{ $material->estimated_sessions ?? '-' }}
                                                    </span>
                                                    <span class="badge badge-light-warning fw-semibold">
                                                        Min. Skor: {{ $material->minimum_score ?? '-' }}
                                                    </span>
                                                    <span class="badge badge-light-primary fw-semibold">
                                                        Kategori: {{ $material->level ?? '-' }}
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-muted fs-8">Belum ada materi untuk kursus ini.</div>
                                @endif
                            </div>
                            <!-- Kolom Kanan: Catatan Basic Skills & Summary Materi -->
                            <div class="col-md-5 px-4 py-3">
                                <div class="mb-4">
                                    <div class="fw-semibold fs-8 text-gray-700 mb-2">
                                        <i class="bi bi-lightbulb text-warning me-1"></i> Catatan Basic Skills (Acuan Pelatih):
                                    </div>
                                    @if(!empty($course->basic_skills))
                                        <ul class="mb-3 ps-3 fs-8" style="list-style: disc;">
                                            @foreach(is_array($course->basic_skills) ? $course->basic_skills : explode(',', $course->basic_skills) as $skill)
                                                <li class="mb-1 text-gray-800">{{ trim($skill) }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-muted fs-8 mb-3 fst-italic">Tidak ada catatan.</div>
                                    @endif
                                </div>

                                <div>
                                    <div class="fw-semibold fs-8 text-gray-700 mb-2 mt-2">
                                        <i class="bi bi-graph-up-arrow text-primary me-1"></i> Summary Materi:
                                    </div>
                                    @php
                                        $totalEstimatedSessions = $course->materials->sum('estimated_sessions');
                                        $averageMinScore = $course->materials->count() > 0
                                            ? number_format($course->materials->avg('minimum_score'), 1)
                                            : '-';
                                    @endphp
                                    <ul class="mb-0 ps-3 fs-8" style="list-style: circle;">
                                        <li class="mb-1">
                                            <span class="text-gray-600">Total Estimasi Sesi:</span>
                                            <span class="fw-bold text-primary">{{ $totalEstimatedSessions ?: '-' }}</span>
                                        </li>
                                        <li>
                                            <span class="text-gray-600">Rata-rata Minimum Skor:</span>
                                            <span class="fw-bold text-success">{{ $averageMinScore }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals Section -->
        @foreach ($course->sessions as $session)
            @include('courses.partials.attendance-modal', ['session' => $session, 'course' => $course])
            @if($session->status === 'scheduled')
                @include('courses.partials.edit-schedule-modal', ['session' => $session, 'course' => $course])
            @endif
        @endforeach
        @foreach ($course->students as $student)
            @include('courses.partials.score-student-modal', ['student' => $student, 'course' => $course])
        @endforeach
        @include('courses.partials.add-schedule-modal', ['course' => $course])
    </div>
    <style>
        @media (max-width: 576px) {
            .card-body, .card-header { padding: 1rem !important; }
            .table { font-size: 0.92rem; }
            .nav-pills .nav-link { font-size: 0.95rem; padding: .5rem .25rem; }
            .symbol-30px { width: 28px !important; height: 28px !important; }
        }
        .symbol-30px { width: 30px; height: 30px; }
        .fs-7 { font-size: 0.95rem !important; }
        .fs-8 { font-size: 0.88rem !important; }
        .nav-pills-custom .nav-link.active {
            background: #f5f8fa;
            color: #009ef7;
            border-bottom: 2px solid #009ef7;
        }
        .nav-pills-custom .nav-link {
            border-radius: 0;
            font-weight: 500;
        }
    </style>
    
</x-default-layout>
