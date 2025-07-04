<x-default-layout>
    <div class="container mt-0">
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
                        <span class="badge {{ $isPaid ? 'badge-light-success' : 'badge-light-danger' }} fw-semibold">
                            {{ $paymentStatus }}
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
                        <div class="fw-bold fs-6">{{ $startDate }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-flush text-center border-0 shadow-sm h-100">
                    <div class="card-body py-3 px-2">
                        <div class="text-gray-500 fs-7 mb-1">Selesai</div>
                        <div class="fw-bold fs-6">{{ $endDate }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-flush text-center border-0 shadow-sm h-100">
                    <div class="card-body py-3 px-2">
                        <div class="text-gray-500 fs-7 mb-1">Sesi</div>
                        <div class="fw-bold fs-6">
                            {{ $sessionsCompleted }} / {{ $maxSessions }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-flush text-center border-0 shadow-sm h-100">
                    <div class="card-body py-3 px-2">
                        <div class="text-gray-500 fs-7 mb-1">Pelatih</div>
                        <div class="d-flex justify-content-center flex-wrap gap-1">
                            @forelse ($trainers as $trainer)
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
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-pills nav-pills-custom mb-3" id="courseTabs" role="tablist" style="background: #f5f8fa; border-radius: 0.2rem; overflow: hidden;">
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
                @include('courses.partials.show-students', compact('students', 'course'))
            </div>
            <!-- Sesi Tab -->
            <div class="tab-pane fade" id="sessions" role="tabpanel">
                @include('courses.partials.show-sessions', compact('sessions', 'course'))
            </div>
            <!-- Materi Tab -->
            <div class="tab-pane fade" id="materials" role="tabpanel">
                @include('courses.partials.show-materials', compact('materials', 'basicSkills', 'totalEstimatedSessions', 'averageMinScore', 'course'))
            </div>
        </div>

        <!-- Modals Section -->
        @foreach ($sessions as $session)
            @include('courses.partials.attendance-modal', ['session' => $session, 'course' => $course])
            @if($session->status === 'scheduled')
                @include('courses.partials.edit-schedule-modal', ['session' => $session, 'course' => $course])
            @endif
        @endforeach
        @foreach ($students as $student)
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

@push('scripts')
    
    <script src="{{ asset('assets/js/courses-show.js') }}"></script>
@endpush
</x-default-layout>