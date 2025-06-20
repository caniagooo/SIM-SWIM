{{--
    Logic Section
    -------------
    Semua perhitungan dan logic diletakkan di bagian atas file agar blade tetap bersih.
    - Status pembayaran & status kursus
    - Progress bar
    - Avatar murid
--}}

@php
    // Data pembayaran kursus
    $payment = $course->payment;

    // Jumlah sesi selesai
    $sessionsCompleted = $course->sessions->where('status', 'completed')->count();

    // Status kursus
    $now = now();
    $isExpired = $now->greaterThan($course->valid_until);
    $maxSessionReached = $course->max_sessions ? ($sessionsCompleted >= $course->max_sessions) : false;

    $isActive = false;
    $statusText = '';
    $statusClass = '';
    if ($payment && $payment->status === 'paid' && !$isExpired && !$maxSessionReached) {
        $isActive = true;
        $statusText = 'Aktif';
        $statusClass = 'badge-light-success';
    } elseif ($isExpired || $maxSessionReached) {
        $statusText = 'Expired';
        $statusClass = 'badge-light-danger';
    } else {
        $statusText = 'Unpaid';
        $statusClass = 'badge-light-warning';
    }

    // Progress bar logic
    $start = $course->start_date;
    $end = $course->valid_until;
    $totalDays = $start->diffInDays($end) ?: 1;
    $elapsedDays = $start->lte($now) ? $start->diffInDays(min($now, $end)) : 0;
    $progress = min(100, max(0, round(($elapsedDays / $totalDays) * 100)));

    // Progress bar color
    if ($now->gt($end)) {
        $progressBg = 'background-color: rgba(255,76,81,0.15);';
        $progressBarBg = 'background: #F1416C; color: #fff;';
    } elseif ($progress >= 1) {
        $progressBg = 'background-color: rgba(80,205,137,0.15);';
        $progressBarBg = 'background: #50CD89; color: #fff;';
    } else {
        $progressBg = 'background-color: rgba(0,158,247,0.15);';
        $progressBarBg = 'background: #009EF7; color: #fff;';
    }

    // Avatar murid (maksimal 3)
    $maxAvatars = 3;
    $students = $course->students->take($maxAvatars);
    $studentNames = $course->students->pluck('user.name')->implode(', ');
    $isGroup = $course->type === 'group';
@endphp

<div class="col-xl-4 col-md-6 mb-6">
    <div class="card card-flush shadow-sm h-100 rounded-4 overflow-hidden d-flex flex-column">
        <!-- Card Header -->
        <div class="card-header bg-white py-4 px-0 position-relative rounded-0 w-100 border-bottom">
            <div class="d-flex flex-wrap align-items-center justify-content-between w-100 px-6">
                <div class="d-flex flex-column flex-grow-1 w-100">
                    <div class="d-flex align-items-center justify-content-between mb-1 w-100">
                        <span class="fw-bold fs-6 text-dark text-truncate" title="{{ $course->name ?? '-' }}">
                            {{ $course->name ?? '-' }}
                        </span>
                        @if($statusText === 'Unpaid')
                            <button type="button"
                                class="btn btn-light-warning btn-sm fw-bold px-4 py-2 btnPayNow"
                                style="font-size: 0.85rem; line-height: 1; padding: 0.25rem 0.75rem; border-radius: 0.475rem; height: 25px; min-width: 70px;"
                                data-course-id="{{ $course->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#paymentModal">
                                <i class="bi bi-cash-coin me-2"></i> Pay Now
                            </button>
                        @else
                            <span class="badge {{ $statusClass }} fs-8 fw-semibold px-4 py-2"
                                style="font-size: 0.85rem; line-height: 1; border-radius: 0.475rem; height: 25px; min-width: 70px; display: inline-flex; align-items: center; justify-content: center;">
                                {{ $statusText }}
                            </span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center flex-wrap gap-2 text-gray-600 fs-8 w-100 justify-content-between">
                        <span class="d-flex align-items-center" title="Lokasi">
                            <i class="bi bi-geo-alt-fill me-1 text-primary"></i>
                            <span class="fw-semibold">{{ $course->venue->name ?? '-' }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Progress Bar -->
        <div class="card-separator bg-white">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <div class="flex-grow-1 mx-0" style="min-width: 0;">
                        <div class="position-relative" style="height: 25px;">
                            <div class="progress" style="{{ $progressBg }} height: 100%; border-radius: 0;">
                                <div class="progress-bar" 
                                    role="progressbar"
                                    style="width: {{ $progress }}%; {{ $progressBarBg }}; border-radius: 0;"
                                    aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body py-4 px-6">
            <div class="d-flex flex-column gap-3">
                <!-- Murid -->
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-semibold text-gray-700">
                        <i class="bi bi-people me-1"></i> Murid
                    </span>
                    <span class="ms-2 text-end d-flex align-items-center flex-wrap">
                        @if($course->students->count() > 0)
                            @if($isGroup)
                                <div class="d-flex align-items-center" style="margin-right: 8px;">
                                    @foreach($students as $i => $student)
                                        <img 
                                            src="{{ $student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}" 
                                            alt="{{ $student->user->name }}" 
                                            class="rounded-circle border border-2 border-white"
                                            style="width: 32px; height: 32px; object-fit: cover; background: #f1f1f1; margin-left: {{ $i === 0 ? '0' : '-12px' }};"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="{{ $student->user->name }}"
                                        >
                                    @endforeach
                                    @if($course->students->count() > $maxAvatars)
                                        <span class="rounded-circle bg-light d-flex align-items-center justify-content-center border border-2 border-white"
                                            style="width: 32px; height: 32px; margin-left: -12px; font-size: 0.95rem;">
                                            +{{ $course->students->count() - $maxAvatars }}
                                        </span>
                                    @endif
                                </div>
                                <span 
                                    class="badge badge-light-info ms-2"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="{{ $studentNames }}"
                                >
                                    {{ $course->students->count() }} murid
                                </span>
                            @else
                                @foreach($students as $student)
                                    <img 
                                        src="{{ $student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}" 
                                        alt="{{ $student->user->name }}" 
                                        class="rounded-circle border border-2 border-white shadow"
                                        style="width: 32px; height: 32px; object-fit: cover; background: #f1f1f1; margin-right: 6px;"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="{{ $student->user->name }}"
                                    >
                                @endforeach
                                @if($course->students->count() > $maxAvatars)
                                    <span class="rounded-circle bg-light d-flex align-items-center justify-content-center border border-2 border-white shadow"
                                        style="width: 32px; height: 32px; font-size: 0.95rem;">
                                        +{{ $course->students->count() - $maxAvatars }}
                                    </span>
                                @endif
                                @if($course->type === 'private' && $course->students->count() === 1)
                                    <span class="badge badge-light-primary ms-2">{{ $course->students->first()->user->name }}</span>
                                @endif
                            @endif
                        @else
                            <span class="text-muted" style="font-size: 1rem;">-</span>
                        @endif
                    </span>
                </div>
                <!-- Pelatih -->
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-semibold text-gray-700"><i class="bi bi-person-badge me-1"></i> Pelatih</span>
                    <span class="ms-2 text-end">
                        <span id="trainersList-{{ $course->id }}">
                            @if($course->trainers->count())
                                @foreach($course->trainers as $trainer)
                                    <span class="d-inline-flex align-items-center mb-1 me-1">
                                        <img src="{{ $trainer->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}" alt="{{ $trainer->user->name }}" class="rounded-circle border border-2 border-white shadow" style="width: 32px; height: 32px; object-fit: cover; background: #f1f1f1; margin-right: 6px;">
                                        <span class="badge badge-light-success">{{ $trainer->user->name }}</span>
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted"></span>
                                <button type="button" class="btn btn-sm btn-light-warning ms-2" data-bs-toggle="modal" data-bs-target="#assignTrainerModal-{{ $course->id }}">
                                    <i class="bi bi-person-plus"></i> Pilih Pelatih
                                </button>
                            @endif
                        </span>
                    </span>
                </div>
                <!-- Materi -->
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-semibold text-gray-700">
                        <i class="bi bi-journal-text me-1"></i> Materi
                    </span>
                    <span class="ms-2 text-end">
                        <button
                            type="button"
                            class="btn btn-sm {{ $course->materials->isEmpty() ? 'btn-light-warning' : 'btn-light-success' }} ms-2"
                            id="assignMaterialsBtn-{{ $course->id }}"
                            data-bs-toggle="modal"
                            data-bs-target="#assignMaterialsModal-{{ $course->id }}">
                            <i class="bi bi-journal-text"></i>
                            {{ $course->materials->isEmpty() ? 'Assign Materi' : $course->materials->count() . ' Materi' }}
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <!-- Card Footer -->
        <div class="bg-white px-0">
            <div class="d-flex align-items-center justify-content-between px-6 py-0">
                <span class="d-flex align-items-center text-gray-600 fs-8" title="durasi kursus">
                    <i class="bi bi-clock-fill me-1 text-primary"></i>
                    <span class="fw-semibold">{{ $course->start_date->format('d M Y') }} - {{ $course->valid_until->format('d M Y') }}</span>
                </span>                 
                <span class="fs-8 fw-normal text-gray-700 px-2 py-1  d-flex align-items-center" title="Jumlah sesi selesai">
                    <i class="bi bi-calendar-check me-1 text-success"></i>
                    {{ $sessionsCompleted }}/{{ $course->max_sessions }} sesi
                </span>         
            </div>
        </div>
        <!-- card lower footer -->
        <div class="border-top px-0">
            <div class="d-flex align-items-stretch gap-0">
                <!-- Jadwal Sesi Button (left) -->
                <button 
                    type="button"
                    class="btn btn-light-info btn-lg flex-grow-1 rounded-0 rounded-start d-flex align-items-center justify-content-center border-end"
                    style="font-size:1.05rem; font-weight:600; border-top: none; border-bottom: none;"
                    data-bs-toggle="modal"
                    data-bs-target="#sessionsModal-{{ $course->id }}"
                >
                    <i class="bi bi-calendar-event me-2"></i>
                    Jadwal Sesi
                </button>
                <!-- Vertical Divider -->
                <div style="width:1px; background:#e5e9f2;"></div>
                <!-- Detail Kursus Button (right) -->
                <a href="{{ route('courses.show', $course->id) }}"
                    class="btn btn-light-primary btn-lg flex-grow-1 rounded-0 rounded-end d-flex align-items-center justify-content-center"
                    style="font-size:1.05rem; font-weight:600; border-top: none; border-bottom: none;">
                    <span class="bi bi-eye me-2"></span> Lihat Detail
                </a>
            </div>
        </div>
    </div>
</div>